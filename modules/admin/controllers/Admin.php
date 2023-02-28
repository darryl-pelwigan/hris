<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller {

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
		$this->load->model('admin_registrar/admin_reg_model');
	}


	 public function index()
	{
		$this->_check_login();
		$this->load->library('theworld');
		$data['nav']=$this->_nav();
		$this->load->model('teacher_profile/user_model');
		$this->load->module('template/template');
		$this->load->module('teachersched/teachersched');
		$data['user'] =$this->user_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->user_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user']['education']= $this->user_model->get_user_education($this->session->userdata('id'));
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		$data['view_content']='teacher_profile/view_profile';
		$data['get_plugins_js']='teacher_profile/plugins_js_hris';
		$data['get_plugins_css']='';
		$this->load->view('template/init_views',$data);
	}



	public function teach_sched()
	{
		$this->load->model('admin_registrar/fg_only_model');
		$this->load->model('teacher_profile/user_model');
		$this->load->module('template/template');
		$this->load->module('teachersched/teachersched');
		$this->load->model('admin_registrar/grades_submission_model');
		$data['fileno'] = $this->session->userdata('fileno');
		$data['grade_submission']['p'] = '';
		$data['grade_submission']['m'] = '';
		$data['grade_submission']['tf'] = '';
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=$data["sem_sy"]["sem_sy"][0]->sem;
        $sy=$data["sem_sy"]["sem_sy"][0]->sy;

		if(($this->grades_submission_model->get_grade_submission($sy,$sem,'p'))){
			$data['grade_submission']['p'] = $this->grades_submission_model->get_grade_submission($sy,$sem,'p');
			$data['grade_submission']['m'] = $this->grades_submission_model->get_grade_submission($sy,$sem,'m');
			$data['grade_submission']['tf'] = $this->grades_submission_model->get_grade_submission($sy,$sem,'tf');
		}
		$data['allow_view'] = $this->fg_only_model->get_teacher_view_exclude($data['fileno']);
		$data['nav']=$this->_nav();
		$data['user'] =$this->user_model->get_user_info($this->session->userdata('id'),'LastName , FirstName , MiddleName');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');



        if(isset($_SESSION['new_sem_Sy'])){
            $new_sem_Sy = $this->session->new_sem_Sy;
            $sem=$new_sem_Sy['sem'];
            $sy=$new_sem_Sy['sy'];
        }
        $data['scool_year'] = $this->admin_reg_model->get_schoolyear('sc.schoolyear');
        $data['set_sem'] = $sem;
        $data['set_sy'] = $sy;


		$data['view_content']='teachersched/teachers_schedule';
		$data['get_plugins_js']='teachersched/plugins_js_ts_sched';
		$data['get_plugins_css']='teachersched/plugins_css';
		$this->load->view('template/init_views',$data);
		$this->_check_login();
	}

	public function signin()
	{
		 $this->load->library('user_agent');
		 $this->load->library('encryption');
		 $this->load->model('admin/user_model');
		if ($this->agent->is_browser())
		{
		 				        $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		 				        $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		 				        $agent = $this->agent->mobile();
		}
		else
		{
		 				        $agent = 'Unidentified User Agent';
		}

		 if($this->input->post('wan_ip',TRUE)!="" && $this->session->userdata('id') ) {

		 			 if(in_array( $this->session->userdata('role'),array(8))){
		 				 echo base_url('');
		 			 }

					if( $this->input->post('wan_ip',TRUE) == "119.93.127.26" ) {
						$mac = shell_exec('arp -an ' . $this->input->post('lan_ip',TRUE));
						preg_match('/..:..:..:..:..:../',$mac , $matches);
						$mac = @$matches[0];
					}elseif ($this->input->post('wan_ip',TRUE) ==  $this->input->post('lan_ip',TRUE)) {
						$mac = shell_exec('arp -an ' . $this->input->post('lan_ip',TRUE));
						preg_match('/..:..:..:..:..:../',$mac , $matches);
						$mac = @$matches[0];
					}else{
						$mac = NULL;
					}

		 			 $log_id=0;
		 			 $date_expiry = date('Y-m-d H:i:s', strtotime("now + 1 minute"));
		 			 if($this->user_model->get_user_login($this->session->userdata('id'),$this->session->userdata('username'),'id')){
		 			 	$log_id=$this->user_model->get_user_login($this->session->userdata('id'),$this->session->userdata('username'),'id')[0]->id;
		 			 }
		 			 if($this->user_model->get_sec_info($agent,$this->agent->platform(),$this->input->post('wan_ip',TRUE),$this->input->post('lan_ip',TRUE),$log_id,$this->session->userdata('id'),$this->session->userdata('username'))){
		 			 	$this->user_model->update_sec_info($mac,$date_expiry,$agent,$this->agent->platform(),$log_id,$this->session->userdata('id'),$this->session->userdata('username'),$this->input->post('wan_ip',TRUE),$this->input->post('lan_ip',TRUE));
		 			 }else{
		 			 	if( !in_array($this->input->post('wan_ip',TRUE),array("119.93.127.26","192.168.1.2")) && !in_array($mac,array("00:24:21:5c:1c:70","00:30:18:a1:a4:43")) ){
		 			 		$this->user_model->insert_sec_info($mac,$date_expiry,$agent,$this->agent->platform(),$log_id,$this->session->userdata('id'),$this->session->userdata('username'),$this->input->post('wan_ip',TRUE),$this->input->post('lan_ip',TRUE));
		 			 	}
		 			 }
		 }else{
		 	if(!$this->user_model->get_secv_info($agent,$this->agent->platform(),$this->input->post('wan_ip',TRUE),$this->input->post('lan_ip',TRUE))){
		 			 	 $this->user_model->insert_secv_info($agent,$this->agent->platform(),$this->input->post('wan_ip',TRUE),$this->input->post('lan_ip',TRUE));
		 	}else{
		 			 	$this->user_model->update_secv_info($agent,$this->agent->platform(),$this->input->post('wan_ip',TRUE),$this->input->post('lan_ip',TRUE));
		 	}
		 }
	}

	public function test()
	{
		 $this->load->library('encryption');
		 $ciphertext = $this->encryption->encrypt(json_encode($this->input->post()));
		 echo  $ciphertext;
	}


	public function login()
	{
		 redirect(base_url().'login');
	}

	public function logout(){
		$this->session->sess_destroy();
			 redirect(ROOT_URL.'logout.php');
	}

	/*hidden method  */

	public function _check_login(){
			if($this->session->userdata('username') &&  $this->session->userdata('role')=='8' ){
     			return TRUE;
			}else{
			   return redirect(ROOT_URL.'modules/admin/logout');
			}
	}

	public function _check_login_and_registrar(){
			if($this->session->userdata('username') && ( $this->session->userdata('role')=='8'  ) ){
     			return TRUE;
			}else if( $this->session->userdata('username') &&  $this->session->userdata('role')=='1'){
				return TRUE;
			}else{
			   return redirect(ROOT_URL.'modules/admin/logout');
			}
	}

	public function _check_login_registrar(){
			if($this->session->userdata('username') &&  $this->session->userdata('role')=='1' ){
     			return TRUE;
			}else{
			   return redirect(ROOT_URL.'modules/admin/logout');
			}
	}

	public function upload_student_picture(){
		$this->_check_login_registrar();
		$student_id = $this->input->post('student_id');
			$config['upload_path']          = 'assets/student_id/';
			$config['file_name']          	= $student_id.'.jpg';
			$config['allowed_types']        = 'JPG|JPEG|jpg|jpeg';
			$config['overwrite']        = TRUE;
		$this->load->library('upload', $config);

		 if ( ! $this->upload->do_upload('student_picture_change')){
		 	 $error = array('error' => $this->upload->display_errors());
		 	 $data = ['error',$error];
		 	echo json_encode($data);
		 }else{
		 	$data = ['success','Successfully uploaded Student Picture','url'=> site_url('assets/student_id').$student_id.'.JPG' ];
		 	echo json_encode($data);
		 }
	}



	public function _check_login2(){
			if($this->session->userdata('username') &&  $this->session->userdata('role')){
     			return TRUE;
			}else{
			   return redirect(ROOT_URL.'modules/admin/logout');
			}
	}


	public function _nav($push=null){
		$this->load->model('college_deans/college_deans_model');
		$id = $this->session->userdata('staff_id');
		$idx = $this->session->userdata('id');



		if(isset($this->college_deans_model->get_teacher_deans($id)[0]->staff_id)){
			$data=array(
			//		URI , 	added class , NAME , properties array
			array('modules/','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''),
			array('modules/TeacherScheduleList','glyphicon glyphicon-calendar','Teacher Sched','li'=>'','a'=>''),
			array('modules/ViewSubmittedGrades','glyphicons glyphicons-notes-2','Submitted Grades','li'=>'','a'=>''),
			array('teacherOvertime.php','glyphicon glyphicon-time','Time Keeping','li'=>'','a'=>''),
			// array('teacherOvertime.php','glyphicon glyphicon-time','Overtime Form','li'=>'','a'=>''),
			// array('teacherTimeRec.php','glyphicon glyphicon-book','Payslip','li'=>'','a'=>''),
			// array('teacherLeave.php','glyphicon glyphicon-road','Leave Form','li'=>'','a'=>''),
			// array('mailto:benedictms.danalex@gmail.com?Subject=Grading%20System%20Concern','glyphicon glyphicons-message-out','Contact Dev.','li'=>'','a'=>''),
			// array('modules/admin/studgrade','glyphicon glyphicon-list-alt','Student Grades','li'=>'','a'=>''),
			);
		}else{
			$data=array(
			//		URI , 	added class , NAME , properties array
			array('modules/','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''),
			array('modules/TeacherScheduleList','glyphicon glyphicon-calendar','Teacher Sched','li'=>'','a'=>''),
			array('teacherOvertime.php','glyphicon glyphicon-time','Time Keeping','li'=>'','a'=>''),
			array('HRDownload.php','glyphicon glyphicon-download','Files','li'=>'','a'=>''),
			// array('teacherOvertime.php','glyphicon glyphicon-time','Overtime Form','li'=>'','a'=>''),
			// array('teacherTimeRec.php','glyphicon glyphicon-book','Payslip','li'=>'','a'=>''),
			// array('teacherLeave.php','glyphicon glyphicon-road','Leave Form','li'=>'','a'=>''),
			// array('mailto:benedictms.danalex@gmail.com?Subject=Grading%20System%20Concern','glyphicon glyphicons-message-out','Contact Dev.','li'=>'','a'=>''),
			// array('modules/admin/studgrade','glyphicon glyphicon-list-alt','Student Grades','li'=>'','a'=>''),
			);
		}

			return $data;
	}

	public function get_all_staff_dept(){
		$this->_check_login();
		$this->load->model('admin/user_model');
		$dept=$this->input->post('department',TRUE);
		$data=$this->user_model->get_all_staff_dept($dept," CONCAT( LastName,', ' , FirstName,' '  , MiddleName ) as FullName , BiometricsID");
		if(count($data)<=0){
			echo "<option>No available Data</option>";
		}else{
			$op='';
			for($x=0;$x<count($data);$x++){
				$op .="<option value='".$data[$x]->BiometricsID."'>".$data[$x]->FullName."</option>";
			}
			echo ($op);
		}


	}

	public function get_all_student_acct(){
		$this->_check_login();
		$this->load->model('admin/user_model');
		$data['data']=$this->user_model->get_all_student_acct(" l.id, l.studid, l.username,  r.lastname, r.firstname, r.middlename ");
		echo json_encode($data);
	}

	public function rlogin(){
		redirect(ROOT_URL.'login');
	}

	public function compute_trans(){
		$TOTAL=$this->input->get('total');
		$percent=$this->input->get('perccent');
		$h_const=24;
		$l_const=10;

		$seven5=($TOTAL*($percent/100));
		echo floor($seven5);
	}
}
