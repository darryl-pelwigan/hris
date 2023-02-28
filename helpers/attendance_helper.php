<?php
include "../includes/db_hr.php";

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Grading System  Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/form_helper.html
 */


// ------------------------------------------------------------------------
if ( ! function_exists('get_attendance'))
{
	function get_attendance($sdwEnrollNumber, $datetime, $sem, $sy){

	    ## get staff attendance,
        ## am in, pm in, am out, pm out
        $biono = $sdwEnrollNumber;
        $date = date('Y-m-d', strtotime($datetime));
        $day = date('N', strtotime($datetime));

        $instat = 0;
        $outstat = 1;
        $timeAM = 'AM';
        $timePM = 'PM';  


        ##QUERY STAFF SCHED TIME IN FOR  AM/PM TO GET LATES
        $schedtimeAM  = schedTime($biono, $day, 'AM', $sem, $sy);
        // $schedtimePM  = schedTime($biono, $day, 'PM', $sem, $sy);
        $am_sched_in = $schedtimeAM['timein_am'];
        $am_sched_out = $schedtimeAM['timeout_am'];
        $pm_sched_in = $schedtimeAM['timein_pm'];
        $pm_sched_out = $schedtimeAM['timeout_pm'];  

        // #CALCULATE AM TARDINESS
        $staff_time_amin = getTimeInOut($biono, $date, $day, $instat, $timeAM, $sem, $sy);
        $sched_time_amin = $date.' '.$am_sched_in;
        $am_tardiness = getTimeDifference($sched_time_amin, $staff_time_amin);
        $am_tardiness_format = getTime($am_tardiness);

        #CALCULATE PM TARDINESS
        $staff_time_pmin = getTimeInOut($biono, $date, $day, $instat, $timePM, $sem, $sy);
        $sched_time_pmin = $date.' '.$pm_sched_in;
        $pm_tardiness = getTimeDifference($sched_time_pmin, $staff_time_pmin);
        $pm_tardiness_format = getTime($pm_tardiness);

        #CALCULATE AM UNDERTIME
        $staff_time_amout = getTimeInOut($biono, $date, $day, $outstat, $timeAM, $sem, $sy);
        $sched_time_amout = $date.' '.$am_sched_out;
        $am_undertime = getTimeDifference($staff_time_amout, $sched_time_amout);
        $am_undertime_format = getTime($am_undertime);

        ##CALCULATE PM UNDERTIME
        $staff_time_pmout = getTimeInOut($biono, $date, $day, $outstat, $timePM, $sem, $sy);
        $sched_time_pmout = $date.' '.$pm_sched_out;
        $pm_undertime = getTimeDifference($staff_time_pmout, $sched_time_pmout);
        $pm_undertime_format = getTime($pm_undertime);


        ##OVERTIME
        $staff_ot = getTimeDifference($sched_time_pmout, $staff_time_pmout);
        $staff_ot_format = getTime($staff_ot);

        $minutes_tardiness = ($am_tardiness > 0 ? $am_tardiness : 0) + ($pm_tardiness > 0 ? $pm_tardiness : 0);
        $minutes_undertime = ($am_undertime > 0 ? $am_undertime : 0) + ($pm_undertime > 0 ? $pm_undertime : 0);
        $minutes_ot = ($staff_ot > 0 ? $staff_ot : 0);

        $total_tardy = getTime($minutes_tardiness);
        $total_undertime = getTime($minutes_undertime);
        $total_overtime = getTime($minutes_ot);

        #TOTAL STAFF SCHED TOTAL HOURS
        $staff_regular_hours = getRegularHours($biono, $day, $sem, $sy);
        $totalhoursrendered = ($staff_regular_hours - $minutes_tardiness - $minutes_undertime) + $minutes_ot;
        $total_regular = getTime($totalhoursrendered);


        $data=[];
        $data = 
            array
            (
                'totaltardy' => $total_tardy,
                'totalundertime' => $total_undertime,
                'totalovertime' => $total_overtime,
                'totalhours' => $total_regular,
            );

        return $data;


	}

	function empClassification($sdwEnrollNumber){
        global $dbh;
        $q = $dbh->prepare("SELECT teaching FROM pcc_staff WHERE biometricsid = ?");
        $q->execute([$sdwEnrollNumber]);
        $r = $q->fetch(PDO::FETCH_NUM);
        return $r[0];
    }

    function getTimeInOut($biono, $date, $day, $status, $time, $sem, $sy){
        global $dbh;

        ##get staff schedule - for reference
        $schedtimeAM  = schedTime($biono, $day, 'AM', $sem, $sy);
        // $schedtimePM  = schedTime($biono, $day, 'PM', $sem, $sy);


        // $amin      = !empty($schedtimeAM['timeinhr']) ? $schedtimeAM['timeinhr'] : 0;
        // $amout     = !empty($schedtimeAM['timeouthr']) ? $schedtimeAM['timeouthr'] : 0;
        // $pmin      = !empty($schedtimePM['timeinhr']) ? $schedtimePM['timeinhr'] : 0;
        // $pmout     = !empty($schedtimePM['timeouthr']) ? $schedtimePM['timeouthr'] : 0;

        $amin      = !empty($schedtimeAM['timein_am']) ? $schedtimeAM['timein_am'] : 0;
        $amout     = !empty($schedtimeAM['timeout_am']) ? $schedtimeAM['timeout_am'] : 0;
        $pmin      = !empty($schedtimePM['timein_pm']) ? $schedtimePM['timein_pm'] : 0;
        $pmout     = !empty($schedtimePM['timeout_pm']) ? $schedtimePM['timeout_pm'] : 0;


        if($time == 'AM'){
            if($status == 0){
                $wherevals = "ORDER BY `datetime` ASC LIMIT 1";
            }else{
                $wherevals = "AND date_format(`datetime`, '%H') < '.$pmin.' ORDER BY `datetime` ASC LIMIT 1";
            }
        }else{
            if($status == 0){
                $wherevals = "AND date_format(`datetime`, '%H') >= '.$amout.' ORDER BY `datetime` ASC LIMIT 1";
            }else{
                $wherevals = "AND date_format(`datetime`, '%H') > '.$pmin.' ORDER BY `datetime` DESC LIMIT 1";
            }
        }
        // $wherevals = 'ORDER BY `datetime` ASC LIMIT 1';

        $datetime = '';
        $query = $dbh->prepare("SELECT `datetime`, status 
                        FROM biometrics_tbl 
                        WHERE badgenumber = ? 
                        AND date_format(`datetime`, '%Y-%m-%d') = ? 
                        AND status= ? 
                        $wherevals");

        $query->execute([$biono, $date, $status]);
        
        if($query->rowCount() > 0){
            $r = $query->fetch(PDO::FETCH_OBJ);
            $datetime = $r->datetime;
        }

        return $datetime;
    }

    function schedTime($biono, $day, $status, $sem, $sy)
    {
        global $dbh;
        // xxxx
        $teaching = empClassification($biono);

        if($teaching == 1){

            $q = $dbh->prepare("(SELECT s.days as days, s.start as timein, s.end as timeout
                            FROM pcc_schedulelist s 
                            INNER JOIN pcc_teachersched ts on ts.subjid=s.schedid
                            WHERE ts.teacherid=?  
                            AND s.semester = ?
                            AND s.schoolyear = ?)
                            UNION
                            (SELECT days, timein, timeout
                            FROM pcc_staff_scheduling 
                            WHERE biono = ?)
                            ORDER BY timein ASC
                            ");

            $totalhours =  0;
            $q->execute([$biono, $sem, $sy, $biono]);
            if($q->rowCount()>0){
                $data = array();
                $row = $q->fetchAll();
                $schedules = array();
                $scheds = array();

                #GET SCHEDULES
                for ($a=0; $a < count($row); $a++) { 
                    $scheddays = explode(',', $row[$a]['days']);
                    $dayval = array();
                    array_push($data, $row);
                    foreach($scheddays as $days){
                        if($days == 'M'){
                            array_push($dayval, 1);
                        }else if($days == 'T'){
                            array_push($dayval, 2);
                        }else if($days == 'W'){
                            array_push($dayval, 3);
                        }else if($days == 'Th'){
                            array_push($dayval, 4);
                        }else if($days == 'F'){
                            array_push($dayval, 5);
                        }else if($days == 'S'){
                            array_push($dayval, 6);
                        }
                        array_push($dayval, $days);
                    }

                    if(in_array($day, $dayval) == true){
                        array_push($schedules, array('timein'=>$row[$a]['timein'], 'timeout'=>$row[$a]['timeout']));
                        $totalhours += getTimeDifference($row[$a]['timein'], $row[$a]['timeout']);
                    }
                }
         
	            $all_am_timeins = [];
	            $all_am_timeouts = [];
	            $all_pm_timeins = [];
	            $all_pm_timeouts = [];


	            foreach($schedules as $s){
	                // all AM
	                if($s['timein'] < '13:00:00'){
	                    array_push($all_am_timeins, $s['timein']);
	                    array_push($all_am_timeouts, $s['timeout']);
	                }
	                // all PM
	                if($s['timein'] > '12:00:00'){
	                    array_push($all_pm_timeins, $s['timein']);
	                    array_push($all_pm_timeouts, $s['timeout']);
	                }

	            }
	            if($status == 'AM'){
	                $key = count($all_am_timeouts) - 1;
	                $key = $key < 1 ? 1 : $key;
	                $timeinhr =  date('H', strtotime('2018-01-01 '.$all_am_timeins[0]));
	                $timeouthr = date('H', strtotime('2018-01-01 '.$all_am_timeouts[$key]));
	                $timein   =  $all_am_timeins[0];
	                $timeout  =  $all_am_timeouts[$key];

	            }else{
	                $key = count($all_pm_timeouts) - 1;
	                $key = $key < 1 ? 1 : $key;
	                $timeinhr = date('H', strtotime('2018-01-01 '.$all_pm_timeins[0]));
	                $timeouthr = date('H', strtotime('2018-01-01 '.$all_pm_timeouts[$key]));
	                $timein   =  $all_pm_timeins[0];
	                $timeout =  $all_pm_timeouts[$key];
	            }

	             return  array(
	                        'timeinhr' => $timeinhr,
	                        'timeouthr' => $timeouthr,
	                        'timein' => $timein,
	                        'timeout' => $timeout,
	                        'totalhours' => $totalhours
	                    );  
        	}

        }else{


            $query = $dbh->prepare("SELECT days, id FROM pcc_staff_scheduling WHERE biono=?");
            $query->execute([$biono]);
            $timein_am = '';
            $timeout_am = '';
            $timein_pm = '';
            $timeout_pm = '';
            $timeinhr = '';
            $timeouthr = '';


            while($r = $query->fetch(PDO::FETCH_NUM)){

                if(in_array($day, explode(',', $r[0])) == true){

                    $que = $dbh->prepare("SELECT time_format(timein_am, '%H'), days, time_format(timeout_pm, '%H'), timein_am, timeout_am, timein_pm, timeout_pm FROM pcc_staff_scheduling WHERE biono=?");
                    $que->execute([$biono]);
                    $row  = $que->fetch(PDO::FETCH_NUM);
                    $timeinhr = $row[0];
                    $timeouthr = $row[2];
                    $timein_am = $row[3];
                    $timeout_am = $row[4];
                    $timein_pm = $row[5];
                    $timeout_pm = $row[6];

                } 
            }

            return  array(
                        'timeinhr' => $timeinhr,
                        'timeouthr' => $timeouthr,
                        'timein_am' => $timein_am,
                        'timeout_am' => $timeout_am,
                        'timein_pm' => $timein_pm,
                        'timeout_pm' => $timeout_pm,
                    );  

        }

                  
        
    }

    function getRegularHours($biono, $day, $sem, $sy)
    {
        global $dbh; 

        $teaching = empClassification($biono);
        if($teaching == 0){

            $query = $dbh->prepare("SELECT total, days FROM pcc_staff_scheduling WHERE biono=?");
            $query->execute([$biono]);
            if($query->rowCount() >0 ){
                $hours = 0;
                $minutes = 0;
                while($r = $query->fetch(PDO::FETCH_OBJ)){

                $rdays = explode(',', $r->days);
                    if(array_search($day, explode(',', $r->days)) !== false){
                        $value = explode(':', $r->total);
                        $hours += $value[0];
                        $minutes += $value[1];

                    }
                }            
                // return array('value' => ($hours * 3600) + ($minutes * 60), 'timeval' =>  ($hours) + ($minutes));
                return ($hours * 3600) + ($minutes * 60);

            
            }
        }else{
            $reg_hours = schedTime($biono, $day, 0, $sem, $sy);
            $minutes = $reg_hours['totalhours'];
            return $minutes;
        }
    }

    function getTimeDifference($timein, $timeout){


        if(!empty($timein) && !empty($timeout)){
            $timeout = new DateTime($timeout);
            $timein = new DateTime($timein);

            $timediff = $timein->diff($timeout);
            $totalseconds = ($timediff->format('%r%H') * 3600) + ($timediff->format('%r%i') * 60);
            return $totalseconds;
        }else{
            return 0;
        }  
    }


    function getTime($time)
    {

        $hour = floor($time / 3600) > 0 ? floor($time / 3600) : '00';
        $minute = floor($time / 60 % 60) > 0 ? floor($time / 60 % 60) : '00';
        $val =  (($hour < 10 && $hour != '00') ? '0'.$hour : $hour) .':'.(($minute < 10 && $minute != '00') ? '0'.$minute : $minute);
        return $val;
    }
}

