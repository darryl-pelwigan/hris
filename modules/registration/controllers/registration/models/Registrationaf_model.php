<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrationaf_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function select_rand(){
        $this->db->select('*');
        $this->db->from('pcc_registration');
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    
    
}