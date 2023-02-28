<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tor extends MY_Controller {

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
		$this->load->module('admin_registrar/admin_reg');
	}
	public function get_student_grades()
	{
		$this->load->model('admin_reg_model');
		$this->load->module('template/template');


		$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();

		$data['view_content']='tor/tor';
		$data['get_plugins_js']='';
		$data['get_plugins_css']='';
		$this->load->view('template/init_views',$data);

	}

	public function get_student_list()
	{
		$this->load->model('admin_reg_model');
		$this->load->module('template/template');


		$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();

		$data['view_content']='tor/list_student';
		$data['get_plugins_js']='tor/plugins_js_tor';
		$data['get_plugins_css']='tor/plugins_css_tor';
		$this->load->view('template/init_views',$data);

	}



	public function get_tor_students(){
		$this->load->model('tor_model');
		$sy=$this->input->post('sy',TRUE);
		$data['aaData']=$this->tor_model->get_student_list($sy,'r.studid,r.lastname,r.firstname,r.middlename,r.emailadd,r.citizenship,r.phone,r.mobile,r.nationality,ei.date_registered,ei.date_admitted,c.code,t.type AS studenttype');

		echo json_encode($data);
	}

public function get_tor_studentsx(){
		$this->load->model('tor_model');
		$sy=$this->input->post('sy',TRUE);
		$data['sy']=$sy;
		$this->load->view('tor/list_student_sy',$data);

	}


	/*hidden method  */

	public function _check_login(){
			if($this->session->userdata('username') && in_array($this->session->userdata('role'),array(1,4)) ){
     			return TRUE;
			}else{
			   redirect(ROOT_URL.'login');
			}
	}

}
