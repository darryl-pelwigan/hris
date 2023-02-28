<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_grades_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_sched_excel_list($sched_id,$select='*'){

        $this->db->select($select);
        $this->db->from('pcc_student_final_grade_excel_files');
         $this->db->where('sched_id', $sched_id);
        $query = $this->db->get();
            return $query->result();
    }

    function get_sched_excel($sched_id,$teacher_id,$file_name,$ftype,$select='*'){

        $this->db->select($select);
        $this->db->from('pcc_student_final_grade_excel_files');
        $this->db->where('sched_id', $sched_id);
        $this->db->where('submitted_by', $teacher_id);
        $this->db->where('excel_file', $file_name);
        // $this->db->where('file_extension', $file_extn);
        $this->db->where('for_type', $ftype);
        $query = $this->db->get();
            return $query->result();
    }



    function get_sched_excel1($file_id,$select='*'){

        $this->db->select($select);
        $this->db->from('pcc_student_final_grade_excel_files');
        $this->db->where('id', $file_id);
        $query = $this->db->get();
            return $query->result();
    }

    function get_sched_exce2($sched_id,$teacher_id,$ftype,$select='*'){

        $this->db->select($select);
        $this->db->from('pcc_student_final_grade_excel_files');
        $this->db->where('sched_id', $sched_id);
        $this->db->where('submitted_by', $teacher_id);
        $this->db->where('for_type', $ftype);
        $query = $this->db->get();
            return $query->result();
    }

    function insert_sched_excel($data){
        $this->db->insert('pcc_student_final_grade_excel_files', $data);
         return $this->db->insert_id();
    }

    function update_sched_excel($sched_id,$teacher_id,$file_name,$ftype){

        $this->db->set('updated_at', 'NOW()', FALSE);
        $this->db->where('submitted_by', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('excel_file', $file_name);
        $this->db->where('for_type', $ftype);
        $this->db->update('pcc_student_final_grade_excel_files');
        return $this->db->affected_rows();
    }

    function delete_excel($schedid){
        $this->db->set('deleted_at','NOW()', FALSE);
        $this->db->where('sched_id', $schedid);
        $this->db->update('pcc_student_final_grade_excel_files');
        return $this->db->affected_rows();
    }

    function update_grades_remarks($sched_id,$teacher_id,$studentid,$remarks){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('remarks', $remarks );
        $this->db->set('submitted_by', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('student_id', $studentid);
        $this->db->update('pcc_student_final_grade');
        return $this->db->affected_rows();
    }

    function update_grades_final($schedid,$student_id,$final){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('final', $final);
        $this->db->where('sched_id', $schedid);
        $this->db->where('student_id', $student_id);
        $this->db->update('pcc_student_final_grade');
        return $this->db->affected_rows();
    }


    /* get student info*/
   function get_student_info($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_registration');
        $this->db->where('studid', $id);
        $query = $this->db->get();
            return $query->result();
    }


    function get_grade_review( $sched_id, $select='*'){
        $this->db->select( $select );
        $this->db->from('pcc_student_final_grade_review_approved s');
        $this->db->where('s.sched_id', $sched_id);
        $query = $this->db->get();
            return $query->result();
    }


    function set_grade_review( $data ){
        $this->db->insert('pcc_student_final_grade_review_approved', $data);
         return $this->db->insert_id();
    }


    function submit_grade_review($sched_id,$teacher_id,$type){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('submit_'.$type, 'NOW()', FALSE );
        $this->db->set('submitted_by', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->update('pcc_student_final_grade_review_approved');
        return $this->db->affected_rows();
    }


    function checkdean_grade_review($sched_id,$dean_id,$type){
        $this->db->set('checkdean_id', $dean_id);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('checkdean_'.$type, 'NOW()', FALSE );
        $this->db->where('sched_id', $sched_id);
        $this->db->update('pcc_student_final_grade_review_approved');
        return $this->db->affected_rows();
    }

    function checkregistrar_grade_review($sched_id,$registrar_id,$type){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('checkregistrar_'.$type, 'NOW()', FALSE );
        $this->db->where('sched_id', $sched_id);
        $this->db->update('pcc_student_final_grade_review_approved');
        return $this->db->affected_rows();
    }

    function submit_grade_request_update($sched_id,$teacher_id,$type,$message){
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->set('requ_'.$type, 'NOW()' , FALSE );
        $this->db->set('requ_'.$type.'_remarks', $message );
        $this->db->where('submitted_by', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->update('pcc_student_final_grade_review_approved');
        return $this->db->affected_rows();
    }
}
