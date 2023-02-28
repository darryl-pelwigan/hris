<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

     function get_all_course($select='*'){
      
        $this->db->select($select);
        $this->db->from('pcc_courses c');
        $query = $this->db->get();
            return $query->result();
    }
    
    function get_student_list($select='*'){
      
        $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', ' r.studid=ei.studid ', 'LEFT');
        $this->db->join('pcc_courses c', ' ei.course=c.courseid ', 'LEFT');
        $this->db->join('pcc_student_types t', ' ei.student_type=t.id ', 'LEFT');
        $query = $this->db->get();
            return $query->result();
    }


    function get_student_list_filtered($sem,$sy,$course,$year,$select='*'){

        $subQueryx = $this->db->select('studid,sem,sy')->from('pcc_studpayment')->where('sem',$sem)->where('sy',$sy)->group_by('studid');
        $subQuery =  $subQueryx->get_compiled_select();

        $subQuery2x =  $this->db->select('studentid,sem,year')->from('pcc_studentsubj')->where('sem',$sem)->where('year',$sy)->group_by('studentid');
        $subQuery2 = $subQuery2x->get_compiled_select();

        $subQuery3x = $this->db->select('studid,sem,sy')->from('pcc_schedulelist')->where('sem',$sem)->where('sy',$sy)->group_by('studid');
        $subQuery3 =  $subQuery3x->get_compiled_select();

       

        $this->db->select($select);
            $this->db->from('pcc_registration r');
            $this->db->join('pcc_enrollment_info ei', 'r.studid = ei.studid ');
            $this->db->join('pcc_courses c', 'ei.course=c.courseid');
            $this->db->join('pcc_student_types t', 'ei.student_type=t.id');
            $this->db->join("($subQuery) as st", 'st.studid=ei.studid ', 'LEFT');
            $this->db->join("($subQuery2) as ss", 'r.studid=ss.studentid', 'LEFT');
            $this->db->where('ss.sem', $sem);
            $this->db->where('ss.year', $sy);

            if($course != 'All'){
                $this->db->where('ei.course', $course);
            }
        $this->db->order_by('r.lastname', 'ASC');
        
         $query =  $this->db->get();
         return $query->result();
        
    }

    function get_student_list_filteredx($sem,$sy,$select='*'){
        $query = $this->db->query('SELECT '.$select.' FROM pcc_registration r inner join  pcc_enrollment_info ei on ei.studid=r.studid 
                left join pcc_courses c on c.courseid=ei.course 
                left join pcc_student_types t on t.id=ei.student_type 
                left join (select studid, datepaid, sem, sy from pcc_studpayment where sem="'.$sem.'" AND sy="'.$sy.'" group by studid) as st on st.studid=ei.studid 
                left join (select studentid from pcc_studentsubj where sem="'.$sem.'" AND year="'.$sy.'" group by studentid) as ss on r.studid=ss.studentid 
                left join (select studentid from pcc_studaccount where sem="'.$sem.'" AND sy="'.$sy.'" group by studentid) as am on r.studid=am.studentid
                where  ei.sem="'.$sem.'"  AND  ei.sy="'.$sy.'"
                ');
         return $query->result();
    }
    
    function get_student_info($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_registration', array('studid' => $id),0, 1);
        
        return $query->result();
    }

    function get_student_infocie($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_registration r');
        $this->db->join('pcc_enrollment_info ei', ' r.studid=ei.studid ', 'LEFT');
        $this->db->join('pcc_courses c', ' ei.course=c.courseid ', 'LEFT');
        $this->db->where('r.studid', $id);
         $query = $this->db->get();
        
        return $query->result();
    }
   
}