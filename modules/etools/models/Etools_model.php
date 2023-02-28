<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Etools_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function save_etool($data){
        $this->db->insert('pcc_gs_tchr_cs_evtool', $data);
        return $this->db->insert_id();

    }

    function save_etool_cats($data){
        $this->db->insert('pcc_gs_tchr_cs_evcats', $data);
        return $this->db->insert_id();
    }

    function save_etool_cats_items($data){
        $this->db->insert('pcc_gs_tchr_cs_evitems', $data);
        return $this->db->insert_id();
    }


}