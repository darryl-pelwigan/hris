<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Profile_model extends CI_Model {

    function insert_add_emp($array_insert){
        $this->db->insert('pcc_staff',($array_insert));
        return $this->db->insert_id();
    }

     function insert_emp_dpndnt_records($array_insert){
          $this->db->insert('pcc_staff_dependent',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_dpndnt_records($staff,$depid,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $depid);
        $this->db->update('pcc_staff_dependent');
        return $this->db->affected_rows();
    }

    function insert_emp_appointment_records($array_insert){
        $this->db->insert('pcc_staff_appointment',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_appointment_records($staff,$appid,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $appid);
        $this->db->update('pcc_staff_appointment');
        return $this->db->affected_rows();
    }

    function insert_emp_educ_records($array_insert){
        $this->db->insert('pcc_staff_educ_background',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_educ_records($staff,$id,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_educ_background');
        return $this->db->affected_rows();
    }

    function insert_emp_eligibilities_records($array_insert){
        $this->db->insert('pcc_staff_eligibility',($array_insert));
        return $this->db->insert_id();
    }

    function update_emp_eligibilities_records($staff,$id,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_eligibility');
        return $this->db->affected_rows();
    }

    function update_emp_biometricsid($staff,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('biometricsid', $staff);
        $this->db->update('pcc_staff');

        $this->db->set('studid', $value );
        $this->db->where('studid', $staff);
        $this->db->update('pcc_login');

        $this->db->set('teacherid', $value );
        $this->db->where('teacherid', $staff);
        $this->db->update('pcc_teachersched');

        return $this->db->affected_rows();
    }

    function update_emp_records($staff,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('biometricsid', $staff);
        $this->db->update('pcc_staff');
        return $this->db->affected_rows();
    }

    function update_emp_history_log($data){
        $this->db->insert('pcc_hr_history_log', $data);
        return $this->db->insert_id();
    }

    function get_old_emp($staff,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid', $staff);
        return $query = $this->db->get()->row();
    }

    function get_emp($staff,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('biometricsid', $staff);
        $query = $this->db->get();
        return $query->result();
    }

     function get_staff_appointment($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_appointment');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function view_emp_basic_data($data){
        $this->db->select('pcc_staff.Firstname, pcc_staff.LastName, pcc_staff.FileNo, pcc_staff.BiometricsID, pcc_departments.DEPTNAME, pcc_position.position, pcc_position.id');
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
        $this->db->where('pcc_staff.FileNo' , $data);
        $query = $this->db->get();        
        return $query->result()?$query->result():false;
    }

    function get_service_record($id){
        $this->db->select('pcc_job_history.staff_id ,pcc_position.position, pcc_job_history.date_from, pcc_job_history.date_to');
        $this->db->from('pcc_job_history');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_job_history.position');
        $this->db->where('pcc_job_history.staff_id' , $id);
        $query1 = $this->db->get_compiled_select();

        $this->db->select('pcc_staff_appointment.staff_id, pcc_staff_appointment.app, pcc_staff_appointment.appfrom, pcc_staff_appointment.appto');
        $this->db->from('pcc_staff_appointment');
        $this->db->where('pcc_staff_appointment.staff_id' , $id);
        $query2 = $this->db->get_compiled_select(); 
        $query = $this->db->query($query1." UNION ".$query2);

        return $query->result()?$query->result():false;
    }

     function get_staff_dept_history($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_department_history');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_department_history.department ', 'left');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_staff_edu_background($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_educ_background');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_staff_eligibilities($id){
        $this->db->select('*');
        $this->db->from('pcc_staff_eligibility');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_user_position($id,$select='*'){

        $this->db->select($select);
        $query = $this->db->get_where('pcc_position', array('id' => $id),0, 1);
        return $query->result();
    }

     function get_user_education($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_staff_educ_background', array('staff_id' => $id),0, 1);
        if(!$query->result()){
            return $this->ins_staff_education($id,array('id'=>null,'staff_id'=>$id));
        }
        else
            return $query->result();
    }

    function ins_staff_education($id,$val=array()){
        $this->db->insert('pcc_staff_educ_background', $val);
        return $this->get_user_education($id);
    }
     


    function get_emp_leave_credits($id,$leave_type){
        if($leave_type > 0){
            $this->db->select('pcc_hr_leave.id, SUM(pcc_hr_leave.leave_credit) as leave_credit, pcc_hr_leave_type.type, pcc_hr_leave.type_id');
        }else{
            $this->db->select('pcc_hr_leave.id, pcc_hr_leave.leave_credit, pcc_hr_leave_type.type, pcc_hr_leave.type_id');
        }
        $this->db->from('pcc_hr_leave');
        $this->db->join('pcc_hr_leave_type', 'pcc_hr_leave.type_id = pcc_hr_leave_type.id ', 'inner');
        $this->db->where('pcc_hr_leave.empid' , $id);
        if($leave_type > 0){
            $this->db->where('pcc_hr_leave.type_id' , $leave_type);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_latest_service_credits($empid){
        $array = array('YEAR(date_added) =' => date('Y'), 'empid' => $empid);
        $this->db->select('date_added');
        $this->db->from('pcc_hr_service_leave_credits');
        $this->db->where($array);

        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_leave_records($leave_type,$staff_id){
        $this->db->select('la.empid, r.FirstName, r.MiddleName, r.LastName, la.reason, la.leave_from, la.leave_to, la.num_days, la.date_filed, la.dept_head_approval, la.dept_head_date_approval, la.hr_remarks, la.id, la.dayswithpay, la.dayswithoutpay, let.type, let.days, l.leave_credit, l.date_added, la.dept_head_approval_remarks, la.hr_remarks');
        $this->db->from('pcc_hr_leave_application la');
        $this->db->join('pcc_staff r', 'r.fileno = la.empid ', 'left');
        $this->db->join('pcc_hr_leave l', 'l.type_id = la.leave_type_id ', 'left');
        $this->db->join('pcc_hr_leave_type let', 'let.id = la.leave_type_id ', 'left');
        $this->db->where('la.empid' , $staff_id);
        $this->db->where('l.empid' , $staff_id);
        if($leave_type != ''){
            $this->db->where('l.type_id' , $leave_type);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_overtime_application($data){
        $this->db->select('*');
        $this->db->from('pcc_hr_overtime');
        $this->db->where('empid',$data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_pass_slip_application($data){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');
        $this->db->where('empid',$data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_travel_form($data){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_form');
        $this->db->where('empid',$data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_emp_otherids_records($array_insert){
        $this->db->insert('pcc_staff_otherid',($array_insert));
        return $this->db->insert_id();
    }

    function del_appointment($id){
        $this->db->where('pcc_staff_appointment.id', $id);
        return $this->db->delete('pcc_staff_appointment');
    }

    function get_educ($staff, $id){
        $this->db->select('*');
        $this->db->from('pcc_staff_educ_background');
        $this->db->where('staff_id',$staff);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function del_education($id){
        $this->db->where('pcc_staff_educ_background.id', $id);
        return $this->db->delete('pcc_staff_educ_background');
    }

    function get_emp_eligibility($staff, $eligid){
        $this->db->select('*');
        $this->db->from('pcc_staff_eligibility');
        $this->db->where('id',$eligid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function del_eligibilities($id){
        $this->db->where('pcc_staff_eligibility.id', $id);
        return $this->db->delete('pcc_staff_eligibility');
    }

    function del_otherID($id){
        $this->db->where('pcc_staff_otherid.id', $id);
        return $this->db->delete('pcc_staff_otherid');
    }

    function get_emp_otherids($staff, $id){
        $this->db->select('*');
        $this->db->from('pcc_staff_otherid');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function update_emp_otherids_records($staff,$id,$type,$value){
        $this->db->set($type, $value );
        $this->db->where('staff_id', $staff);
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_otherid');
        return $this->db->affected_rows();
    }

    function get_emp_dpndnt($staff,$depid){
        $this->db->select('*');
        $this->db->from('pcc_staff_dependent');
        $this->db->where('id',$depid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;        
    }

    function get_profile_image($id){
        $this->db->select('*');
        $this->db->from('pcc_hr_profile_images');
        $this->db->where('user_id',$id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function profile_image_upload($data){
        $this->db->insert('pcc_hr_profile_images', $data);
        return $this->db->insert_id();
    }

    function profile_image_update($data, $id){
        $this->db->where('user_id', $id);
        $this->db->update('pcc_hr_profile_images', $data);
    }

    function get_hr_history_log(){
        $this->db->select('log.*, staff.LastName , staff.FirstName, staff.MiddleName');
        $this->db->from('pcc_hr_history_log log');
        $this->db->join('pcc_staff staff', 'log.biometric_id = staff.BiometricsID');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
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

    function get_profile_dependents($id){
        $this->db->select('*');
        $this->db->from('pcc_staff_dependent');
        $this->db->where('staff_id',$id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;        
    }

    function get_leave_credit_log($empid, $leave_type){
        $this->db->select('*');
        $this->db->from('pcc_hr_leave');
        $this->db->where('empid',$empid);
        $this->db->where('type_id',$leave_type);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result()?$query->result():false;        
    }

    function get_employee_leave($employee_id){
        $this->db->select('');
        $this->db->from('pcc_hr_leave_application la');
        $this->db->join('pcc_hr_leave l', 'l.type_id = la.leave_type_id ', 'left');
        $this->db->where('la.empid' , $employee_id);
        $this->db->where('l.status' , 1);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function add_emp_job_history_record($array_insert){
        $this->db->insert('pcc_job_history',($array_insert));
        return $this->db->insert_id();
    }

    function add_appointment_history_record($array_insert){
        $this->db->insert('pcc_staff_appointment',($array_insert));
        return $this->db->insert_id();
    }
        
    function get_emp_job_history($empid){
        $this->db->select('j.*, d.deptname, p.position as positiontitle');
        $this->db->from('pcc_job_history j');
        $this->db->join('pcc_departments d', 'd.deptid = j.department ', 'left');
        $this->db->join('pcc_position p', 'p.id = j.position ', 'left');
        $this->db->where('j.staff_id' , $empid);
        $this->db->order_by('j.date_from', 'asc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function update_position_dept($fileno, $position, $department){
        $this->db->set('positionRank', $position);
        $this->db->set('Department', $department);
        $this->db->where('fileno', $fileno);
        $this->db->update('pcc_staff');
        return $this->db->affected_rows();
    }

    function update_employment_separation($fileno, $reasonforseparation, $lastday, $status){
        $this->db->set('leavereason', $reasonforseparation);
        $this->db->set('lastday', $lastday);
        $this->db->set('active', $status);
        $this->db->where('fileno', $fileno);
        $this->db->update('pcc_staff');
        return $this->db->affected_rows();
    }

}