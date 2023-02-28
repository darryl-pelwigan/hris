<?php defined('BASEPATH') OR exit('No direct script access allowed');

// for general data
// queries of data lists
// 
class employee_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_position_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_position');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_department_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_departments');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_leave_type_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_hr_leave_type');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_approving_position($pos_id){
        $this->db->select('l.*, p.position');
        $this->db->from('pcc_hr_leave_approval l');
        $this->db->join('pcc_position p', 'p.id=l.position_approval_id', 'left');
        $this->db->where('l.position_id', $pos_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function getlatestpositionrank($pos_id){
        $this->db->select('approval_level');
        $this->db->from('pcc_hr_leave_approval');
        $this->db->order_by('id', 'desc');
        $this->db->where('position_id', $pos_id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_position_approval($data){
        $this->db->insert('pcc_hr_leave_approval', $data);
        return $this->db->insert_id();
    }
    
    function setting_resetapproving($position_id){
        $this->db->where('position_id', $position_id);
        $this->db->delete('pcc_hr_leave_approval');
        return $this->db->affected_rows();
    }

}