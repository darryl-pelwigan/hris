<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Leave_request extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('hr/hr_model');
		$this->load->module('hr/login');
		$this->load->model('staff/staff_model');
		$this->load->model('hr/employee_model');	
		$this->load->model('profile/profile_model');	
		$this->load->module('template/template');	
		$this->load->model('teacher_profile/user_model');
		$this->form_validation->set_error_delimiters('<b class="error_validation">', '</b><br />');
	}


	public function leave_request()
	{
		####################################################
		$user_access_role  = [$this->session->userdata('role')];
		$this->login->_check_login($user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$data['fileno'] = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($data['fileno']);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['leave_credits'] = $this->hr_model->get_emp_leave_credits($data['fileno'], 0);
		$data['leave_requests'] = $this->employee_model->get_employee_leave_requests($data['fileno'], '');
		$data['gender'] = $data['user'][0]->sex;

		$data['leave_balance'] = [];
		if($data['leave_requests']){
			foreach($data['leave_requests'] as $lq){
				$leave_type = $lq->leave_type_id;
				if($lq->leave_type_id == 11){
					$leave_type = 1;
				}
				$leave_credits = $this->profile_model->get_emp_leave_credits($data['fileno'], $leave_type);
				$credits = ($leave_credits) ? $leave_credits[0]->leave_credit : 0;
				$leave = $this->employee_model->get_used_leave_type($data['fileno'], $lq->leave_type_id);
				$leave_used = ($leave && $leave[0]->dayswithpay != null) ? $leave[0]->dayswithpay : 0;
				$total_balance = $credits - $leave_used;
				array_push($data['leave_balance'], $credits);
			}
		}

		$data['leave_type_array'] = [];
		if ($data['leave_credits']) {
			foreach ($data['leave_credits'] as $key => $lc) {
				array_push($data['leave_type_array'], $lc->type_id);
			}
		}

		$leave_type = $this->employee_model->get_leave_type_lists();
		$leave_type_id = [];
		foreach ($leave_type as $key => $lt) {
			array_push($leave_type_id, $lt->id);
		}

		$diff_result = array_values(array_diff($leave_type_id, $data['leave_type_array'] ));

		if (($key = array_search(7, $diff_result)) !== false) {
			unset($diff_result[$key]);
		}
		if (($key = array_search(8, $diff_result)) !== false) {
			unset($diff_result[$key]);
		}
		if (($key = array_search(10, $diff_result)) !== false) {
			unset($diff_result[$key]);
		}

		if ( $data['user'][0]->sex == 'Female') {
			if (($key = array_search(6, $diff_result)) !== false) {
				unset($diff_result[$key]);
			}
		} else {
			if (($key = array_search(5, $diff_result)) !== false) {
				unset($diff_result[$key]);
			}
		}

		$diff_sequence = array_values($diff_result);

		$default_leave = [];
		for ($i=0; $i < count($diff_sequence) ; $i++) { 
			$default_leave = $this->employee_model->get_leave_type_lists_id( $diff_sequence[$i] );

			$data['leave_credits'][] = (object) array(
				"leave_credit" => $default_leave[0]->days,
	            "type_id" => $default_leave[0]->id,
	            "type" => $default_leave[0]->type,
	            "id" => 'NULL',
			);
		}

		$data['view_content']='staff/staff_leave_requests';
		$data['view_modals']='staff/staff_leave_requests_modal';
		$data['get_plugins_js']='staff/js/staff_leave_requests_js';
		$data['get_plugins_css']='staff/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function leave_balance(){

		$ltype_id = $this->input->post('ltype_id');
		$employee_id = $this->input->post('emp_id');
		if($ltype_id == 11){
			$ltype_id = 1;
		}
		$leave_credit = $this->employee_model->get_emp_leave_type_credit($employee_id, $ltype_id);
		$leave_balance = $this->employee_model->get_used_leave_type($employee_id, $ltype_id);
		$balance = ($leave_credit ? $leave_credit[0]->leave_credit : 0);

		if ($balance == 0) {
			$type = $this->employee_model->get_leave_type_lists_id($ltype_id);
			$balance = $type[0]->days;
		} else {
			if($leave_balance && $leave_balance[0]->dayswithpay != null){
				$balance = $leave_credit[0]->leave_credit - $leave_balance[0]->dayswithpay;
			}
		}
		echo json_encode($balance);
	}

	public function add_leave_application_employee()
	{

		$employee_id  		= 	$this->input->post('employee_id');
		$leavetype 	  		= 	$this->input->post('leavetype');
		$datefiled 	  		= 	mdate('%Y-%m-%d');
		$fromdate 	  		= 	$this->input->post('fromdate');
		$todate 	  		= 	$this->input->post('todate');
		$reason 	  		= 	$this->input->post('reason');
		$actualdays	  		= 	$this->input->post('actualdays');
		$dayswithpay  		= 	0;
		$dayswitouthpay		= 	0;
		$remarks 	  		= 	null;
		$leave_status 		= 	0;
		$date_approve 		= 	null;
		$dept_remarks 		= 	null;
		$dept_approval_empid= 	null;

		$daysavailable = $this->input->post('daysavailable');

		$data_array	=  array(
					'empid' => $employee_id,
					'leave_type_id' => $leavetype,
					'reason' => $reason,
					'leave_from' => mdate('%Y-%m-%d', strtotime($fromdate)),
					'leave_to' => mdate('%Y-%m-%d', strtotime($todate)),
					'num_days' => $actualdays,
					'date_filed' => mdate('%Y-%m-%d', strtotime($datefiled)),
					'dept_head_approval' => $leave_status,
					'dept_head_date_approval' => $date_approve,
					'dept_head_approval_remarks' => $dept_remarks,
					'dept_approval_empid' => $dept_approval_empid,
					'hr_remarks' => $remarks,
					'dayswithpay' => $dayswithpay,
					'dayswithoutpay' => $dayswitouthpay,
					'date_requested' => date('Y-m-d H:i:s')
				);

		if($this->input->post('leave_id')){
			$this->employee_model
					->update_leave_application($data_array, $this->input->post('leave_id'));
		}else{
			$this->employee_model->insert_leave_application($data_array);
			$lcredit = $this->profile_model->get_emp_leave_credits($employee_id, $leavetype);
			if ($lcredit[0]->leave_credit == '') {
				$leave_credit_array = array(
					'empid' => $employee_id,
					'type_id' => $leavetype,
					'leave_credit' => $daysavailable,
					'date_added' => $datefiled,
					'status' => 1,
				);
				$this->employee_model->insert_leave_credit($leave_credit_array);

			}
		}

       	redirect(base_url('employee_leave_form'));

	}

	public function overtime_requests()
	{
		####################################################
		$user_access_role  = [$this->session->userdata('role')];
		$this->login->_check_login($user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$data['fileno'] = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($data['fileno']);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['overtime_records'] = $this->staff_model->get_overtime_application($data['fileno']);

		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['view_content']='staff/staff_overtime_requests';
		$data['view_modals']='staff/staff_overtime_requests_modal';
		$data['get_plugins_js'] = 'staff/js/staff_overtime_requests_js';
		$data['get_plugins_css']= 'staff/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function passslip_request()
	{
		####################################################
		$user_access_role  = [$this->session->userdata('role')];
		$this->login->_check_login($user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$data['fileno'] = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($data['fileno']);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['passslip_request'] = $this->staff_model->get_pass_slip_application($data['fileno']);

		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['view_content']='staff/staff_passslip_form';
		$data['view_modals']='staff/staff_passslip_requests_modal';
		$data['get_plugins_js'] = 'staff/js/staff_passslip_requests_js';
		$data['get_plugins_css']= 'staff/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function travel_order_request()
	{
		####################################################
		$user_access_role  = [$this->session->userdata('role')];
		$this->login->_check_login($user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$data['fileno'] = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($data['fileno']);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['travelorder_request'] = $this->staff_model->get_travel_form($data['fileno']);

		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['view_content']='staff/staff_travel_form';
		$data['view_modals']='staff/staff_travel_form_modal';
		$data['get_plugins_js'] = 'staff/js/staff_travel_requests_js';
		$data['get_plugins_css']= 'staff/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}


}