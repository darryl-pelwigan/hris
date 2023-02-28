<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_reg extends MY_Controller {

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
		$this->_check_login();
	}


	 public function index()

	{
		$this->load->model('admin_reg_model');
		$this->load->module('template/template');
		$data['nav']=$this->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		$data['view_content']='admin_registrar/admin_registrar';
		$data['get_plugins_js']='';
		$data['get_plugins_css']='';
		$this->load->view('template/init_views',$data);
	}




	/*hidden method  */

	public function _check_login(){
			if(in_array($this->session->userdata('role'),['1','2','4']) ){
     			return TRUE;
			}else{
			   return redirect(ROOT_URL.'login');
			}
	}


	public function _nav($push=null){

			$data=array(
			//		URI , 	added class , NAME , properties array
			array('pcc_dashboard.php','fa fa-bar-chart-o',' Dashboard','li'=>'','a'=>''),
			array('records_page.php','fa fa-folder-open fa-fw','Student Records','li'=>'','a'=>''),
			array('enrollment_page.php','fa fa-building-o','Enrollment','li'=>'','a'=>''),
			array('purchaseRequest.php','fa fa-briefcase fa-fw',' Purchase Request','li'=>'','a'=>''),
			array('preferences_page.php','fa fa-gear','Preferences','li'=>'','a'=>''),
			array('HRDownload.php',' glyphicon glyphicon-download','Download Files','li'=>'','a'=>''),
			);
			return $data;
	}



	public function rlogin(){
		redirect(ROOT_URL.'login');
	}
}
