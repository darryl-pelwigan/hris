<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Itdept_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }
    
    function get_student_list($sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_registration pr');
        $this->db->join('pcc_studentsubj ps', 'pr.studid = ps.studentid ');
        $this->db->join('pcc_enrollment_info pei', 'pr.studid = pei.studid ');
        $this->db->where('pei.sem', $sem);
        $this->db->where('pei.sy', $sy);
        $this->db->group_by('pei.studid');
        $this->db->order_by('pei.date_admitted', 'ASC');
        $query = $this->db->get();
            return $query->result();
    }


}