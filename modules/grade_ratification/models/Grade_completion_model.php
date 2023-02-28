<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_completion_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

   function get_grade_completion_student($sched_id,$student_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_grade_completion');
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
            return $query->result();
   }

   function insert_grade_completion_student($data){
        $this->db->insert('pcc_gs_grade_completion', $data);
         return $this->db->insert_id();
   }

   function count_gc($select='*'){
      $this->db->select($select);
        $this->db->from('pcc_gs_grade_completion');
        $this->db->where('approved_by_registrar', NULL);
        $query = $this->db->get();
            return $query->result();
   }



   function update_grade_completion_student($sched_id,$student_id,$lec_cs,$lec_exam,$lec_total,$lab_cs,$lab_exam,$lab_total,$tentativefinal,$final_grade,$remarks,$grade_remarks){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('lec_cs', $lec_cs);
        $this->db->set('lec_exam', $lec_exam);
        $this->db->set('lec_total', $lec_total);
        $this->db->set('lab_cs', $lab_cs);
        $this->db->set('lab_exam', $lab_exam);
        $this->db->set('lab_total', $lab_total);
        $this->db->set('tentativefinal', $tentativefinal);
        $this->db->set('final_grade', $final_grade);
        $this->db->set('remarks', $remarks);
        $this->db->set('grade_remarks', $grade_remarks);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }

    function update_grade_completion_student_tf($sched_id,$student_id,$tentativefinal,$final_grade,$remarks){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('tentativefinal', $tentativefinal);
        $this->db->set('final_grade', $final_grade);
        $this->db->set('remarks', $remarks);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }

     function update_grade_completion_student_printed($sched_id,$student_id){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('is_printed', 1);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }

     function get_department($studid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login l');
        $this->db->join('pcc_departments d', ' l.department=d.DEPTID ');
        $this->db->where('l.studid', $studid);
        $this->db->limit(1);
        $query = $this->db->get();
            return $query->result();
    }

    // registrar manipulation
    function update__registrar_grade_completion_student_tf($sched_id,$student_id,$tentativefinal,$final_grade,$reg_remarks,$remarks){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('tentativefinal', $tentativefinal);
        $this->db->set('final_grade', $final_grade);
        $this->db->set('approved_by_registrar', json_encode($reg_remarks));
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }

    function approved__registrar_grade_completion_student_tf($sched_id,$student_id,$reg_remarks){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('approved_by_registrar', json_encode($reg_remarks));
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }


     function update_grades_final($schedid,$student_id,$final_grade,$tentativefinal,$remarksg){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('tentativefinal', $tentativefinal);
        $this->db->set('final', $final_grade);
        $this->db->set('re_final', $final_grade);
        $this->db->set('remarks', $remarksg);
        $this->db->where('sched_id', $schedid);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_student_final_grade');
        return $this->db->affected_rows();
    }

     function update_grades_finalx($schedid,$student_id,$final_grade,$tentativefinal,$remarksg){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('prelim', $tentativefinal);
        $this->db->set('midterm', $tentativefinal);
        $this->db->set('tentativefinal', $tentativefinal);
        $this->db->set('final', $final_grade);
        $this->db->set('re_final', $final_grade);
        $this->db->set('remarks', $remarksg);
        $this->db->where('sched_id', $schedid);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_student_final_grade');
        return $this->db->affected_rows();
    }



    
}