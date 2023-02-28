<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_model_wsub extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_all_items($sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats c');
        $this->db->join('pcc_gs_tchr_cs_cats_subs cs', 'c.id = cs.cats_id ');
        $this->db->join('pcc_gs_tchr_cs_cats_subs csi', 'c.id = csi.cats_id ');
        $this->db->where('c.sched_id ' , $sched_id);
        $this->db->where('c.teacher_id ' , $teacher_id);
        $this->db->where('c.type ' , $type);
        $query = $this->db->get();
        if($query->result()){
          $data['cs_query']=$query->result();
          $data['cs_num']=$query->num_rows();
          return $data;
        }
        return FALSE;
    }


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
        $this->db->from('pcc_gs_tchr_cs_cats');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

   function create_sched_cs_cats( $data ){
        $this->db->insert('pcc_gs_tchr_cs_cats', $data);
         echo $this->db->insert_id();
   }


   // sub category
  function get_cs_sub($sched_id,$teacher_id,$cats_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats_subs');
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('cats_id ' , $cats_id);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

    function get_cs_sub_f($sched_id,$teacher_id,$type,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats c');
        $this->db->join('pcc_gs_tchr_cs_cats_subs cs', 'c.id = cs.cats_id ');
        $this->db->where('c.type ' , $type);
        $this->db->where('c.sched_id ' , $sched_id);
        # $this->db->group_by('cs.description');
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
    }

  function create_sched_cs_subs( $data ){
        $this->db->insert('pcc_gs_tchr_cs_cats_subs', $data);
         echo $this->db->insert_id();
   }

  function get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id,$select='*'){
      $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats_items');
        $this->db->where('teacher_id ' , $teacher_id);
        $this->db->where('sched_id ' , $sched_id);
        $this->db->where('cats_id ' , $cats_id);
        $this->db->where('cs_csub_id ' , $cs_csub_id);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
   }

   function get_cs_sub_items_f($sched_id,$teacher_id,$type,$select='*'){
      $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats_items ci');
        $this->db->join('pcc_gs_tchr_cs_cats c', 'c.id = ci.cats_id ');
        $this->db->join('pcc_gs_tchr_cs_cats_subs cs', 'ci.cs_csub_id = cs.id ');
        $this->db->where('c.type ' , $type);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
   }

      function get_cs_sub_items_fx($sched_id,$teacher_id,$cats_id,$type,$select='*'){
      $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats_items ci');
        $this->db->join('pcc_gs_tchr_cs_cats c', 'c.id = ci.cats_id ');
        $this->db->join('pcc_gs_tchr_cs_cats_subs cs', 'ci.cs_csub_id = cs.id ');
        $this->db->where('c.type ' , $type);
        $this->db->where('ci.cats_id ' , $cats_id);
        $query = $this->db->get();
        $data['cs_query']=$query->result();
        $data['cs_num']=$query->num_rows();
        return $data;
   }

  function create_cs_sub_items($data){
          $this->db->insert('pcc_gs_tchr_cs_cats_items', $data);
         echo $this->db->insert_id();
   }

   function update_cs_sub_items($teacher_id,$cats_id,$sub_id,$cs_id,$sched_id,$cs_desc,$cs_items,$cs_date){
        $this->db->set('items', $cs_items);
        $this->db->set('cs_date', $cs_date);
        $this->db->set('title', $cs_desc);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cats_id', $cats_id);
        $this->db->where('cs_csub_id', $sub_id);
        $this->db->where('id', $cs_id);
        $this->db->update('pcc_gs_tchr_cs_cats_items');
        echo $this->db->affected_rows();
   }

   function update_cs_cats($teacher_id,$cats_id,$sched_id,$cs_desc,$cs_percent){
        $this->db->set('description', $cs_desc);
        $this->db->set('percent', $cs_percent);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('id', $cats_id);
        $this->db->update('pcc_gs_tchr_cs_cats');
        echo $this->db->affected_rows();
   }

   function update_cs_subs($teacher_id,$cats_id,$sub_id,$sched_id,$cs_desc,$cs_percent){
        $this->db->set('description', $cs_desc);
        $this->db->set('percent', $cs_percent);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('sched_id', $sched_id);
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('cats_id', $cats_id);
        $this->db->where('id', $sub_id);
        $this->db->update('pcc_gs_tchr_cs_cats_subs');
        echo $this->db->affected_rows();
   }

function delete_cats($teacher_id,$cats_id,$sched_id){
  $this->db->where('id', $cats_id);
  $this->db->where('sched_id', $sched_id);
  $this->db->where('teacher_id ' , $teacher_id);
  $this->db->delete('pcc_gs_tchr_cs_cats');
  echo $this->db->affected_rows();
  $this->delete_subs($teacher_id,$cats_id,$sched_id);

}

function delete_subs($teacher_id,$cats_id,$sched_id,$sub_id=NULL){
  if($sub_id!=NULL){$this->db->where('id', $sub_id);}
      $this->db->where('cats_id', $cats_id);
      $this->db->where('sched_id', $sched_id);
      $this->db->where('teacher_id ' , $teacher_id);
      $this->db->delete('pcc_gs_tchr_cs_cats_subs');
      echo  $this->db->affected_rows();
      $this->delete_items($teacher_id,$cats_id,$sched_id,$sub_id);
}

function delete_items($teacher_id,$cats_id,$sched_id,$sub_id,$cs_id=NULL){
  if($cs_id!=NULL){$this->db->where('id', $cs_id);}
  if($sub_id!=NULL){$this->db->where('cs_csub_id', $sub_id);}
      $this->db->where('cats_id', $cats_id);
      $this->db->where('sched_id', $sched_id);
      $this->db->where('teacher_id ' , $teacher_id);
      $this->db->delete('pcc_gs_tchr_cs_cats_items');
       echo $this->db->affected_rows();
       $this->delete_items_score($teacher_id,$cats_id,$sched_id,$sub_id,$cs_id);
}

function delete_items_score($teacher_id,$cats_id,$sched_id,$sub_id,$cs_id=NULL){
  if($sub_id!=NULL){$this->db->where('cs_csub_id', $sub_id);}
  if($cs_id!=NULL){$this->db->where('cs_cats_items_id', $cs_id);}
      $this->db->where('cats_id', $cats_id);
      $this->db->where('sched_id', $sched_id);
      $this->db->delete('pcc_gs_tchr_cs_cats_scores');
       echo $this->db->affected_rows();
}

function get_cs_score( $labunits , $stud_id ,$sched_id, $cats_id ,$cs_csub_id ,$cs_i_id, $type , $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats_scores');
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cats_id ' , $cats_id);
        $this->db->where('cs_csub_id ' , $cs_csub_id);
        $this->db->where('cs_cats_items_id ' , $cs_i_id);
        $this->db->where('student_id ' , $stud_id);
         $query = $this->db->get();
           return $query->result();
    }

    // updating student cs score
    function get_student_cs($studentid,$cats_id,$cs_csub_id,$cs_items_id,$sched_id,$type,$select='*' ){
        $this->db->select($select);
        $this->db->from('pcc_gs_tchr_cs_cats_scores');
        $this->db->where('sched_id', $sched_id);
        $this->db->where('cats_id ' , $cats_id);
        $this->db->where('cs_csub_id ' , $cs_csub_id);
        $this->db->where('cs_cats_items_id ' , $cs_items_id);
        $this->db->where('student_id ' , $studentid);
        $query = $this->db->get();
        return $query->result();
    }

    function update_student_cs( $studentid,$cats_id,$cs_csub_id,$cs_items_id,$cs_items,$sched_id,$type  ){
        $this->db->set('cs_score', $cs_items);
        $this->db->set('date_updated', 'NOW()', FALSE);
        $this->db->where('sched_id', $sched_id);
         $this->db->where('cats_id ' , $cats_id);
        $this->db->where('cs_csub_id ' , $cs_csub_id);
        $this->db->where('cs_cats_items_id ' , $cs_items_id);
        $this->db->where('student_id', $studentid);
        $this->db->update('pcc_gs_tchr_cs_cats_scores');
        return $this->db->affected_rows();
    }

    function insert_student_cs( $studentid,$cats_id,$cs_csub_id,$cs_items_id,$cs_items,$sched_id,$type ){
        $data = array(
            "sched_id" => $sched_id,
            "cats_id" => $cats_id,
            "cs_csub_id" => $cs_csub_id,
            "cs_cats_items_id" => $cs_items_id,
            "student_id" => $studentid,
            "cs_score" => $cs_items,
            "date_created" => mdate('%Y-%m-%d %H:%i %a')
        );
         $this->db->insert('pcc_gs_tchr_cs_cats_scores', $data);
         return $this->db->insert_id();
    }
}