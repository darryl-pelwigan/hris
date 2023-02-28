<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
	function __constract(){
		$this->load->module('admin/admin');
		$this->admin->_check_login();
	}
	public function index()
	{
		$this->_check_login();
		
		$data['nav']=array(
			//		URI , 	added class , NAME , properties array
			array('profile','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''),
			array('teachersched','glyphicon glyphicon-calendar','Teacher Sched','li'=>'','a'=>''),
			array('attendance','glyphicon glyphicon-calendar','Time Keeping','li'=>'','a'=>''),
			array('overttime','glyphicon glyphicon-time','Overtime Form','li'=>'','a'=>''),
			array('timerecord','glyphicon glyphicon-book','Payslip','li'=>'','a'=>''),
			array('leave','glyphicon glyphicon-road','Leave Form','li'=>'','a'=>''),
			array('studgrade','glyphicon glyphicon-list-alt','Student Grades','li'=>'','a'=>''),
			);
		$this->load->model('user_model');
		$this->load->module('template/template');
		$this->load->module('teachersched/teachersched');
		
		
		$data['user'] =$this->user_model->get_user_info($this->session->userdata('id'),'LastName , FirstName , MiddleName');
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		
		$this->load->view('template/init_views',$data);
	}
	
	public function signin()
	{
		 $sess= json_decode($_POST['sess'] , TrUE);
		 $this->session->set_userdata($sess);
	}
	
	public function login()
	{
		 redirect(base_url().'login');
	}

	/*hidden method*/

	public function _check_login(){
			if($this->session->userdata('name') &&  $this->session->userdata('role')==8){
     			return TRUE;
			}else{
			   redirect('http://localhost/pcc/login');
			}
	}
}
