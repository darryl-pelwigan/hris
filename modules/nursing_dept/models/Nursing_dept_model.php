<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nursing_dept_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_user_info($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_user_dept($username,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login l');
        $this->db->join('pcc_roles r', 'l.role=r.id');
        $this->db->join('pcc_departments_ d', 'l.department=d.deptid');
        $this->db->where('l.username ' , $username);
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $data;
    }

    function get_user_role($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login');
        $this->db->join('pcc_roles', 'pcc_login.role = pcc_roles.id ', 'left');
        $this->db->where('pcc_login.studid', $id);
        $query = $this->db->get();
            return $query->result();
    }

    function get_scheduling($sy,$sem,$course=1,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 'c.courseid=s.course ', 'left');
        $this->db->where('s.schoolyear', $sy);
        $this->db->where('s.semester', $sem);
        $this->db->where('c.courseid=', $course);
        $this->db->group_by('s.yearlvl');
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $data;
    }

    function check_status($courseid,$yearlvl,$section,$schoolyear,$semester,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist');
        $this->db->where('course' , $courseid);
        $this->db->where('yearlvl' , $yearlvl);
        $this->db->where('section' , $section);
        $this->db->where('schoolyear' , $schoolyear);
        $this->db->where('semester' , $semester);
        $this->db->where('status' , 0);
        $this->db->group_by(array('schoolyear', 'semester', 'section', 'yearlvl', 'course'));

        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function check_submit_stat($courseid,$yearlvl,$section,$schoolyear,$semester,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist');
        $this->db->where('course' , $courseid);
        $this->db->where('yearlvl' , $yearlvl);
        $this->db->where('section' , $section);
        $this->db->where('schoolyear' , $schoolyear);
        $this->db->where('semester' , $semester);
        $this->db->where('submit_stat' , 0);
        $this->db->group_by(array('schoolyear', 'semester', 'section', 'yearlvl', 'course'));

        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_schedule_data($section,$course,$year,$curr,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 'c.courseid=s.course ', 'left');
        $this->db->where('s.course' , $course);
        $this->db->where('s.yearlvl' , $year);
        $this->db->where('s.section' , $section);
        $this->db->where('s.schoolyear' , $sy);
        $this->db->where('s.semester' , $sem);
        $this->db->group_by(array('coursecode'));
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $query->result()?$data:false;
    }

    function check_teacher($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_teachersched');
        $this->db->where('subjid' , $schedid);
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $query->result()?$data:false;
    }

    function check_teacher_advisee($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_sched_class_advise');
        $this->db->where('sched_id' , $schedid);
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $query->result()?$data:false;
    }

    function get_teacher_flm($teacher_idx,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('BiometricsID' , $teacher_idx);
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $query->result()?$data:false;
    }

    function get_nursing_adviser($deptid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('teaching' , $deptid);
        $this->db->order_by('LastName ','ASC');
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $query->result()?$data:false;
    }

    function set_nursing_adviser($data){
        $this->db->insert('pcc_sched_class_advise', $data);
         return $this->db->insert_id();
    }

    function del_nursing_adviser($sched_id,$sem,$sy){
        $this->db->where('sched_id', $sched_id);
        $this->db->where('sem ' , $sem);
        $this->db->where('sy ' , $sy);
        $this->db->delete('pcc_sched_class_advise');
         echo $this->db->affected_rows();
    }




}