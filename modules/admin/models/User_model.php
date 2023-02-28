<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model {

   

    function get_user_info($id,$select='*'){

        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_user_login($user_id,$uname,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login');
        $this->db->where('studid', $user_id);
        $this->db->where('username', $uname);
        $query = $this->db->get();
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

    function get_all_staff_dept($dept_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('Department', $dept_id);
        $query = $this->db->get();
            return $query->result();
    }

     function get_all_student_acct($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login l');
        $this->db->join('pcc_registration r ', 'r.studid=l.studid');
        $query = $this->db->get();
            return $query->result();
    }

    function get_sec_info($agent,$platform,$wan_ip,$lan_ip,$log_id,$user_id,$uname,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_sec_login_info');
        $this->db->where('login_id ' , $log_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('username', $uname);
        $this->db->where('wan_ip', $wan_ip);
        $this->db->where('lan_ip', $lan_ip);
        $this->db->where('user_platform', $platform);
        $this->db->where('user_agent', $agent);
        $query = $this->db->get();
            return $query->result();
    }

    function insert_sec_info($mac,$date_expiry,$agent,$platform,$log_id,$user_id,$uname,$wan_ip,$lan_ip){
           $data = array(
                "login_id" => $log_id,
                "user_id" => $user_id,
                "username" => $uname,
                "mac"=>$mac,
                "lan_ip" => $lan_ip,
                "wan_ip" => $wan_ip,
                "user_agent" => $agent,
                "user_platform" => $platform,
                "date_created" => mdate('%Y-%m-%d %H:%i %a'),
                "date_updated" => mdate('%Y-%m-%d %H:%i %a'),
                "date_expired" => $date_expiry
            );

            $this->db->insert('pcc_sec_login_info', $data);
             return $this->db->insert_id();
    }

    function update_sec_info($mac,$date_expiry,$agent,$platform,$log_id,$user_id,$uname,$wan_ip,$lan_ip){
         $this->db->set('mac', $mac);
        $this->db->set('wan_ip', $wan_ip);
        $this->db->set('lan_ip', $lan_ip);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('date_expired', $date_expiry);
        $this->db->where('login_id ' , $log_id);
        $this->db->where('user_id ' , $user_id);
        $this->db->where('username', $uname);
        $this->db->where('user_agent ' , $agent);
        $this->db->where('user_platform ' , $platform);
        $this->db->update('pcc_sec_login_info');
        return $this->db->affected_rows();
   }

   function get_secv_info($agent,$platform,$wan_ip,$lan_ip,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_sec_viewer');
        $this->db->where('wan_ip', $wan_ip);
        $this->db->where('lan_ip', $lan_ip);
        $this->db->where('user_agent ' , $agent);
        $this->db->where('user_platform', $platform);
        $query = $this->db->get();
            return $query->result();
   }

   function insert_secv_info($agent,$platform,$wan_ip,$lan_ip){
         $data = array(
                "lan_ip" => $lan_ip,
                "wan_ip" => $wan_ip,
                "user_agent" => $agent,
                "user_platform" => $platform,
                "date_created" => mdate('%Y-%m-%d %H:%i %a'),
                "date_updated" => mdate('%Y-%m-%d %H:%i %a'),
            );

            $this->db->insert('pcc_sec_viewer', $data);
             return $this->db->insert_id();
   }

   function update_secv_info($agent,$platform,$wan_ip,$lan_ip){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('wan_ip ' , $wan_ip);
        $this->db->where('lan_ip ' , $lan_ip);
        $this->db->where('user_agent ' , $agent);
        $this->db->where('user_platform ' , $platform);
        $this->db->update('pcc_sec_viewer');
        return $this->db->affected_rows();
   }


}