<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Employee_model extends CI_Model {

    function get_user_info($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_staff.PositionRank = pcc_position.id ', 'left');
        $this->db->where('fileno' , $id);
        $this->db->where('active' , 1);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    // function get_all_hr_staff($select='*'){
    //     $this->db->select($select);
    //     $this->db->from('pcc_staff');
    //     $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
    //     $this->db->where('Department' , 4);
    //     $query = $this->db->get();
    //     return $query->result()?$query->result():false;
    // }

    function get_user_role($id,$select='*'){
        $this->db->select($select);
        $this->db->from('pcc_login');
        $this->db->join('pcc_roles', 'pcc_login.role = pcc_roles.id ', 'left');
        $this->db->where('pcc_login.studid', $id);
        $query = $this->db->get();
            return $query->result();
    }

    function get_employees($active, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
        $this->db->where('pcc_staff.active' , $active);
        $this->db->order_by("pcc_staff.LastName", "asc");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }



    // function get_employees($active, $select='*'){
    //     $this->db->select($select);
    //     $this->db->from('pcc_staff');
    //     $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
    //     $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
    //     $this->db->where('pcc_staff.active' , $active);
    //     $this->db->order_by("pcc_staff.LastName", "asc");
    //     $query = $this->db->get();
    //     return $query->result()?$query->result():false;
    // }

     function view_emp_basic_data($data){
        $this->db->select('pcc_staff.Firstname, pcc_staff.LastName, pcc_staff.FileNo, pcc_staff.BiometricsID,pcc_staff.teaching, pcc_departments.DEPTNAME, pcc_position.position, pcc_position.id, pcc_staff.sex');
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
        $this->db->where('pcc_staff.FileNo' , $data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_used_leave_type($empid, $type_id){
        $this->db->select_sum('dayswithpay');
        $this->db->from('pcc_hr_leave_application');  
        $this->db->where('empid' , $empid);  
        if($type_id == 1){
            $this->db->where_in('leave_type_id' , [$type_id, 11]); 
        }else if ($type_id == 11){
            $this->db->where_in('leave_type_id' , [$type_id, 1]);   
        }else{
            $this->db->where('leave_type_id' , $type_id);  
        }
        $this->db->where('dept_head_approval' , 1); 
        // $this->db->group_by('leave_type_id');
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
        $this->db->order_by('id' ,'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_emp_leave_type_credit($employee_id, $ltype_id){
        $this->db->select_sum('leave_credit');
        $this->db->from('pcc_hr_leave');
        $this->db->where('empid' , $employee_id);
        $this->db->where('type_id' , $ltype_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    // function get_approving_position($pos_id){
    //     $this->db->select('l.*, p.position');
    //     $this->db->from('pcc_hr_leave_approval l');
    //     $this->db->join('pcc_position p', 'p.id=l.position_approval_id', 'left');
    //     $this->db->where('l.position_id', $pos_id);
    //     $query = $this->db->get();
    //     return $query->result()?$query->result():false;
    // }

    function get_approving_position(){
        $this->db->select('l.*');
        $this->db->from('pcc_hr_leave_approval l');
        // $this->db->join('pcc_position p', 'p.id=l.position_approval', 'left');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_approval_lists($category){
        $this->db->select('l.*');
        $this->db->from('pcc_hr_leave_approval l');
        // $this->db->join('pcc_position p', 'p.id=l.position_approval_id', 'left');
        $this->db->where('l.category', $category);
        $query = $this->db->get();
        return $query->result()?$query->result():false;       
    }

    function get_leave_type_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_hr_leave_type');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_department_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_departments');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_leave_credits($data){
        $this->db->insert('pcc_hr_leave', $data);
        return $this->db->insert_id();
    }

    function insert_leave_credit_logs($data){
        $this->db->insert('pcc_hr_service_leave_credits', $data);
        return $this->db->insert_id();
    }

    
    function update_leave_credits($leave_type,$leave_credit, $leave_id){
        $this->db->set('type_id', $leave_type );
        $this->db->set('leave_credit', $leave_credit );
        $this->db->where('id', $leave_id);
        $this->db->update('pcc_hr_leave');
        return $this->db->affected_rows();
    }

    function get_head_approving_ranks($position_id){
        $this->db->select('a.category, a.category_approval');
        $this->db->from('pcc_hr_leave_approval a');  
        $this->db->join('pcc_position p', 'lower(p.position_category)=lower(a.category_approval)', 'inner');      
        $this->db->join('pcc_staff s', 's.positionrank=p.id', 'inner');   
        $this->db->where('s.positionrank' , $position_id);   
        $this->db->group_by('a.category');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_pending_approved_overtime_requests($position_id, $dept_id, $status, $approval, $teaching){
        $this->db->select('s.firstname, s.lastname,  po.id as overtime_id, po.empid, po.date_overtime, po.timefrom, po.timeto, po.hours_rendered, po.dept_head_approval, po.remarks, po.reason, po.date_requested');
        $this->db->from('pcc_hr_overtime po');  
        $this->db->join('pcc_staff s', 's.fileno=po.empid', 'left');       
        $this->db->join('pcc_position p', 'p.id=s.PositionRank', 'inner');          
        $this->db->where('lower(p.position_category)' , strtolower($position_id));
        $this->db->where('po.dept_head_approval' , $status);
        if(strtolower($approval) != 'vp'){
            $this->db->where('s.department' , $dept_id);
        }
        if(strtolower($approval) == 'vp'){
            $this->db->where('s.teaching' , $teaching);
        }
        $this->db->order_by('po.date_requested' , 'DESC');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_pending_approved_pay_slip_requests($position_id, $dept_id, $status, $approval, $teaching){
        $this->db->select('s.firstname, s.lastname,  ps.id as pass_slip_id, ps.empid,ps.type, ps.slip_date, ps.destination, ps.purpose, ps.exp_timeout, ps.exp_timreturn, ps.numhours, ps.exp_undertime, ps.date_requested');
        $this->db->from('pcc_hr_passslip ps');  
        $this->db->join('pcc_staff s', 's.fileno=ps.empid', 'left');       
        $this->db->join('pcc_position p', 'p.id=s.PositionRank', 'inner');        
        $this->db->where('lower(p.position_category)' , strtolower($position_id));
        $this->db->where('ps.dept_head_approval' , $status);
        if(strtolower($approval) != 'vp'){
            $this->db->where('s.department' , $dept_id);
        }
        if(strtolower($approval) == 'vp'){
            $this->db->where('s.teaching' , $teaching);
        }
        $this->db->order_by('ps.date_requested' , 'DESC');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    function get_pending_approved_travelo_requests($position_id, $dept_id, $status, $approval, $teaching){
        $this->db->select('s.firstname, s.lastname, to.id as travel_id, to.travelo_date, to.purpose, to.datefrom, to.dateto, to.destination, to.numberofdays, to.dept_head_approval, to.dept_head_date_approval, to.remarks, to.date_requested');
        $this->db->from('pcc_hr_travel_form to');  
        $this->db->join('pcc_staff s', 's.fileno=to.empid', 'left');  
        $this->db->join('pcc_position p', 'p.id=s.PositionRank', 'inner');          
        $this->db->where('lower(p.position_category)' , strtolower($position_id));
        $this->db->where('to.dept_head_approval' , $status);
        if(strtolower($approval) != 'vp'){
            $this->db->where('s.department' , $dept_id);
        }
        if(strtolower($approval) == 'vp'){
            $this->db->where('s.teaching' , $teaching);
        }
        $this->db->order_by('to.date_requested' , 'DESC');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    function insert_leave_application($data){
        $this->db->insert('pcc_hr_leave_application', $data);
        return $this->db->insert_id();
    }

    // function insert_leave_notification($data){
    //     $this->db->insert('pcc_hr_leave_notification', $data);
    //     return $this->db->insert_id();
    // }

    function update_leave_application($data, $overtime_id){
        $this->db->where('id', $overtime_id);
        $this->db->update('pcc_hr_leave_application', $data);
        return $this->db->affected_rows();
    }

    function search_employee($data){
        $this->db->select('pcc_staff.Firstname, pcc_staff.LastName, pcc_staff.FileNo, pcc_staff.teaching, pcc_staff.yearsofservice, pcc_staff.nature_emp');
        $this->db->from('pcc_staff');  
        $this->db->like('CONCAT(pcc_staff.FileNo, " ", pcc_staff.Firstname, " ", pcc_staff.LastName)' , $data);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    function get_emp_pass_slip_records($passlip_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');  
        if($passlip_id > 0){
            $this->db->where('pcc_hr_passslip.id' , $passlip_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_travel_order_records($travelo_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_form');  
        if($travelo_id > 0){
            $this->db->where('pcc_hr_travel_form.id' , $travelo_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_travel_budgets($empid, $travel_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_budget'); 
        $this->db->where('empid' , $empid);
        $this->db->where('travel_form_id' , $travel_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_staff_travel_budgets($travel_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_budget'); 
        $this->db->where('travel_form_id' , $travel_id);
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

    function insert_travel_order_budget($data){
        $this->db->insert('pcc_hr_travel_budget', $data);
        return $this->db->insert_id();
    }

    function update_travel_order_budget($data, $id){
        $this->db->where('id', $id);
        $this->db->update('pcc_hr_travel_budget', $data);
        return $this->db->affected_rows();
    }

    function del_emp_travel_budgets($id){
        $this->db->where('pcc_hr_travel_budget.id', $id);
        return $this->db->delete('pcc_hr_travel_budget');
    }

    function update_travel_order_application($data, $travelo_id){
        $this->db->where('id', $travelo_id);
        $this->db->update('pcc_hr_travel_form', $data);
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

    function get_employee_travel_application($empid){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_form');  
        $this->db->where('empid' , $empid);
        $this->db->order_by('id' ,'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_religion_list(){
        $this->db->select('Religion ID as id, Religion');
        $this->db->from('tblreligion'); 
        $this->db->order_by("Religion", "asc"); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_eligibilities_list() {
        $this->db->select('eligname');
        $this->db->from('eligibility_list'); 
        $this->db->order_by("eligname", "asc");  
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_position_approval($data){
        $this->db->insert('pcc_hr_leave_approval', $data);
        return $this->db->insert_id();
    }
    
    function getlatestpositionrank($pos_id){
        $this->db->select('approval_level');
        $this->db->from('pcc_hr_leave_approval');
        $this->db->order_by('id', 'desc');
        $this->db->where('category', $pos_id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function setting_resetapproving($category){
        $this->db->where('category', $category);
        $this->db->delete('pcc_hr_leave_approval');
        return $this->db->affected_rows();
    }

    function get_staff_eligibilities(){
        $this->db->select("eligname");
        $this->db->from("pcc_staff_eligibility");
        $this->db->group_by("eligname");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_staff_eligibilities($id){
        $this->db->select("eligname");
        $this->db->from("pcc_staff_eligibility");
        $this->db->group_by("eligname");
        $this->db->where("staff_id", $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_staff_educ_background($fileno, $completed){
        $this->db->select("*");
        $this->db->from("pcc_staff_educ_background");
        $this->db->where("staff_id", $fileno);
        $this->db->where("status", $completed);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_staff_highest_educ($fileno, $completed, $type){
        $this->db->select("*");
        $this->db->from("pcc_staff_educ_background");
        $this->db->where("staff_id", $fileno);
        $this->db->where("status", $completed);
        $this->db->where("type", $type);
        $this->db->group_by("type");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    // function get_pending_approved_leave_requests($position_category, $dept_id, $status, $approval, $teaching){
    //     $this->db->select('s.firstname, s.lastname, lt.type, la.num_days, la.leave_from, la.leave_to, la.reason, la.date_filed, la.id as leave_id');
    //     $this->db->from('pcc_hr_leave_application la');  
    //     $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left'); 
    //     $this->db->join('pcc_staff s', 's.fileno=la.empid', 'left');     
    //     $this->db->join('pcc_position p', 'p.id=s.PositionRank', 'inner');        
    //     $this->db->where('lower(p.position_category)' , strtolower($position_category));
    //     if(strtolower($approval) != 'vp'){
    //         $this->db->where('s.department' , $dept_id);
    //     }
    //     if(strtolower($approval) == 'vp'){
    //         $this->db->where('s.teaching' , $teaching);
    //     }
    //     $this->db->where('la.dept_head_approval' , $status);
    //     $query = $this->db->get();
    //     return $query->result()?$query->result():false;
    // }

    function get_pending_approved_leave_requests($category, $dept_id, $status, $approval, $teaching){
        $this->db->select('s.firstname, s.lastname, lt.type, la.num_days, la.leave_from, la.leave_to, la.reason, la.date_filed, la.id as leave_id, lt.type, la.date_requested');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_staff s', 's.fileno=la.empid', 'inner');     
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'inner'); 
        $this->db->join('pcc_position p', 'p.id=s.PositionRank', 'inner');        
        $this->db->where('LOWER(p.position_category)' , strtolower($category));
        if(strtolower($approval) != 'vp'){
            $this->db->where('s.department' , $dept_id);
        }
        if(strtolower($approval) == 'vp'){
            $this->db->where('s.teaching' , $teaching);
        }
        $this->db->where('la.dept_head_approval', $status);
        $this->db->order_by('la.date_requested', 'DESC');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function del_leave_notification($leave_id){
        $this->db->where('pcc_hr_leave_seen_notification.leave_app_id', $leave_id);
        return $this->db->delete('pcc_hr_leave_seen_notification');      
    }
    
    function del_seen_travel_records($travel_id, $empid){
        $this->db->where_in('travel_id', $travel_id);
        return $this->db->delete('pcc_hr_travel_seen_notification');  
    }

    function del_seen_overtime_records($overt_id, $empid){
        $this->db->where_in('overtime_id', $overt_id);
        return $this->db->delete('pcc_hr_overtime_seen_notification');
    }

    function del_seen_slip_records($pass_slip_id){
        $this->db->where_in('pass_slip_id', $pass_slip_id);
        return $this->db->delete('pcc_hr_pass_slip_seen_notification');
    }

    function get_leave_type_lists_id($id){
        $this->db->select('*');
        $this->db->from('pcc_hr_leave_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    function insert_leave_credit($data){
        $this->db->insert('pcc_hr_leave', $data);
        return $this->db->insert_id();
    }

     function get_all_emp_service_credits($empid){
        $this->db->select_sum("credits");
        $this->db->from("pcc_hr_teaching_service_credits");
        $this->db->where("empid", $empid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_credits_sem_sy($empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_teaching_service_credits");
        $this->db->where("empid", $empid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_credits_sem_sy2($empid){
        $this->db->select("tsc.*, st.department");
        $this->db->from("pcc_hr_teaching_service_credits tsc");
        $this->db->join('pcc_staff st', 'st.fileno=tsc.empid', 'LEFT');  
        $this->db->where("tsc.empid", $empid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_sem_school_year($empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_teaching_service_credits");
        $this->db->where("empid", $empid);
        $this->db->where("sem !=", 3);
        $this->db->group_by("sy");
        $this->db->order_by("sy", "ASC");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_credits_sem_per_sy($empid, $year){
        $this->db->select("*");
        $this->db->from("pcc_hr_teaching_service_credits");
        $this->db->where("empid", $empid);
        $this->db->where("sy", $year);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_credits_sem_per_sy2($empid, $year){
        $this->db->select("tsc.*, st.department");
        $this->db->from("pcc_hr_teaching_service_credits tsc");
        $this->db->join('pcc_staff st', 'st.fileno=tsc.empid', 'LEFT');  
        $this->db->where("tsc.empid", $empid);
        $this->db->where("tsc.sy", $year);
        $this->db->where("tsc.sem !=", 3);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_init_service_credits($empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_service_leave_credits");
        $this->db->where("empid", $empid);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    

    function insert_initial_yos($data){
        $this->db->insert('pcc_hr_service_leave_credits', $data);
        return $this->db->insert_id();
    }

    function update_initial_yos($data, $id){
        $this->db->where('empid', $id);
        $this->db->update('pcc_hr_service_leave_credits', $data);
        return $this->db->affected_rows();
    }

    function get_staff($active, $empid){
        $this->db->select('*');
        $this->db->from('pcc_staff');
        $this->db->where('pcc_staff.active' , $active);
        if($empid > 0){
            $this->db->where('pcc_staff.Fileno' , $empid);  
        }      
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_schedule_sem_sy($biono){
        $this->db->select("sched.schoolyear, sched.semester");
        $this->db->select_sum("sched.totalunits");
        $this->db->from("pcc_schedulelist sched");
        $this->db->join('pcc_teachersched t', 't.subjid=sched.schedid', 'inner');     
        $this->db->where("t.teacherid", $biono);
        $this->db->group_by("sched.schoolyear, sched.semester");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_schedule_details($biono){
        $this->db->select_sum("sched.totalunits");
        $this->db->from("pcc_schedulelist sched");
        $this->db->join('pcc_teachersched t', 't.subjid=sched.schedid', 'inner');     
        $this->db->where("t.teacherid", $biono);
        // $this->db->group_by("sched.schoolyear, sched.semester");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function update_emp_yos($empid, $yos){
        $this->db->set('yearsofservice', $yos );
        $this->db->where('fileno', $empid);
        $this->db->update('pcc_staff');
        return $this->db->affected_rows();
    }

    function get_teaching_credits_sem_sy($empid, $sem, $sy){
        $this->db->select('empid');
        $this->db->from('pcc_hr_teaching_service_credits');
        $this->db->where('empid', $empid);
        $this->db->where('sem', $sem);
        $this->db->where('sy', $sy);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    
    function insert_service_credit($data){
        $this->db->insert('pcc_hr_teaching_service_credits', $data);
        return $this->db->insert_id();
    }

    function update_leave_type_days($leaveid, $ldays){
        $this->db->set('days', $ldays );
        $this->db->where('id', $leaveid);
        $this->db->update('pcc_hr_leave_type');
        return $this->db->affected_rows();
    }

     function get_employees_byclassify($active, $classify, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
        $this->db->where('pcc_staff.active' , $active);
        $this->db->where('pcc_staff.teaching' , $classify);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_leave_credible_staff($classify, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->where('pcc_staff.active' , 1);
        $this->db->where('pcc_staff.teaching' , $classify);
        $this->db->where('lower(pcc_staff.emp_status)' , 'regular');
        $this->db->where('pcc_staff.yearsofservice >=', 1);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function check_emp_vl_credit($employee_id, $ltype_id, $month){
        $this->db->select('pcc_hr_leave.date_added');
        $this->db->from('pcc_hr_leave');
        $this->db->where('empid' , $employee_id);
        $this->db->where('type_id' , $ltype_id);
        // $this->db->where('DATE()' , $ltype_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


}