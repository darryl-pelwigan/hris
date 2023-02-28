<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class deductions extends MY_Controller {

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
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->module('template/template');
		$this->load->module('hr/employees');
		$this->load->model('payroll/payroll_model');
		$this->form_validation->set_error_delimiters('<b class="error_validation">', '</b><br />');
		$this->load->model('teacher_profile/user_model');


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

		$data['view_content']='payroll/deductions';
		$data['view_modals']='payroll/deductions_modal';
		$data['get_plugins_js'] = 'payroll/js/plugins_js_deductions';
		$data['get_plugins_css']= 'payroll/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function add_deductions()
	{
		$description = 	$this->input->post('description');
		$amount 	 = 	$this->input->post('amount');
		$type 	 	 = 	$this->input->post('type');

		// if($data){
		// 	$this->payroll_model
		// 			->update_salary_matrix($position_id, $value, $col_name);
		// }else{
			$data = array(
					'description' 	  => $description, 
					'amount'	  	  => $amount,
					'status'	  	  => $type
				);
			$this->payroll_model
					->insert_dedductions_allowances($data);
		// }
		redirect(ROOT_URL.'modules/deductions_allowances');

	}

	public function update_deductions($id)
	{
		$description = 	$this->input->post('update_description');
		$type 	 = 	$this->input->post('update_types');
		$amount 	 	 = 	$this->input->post('update_amount');

		// if($data){
		// 	$this->payroll_model
		// 			->update_salary_matrix($position_id, $value, $col_name);
		// }else{
			$data = array(
					'description' 	  => $description, 
					'amount'	  	  => $amount,
					'status'	  	  => $type
				);

			$this->payroll_model
					->update_dedductions_allowances($data,$id);
		// }
		redirect(ROOT_URL.'modules/deductions_allowances');
	}

	public function delete_deductions($id)
	{

			$this->payroll_model
					->delete_dedductions_allowances($id);
		// }
		redirect(ROOT_URL.'modules/deductions_allowances');
	}

	
}
