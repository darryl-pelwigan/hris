<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class payroll extends MY_Controller {

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
		parent::__construct();
		$this->load->library('theworld');
		$this->load->library('form_validation');
		$this->load->module('template/template');
		$this->load->module('hr/employees');
		$this->load->module('hr/login');
		$this->load->model('payroll/payroll_model');
		$this->load->model('teacher_profile/user_model');
		$this->form_validation->set_error_delimiters('<b class="error_validation">', '</b><br />');
	}


	public function index()
	{
		####################################################
		$this->login->_check_login_all($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['deductions'] = $this->payroll_model->get_deductions_allowances();
		$data['employees_grp'] = $this->payroll_model->get_employees_eligible_grp();

		// $data['cutt_off'] = $this->payroll_model->get_cut_off_all();
		// $data['teaching_cutt_off'] = $this->payroll_model->get_cut_off_all_teaching();

		$data['emp_deduction'] = [];
		$array2 = [];


		if(is_array($data['employees_grp'])){
			
			foreach ($data['employees_grp'] as $key => $value) {
				$array = [];
				$array2 = [];
				$emp_deduction = $this->payroll_model->get_employees_eligible($value->FileNo);
				foreach ($emp_deduction as $key => $emp) {
					array_push($array, $emp->deduction_id);
					array_push($array2, $emp->amount);
				}
				array_push($data['emp_deduction'], 
					array('emp_id' => $value->FileNo, 
							'fname' => $value->FirstName, 
							'lname' => $value->LastName, 
							'amount' => $array2,
							'deductions' => $array));
			}
		}
		
		$data['view_content']='payroll/payroll';
		$data['view_modals']='payroll/payroll_modals';
		$data['get_plugins_js'] = 'payroll/js/plugins_js_payroll';
		$data['get_plugins_css']= 'payroll/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function get_cutoff_period(){

		$lists = $this->payroll_model->get_cut_off_all();

		$data = [];

		if($lists){
			foreach ($lists as $key => $value) {
				$data[] = array(
					'isTeaching' 		=> $value->isTeaching,
					'emp_status' 	=> $value->emp_status,
					'first_cut_from' 	=> $value->first_cut_from,
					'first_cut_to' => $value->first_cut_to,
					'second_cut_from' 		=> $value->second_cut_from,
					'second_cut_to'  	=> $value->second_cut_to,
				);
			}
		}

		echo json_encode($data);
	}

	public function get_cutoff_period_teaching(){

		$lists = $this->payroll_model->get_cut_off_all_teaching();

		$data = [];

		if($lists){
			foreach ($lists as $key => $value) {
				$data[] = array(
					'isTeaching' 		=> $value->isTeaching,
					'emp_status' 	=> $value->emp_status,
					'first_cut_from' 	=> $value->first_cut_from,
					'first_cut_to' => $value->first_cut_to,
					'second_cut_from' 		=> $value->second_cut_from,
					'second_cut_to'  	=> $value->second_cut_to,
				);
			}
		}

		echo json_encode($data);

	}

	public function get_emp_deductions()
	{
		$lists = $this->payroll_model->get_employees_eligible();
		
		$data['data'] = [];

		foreach ($lists as $key => $value) {
			$data['data'][] = array(
							'fileno' 		=> $value->FileNo,
							'name' 			=> $value->LastName.', '.$value->FirstName.' '.$value->MiddleName,
							'position' 		=> $value->position,
							'dept_name' 	=> $value->DEPTNAME
						);
			$deductions = $this->payroll_model->get_deductions_allowances();
			foreach($deductions as $d){
				$data['data'][] = array(
							$d->description 		=> $d->amount
						);
			}

		}
		echo json_encode($data);
	}

	public function add_emp_deductions_allowances()
	{
		$fileno      = 	$this->input->post('fileno');
		$deduction_id= 	$this->input->post('deduction_id');

		$firstcut 	= 	array_values(array_filter($this->input->post('first_cut')));
		$secondcut 	= 	array_values(array_filter($this->input->post('second_cut')));		

		for ($i=0; $i < count($deduction_id); $i++) { 
			$amount = $firstcut[$i]+$secondcut[$i];

					$data = array(
						'emp_id' 	  => $fileno, 
						'deduction_id'	 => $deduction_id[$i],
						'first_cutoff'	 => $firstcut[$i],
						'second_cutoff'	=> $secondcut[$i],
						'amount'		  => $amount,
					);


					$this->payroll_model->insert_emp_dedductions_allowances($data);
			}
			
		redirect(ROOT_URL.'modules/payroll');
		
	}

	public function get_emp_payroll()
	{
		$lists = $this->payroll_model->get_employees($active = 1);

		$data['data'] = [];

		if($lists){

			foreach ($lists as $key => $value) {
				$data['data'][] = array(
							'biometrics' 	=> $value->BiometricsID,
							'fileno' 		=> $value->FileNo,
							'name' 			=> $value->LastName.', '.$value->FirstName.' '.$value->MiddleName,
							'dailyrate' 	=> $value->position,
							'hoursrendered' => $value->DEPTNAME,
							'basicpay' 		=> $value->dateofemploy,
							'yearsofservice'=> $value->yearsofservice,
							'teaching' 		=> $value->teaching,
							'emp_status'	=> strtoupper($value->emp_status),
							'salary'	=> 'wala pa',
						);
			}
		}

		echo json_encode($data);

	}

	public function get_all_cutoff(){
		$list = $this->payroll_model->get_cut_off_all();

		$data['data'] = [];

		if($list){
			foreach ($list as $key => $value) {
				$data['data'][] = array(
					'id' 				=> $value->id,
					'cut_off_period' 	=> $value->cut_off_period,
					'classification' 	=> $value->classification,
					'status' 			=> $value->status,
					'cut_off_from' 		=> "Day ".mdate('%d',strtotime($value->cut_off_from)),
					'cut_off_to' 		=> "Day ".mdate('%d',strtotime($value->cut_off_to)),
					'remarks' 			=> $value->remarks
				);
			}
		}

		echo json_encode($data);
	}

	public function view_cutoff(){
		$cutoff_id = $this->input->post('cutoff_id');
		$lists = $this->payroll_model->get_cut_off($cutoff_id);
	
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
					'id' 				=> $value->id,
					'cut_off_period' 	=> $value->cut_off_period,
					'classification' 	=> $value->classification,
					'status' 			=> $value->status,
					'cut_off_from' 		=> mdate('%m/%d/%Y',strtotime($value->cut_off_from)),
					'cut_off_to' 		=> mdate('%m/%d/%Y',strtotime($value->cut_off_to)),
					'remarks' 			=> $value->remarks
				);
			}
		}
		echo json_encode($data);
	}

	public function add_cutoff_period(){


		$classification = ['regular', 'contractual', 'project based', 'probationary', 'fixed Term'];

		$firstcut_from	=	$this->input->post('first_cut_from');
		$firstcut_to	=	$this->input->post('first_cut_to');
		$secondcut_from	=	$this->input->post('second_cut_from');
		$secondcut_to	=	$this->input->post('second_cut_to');

		$t_firstcut_from	=	$this->input->post('t_first_cut_from');
		$t_firstcut_to	=	$this->input->post('t_first_cut_to');
		$t_secondcut_from	=	$this->input->post('t_second_cut_from');
		$t_secondcut_to	=	$this->input->post('t_second_cut_to');

		$data = array();
		$data2 = array();


		for ($i=0; $i < count($classification); $i++) { 
			// for non-teaching
			$data = array(
				'isTeaching' => 0,
				'emp_status' => $classification[$i],
				'first_cut_from' => $firstcut_from[$i],
				'first_cut_to' => $firstcut_to[$i],
				'second_cut_from' => $secondcut_from[$i],
				'second_cut_to' => $secondcut_to[$i],
			);

			$data2 = array(
				'isTeaching' => 1,
				'emp_status' => $classification[$i],
				'first_cut_from' => $t_firstcut_from[$i],
				'first_cut_to' => $t_firstcut_to[$i],
				'second_cut_from' => $t_secondcut_from[$i],
				'second_cut_to' => $t_secondcut_to[$i],
			);

			$check = $this->payroll_model->check_cut_off_date();

			if ($check) {
				$this->payroll_model->update_cut_off($data);
				$this->payroll_model->update_cut_off($data2);
			} else {

				$this->payroll_model->insert_cut_off($data);
				$this->payroll_model->insert_cut_off($data2);
			}

		}

		redirect(ROOT_URL.'modules/payroll');
	}

	public function delete_cutoff_period(){
		$cutoff_id = $this->input->post('cutoff_id');
		$data = $this->payroll_model->delete_cut_off($cutoff_id);

		echo json_encode($data);
	}

	public function view_deduction_allowance(){
		$fileno = $this->input->get('fileno');
		$lists = $this->payroll_model->get_emp_file_deductions($fileno);

		$deductions = $this->payroll_model->get_deductions_allowances();

		$data_deduction = [];
		foreach ($deductions as $key => $value) {
			array_push($data_deduction, $value->id);
		}
		$data = [];

		if($lists){
			foreach ($lists as $key => $value) {
					
					$data[] = array(
						'id' 			=> $value->id,
						'empid' 		=> $value->emp_id,
						'deduction_id' 	=> $value->deduction_id,
						'first_cutoff' 	=> $value->first_cutoff,
						'second_cutoff' => $value->second_cutoff,
						'amount' 		=> $value->amount,
						'description'  	=> $value->description,
						'data_deduction' => $data_deduction
					);
				}
		}

		echo json_encode($data);
	}

	public function delete_deduction_allowance(){
		$fileno = $this->input->post('fileno');
		$data = $this->payroll_model->del_deduction_allowance($fileno);
		echo json_encode($data);

	}

	public function update_emp_deductions_allowances(){
		$fileno = $this->input->post('fileno');
		$deduction_id = $this->input->post('deduction_id');
		$first_cut = array_values(array_filter($this->input->post('first_cut')));
		$second_cut = array_values(array_filter($this->input->post('second_cut')));


		$emp_deduction = $this->payroll_model->get_emp_file_deductions($fileno);

		$emp_dec_array = [];

		for ($i=0; $i < count($emp_deduction); $i++) { 
			array_push($emp_dec_array, $emp_deduction[$i]->deduction_id);
		}

		if(count($deduction_id) < count($emp_dec_array)){
			$result_array = array_values(array_diff($emp_dec_array, $deduction_id));


			if (count($result_array) != 1) {

				for ($i=0; $i < count($result_array) ; $i++) { 
					$this->payroll_model->delete_specific_deduction_allowance($fileno, $result_array[$i]);
				}

			} else {
				$this->payroll_model->delete_specific_deduction_allowance($fileno, $result_array[0]);
			}

			
		} else {

			for ($i=0; $i < count($deduction_id); $i++) { 
				$deduction_lists = $this->payroll_model->get_specific_deduction_allowance($fileno, $deduction_id[$i]);

				$amount = $first_cut[$i]+$second_cut[$i];

				if (in_array($deduction_lists[0]->deduction_id, $deduction_id)) {
					$data = array(
						'deduction_id'	 => $deduction_id[$i],
						'first_cutoff'	 => $first_cut[$i],
						'second_cutoff'	=> $second_cut[$i],
						'amount'		  => $amount,
					);

					$this->payroll_model->update_deductions_allowances($data, $fileno, $deduction_id[$i]);

				} else {
					$data = array(
						'emp_id'	 => $fileno,
						'deduction_id'	 => $deduction_id[$i],
						'first_cutoff'	 => $first_cut[$i],
						'second_cutoff'	=> $second_cut[$i],
						'amount'		  => $amount,
					);

					$this->payroll_model->insert_update_deductions_allowances($data);
				}

			}
		}

		redirect(ROOT_URL.'modules/payroll');
	}

}
