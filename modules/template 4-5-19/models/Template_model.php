<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Template_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_sem_sy($select="*"){

        $this->db->select($select);
        $query = $this->db->get('pcc_enrollmentperiod');
        return $query->result();
    }

}