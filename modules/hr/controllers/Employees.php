<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employees extends MY_Controller {

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
		$this->load->model('hr/employee_model');
		$this->load->model('hr/hr_model');
		$this->load->model('teacher_profile/user_model');
	}
	
	public function index()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		// $data['user'] =$this->employee_model->get_user_info($fileno);
		$data['user'] =$this->user_model->get_user_info($this->session->userdata('id'));

		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['dept_lists'] =$this->hr_model->get_department_lists();	
		$data['load_yos'] = true;
		##VIEW CONTENT
		$data['view_content']='hr/employee_lists';
		$data['get_plugins_js'] = 'hr/js/plugins_js_emp_lists';
		$data['get_dt_js'] = 'hr/js/datatables_js';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function inactive()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		##VIEW CONTENT
		$data['view_content']='hr/employee_lists_inactive';
		$data['get_plugins_js'] = 'hr/js/plugins_js_emp_lists';
		$data['get_dt_js'] = 'hr/js/datatables_js';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function employee_postions(){
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['view_content']='hr/employee_postions_list';
		$data['get_plugins_js'] = 'hr/js/plugins_js_emp_lists';
		$data['get_dt_js'] = 'hr/js/datatables_js';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function employee_years_service(){
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['view_content']='hr/employee_years_service';
		$data['get_plugins_js'] = 'hr/js/plugins_js_emp_lists';
		$data['get_dt_js'] = 'hr/js/datatables_js.php';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}


	public function search(){
		$search = $this->input->post('search');
		$data = $this->employee_model->search_employee($search);
		echo json_encode($data);

	}

	public function viewdata(){
		$input = $this->input->post('view_emp_data');

		$data['info'] = $this->employee_model->view_emp_basic_data($input);
		$data['leave'] = $this->hr_model->get_emp_leave_credits($input);
		$leave_type_lists = $this->employee_model->get_leave_type_lists();

		$leave_credit_id = [];

		if ($data['leave']) {
			foreach ($data['leave'] as $key => $value) {
				array_push($leave_credit_id, $value->type_id );
			}
		}

		$leave_type_lists_id = [];
		foreach ($leave_type_lists as $key => $lt) {
			array_push($leave_type_lists_id, $lt->id);
		}

		$diff_result = array_values(array_diff($leave_type_lists_id, $leave_credit_id ) );


		if (($key = array_search(7, $diff_result)) !== false) {
			unset($diff_result[$key]);
		}
		if (($key = array_search(8, $diff_result)) !== false) {
			unset($diff_result[$key]);
		}
		if (($key = array_search(10, $diff_result)) !== false) {
			unset($diff_result[$key]);
		}


		if ( $data['info'][0]->sex  == 'Female') {
			if (($key = array_search(6, $diff_result)) !== false) {
				unset($diff_result[$key]);
			}
		} else {
			if (($key = array_search(5, $diff_result)) !== false) {
				unset($diff_result[$key]);
			}
		}

		$diff_sequence = array_values($diff_result);

		$default_leave = [];
		for ($i=0; $i < count($diff_sequence) ; $i++) { 
			$default_leave = $this->employee_model->get_leave_type_lists_id( $diff_sequence[$i] );

			$data['leave'][] = (object) array(
				"leave_credit" => $default_leave[0]->days,
	            "type_id" => $default_leave[0]->id,
	            "type" => $default_leave[0]->type,
	            "id" => 'NULL',
			);
		}

		echo json_encode($data);
	}

	public function service_credits()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['view_content']='hr/employee_service_leave_log';
		$data['get_plugins_js'] = 'hr/js/plugins_js_emp_lists';
		$data['get_dt_js'] = 'hr/js/datatables_js.php';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function religion_list(){
		$data = $this->employee_model->get_religion_list();
		echo json_encode($data);
	}

	public function eligList(){
		$data = $this->employee_model->get_eligibilities_list();
		echo json_encode($data);
	}

	public function get_position_details(){
		$id = $this->input->post('id');
		$lists =$this->hr_model->get_position_details($id);
		$data['data'] = [];
		foreach ($lists as $key => $value) {
			$data = array(
				'id' => $value->id,
				'position' => $value->position,
				'position_category' => $value->position_category,
			);
		}
		echo json_encode($data);

	}
	public function add_update_emp_posision(){
		$id = $this->input->post('position_id');
		$position_name = $this->input->post('position_name');
		$position_category = $this->input->post('position_category');

		$data = array(
			'position' => $position_name,
			'position_category' => $position_category,
		);

		if ($id) {
			$this->hr_model->update_employee_position($data, $id);
		} else {
			$this->hr_model->insert_employee_position($data);
		}

		redirect(base_url('employee_position_record'));
	}

	public function delete_position_details(){
		$id = $this->input->post('id');
		$data = $this->hr_model->del_position_details($id);
		echo json_encode($data);
	}

	public function get_years_of_service_record(){
		$fileno = $this->input->post('fileno');
		$data = [];

		$employee = $this->employee_model->get_user_info($fileno);
		$teaching = $employee[0]->teaching;
		$status = $employee[0]->emp_status;
		$biono = $employee[0]->BiometricsID;
		$data['dateofemploy'] = $employee[0]->dateofemploy;

		$dateofemploy =  new DateTime($employee[0]->dateofemploy);
        $current = new DateTime();

        $diff = $current->diff($dateofemploy);
        $yearsofservice = ($diff->format('%Y')).' year/s, '.($diff->format('%m')).' month/s, '. ($diff->format('%d')). ' day/s';
        $data['yos_complete'] = $yearsofservice;
        $data['yos'] = $employee[0]->yearsofservice;

		if($teaching == 0){
            $data['type'] = 1;
		}

		if($teaching == 1 && $status == 'regular'){
            $data['type'] = 1;
		}

		if($teaching == 1 && $status != 'regular'){
            $data['type'] = 2;
			$data['getsemsy'] =  $this->employee_model->get_credits_sem_sy($fileno);
			$inisc = $this->employee_model->get_init_service_credits($fileno);
			$data['ini_sc'] = ($inisc) ? $inisc[0]->service_credits : 0; 
			// $data['getsubjects'] =  $this->employee_model->get_schedule_details($biono);
		}

		echo json_encode($data);
	}

	public function update_years_of_service($empid){
		##list employees
		$employees = $this->employee_model->get_staff($active = 1, $empid);

		foreach($employees as $emp){
			$teaching =  $emp->teaching;
			$status  = $emp->emp_status;
			$empid = $emp->FileNo;
			$biono = $emp->BiometricsID;
			$department = $emp->Department;
			$employdate = $emp->dateofemploy;
			$yearsofservice = 0;

			##non-teaching
			if($teaching == 0){
				$dateofemploy =  new DateTime($employdate);
	            $current = new DateTime();

	            $diff = $current->diff($dateofemploy);
	            $yearsofservice = ($diff->format('%Y')).' year/s, '.($diff->format('%m')).' month/s';

			}

			if($teaching == 1 && $status == 'regular'){
				$dateofemploy =  new DateTime($employdate);
	            $current = new DateTime();

	            $diff = $current->diff($dateofemploy);
	            $yearsofservice = ($diff->format('%Y')).' year/s, '.($diff->format('%m')).' month/s';
	         
			}

			if($teaching == 1 && $status != 'regular'){
				$semsy =  $this->employee_model->get_schedule_sem_sy($biono);

				if($semsy){
					foreach($semsy as $val){
						$sc = $this->employee_model->get_teaching_credits_sem_sy($empid, $val->semester, $val->schoolyear);
						if(!$sc){
							$credits = 0;
							##dentistry
							##22 full unis
							if($department == 12){
								if($val->totalunits >= 17){
									$credits = 1;
								}else{
									$credits = 0.5;
								}
							}else{
								if($val->totalunits >= 18){
									$credits = 1;
								}else{
									$credits = 0.5;
								}
							}
							$data = array(
										'empid' => $empid,
										'sem' => $val->semester,
										'sy' => $val->schoolyear,
										'totalunits' => $val->totalunits,
										'credits' => $credits,
									);

							$this->employee_model->insert_service_credit($data);
						}

					}

				}

				##get all service credit
				$initial = $this->employee_model->get_init_service_credits($empid);
				$initialcredit = ($initial) ? $initial[0]->service_credits : 0;
				$allservicec = $this->employee_model->get_all_emp_service_credits($empid);
				$ser_credits =  ($allservicec) ? $allservicec[0]->credits : 0;
				$yearsofservice = $initialcredit + $ser_credits;
				
			}

			if ($teaching == 1) {

				$getsemsy =  $this->employee_model->get_credits_sem_sy($empid);

				$tmp = array();

				if ( $getsemsy) {
					foreach($getsemsy as $arg){
						if ($arg->sem != 3) {
						    $tmp[$arg->sy][][] = $arg->totalunits;
						}
					}
				}

				$result = array();

				if ($tmp) {
					foreach ($tmp as $sy => $totalunits) {
						$result[] = array( 'sem' => $sy, 'totalunits' => $totalunits);
					}
				}

				if ( !empty($result) ) {
					foreach ($result as $res) {

						$first_val = (isset($res['totalunits'][0])) ? $res['totalunits'][0][0] : 0;
						$second_val = (isset($res['totalunits'][1])) ? $res['totalunits'][1][0] : 0;

						if ($department != 12) {
							if( $first_val >= 24 && $second_val >= 24){
								// dito yung code sa pag save nang leave credits for 3 VL and 3 SL for full load employee leaves
								
								
							}
						} else {
							if( $first_val >= 18 && $second_val >= 18){
								// dito yung code sa pag save nang leave credits for 3 VL and 3 SL for full load employee leaves
							}
						}


					}
				}
			
				// foreach ($tmp as $key) {

				// 	for ($i=0; $i < count($key) ; $i++) { 

				// 		if( $key[$i]['sem'] != 3 ){
				// 			$first_sem = ($key[$i]['sem'] == 1 && $key[$i]['totalunits'] >= 24 ) ? '1' : '0' ;
				// 			$second_sem = ($key[$i]['sem'] == 2 && $key[$i]['totalunits'] >= 24 ) ? '1' : '0' ;

				// 			if ($first_sem == 1 && $second_sem == 1) {
				// 				// dito mag insert yung credits niya
				// 			}
							

				// 		} 
				// 	}
				// }

				
			}


			##update YOS in pcc_staff
			$this->employee_model->update_emp_yos($empid, $yearsofservice);
		}

		// die();
		echo true;
	}

	public function add_update_initial_yos(){
		$empid = $this->input->post('empid');
		$initialyos = $this->input->post('initialyos');

		$data = array(
			'empid' => $empid,
			'service_credits' => $initialyos,
			'date_added' => date('Y-m-d')
		);

		$initial = $this->employee_model->get_init_service_credits($empid);

		if ($initial) {
			$this->employee_model->update_initial_yos($data, $empid);
		} else {
			$this->employee_model->insert_initial_yos($data);
		}

		$this->update_years_of_service($empid);

		redirect($this->agent->referrer());
	}

	public function get_employee_data($fileno){
		$data['info'] = $this->employee_model->view_emp_basic_data($fileno);

		echo json_encode($data);
	}	

	public function employee_leave_credits(){
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['view_content']='hr/employee_leave_credits';
		$data['get_plugins_js'] = 'hr/js/plugins_js_leave_ot_records';
		$data['get_dt_js'] = 'hr/js/datatables_js.php';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	// public function update_employee_leave_credits(){
	// 	##list employees
	// 	$employees = $this->employee_model->get_staff($active = 1, $empid);
	// 	foreach($employees as $emp){
	// 		$teaching =  $emp->teaching;
	// 		$status  = $emp->emp_status;
	// 		$empid = $emp->FileNo;
	// 		$biono = $emp->BiometricsID;
	// 		$department = $emp->Department;
	// 		$employdate = $emp->dateofemploy;
	// 		$yearsofservice = 0;

	// 		##List all leave types 
	// 		$leave_type_lists = $this->employee_model->get_leave_type_lists();
	// 		foreach($leave_type_lists as $lt){
				
	// 		}

	// 		$this->employee_model->insert_initial_yos($data);

	// 		$this->update_years_of_service($empid);
	// 	}
	// }

	public function update_status_inactive($fileno) {
		// echo "test";
		$this->employee_model->get_user_info($fileno);
		$this->db->set('active', 0);
		$this->db->where('FileNo', $fileno);
		$this->db->update('pcc_staff');

		redirect($this->agent->referrer());
	}

	public function update_status_active($fileno) {
		// echo "test";
		$this->employee_model->get_user_info($fileno);
		$this->db->set('active', 1);
		$this->db->where('FileNo', $fileno);
		$this->db->update('pcc_staff');

		redirect($this->agent->referrer());
	}


}
