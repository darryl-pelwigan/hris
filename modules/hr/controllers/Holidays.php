<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Holidays extends MY_Controller {

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
		$data['position_lists'] =$this->hr_model->get_position_lists();

		##VIEW CONTENT
		$data['view_content']='hr/holiday_list';
		$data['get_plugins_js'] = 'hr/js/plugins_js_holiday';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function add_holiday(){

		$month 			= $this->input->post('month');
		$month_date 	= $this->input->post('month_date');
		$description 	= $this->input->post('description');
		$type 	  		= $this->input->post('holiday_type');

		$data_array = array(
				'holiday_date' => $month. ' ' .$month_date,
				'description' => $description,
				'type' => $type
		);

		if($this->input->post('holiday_id')){
				$this->hr_model->update_holiday_list($data_array, $this->input->post('holiday_id'));
		}else{
				$this->hr_model->insert_holiday_list($data_array);
		}

		redirect(base_url('list_holidays'));
	}


	public function delete_holiday(){
		$holiday_id = $this->input->post('holiday_id');
		$data = $this->hr_model->del_holiday($holiday_id);
		echo json_encode($data);
	}

}
