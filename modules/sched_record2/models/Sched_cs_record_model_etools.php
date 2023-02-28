<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_model_etools extends CI_Model {

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

    function get_cs($sched_id,$teacher_id,$type,$etool_id='',$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_sched_etools');
        if($etool_id!=''){$this->db->where('etools_id ' , $etool_id);}
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('cs_type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function delete_sched_cs( $sched_id,$teacher_id,$etool_id,$type ){
        $this->db->where('etools_id', $etool_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->delete('pcc_gs_tchr_cs_sched_etools');
        $this->del_cs_scores($sched_id,$teacher_id,$type,$etool_id);
         echo $this->db->affected_rows();
    }

    function del_cs_scores($sched_id,$teacher_id,$type,$etool_id){
        $this->db->where('sched_etools_id', $etool_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->delete('pcc_gs_tchr_cs_sched_etools_score');
        echo $this->db->affected_rows();
    }

    function get_cs_sched($sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_sched_etools se');
        $this->db->join('pcc_gs_tchr_cs_evtool ev', 'ev.id = se.etools_id ');
        $this->db->where('se.sched_id ' , $sched_id);
        $this->db->where('se.teacher_id ' , $teacher_id);
        $this->db->where('se.cs_type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_etools($etools_id='',$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_evtool');
        if($etools_id!=''){$this->db->where('id ' , $etools_id);}
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_etools_cats($etools_id='',$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_evcats');
        $this->db->where('evtools_id ' , $etools_id);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_etools_cats_items($etools_id='',$etools_cats_id='',$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_evitems');
        $this->db->where('evtools_id ' , $etools_id);
        $this->db->where('evcats_id ' , $etools_cats_id);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function save_sched_cs($data){
        $this->db->insert('pcc_gs_tchr_cs_sched_etools', $data);
         return $this->db->insert_id();
    }

    function etools_stu_score($sched_id,$etools_id,$studentid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_sched_etools_score ');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('sched_etools_id ' , $etools_id);
        $this->db->where('student_id ' , $studentid);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_agency($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_evtool_agncy ');
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $data;
    }

    function get_clinical_area($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_evtool_ca ');
        $query = $this->db->get();
        $data['query']=$query->result();
        $data['num']=$query->num_rows();
        return $data;
    }


    function save_student_etools_score($data){
        $this->db->insert('pcc_gs_tchr_cs_sched_etools_score', $data);
        return $this->db->insert_id();
    }

    function update_student_etools_score($sched_id,$etool_id,$studentid,$data){
        $this->db->where('sched_id', $sched_id);
        $this->db->where('sched_etools_id', $etool_id);
        $this->db->where('student_id', $studentid);
        $this->db->update('pcc_gs_tchr_cs_sched_etools_score', $data);
        echo $this->db->affected_rows();
    }


}