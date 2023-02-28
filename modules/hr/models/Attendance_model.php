<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Attendance_model extends CI_Model {

    function get_timekeeping_records($fdate, $tdate){
        $this->db->select('b.*, s.fileno, s.firstname, s.lastname, d.deptname, p.position');
        $this->db->from('biometrics_tbl b');  
        $this->db->join('pcc_staff s', 's.biometricsid=b.badgenumber', 'left');      
        $this->db->join('pcc_departments d', 'd.deptid=s.department', 'left');
        $this->db->join('pcc_position p', 'p.id=s.positionrank', 'left');      
        if($fdate != '1970-01-01'){
            $this->db->where('date_format(b.datetime, "%Y-%m-%d") >=', $fdate);
            $this->db->where('date_format(b.datetime, "%Y-%m-%d") <=', $tdate);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    
    function get_attendance_records($fdate, $tdate, $teaching, $department){
        $this->db->select('a.*, s.fileno, s.firstname, s.lastname, d.deptname, p.position, s.teaching');
        $this->db->from('pcc_staff_attendance a');  
        $this->db->join('pcc_staff s', 's.biometricsid=a.biono', 'left');      
        $this->db->join('pcc_departments d', 'd.deptid=s.department', 'left');
        $this->db->join('pcc_position p', 'p.id=s.positionrank', 'left');      
        if($fdate != '1970-01-01'){
            $this->db->where('date_format(a.date, "%Y-%m-%d") >=', $fdate);
            $this->db->where('date_format(a.date, "%Y-%m-%d") <=', $tdate);           
        }
        $this->db->where('s.teaching', $teaching);
        if($department !=  0){
            $this->db->where('s.department', $department);
        }
        $this->db->where('s.teaching', $teaching);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_timekeeping_records($date, $biono){
        $this->db->select('*');
        $this->db->from('biometrics_tbl');      
        $this->db->where('date_format(biometrics_tbl.datetime, "%Y-%m-%d") = ', $date);
        $this->db->where('biometrics_tbl.badgenumber', $biono);
        $this->db->order_by('biometrics_tbl.datetime', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_schedule($biono){
        $this->db->select('*');
        $this->db->from('pcc_staff_scheduling');  
        if($biono > 0){
            $this->db->where('pcc_staff_scheduling.biono' , $biono);
        }    
        $this->db->order_by('pcc_staff_scheduling.timein_am', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    
    function get_emp_schedule_teaching($biono, $sem, $sy){
        $this->db->select('s.start, s.end, s.days');
        $this->db->from('pcc_teachersched ts');  
        $this->db->join('pcc_schedulelist s', 's.schedid=ts.subjid', 'left');
        $this->db->where('ts.teacherid' , $biono);
        $this->db->where('s.semester' , $sem);
        $this->db->where('s.schoolyear' , $sy);
        $this->db->where('s.start !=' , '');
        $this->db->order_by('s.start', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_staff_attendance($data){
        $this->db->insert('pcc_staff_attendance', $data);
        return $this->db->insert_id();
    }

    function get_staff_attendance($id, $date) {
        $this->db->select('*');
        $this->db->from('pcc_staff_attendance');
        $this->db->where('biono', $id);
        $this->db->where('date', $date);
        $query = $this->db->get();
        return $query->result();
    }

    function update_emp_attendance($id, $date, $status){
        $this->db->set('datetime', $date);
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('biometrics_tbl');
        return $this->db->affected_rows();
    }

    function insert_emp_attendance($data){
        $this->db->insert('biometrics_tbl', $data);
        return $this->db->insert_id();
    }

    function update_staff_attendance($date, $biono, $attendance, $totalhours){
        $this->db->set('totalhours', $attendance['totalhours']);
        $this->db->set('tardiness', $attendance['totaltardy']);
        $this->db->set('overtime', $attendance['totalovertime']);
        $this->db->set('undertime', $attendance['totalundertime']);
        $this->db->where('biono', $biono);
        $this->db->where('date', $date);
        $this->db->update('pcc_staff_attendance');
        return $this->db->affected_rows();
    }


    function get_staff_scheduling(){
        $this->db->select('*');
        $this->db->from('pcc_staff_scheduling sched'); 
        $this->db->join('pcc_staff staff', 'sched.biono = staff.BiometricsID'); 
        $this->db->join('pcc_departments dept', 'staff.department = dept.DEPTID', 'left'); 
        $this->db->where('staff.teaching', 0); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;        
    }

    function get_emp_staff_scheduling ($id){
        $this->db->select('*');
        $this->db->from('pcc_staff_scheduling sched'); 
        $this->db->join('pcc_staff staff', 'sched.biono = staff.BiometricsID'); 
        $this->db->where('sched.id', $id); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;   
    }


    function update_staff_schedule($data, $id){
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_scheduling', $data);
        return true;

    }

    function del_staff_schedule($id){
        $this->db->where('id', $id);
        return $this->db->delete('pcc_staff_scheduling');
    }

    function get_check_staff_attendance($biono){
        $this->db->select('*');
        $this->db->from('pcc_staff_scheduling sched'); 
        $this->db->where('biono', $biono); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;  
    }

    function get_emp_staff_name_lists(){
        $this->db->select('BiometricsID, FirstName, MiddleName, LastName');
        $this->db->from('pcc_staff'); 
        $this->db->order_by('LastName', 'ASC'); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;     
    }

    function get_emp_staff_name_non_teaching_lists(){
        $this->db->select('BiometricsID, FirstName, MiddleName, LastName');
        $this->db->from('pcc_staff'); 
        $this->db->where('teaching', 0); 
        $this->db->order_by('LastName', 'ASC'); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;     
    }

    function get_emp_staff_name_teaching_lists(){
        $this->db->select('BiometricsID, FirstName, MiddleName, LastName');
        $this->db->from('pcc_staff'); 
        $this->db->where('teaching', 1); 
        $this->db->order_by('LastName', 'ASC'); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;    
    }

    function insert_staff_schedule($data){
        $this->db->insert('pcc_staff_scheduling', $data);
        return $this->db->insert_id();
    }

    function get_emp_staff_scheduling_teaching($year, $semester){

        $this->db->select('*');
        $this->db->from('pcc_teachersched a'); 
        $this->db->join('pcc_staff b', 'b.BiometricsID = a.teacherid'); 
        $this->db->join('pcc_schedulelist c', 'c.schedid = a.subjid', 'left'); 
        $this->db->join('pcc_departments d', 'd.DEPTID = b.department', 'left'); 
        $this->db->group_by('a.teacherid'); 
        $this->db->where('b.teaching', 1); 
        $this->db->where('c.schoolyear', $year); 
        $this->db->where('c.semester', $semester); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;   

    }

    function delete_attendance($id){
        $this->db->where('id', $id);
        return $this->db->delete('biometrics_tbl');
    }

    function update_attendance($attendance_id, $value, $col){
        $this->db->set($col, $value);
        $this->db->where('id', $attendance_id);
        $this->db->update('pcc_staff_attendance');
        return $this->db->affected_rows();

    }

    function get_staff_teaching_schedule($fileno, $year, $semester){
        $this->db->select('*');
        $this->db->from('pcc_teachersched a'); 
        $this->db->join('pcc_staff b', 'b.BiometricsID = a.teacherid'); 
        $this->db->join('pcc_schedulelist c', 'c.schedid = a.subjid', 'left'); 
        $this->db->join('pcc_departments d', 'd.DEPTID = b.department', 'left'); 
        $this->db->join('pcc_courses e', 'e.courseid = c.courseid', 'left'); 
        $this->db->where('b.teaching', 1); 
        $this->db->where('b.FileNo', $fileno); 
        $this->db->where('c.schoolyear', $year); 
        $this->db->where('c.semester', $semester); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;  
    }

    function get_students($schedid, $year, $semester){
        $this->db->select('id');
        $this->db->from('pcc_studentsubj '); 
        $this->db->where('schedid', $schedid); 
        $this->db->where('year', $year); 
        $this->db->where('sem', $semester); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;  
    }

    function insert_attendance_biometrics($data){
        $this->db->insert('biometrics_tbl', $data);
        return $this->db->insert_id();

    }

    function get_staff_attendance_biometrics($data, $time){

        $this->db->select('*');
        $this->db->from('biometrics_tbl'); 
        $this->db->where('badgenumber', $data['badgenumber']); 
        $this->db->where('verifycode', $data['verifycode']); 
        $this->db->where('datetime', $data['datetime']);
        $query = $this->db->get(); 
        return $query->result()?$query->result():false;

    }

    function get_biometrics_records($fdate, $tdate, $teaching, $department){
        $this->db->select('a.*, s.fileno, s.firstname, s.lastname, d.deptname, p.position, s.teaching');
        $this->db->from('biometrics_tbl a');
        $this->db->join('pcc_staff s', 's.biometricsid=a.badgenumber', 'left');
        $this->db->join('pcc_departments d', 'd.deptid=s.department', 'left');
        $this->db->join('pcc_position p', 'p.id=s.positionrank', 'left'); 
        if($fdate != '1970-01-01'){
            $this->db->where('date_format(a.datetime, "%Y-%m-%d") >=', $fdate);
            $this->db->where('date_format(a.datetime, "%Y-%m-%d") <=', $tdate);           
        }
        if($department !=  0){
            $this->db->where('s.department', $department);
        }
        $this->db->order_by('a.id','asc');
        // $this->db->order_by('s.lastname','asc');
        // $this->db->order_by('a.datetime','desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function check_staff_attendance($bio_no, $date){
        $this->db->select('*');
        $this->db->from('pcc_staff_attendance');
        $this->db->where('biono', $bio_no);
        $this->db->where('date', $date);
        $query = $this->db->get();
        return $query->result()?$query->result():false; 
    }

    function check_staff_biometrics($bio_no, $date){
        $this->db->select('*');
        $this->db->from('biometrics_tbl');
        $this->db->where('badgenumber', $bio_no);
        $this->db->like('datetime', $date);
        $query = $this->db->get();
        return $query->result()?$query->result():false; 
    }


    function get_attendance_inserted($bio_no, $date){
        $this->db->select('*');
        $this->db->from('biometrics_tbl');
        $this->db->where('badgenumber', $bio_no);
        $this->db->like('datetime', $date);
        $this->db->order_by('datetime', 'ASC');
        $query = $this->db->get();

        return $query->result()?$query->result_array():false;
    }

    function check_nature_employement($bio_no){
        $this->db->select('teaching');
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid', $bio_no);
        $query = $this->db->get();
        return $query->row()?$query->row():false;
    }


}