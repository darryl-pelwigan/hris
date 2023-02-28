<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_assessment_model extends CI_Model {

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

   function get_student_list_assesment( $courseid , $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', 'r.studid = ei.studid ','LEFT');
        $this->db->join('pcc_courses c', 'ei.course=c.courseid','LEFT');
        $this->db->join('pcc_student_types t', 'ei.student_type=t.id','LEFT');
        $this->db->where('c.courseid', $courseid);
        $this->db->order_by('r.lastname', 'ASC');
        $query = $this->db->get();
            return $query->result();
    }

   function get_approved_list_assesment($sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', 'r.studid=ei.studid','LEFT');
        $this->db->join('pcc_courses c', 'ei.course=c.courseid','LEFT');
        $this->db->join('pcc_assessmode m ', 'm.studid=r.studid','LEFT');
        $this->db->where('m.status', '0');
        $this->db->where('m.sem', $sem);
        $this->db->where('m.acadyear', $sy);
        $this->db->order_by('r.lastname', 'ASC');
        $query = $this->db->get();
            return $query->result();
    }

    function check_assessment($studentid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studaccount s');
        $this->db->where('s.studentid', $studentid);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.sy', $sy);
        $query = $this->db->get();
            return $query->result();
    }

        function check_payment($studentid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studpayment s');
        $this->db->where('s.studid', $studentid);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.sy', $sy);
        $query = $this->db->get();
            return $query->result();
    }


   
}