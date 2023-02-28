<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tor_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_student_list($sy,$select = '*'){
        $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', 'r.studid = ei.studid ');
        $this->db->join('pcc_courses c', 'ei.course=c.courseid');
        $this->db->join('pcc_student_types t', 'ei.student_type=t.id');
        $this->db->where('ei.sy', $sy);
        $this->db->order_by('r.lastname', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
   

   
}