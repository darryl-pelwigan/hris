<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_model_contg extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }



    /* Computation Type Start*/

    function get_tchr_cs_computation($sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_computation');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('type ' , $type);
        $query = $this->db->get();
        if($query->result()){return $query->result();}
        return FALSE;

    }

     function insert_tchr_cs_computation( $data){
         $this->db->insert('pcc_gs_tchr_computation', $data);
         echo $this->db->insert_id();
    }

    /* Computation Type End*/

    function get_cs($sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_contg');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

     function get_cs_one($cs_id,$sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_contg');
        $this->db->where('id', $cs_id);
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

   function create_sched_cs( $data ){
        $this->db->insert('pcc_gs_tchr_cs_contg', $data);
         echo $this->db->insert_id();
   }

    function delete_sched_cs($sched_id,$teacher_id,$cs_id,$type){
        $this->db->where('id', $cs_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->delete('pcc_gs_tchr_cs_contg');
        $this->del_cs_scores($sched_id,$teacher_id,$type,$cs_id);
         echo $this->db->affected_rows();
   }

   function update_sched_cs( $sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_date ){
        $this->db->set('items', $cs_items);
        $this->db->set('cs_date', $cs_date);
        $this->db->set('title', $cs_desc);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('id', $cs_id);
        $this->db->update('pcc_gs_tchr_cs_contg');
        echo $this->db->affected_rows();
    }

    function update_sched_cs_del_scores( $sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_date ){
        $this->db->set('items', $cs_items);
        $this->db->set('cs_date', $cs_date);
        $this->db->set('title', $cs_desc);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('id', $cs_id);
        $this->db->update('pcc_gs_tchr_cs_contg');
        $this->del_cs_scores($sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_date);
        echo $this->db->affected_rows();
    }

    function del_cs_scores($sched_id,$teacher_id,$type,$cs_id,$cs_desc=NUll,$cs_items=NUll,$cs_date=NUll){
        $this->db->where('cs_contg_id', $cs_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->delete('pcc_gs_tchr_cs_contg_scores');
         echo $this->db->affected_rows();
    }

    function get_student_cs($studentid,$cs_id,$sched_id,$type,$select='*' ){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_contg_scores');
        $this->db->where('student_id ' , $studentid);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cs_contg_id', $cs_id);
        $query = $this->db->get();
        return $query->result();
    }

    function update_student_cs( $studentid,$cs_id,$cs_items,$sched_id,$type  ){
        $this->db->set('score', $cs_items);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('student_id', $studentid);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cs_contg_id', $cs_id);
        $this->db->update('pcc_gs_tchr_cs_contg_scores');
        return $this->db->affected_rows();
    }

    function insert_student_cs( $studentid,$cs_id,$cs_items,$sched_id,$type ){
        $data = array(
            "sched_id" => $sched_id,
            "student_id" => $studentid,
            "cs_contg_id" => $cs_id,
            "score" => $cs_items,
            "date_created" => mdate('%Y-%m-%d %H:%i %a')
        );
         $this->db->insert('pcc_gs_tchr_cs_contg_scores', $data);
         return $this->db->insert_id();
    }

    function view_cs_items($teacher_id,$sched_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_contg');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('type ' , $type);
        $query = $this->db->get();
        $data['cs_i_query']=$query->result();
        $data['cs_i_num']=$query->num_rows();
        return $data;
    }


}