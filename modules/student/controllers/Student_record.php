<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_record extends MY_Controller {

	function __constract(){
		$this->load->module('admin/admin');
		$this->_check_login2();
	}

	public function _check_login(){
			if($this->session->userdata('username') &&  $this->session->userdata('role')==3 ){
     			return TRUE;
			}else{
			   redirect($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/pcc/login');
			}
	}

	public function _nav($push=null){
			$data=array(
			//		URI , 	added class , NAME , properties array
			array('mystats.php','fa fa-bar-chart-o',' Dashboard','li'=>'','a'=>''),
			array('student.php','fa fa-files-o fa-fw',' My Profile','li'=>'','a'=>''),
			array('enrollment.php','glyphicon glyphicon-play',' Enrollment','li'=>'','a'=>''),
			array('academics.php','fa fa-tasks','  Academics','li'=>'','a'=>''),
			array('libpage.php','fa fa-archive','  Library','li'=>'','a'=>''),
			array('studentapplications.php','fa fa-edit','  Applications','li'=>'','a'=>''),
			);
			return $data;
	}

	 public function student_recordx()
	{
		$this->load->model('student_model');
		$data['data']['aaData']= $this->student_model->get_student_list(' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality,r.mobile,r.phone,ei.interview AS status ');

		 $this->load->view('json_data',$data);
	}
}
