<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {





    function get_user_info($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function get_user_position($id,$select='*'){

        $this->db->select($select);
        $query = $this->db->get_where('pcc_position', array('id' => $id),0, 1);
        return $query->result();
    }

    function ins_staff_education($id,$val=array()){
        $this->db->insert('pcc_staff_educ_background2', $val);
        return $this->get_user_education($id);
    }
     function get_user_education($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_staff_educ_background2', array('staff_id' => $id),0, 1);
        if(!$query->result()){
              return $this->ins_staff_education($id,array('id'=>null,'staff_id'=>$id));
        }
        else
                return $query->result();
    }

    function get_user_role($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login');
        $this->db->join('pcc_roles', 'pcc_login.role = pcc_roles.id ', 'left');
        $this->db->where('pcc_login.studid', $id);
        $query = $this->db->get();
            return $query->result();
    }
}