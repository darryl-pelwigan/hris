<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }


  /*************

    check if user is lecture and labaoratory
  *************/


    function check_leclab_teacher($teacherid,$schedid,$type,$select = '*'){
        $this->db->select($select);
        $this->db->from('pcc_teachersched ts');
        $this->db->join('pcc_schedulelist sc', 'sc.schedid = ts.subjid ');
        $this->db->where('ts.teacherid', $teacherid);
        $this->db->where('ts.subjid', $schedid);
        $this->db->where('sc.type', $type);
        $query = $this->db->get();
         return $query->result()?true:false;
    }

    function check_lab_ifexist($schedid,$sem,$sy,$select = '*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist sc');
        $this->db->where('sc.group_id', $schedid);
        $this->db->where('sc.semester', $sem);
        $this->db->where('sc.schoolyear', $sy);
        $query = $this->db->get();
         return $query->result();
    }
    
    function reset_grades_sched_id($schedid,$tables){

      $this->db->where('sched_id', $schedid);
      $this->db->delete($tables);
      $this->db->reset_query();
    }

    function reset_grades_schedid($schedid,$tables){

      $this->db->where('schedid', $schedid);
      $this->db->delete($tables);
      $this->db->reset_query();
    }

    function insert_reset_info($reason,$sched_id,$teacher_id){
      $configs = array('percent'=>55,'exemption'=>false);
        $data = array(
                                'teacher_id' => $teacher_id,
                                'schedid' => $sched_id,
                                'reason' => json_encode($reason),
                                'date_created' => date('Y-m-d H:i:s')
                        );
        $this->db->insert('pcc_gs_reset', $data);
    }

    function get_conf($coursecode,$sched_id,$teacher_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_config');
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('coursecode', $coursecode);
        $query = $this->db->get();
        if($query->result()){return $query->result();}
        else{return $this->create_conf($coursecode,$sched_id,$teacher_id);}
    }

    function get_sched_adviser($sched_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_sched_class_advise');
        $this->db->where('sched_id' , $sched_id);
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $query->result()?$data['query'][0]->teacher_id:false;
    }


    function update_conf($coursecode,$sched_id,$teacher_id,$configs){
        $this->db->set('configs', $configs);
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('coursecode', $coursecode);
        $this->db->update('pcc_gs_config');
        return $this->db->affected_rows();
    }

    function create_conf($coursecode,$sched_id,$teacher_id){
      $configs = array('percent'=>55,'exemption'=>false);
        $data = array(
                                'teacher_id' => $teacher_id,
                                'coursecode' =>  $coursecode,
                                'sched_id' => $sched_id,
                                'configs' => json_encode($configs),
                                'date_created' => date('Y-m-d H:i:s')
                        );
        $this->db->insert('pcc_gs_config', $data);
        return $this->get_conf($coursecode,$sched_id,$teacher_id);
    }

    function check_remarks($studentid,$sched_id,$table,$select='*'){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where('schedid', $sched_id);
        $this->db->where('studentid', $studentid);
        $query = $this->db->get();
            return $query->result();
    }

    function insert_remarks($studentid,$schedid,$remarks,$table){
        $data = array(
                                'schedid' => $schedid,
                                'studentid' => $studentid,
                                'final_remarks' =>  $remarks,
                                'date_created' => date('Y-m-d H:i:s')
                        );
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

     function update_remarks($studentid,$schedid,$remarks,$table){
        $this->db->set('final_remarks', $remarks);
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('schedid', $schedid);
        $this->db->where('studentid', $studentid);
        $this->db->update($table);
        return $this->db->affected_rows();
    }

    // function get_student_list($id,$select='*'){
    //     $this->db->select($select);
    //     $this->db->from('pcc_studentsubj s');
    //     $this->db->join('pcc_registration r', 'r.studid = s.studentid ');
    //     // $this->db->join('pcc_studpayment sp', 'sp.studid = s.studentid ');
    //     $this->db->where('s.schedid', $id);
    //     $this->db->group_by('r.studid');
    //     $this->db->order_by('r.lastname', 'ASC');
    //     $this->db->where('s.subjdrop', '0');
    //     $query = $this->db->get();
    //         return $query->result();
    // }

     function get_student_list($id,$select='*'){
        $this->db->select('r.*, s.*, CONCAT(r.lastname, " ", r.firstname) as fullname');
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_registration r', 'r.studid = s.studentid ');
        // $this->db->join('pcc_studpayment sp', 'sp.studid = s.studentid ');
        $this->db->where('s.schedid', $id);
        $this->db->group_by('r.studid');
        $this->db->order_by('fullname', 'ASC');
        $this->db->where('s.subjdrop', '0');
        $query = $this->db->get();
            return $query->result();
    }


    function get_sched_infoAll($teacher_id , $schedid , $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist');
        $this->db->order_by('acadyear ','ASC');
        $this->db->group_by('acadyear ');
        $query = $this->db->get();
        return $query->result();
    }


    function get_sched_info($teacher_id , $schedid , $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist');
        $this->db->where('schedid ' , $schedid);
        $query = $this->db->get();
        $data['sched_query']=$query->result();
        $data['sched_num']=$query->num_rows();
        return $data;
    }

    function get_schedteacher_info($teacher_id , $schedid , $select='sc.*,CONCAT(sf.LastName, sf.FirstName ) as teacher_name'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist sc');
        $this->db->join('pcc_teachersched ts', 'sc.schedid = ts.subjid ');
        $this->db->join('pcc_staff sf', 'ts.teacherid = sf.BiometricsID ');
        $this->db->where('sc.schedid ' , $schedid);
        $query = $this->db->get();
        $data['sched_query']=$query->result();
        $data['sched_num']=$query->num_rows();
        return $data;
    }

    function get_sched_course($courseid , $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_courses');
        $this->db->where('courseid ' , $courseid);
        $query = $this->db->get();
        $query->result();
        return  $query->result();
    }

    function get_sched_course_dept($department , $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_courses');
        $this->db->where('department ' , $department);
        $query = $this->db->get();
        $query->result();
        return  $query->result();
    }

    function get_subject_cs(  $labunits , $teacher_id , $schedid , $type , $select='*' ){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs');
        $this->db->where('schedid ' , $schedid);
        $this->db->where('type ' , $type);
        $this->db->order_by('date_created', 'ASC');
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_subject_cs_items_total( $labunits ,  $teacher_id , $schedid , $type , $select='*' ){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs');
        $this->db->where('schedid ' , $schedid);
        $this->db->where('type ' , $type);
        $this->db->order_by('date_created', 'ASC');
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_subject_exam( $lecunits ,  $labunits ,  $teacher_id , $schedid , $type , $select='*'){
         if($lecunits>0 && $labunits>0){$table_e= 'pcc_gs_subject_examlab';}
         else{$table_e= 'pcc_gs_subject_exam';}

        $this->db->select($select);
        $this->db->from($table_e);
        $this->db->where('schedid ' , $schedid);
        $this->db->order_by('date_created', 'ASC');
        $query = $this->db->get();
        $data['exam_query']=$query->result();
        $data['exam_num']=$query->num_rows();
        return $data;
    }


    function get_subject_info($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_subject', array('subjectid' => $id),0, 1);
        return $query->result();
    }

    function get_cs_score( $labunits , $stud_id , $cs_id ,$cs_i_id, $type , $select='*'){
         $this->db->select($select);
         $this->db->from('pcc_gs_tchr_csscore');
         $this->db->where('cs_id ' , $cs_id);
         $this->db->where('stud_id ' , $stud_id);
          $this->db->where('cs_i_id ' , $cs_i_id);
         $query = $this->db->get();
           return $query->result();
    }

    function get_exam_score($lecunits , $labunits , $teacher_id , $stud_id , $schedid , $type , $select='*'){
         if($lecunits>0 && $labunits>0)
            $table_e= 'pcc_gs_sched_exam_labscore';
         else
             $table_e= 'pcc_gs_sched_exam_score';
         $this->db->select($select);
         $this->db->from($table_e);
         $this->db->where('schedid ' , $schedid);
         $this->db->where('studentid ' , $stud_id);
         $query = $this->db->get();
           return $query->result();
    }



    function get_sched_escore($lecunits, $labunits , $teacher_id , $schedid , $type_d , $item_n,$select='*'){
          if($lecunits>0 && $labunits>0)
            $table_e= 'pcc_gs_subject_examlab';
         else
             $table_e= 'pcc_gs_subject_exam';
         $this->db->select($select);
         $this->db->from($table_e);
         $this->db->where('schedid ' , $schedid);
         $query = $this->db->get();
           return $query->result();
    }

     function update_subject_exam($lecunits, $labunits ,  $teacher_id , $schedid , $type_d , $item_n ){
         if($lecunits>0 && $labunits>0){
            $table_e= 'pcc_gs_subject_examlab';
            $type_d[8]=$type_d[8];
            }
         else{
             $table_e= 'pcc_gs_subject_exam';
             $type_d[8]=$type_d[5];
             }

        $this->db->set($type_d[8], $item_n);
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('schedid', $schedid);
        $this->db->update($table_e);
        return $this->db->affected_rows();
    }



    function insert_subject_exam($lecunits,  $labunits , $teacher_id , $schedid , $type_d , $item_n ){
         if($lecunits>0 && $labunits>0){
            $table_e= 'pcc_gs_subject_examlab';
            $type_d[8]=$type_d[8];
            }
         else{
             $table_e= 'pcc_gs_subject_exam';
             $type_d[8]=$type_d[5];
             }
            $data = array(
                                'schedid' => $schedid,
                                // 'teacher_id' => $teacher_id,
                                $type_d[8] =>  $item_n,
                                'date_created' => date('Y-m-d H:i:s')
                        );
        $this->db->insert($table_e, $data);
        return $this->db->insert_id();
    }

    function get_student_score($studentid,$exm_id,$exm_val,$sched_id, $type_d , $table_e , $select='*'){
         $this->db->select($type_d[8]);
         $this->db->from($table_e);
         $this->db->where('exam_id ' , $exm_id);
         $this->db->where('schedid ' , $sched_id);
         $this->db->where('studentid ' , $studentid);
         $query = $this->db->get();
           return $query->result();
    }

    function insert_student_exam( $studentid,$exm_id,$exm_val,$sched_id, $type_d , $table_e){
         $data = array(
                                'exam_id' => $exm_id,
                                'studentid' => $studentid,
                                'schedid' => $sched_id,
                                $type_d[8] =>  $exm_val,
                                'date_created' => date('Y-m-d H:i:s')
                        );
        $this->db->insert($table_e, $data);
        return $this->db->insert_id();
    }

    function update_student_exam( $studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e){
        $this->db->set($type_d[8], $exm_val);
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('studentid', $studentid);
        $this->db->where('schedid', $sched_id);
        $this->db->where('exam_id', $exm_id);
        $this->db->update($table_e);
        return $this->db->affected_rows();
    }

    function get_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f ){
         $this->db->select($type_d);
         $this->db->from($table_e_f);
         $this->db->where('schedid ' , $sched_id);
         $this->db->where('studentid ' , $studentid);
         $query = $this->db->get();
           return $query->result();
    }

    function update_student_finalgrade( $studentid,$sched_id,$type_d , $table_e , $final  ){
        $this->db->set($type_d[8], $final);
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('studentid', $studentid);
        $this->db->where('schedid', $sched_id);
        $this->db->update($table_e);
        return $this->db->affected_rows();
    }

    function insert_student_finalgrade( $studentid,$sched_id,$type_d , $table_e , $final  ){
          $data = array(
                                'studentid' => $studentid,
                                'schedid' => $sched_id,
                                $type_d[8] =>  $final,
                                'date_created' => date('Y-m-d H:i:s')
                        );
        $this->db->insert($table_e, $data);
        return $this->db->insert_id();
    }

    function update_percentage($sched_id,$leclab){
        $this->db->set('percentage', $leclab );
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('schedid', $sched_id);
        $this->db->update("pcc_gs_subject_examlab");
         return $this->db->affected_rows();
    }

    function insert_percentage($sched_id,$leclab){
         $data = array(
                                'schedid' => $sched_id,
                                "percentage" =>  $leclab,
                                "prcnt" =>  55,
                                'date_created' => date('Y-m-d H:i:s')
                       );
        $this->db->insert("pcc_gs_subject_examlab", $data);
        return $this->db->insert_id();
    }

    /*duplicate functionality with get_final_grades just to simplify things*/
    function get_intern_grades($sched_id,$studentid,$select='*'){
         $this->db->select($select);
         $this->db->from('pcc_gs_student_gradeslec');
         $this->db->where('schedid ' , $sched_id);
         $this->db->where('studentid ' , $studentid);
         $query = $this->db->get();
           return $query->result();
    }

    function update_intern_grades($sched_id,$studentid,$grades_val,$select='*'){
       $this->db->set('final', $grades_val );
        $this->db->set('date_updated', 'NOW()', FALSE );
        $this->db->where('schedid', $sched_id);
        $this->db->where('studentid', $studentid);
        $this->db->update("pcc_gs_student_gradeslec");
         return $this->db->affected_rows();
    }

    function insert_intern_grades($sched_id,$studentid,$grades_val,$select='*'){
          $data = array(
                                'schedid' => $sched_id,
                                'studentid' => $studentid,
                                "final" =>  $grades_val,
                                'date_created' => date('Y-m-d H:i:s')
                       );
          $this->db->insert("pcc_gs_student_gradeslec", $data);
          return $this->db->insert_id();
    }

    /* pcc_gs_percentage */

    function get_acd_percentage($acdyr,$select='*'){
         $this->db->select($select);
         $this->db->from('pcc_gs_percentage');
         $this->db->where('acadyear ' , $acdyr);
         $query = $this->db->get();
           return $query->result();
    }

    /*final grade*/

    /* end for intern grades final */
    function type($type,$acadyear){
    $data='';
    $data[6]=strtolower($type);
     if($data[6]=='p' || $data[6]=='lp'){
            $data[0]='Prelim';
            $percent = [70,30];
        }elseif ($data[6]=='m' || $data[6]=='lm') {
            $data[0]='Midterm';
            $percent = [60,40];
        }elseif($data[6]=='tf' || $data[6]=='ltf'){
            $data[0]='Tentative Final';
            $percent = [50,50];
        }else{
            $percent = [0,0];
            $data[0]='Final';
        }

        $data['mid']='midterm';
        $data['pre']='prelim';
        $data['tent']='tentativefinal';
        $str_typeWord=preg_replace('/\s+/', '', $data[0]);
        $data[5]=strtolower($str_typeWord);
        $data[8]=strtolower(($data[6]=='lp' || $data[6]=='lm' || $data[6]=='ltf') ? 'lab_'.$str_typeWord : $str_typeWord);
        if($data[0]!='Final'){
            if($this->get_acd_percentage($acadyear,$data[5])){
                    $data["percentage"]=json_decode($this->get_acd_percentage($acadyear,$data[5])[0]->{$data[5]});
                    $data[1]=$data["percentage"]->{'cs'}/100;
                    $data[2]=$data["percentage"]->{'exam'}/100;
                    $data[3]=$data["percentage"]->{'cs'}.'%';
                    $data[4]=$data["percentage"]->{'exam'}.'%';

            }else{

                $data[1]=$percent[0]/100;
                $data[2]=$percent[1]/100;
                $data[3]=$percent[0].'%';
                $data[4]=$percent[1].'%';
            }
            $data['title']=strtolower(($data[6]=='lp' || $data[6]=='lm' || $data[6]=='ltf') ? 'lab_'.$str_typeWord : $str_typeWord);
    }else{
        $data['title'] = "Final Grade";
    }


            $data[7]=($data[6]=='lp' || $data[6]=='lm' || $data[6]=='ltf') ? 'LABORATORY' : 'LECTURE';

            $data[9]='lab_'.strtolower($str_typeWord);

             if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
                {$data[10]= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);}
            else
                {$data[10]= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);}

        return $data;
	}








}