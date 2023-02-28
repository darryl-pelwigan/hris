<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Hris_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function insert_add_emp($array_insert){
        $this->db->insert('pcc_staff',($array_insert));
        return $this->db->insert_id();
    }

    function get_emp($staff,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid', $staff);
        $query = $this->db->get();
        return $query->result();
    }

    function get_old_emp($staff,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid', $staff);
        return $query = $this->db->get()->row();
    }

    function update_emp_records($staff,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('biometricsid', $staff);
        $this->db->update('pcc_staff');
        return $this->db->affected_rows();
    }

    function update_emp_history_log($data){
        $this->db->insert('pcc_hr_history_log', $data);
        return $this->db->insert_id();
    }

    function update_emp_biometricsid($staff,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('biometricsid', $staff);
        $this->db->update('pcc_staff');

        $this->db->set('studid', $value );
        $this->db->where('studid', $staff);
        $this->db->update('pcc_login');

        $this->db->set('teacherid', $value );
        $this->db->where('teacherid', $staff);
        $this->db->update('pcc_teachersched');

        return $this->db->affected_rows();


    }

    function get_emp_dpndnt($staff,$depid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_dependent');
        $this->db->where('staff_id', $staff);
         $this->db->where('id', $depid);
        $query = $this->db->get();
            return $query->result();
    }

    function insert_emp_dpndnt_records($array_insert){
        $this->db->insert('pcc_staff_dependent',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_dpndnt_records($staff,$depid,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $depid);
        $this->db->update('pcc_staff_dependent');
        return $this->db->affected_rows();
    }


    function get_emp_appointment($staff,$appid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_appointment');
        $this->db->where('staff_id', $staff);
         $this->db->where('id', $appid);
        $query = $this->db->get();
            return $query->result();
    }

    function insert_emp_appointment_records($array_insert){
        $this->db->insert('pcc_staff_appointment',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_appointment_records($staff,$appid,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $appid);
        $this->db->update('pcc_staff_appointment');
        return $this->db->affected_rows();
    }


    function get_educ($staff,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_educ_background');
        $this->db->where('staff_id', $staff);
        $query = $this->db->get();
            return $query->result();
    }

    function insert_emp_educ_records($array_insert){
        $this->db->insert('pcc_staff_educ_background',($array_insert));
        return $this->db->insert_id();
    }

    function insert_emp_otherids_records($array_insert){
        $this->db->insert('pcc_staff_otherid',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_educ_records($staff,$id,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_educ_background');
        return $this->db->affected_rows();
    }

    function insert_emp_eligibilities_records($array_insert){
        $this->db->insert('pcc_staff_eligibility',($array_insert));
        return $this->db->insert_id();
    }

     function get_emp_eligibility($staff,$eligid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_eligibility');
        // $this->db->where('staff_id', $staff);
        $this->db->where('id', $eligid);
        $query = $this->db->get();
        return $query->result();
    }

    function get_emp_otherids($staff,$ids,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_otherid');
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $ids);
        $query = $this->db->get();
        return $query->result();
    }

    function update_emp_eligibilities_records($staff,$id,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_eligibility');
        return $this->db->affected_rows();
    }

    function update_emp_otherids_records($staff,$id,$type,$value){
        $this->db->set($type, $value );
        // $this->db->where('staff_id', $staff);
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_otherid');
        return $this->db->affected_rows();
    }

    function checkemp_for_request_approval($fileno){
        $this->db->select('a.id');
        $this->db->from('pcc_hr_leave_approval a');  
        $this->db->join('pcc_staff s', 's.positionrank=a.position_approval_id', 'inner');      
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_employees($active, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
        $this->db->where('pcc_staff.active' , $active);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_position($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_position');
        $query = $this->db->get();
        return $query->result();
    } 

    function get_emp_leave_records($leave_id){
        $this->db->select('la.*, lt.type');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left');    
        if($leave_id > 0){
            $this->db->where('la.id' , $leave_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_leave_credits($leave_id){
        $this->db->select('l.leave_credit, l.date_added, l.type_id, lt.type, l.empid, l.type_id');
        $this->db->from('pcc_hr_leave l');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=l.type_id', 'inner');    
        if($leave_id > 0){
            // $this->db->where('l.id' , $leave_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_overtime_records($ot_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_overtime');  
        if($ot_id > 0){
            $this->db->where('pcc_hr_overtime.id' , $ot_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_pass_slip_records($passlip_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');  
        if($passlip_id > 0){
            $this->db->where('pcc_hr_passslip.id' , $passlip_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_travel_order_records($travelo_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_form');  
        if($travelo_id > 0){
            $this->db->where('pcc_hr_travel_form.id' , $travelo_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_service_log(){
        $this->db->select("*");
        $this->db->from("pcc_hr_service_leave_credits");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    function search_employee($data){
        $this->db->select('pcc_staff.Firstname, pcc_staff.LastName, pcc_staff.FileNo');
        $this->db->from('pcc_staff');  
        $this->db->like('CONCAT(pcc_staff.FileNo, " ", pcc_staff.Firstname, " ", pcc_staff.LastName)' , $data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_holidays($holiday_id){
        $this->db->select('*');
        $this->db->from('holidays');  
        if($holiday_id > 0){
            $this->db->where('holidays.holiday_id' , $holiday_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_timekeeping_records($fdate, $tdate){
        $this->db->select('b.*, s.fileno, s.firstname, s.lastname, d.deptname, p.position');
        $this->db->from('biometrics_tbl b');  
        $this->db->join('pcc_staff s', 's.biometricsid=b.badgenumber', 'left');      
        $this->db->join('pcc_departments d', 'd.deptid=s.department', 'left');
        $this->db->join('pcc_position p', 'p.id=s.positionrank', 'left');      
        if($fdate != '1970-01-01'){
            $this->db->where('date_format(b.datetime, "%Y-%m-%d") >=', $fdate);
            $this->db->where('date_format(b.datetime, "%Y-%m-%d") <=', $tdate);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_holiday_list($data){
        $this->db->insert('holidays', $data);
        return $this->db->insert_id();
    }
    
    function update_holiday_list($data, $holiday_id){
        $this->db->update('holidays', $data);
        $this->db->where('holiday_id', $holiday_id);
        return $this->db->affected_rows();
    }

    function del_holiday($holiday_id){
        $this->db->where('holidays.holiday_id', $holiday_id);
        return $this->db->delete('holidays');
    }

    function get_attendance_records($fdate, $tdate){
        $this->db->select('a.*, s.fileno, s.firstname, s.lastname, d.deptname, p.position, s.teaching');
        $this->db->from('pcc_staff_attendance a');  
        $this->db->join('pcc_staff s', 's.biometricsid=a.biono', 'left');      
        $this->db->join('pcc_departments d', 'd.deptid=s.department', 'left');
        $this->db->join('pcc_position p', 'p.id=s.positionrank', 'left');      
        // if($fdate != '1970-01-01'){
        //     $this->db->where('date_format(a.date, "%Y-%m-%d") >=', $fdate);
        //     $this->db->where('date_format(a.date, "%Y-%m-%d") <=', $tdate);
        // }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_emp_timekeeping_records($date, $biono){
        $this->db->select('*');
        $this->db->from('biometrics_tbl');      
        $this->db->where('date_format(biometrics_tbl.datetime, "%Y-%m-%d") = ', $date);
        $this->db->where('biometrics_tbl.badgenumber', $biono);
        $this->db->order_by('biometrics_tbl.datetime', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_schedule($biono){
        $this->db->select('*');
        $this->db->from('pcc_staff_scheduling');  
        if($biono > 0){
            $this->db->where('pcc_staff_scheduling.biono' , $biono);
        }    
        $this->db->order_by('pcc_staff_scheduling.timein', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    
    function get_emp_schedule_teaching($biono, $sem, $sy){
        $this->db->select('s.start, s.end, s.days');
        $this->db->from('pcc_teachersched ts');  
        $this->db->join('pcc_schedulelist s', 's.schedid=ts.subjid', 'left');
        $this->db->where('ts.teacherid' , $biono);
        $this->db->where('s.semester' , $sem);
        $this->db->where('s.schoolyear' , $sy);
        $this->db->where('s.start !=' , '');
        $this->db->order_by('s.start', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


}