<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function sett_teacher_sched($id){
        $this->db->set('teacherid', $id);
        $this->db->update('pcc_teachersched_test');
        $this->db->affected_rows();
    }

    function get_teacher_sched($teacher_id,$sem,$sy,$select='*'){

        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 's.course=c.courseid');
        if($teacher_id=='5551'){$this->db->join('pcc_teachersched_test t', 's.schedid=t.subjid');}
        else{$this->db->join('pcc_teachersched t', 's.schedid=t.subjid');}
        $this->db->where('s.status !=', '2' );
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->where('t.teacherid', $teacher_id);

        $this->db->group_by('s.coursecode,s.fuse');
        $this->db->order_by('c.courseid,s.yearlvl,s.section', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    function get_sched_info($teacher_id , $coursecode , $select='*'){
        $sem_sy =$this->session->userdata('new_sem_Sy');
        $this->db->select($select);
        $this->db->from('pcc_teachersched t');
        $this->db->join('pcc_schedulelist s', 's.schedid = t.subjid ');
        $this->db->where('s.coursecode' , $coursecode);
        $this->db->where('s.semester', $sem_sy['sem']);
        $this->db->where('s.schoolyear',$sem_sy['sy']);
        // $this->db->group_by('s.fuse');
        $query = $this->db->get();
        $data['sched_query']=$query->result();
        $data['sched_num']=$query->num_rows();
        return $data;
    }

     function get_schedteacher_info($teacher_id , $coursecode , $select='s.*,t.teacherid,CONCAT(sf.LastName, ", " , sf.FirstName ) as teacher_name'){
        $sem_sy =$this->session->userdata('new_sem_Sy');
        $this->db->select($select);
        $this->db->from('pcc_teachersched t');
        $this->db->join('pcc_schedulelist s', 's.schedid = t.subjid ');
        $this->db->join('pcc_staff sf', 't.teacherid = sf.BiometricsID ');
        $this->db->where('s.coursecode' , $coursecode);
        $this->db->where('s.semester', $sem_sy['sem']);
        $this->db->where('s.schoolyear',$sem_sy['sy']);

        $query = $this->db->get();
        $data['sched_query']=$query->result();
        $data['sched_num']=$query->num_rows();
        return $data;
    }

    function get_schedteacher_infox($teacher_id , $coursecode , $select='s.*,t.teacherid,CONCAT(sf.LastName, ", " , sf.FirstName ) as teacher_name'){
        $sem_sy =$this->session->userdata('new_sem_Sy');
        $this->db->select($select);
        $this->db->from('pcc_teachersched t');
        $this->db->join('pcc_schedulelist s', 's.schedid = t.subjid ');
        $this->db->join('pcc_staff sf', 't.teacherid = sf.BiometricsID ');
        $this->db->where('s.coursecode' , $coursecode);
        // $this->db->where('s.semester', $sem_sy['sem']);
        // $this->db->where('s.schoolyear',$sem_sy['sy']);
        $query = $this->db->get();
        $data['sched_query']=$query->result();
        $data['sched_num']=$query->num_rows();
        return $data;
    }

    function get_schedteacher_infoxx($teacher_id , $subject, $select='s.*,t.teacherid,CONCAT(sf.LastName, ", " , sf.FirstName ) as teacher_name'){
        $sem_sy =$this->session->userdata('new_sem_Sy');
        $this->db->select($select);
        $this->db->from('pcc_teachersched t');
        $this->db->join('pcc_schedulelist s', 's.schedid = t.subjid ');
        $this->db->join('pcc_staff sf', 't.teacherid = sf.BiometricsID ');
        $this->db->where('s.coursecode' , $subject->coursecode);
        $this->db->where('s.semester', $subject->semester);
        $this->db->where('s.schoolyear',$subject->schoolyear);
        $this->db->group_by('s.schedid');
        $query = $this->db->get();
        $data['sched_query']=$query->result();
        $data['sched_num']=$query->num_rows();
        return $data;
    }


    /**
     * create a config json file for subjects
     */

    function get_subjct_conf($sched2,$check_sched,$sched,$teacherid, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_config');
        $this->db->where('coursecode' , $sched2->coursecode);
        $query = $this->db->get();

        return $query->result();
    }

    function create_subject_conf($sched2,$check_sched,$sched,$teacherid){
        $data =array(
                        'teacher_id' => $teacherid,
                        'coursecode' => $sched2->coursecode,
                        'sched_id' => $sched->subjid,
                        'configs' => json_encode(array("percent"=>55,"exemption"=>true)),
                        'date_created' => mdate('%Y-%m-%d %H:%i %a')
                    );

        $this->db->insert('pcc_gs_config', $data);
         return $this->db->insert_id();
    }

    function check_grade_completion($teacher_id , $coursecode , $select='*'){
        $this->db->select($select);
        $this->db->from(' pcc_teachersched t');
        $this->db->join(' pcc_student_final_grade_review_approved f', 'f.sched_id = t.subjid ');
        $this->db->where('t.subjid' , $coursecode);
        $this->db->where('f.submitted_by' , $teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

}