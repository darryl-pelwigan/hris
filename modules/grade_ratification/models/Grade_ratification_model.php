<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_ratification_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

  

   function get_grade_ratification_student($sched_id,$student_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_grade_ratification');
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
            return $query->result();
   }

   function insert_grade_ratification_student($data){
        $this->db->insert('pcc_gs_grade_ratification', $data);
         return $this->db->insert_id();
   }

   function update_grade_ratification_student($data){
       	$this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('prelim', $data['prelim']);
       	$this->db->set('midterm', $data['midterm']);
       	$this->db->set('tentativefinal', $data['tentativefinal']);
       	$this->db->set('final_grade', $data['final_grade']);
       	$this->db->set('grade_remarks', $data['grade_remarks']);
       	$this->db->set('comment', $data['comment']);
       	$this->db->set('old_data', $data['old_data']);
        $this->db->where('sched_id', $data['sched_id']);
        $this->db->where('student_id', $data['student_id']);
        $this->db->update('pcc_gs_grade_ratification');
        return $this->db->affected_rows();
    }


    
}