<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Admin_reg_model extends CI_Model {



    function get_user_info($id,$select='*'){
       $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_user_role($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login');
        $this->db->join('pcc_roles', 'pcc_login.role = pcc_roles.id ', 'left');
        $this->db->where('pcc_login.studid', $id);
        $query = $this->db->get();
            return $query->result();
    }


    function get_user_position($id,$select='*'){

        $this->db->select($select);
        $query = $this->db->get_where('pcc_position', array('id' => $id),0, 1);
        return $query->result();
    }

    function signatories($position,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_signatories', array('position' => $position),0, 1);
        return $query->result();
    }


    function get_schoolyear($select='*'){
        
        $this->db->select( $select );
        $this->db->from('pcc_schedulelist sc');
         $this->db->group_by('sc.schoolyear');
        $this->db->order_by('sc.schoolyear', 'ASC');
        $query = $this->db->get();
            return $query->result();
    }



}