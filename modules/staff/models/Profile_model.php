<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_fileno($id,$select='*'){
        $this->db->select('fileno, positionrank  as position_id, biometricsid, Department as dept_id');
        $this->db->from('pcc_staff');
        $this->db->where('BiometricsID' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_user_info($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->where('fileno' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    // function insert_edit_employee_profile($data){
    //     $this->db->insert('pcc_staff_history_log', $data);
    //     return $this->db->insert_id();
    // }

    function insert_edit_employee_profile($data, $fileno){
        $this->db->where('FileNo', $fileno);
        $this->db->update('pcc_staff', $data);
        return $this->db->affected_rows();
    }

    function insert_update_appointment($data, $appid){
        $this->db->where('id', $appid);
        $this->db->update('pcc_staff_appointment', $data);
        return $this->db->affected_rows();
    }

   //add appointment
    function add_update_appointment($data){
        $this->db->insert('pcc_staff_appointment', $data);
        return $this->db->insert_id();
    
    }
    //get appointment
    function get_all_appointment($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_appointment');
        $query = $this->db->get();
        return $query->result();
    }
    //delete apointment
    function del_emp_appointment($appid){
        $this->db->where('pcc_staff_appointment.id', $appid);
        return $this->db->delete('pcc_staff_appointment');
    }

    //add educational background
    function add_educ_background($data){
        $this->db->insert('pcc_staff_educ_background', $data);
        return $this->db->insert_id();
    }

    function get_user_position($id,$select='*'){

        $this->db->select($select);
        $query = $this->db->get_where('pcc_position', array('id' => $id),0, 1);
        return $query->result();
    }

    function ins_staff_education($id,$val=array()){
        $this->db->insert('pcc_staff_educ_background', $val);
        return $this->get_user_education($id);
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

    function get_user_role($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login');
        $this->db->join('pcc_roles', 'pcc_login.role = pcc_roles.id ', 'left');
        $this->db->where('pcc_login.studid', $id);
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

    function get_staff_edu_background($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_educ_background');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_staff_eligibilities($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff_eligibility');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    public function insert_update_educ_background($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('pcc_staff_educ_background', $data);
        return $this->db->affected_rows();        
    }

    function get_staff_dept_history($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_department_history');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_department_history.department ', 'left');
        $this->db->where('staff_id' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_leave_credits($id,$select='*'){
        $this->db->select('pcc_hr_leave.id, pcc_hr_leave.leave_credit, pcc_hr_leave_type.type, pcc_hr_leave.type_id');
        $this->db->from('pcc_hr_leave');
        $this->db->join('pcc_hr_leave_type', 'pcc_hr_leave.type_id = pcc_hr_leave_type.id ', 'inner');
        $this->db->where('pcc_hr_leave.empid' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_overtime_records($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_hr_overtime');
        $this->db->where('pcc_hr_overtime.empid' , $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
 
    function insert_leave_credits($data){
        $this->db->insert('pcc_hr_leave', $data);
        return $this->db->insert_id();
    }

    function update_leave_credits($leave_type,$leave_credit, $leave_id){
        $this->db->set('type_id', $leave_type );
        $this->db->set('leave_credit', $leave_credit );
        $this->db->where('id', $leave_id);
        $this->db->update('pcc_hr_leave');
        return $this->db->affected_rows();
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

    function update_leave_remain($lid, $days_remain){
        $this->db->set('days_remain', $days_remain );
        $this->db->where('leave_id', $lid);
        $this->db->update('pcc_hr_leave_remain');
        return $this->db->affected_rows();
    }

    function update_leave_record($lid,$remark, $numdays, $dayswithpay, $dayswithoutpay, $leavefrom, $leaveto, $vacation){
        $this->db->set('hrcomment', $remark );
        $this->db->set('leave_from', $leavefrom );
        $this->db->set('leave_to', $leaveto );
        $this->db->set('numbersofdays', $numdays );
        $this->db->set('dayswithpay', $dayswithpay );
        $this->db->set('dayswithoutpay', $dayswithoutpay );
        if($vacation != ''){
            $this->db->set('vacleave_bal', $vacation );
        }
        $this->db->where('id', $lid);
        $this->db->update('pcc_teacher_leave');
        return $this->db->affected_rows();
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


    function get_emp_leave_type_credit($employee_id, $ltype_id){
        $this->db->select('pcc_hr_leave.leave_credit');
        $this->db->from('pcc_hr_leave');
        $this->db->where('empid' , $employee_id);
        $this->db->where('type_id' , $ltype_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_leave_application($data){
        $this->db->insert('pcc_hr_leave_application', $data);
        return $this->db->insert_id();
    }

    function update_leave_application($data, $overtime_id){
        $this->db->where('id', $overtime_id);
        $this->db->update('pcc_hr_leave_application', $data);
        return $this->db->affected_rows();
    }

    function insert_overtime_application($data){
        $this->db->insert('pcc_hr_overtime', $data);
        return $this->db->insert_id();
    }

    function update_overtime_application($data, $overtime_id){
        $this->db->where('id', $overtime_id);
        $this->db->update('pcc_hr_overtime', $data);
        return $this->db->affected_rows();
    }


    function get_used_leave_type($empid, $type_id){
        $this->db->select_sum('dayswithpay');
        $this->db->from('pcc_hr_leave_application');  
        $this->db->where('empid' , $empid);  
        $this->db->where('leave_type_id' , $type_id);  
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_employee_leave_requests($fileno, $status){
        $this->db->select('la.*, lt.type, s.firstname, s.lastname, s.middlename');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left');    
        $this->db->join('pcc_staff s', 's.fileno=la.empid', 'left');    
        if($fileno > 0){
            $this->db->where('la.empid' , $fileno);
        }else{
             $this->db->where('la.hr_remarks' , null);
        }
        if($status > 0){
            $this->db->where('la.dept_head_approval' , $status);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_head_approving_ranks($position_id){
        $this->db->select('position_id');
        $this->db->from('pcc_hr_leave_approval');  
        $this->db->where('position_approval_id' , $position_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_pending_approved_leave_requests($position_id, $dept_id, $status){
        $this->db->select('s.firstname, s.lastname, lt.type, la.num_days, la.leave_from, la.leave_to, la.reason, la.date_filed, la.id as leave_id');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left'); 
        $this->db->join('pcc_staff s', 's.fileno=la.empid', 'left');       
        $this->db->where('s.positionrank' , $position_id);
        // $this->db->where('s.department' , $dept_id);
        $this->db->where('la.dept_head_approval' , $status);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_pending_approved_overtime_requests($position_id, $dept_id, $status){
        
        $this->db->select('s.firstname, s.lastname,  po.id as overtime_id, po.empid, po.date_overtime, po.timefrom, po.timeto, po.hours_rendered, po.dept_head_approval, po.remarks, po.reason');
        $this->db->from('pcc_hr_overtime po');  
        $this->db->join('pcc_staff s', 's.fileno=po.empid', 'left');       
        $this->db->where('s.PositionRank', $position_id);
        $this->db->where('po.dept_head_approval' , $status);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_pending_approved_pay_slip_requests($position_id, $dept_id, $status){
        $this->db->select('s.firstname, s.lastname,  ps.id as pass_slip_id, ps.empid,ps.type, ps.slip_date, ps.destination, ps.purpose, ps.exp_timeout, ps.exp_timreturn, ps.numhours, ps.exp_undertime');
        $this->db->from('pcc_hr_passslip ps');  
        $this->db->join('pcc_staff s', 's.fileno=ps.empid', 'left');       
        $this->db->where('s.positionrank' , $position_id);
        $this->db->where('ps.dept_head_approval' , $status);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    function get_pending_approved_travelo_requests($position_id, $dept_id, $status){
        $this->db->select('s.firstname, s.lastname, to.id as travel_id, to.travelo_date, to.purpose, to.datefrom, to.dateto, to.destination, to.numberofdays, to.dept_head_approval, to.dept_head_date_approval, to.remarks ');
        $this->db->from('pcc_hr_travel_form to');  
        $this->db->join('pcc_staff s', 's.fileno=to.empid', 'left');       
        $this->db->where('s.positionrank' , $position_id);
        $this->db->where('to.dept_head_approval' , $status);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function update_leave_request_status($leave_id, $dept_status){
        $this->db->set('dept_head_approval', $dept_status);
        $this->db->where('id', $leave_id);
        $this->db->update('pcc_hr_leave_application');
        return $this->db->affected_rows();
    }

    function update_travel_order_request_status($travel_order_id, $dept_status, $remarks){
        $this->db->set('dept_head_approval', $dept_status);
        $this->db->set('remarks', $remarks);
        $this->db->set('dept_head_date_approval', date('Y-m-d'));
        $this->db->where('id', $travel_order_id);
        $this->db->update('pcc_hr_travel_form');
        return $this->db->affected_rows();
    }

    function update_pass_slip_status($pass_slip, $dept_status, $data){
        $this->db->set('dept_head_approval', $dept_status);
        $this->db->set('dept_head_date_approval', date('Y-m-d'));
        $this->db->where('id', $pass_slip);
        $this->db->update('pcc_hr_passslip', $data);
        return $this->db->affected_rows();
    }

    function update_overtime_status($overt_id, $dept_status){
        $this->db->set('dept_head_approval', $dept_status);
        $this->db->set('dept_head_date_approval', date('Y-m-d'));
        $this->db->where('id', $overt_id);
        $this->db->update('pcc_hr_overtime');
        return $this->db->affected_rows();
    }

    function insert_ovetime_application($data){
        $this->db->insert('pcc_hr_overtime', $data);
        return $this->db->insert_id();
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

    function insert_pass_slip_application($data){
        $this->db->insert('pcc_hr_passslip', $data);
        return $this->db->insert_id();
    }

      function update_pass_slip_application($data, $pass_slip_id){
        $this->db->where('id', $pass_slip_id);
        $this->db->update('pcc_hr_passslip', $data);
        return $this->db->affected_rows();
    }

    function inser_travel_order_application($data){
        $this->db->insert('pcc_hr_travel_form', $data);
        return $this->db->insert_id();
    }
    function update_travel_order_application($data, $travelo_id){
        $this->db->where('id', $travelo_id);
        $this->db->update('pcc_hr_travel_form', $data);
        return $this->db->affected_rows();
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

    function del_emp_leave_records($leave_id){
        $this->db->where('pcc_hr_leave_application.id', $leave_id);
        return $this->db->delete('pcc_hr_leave_application');

    }
    function del_emp_overtime_records($overt_id){
        $this->db->where('pcc_hr_overtime.id', $overt_id);
        return $this->db->delete('pcc_hr_overtime');
    }

    function del_emp_slip_records($passlip_id){
        $this->db->where('pcc_hr_passslip.id', $passlip_id);
        return $this->db->delete('pcc_hr_passslip');
    }
    function del_emp_travel_records($travelo_id){

        $this->db->where('pcc_hr_travel_form.id', $travelo_id);
        return $this->db->delete('pcc_hr_travel_form');
    }
    function get_overtime_application($data){
        $this->db->select('*');
        $this->db->from('pcc_hr_overtime');
        $this->db->where('empid',$data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_latest_service_credits($empid){
        $array = array('YEAR(date_added) =' => date('Y'), 'empid' => $empid);

        $this->db->select('date_added, date_created');
        $this->db->from('pcc_hr_service_leave_credits');
        $this->db->where($array);

        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    
}