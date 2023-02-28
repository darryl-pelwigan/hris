<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller {

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
		$this->load->model('hr/hr_model');
		$this->load->model('hr/employee_model');
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

		$data['departments'] = $this->hr_model->get_department_lists();
		$data['positions'] = $this->hr_model->get_emp_position();
		$data['religion'] = $this->employee_model->get_religion_list();
		$data['eligibilities'] = $this->employee_model->get_staff_eligibilities();
		$data['leavetypes'] = $this->employee_model->get_leave_type_lists();

		##VIEW CONTENT
		$data['view_content']='hr/report';
		$data['get_plugins_js'] = 'hr/js/plugins_js_report';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function charts()
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
		
		##VIEW CONTENT
		$data['view_content']='hr/report_charts';
		$data['get_plugins_js'] = 'hr/js/plugins_js_report_charts';
		$data['get_plugins_css']= 'hr/css/plugins_charts_css';
		$this->load->view('template/init_views_hr',$data);
	}

	

}
