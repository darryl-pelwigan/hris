<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_model extends CI_Model {

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
        if($type !== 'f'){
            $this->db->where('type ' , $type);
        }
        $query = $this->db->get();
        if($query->result()){return $query->result();}
        elseif($type=='final'){return array(0=>(object) ['comp_type'=>'final']);}
        else{return FALSE;}


    }

     function insert_tchr_cs_computation( $data){
         $this->db->insert('pcc_gs_tchr_computation', $data);
         echo $this->db->insert_id();
    }

    /* Computation Type End*/

    function get_cs($sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs');
        $this->db->where('schedid ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }



   function create_sched_cs( $data ){
        $this->db->insert('pcc_gs_tchr_cs', $data);
         echo $this->db->insert_id();
   }

    function delete_sched_cs($sched_id,$teacher_id,$cs_id ){
        $this->db->where('id', $cs_id);
        $this->db->where('schedid', $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->delete('pcc_gs_tchr_cs');

        $this->delete_cs_item($sched_id,$cs_id);


         echo $this->db->affected_rows();
   }

   function update_sched_cs( $sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_prcnt ){
        $this->db->set('items', $cs_items);
        $this->db->set('percent', $cs_prcnt);
        $this->db->set('description', $cs_desc);
        $this->db->set('last_updated', 'NOW()', FALSE);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('schedid', $sched_id);
        $this->db->where('id', $cs_id);
        $this->db->update('pcc_gs_tchr_cs');
        echo $this->db->affected_rows();
    }

    function get_student_cs($studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type ){
        $this->db->select('sc_score');
        $this->db->from('pcc_gs_tchr_csscore');
        $this->db->where('stud_id ' , $studentid);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cs_id ' , $cs_id);
        $this->db->where('cs_i_id ' , $cs_i_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function update_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type  ){
        $this->db->set('sc_score', $cs_items);
        $this->db->set('last_updated', 'NOW()', FALSE);
        $this->db->where('stud_id', $studentid);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cs_id', $cs_id);
        $this->db->where('cs_i_id ' , $cs_i_id);
        $this->db->update('pcc_gs_tchr_csscore');
        return $this->db->affected_rows();
    }

    function insert_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type ){
        $data = array(
            "sched_id" => $sched_id,
            "stud_id" => $studentid,
            "cs_id" => $cs_id,
            "cs_i_id" => $cs_i_id,
            "sc_score" => $cs_items,
            "date_created" => mdate('%Y-%m-%d %H:%i %a')
        );
         $this->db->insert('pcc_gs_tchr_csscore', $data);
         return $this->db->insert_id();
    }

    function count_cs_items($teacher_id,$sched_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_items i');
        $this->db->join('pcc_gs_tchr_cs cs', 'i.sched_id = cs.schedid ');
        $this->db->where('i.sched_id ' , $sched_id);
        $this->db->where('cs.type ' , $type);
        $query = $this->db->get();
        $data['cs_i_query']=$query->result();
        $data['cs_i_num']=$query->num_rows();
        return $data;
    }

    function view_cs_items($teacher_id,$sched_id,$cs_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_items');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('cs_id ' , $cs_id);
        $query = $this->db->get();
        $data['cs_i_query']=$query->result();
        $data['cs_i_num']=$query->num_rows();
        return $data;
    }

    function add_cs_items( $data ){
        $this->db->insert('pcc_gs_tchr_items', $data);
   }

   function edit_cs_item($sched_id,$type,$cs_id,$cs_i_id,$title,$items){
        $this->db->set('title', $title);
        $this->db->set('items', $items);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cs_id', $cs_id);
        $this->db->where('id ' , $cs_i_id);
        $this->db->update('pcc_gs_tchr_items');
        return $this->db->affected_rows();
   }

       function delete_cs_item($sched_id,$cs_id, $cs_i_id=NULL ){
        if($cs_i_id!=NULL){$this->db->where('id ' , $cs_i_id);}
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cs_id', $cs_id);
        $this->db->delete('pcc_gs_tchr_items');
        $this->delete_student_cs_score($sched_id,$cs_id);
         echo $this->db->affected_rows();
   }

    function delete_student_cs_score($sched_id,$cs_id, $cs_i_id=NULL , $studentid = NULL ){
        if($studentid!=NULL){$this->db->where('stud_id ' , $studentid);}
        if($cs_i_id!=NULL){$this->db->where('cs_i_id ' , $cs_i_id);}
        $this->db->where('cs_id', $cs_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->delete('pcc_gs_tchr_csscore');
         echo $this->db->affected_rows();
   }

   /*cs templates start*/

   function get_cs_template($cs_template_id='',$college_id='',$check_sched,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_cs_templates');
        if($cs_template_id!=''){
            $this->db->where('id ' , $cs_template_id);
        }
        if($college_id!=''){
            $this->db->where('college_id ' , $college_id);
        }

         if($check_sched[0]['lecunits']>0 && $check_sched['labunits'] == 0 ){
             $this->db->where('lec IS NOT NULL');
        }elseif($check_sched[0]['lecunits']==0 && $check_sched['labunits'] >0 ){
             $this->db->where('lab IS NOT NULL');
        }else{
             $this->db->where('lab IS NOT NULL');
             $this->db->where('lec IS NOT NULL');
        }

        $query = $this->db->get();
        return $query->result();
   }

      function set_cs_template($cs_template_id=NULL,$college_id=NULL,$select='*'){

   }

   function create_cs_template($data){
         $this->db->insert('pcc_gs_cs_templates', $data);
         return $this->db->insert_id();
   }

    /*cs templates end*/

}