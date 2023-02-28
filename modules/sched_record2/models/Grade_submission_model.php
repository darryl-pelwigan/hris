<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_submission_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_grades_lec($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_student_gradeslec sg');
        $this->db->join('pcc_registration r', 'r.studid = sg.studentid ');
        $this->db->where('sg.schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    function get_grades_leclab($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_student_gradesleclab sg');
        $this->db->join('pcc_registration r', 'r.studid = sg.studentid ');
        $this->db->where('sg.schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    function get_stud_fgrades($schedid,$student_id,$type_d,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_student_final_grade');
        $this->db->where('sched_id', $schedid);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        return $query->result();
    }


    function get_sched_leclabp($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_subject_examlab');
        $this->db->where('schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    function update_grades($schedid,$student_id,$type_d,$grade){
        $this->db->set($type_d, $grade);
        $this->db->where('sched_id', $schedid);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_student_final_grade');
        return $this->db->affected_rows();
    }

    function update_grades_pmtf($schedid,$student_id,$grade){
        $this->db->set('prelim', $grade['prelim']);
         $this->db->set('midterm', $grade['midterm']);
          $this->db->set('tentativefinal', $grade['tentativefinal']);
          $this->db->set('final', $grade['final']);
        $this->db->where('sched_id', $schedid);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_student_final_grade');
        return $this->db->affected_rows();
    }



    function insert_grades($data){
         $this->db->insert('pcc_student_final_grade', $data);
         return $this->db->insert_id();
    }

    function check_sched_fgrades($schedid,$type = '', $all = false, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_student_final_grade');
        $this->db->where('sched_id', $schedid);
        if($all===false)
            $this->db->where($type.'!=', '0.00');
        $query = $this->db->get();
        return $query->result();
    }



    function get_gradeupdate_requestx($schedid,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_fgrade_request_update gu_req');
        $this->db->where('schedid', $schedid);
        $this->db->where('type', $type);
        $this->db->where('teacher_id', $teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_gradeupdate_request($schedid,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_fgrade_request_update gu_req');
        $this->db->join('pcc_staff s', 'gu_req.teacher_id = s.BiometricsID ');
        $this->db->join('pcc_schedulelist sc', 'gu_req.schedid = sc.schedid ');
        $this->db->where('gu_req.schedid', $schedid);
        $this->db->where('gu_req.type', $type);
        $this->db->where('gu_req.teacher_id', $teacher_id);
        $query = $this->db->get();
        return $query->result();
    }

    function update_gradeupdate_request($schedid,$teacher_id,$type,$remarks){
        $this->db->set('remarks', json_encode($remarks));
        $this->db->where('schedid', $schedid);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('status', '1');
        $this->db->update('pcc_gs_fgrade_request_update');
        return $this->db->affected_rows();
    }

    function insert_gradeupdate_request($schedid,$teacher_id,$type,$request_desc){
        $data = array(
                        'schedid' =>$schedid,
                        'teacher_id' =>$teacher_id,
                        'request_desc' =>$request_desc,
                        'type' =>$type,
                        'status' =>'1',

            );
        $this->db->insert('pcc_gs_fgrade_request_update', $data);
        return $this->db->insert_id();
    }

    function get_gradeupdate_request_id($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_fgrade_request_update gu_req');
        $this->db->join('pcc_staff s', 'gu_req.teacher_id = s.BiometricsID ');
        $this->db->join('pcc_schedulelist sc', 'gu_req.schedid = sc.schedid ');
        $this->db->where('gu_req.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_gradeupdate_request_idx($request_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_fgrade_request_update');
        $this->db->where('id', $request_id);
        $query = $this->db->get();
        return $query->result();
    }

    function update_gradeupdate_request_id($request,$date_validity,$data,$checker){
        $this->db->set('remarks', json_encode($data));
        $this->db->set('request_valid_from', $date_validity);
        $this->db->set('status', $checker);
        $this->db->where('id', $request);
        $this->db->update('pcc_gs_fgrade_request_update');
        return $this->db->affected_rows();
    }

    function update_gradeupdate_request_idx($request,$data){
        $this->db->set('remarks', json_encode($data));
        $this->db->set('status', '1');
        $this->db->where('id', $request);
        $this->db->update('pcc_gs_fgrade_request_update');
        return $this->db->affected_rows();
    }

    function update_gradeupdate_request_idxx($request){
        $this->db->set('status', '1');
        $this->db->where('id', $request);
        $this->db->update('pcc_gs_fgrade_request_update');
        return $this->db->affected_rows();
    }
}