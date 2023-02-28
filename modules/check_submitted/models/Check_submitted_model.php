<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Check_submitted_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_notify($sched_id,$select='*'){
    	$this->db->select($select);
        $this->db->from('pcc_student_final_grade_review_notify');
        $this->db->where('sched_id', $sched_id);
        $query = $this->db->get();
        return $query->result();
    }

    function insert_notify($data){
    	 $this->db->insert('pcc_student_final_grade_review_notify', $data);
         return $this->db->insert_id();
    }


    function set_notify($sched_id,$type){
        $this->db->set('date_updated','NOW()', FALSE);
        $this->db->set($type,'NOW()', FALSE);
        $this->db->where('sched_id', $sched_id);
        $this->db->update('pcc_student_final_grade_review_notify');
        return $this->db->affected_rows();
    }

    function dept_courses($dept_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_courses');
        $this->db->where('department', $dept_id);
        $query = $this->db->get();
        return $query->result();
    }

     function dept_courses_all($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_courses');
        $query = $this->db->get();
        return $query->result();
    }

    function approved_grade_request_update($sched_id,$type,$message){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('submit_'.$type, NULL  );
        $this->db->set('checkdean_'.$type, NULL  );
        $this->db->set('requ_'.$type, NULL  );
        $this->db->set('requ_'.$type.'_remarks', $message );
        $this->db->where('sched_id', $sched_id);
        $this->db->update('pcc_student_final_grade_review_approved');
        return $this->db->affected_rows();
    }



  
    
}