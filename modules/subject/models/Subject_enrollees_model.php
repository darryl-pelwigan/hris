<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_enrollees_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function check_fused($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->where_in('s.schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    function get_fused($fuse_id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_sched_fused f');
        $this->db->where('id', $fuse_id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_student_list($schedid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->join('pcc_registration r', 'r.studid = s.studentid ');
        $this->db->join('pcc_enrollment_info ei', 'r.studid = ei.studid ');
        $this->db->join('pcc_courses c', 'ei.course=c.courseid');
        $this->db->join('pcc_student_types t', 'ei.student_type=t.id');
        $this->db->where('s.schedid', $schedid);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.year', $sy);
        $this->db->where('s.subjdrop', '0');

        $this->db->order_by('r.lastname', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function check_assessment($studentid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studaccount s');
        $this->db->where('s.studentid', $studentid);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.sy', $sy);
        $query = $this->db->get();
        return $query->result();
    }

    function check_payment($studentid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studpayment s');
        $this->db->where('s.studid', $studentid);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.sy', $sy);
        $query = $this->db->get();
        return $query->result();
    }

    function get_search($sem,$sy,$group_by,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 's.course=c.courseid');
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->group_by($group_by);
        $query = $this->db->get();
        return $query->result();
    }

    function get_subjects($sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 's.course=c.courseid');
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->group_by('s.section, s.acadyear, s.yearlvl, s.course');
        $this->db->order_by('c.courseid,s.yearlvl,s.section', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function get_subjects_search($search_text,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 's.course=c.courseid',  'Left');
        $this->db->join('pcc_student_final_grade fg', 's.schedid = fg.sched_id');
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->where($search_text["type"], $search_text["value"]);
        $this->db->group_by('fg.sched_id');
        // $this->db->group_by('s.schedid');
        // $this->db->group_by('s.section, s.acadyear, s.yearlvl, s.course');
        $this->db->order_by('c.courseid,s.yearlvl,s.section', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

     function get_subjects_search2($search_text,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 's.course=c.courseid');
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->where($search_text["type"], $search_text["value"]);
        $this->db->order_by('c.courseid,s.yearlvl,s.section', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function get_subjects_search_teacher($teacherid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->join('pcc_courses c', 's.course=c.courseid');
        $this->db->join('pcc_teachersched t', 's.schedid=t.subjid');
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->where('t.teacherid', $teacherid);
        $this->db->group_by('s.section, s.acadyear, s.yearlvl, s.course');
        $this->db->order_by('c.courseid,s.yearlvl,s.section', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

     function get_subject_courseinfo($search_text,$section, $acadyear, $yearlvl, $course,$sem,$sy,$schedid='',$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        if($search_text["type"]==='t.teacherid'){
                $this->db->join('pcc_teachersched t', 's.schedid=t.subjid');
        }

        $this->db->where('s.section', $section);
        $this->db->where('s.acadyear', $acadyear);
        $this->db->where('s.yearlvl', $yearlvl);
        $this->db->where('s.course', $course);
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
         if($schedid != ''){
             $this->db->where('s.schedid', $schedid);
        }
        $this->db->where($search_text["type"], $search_text["value"]);
        $this->db->group_by('s.coursecode');
        $query = $this->db->get();
        return $query->result();
    }

    function get_subject_courseinfox($search_text,$section, $acadyear, $yearlvl, $course,$sem,$sy,$schedid='',$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        if($search_text["type"]==='t.teacherid'){
                $this->db->join('pcc_teachersched t', 's.schedid=t.subjid');
        }

        $this->db->where('s.section', $section);
        $this->db->where('s.acadyear', $acadyear);
        $this->db->where('s.yearlvl', $yearlvl);
        $this->db->where('s.course', $course);
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        if($schedid != ''){
             $this->db->where('s.schedid', $schedid);
        }
        $this->db->where($search_text["type"], $search_text["value"]);
        $query = $this->db->get();
        return $query->result();
    }

    function get_subject($section, $acadyear, $yearlvl, $course,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist s');
        $this->db->where('s.section', $section);
        $this->db->where('s.acadyear', $acadyear);
        $this->db->where('s.yearlvl', $yearlvl);
        $this->db->where('s.course', $course);
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->group_by('s.coursecode');
        $query = $this->db->get();
        return $query->result();
    }

     function get_subjectx($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_schedulelist sc');
        $this->db->join('pcc_subject s', 'sc.subjectid=s.subjectid');
        $this->db->where('sc.schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    function get_teacher_list($sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff e');
        $this->db->join('pcc_teachersched t', 't.teacherid=e.BiometricsID');
        $this->db->join('pcc_schedulelist s', 's.schedid=t.subjid');
        $this->db->where('s.semester', $sem);
        $this->db->where('s.schoolyear', $sy);
        $this->db->order_by("UPPER(e.LastName)","asc");
        $this->db->group_by('t.teacherid');
        $query = $this->db->get();
        return $query->result();
    }

    function get_teacher($schedid,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff e');
        $this->db->join('pcc_teachersched t', 't.teacherid=e.BiometricsID');
        $this->db->where('t.subjid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    function count_subject_student($schedid,$sem,$sy,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_studentsubj s');
        $this->db->where('s.schedid', $schedid);
        $this->db->where('s.sem', $sem);
        $this->db->where('s.year', $sy);
        $this->db->where('s.subjdrop', "0");
        $query = $this->db->get();
        return $query->num_rows();
    }

}