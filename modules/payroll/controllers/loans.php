<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class loans extends MY_Controller {

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
		$this->load->module('hr/login');
		$this->load->library('form_validation');
		$this->load->module('template/template');
		$this->load->module('hr/employees');
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
		
		$data['loans'] = $this->payroll_model->get_emp_loans();

		$data['view_content']='payroll/loans';
		$data['view_modals']='payroll/loans_modal';
		$data['get_plugins_js'] = 'payroll/js/plugins_js_loans';
		$data['get_plugins_css']= 'payroll/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function get_emp_loans_dt()
	{
		$lists = $this->payroll_model->get_emp_loans();
		$data['data'] = [];	

		if($lists){	
			foreach ($lists as $key => $value) {
					$data['data'][] = array(
								"id"	=> $value->id,
								"name" 	=> $value->LastName." ".$value->FirstName,
								"loan_description" 	=> $value->loan_description,
								"months_payable" 	=> $value->months_payable,
								"amt_per_month" 	=> $value->amt_per_month,
								"cut_off" 	=> $value->cut_off,
								"total_amt" 	=> $value->total_amt,
								"remarks" 	=> $value->remarks,
							);
			}
		}

		echo json_encode($data);
	}

	public function add_loans()
	{
		$empid		 		 = 	$this->input->post('employee_fileno');
		$loan_description 	 = 	$this->input->post('loan_description');
		$months_payable 	 = 	$this->input->post('months_payable');
		$amt_per_month		 = 	$this->input->post('amt_per_month');
		$cut_off 			 = 	$this->input->post('cut_off');
		$total_amt 	 	 	 = 	$this->input->post('total_amt');
		$remarks 	 	 	 = 	$this->input->post('remarks');


		$data = array(
				"empid" 			=> $empid,
				"loan_description" 	=> $loan_description,
				"months_payable" 	=> $months_payable,
				"amt_per_month" 	=> $amt_per_month,
				"cut_off" 			=> $cut_off,
				"total_amt" 		=> $total_amt,
				"remarks" 			=> $remarks,
			);
		if($this->input->post('loan_id')){
			$this->payroll_model->update_emp_loans($data, $this->input->post('loan_id'));
		}else{
			$this->payroll_model->insert_emp_loans($data);
		}
		redirect(ROOT_URL.'modules/loans');

	}

	public function get_emp_loan_details()
	{
		$this->load->model('hris/hris_model');
		$this->load->model('hris/profile_model');

		$loan_id = $this->input->post('loan_id');
		$lists = $this->payroll_model->get_emp_loan_details($loan_id);
	
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->profile_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
								'biometrics' 		=> $emp[0]->BiometricsID,
								'fileno' 			=> $emp[0]->FileNo,
								'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
								'position' 			=> $emp[0]->position,
								'department' 		=> $emp[0]->DEPTNAME,
								"loan_description" 	=> $value->loan_description,
								"months_payable" 	=> $value->months_payable,
								"amt_per_month" 	=> $value->amt_per_month,
								"cut_off" 			=> $value->cut_off,
								"total_amt" 		=> $value->total_amt,
								"remarks" 			=> $value->remarks,
								'loan_id' 			=> $value->id
							);
			}
		}
		echo json_encode($data);
	}

	public function delete_loan(){

		$loan_id = $this->input->post('loan_id');
		$data = $this->payroll_model->del_emp_loan($loan_id);

		echo json_encode($data);
	}
}
?>