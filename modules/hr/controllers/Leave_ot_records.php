<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class leave_ot_records extends MY_Controller {

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

	#################################################
	##### HR ACCOUNT
	public $user_access_role  = [7];
	##### HR ACCOUNT
	#################################################

	function __construct(){
		$this->load->module('hr/login');
		$this->load->module('template/template');
		$this->load->model('hr/employee_model');
		$this->load->model('hr/hr_model');
		$this->load->model('profile/profile_model');
		$this->load->model('teacher_profile/user_model');
	}
	
	public function index()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['leavetype_lists'] =$this->employee_model->get_leave_type_lists();
		##VIEW CONTENT
		$data['view_content']='hr/leave_ot_record_view';
		$data['view_modals']='hr/leave_ot_record_modals';
		$data['get_plugins_js'] = 'hr/js/plugins_js_leave_ot_records';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function employee_pending_overtime_requests()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['view_content']='hr/overtime_req';
		$data['view_modals']='hr/leave_ot_record_modals';
		$data['get_plugins_js'] = 'hr/js/plugins_js_leave_ot_records';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function employee_pending_leave_requests()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['leave_requests'] = $this->employee_model->get_employee_leave_requests(0, $status=1);
		$data['leave_type'] = $this->employee_model->get_leave_type_lists();
		// $data['leave_credits'] = $this->hr_model->get_emp_leave_credits($data['fileno'], 0);

		$data['leave_balance'] = [];
		if($data['leave_requests']){
			foreach($data['leave_requests'] as $lq){
				$lcredit = $this->employee_model->get_emp_leave_type_credit($lq->empid, $lq->leave_type_id);
				$used_leave = $this->employee_model->get_used_leave_type($lq->empid, $lq->leave_type_id);
				if($used_leave){
					$balance = $lcredit[0]->leave_credit - $used_leave[0]->dayswithpay;
				}
				array_push($data['leave_balance'], $balance);
			}
		}

		$data['view_content']='hr/leave_request_view';
		$data['view_modals']='hr/leave_ot_record_modals';
		$data['get_plugins_js'] = 'hr/js/plugins_js_leave_ot_records';
		$data['get_plugins_css']='hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function employee_pending_passslip_requests()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['view_content']='hr/passslip_request';
		$data['view_modals']='hr/leave_ot_record_modals';
		$data['get_plugins_js'] = 'hr/js/plugins_js_leave_ot_records';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function employee_pending_travelform_requests()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['view_content']='hr/travelform_request';
		$data['view_modals']='hr/leave_ot_record_modals';
		$data['get_plugins_js'] = 'hr/js/plugins_js_leave_ot_records';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function add_leave_credit()
	{
		$this->login->_hr_check_login($this->user_access_role);
		
		$leave_type = $this->input->post('leave_type');
		$leave_credit = $this->input->post('leave_credit');
		$leave_id = $this->input->post('leave_id');
		$employee_id = $this->input->post('employee_id');

		for ($i = 0; $i < count($leave_id); $i++) {
			if($leave_id[$i] == 0){
				$this->employee_model
						->insert_leave_credits([
										'empid' => $employee_id,
										'type_id' => $leave_type[$i],
										'leave_credit' => $leave_credit[$i],
										'date_added' => mdate('%Y-%m-%d'),
										'status' => 1,
									]);
						
			}else{
				$x = $this->employee_model->update_leave_credits($leave_type[$i],$leave_credit[$i], $leave_id[$i]);
			}
		}
    		
       	redirect('employees/'.$employee_id);

	}

	public function view_leave()
	{
		$leave_id = $this->input->post('leave_id');

		$lists = $this->hr_model->get_emp_staff_leave_records($leave_id);

		$data['info'] = [];
		$fileno = 0;
		$ltype_id = 0;

		$leave_type_credits = [];
		foreach ($lists as $key => $value) {
			$emp = $this->employee_model->view_emp_basic_data($value->empid);
			$fileno = $emp[0]->FileNo;
			$ltype_id = $value->leave_type_id;

			if($ltype_id == 11){
				$ltype_id = 1;
			}
			$lcredit = $this->profile_model->get_emp_leave_credits($value->empid, $ltype_id);
			$credits = $lcredit[0]->leave_credit;

			$leave_credits_type = $this->hr_model->get_emp_leave_credits($value->empid, 0);

			foreach ($leave_credits_type as $key => $lct) {
				array_push($leave_type_credits, $lct->type);
			}

			$used_leave = $this->employee_model->get_used_leave_type($value->empid, $value->leave_type_id);
			if($used_leave){
				$balance = $credits- $used_leave[0]->dayswithpay;
			}

			$data['info'][] = array(
				'biometrics' 			=> $emp[0]->BiometricsID,
				'fileno' 				=> $emp[0]->FileNo,
				'name' 					=> $emp[0]->LastName.', '.$emp[0]->Firstname,
				'position' 				=> $emp[0]->position,
				'department' 			=> $emp[0]->DEPTNAME,
				'date_filed' 			=> mdate('%m/%d/%Y', strtotime($value->date_filed)),
				'leave_type' 			=> $value->type,
				'leave_type_id' 		=> $value->leave_type_id,
				'leave_from'			=> mdate('%M %d, %Y', strtotime($value->leave_from)),
				'leave_to'				=> mdate('%M %d, %Y', strtotime($value->leave_to)),
				'num_days' 				=> $value->num_days,
				'reason' 				=> $value->reason,
				'days_with_pay' 		=> $value->dayswithpay,
				'maternity_type' 		=> $value->maternity_type,
				'days_without_pay' 		=> $value->dayswithoutpay,
				'leave_id' 				=> $value->id,
				'dept_head_approval' 	=> $value->dept_head_approval,
				'head_date_approval' 	=> mdate('%m/%d/%Y', strtotime($value->dept_head_date_approval)),
				'head_approval_remarks' => $value->dept_head_approval_remarks,
				'hr_remarks' 			=> $value->hr_remarks,
				'leave_balance' 		=> $balance,
				'leave_type_credits' 	=> $leave_type_credits,
			);
		}

		$data['leave'] = $this->employee_model->get_emp_leave_type_credit($fileno, $ltype_id);

		echo json_encode($data);
	}

	public function add_leave_application()
	{

		$employee_id  = 	$this->input->post('employee_id');
		$leavetype 	  = 	$this->input->post('leavetype');
		$datefiled 	  = 	$this->input->post('datefiled');
		$fromdate 	  = 	$this->input->post('fromdate');
		$todate 	  = 	$this->input->post('todate');
		$reason 	  = 	$this->input->post('reason');
		$actualdays	  = 	$this->input->post('actualdays');
		$dayswithpay  = 	$this->input->post('dayswithpay');
		$dayswitouthpay= 	$this->input->post('dayswitouthpay');
		$remarks 	  = 	$this->input->post('remarks');
		$leave_status = 	$this->input->post('leave_status');
		$date_approve = 	$this->input->post('date_approve_decline');
		$dept_remarks = 	$this->input->post('dept_remarks');
		$daysavailable=		$this->input->post('daysavailable');
		$maternity_type= 	$this->input->post('maternitytype');



		$data_array	  =      array(
						'empid' => $employee_id,
						'leave_type_id' => $leavetype,
						'reason' => $reason,
						'leave_from' => mdate('%Y-%m-%d', strtotime($fromdate)),
						'leave_to' => mdate('%Y-%m-%d', strtotime($todate)),
						'num_days' => $actualdays,
						'date_filed' => mdate('%Y-%m-%d', strtotime($datefiled)),
						'dept_head_approval' => $leave_status,
						'dept_head_date_approval' => mdate('%Y-%m-%d', strtotime($date_approve)),
						'dept_head_approval_remarks' => $dept_remarks,
						'hr_remarks' => $remarks,
						'dayswithpay' => $dayswithpay,
						'dayswithoutpay' => $dayswitouthpay,
						'maternity_type' => $maternity_type,
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

		redirect($this->agent->referrer());

	}

	public function leave_balance(){

		$ltype_id = $this->input->post('ltype_id');
		$employee_id = $this->input->post('emp_id');

		if($ltype_id == 11){
			$ltype_id = 1;
		}

		$leave_credits = $this->profile_model->get_emp_leave_credits($employee_id, $ltype_id);

		$leave_credits_type = '';
		if ($leave_credits[0]->leave_credit == '') {
			$default_type = $this->employee_model->get_leave_type_lists_id( $ltype_id );

			foreach ($default_type as $key => $value) {
				$leave_credits_type[] = (object) array(
					'id' => $ltype_id,
					'leave_credit' => $value->days,
					'type' => $value->type,
					'type_id' => $value->id,
				);
			}
		} else {
			$leave_credits_type = $this->profile_model->get_emp_leave_credits($employee_id, $ltype_id);
		}

		$credits = ($leave_credits_type) ? $leave_credits_type[0]->leave_credit : 0;

		$leave = $this->employee_model->get_used_leave_type($employee_id, $ltype_id);
		$leave_used = ($leave && $leave[0]->dayswithpay != null) ? $leave[0]->dayswithpay : 0;
		$balance = $credits - $leave_used;
		
		echo json_encode($balance);

		// $ltype_id = $this->input->post('ltype_id');
		// $employee_id = $this->input->post('emp_id');

		// // $leave_credit = $this->employee_model->get_emp_leave_type_credit($employee_id, $ltype_id);
		// // $leave_balance = $this->employee_model->get_used_leave_type($employee_id, $ltype_id);
		// // $balance = ($leave_credit ? $leave_credit[0]->leave_credit : 0);
		// // if($leave_balance && $leave_balance[0]->dayswithpay != null)
		// // {
		// // 	$balance = $leave_credit[0]->leave_credit - $leave_balance[0]->dayswithpay;
		// // }
		// if($ltype_id == 11){
		// 	$ltype_id = 1;
		// }
		// $leave_credits = $this->profile_model->get_emp_leave_credits($employee_id, $ltype_id);
		// $credits = ($leave_credits) ? $leave_credits[0]->leave_credit : 0;
		// $leave = $this->employee_model->get_used_leave_type($employee_id, $ltype_id);
		// $leave_used = ($leave && $leave[0]->dayswithpay != null) ? $leave[0]->dayswithpay : 0;
		// $balance = $credits - $leave_used;
		
		// echo json_encode($balance);
	}


	public function get_overtime_records()
	{

		$overt_id = $this->input->post('overt_id');

		$lists = $this->hr_model->get_emp_overtime_records($overt_id);
	
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
							'biometrics' 		=> $emp[0]->BiometricsID,
							'fileno' 			=> $emp[0]->FileNo,
							'sname' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 			=> $emp[0]->position,
							'department' 		=> $emp[0]->DEPTNAME,
							'date_ot' 			=> $value->date_overtime,
							'timefrom'			=> $value->timefrom,
							'timeto'			=> $value->timeto,
							'hours_requested' 	=> $value->hours_requested,
							'hours_rendered' 	=> $value->hours_rendered,
							'reason' 			=> $value->reason,
							'dept_head_approval'=> $value->dept_head_approval,
							'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
							'remarks' 			=> $value->remarks,
							'overt_id' 			=> $value->id
						);

				
			}
		}
		echo json_encode($data);
	}

	public function get_passlip_records()
	{

		$pass_slip_id = $this->input->post('pass_slip_id');

		$lists = $this->employee_model->get_emp_pass_slip_records($pass_slip_id);



		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				// if ($value) {
				// 	# code...
				// }

				$data['data'][] = array(
							'biometrics' 		=> $emp[0]->BiometricsID,
							'fileno' 			=> $emp[0]->FileNo,
							'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 			=> $emp[0]->position,
							'department' 		=> $emp[0]->DEPTNAME,
							'type' 				=> $value->type,
							'slip_date'			=> mdate('%M %d, %Y', strtotime($value->slip_date)),
							'destination'		=> $value->destination,
							'purpose'			=> $value->purpose,
							'exp_timeout' 		=> $value->exp_timeout,
							'exp_timreturn' 	=> $value->exp_timreturn,
							'numhours' 			=> $value->numhours,
							'exp_undertime' 	=> $value->exp_undertime,
							'dept_head_approval'=> $value->dept_head_approval,
							'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
							'dept_head_empid' 	=> $value->dept_head_empid,
							'date_return' 	=> date('M d Y', strtotime($value->date_return)),
							'pass_slip_id' 		=> $value->id
						);
			}
		}
		echo json_encode($data);
	}

	public function get_travel_order_records()
	{
		$travelo_id = $this->input->post('travelo_id');

		$lists = $this->employee_model->get_emp_travel_order_records($travelo_id);

		$budget_lists = $this->employee_model->get_emp_travel_budgets($lists[0]->empid, $travelo_id);

		$budget = [];
		if ($budget_lists) {
			foreach ($budget_lists as $key => $value) {
				$budget_data = array(
					'id' => $value->id,
					'types' => $value->types,
					'amount' => $value->amount,
				);
				array_push($budget, $budget_data);
			}
		}
		
		$data['data'] = [];
		if ($lists) {
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);
				$data['data'][] = array(
					'biometrics' 		=> $emp[0]->BiometricsID,
					'fileno' 			=> $emp[0]->FileNo,
					'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
					'position' 			=> $emp[0]->position,
					'department' 		=> $emp[0]->DEPTNAME,
					'travelo_date' 		=> mdate('%m/%d/%Y', strtotime($value->travelo_date)),
					'datefrom'			=> mdate('%m/%d/%Y', strtotime($value->datefrom)),
					'dateto'			=> mdate('%m/%d/%Y', strtotime($value->dateto)),
					'destination' 		=> $value->destination,
					'numberofdays' 		=> $value->numberofdays,
					'purpose' 			=> $value->purpose,
					'dept_head_approval' 	=> $value->dept_head_approval,
					'dept_head_date_approval' 	=> mdate('%m/%d/%Y', strtotime($value->dept_head_date_approval)),
					'remarks' 			=> $value->remarks,
					'travelo_id' 		=> $value->id,
					'budget' 		=> $budget,
				);
			}
		}

		echo json_encode($data);
	}

	public function add_overtime_application()
	{

		$employee_id  = $this->input->post('employee_id');
		$overtime_date 	  = 	$this->input->post('overtime_date');
		$fromtime 	  = $this->input->post('fromtime');
		$totime 	  = $this->input->post('totime');
		$numhours 	  = $this->input->post('numhours');
		$reason 	  = $this->input->post('reason');
		$remarks 	  =	$this->input->post('remarks');
		$dept_head_approval  = $this->input->post('dept_head_approval');
		$date_approve_decline = $this->input->post('date_approve_decline');

		if($this->input->post("overt_id")){
			$dept_head_approval  = $this->input->post('dept_head_approval');
			$date_approve_decline = $this->input->post('date_approve_decline');
			$date = mdate('%Y-%m-%d', strtotime($date_approve_decline));

			}else{
				$dept_head_approval  =0;
				$date = NULL;
		}
		$data_array = array(
				'empid' => $employee_id,
				'date_overtime' => mdate('%Y-%m-%d', strtotime($overtime_date)),
				'timefrom' => $fromtime,
				'timeto' => $totime,
				'hours_rendered' => $numhours,
				'reason' => $reason,
				'remarks' => $remarks,
				'dept_head_approval' => $dept_head_approval,
				'dept_head_date_approval' => mdate('%Y-%m-%d', strtotime($date_approve_decline)),
				'date_requested' => date('Y-m-d H:i:s')
			);

		if($this->input->post('overt_id')){
			$this->employee_model
					->update_overtime_application($data_array, $this->input->post('overt_id'));
		}else{
			$this->employee_model
					->insert_overtime_application($data_array);
		}

		redirect($this->agent->referrer());
	}


	public function add_pass_slip_application()
	{

		$employee_id  		= 	$this->input->post('employee_id');
		$type 				= 	$this->input->post('pass_slip_type');
		$slip_date  		= 	$this->input->post('slip_date');
		$destination 	  	= 	$this->input->post('destination');
		$reason 	  		= 	$this->input->post('purpose');
		$timeout 	  		= 	$this->input->post('from');
		$timereturn 	  	= 	$this->input->post('to');
		$numhours 	  		= 	$this->input->post('numhours');
		$exp_undertime 	  	= 	$this->input->post('undertime');
		$date_return 	  	= 	$this->input->post('date_return');

		if($this->input->post('hr_approval')){
		$dept_head_approval  		= 	$this->input->post('dept_head_approval');
		$date_approve_decline 		=	$this->input->post('date_approve_decline');
		$date = mdate('%Y-%m-%d', strtotime($date_approve_decline));
		}else{
		$dept_head_approval  	= NULL;
		$date 					= NULL;
		}

		$data_array	 = array(
			'empid' 			=> $employee_id,
			'type' 				=> $type,
			'slip_date'			=> mdate('%Y-%m-%d', strtotime($slip_date)),
			'destination'		=> $destination,
			'purpose'			=> $reason,
			'exp_timeout'		=> $timeout,
			'exp_timreturn'		=> $timereturn,
			'numhours' 			=> $numhours,
			'date_return' 		=> date('Y-m-d', strtotime($date_return)),
			'dept_head_approval' => 0,
			'date_requested' => date('Y-m-d H:i:s')
		);

		if($this->input->post('pass_slip_id')){
			$this->employee_model->update_pass_slip_application($data_array, $this->input->post('pass_slip_id'));
		}else{
			$this->employee_model->insert_pass_slip_application($data_array);
		}

		redirect($this->agent->referrer());

	}
	public function add_travel_order_application()
	{
		
		$employee_id  		= 	$this->input->post('employee_id');
		$destination 	  	= 	$this->input->post('destination');
		$reason 	  		= 	$this->input->post('purpose');
		$fromdate 	  		= 	$this->input->post('fromdate');
		$todate 	  	= 	$this->input->post('todate');
		$numdays 	  		= 	$this->input->post('numdays');
		$travelo_id 	  		= 	$this->input->post('travelo_id');

		$budget_id 	= 	$this->input->post('budget_id');
		$budget_spec 	= 	$this->input->post('budget_type');
		$budget_amount 	= 	$this->input->post('budget_amount');

		if($this->input->post('hr_approval')){
		$to_status  	= 	$this->input->post('to_status');
		$date_approve_decline 	=	$this->input->post('date_approve_decline');
		$date = mdate('%Y-%m-%d', strtotime($date_approve_decline));
		}else{
		$to_status = 0;
		$date = null;
		}

		$data_array	  =      array(
			'empid' 			=> $employee_id,
			'travelo_date'		=> mdate('%Y-%m-%d'),
			'destination'		=> $destination,
			'purpose'			=> $reason,
			'datefrom'				=> mdate('%Y-%m-%d', strtotime($fromdate)),
			'dateto'			=> mdate('%Y-%m-%d', strtotime($todate)),
			'numberofdays' 			=> $numdays,
			'dept_head_approval' 	=> $to_status,
			'dept_head_date_approval' 	=> $date,
			'date_requested' => date('Y-m-d H:i:s')
		);

		if($this->input->post('travelo_id')){
			$this->employee_model->update_travel_order_application($data_array, $this->input->post('travelo_id'));
			$budget_lists = $this->employee_model->get_emp_travel_budgets($employee_id, $this->input->post('travelo_id'));
			$id = [];

			if ($budget_lists) {
				foreach ($budget_lists as $key => $value) {
					array_push($id, $value->id);
				}
			}

			for ($i=0; $i < count($budget_id) ; $i++) { 
				if(in_array($budget_id[$i], $id) && !empty($id)){

					$array_data1 = array(
						'types' => $budget_spec[$i],
						'amount' => $budget_amount[$i]
					);
					$this->employee_model->update_travel_order_budget($array_data1, $budget_id[$i]);

				} else {
					$budget_array = array(
						'empid' => $employee_id,
						'travel_form_id	' => $travelo_id,
						'types' 	=> $budget_spec[$i],
						'amount' 	=> $budget_amount[$i],
					);
					$this->employee_model->insert_travel_order_budget($budget_array);

				}
			}

		}else{
			$this->employee_model->inser_travel_order_application($data_array);

			$travel_id = $this->employee_model->get_employee_travel_application($employee_id);
			if ($budget_spec) {
				for ($i=0; $i < count($budget_spec) ; $i++) { 

					$budget_array = array(
						'empid' => $employee_id,
						'travel_form_id	' => $travel_id[0]->id,
						'types' 	=> $budget_spec[$i],
						'amount' 	=> $budget_amount[$i],
					);
					$this->employee_model->insert_travel_order_budget($budget_array);
				}
			}
			
		}

		redirect($this->agent->referrer());
	}

	public function delete_leave(){
		$leave_id = $this->input->post('leave_id');
		$data['notif'] = $this->employee_model->del_leave_notification($leave_id);
		$data['leave'] = $this->employee_model->del_emp_leave_records($leave_id);
		echo json_encode($data);
	}

	public function delete_overtime_record(){
		$overt_id = $this->input->post('overt_id');
		$user = $this->session->userdata('id');
		$data['seen_overtime'] = $this->employee_model->del_seen_overtime_records($overt_id, $user);
		$data['overtime_records'] = $this->employee_model->del_emp_overtime_records($overt_id);
		echo json_encode($data);
	}

	public function delete_slip_record(){
		$pass_slip_id = $this->input->post('pass_slip_id');
		$data['seen_slip'] = $this->employee_model->del_seen_slip_records($pass_slip_id);
		$data['pass_slip_records'] = $this->employee_model->del_emp_slip_records($pass_slip_id);
		echo json_encode($data);
	}
	
	public function delete_travel_record(){
		$travelo_id = $this->input->post('travelo_id');
		$user = $this->session->userdata('id');
		$data['seen_travel'] = $this->employee_model->del_seen_travel_records($travelo_id, $user);
		$data['travel_form'] = $this->employee_model->del_emp_travel_records($travelo_id);
		echo json_encode($data);
	}

	public function delete_travel_budgets(){
		$id = $this->input->post('id');
		$data = $this->employee_model->del_emp_travel_budgets($id);
		echo json_encode($data);

	}

	public function get_staff_emp_pass_slip_request(){
		$travelo_id = $this->input->post('pass_id');
		$lists = $this->employee_model->get_emp_pass_slip_records($travelo_id);

		$data = array(
			'id' => $lists[0]->id,
			'empid' => $lists[0]->empid,
			'type' => $lists[0]->type,
			'slip_date' => $lists[0]->slip_date,
			'destination' => $lists[0]->destination,
			'purpose' => $lists[0]->purpose,
			'exp_timeout' => $lists[0]->exp_timeout,
		);

		echo json_encode($data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

	}

	public function settings(){
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['leave_type'] = $this->employee_model->get_leave_type_lists();
		
		$data['view_content']='hr/leave_type_settings';
		$data['get_plugins_js'] = 'hr/js/datatables_js';
		$data['get_plugins_css']='hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function update_lt_days()
	{

		$leave_id  			= 	$this->input->post('leave_id');
		$days 				= 	$this->input->post('days');

		for ($i=0; $i < count($leave_id); $i++) { 
			$this->employee_model->update_leave_type_days($leave_id[$i], $days[$i]);
		}

		redirect($this->agent->referrer());

	}

	

	// public function overtime_request()
	// {
	// 	###################################################
	// 	$this->login->_hr_check_login($this->user_access_role);
	// 	$data['nav']=$this->template->_nav();
	// 	$fileno = $this->session->userdata('fileno');
	// 	$data['user'] =$this->employee_model->get_user_info($fileno);
	// 	$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
	// 	$data['user_role'] =$this->employee_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
	// 	####################################################

	// 	$data['overtime_records'] = $this->employee_model->get_emp_overtime_records($fileno);

	// 	$data['view_content']='hr/staff_overtime_requests';
	// 	$data['view_modals']='hr/staff_overtime_requests_modal';
	// 	$data['get_plugins_js']='hr/js/staff_overtime_requests_js';
	// 	$data['get_plugins_css']='hr/css/plugins_css';
	// 	$this->load->view('template/init_views',$data);	
	// }

	// public function get_overtime_requests()
	// {
	// 	$status = $this->input->post('status');
	// 	$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
	// 	$position_id = $fileno[0]->position_id;
	// 	$dept_id = $fileno[0]->dept_id;

	// 	$approving_ranks = $this->employee_model->get_head_approving_ranks($position_id);
	// 	$requests = [];
	// 	$data['data'] = [];

	// 	foreach($approving_ranks as $r)
	// 	{
	// 		$result = $this->employee_model->get_pending_approved_overtime_requests($r->position_id, $dept_id, $status);
	// 		if($result){
	// 			foreach($result as $value)
	// 			{
	// 				$data['data'][] = array(
	// 								'id' 			=> $value->overtime_id,
	// 								'name' 			=> $value->lastname.', '.$value->firstname,
	// 								'date_overtime' => mdate('%M %d, %Y', strtotime($value->date_overtime)),
	// 								'timefrom' 		=> $value->timefrom,
	// 								'timeto' 		=> $value->timeto,
	// 								'numhours' 		=> $value->hours_rendered,
	// 								'reason' 		=> $value->reason,
	// 							);
	// 			}
	// 		}
	// 	}

		
	// 	echo json_encode($data);
	// }

	public function save_vl_leave_credits()
	{
		$employee_id 	= 	$this->input->post('fileno');
		$date 	  		= 	$this->input->post('date');
		$leave_credit 	= 	$this->input->post('leavebalance');

		for ($i=0; $i < count($leave_credit); $i++) { 
			if($leave_credit[$i] > 0 && $leave_credit[$i] != ''){
				$this->employee_model
						->insert_leave_credits([
										'empid' => $employee_id[$i],
										'type_id' => 1, //vacation/emergency leave
										'leave_credit' => $leave_credit[$i],
										'date_added' => mdate('%Y-%m-%d', strtotime($date)),
										'status' => 1,
									]);
			}
		}

		echo json_encode('true');

	}

	public function get_emp_leave_credits(){
		#auto adding of leave credits - VL

		##NON-TEACHING
		#query all employees with regular employment status and at least 1 YOS
		$non_teaching_emp = $this->employee_model->get_leave_credible_staff($classify = 0);
		for ($i=0; $i < count($non_teaching_emp) ; $i++) { 
			$dayofemp = date('d', strtotime($non_teaching_emp[$i]->dateofemploy));
			if($dayofemp == date('d')){
				##check if leave credits has already been added for the current month
				$dismonth = date('m-Y');
				$withleave = $this->employee_model->check_emp_vl_credit($non_teaching_emp[$i]->FileNo, $vl=1, $dismonth);
				$monthyr = [];
				if($withleave){
					foreach($withleave as $l){
						array_push($monthyr, date('m-Y', strtotime($l->date_added)));
					}
				}
				if(!in_array($dismonth, $monthyr)){
					$this->employee_model
							->insert_leave_credits([
									'empid' => $non_teaching_emp[$i]->FileNo,
									'type_id' => 1, //vacation/emergency leave
									'leave_credit' => 1.5, //alloted vl per month
									'date_added' => mdate('%Y-%m-%d'),
									'status' => 1,
								]);
				}
			}

		}

		echo json_encode('true');
	}
	






}
