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
        $this->db->from('pcc_gs_grade_completion gc');

        $this->db->where('gc.approved_by_registrar', NULL);
        $query = $this->db->get();
            return $query->result();
   }

    function get_gc($select='*'){
      $this->db->select($select);
        $this->db->from('pcc_gs_grade_completion gc');
        $this->db->join('pcc_schedulelist sch', 'sch.schedid = gc.sched_id ');
        $this->db->where('gc.approved_by_registrar', NULL);
        $query = $this->db->get();
            return $query->result();
   }

    function get_gc_semsy($sem,$sy,$select='*'){
      $this->db->select($select);
        $this->db->from('pcc_gs_grade_completion gc');
        $this->db->join('pcc_schedulelist sch', 'sch.schedid = gc.sched_id ');
        $this->db->where('sch.semester', $sem);
        $this->db->where('sch.schoolyear', $sy);
        $this->db->where('gc.approved_by_registrar', NULL);
        $query = $this->db->get();
            return $query->result();
   }



   function update_grade_completion_student($data){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('lec_cs', $data['lec_cs']);
        $this->db->set('lec_exam', $data['lec_exam']);
        $this->db->set('lec_total', $data['lec_total']);
        $this->db->set('lec_percentage', $data['lec_percentage']);
        $this->db->set('lab_cs', $data['lab_cs']);
        $this->db->set('lab_exam', $data['lab_exam']);
        $this->db->set('lab_total', $data['lab_total']);
        $this->db->set('lab_percentage', $data['lab_percentage']);
        $this->db->set('tentativefinal', $data['tentativefinal']);
        $this->db->set('final_grade', $data['final_grade']);
        $this->db->set('remarks', $data['remarks']);
        $this->db->set('grade_remarks', $data['grade_remarks']);
        $this->db->set('approved_by_registrar', NULL);
        $this->db->set('old_data', $data['old_data']);
        $this->db->where('sched_id', $data['sched_id']);
        $this->db->where('student_id', $data['student_id']);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }


    function update_grade_completion_student_incomplete($data){
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('approved_by_registrar', NULL);
        $this->db->set('is_printed', 0);
        $this->db->where('sched_id', $data['sched_id']);
        $this->db->where('student_id', $data['student_id']);
        $this->db->update('pcc_gs_grade_completion');
        return $this->db->affected_rows();
    }

    function update_grade_completion_student_tf($data){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('tentativefinal', $data['tentativefinal']);
        $this->db->set('final_grade', $data['final_grade']);
        $this->db->set('grade_remarks', $data['grade_remarks']);
        $this->db->set('remarks', $data['remarks']);
        $this->db->set('old_data', $data['old_data']);
        $this->db->where('sched_id', $data['sched_id']);
        $this->db->where('student_id', $data['student_id']);
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
    function update__registrar_grade_completion_student_tf($data){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('tentativefinal', $data['tentativefinal']);
        $this->db->set('final_grade', $data['final_grade']);
        $this->db->set('approved_by_registrar', $data['reg_remarks']);
        $this->db->where('sched_id', $data['sched_id']);
        $this->db->where('student_id', $data['student_id']);
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

    function update_grades_finalxz($data){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('prelim', $data['prelim']);
        $this->db->set('midterm', $data['midterm']);
        $this->db->set('tentativefinal', $data['tentativefinal']);
        $this->db->set('final', $data['final_grade']);
        $this->db->set('re_final', $data['final_grade']);
        $this->db->set('remarks', $data['grade_remarks']);
        $this->db->where('sched_id', $data['sched_id']);
        $this->db->where('student_id', $data['student_id']);
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

     function get_init($select='*'){
         $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', 'ei.studid = r.studid ');
        $this->db->like('r.Gender', 'fe', 'both');
        $query = $this->db->get();
            return $query->result();
   }




}