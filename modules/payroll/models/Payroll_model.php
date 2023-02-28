<?php defined('BASEPATH') OR exit('No direct script access allowed');

// for general data
// queries of data lists
// 
class payroll_model extends CI_Model {

        // function __construct()
    // {
    //     parent::__construct();
    // }

    function get_salary_matrix(){
        // $this->db->select('pcc_position.id as pos_id, pcc_position.position, pcc_hr_payroll_salary_matrix.*');
        // $this->db->from('pcc_position');
        // $this->db->join('pcc_hr_payroll_salary_matrix', 'pcc_position.id = pcc_hr_payroll_salary_matrix.position_id ', 'left');       
        // $query = $this->db->get();
        // return $query->result()?$query->result():false;

        $this->db->select('pcc_staff.id as u_id, CONCAT(pcc_staff.LastName, ", ", pcc_staff.FirstName, " ", pcc_staff.MiddleName) as fullname, pcc_position.position, pcc_hr_payroll_salary_rate.*');
        $this->db->from('pcc_staff');
        $this->db->join('pcc_hr_payroll_salary_rate', 'pcc_staff.id = pcc_hr_payroll_salary_rate.user_id ', 'left'); 
        $this->db->join('pcc_position', 'pcc_staff.PositionRank = pcc_position.id ', 'left');    
        $this->db->where('pcc_staff.teaching', 0);    
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function get_salary_matrix_teaching(){
        $this->db->select('pcc_staff.id as u_id, CONCAT(pcc_staff.LastName, ", ", pcc_staff.FirstName, " ", pcc_staff.MiddleName) as fullname, pcc_position.position, pcc_hr_payroll_salary_rate.*');
        $this->db->from('pcc_staff');
        $this->db->join('pcc_hr_payroll_salary_rate', 'pcc_staff.id = pcc_hr_payroll_salary_rate.user_id ', 'left'); 
        $this->db->join('pcc_position', 'pcc_staff.PositionRank = pcc_position.id ', 'left');    
        $this->db->where('pcc_staff.teaching', 1);    
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function get_salary_matrix_unknown(){
        $this->db->select('pcc_staff.id as u_id, CONCAT(pcc_staff.LastName, ", ", pcc_staff.FirstName, " ", pcc_staff.MiddleName) as fullname, pcc_position.position, pcc_hr_payroll_salary_rate.*');
        $this->db->from('pcc_staff');
        $this->db->join('pcc_hr_payroll_salary_rate', 'pcc_staff.id = pcc_hr_payroll_salary_rate.user_id ', 'left'); 
        $this->db->join('pcc_position', 'pcc_staff.PositionRank = pcc_position.id ', 'left');    
        $this->db->where('pcc_staff.teaching', null);    
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function get_user_rate($id){
        $this->db->select('pcc_staff.id as u_id, pcc_hr_payroll_salary_rate.*');
        $this->db->from('pcc_staff');
        $this->db->join('pcc_hr_payroll_salary_rate', 'pcc_staff.id = pcc_hr_payroll_salary_rate.user_id ', 'left'); 
        $this->db->where('pcc_staff.fileno', $id);    
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function update_salary_matrix($user_id, $value, $col_name){
        // $this->db->set($col_name, $value);
        // $this->db->where('position_id', $position);
        // $this->db->update('pcc_hr_payroll_salary_matrix');
        // return $this->db->affected_rows();

        $this->db->set('hour', $value);
        $this->db->where('user_id', $user_id);
        $this->db->update('pcc_hr_payroll_salary_rate');
        return $this->db->affected_rows();
    }

    function insert_salary_matrix($data){
        // $this->db->insert('pcc_hr_payroll_salary_matrix', $data);
        // return $this->db->insert_id();

        $this->db->insert('pcc_hr_payroll_salary_rate', $data);
        return $this->db->insert_id();

    }

    function insert_salary_matrix_log($data){
        // $this->db->insert('pcc_hr_payroll_salary_matrix', $data);
        // return $this->db->insert_id();

        $this->db->insert('pcc_hr_payroll_salary_rate_history', $data);
        return $this->db->insert_id();

    }

    function search_position_salary_matrix($user_id){
        // $this->db->select('id');
        // $this->db->from('pcc_hr_payroll_salary_matrix');
        // $this->db->where('position_id', $position_id);
        // $query = $this->db->get();
        // return $query->result()?$query->result():false;

        $this->db->select('id');
        $this->db->from('pcc_hr_payroll_salary_rate');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_dedductions_allowances($data){
        $this->db->insert('pcc_hr_payroll_set_deductions_allowances', $data);
        return $this->db->insert_id();
    }

    function update_dedductions_allowances($data,$id){
         $deduction_data=array(
            'description'=>$data['description'],
            'amount'=>$data['amount'],
            'status'=>$data['status']
        );

        $this->db->WHERE('id',$id)->update('pcc_hr_payroll_set_deductions_allowances',$deduction_data);

        return true;
    }

    function delete_dedductions_allowances($id){
          $this->db->WHERE('id',$id)->delete('pcc_hr_payroll_set_deductions_allowances');
        return true;
    }

    function get_deductions_allowances(){
        $this->db->select('*');
        $this->db->from('pcc_hr_payroll_set_deductions_allowances');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_loans(){
        $this->db->select('*');
        $this->db->from('pcc_hr_emp_loans');
        $this->db->join('pcc_staff','pcc_staff.FileNo=pcc_hr_emp_loans.empid','left');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_deductions_allowances($fileno, $deduction_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_payroll_emp_deductions_allowances');
        $this->db->where('deduction_id', $deduction_id);
        $this->db->where('emp_id', $fileno);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    
    function get_employees_eligible($fileno){
        $this->db->select('st.FileNo, st.FirstName, st.LastName, e.*');
        $this->db->from('pcc_hr_payroll_emp_deductions_allowances e');
        $this->db->join('pcc_staff st', 'st.fileno = e.emp_id ', 'inner');  
        $this->db->where('st.FileNo', $fileno);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_employees_eligible_grp(){
        $this->db->select('st.FileNo, st.FirstName, st.LastName, e.deduction_id');
        $this->db->from('pcc_hr_payroll_emp_deductions_allowances e');
        $this->db->join('pcc_staff st', 'st.fileno = e.emp_id ', 'inner');     
        $this->db->group_by('e.emp_id');  
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }


    function insert_emp_dedductions_allowances($data){
        $this->db->insert('pcc_hr_payroll_emp_deductions_allowances', $data);
        return $this->db->insert_id();
    }

    function insert_emp_loans($data){
        $this->db->insert('pcc_hr_emp_loans', $data);
        return $this->db->insert_id();
    }

    function update_emp_loans($data,$id){
         $loans_data=array(
            "empid"             => $data['empid'],
            "loan_description"  => $data['loan_description'],
            "months_payable"    => $data['months_payable'],
            "amt_per_month"     => $data['amt_per_month'],
            "cut_off"            => $data['cut_off'],
            "total_amt"         => $data['total_amt'],
            "remarks"            => $data['remarks'],
        );

        $this->db->WHERE('id',$id)->update('pcc_hr_emp_loans',$loans_data);

        return true;
    }

    function get_emp_loan_details($loan_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_emp_loans');  
        if($loan_id){
            $this->db->where('pcc_hr_emp_loans.id' , $loan_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function del_emp_loan($loan_id){
        $this->db->where('pcc_hr_emp_loans.id', $loan_id);
        return $this->db->delete('pcc_hr_emp_loans');
    }

    function check_cut_off_date(){
        $this->db->select('*');
        $this->db->from(' pcc_hr_cut_off_periods');
        $query = $this->db->get();

        return $query->result()?$query->result():false;
    }

    function check_cut_off_date_update($date1, $date2, $id){
        $this->db->select('*');
        $this->db->from(' pcc_hr_cut_off_periods');
        $this->db->where('date("'.$date1.'") BETWEEN cut_off_from AND cut_off_to OR date("'.$date2.'") BETWEEN cut_off_from AND cut_off_to');
        $this->db->where('id <>', $id);

        $query = $this->db->get();

        return $query->result()?$query->result():false;
    }

    function get_cut_off_all(){
        $this->db->select('*');
        $this->db->from('pcc_hr_cut_off_periods');
        $this->db->where('isTeaching', 0);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_cut_off_all_teaching(){
        $this->db->select('*');
        $this->db->from('pcc_hr_cut_off_periods');
        $this->db->where('isTeaching', 1);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_cut_off($cutoff_id){
        $this->db->select('*');
        $this->db->from(' pcc_hr_cut_off_periods');
        $this->db->where('id',$cutoff_id); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_cut_off($data){
        $this->db->insert('pcc_hr_cut_off_periods', $data);
        return $this->db->insert_id();
    }

    function update_cut_off($data){
         $loans_data=array(
            'first_cut_from' => $data['first_cut_from'],
            'first_cut_to' => $data['first_cut_to'],
            'second_cut_from' => $data['second_cut_from'],
            'second_cut_to' => $data['second_cut_to'],
        );

        $this->db->WHERE('isTeaching', $data['isTeaching']);
        $this->db->WHERE('emp_status', $data['emp_status']);
        $this->db->update('pcc_hr_cut_off_periods',$loans_data);

        return true;
    }

    function delete_cut_off($cutoff_id){
        $this->db->where('id', $cutoff_id);
        return $this->db->delete('pcc_hr_cut_off_periods');
    }

    function get_emp_file_deductions($fileno){
        $this->db->select('e.*, s.description');
        $this->db->from('pcc_hr_payroll_emp_deductions_allowances e');
        $this->db->join('pcc_hr_payroll_set_deductions_allowances s', 'e.deduction_id = s.id');
        $this->db->where('emp_id', $fileno);
        $this->db->order_by("deduction_id", "ASC");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_specific_deduction_allowance($fileno, $deduction_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_payroll_emp_deductions_allowances');
        $this->db->where('emp_id', $fileno);
        $this->db->where('deduction_id', $deduction_id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function del_deduction_allowance($fileno){
        $this->db->where('emp_id', $fileno);
        return $this->db->delete('pcc_hr_payroll_emp_deductions_allowances');
    }

    function delete_specific_deduction_allowance($fileno, $dec_id){
         $this->db->where('emp_id', $fileno);
         $this->db->where('deduction_id', $dec_id);
        return $this->db->delete('pcc_hr_payroll_emp_deductions_allowances');

    }

    function update_deductions_allowances($data, $fileno, $deduction_id){
        $vals = array(
            'first_cutoff'   =>  $data['first_cutoff'],
            'second_cutoff' => $data['second_cutoff'],
            'amount'          =>  $data['amount'],
        );
        $this->db->where('emp_id', $fileno);
        $this->db->where('deduction_id', $deduction_id);
        $this->db->update('pcc_hr_payroll_emp_deductions_allowances', $vals);
        return true;
        
    }

    function insert_update_deductions_allowances($data){
        $this->db->insert('pcc_hr_payroll_emp_deductions_allowances', $data);
        return $this->db->insert_id();
    }


    function get_employees($active, $select='*'){
        $this->db->select($select);
        $this->db->from('pcc_staff');
        $this->db->join('pcc_departments', 'pcc_departments.DEPTID = pcc_staff.Department ', 'left');
        $this->db->join('pcc_position', 'pcc_position.id = pcc_staff.PositionRank ', 'left');       
        $this->db->where('pcc_staff.active' , $active);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_total_leaves($fileno, $date_from, $date_to){
        $this->db->select('la.*, lt.type', 'st.BiometricsID');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left');                     
        $this->db->where('la.empid', $fileno);
        $this->db->where('la.leave_from >=', $date_from);
        $this->db->where('la.leave_to <=', $date_to);
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function get_user_cutt_off($emp_status, $isTeaching){
        $this->db->select('*');
        $this->db->from('pcc_hr_cut_off_periods');
        $this->db->where('isTeaching', $isTeaching);
        $this->db->where('emp_status', $emp_status);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_staff_attendance($biono, $date_from, $date_to){
        $this->db->select('*');
        $this->db->from('pcc_staff_attendance');
        $this->db->where('biono', $biono);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result()?$query->result():false;

    }

    function get_staff_salary($id){
        $this->db->select('*');
        $this->db->from('pcc_hr_payroll_salary_rate');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_cuttoff_date( $isTeaching, $emp_status){
        $this->db->select('*');
        $this->db->from('pcc_hr_cut_off_periods');
        $this->db->where('isTeaching', $isTeaching);
        $this->db->like('emp_status', $emp_status);
        $query = $this->db->get();
        return $query->result()?$query->result():false;


    }
}