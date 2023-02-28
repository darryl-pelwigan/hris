<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Early_enroll_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }
    
    function religion($select="(*)"){
        $this->db->select($select);
        $this->db->from('tblreligion');
        $this->db->order_by('tblreligion.religion', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
      function courses($select="*"){
        $courseid = array(15,16);
        $this->db->select($select);
        $this->db->from('pcc_courses');
        $this->db->where_not_in('pcc_courses.courseid', $courseid);
        $this->db->order_by('pcc_courses.courseid', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    
}