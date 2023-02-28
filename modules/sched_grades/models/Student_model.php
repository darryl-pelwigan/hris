<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }
    
    function get_student_list($select='*'){
      
        $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', ' r.studid=ei.studid ', 'LEFT');
        $this->db->join('pcc_courses c', ' ei.course=c.courseid ', 'LEFT');
        $this->db->join('pcc_student_types t', ' ei.student_type=t.id ', 'LEFT');
        $query = $this->db->get();
            return $query->result();
    }
    
    function get_student_info($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_registration', array('studid' => $id),0, 1);
        
        return $query->result();
    }
   
}