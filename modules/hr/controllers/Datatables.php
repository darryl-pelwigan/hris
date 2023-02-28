<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Datatables extends MY_Controller {

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
		$this->load->module('hr/login');
		$this->load->module('template/template');
		$this->load->model('hr/employee_model');
		$this->load->model('hr/hr_model');
		$this->load->model('hr/attendance_model');
		$this->load->model('teacher_profile/user_model');
		// $this->load->model('hr/hr_model2');
	}
	
	public function get_emp_lists()
	{
		
		$lists = $this->employee_model->get_employees($active = 1);
		$data['data'] = [];

		
		foreach ($lists as $key => $value) {
			$elig = $this->employee_model->get_emp_staff_eligibilities($value->BiometricsID);
			$elig_list = [];
			for ($i=0; $i < count($elig) ; $i++) { 
				if ($elig[$i]) {
					array_push($elig_list, $elig[$i]->eligname);

				}
			}
			$eligibilities = implode(' , ', $elig_list);

			$educ = $this->employee_model->get_emp_staff_educ_background($value->BiometricsID, 'Completed');
			$educ_type = [];
			$educ_degree = [];
			for ($i=0; $i < count($educ) ; $i++) { 
				if ($educ[$i])  {
					array_push($educ_type, $educ[$i]->type);
					array_push($educ_degree, $educ[$i]->degree);
				}
			}	

			$title_lists = '';
			$education = '';
			if ( in_array('Doctorate', $educ_type) ) {
				$title_lists = $this->employee_model->get_emp_staff_highest_educ($value->BiometricsID, 'Completed', 'Doctorate');
				$education = $title_lists[0]->degree;
			} 
			else if ( !in_array('Doctorate', $educ_type) && in_array('Masters', $educ_type) ){

				$title_lists = $this->employee_model->get_emp_staff_highest_educ($value->BiometricsID, 'Completed', 'Masters');
				$education = $title_lists[0]->degree;
			} 
			else if( !in_array('Doctorate', $educ_type) && !in_array('Masters', $educ_type) && in_array('Bachelor', $educ_type) ){
				$title_lists = $this->employee_model->get_emp_staff_highest_educ($value->BiometricsID, 'Completed', 'Bachelor');
				$education = $title_lists[0]->degree;
			}
			
			$data['data'][] = array(
				'biometrics' 	=> $value->BiometricsID,
				'fileno' 		=> $value->FileNo,
				'lastname' 			=> $value->LastName,
				'firstname' 		=> $value->FirstName,
				'middlename' 	=> $value->MiddleName,
				'position' 	=> $value->position,
				'department'=> $value->DEPTNAME,
				'birthdate' 		=> date('j F Y', strtotime($value->birth_date)),
				'age' 		=> $value->age,
				'sex' 		=> $value->sex,
				'civil_status' 		=> $value->civil_status,
				'religion' 		=> $value->religion,
				'date_employ' 		=> date('j F Y', strtotime($value->dateofemploy)),
				'yrs_service' 		=> $value->yearsofservice,
				'end_contract' 		=> date('j F Y', strtotime($value->end_of_contract)),
				'teaching' 		=> $value->teaching,
				'union' 		=> $value->isUnion,
				'employment_status' 		=> $value->emp_status,
				'nature_employment' 		=> $value->nature_emp,
				'home_address' 		=> str_replace('|', ',', $value->home_address),
				'prov_address' 		=> str_replace('|', ',', $value->prov_address),
				'email_address' 		=> $value->email,
				'contact' 		=> $value->mobile_no,
				'w_dependents' 		=> $value->wo_with_dependents,
				'tin' 		=> $value->tin,
				'sss' 		=> $value->sss,
				'love' 		=> $value->pagibig,
				'health' 		=> $value->philhealth,
				'peraa' 		=> $value->peraa,
				'person_emergency' 		=> $value->person_contact_emergency,
				'address_emergency' 		=> $value->person_address,
				'emergency_contact' 		=> $value->contact_number,
				'relationship' 		=> $value->relation_person,
				'highest_educ' 		=> $education,
				'eligibilities' 		=> $eligibilities,
			);
		}
		echo json_encode($data);
	}

	public function get_emp_lists_inactive()
	{
		$lists = $this->employee_model->get_employees($active = 0);
		
		$data['data'] = [];

		foreach ($lists as $key => $value) {
			if($value->lastday != ''){
				$lastday = date('j F Y', strtotime($value->lastday));
			}else{
				$lastday = '';
			}
			

			$data['data'][] = array(
						'biometrics' 	=> $value->BiometricsID,
						'fileno' 		=> $value->FileNo,
						'name' 			=> $value->LastName.', '.$value->FirstName.' '.$value->MiddleName,
						'position' 		=> $value->position,
						'dept_name' 	=> $value->DEPTNAME,
						'dateofemploy' 	=> $value->dateofemploy,
						'yearsofservice'=> $value->yearsofservice,
						'teaching' 		=> $value->teaching,
						'separation' 	=> '<b>Reason :'.$value->leavereason.'</b><br><b>Last Day: '.$lastday.' </b>'
					);
		}

		echo json_encode($data);
	}

	public function get_leave_records()
	{

		$lists = $this->hr_model->get_emp_leave_records(0);
		
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
							'biometrics' 		=> $emp[0]->BiometricsID,
							'fileno' 			=> $emp[0]->FileNo,
							'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 			=> $emp[0]->position,
							'department' 		=> $emp[0]->DEPTNAME,
							'leave_type' 		=> $value->type,
							'leave_from'		=> $value->leave_from,
							'leave_to'			=> $value->leave_to,
							'num_days' 			=> $value->num_days,
							'reason' 			=> $value->reason,
							'days_with_pay' 	=> $value->dayswithpay,
							'days_without_pay' 	=> $value->dayswithoutpay,
							'leave_id' 			=> $value->id
						);
			}
		}

		echo json_encode($data);
	}

	public function get_summary_records(){
		$lists = $this->hr_model->get_emp_leave_records_summary(0);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
							'biometrics' 		=> $emp[0]->BiometricsID,
							'fileno' 			=> $emp[0]->FileNo,
							'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 			=> $emp[0]->position,
							'department' 		=> $emp[0]->DEPTNAME,
							'leave_type' 		=> $value->type,
							'leave_from'		=> $value->leave_from,
							'leave_to'			=> $value->leave_to,
							'num_days' 			=> $value->num_days,
							'reason' 			=> $value->reason,
							'days_with_pay' 	=> $value->dayswithpay,
							'days_without_pay' 	=> $value->dayswithoutpay,
							'leave_id' 			=> $value->id
						);
			}
		}
		echo json_encode($data);
	}

	// public function get_all_leave_records_summary()
	// {
	// 	$lists = $this->hr_model->get_emp_leave_records_summary(0);
		
	// 	$data['data'] = [];
	// 	if($lists){
	// 		foreach ($lists as $key => $value) {
	// 			$emp = $this->employee_model->view_emp_basic_data($value->empid);

	// 			$data['data'][] = array(
	// 						'biometrics' 		=> $emp[0]->BiometricsID,
	// 						'fileno' 			=> $emp[0]->FileNo,
	// 						'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
	// 						'position' 			=> $emp[0]->position,
	// 						'department' 		=> $emp[0]->DEPTNAME,
	// 						'leave_type' 		=> $value->type,
	// 						'leave_from'		=> $value->leave_from,
	// 						'leave_to'			=> $value->leave_to,
	// 						'num_days' 			=> $value->num_days,
	// 						'reason' 			=> $value->reason,
	// 						'days_with_pay' 	=> $value->dayswithpay,
	// 						'days_without_pay' 	=> $value->dayswithoutpay,
	// 						'leave_id' 			=> $value->id
	// 					);
	// 		}
	// 	}

	// 	echo json_encode($data);
	// }

	public function get_leave_credits()
	{
		$lists = $this->hr_model->get_emp_leave_credits(0);
		
		$data['data'] = [];

		if($lists) {
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$leave_bal = $this->employee_model->get_used_leave_type($value->empid, $value->type_id);
				$leave_used = ($leave_bal ? $leave_bal[0]->dayswithpay : 0);
				$total_balance = $value->leave_credit - $leave_used;
				$data['data'][] = array(
						'biometrics' 		=> $emp[0]->BiometricsID,
						'fileno' 			=> $emp[0]->FileNo,
						'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
						'position' 			=> $emp[0]->position,
						'department' 		=> $emp[0]->DEPTNAME,
						'teaching' 			=> $emp[0]->teaching,
						'leave_type' 		=> $value->type,
						'leave_type_id' 	=> $value->type_id,
						'credit'			=> $value->leave_credit,
						'credit_date'		=> $value->date_added,
						'balance' 			=> $total_balance
					);
			}
		}

		echo json_encode($data);
	}

	public function get_overtime_records()
	{
		$overt_id = $this->input->post('overt_id');

		$lists = $this->hr_model->get_emp_overtime_records($overt_id);
	
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
							'biometrics' 		=> $emp[0]->BiometricsID,
							'fileno' 			=> $emp[0]->FileNo,
							'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 			=> $emp[0]->position,
							'department' 		=> $emp[0]->DEPTNAME,
							'date_ot' 			=> $value->date_overtime,
							'timefrom'			=> $value->timefrom,
							'timeto'			=> $value->timeto,
							'hours_requested' 	=> $value->hours_requested,
							'hours_rendered' 	=> $value->hours_rendered,
							'reason' 			=> $value->reason,
							'dept_head_approval'=> $value->dept_head_approval,
							'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
							'remarks' 			=> $value->remarks,
							'overt_id' 			=> $value->id
						);

				
			}
		}
		echo json_encode($data);
	}

	public function get_passlip_records()
	{
		$pass_slip_id = $this->input->post('pass_slip_id');
		$lists = $this->hr_model->get_emp_pass_slip_records($pass_slip_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
					'biometrics' 		=> $emp[0]->BiometricsID,
					'fileno' 			=> $emp[0]->FileNo,
					'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
					'position' 			=> $emp[0]->position,
					'department' 		=> $emp[0]->DEPTNAME,
					'type' 				=> $value->type,
					'slip_date'			=> mdate('%M %d, %Y', strtotime($value->slip_date)),
					'destination'		=> $value->destination,
					'purpose'			=> $value->purpose,
					'exp_timeout' 		=> $value->exp_timeout,
					'exp_timreturn' 	=> $value->exp_timreturn,
					'numhours' 			=> $value->numhours,
					'exp_undertime' 	=> $value->exp_undertime,
					'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
					'dept_head_empid' 	=> $value->dept_head_empid,
					'pass_slip_id' 		=> $value->id
				);
			}
		}

		echo json_encode($data);
	}
	public function get_official_passlip_records()
	{
		$pass_slip_id = $this->input->post('pass_slip_id');
		$lists = $this->hr_model->get_emp__official_pass_slip_records($pass_slip_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
					'biometrics' 		=> $emp[0]->BiometricsID,
					'fileno' 			=> $emp[0]->FileNo,
					'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
					'position' 			=> $emp[0]->position,
					'department' 		=> $emp[0]->DEPTNAME,
					'type' 				=> $value->type,
					'slip_date'			=> mdate('%M %d, %Y', strtotime($value->slip_date)),
					'destination'		=> $value->destination,
					'purpose'			=> $value->purpose,
					'exp_timeout' 		=> $value->exp_timeout,
					'exp_timreturn' 	=> $value->exp_timreturn,
					'numhours' 			=> $value->numhours,
					'exp_undertime' 	=> $value->exp_undertime,
					'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
					'dept_head_empid' 	=> $value->dept_head_empid,
					'pass_slip_id' 		=> $value->id
				);
			}
		}

		echo json_encode($data);
	}


	public function get_passlip_records_summary(){
		$pass_slip_id = $this->input->post('pass_slip_id');
		$lists = $this->hr_model->get_emp_pass_slip_records_summary($pass_slip_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
					'biometrics' 		=> $emp[0]->BiometricsID,
					'fileno' 			=> $emp[0]->FileNo,
					'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
					'position' 			=> $emp[0]->position,
					'department' 		=> $emp[0]->DEPTNAME,
					'type' 				=> $value->type,
					'slip_date'			=> mdate('%M %d, %Y', strtotime($value->slip_date)),
					'destination'		=> $value->destination,
					'purpose'			=> $value->purpose,
					'exp_timeout' 		=> $value->exp_timeout,
					'exp_timreturn' 	=> $value->exp_timreturn,
					'numhours' 			=> $value->numhours,
					'exp_undertime' 	=> $value->exp_undertime,
					'dept_head_approval'=> $value->dept_head_approval,
					'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
					'dept_head_empid' 	=> $value->dept_head_empid,
					'pass_slip_id' 		=> $value->id
				);
			}
		}

		echo json_encode($data);
	}

	public function get_official_passlip_records_summary(){
		$pass_slip_id = $this->input->post('pass_slip_id');
		$lists = $this->hr_model->get_emp__official_pass_slip_records_summary($pass_slip_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
					'biometrics' 		=> $emp[0]->BiometricsID,
					'fileno' 			=> $emp[0]->FileNo,
					'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
					'position' 			=> $emp[0]->position,
					'department' 		=> $emp[0]->DEPTNAME,
					'type' 				=> $value->type,
					'slip_date'			=> mdate('%M %d, %Y', strtotime($value->slip_date)),
					'destination'		=> $value->destination,
					'purpose'			=> $value->purpose,
					'exp_timeout' 		=> $value->exp_timeout,
					'exp_timreturn' 	=> $value->exp_timreturn,
					'numhours' 			=> $value->numhours,
					'exp_undertime' 	=> $value->exp_undertime,
					'dept_head_approval'=> $value->dept_head_approval,
					'dept_head_date_approval' => mdate('%M %d, %Y', strtotime($value->dept_head_date_approval)),
					'dept_head_empid' 	=> $value->dept_head_empid,
					'pass_slip_id' 		=> $value->id
				);
			}
		}

		echo json_encode($data);
	}


	public function get_travel_order_records()
	{
		$travelo_id = $this->input->post('travelo_id');
		$lists = $this->hr_model->get_emp_travel_order_records($travelo_id);
		
		$data['data'] = [];
		if ($lists) {
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
							'biometrics' 		=> $emp[0]->BiometricsID,
							'fileno' 			=> $emp[0]->FileNo,
							'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
							'position' 			=> $emp[0]->position,
							'department' 		=> $emp[0]->DEPTNAME,
							'travelo_date' 		=> mdate('%m/%d/%Y', strtotime($value->travelo_date)),
							'datefrom'			=> mdate('%m/%d/%Y', strtotime($value->datefrom)),
							'dateto'			=> mdate('%m/%d/%Y', strtotime($value->dateto)),
							'destination' 		=> $value->destination,
							'numberofdays' 		=> $value->numberofdays,
							'purpose' 			=> $value->purpose,
							'dept_head_approval' 	=> $value->dept_head_approval,
							'dept_head_date_approval' 	=> mdate('%m/%d/%Y', strtotime($value->dept_head_date_approval)),
							'remarks' 			=> $value->remarks,
							'travelo_id' 		=> $value->id,

						);
			}
		}
		echo json_encode($data);
	}

	public function get_emp_position_lists(){

		$lists = $this->hr_model->get_emp_position();
		
		$data['data'] = [];

		foreach ($lists as $key => $value) {
			$data['data'][] = array(
				'id' 			=> $value->id,
				'position' 		=> $value->position,
				'union' 		=> $value->union,
				'payperhour' 	=> $value->payperhour,
				'position_category' => $value->position_category,
			);
		}

		echo json_encode($data);
	}

	public function get_emp_timekeeping()
	{

		$fdate = date("Y-m-d", strtotime($this->input->post("fdate")));
		$tdate = date("Y-m-d", strtotime($this->input->post("tdate")));

		$lists = $this->attendance_model->get_timekeeping_records($fdate, $tdate);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {

				$data['data'][] = array(
								'biometrics' 		=> $value->badgenumber,
								'fileno' 			=> $value->fileno,
								'name' 				=> $value->lastname.', '.$value->firstname,
								'position' 			=> $value->position,
								'department' 		=> $value->deptname,
								'datetime' 			=> mdate('%M %d, %Y %H:%i:%s', strtotime($value->datetime)),
								'status' 			=> ($value->status == 0 ? 'C/In' : 'C/Out'),
								'location'			=> $value->location,
								'verifycode'		=> ($value->verifycode == 0 ? 'FP' : 'P'),
							);
			}
		}

		echo json_encode($data);
	}

	public function get_emp_attendance()
	{

		$fdate 	  = date("Y-m-d", strtotime($this->input->post("fdate")));
		$tdate 	  = date("Y-m-d", strtotime($this->input->post("tdate")));
		$teaching = $this->input->post("teaching");
		$department= $this->input->post("department");

		$lists = $this->attendance_model->get_attendance_records($fdate, $tdate, $teaching, $department);

		$data['data'] = [];

		if($lists){
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
					'biometrics' 	=> $value->biono,
					'fileno' 		=> $value->fileno,
					'name' 			=> $value->lastname.', '.$value->firstname,
					'position' 		=> $value->position,
					'department' 	=> $value->deptname,
					'teaching' 		=> ($value->teaching == 1 ? 'Teaching' : 'Non-teaching'),
					'date' 			=> mdate('%M %d, %Y', strtotime($value->date)),
					'totalhours' 	=> $value->totalhours,
					'regularhours'	=> $value->regularhours,
					'tardiness'		=> $value->tardiness,
					'overtime'		=> $value->overtime,
					'undertime'		=> $value->undertime,
					'status'		=> $value->status,
					'remarks'		=> $value->remarks,
					'tdate' 		=> date('m/d/Y', strtotime($tdate)),
					'fdate' 		=> date('m/d/Y', strtotime($fdate))
				);
			}
		}
		
		echo json_encode($data);
	}

	public function get_list_holidays()
	{
		$holiday_id = $this->input->post('holiday_id');
		$holidays = $this->hr_model->get_holidays($holiday_id);
		
		$data['data'] = [];
		$days = [];
		$months = [];
		if ($holidays) {
			foreach ($holidays as $key => $value) {
				$month = explode(' ', $value->holiday_date);
				$mon = '';
				switch ($month[0]) {
					case 'January':
						$date = 1;
						break;
					case 'February':
						$date = 2;
						break;
					case 'March':
						$date = 3;
						break;
					case 'April':
						$date = 4;
						break;
					case 'May':
						$date = 5;
						break;
					case 'June':
						$date = 6;
						break;
					case 'July':
						$date = 7;
						break;
					case 'August':
						$date = 8;
						break;
					case 'September':
						$date = 9;
						break;
					case 'October':
						$date = 10;
						break;
					case 'November':
						$date = 11;
						break;
					case 'December':
						$date = 12;
						break;
					default:
						$date = 0;
						break;
				}
				$time = strtotime(''.date('Y').'/'.$date.'/'.$month[1].'');
				$newformat = date('Y-m-d',$time);
				$day_of_week = date('l', strtotime($newformat));
				// array_push($days, $day_of_week);

				$data ['data'][] = array(
					'holiday_id' => $value->holiday_id,
					'date' => $value->holiday_date,
					'day_of_week' => $day_of_week,
					'description' => $value->description,
					'type' => $value->type,
				);
			}
		}


		echo json_encode($data);
	}

	public function get_service_log_dt()
	{
		$lists = $this->hr_model->get_service_log();
		$data['data'] = [];
		if ($lists) {
			foreach ($lists as $key => $value) {
				$emp = $this->employee_model->view_emp_basic_data($value->empid);

				$data['data'][] = array(
					'biometrics' 		=> $emp[0]->BiometricsID,
					'fileno' 			=> $emp[0]->FileNo,
					'name' 				=> $emp[0]->LastName.', '.$emp[0]->Firstname,
					'position' 			=> $emp[0]->position,
					'department' 		=> $emp[0]->DEPTNAME,
					'leave_credits' 	=> $value->leave_credits,
					'date_added'		=> mdate('%m/%d/%Y', strtotime($value->date_added)),
					'date_created'		=> mdate('%m/%d/%Y', strtotime($value->date_added)),
					'service_log_id' 	=> $value->id,
				);
			}
		}

		echo json_encode($data);
	}

	public function get_status_leave_requests()
	{
		$status = $this->input->post('status');
		$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
		$position_id = $fileno[0]->PositionRank;
		$dept_id = $fileno[0]->Department;
		$teaching = $fileno[0]->teaching;

		$approving_ranks = $this->employee_model->get_head_approving_ranks($position_id);
		$requests = [];
		$data['data'] = [];

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$requests = $this->employee_model->get_pending_approved_leave_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);
				if($requests){
					foreach($requests as $key=>$value)
					{
						$data['data'][] = array(
							'name' 			=> $value->lastname.', '.$value->firstname,
							'ltype' 		=> $value->type,
							'num_days' 		=> $value->num_days,
							'leave_dates' 	=> mdate('%M %d, %Y', strtotime($value->leave_from)) .' to '. mdate('%M %d, %Y', strtotime($value->leave_to)),
							'date_filed'	=> $value->date_filed,
							'reason' 		=> $value->reason,
							'leave_id'		=> $value->leave_id
						);
					}
				}
			}
		}
		
		echo json_encode($data);
	}


	public function get_overtime_requests()
	{
		$status = $this->input->post('status');

		$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
		$position_id = $fileno[0]->PositionRank;
		$dept_id = $fileno[0]->Department;
		$teaching = $fileno[0]->teaching;

		$approving_ranks = $this->employee_model->get_head_approving_ranks($position_id);
		$requests = [];
		$data['data'] = [];

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$requests = $this->employee_model->get_pending_approved_overtime_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);
				if($requests){
					foreach($requests as $value)
					{
						$data['data'][] = array(
							'id' 			=> $value->overtime_id,
							'name' 			=> $value->lastname.', '.$value->firstname,
							'date_overtime' => mdate('%M %d, %Y', strtotime($value->date_overtime)),
							'timefrom' 		=> $value->timefrom,
							'timeto' 		=> $value->timeto,
							'numhours' 		=> $value->hours_rendered,
							'reason' 		=> $value->reason,
						);
					}
				}
			}
		}

		echo json_encode($data);
	}

	public function get_pass_slip_requests()
	{
		$status = $this->input->post('status');

		// print($status);
		$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
		$position_id = $fileno[0]->PositionRank;
		$dept_id = $fileno[0]->Department;
		$teaching = $fileno[0]->teaching;

		$approving_ranks = $this->employee_model->get_head_approving_ranks($position_id);
		$requests = [];
		$data['data'] = [];

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$requests = $this->employee_model->get_pending_approved_pay_slip_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);
				if($requests){
					foreach($requests as $value)
					{
						$data['data'][] = array(
							'id' 			=> $value->pass_slip_id,
							'name' 			=> $value->lastname.', '.$value->firstname,
							'type' 			=> $value->type,
							'slip_date' 	=> mdate('%M %d, %Y', strtotime($value->slip_date)),
							'destination' 	=> $value->destination,
							'purpose' 		=> $value->purpose,
							'exp_timeout' 	=> $value->exp_timeout,
							'exp_timreturn' => $value->exp_timreturn,
							'numhours' 		=> $value->numhours,
							'exp_undertime' => $value->exp_undertime,
						);
					}
				}
			}
		}

	
		echo json_encode($data);
	}

	public function get_travelo_requests()
	{
		$status = $this->input->post('status');
		
		$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
		$position_id = $fileno[0]->PositionRank;
		$dept_id = $fileno[0]->Department;
		$teaching = $fileno[0]->teaching;
		$approving_ranks = $this->employee_model->get_head_approving_ranks($position_id);
		$requests = [];
		$data['data'] = [];
				

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$requests = $this->employee_model->get_pending_approved_travelo_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);
				if($requests){
					foreach($requests as $value)
					{
						$data['data'][] = array(
										'id' 				=> $value->travel_id,
										'name' 				=> $value->lastname.', '.$value->firstname,
										'travelo_date' 		=> mdate('%M %d, %Y', strtotime($value->travelo_date)),
										'destination' 		=> $value->destination,
										'purpose' 			=> $value->purpose,
										'date_of_travel' 	=> mdate('%M %d, %Y', strtotime($value->datefrom))." - ".mdate('%M %d, %Y', strtotime($value->dateto))." (".$value->numberofdays." day/s)",
										'remarks' 			=> $value->remarks,
									);
					}
				}
			}
		}

		
		echo json_encode($data);
	}

	public function get_all_leave_application(){

		$users = $this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');

		if ($users[0]->role == 'Human Resource') {
			$post = $this->input->post('view');
			$output = '';

			//Leave Requests
			$lists = $this->hr_model->get_all_leave_records_hr_notif();
			$leave_count = 0;
			if ($lists) {		
				foreach ($lists as $key => $value) {
					$leave_count++;

					$diff = date_diff(date_create($value->date_requested), date_create());
					$date_time_diff = '';

					if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
						$date_time_diff = $diff->format("%I minutes");
					} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
						$date_time_diff = $diff->format("%H hour %I minutes");
					} else {
						$date_time_diff = $diff->format("%a days %H hour %I minutes");
					}

					$seen_by = [];
					$seeners = $this->hr_model->get_all_notification_seener($value->id, $this->session->userdata('id') );
					if ($seeners) {
						foreach ($seeners as $key => $s) {
							array_push($seen_by, $s->seen_empid);
						}
					}

					if ( in_array( $this->session->userdata('id'), $seen_by) ) {
						$leave_count--;
					} else {
						$leave_count;
					}

					if ($seeners) {

						if ($seeners[0]->highlight_status  == 0) {
							$output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_leave_requests'). '" class="leave_link_notif" id="'.$value->id.'">
				                    <div>
				                        <i class="fa fa-share fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> ' .$value->type. ' </i> Leave Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
							
						} else {
							$output .= '<li style="text-align: left;">
				                <a href="' .base_url('employee_leave_requests'). '">
				                    <div>
				                        <i class="fa fa-share fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> ' .$value->type. ' </i> Leave Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						}
					} else {
						$output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_leave_requests'). '" class="leave_link_notif" id="'.$value->id.'">
				                    <div>
				                        <i class="fa fa-share fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> ' .$value->type. ' </i> Leave Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
					}


					if ($post == 'yes') {

						$notification_array = array(
							'seen_empid' => $this->session->userdata('id'),
							'leave_app_id' => $value->id,
							'notif_status' => 1,
							'date_seen' => date('Y-m-d H:i:s')
						);

						$notification_list = $this->hr_model->get_notication_seen_lists($this->session->userdata('id'), $value->id );
						if ($notification_list) {
							$this->hr_model->update_notification_status($notification_array, $value->id, $this->session->userdata('id'));
						} else {
							$this->hr_model->insert_notification_status($notification_array);
							
						}
						
					}
				} // end of foreach for Leave Notification

				//Expiration License Notification
				

			}

			//Overtime Requests
			$overtime_lists = $this->hr_model->get_all_overtime_records_hr_notif();
			$overtime_count = 0;

			if ($overtime_lists) {		
				foreach ($overtime_lists as $key => $value) {
					$overtime_count++;

					$diff = date_diff(date_create($value->date_requested), date_create());
					$date_time_diff = '';

					if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
						$date_time_diff = $diff->format("%I minutes");
					} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
						$date_time_diff = $diff->format("%H hour %I minutes");
					} else {
						$date_time_diff = $diff->format("%a days %H hour %I minutes");
					}

					$seen_by = [];
					$seeners = $this->hr_model->get_all_overtime_seener($value->id, $this->session->userdata('id') );
					if ($seeners) {
						foreach ($seeners as $key => $s) {
							array_push($seen_by, $s->seen_empid);
						}
					}

					if ( in_array( $this->session->userdata('id'), $seen_by) ) {
						$overtime_count--;
						

					} else {
						$overtime_count;
						
					}


					if ($seeners) {

						if ($seeners[0]->highlight_status  == 0) {
							$output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_overtime_requests_approval'). '" id="'.$value->id.'" class="overtime_link_notif">
				                    <div>
				                        <i class="fa fa-clock-o fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Overtime </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
							
						} else {
							$output .= '<li style="text-align: left;">
				                <a href="' .base_url('employee_overtime_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-clock-o fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Overtime </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						}
					} else {
						$output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_overtime_requests_approval'). '" id="'.$value->id.'" class="overtime_link_notif">
				                    <div>
				                        <i class="fa fa-clock-o fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Overtime </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
					}

					if ($post == 'yes') {

						$notification_array = array(
							'seen_empid' => $this->session->userdata('id'),
							'overtime_id' => $value->id,
							'notif_status' => 1,
							'date_seen' => date('Y-m-d H:i:s')
						);

						$notification_list = $this->hr_model->get_notication_overtime_lists($this->session->userdata('id'), $value->id );

						if ($notification_list) {
							$this->hr_model->update_notification_overtime_status($notification_array, $value->id, $this->session->userdata('id'));
						} else {
							$this->hr_model->insert_notification_overtime_status($notification_array);
							
						}
						
					}
				} // end of foreach
			} 

			// Pass Slip Requests
			$pass_lists = $this->hr_model->get_all_pass_records_hr_notif();
			$pass_count = 0;

			if ($pass_lists) {		
				foreach ($pass_lists as $key => $value) {
					$pass_count++;

					$diff = date_diff(date_create($value->date_requested), date_create());
					$date_time_diff = '';

					if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
						$date_time_diff = $diff->format("%I minutes");
					} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
						$date_time_diff = $diff->format("%H hour %I minutes");
					} else {
						$date_time_diff = $diff->format("%a days %H hour %I minutes");
					}

					$seen_by = [];
					$seeners = $this->hr_model->get_all_pass_seener($value->id, $this->session->userdata('id') );
					if ($seeners) {
						foreach ($seeners as $key => $s) {
							array_push($seen_by, $s->seen_empid);
						}
					}

					if ( in_array( $this->session->userdata('id'), $seen_by) ) {
						$pass_count--;
					} else {
						$pass_count;
					}

					if ($seeners) {

						if ($seeners[0]->highlight_status  == 0) {
							$output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_passslip_requests_approval'). '" id="'.$value->id.'" class="pass_link_notif">
				                    <div>
				                        <i class="fa fa-clipboard fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Pass Slip </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
							
						} else {
							$output .= '<li style="text-align: left;">
					                <a href="' .base_url('employee_passslip_requests_approval'). '">
					                    <div>
					                        <i class="fa fa-clipboard fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Pass Slip </i> Request
					                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
					                    </div>
					                </a>
					            </li>
					            <hr class="divider">';
						}
					} else {
						$output .= '<li style="background-color: #bbff99; text-align: left;">
				                 <a href="' .base_url('employee_passslip_requests_approval'). '" id="'.$value->id.'" class="pass_link_notif">
				                    <div>
				                        <i class="fa fa-clipboard fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Pass Slip </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
					}

					if ($post == 'yes') {

						$notification_array = array(
							'seen_empid' => $this->session->userdata('id'),
							'pass_slip_id' => $value->id,
							'notif_status' => 1,
							'date_seen' => date('Y-m-d H:i:s')
						);

						$notification_list = $this->hr_model->get_notication_pass_lists($this->session->userdata('id'), $value->id );

						if ($notification_list) {
							$this->hr_model->update_notification_pass_status($notification_array, $value->id, $this->session->userdata('id'));
						} else {
							$this->hr_model->insert_notification_pass_status($notification_array);
							
						}
						
					}
				} // end of foreach
			} 

			// Travel Form Requests
			$travel_lists = $this->hr_model->get_all_travel_records_hr_notif();
			$travel_count = 0;

			if ($travel_lists) {		
				foreach ($travel_lists as $key => $value) {
					$travel_count++;

					$diff = date_diff(date_create($value->date_requested), date_create());
					$date_time_diff = '';

					if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
						$date_time_diff = $diff->format("%I minutes");
					} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
						$date_time_diff = $diff->format("%H hour %I minutes");
					} else {
						$date_time_diff = $diff->format("%a days %H hour %I minutes");
					}

					$seen_by = [];
					$seeners = $this->hr_model->get_all_travel_seener($value->id, $this->session->userdata('id'));

					if ($seeners) {
						foreach ($seeners as $key => $s) {
							array_push($seen_by, $s->seen_empid);
						}
					}

					if ( in_array( $this->session->userdata('id'), $seen_by) ) {
						$travel_count--;
					} else {
						$travel_count;
					}

					if ($seeners) {
						
						if ($seeners[0]->highlight_status  == 0) {
								$output .= '<li style="background-color: #bbff99; text-align: left;">
							                <a href="' .base_url('employee_travelform_requests_approval'). '" id="'.$value->id.'" class="travel_link_notif">
							                    <div>
							                        <i class="fa fa-plane fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Travel Form </i> Request
							                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
							                    </div>
							                </a>
							            </li>
							            <hr class="divider">';	
							
						} else {
							$output .= '<li style="text-align: left;>
						                <a href="' .base_url('employee_travelform_requests_approval'). '">
						                    <div>
						                        <i class="fa fa-plane fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Travel Form </i> Request
						                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
						                    </div>
						                </a>
						            </li>
						            <hr class="divider">';	
						}
					} else {

						$output .= '<li style="background-color: #bbff99; text-align: left;">
						                <a href="' .base_url('employee_travelform_requests_approval'). '" id="'.$value->id.'" class="travel_link_notif">
						                    <div>
						                        <i class="fa fa-plane fa-fw"></i>'.$value->LastName. ',' .$value->FirstName.' Sent <i style="color: green;"> Travel Form </i> Request
						                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
						                    </div>
						                </a>
						            </li>
						            <hr class="divider">';	
					}

					if ($post == 'yes') {

						$notification_array = array(
							'seen_empid' => $this->session->userdata('id'),
							'travel_id' => $value->id,
							'notif_status' => 1,
							'date_seen' => date('Y-m-d H:i:s')
						);

						$notification_list = $this->hr_model->get_notication_travel_lists($this->session->userdata('id'), $value->id );

						if ($notification_list) {
							$this->hr_model->update_notification_travel_status($notification_array, $value->id, $this->session->userdata('id'));
						} else {
							$this->hr_model->insert_notification_travel_status($notification_array);
							
						}
						
					}
				} // end of foreach
			}

			$count_notif = $leave_count + $overtime_count + $pass_count + $travel_count;
			
			$data = array(
				'notification' => $output,
				'unseen_notification' => $count_notif
			);

			echo json_encode($data);

		} else { // end of Human Resources
			 $this->get_user_leave_notification();

		}
	}

	public function get_user_leave_notification(){

		$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
		$position_id = $fileno[0]->PositionRank;
		$dept_id = $fileno[0]->Department;
		$teaching = $fileno[0]->teaching;
		$status = 0;

		$post = $this->input->post('view');

		$approving_ranks = $this->employee_model->get_head_approving_ranks($position_id);
		$leave_requests = [];
		$data['leave'] = [];
		$leave_count = 0;

		$leave_output = '';
		$date_request_output = '';

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$leave_requests = $this->employee_model->get_pending_approved_leave_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);

				if($leave_requests){
					foreach($leave_requests as $key=>$value)
					{
						$leave_count++;

						$date_request_output .= $value->date_requested;

						$seen_by = [];
						$seeners = $this->hr_model->get_all_notification_seener($value->leave_id, $this->session->userdata('id') );

						$diff = date_diff(date_create($value->date_requested), date_create());
						$date_time_diff = '';

						if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
							$date_time_diff = $diff->format("%I minutes");
						} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
							$date_time_diff = $diff->format("%H hour %I minutes");
						} else {
							$date_time_diff = $diff->format("%a days %H hour %I minutes");
						}

						if ($seeners) {
							foreach ($seeners as $key => $s) {
								array_push($seen_by, $s->seen_empid);
							}
						}

						if ( in_array( $this->session->userdata('id'), $seen_by) ) {
							$leave_count--;
							$leave_output .= '<li style="text-align:left;>
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-share fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> ' .$value->type. ' </i> Leave Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						} else {
							$leave_count;
							$leave_output .= '<li style="background-color: #bbff99; text-align: left;" >
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-share fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> ' .$value->type. ' </i> Leave Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						}

				        if ($post == 'yes') {

							$notification_array = array(
								'seen_empid' => $this->session->userdata('id'),
								'leave_app_id' => $value->leave_id,
								'notif_status' => 1,
								'date_seen' => date('Y-m-d H:i:s')
							);

							$notification_list = $this->hr_model->get_notication_seen_lists($this->session->userdata('id'), $value->leave_id );
							if ($notification_list) {
								$this->hr_model->update_notification_status($notification_array, $value->leave_id, $this->session->userdata('id'));
							} else {
								$this->hr_model->insert_notification_status($notification_array);
							}
						}
			            
					}
				}
			}
		}

		$overtime_requests = [];
		$data['overtime'] = [];
		$overtime_count = 0;

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$overtime_requests = $this->employee_model->get_pending_approved_overtime_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);
				if($overtime_requests){
					foreach($overtime_requests as $value)
					{
						$overtime_count++;

						$date_request_output .= $value->date_requested;

						$diff = date_diff(date_create($value->date_requested), date_create());
						$date_time_diff = '';

						if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
							$date_time_diff = $diff->format("%I minutes");
						} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
							$date_time_diff = $diff->format("%H hour %I minutes");
						} else {
							$date_time_diff = $diff->format("%a days %H hour %I minutes");
						}

						$seen_by = [];
						$seeners = $this->hr_model->get_all_overtime_seener($value->overtime_id, $this->session->userdata('id') );

						if ($seeners) {
							foreach ($seeners as $key => $s) {
								array_push($seen_by, $s->seen_empid);
							}
						}

						if ( in_array( $this->session->userdata('id'), $seen_by) ) {
							$overtime_count--;
							$leave_output .= '<li style="text-align:left;>
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div">
				                        <i class="fa fa-clock-o fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> Overtime </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						} else {
							$overtime_count;
							$leave_output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div">
				                        <i class="fa fa-clock-o fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> Overtime </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						}



			            if ($post == 'yes') {

							$notification_array = array(
								'seen_empid' => $this->session->userdata('id'),
								'overtime_id' => $value->overtime_id,
								'notif_status' => 1,
								'date_seen' => date('Y-m-d H:i:s')
							);

							$notification_list = $this->hr_model->get_notication_overtime_lists($this->session->userdata('id'), $value->overtime_id );

							if ($notification_list) {
								$this->hr_model->update_notification_overtime_status($notification_array, $value->overtime_id, $this->session->userdata('id'));
							} else {
								$this->hr_model->insert_notification_overtime_status($notification_array);
							}

						}

					}
				}
			}
		}

		$pass_requests = [];
		$data['pass'] = [];
		$pass_count = 0;
		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$pass_requests = $this->employee_model->get_pending_approved_pay_slip_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);
				if($pass_requests){
					foreach($pass_requests as $value)
					{
						$pass_count++;

						$date_request_output .= $value->date_requested;

						$diff = date_diff(date_create($value->date_requested), date_create());
						$date_time_diff = '';

						if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
							$date_time_diff = $diff->format("%I minutes");
						} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
							$date_time_diff = $diff->format("%H hour %I minutes");
						} else {
							$date_time_diff = $diff->format("%a days %H hour %I minutes");
						}

						$seen_by = [];
						$seeners = $this->hr_model->get_all_pass_seener($value->pass_slip_id, $this->session->userdata('id') );

						if ($seeners) {
							foreach ($seeners as $key => $s) {
								array_push($seen_by, $s->seen_empid);
							}
						}

						if ( in_array( $this->session->userdata('id'), $seen_by) ) {
							$pass_count--;
							$leave_output .= '<li style="text-align: left;">
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-clipboard fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> Pass Slip </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						} else {
							$pass_count;
							$leave_output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-clipboard fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> Pass Slip </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						}

			        	if ($post == 'yes') {

							$notification_array = array(
								'seen_empid' => $this->session->userdata('id'),
								'pass_slip_id' => $value->pass_slip_id,
								'notif_status' => 1,
								'date_seen' => date('Y-m-d H:i:s')
							);

							$notification_list = $this->hr_model->get_notication_pass_lists($this->session->userdata('id'), $value->pass_slip_id );

							if ($notification_list) {
								$this->hr_model->update_notification_pass_status($notification_array, $value->pass_slip_id, $this->session->userdata('id'));
							} else {
								$this->hr_model->insert_notification_pass_status($notification_array);
							}

						}


					}
				}
			}
		}

		$travel_requests = [];
		$data['travel'] = [];
		$travel_count = 0;

		if ($approving_ranks) {
			foreach($approving_ranks as $r)
			{
				$travel_requests = $this->employee_model->get_pending_approved_travelo_requests($r->category, $dept_id, $status, $r->category_approval, $teaching);

				if($travel_requests){
					foreach($travel_requests as $value)
					{
						$travel_count++;

						$date_request_output .= $value->date_requested;

						$diff = date_diff(date_create($value->date_requested), date_create());
						$date_time_diff = '';

						if ($diff->format("%a") == 0 && $diff->format("%H") == 00 ) {
							$date_time_diff = $diff->format("%I minutes");
						} else if (  $diff->format("%a") == 0 && $diff->format("%H") != 00  ) {
							$date_time_diff = $diff->format("%H hour %I minutes");
						} else {
							$date_time_diff = $diff->format("%a days %H hour %I minutes");
						}	

						$seen_by = [];
						$seeners = $this->hr_model->get_all_travel_seener($value->travel_id, $this->session->userdata('id'));

						if ($seeners) {
							foreach ($seeners as $key => $s) {
								array_push($seen_by, $s->seen_empid);
							}
						}

						if ( in_array( $this->session->userdata('id'), $seen_by) ) {
							$travel_count--;
							$leave_output .= '<li style="text-align: left;">
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-plane fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> Travel Form </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						} else {
							$travel_count;
							$leave_output .= '<li style="background-color: #bbff99; text-align: left;">
				                <a href="' .base_url('employee_requests_approval'). '">
				                    <div>
				                        <i class="fa fa-plane fa-fw"></i>'.$value->lastname. ',' .$value->firstname.' Sent <i style="color: green;"> Travel Form </i> Request
				                        <span class="pull-right text-muted small">'.$date_time_diff.' ago</span>
				                    </div>
				                </a>
				            </li>
				            <hr class="divider">';
						}

			            if ($post == 'yes') {

							$notification_array = array(
								'seen_empid' => $this->session->userdata('id'),
								'travel_id' => $value->travel_id,
								'notif_status' => 1,
								'date_seen' => date('Y-m-d H:i:s')
							);

							$notification_list = $this->hr_model->get_notication_travel_lists($this->session->userdata('id'), $value->travel_id );

							if ($notification_list) {
								$this->hr_model->update_notification_travel_status($notification_array, $value->travel_id, $this->session->userdata('id'));
							} else {
								$this->hr_model->insert_notification_travel_status($notification_array);
							}

						}


					}
				}
			}
		}

		$notification_count = $travel_count + $pass_count + $leave_count + $overtime_count;
		
		$data_notification = array(
			'notification' => $leave_output,
			'unseen_notification' => $notification_count,
			'date_requested' => $date_request_output,
		);

		echo json_encode($data_notification);

	}

	public function update_highlight_status(){
		$id = $this->input->post('id');
		$user = $this->session->userdata('id');
		$data = $this->hr_model->update_travel_highlights($id, $user);
		echo json_encode($data);
	}

	public function pass_highlight_status(){
		$id = $this->input->post('id');
		$user = $this->session->userdata('id');
		$data = $this->hr_model->update_pass_seen_status($id, $user);
		echo json_encode($data);
	}

	public function overtime_highlight_status(){
		$id = $this->input->post('id');
		$user = $this->session->userdata('id');		
		$data = $this->hr_model->update_overtime_seen_status($id, $user);
		echo json_encode($data);
	}

	public function leave_highlight_status(){
		$id = $this->input->post('id');
		$user = $this->session->userdata('id');		
		$data = $this->hr_model->update_leave_seen_status($id, $user);
		echo json_encode($data);
	}

	public function get_message_notification(){
		$users = $this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$userid = $this->session->userdata('id');
		$notifcount = 0;
		// $seen_status = 0;
		$expiry_id = 0;
		$unseen_count = $this->hr_model->count_unseen_expiry_notification();
        if($users[0]->role == 'Human Resource'){
            $query = $this->hr_model->get_license_expired();
            $notifcount = $query->num_rows();
            $notif = "";
			
            if ($notifcount > 0) {
                foreach($query->result() as $r){
                $expiry_id = $r->id;
                        // <a href="'.base_url('employees/').$r->BiometricsID.'">
                $notif .= '
                    <li id="expiry_notif" name="'.$r->id.'" class="'.$r->highlight_status.'" style="display: block; text-align: left;">
                        <a href="">
                            <div><i class="fa fa-exchange"></i>
                                <strong>'.$r->FirstName.' '.$r->LastName.'</strong><br>
                                <span class="text-muted">
                                    <b>'.$r->eligname.' license expires on '.date('F d, Y', strtotime($r->expiry)).' </b>
                                </span>
                            </div>
                        </a>
                    </li>
                    <hr class="divider"/>
                    ';
                    // check if exists
                    $expiry_notif = $this->hr_model->get_expiry_seen_notification($userid, $r->id);
                    if ($expiry_notif->num_rows() <= 0) { // if not create
                    	$this->hr_model->insert_expiry_seen_notification($userid, $r->id);
                    } else { // else.. update seen status to 1
                    	$this->hr_model->update_seen_expiry_notification($userid, $r->id);
                    	// $seen_status = 1;
                    }
                }
            } else {
            	$notif .= '
                    <li id="expiry_notif" name="" style="display: block;">
                        <a href="">
                            <div>
                                <strong>No new notifications</strong><br>
                                <span class="text-muted">
                                </span>
                            </div>
                        </a>
                    </li>
                    ';
            }
            $data = array(
				'notif' => $notif,
				'count' => $notifcount,
				// 'seen_status' => $seen_status,
				'expiry_id' => $expiry_id,
				'unseen_count' => $unseen_count->num_rows()
			);
			echo json_encode($data);
        }
	}

	public function message_notif_highlight() { // change highlight status upon notif click
		$id = $this->input->post('id');
		$user = $this->session->userdata('id');
		$data = $this->hr_model->highlight_expiry_seen_notification($user, $id);
		echo json_encode($data);
	}

	public function get_emp_non_teaching_leavecredits()
	{
		
		$lists = $this->employee_model->get_employees_byclassify($active = 1, $classification = 0); //non-teaching
		$data['data'] = [];

		foreach ($lists as $key => $value) {
			
			##get total VL
			$vl = $this->employee_model->get_emp_leave_type_credit($value->FileNo, $vl=1);	

			$data['data'][] = array(
				'biometrics' 		=> $value->BiometricsID,
				'fileno' 			=> $value->FileNo,
				'lastname' 			=> $value->LastName,
				'firstname' 		=> $value->FirstName,
				'middlename' 		=> $value->MiddleName,
				'position' 			=> $value->position,
				'department' 		=> $value->DEPTNAME,
				'date_employ' 		=> date('j F Y', strtotime($value->dateofemploy)),
				'yrs_service' 		=> $value->yearsofservice,
				'teaching' 			=> $value->teaching,
				'employment_status' => strtolower($value->emp_status),
				'nature_employment' => $value->nature_emp,
				'vl_credit'			=> ($vl[0]->leave_credit) ? $vl[0]->leave_credit : 0
			);
		}
		echo json_encode($data);
	}

	public function get_biometric_attendance(){

		$fdate 	  = date("Y-m-d", strtotime($this->input->post("fdate")));
		$tdate 	  = date("Y-m-d", strtotime($this->input->post("tdate")));
		$teaching = $this->input->post("teaching");
		$department= $this->input->post("department");

		$lists = $this->attendance_model->get_biometrics_records($fdate, $tdate, $teaching, $department);




		$data['data'] = [];

		if($lists){
			foreach ($lists as $key => $value) {

				if ($value->fileno != null) {
					$status = '';

					if ($value->status == 0) {
						$status = 'Time In';
					} else {
						$status = 'Time Out';
					}



					$data['data'][] = array(
						'id' 	=> $value->id,
						'biometrics' 	=> $value->badgenumber,
						'fileno' 		=> $value->fileno,
						'name' 			=> $value->lastname.', '.$value->firstname,
						'position' 		=> $value->position,
						'department' 	=> $value->deptname,
						'teaching' 		=> ($value->teaching == 1 ? 'Teaching' : 'Non-teaching'),
						'date' 			=> mdate('%M %d, %Y', strtotime($value->datetime)),
						'time' 			=> date('h:i a', strtotime($value->datetime)),
						'status'		=> $status,
						'exception'		=> $value->test,
						// 'tardiness'		=> $value->tardiness,
						// 'overtime'		=> $value->overtime,
						// 'undertime'		=> $value->undertime,
						// 'remarks'		=> $value->remarks,
						'tdate' 		=> date('m/d/Y', strtotime($tdate)),
						'fdate' 		=> date('m/d/Y', strtotime($fdate))
					);

				}

			}
		}
		
		echo json_encode($data);


	}
}
