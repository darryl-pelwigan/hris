<?php defined('BASEPATH') OR exit('No direct script access allowed');


class pcc_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function get_sem($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_enrollmentperiod'); 
        $query = $this->db->get();
            return $query->result();
        
    }
    
}