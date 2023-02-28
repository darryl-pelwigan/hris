<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Grades_submission_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_grade_submission($sy,$sem,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_grade_submission');
        $this->db->where('sem' , $sem);
        $this->db->where('sy' , $sy);
        $this->db->where('type' , $type);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function update_grades_submission( $sy,$sem,$type, $data   ){
        $this->db->where('sem' , $sem);
        $this->db->where('sy' , $sy);
        $this->db->where('type' , $type);
        $this->db->update('pcc_gs_grade_submission', $data);
        echo $this->db->insert_id();
    }

    function insert_grades_submission( $data   ){

        $this->db->insert('pcc_gs_grade_submission', $data);
        echo $this->db->insert_id();
    }

      function st_get_grade_submission($sy,$sem,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_student_view_grades');
        $this->db->where('sem' , $sem);
        $this->db->where('sy' , $sy);
        $this->db->where('type' , $type);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    // $this->db->set('final_remarks', $remarks);

    function st_update_grades_submission( $sy,$sem,$type, $data   ){
        $this->db->where('sem' , $sem);
        $this->db->where('sy' , $sy);
        $this->db->where('type' , $type);
        $this->db->update('pcc_gs_student_view_grades', $data);
        echo $this->db->insert_id();
    }

    function st_insert_grades_submission( $data   ){

        $this->db->insert('pcc_gs_student_view_grades', $data);
        echo $this->db->insert_id();
    }

    function sloweeee(){
        $x = rand(60, 180);
        // sleep($x);
    }


    /**
     * Student view grades
     */
    
    function get_st_viewgrades($sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_view_grades_smsy');
        $this->db->where('sem' , $sem);
        $this->db->where('sy' , $sy);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_st_viewgrades_subject($subjectid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_view_grades_smsy');
        $this->db->where('subjectid' , $subjectid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_st_viewgrades_subject_update( $data   ){
        $this->db->where('subjectid' , $data['subjectid']);
        $this->db->update('pcc_gs_view_grades_smsy', $data);
    }

    function get_st_viewgrades_subject_insert( $data){
        $this->db->insert('pcc_gs_view_grades_smsy', $data);
    }





}