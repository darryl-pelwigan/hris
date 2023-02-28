<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Staff extends MY_Controller {

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
		$this->load->model('hr/employee_model');	
		$this->load->module('template/template');	
		$this->load->model('teacher_profile/user_model');
		$this->load->model('staff/staff_model');
		$this->form_validation->set_error_delimiters('<b class="error_validation">', '</b><br />');
	}

	public function requests_approval()
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

		$position_id = $data['user'][0]->PositionRank;
		$dept_id = $data['user'][0]->Department;
		
		$data['leave_requests'] = $this->employee_model->get_employee_leave_requests($data['fileno'], 0);
		$data['leave_balance'] = [];
		if($data['leave_requests']){
			foreach($data['leave_requests'] as $lq){
				$lcredit = $this->employee_model->get_emp_leave_type_credit($data['fileno'], $lq->leave_type_id);
				$used_leave = $this->employee_model->get_used_leave_type($data['fileno'], $lq->leave_type_id);
				$balance = 0;
				if($used_leave){
					$balance = $lcredit[0]->leave_credit - $used_leave[0]->dayswithpay;
				}
				array_push($data['leave_balance'], $balance);
			}
		}

		$data['view_content']='staff/staff_leave_requests_approval';
		$data['get_plugins_js']='staff/js/staff_leave_requests_approval_js';
		$data['get_plugins_css']='hris/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	
	public function leave_approval()
	{
		$dept_status = $this->input->post('dept_status');
		$leave_id = $this->input->post('leave_id');

		$this->staff_model->update_leave_request_status($leave_id, $dept_status);

		redirect($this->agent->referrer());
	}

	public function overtime_approval()
	{
		$dept_status = $this->input->post('dept_status');
		$pass_slip_id = $this->input->post('pass_slip_id');

		$this->staff_model->update_overtime_status($pass_slip_id, $dept_status);

		redirect($this->agent->referrer());
	}

	public function pass_slip_approval()
	{
		$dept_status = $this->input->post('dept_status');
		$overtime_id = $this->input->post('pass_slip_id');

		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$numhours = $this->input->post('numhours');
		$undertime = $this->input->post('undertime');
		$date_return = $this->input->post('date_return');

		$data = array(
			'exp_timeout' => $from,
			'exp_timreturn' => $to,
			'numhours' => $numhours,
			'exp_undertime'	=> $undertime,
			'date_return' => date('Y-m-d', strtotime($date_return)),
		);

		$this->staff_model->update_pass_slip_status($overtime_id, $dept_status, $data);
		redirect($this->agent->referrer());
	}

	public function travel_order_request_approval()
	{
		$dept_status = $this->input->post('dept_status');
		$travel_id = $this->input->post('travel_order_id');
		$remarks = $this->input->post('remarks');
		$employee_id = $this->input->post('employee_id');

		$budget_id = $this->input->post('budget_id');
		$type = $this->input->post('budget_type');
		$amount = $this->input->post('budget_amount');

		$budget_lists = $this->employee_model->get_staff_travel_budgets($travel_id);

		$id = [];

		if ($budget_lists) {
			foreach ($budget_lists as $key => $value) {
				array_push($id, $value->id);
			}
		}

		for ($i=0; $i < count($budget_id) ; $i++) { 
				if(in_array($budget_id[$i], $id) && !empty($id)){

					$array_data1 = array(
						'types' => $type[$i],
						'amount' => $amount[$i]
					);
					$this->employee_model->update_travel_order_budget($array_data1, $budget_id[$i]);

				} else {
					$budget_array = array(
						'empid' => $employee_id,
						'travel_form_id	' => $travel_id,
						'types' 	=> $type[$i],
						'amount' 	=> $amount[$i],
					);
					$this->employee_model->insert_travel_order_budget($budget_array);
				}
		}

		$this->staff_model->update_travel_order_request_status($travel_id, $dept_status, $remarks);
		redirect($this->agent->referrer());
	}

}
