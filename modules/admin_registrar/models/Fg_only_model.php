<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Fg_only_model extends CI_Model {




	function get_completion_days($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_grade_completion_days');
        $query = $this->db->get();
        return $query->result();
    }

    function get_completion_days_type($grading_type,$select='*'){
        $this->db->select($select);
        $this->db->where('grading_type', $grading_type);
        $this->db->from('pcc_gs_grade_completion_days');
        $query = $this->db->get();
        return $query->result();
    }

    function update_completion_days($grading_type,$days){
        $this->db->set('updated_at', 'NOW()', FALSE);
   		$this->db->set('days', $days);
        $this->db->where('grading_type', $grading_type);
        $this->db->update('pcc_gs_grade_completion_days');
        return $this->db->affected_rows();
    }


    /**
     * / fg only start
     * @param  string $select [select type]
     * @return [type]         [array, string]
     */
    function get_fgs_only($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_subject_fg_only sf');
        $this->db->join('pcc_subject s', 's.subjectid = sf.subjectid ');
        $this->db->where('sf.deleted_at', NULL);
        $this->db->order_by('s.courseno','asc');
        $query = $this->db->get();
        return $query->result();
    }

     function get_fg_only($subjectid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_subject_fg_only');
        $this->db->where('subjectid', $subjectid);
        $this->db->where('deleted_at', NULL);
        $query = $this->db->get();
        return $query->result();
    }

    function get_teachers_only($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff sf');
        $this->db->join('pcc_grading_records gr', 'gr.teacher_id = sf.FileNo ');
        $this->db->join('pcc_departments d', 'd.DEPTID = sf.Department ');
        $this->db->where('gr.deleted_at', NULL);
        $this->db->order_by('sf.Department','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_teacher_view($teacherid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_grading_records');
        $this->db->where('teacher_id', $teacherid);
        $query = $this->db->get();
        return $query->result();
    }

     function get_teacher_view_exclude($teacherid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_grading_records');
        $this->db->where('teacher_id', $teacherid);
        $this->db->where('deleted_at', NULL);
        $query = $this->db->get();
        return $query->result();
    }

     function insert_teacher_view($data){
       $this->db->insert('pcc_grading_records', $data);
         return $this->db->insert_id();
    }

    function remove_teacher_view($teacherid,$select='*'){
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('deleted_at', 'NOW()', FALSE);
        $this->db->where('teacher_id', $teacherid);
        $this->db->update('pcc_grading_records');
        return $this->db->affected_rows();
    }

    function restore_teacher_view($teacherid,$select='*'){
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('deleted_at', NULL);
        $this->db->where('teacher_id', $teacherid);
        $this->db->update('pcc_grading_records');
        return $this->db->affected_rows();
    }


    function insert_fg_only($data){
       $this->db->insert('pcc_gs_subject_fg_only', $data);
         return $this->db->insert_id();
    }

    function remove_fg_only($subjectid,$select='*'){
        $this->db->set('updated_at', 'NOW()', FALSE);
   		$this->db->set('deleted_at', 'NOW()', FALSE);
        $this->db->where('subjectid', $subjectid);
        $this->db->update('pcc_gs_subject_fg_only');
        return $this->db->affected_rows();
    }

    function restore_fg_only($subjectid,$select='*'){
        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->set('deleted_at', NULL);
        $this->db->where('subjectid', $subjectid);
        $this->db->update('pcc_gs_subject_fg_only');
        return $this->db->affected_rows();
    }


    /**
     * fg only end
     */




    /**
     * /
     * @param  [int] $subjectid [id of the subject]
     * @param  string $select    [description]
     * @return [type]            [bollean]
     */
    function get_sem3_pmtf($subjectid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_subject_summer_pmtf');
        $this->db->where('subjectid', $subjectid);
        $this->db->where('deleted_at', NULL);
        $query = $this->db->get();
        return $query->result();
    }

     /**
     * sem3 pmtf end
     */


    function get_subjects($query,$select='*'){

    	$subQueryx = $this->db->select('sf.subjectid')->from('pcc_gs_subject_fg_only sf')->where('deleted_at', NULL);
        $subQuery =  $subQueryx->get_compiled_select();


        $this->db->select($select);
        $this->db->from('pcc_subject s');
        $this->db->like('courseno', $query, 'after');
        $this->db->where("s.subjectid NOT IN ($subQuery)", NULL, FALSE);

        $query = $this->db->get();
        return $query->result();
    }


     function get_teachers($query,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff s');
        $this->db->like('LastName', $query, 'both');
        $this->db->where('teaching', '1');
        $this->db->order_by('LastName', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }








}