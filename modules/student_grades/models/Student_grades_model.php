<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_grades_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_subjects_year($studentid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->where('s.studentid', $studentid);
        $this->db->group_by('s.year');
        $query = $this->db->get();
            return $query->result();
    }

    function get_tsubjects_school($studentid,$school=NULL,$sem="NULL",$sy="NULL",$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_transfereesubj s');
        $this->db->where('s.studid', $studentid);
        if($sem!="NULL" && $sy!="NULL"){
            $this->db->where('s.sem', $sem);
            $this->db->where('s.sy', $sy);
        }elseif($sem=="NULL" && $sy!="NULL"){
            $this->db->where('s.sy', $sy);
        }
        if($school!=NULL)
            {$this->db->where('s.school', $school);}
        else
       	    {$this->db->group_by('s.school');}
        $query = $this->db->get();
            return $query->result();
    }
    
    function get_osubjects_school($studentid,$school=NULL,$sem="NULL",$sy="NULL",$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_oldstudent_grades s');
        $this->db->where('s.studid', $studentid);
        if($sem!="NULL" && $sy!="NULL"){
            $this->db->where('s.sem', $sem);
            $this->db->where('s.sy', $sy);
        }elseif($sem=="NULL" && $sy!="NULL"){
            $this->db->where('s.sy', $sy);
        }
        if($school!=NULL)
           { $this->db->where('s.school', $school);}
       else
       	    {$this->db->group_by('s.school');}
        $query = $this->db->get();
            return $query->result();
    }

    function get_stud_fgrades_persubject($sched_id,$student_id,$select='*'){


        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_student_final_grade fg','s.schedid = fg.sched_id');
        $this->db->join('pcc_schedulelist sc', 's.schedid = sc.schedid ');
        $this->db->join('pcc_subject sbj', 'sbj.courseno = sc.courseno ');
        $this->db->where('s.schedid', $sched_id);
        $this->db->where('s.studentid', $student_id);
        $this->db->where('fg.student_id', $student_id);
        $this->db->where('fg.sched_id', $sched_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_stud_fgrades_persubjectxx($sched_id,$student_id,$select='*'){


        $this->db->select($select);
        $this->db->from('pcc_student_final_grade fg');
        $this->db->where('fg.student_id', $student_id);
        $this->db->where('fg.sched_id', $sched_id);
        $query = $this->db->get();
        return $query->result();
    }

     function get_stud_fgrades($student_id,$sem="NULL",$sy="NULL",$select='*'){



        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_student_final_grade fg','s.schedid = fg.sched_id');
        $this->db->join('pcc_schedulelist sc', 's.schedid = sc.schedid ');
        $this->db->join('pcc_subject sbj', 'sbj.subjectid = sc.subjectid ');
        $this->db->where('fg.student_id', $student_id);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.year', $sy);
        $this->db->group_by('sc.courseno');
        $this->db->order_by('sc.courseno','desc');
        $query = $this->db->get();
        return $query->result();
    }


     function get_stud_fgrades_internships($student_id,$sem="NULL",$sy="NULL",$select='*'){

        $subQueryx = $this->db->select('sc.courseno')
                    ->from('pcc_studentsubj s')
                    ->join('pcc_schedulelist sc', 's.schedid = sc.schedid ')
                    ->join('pcc_student_final_grade fg','s.schedid = fg.sched_id')
                    ->where('fg.student_id', $student_id)
                    ->where('s.studentid', $student_id)
                    ->where('s.sem',$sem)
                    ->where('s.year',$sy)
                    ->group_by('sc.courseno');
        $subQuery =  $subQueryx->get_compiled_select();

       $subQueryxx = $this->db->select('sc.courseno')
                    ->from('pcc_studentsubj s')
                    ->join('pcc_schedulelist sc', 's.schedid = sc.schedid ')
                    ->join('pcc_gs_subject_fg_only fgo', 'sc.subjectid = fgo.subjectid ')
                    ->where('s.studentid', $student_id)
                    ->where('s.sem',$sem)
                    ->where('s.year',$sy)
                    ->group_by('sc.courseno');
        $subQueryy =  $subQueryxx->get_compiled_select();

        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_schedulelist sc', 's.schedid = sc.schedid ');
        $this->db->join('pcc_subject sbj', 'sbj.courseno = sc.courseno ');
        $this->db->where('s.studentid', $student_id);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.year', $sy);
        $this->db->where("sc.courseno NOT IN ($subQuery)", NULL, FALSE);
        $this->db->where("sc.courseno IN ($subQueryy)", NULL, FALSE);

        $this->db->group_by('sc.courseno');
        $this->db->order_by('sc.courseno','desc');
        $query = $this->db->get();

        return $query->result();
    }
    

      function get_student_grades_lec($studentid,$sem="NULL",$sy="NULL",$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_gs_student_gradeslec lc', 'lc.schedid = s.schedid ');
        $this->db->join('pcc_schedulelist sc', 'lc.schedid = sc.schedid ');
        $this->db->where('s.studentid=lc.studentid');
        $this->db->where('s.studentid', $studentid);
        if($sem!="NULL" && $sy!="NULL"){
            $this->db->where('sc.semester', $sem);
            $this->db->where('sc.schoolyear', $sy);
        }elseif($sem=="NULL" && $sy!="NULL"){
            $this->db->where('sc.schoolyear', $sy);
        }
        $query = $this->db->get();
            return $query->result();
    }

    function get_student_grades_leclab($studentid,$sem="NULL",$sy="NULL",$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_gs_student_gradesleclab lcb', 'lcb.schedid = s.schedid ');
        $this->db->join('pcc_schedulelist sc', 'lcb.schedid = sc.schedid ');
        $this->db->join('pcc_gs_subject_examlab se', 'lcb.schedid = se.schedid ');
        $this->db->where('s.studentid=lcb.studentid');
        $this->db->where('s.studentid', $studentid);
         if($sem!="NULL" && $sy!="NULL"){
            $this->db->where('sc.semester', $sem);
            $this->db->where('sc.schoolyear', $sy);
        }elseif($sem=="NULL" && $sy!="NULL"){
            $this->db->where('sc.schoolyear', $sy);
        }
       
        $query = $this->db->get();
            return $query->result();
    }

   
}