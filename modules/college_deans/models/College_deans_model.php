<?php defined('BASEPATH') OR exit('No direct script access allowed');

class College_deans_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }


    function get_all_college($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_departments  d');
        $this->db->where('d.TEACHING', '1');
        $this->db->where('d.DIACTIVATED', '0');
        $this->db->order_by('d.DEPTID', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_all_college_deans($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_departments  d');
        $this->db->join('pcc_college_deans c', 'd.DEPTID = c.college_dept ', 'left');
        $this->db->join('pcc_staff s', 's.ID = c.staff_id ', 'left');
        $this->db->where('c.date_ended',NULL);
        // $this->db->where('c.staff_id != ',NULL);
        $this->db->where('d.TEACHING', '1');
        $this->db->where('d.DIACTIVATED', '0');
        $this->db->order_by('d.DEPTID', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function get_teacher_deans($teacher_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_college_deans');
        $this->db->where('date_ended',NULL);
        $this->db->where('staff_id',$teacher_id);
        $query = $this->db->get();
        return $query->result();
    }


    function get_staff($DEPTID,$searchx,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->group_start()
                                ->like('LastName',$searchx,'after')
                                ->or_like('FirstName',$searchx,'after')
        ->group_end()
        ->where('Department',$DEPTID);
        $this->db->order_by('LastName', 'ASC');
        $query = $this->db->get();
       // 
        return $query->result();
    }

     function get_staff_all($searchx,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
                                $this->db->like('LastName',$searchx,'after');
                                $this->db->or_like('FirstName',$searchx,'after');
        $this->db->order_by('LastName', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }


     function insert_college_deans($data){
        $this->db->insert('pcc_college_deans', $data);
         return $this->db->insert_id();
    }

    function delete_college_deans($ID){
        $this->db->set('date_ended','NOW()', FALSE);
        $this->db->set('updated_at','NOW()', FALSE);
        $this->db->where('id', $ID);
        $this->db->update('pcc_college_deans');
        return $this->db->affected_rows();
    }
}