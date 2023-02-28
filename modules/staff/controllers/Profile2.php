<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends MY_Controller {

	function __constract(){
		$this->_check_login();
		$this->load->model('hris/profile_model');
		$this->load->model('hris/employee_model');	
	}


	public function signin()
	{
		 $sess= json_decode($_POST['sess'] , TrUE);
		 $this->session->set_userdata($sess);
	}
	
	public function login()
	{
		 redirect('login');
	}

	/*hidden method*/

	public function _check_login(){
		if($this->session->userdata('role')!=3){
 			return TRUE;
		}else{
		   redirect('login');
		}
	}

	public function index($employee_id)
	{
		$this->_check_login();
		$this->load->library('theworld');
		$this->load->module('template/template');
		$this->load->module('hris/employees');


		$data['nav']=$this->template->_nav();

		$employee_id = $this->session->userdata('fileno');
		##employee profile
		$data['user'] =$this->profile_model->get_user_info($employee_id);
		$data['appointmnt'] =$this->profile_model->get_staff_appointment($employee_id);
		$data['user_info'] = $this->profile_model->view_emp_basic_data($employee_id);
		$data['dept_history'] =$this->profile_model->get_staff_dept_history($employee_id);
		$data['edu_background'] = $this->profile_model->get_staff_edu_background($employee_id);
		$data['eligibilities'] = $this->profile_model->get_staff_eligibilities($employee_id);

	
		##employee leave
		$data['user']['position']= $this->profile_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user']['education']= $this->profile_model->get_user_education($employee_id);
		$data['user_education']= $this->profile_model->get_user_education($data['user'][0]->BiometricsID);
		$data['user_appointment']= $this->profile_model->get_staff_appointment($data['user'][0]->BiometricsID);

		$data['leave_credits']= $this->profile_model->get_emp_leave_credits($employee_id);
		$data['leavetype_lists'] =$this->employee_model->get_leave_type_lists();

		##departments and Posistions
		$data['dept_names'] =$this->employee_model->get_department_lists();
		$data['position'] = $this->hris_model->get_emp_position();

		##NOTIFICATION FOR SERVICE ADDED CREDIT
		$data['service_credit'] = $this->profile_model->get_latest_service_credits($employee_id);

		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->profile_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['view_content']='staff/view_profile';
		$data['view_modals']='staff/view_profile_modals';
		$data['get_plugins_js']='staff/js/plugins_js_profile';
		$data['get_plugins_css']='staff/css/plugins_css';
		$this->load->view('template/init_views',$data);

	}

	public function edit_employee_profile()
	{
		$this->_check_login();
		$this->load->model('profile_model');

		//personal Information
		$fileno = $this->input->post('fileno');
		$biono = $this->input->post('biono');

		$fname = $this->input->post('fname');
		$mname = $this->input->post('mname');
		$lname = $this->input->post('lname');
		$birth_month = $this->input->post('birth_month');
		$month_date = $this->input->post('month_date');
		$birth_year = $this->input->post('birth_year');
		$age = $this->input->post('age');
		$gender = $this->input->post('gender');
		$birthplace = $this->input->post('birthplace');
		$civil_status = $this->input->post('civil_status');
		$religion = $this->input->post('religion');
		$haddr_sitio = $this->input->post('haddr_sitio');
		$haddr_town = $this->input->post('haddr_town');
		$haddr_prov = $this->input->post('haddr_prov');
		$paddr_sitio = $this->input->post('paddr_sitio');
		$paddr_town = $this->input->post('paddr_town');
		$paddr_prov = $this->input->post('paddr_prov');
		$email = $this->input->post('email');
		$landline = $this->input->post('landline');
		$contactnumber = $this->input->post('contactnumber');
		$realspousename = $this->input->post('realspousename');
		$realspouseocc = $this->input->post('realspouseocc');
		$realspouseadd = $this->input->post('realspouseadd');
		$realspousecon = $this->input->post('realspousecon');
		$dependents = $this->input->post('dependents');

		// Parents/ Contact Information
		$fathername = $this->input->post('fathername');
		$fatherbday = $this->input->post('fatherbday');
		$fatheroccup = $this->input->post('fatheroccup');
		$fatherbdate = $this->input->post('fatherbdate');
		$fatherddate = $this->input->post('fatherddate');
		$mothername = $this->input->post('mothername');
		$motheroccup = $this->input->post('motheroccup');
		$motherbdate = $this->input->post('motherbdate');
		$motherddate = $this->input->post('motherddate');
		$emergency_contact = $this->input->post('emergency_contact');
		$emergency_number = $this->input->post('emergency_number');
		$emergency_address = $this->input->post('emergency_address');
		$emergency_relation = $this->input->post('emergency_relation');

		//Employee Information
		$position = $this->input->post('position');
		$salary = $this->input->post('salary');
		$department_name = $this->input->post('department_name');
		$contract = $this->input->post('contract');
		$empstat = $this->input->post('empstat');
		$endcontract = $this->input->post('endcontract');
		$nature_emp = $this->input->post('nature_emp');
		$union = $this->input->post('union');
		$nature_emp = $this->input->post('nature_emp');
		$date_employ = $this->input->post('date_employ');

		//Education backgroud
		$eductype = $this->input->post('eductype');
		$educdegree = $this->input->post('educdegree');
		$educremarks = $this->input->post('educremarks');
		$educnameschool = $this->input->post('educnameschool');

		//eligibilities
		$eligname = $this->input->post('eligname');
		$eligdate = $this->input->post('eligdate');
		$eligno = $this->input->post('eligno');
		$eligrate = $this->input->post('eligrate');
		$expiry = $this->input->post('expiry');

		//Government Issued ID's
		$sss = $this->input->post('sss');
		$philhealth = $this->input->post('philhealth');
		$peraa = $this->input->post('peraa');
		$pagibig = $this->input->post('pagibig');
		$tin = $this->input->post('tin');
		$othername = $this->input->post('othername');
		$otherno = $this->input->post('otherno');

		//employee Leave/Serpaction
		$leavecause = $this->input->post('leavecause');
		$lastday = $this->input->post('lastday');

		$data_array = array(
					'BiometricsID' => $biono,
					'FileNo' => $fileno,
					'LastName' => $lname,
					'FirstName' => $fname,
					'MiddleName' => $mname,
					'PositionRank' => $position,
					'Department' => $department_name,
					'dateofemploy' =>  mdate('%Y-%m-%d', strtotime($date_employ)),
					// 'yearsofservice' => $mname,
					'end_of_contract' => mdate('%Y-%m-%d', strtotime($endcontract)),
					'emp_status' => $contract,
					'nature_emp' =>	$nature_emp,
					'home_address' => $haddr_sitio.' ,'.$haddr_town.' , '.$haddr_prov,
					'prov_address' => $paddr_sitio.' ,'.$paddr_town.' , '.$paddr_prov,
					'email' => $email,
					'mobile_no' => $contactnumber,
					'landline_no' => $landline,
					'birth_date' => $birth_year.'-'.$birth_month.'-'.$month_date,
					'age' => $age,
					'sex' => $gender,
					'civil_status' => $civil_status,
					'wo_with_dependents' => $dependents,
					'leavereason' => $leavecause,
					'lastday' => $lastday,
					'religion' => $religion,
					'tin' => $tin,
					'sss' => $sss,
					'pagibig' => $pagibig,
					'philhealth' => $philhealth,
					'peraa' => $peraa,
					'person_contact_emergency' => $emergency_contact,
					'person_address' => $emergency_address,
					'contact_number' => $emergency_number,
					'relation_person' => $emergency_relation,
					'teaching' => $empstat,
					'active' => '1',
					// 'pic_path' => $nature_emp,
					'fathername' => $fathername,
					'fatherbday' => $fatherbday,
					'fatheroccup' => $fatheroccup,
					'mothername' => $mothername,
					'motherbday' => $motherbdate,
					'motheroccup' => $motheroccup,
					'spousename' => $realspousename,
					'spouseoccup' => $realspouseocc,
					'spouseaddr' => $realspouseadd,
					'spouseno' => $realspousecon,
					'birth_place' => $birthplace,
					'isUnion' => $union,
					'fatherddate' => $fatherddate,
					'motherddate' => $motherddate,
					'salary' => $salary,

		);

		$this->profile_model->insert_edit_employee_profile($data_array, $fileno);
		$data['appointment_all'] =$this->profile_model->get_all_appointment();
		$app_all = $data['appointment_all'];

		
		$appointments = $this->input->post('appointments');
		$app_from = $this->input->post('app_from');
		$app_to = $this->input->post('app_to');
		$appid = $this->input->post('appid');
		
		foreach ($app_all as $value) {
			$app_staff_id = $value->id;
		}

			if ($appid) {
				if($appid == $app_staff_id){
					$data_array = array(
						'id' => $appid,
						'staff_id' => $fileno,
						'app' => $appointments,
						'appfrom' => mdate('%Y-%m-%d', strtotime($app_from)),
						'appto' => mdate('%Y-%m-%d', strtotime($app_to)),

					);
					$this->profile_model->insert_update_appointment($data_array, $appid);
				}else{
					$data_array = array(
					'staff_id' => $fileno,
					'app' => $appointments,
					'appfrom' => mdate('%Y-%m-%d', strtotime($app_from)),
					'appto' => mdate('%Y-%m-%d', strtotime($app_to)),

				);
				$this->profile_model->add_update_appointment($data_array);
				}
			
		} else {
			$data_array = array(

					'staff_id' => $fileno,
					'app' => $appointments,
					'appfrom' => mdate('%Y-%m-%d', strtotime($app_from)),
					'appto' => mdate('%Y-%m-%d', strtotime($app_to)),

				);
				$this->profile_model->add_update_appointment($data_array);
		}

		


		redirect(ROOT_URL.'modules/employees/'.$fileno);
	}

	public function auto_save_appointment()
	{
		$this->load->model('profile_model');

		$data['appointment_all'] =$this->profile_model->get_all_appointment();
		$app_all = $data['appointment_all'];

		
		$appointments = $this->input->post('appointments');
		$app_from = $this->input->post('app_from');
		$app_to = $this->input->post('app_to');
		$appid = $this->input->post('appid');
		$fileno = $this->input->post('fileno');
		
		foreach ($app_all as $value) {
			$app_staff_id = $value->id;
		}

			if ($appid) {
				if($appid == $app_staff_id){
					$data_array = array(
						'id' => $appid,
						'staff_id' => $fileno,
						'app' => $appointments,
						'appfrom' => mdate('%Y-%m-%d', strtotime($app_from)),
						'appto' => mdate('%Y-%m-%d', strtotime($app_to)),

					);
					$this->profile_model->insert_update_appointment($data_array, $appid);
				}else{
					$data_array = array(
					'staff_id' => $fileno,
					'app' => $appointments,
					'appfrom' => mdate('%Y-%m-%d', strtotime($app_from)),
					'appto' => mdate('%Y-%m-%d', strtotime($app_to)),

				);
				$this->profile_model->add_update_appointment($data_array);
				}
			
		} else if($appointments != null) {
			$data_array = array(
					'staff_id' => $fileno,
					'app' => $appointments,
					'appfrom' => mdate('%Y-%m-%d', strtotime($app_from)),
					'appto' => mdate('%Y-%m-%d', strtotime($app_to)),

				);
				$this->profile_model->add_update_appointment($data_array);
		}
	}

	//Education backgroud
	public function auto_save_educ_background(){
		$this->load->model('profile_model');

		$eductype = $this->input->post('eductype');
		$educdegree = $this->input->post('educdegree');
		$educremarks = $this->input->post('educremarks');
		$educnameschool = $this->input->post('educnameschool');
		$educstatus = $this->input->post('educstatus');
		$id = $this->input->post('educ_id');
		$fileno = $this->input->post('fileno');

		$data_array = array(
				'staff_id' => $fileno,
				'type' => $eductype,
				'degree' => $educdegree,
				'status' => $educstatus,
				'remarks' => $educremarks,
				'school_address' => $educnameschool
			);

		if ($id) {
			$this->profile_model->insert_update_educ_background($data_array, $id);
		} else if ($educdegree != null) {
			$this->profile_model->add_educ_background($data_array);

		}

		redirect(ROOT_URL.'modules/employees/'.$fileno);
	}

	public function delete_appointment(){
		$this->load->model('profile_model');
		$appid = $this->input->post('appid');
		$data = $this->profile_model->del_emp_appointment($appid);

		echo json_encode($data);
	}


	public function delete_educational_background(){
		$this->load->model('profile_model');
		$appid = $this->input->post('appid');
		$data = $this->profile_model->del_emp_appointment($appid);

		echo json_encode($data);
	}

	public function add_leave_credit()
	{
		$this->_check_login();
		$this->load->model('profile_model');

		$leave_type = $this->input->post('leave_type');
		$leave_credit = $this->input->post('leave_credit');
		$leave_id = $this->input->post('leave_id');
		$employee_id = $this->input->post('employee_id');

		for ($i = 0; $i < count($leave_id); $i++) {
			if($leave_id[$i] == 0){
				$this->profile_model
						->insert_leave_credits([
										'empid' => $employee_id,
										'type_id' => $leave_type[$i],
										'leave_credit' => $leave_credit[$i],
										'date_added' => mdate('%Y-%m-%d'),
										'status' => 1,
									]);
						
			}else{
				$x = $this->profile_model->update_leave_credits($leave_type[$i],$leave_credit[$i], $leave_id[$i]);
			}
		}
    		
       	redirect(ROOT_URL.'modules/employees/'.$employee_id);

	}

	public function get_leave_records_dt(){
		$this->load->model('profile_model');
		$staffid = $this->input->post('staff_id');
		$ltype = $this->input->post('ltype');

		$lists = $this->profile_model->get_leave_records($ltype, $staffid);
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				
				$data['data'][] = array(
								'id' 			=> $value->id,
								'employee' 			=> $value->LastName.', '.$value->FirstName.' '.$value->MiddleName,
								'type' 		=> $value->type,
								'days_remain' 	=> 0,
								'leave_from' 	=> $value->leave_from,
								'leave_to' 	=> $value->leave_to,
								'num_days'=> $value->num_days,
								'reason' 		=> $value->reason,
								'depremarks' 		=> $value->dept_head_approval_remarks,
								'dayswithpay' 		=> $value->dayswithpay,
								'dayswithoutpay' 		=> $value->dayswithoutpay,
								'hr_remarks' 		=> $value->hr_remarks,
							);
			}
		}

		echo json_encode($data);
	}

	public function get_overtime_records_dt()
	{
		$this->load->model('hris/profile_model');

		$staff_overtime_id = $this->input->post('overtime_id');
		$lists = $this->profile_model->get_overtime_application($staff_overtime_id);


		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {

				$data['data'][] = array(
								'id' 		=> $value->id,
								'empid' 				=> $value->empid,
								'reason'			=> $value->reason,
								'hours_requested'			=> $value->hours_requested,
								'date_overtime'			=> $value->date_overtime,
								'timefrom' 		=> $value->timefrom,
								'timeto' 	=> $value->timeto,
								'hours_rendered' 	=> $value->hours_rendered,
								'dept_head_approval'=> $value->dept_head_approval,
								'dept_head_date_approval' => $value->dept_head_date_approval,
								'dept_head_empid' 	=> $value->dept_head_empid,
								'remarks' => $value->remarks,
							);
			}
		}

		echo json_encode($data);
	}

	public function get_passlip_records_dt()
	{
		$this->load->model('hris/profile_model');

		$staff_id = $this->input->post('staff_id');
		$lists = $this->profile_model->get_pass_slip_application($staff_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {

				$data['data'][] = array(
								'id' 		=> $value->id,
								'type' 				=> $value->type,
								'slip_date'			=> mdate('%M %d, %Y', strtotime($value->slip_date)),
								'destination'		=> $value->destination,
								'purpose'			=> $value->purpose,
								'exp_timeout' 		=> $value->exp_timeout,
								'exp_timreturn' 	=> $value->exp_timreturn,
								'exact_timeout' 	=> $value->exact_timeout,
								'exact_timereturn' 	=> $value->exact_timereturn,
								'numhours' 			=> $value->numhours,
								'exact_numhours' 	=> $value->exact_numhours,
								'exp_undertime' 	=> $value->exp_undertime,
								'exact_undertime' 	=> $value->exact_undertime,
								'dept_head_approval'=> $value->dept_head_approval,
								'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
								'dept_head_empid' 	=> $value->dept_head_empid,
							);
			}
		}
		echo json_encode($data);
	}

	public function get_travelo_records_dt()
	{
		$this->load->model('hris/profile_model');

		$staff_id = $this->input->post('staff_id');
		$lists = $this->profile_model->get_travel_form($staff_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {

				$data['data'][] = array(
								'id' 				=> $value->id,
								'travelo_date' 		=> mdate('%M %d, %Y', strtotime($value->travelo_date)),
								'destination' 		=> $value->destination,
								'purpose' 			=> $value->purpose,
								'date_of_travel' 	=> mdate('%M %d, %Y', strtotime($value->datefrom))." - ".mdate('%M %d, %Y', strtotime($value->dateto))." (".$value->numberofdays." day/s)",
								'remarks' 			=> $value->remarks,
								'dept_head_date_approval'					=>mdate('%M %d, %Y', strtotime($value->dept_head_date_approval))
 							);
			}
		}

		echo json_encode($data);
	}

	public function update_leave_record()
	{
		$this->_check_login();
		$this->load->model('profile_model');

		$leavefrom = date('Y-m-d', strtotime($this->input->post('leavefrom')));
		$leaveto = date('Y-m-d', strtotime($this->input->post('leaveto')));
		$dayswithpay = $this->input->post('dayswithpay');
		$available = $this->input->post('available');
		$vacl = $this->input->post('vacl');
		$availablevacleave = $this->input->post('availablevacleave');
		$vacid = $this->input->post('vacid');
		$remark = $this->input->post('remark');
		$numdays = $this->input->post('numdays');
		$dayswithoutpay = $this->input->post('dayswithoutpay');
		$lid = $this->input->post('lid');
		$numdays = $this->input->post('numdays');


		if($available <= 0 && isset($vacl) && $vacl != ""){
			$vacbalance = $availablevacleave - $vacl;
	        $vacbalance = $availablevacleave - $dayswithpay;
	        $balance = $dayswithpay;
        	$vacation = $vacl;

			$this->profile_model->update_leave_record($lid,$remark, $numdays, $dayswithpay, $dayswithoutpay, $leavefrom, $leaveto, $vacation);
			$this->profile_model->update_leave_remain($lid,$vacbalance);
		}else{
	        $balance = $available - $dayswithpay;
			$this->profile_model->update_leave_record($lid,$remark, $numdays, $dayswithpay, $dayswithoutpay,  $leavefrom, $leaveto, $vacation='');
			$this->profile_model->update_leave_remain($lid,$balance);
		}		
    	$data['success'] = true;
    	
		echo json_encode($data);

	}

	public function viewdata(){
		$this->load->model('profile_model');

		$input = $this->input->post('view_emp_data');

		$data['info'] = $this->profile_model->view_emp_basic_data($input);
		$data['leave'] = $this->profile_model->get_emp_leave_credits($input);
		
		echo json_encode($data);

	}

	public function leave_balance(){
		$this->load->model('profile_model');

		$ltype_id = $this->input->post('ltype_id');
		$employee_id = $this->input->post('emp_id');
		$leave_credit = $this->profile_model->get_emp_leave_type_credit($employee_id, $ltype_id);
		$leave_balance = $this->profile_model->get_used_leave_type($employee_id, $ltype_id);
		$balance = ($leave_credit ? $leave_credit[0]->leave_credit : 0);
		if($leave_balance && $leave_balance[0]->dayswithpay != null)
		{
			$balance = $leave_credit[0]->leave_credit - $leave_balance[0]->dayswithpay;
		}
		
		echo json_encode($balance);
	}

	public function add_leave_application()
	{
		$this->load->model('profile_model');

		$employee_id  = 	$this->input->post('employee_id');
		$leavetype 	  = 	$this->input->post('leavetype');
		$datefiled 	  = 	$this->input->post('datefiled');
		$fromdate 	  = 	$this->input->post('fromdate');
		$todate 	  = 	$this->input->post('todate');
		$reason 	  = 	$this->input->post('reason');
		$actualdays	  = 	$this->input->post('actualdays');
		$dayswithpay  = 	$this->input->post('dayswithpay');
		$dayswitouthpay= 	$this->input->post('dayswitouthpay');
		$remarks 	  = 	$this->input->post('remarks');
		$leave_status = 	$this->input->post('leave_status');
		$date_approve = 	$this->input->post('date_approve_decline');
		$dept_remarks = 	$this->input->post('dept_remarks');
		$daysavailable=		$this->input->post('daysavailable');
		$data_array	  =      array(
									'empid' => $employee_id,
									'leave_type_id' => $leavetype,
									'reason' => $reason,
									'leave_from' => mdate('%Y-%m-%d', strtotime($fromdate)),
									'leave_to' => mdate('%Y-%m-%d', strtotime($todate)),
									'num_days' => $actualdays,
									'date_filed' => mdate('%Y-%m-%d', strtotime($datefiled)),
									'dept_head_approval' => $leave_status,
									'dept_head_date_approval' => mdate('%Y-%m-%d', strtotime($date_approve)),
									'dept_head_approval_remarks' => $dept_remarks,
									'hr_remarks' => $remarks,
									'dayswithpay' => $dayswithpay,
									'dayswithoutpay' => $dayswitouthpay
								);
		if($this->input->post('leave_id')){
			$this->profile_model
					->update_leave_application($data_array, $this->input->post('leave_id'));
		}else{
			$this->profile_model
					->insert_leave_application($data_array);
		}

		if($this->input->post('hr_approval')){
			redirect(base_url('employee_leave_requests'));
       	}else{
       		redirect(base_url('employee_leave_records'));
       	}

	}

	public function add_overtime_application()
	{
		$this->load->model('profile_model');

		$employee_id  = $this->input->post('employee_id');
		$overtime_date 	  = 	$this->input->post('overtime_date');
		$fromtime 	  = $this->input->post('fromtime');
		$totime 	  = $this->input->post('totime');
		$numhours 	  = $this->input->post('numhours');
		$reason 	  = $this->input->post('reason');
		$remarks 	  =	$this->input->post('remarks');
		$dept_head_approval  = $this->input->post('dept_head_approval');
		$date_approve_decline = $this->input->post('date_approve_decline');

		if($this->input->post("overt_id")){
			$dept_head_approval  = $this->input->post('dept_head_approval');
			$date_approve_decline = $this->input->post('date_approve_decline');
			$date = mdate('%Y-%m-%d', strtotime($date_approve_decline));

			}else{
				$dept_head_approval  =0;
				$date = NULL;
		}
		$data_array = array(
				'empid' => $employee_id,
				'date_overtime' => mdate('%Y-%m-%d', strtotime($overtime_date)),
				'timefrom' => $fromtime,
				'timeto' => $totime,
				'hours_rendered' => $numhours,
				'reason' => $reason,
				'remarks' => $remarks,
				'dept_head_approval' => $dept_head_approval,
				'dept_head_date_approval' => mdate('%Y-%m-%d', strtotime($date_approve_decline)),
			);

		if($this->input->post('overt_id')){
			$this->profile_model
					->update_overtime_application($data_array, $this->input->post('overt_id'));
		}else{
			$this->profile_model
					->insert_overtime_application($data_array);
		}

		if($this->input->post('hr_approval')){
			redirect(base_url('employee_leave_records'));
       	}else{
       		redirect(base_url('employee_overtime_form'));
       	}

	}


	public function add_pass_slip_application()
	{

		$this->load->model('profile_model');

		$employee_id  		= 	$this->input->post('employee_id');
		$type 				= 	$this->input->post('pass_slip_type');
		$slip_date  		= 	$this->input->post('slip_date');
		$destination 	  	= 	$this->input->post('destination');
		$reason 	  		= 	$this->input->post('purpose');
		$timeout 	  		= 	$this->input->post('from');
		$timereturn 	  	= 	$this->input->post('to');
		$numhours 	  		= 	$this->input->post('numhours');
		$exp_undertime 	  	= 	$this->input->post('undertime');

		if($this->input->post("pass_slip_id")){
		$exact_timeout  			= 	$this->input->post('exact_from');
		$exact_timereturn 			=	$this->input->post('exact_to');
		$exact_numhours 			= 	$this->input->post('exact_numhours');
		$exact_undertime 			= 	$this->input->post('exact_undertime');
			}else{
			$exact_timeout			= 	NULL;
			$exact_timereturn		=	NULL;
			$exact_numhours			=	NULL;
			$exact_undertime		= 	'';
		}

		if($this->input->post('hr_approval')){
		$dept_head_approval  		= 	$this->input->post('dept_head_approval');
		$date_approve_decline 		=	$this->input->post('date_approve_decline');
		$date = mdate('%Y-%m-%d', strtotime($date_approve_decline));
		}else{
			$dept_head_approval  	= NULL;
			$date 					= NULL;
			}

			

		$data_array	 = array(
				'empid' 			=> $employee_id,
				'type' 				=> $type,
				'slip_date'			=> mdate('%Y-%m-%d', strtotime($slip_date)),
				'destination'		=> $destination,
				'purpose'			=> $reason,
				'exp_timeout'		=> $timeout,
				'exp_timreturn'		=> $timereturn,
				'numhours' 			=> $numhours,
				'exp_undertime'		=> $exp_undertime,
				'exact_timeout'		=> $exact_timeout,
				'exact_timereturn'	=> $exact_timereturn,
				'exact_numhours' 	=> $exact_numhours,
				'exact_undertime'	=> $exact_undertime,
				'dept_head_approval' => $dept_head_approval,
				'dept_head_date_approval' 	=> $date,
				);

		if($this->input->post('pass_slip_id')){
			$this->profile_model
					->update_pass_slip_application($data_array, $this->input->post('pass_slip_id'));
		}else{
			$this->profile_model
					->insert_pass_slip_application($data_array);
		}


		if($this->input->post('hr_approval')){
			redirect(base_url('employee_leave_records'));
       	}else{
       		redirect(base_url('employee_passslip_form'));
       	}

	}
	public function add_travel_order_application()
	{
		$this->load->model('profile_model');

		$employee_id  		= 	$this->input->post('employee_id');
		$destination 	  	= 	$this->input->post('destination');
		$reason 	  		= 	$this->input->post('purpose');
		$fromdate 	  		= 	$this->input->post('fromdate');
		$todate 	  	= 	$this->input->post('todate');
		$numdays 	  		= 	$this->input->post('numdays');

		if($this->input->post('hr_approval')){
		$to_status  	= 	$this->input->post('to_status');
		$date_approve_decline 	=	$this->input->post('date_approve_decline');
		$date = mdate('%Y-%m-%d', strtotime($date_approve_decline));
		}else{
		$to_status = 0;
		$date = null;
		}

		$data_array	  =      array(
								'empid' 			=> $employee_id,
								'travelo_date'		=> mdate('%Y-%m-%d'),
								'destination'		=> $destination,
								'purpose'			=> $reason,
								'datefrom'				=> mdate('%Y-%m-%d', strtotime($fromdate)),
								'dateto'			=> mdate('%Y-%m-%d', strtotime($todate)),
								'numberofdays' 			=> $numdays,
								'dept_head_approval' 	=> $to_status,
								'dept_head_date_approval' 	=> $date,
								);

		if($this->input->post('travelo_id')){
			$this->profile_model
					->update_travel_order_application($data_array, $this->input->post('travelo_id'));
		}else{
			$this->profile_model
					->inser_travel_order_application($data_array);
		}

		if($this->input->post('hr_approval')){
			redirect(base_url('employee_leave_requests'));
       	}else{
       		redirect(base_url('employee_travel_order_form'));
       	}

	}


	
	public function view_leave()
	{
		$this->load->model('hris/hris_model');
		$this->load->model('hris/profile_model');

		$leave_id = $this->input->post('leave_id');

		$lists = $this->hris_model->get_emp_leave_records($leave_id);
		

		$data['info'] = [];
		$fileno = 0;
		$ltype_id = 0;
		foreach ($lists as $key => $value) {
			$emp = $this->profile_model->view_emp_basic_data($value->empid);
			$fileno = $emp[0]->FileNo;
			$ltype_id = $value->leave_type_id;
			$data['info'][] = array(
							'biometrics' 			=> $emp[0]->BiometricsID,
							'fileno' 				=> $emp[0]->FileNo,
							'name' 					=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 				=> $emp[0]->position,
							'department' 			=> $emp[0]->DEPTNAME,
							'date_filed' 			=> mdate('%m/%d/%Y', strtotime($value->date_filed)),
							'leave_type' 			=> $value->type,
							'leave_type_id' 		=> $value->leave_type_id,
							'leave_from'			=> mdate('%M %d, %Y', strtotime($value->leave_from)),
							'leave_to'				=> mdate('%M %d, %Y', strtotime($value->leave_to)),
							'num_days' 				=> $value->num_days,
							'reason' 				=> $value->reason,
							'days_with_pay' 		=> $value->dayswithpay,
							'days_without_pay' 		=> $value->dayswithoutpay,
							'leave_id' 				=> $value->id,
							'dept_head_approval' 	=> $value->dept_head_approval,
							'head_date_approval' 	=> mdate('%m/%d/%Y', strtotime($value->dept_head_date_approval)),
							'head_approval_remarks' => $value->dept_head_approval_remarks,
							'hr_remarks' 			=> $value->hr_remarks
						);
		}

		$data['leave'] = $this->profile_model->get_emp_leave_type_credit($fileno, $ltype_id);

		echo json_encode($data);
	}



}
