<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Scheduling extends MY_Controller {

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
		$this->load->model('hr/attendance_model');
		$this->load->model('hr/hr_model');
		$this->load->model('teacher_profile/user_model');
	}
	
	public function index()
	{
		####################################################
		$this->login->_check_login_all($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] = $this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		// $all_users = $this->employee_model->get_employees_non($active = 1);

		#VIEW CONTENT
		$data['view_content']='hr/employee_scheduling';
		$data['get_plugins_js'] = 'hr/js/scheduling_js';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function get_staff_scheduling_lists(){
		$lists = $this->attendance_model->get_staff_scheduling();

		$data['data'] = [];
		if ($lists) {
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
					'id' => $value->id,
					'biono' => $value->biono,
					'fileno' => $value->FileNo,
					'lastname' => $value->LastName,
					'firstname' => $value->FirstName,
					'middlename' => $value->MiddleName,
					'department' => $value->DEPTNAME,
					'classification' => $value->teaching,
					'timein_am' => date('h:i A', strtotime($value->timein_am)),
					'timeout_am' => date('h:i A', strtotime($value->timeout_am)),
					'timein_pm' => date('h:i A', strtotime($value->timein_pm)),
					'timeout_pm' => date('h:i A', strtotime($value->timeout_pm)),
					'total' => $value->total,
					'days' => $value->days,
				);
			}
		}

		echo json_encode($data);


	}

	public function view_staff_scheduling(){
		$id = $this->input->post('fileno');
		$lists = $this->attendance_model->get_emp_staff_scheduling($id);
		$data = [];

		foreach ($lists as $key => $value) {
			$data = array(
				'id' => $value->id,
				'fullname' => $value->LastName.', '.$value->FirstName.' '. $value->MiddleName.'.',
				'days' => $value->days,
				'timein_am' => date('h:i A', strtotime($value->timein_am)),
				'timeout_am' => date('h:i A', strtotime($value->timeout_am)),
				'timein_pm' => date('h:i A', strtotime($value->timein_pm)),
				'timeout_pm' => date('h:i A', strtotime($value->timeout_pm)),
				'totalhours' => $value->total,
			);
		}

		echo json_encode($data);
	}

	public function update_staff_scheduling(){

		$id = $this->input->post('schedid');
		$timeinam = $this->input->post('timein_am');
        $timeoutam = $this->input->post('timeout_am');
        $timeinpm = $this->input->post('timein_pm');
        $timeoutpm = $this->input->post('timeout_pm');

		$hours = $this->input->post('update_hours');
		$days = implode(',', $this->input->post('days'));

		$data = array(
			'timein_am' => $timeinam,
        	'timeout_am' => $timeoutam,
        	'timein_pm' => $timeinpm,
        	'timeout_pm' => $timeoutpm,
			'days' => $days,
			'total' => $hours,
		);

		$this->attendance_model->update_staff_schedule($data, $id);
		redirect(base_url('/employee_scheduling'));

	}

	public function delete_staff_scheduling(){
		$id = $this->input->post('id');
		$data = $this->attendance_model->del_staff_schedule($id);
		echo json_encode($data);
	}

	public function get_staff_name_lists(){
		$lists = $this->attendance_model->get_emp_staff_name_lists();
		$data = [];

		foreach ($lists as $key => $value) {
			$data[] = array(
				'biono' => $value->BiometricsID,
				'name' => '('.$value->BiometricsID.') '.$value->LastName.', '.$value->FirstName.' '.$value->MiddleName
			);
		}
		echo json_encode($data);

	}

	public function get_staff_non_teaching_lists(){
		$lists = $this->attendance_model->get_emp_staff_name_non_teaching_lists();
		$data = [];

		foreach ($lists as $key => $value) {
			$data[] = array(
				'biono' => $value->BiometricsID,
				'name' => '('.$value->BiometricsID.') '.$value->LastName.', '.$value->FirstName.' '.$value->MiddleName
			);
		}
		echo json_encode($data);
	}

	public function get_staff_teaching_lists(){
		$lists = $this->attendance_model->get_emp_staff_name_teaching_lists();
		$data = [];

		foreach ($lists as $key => $value) {
			$data[] = array(
				'biono' => $value->BiometricsID,
				'name' => '('.$value->BiometricsID.') '.$value->LastName.', '.$value->FirstName.' '.$value->MiddleName
			);
		}
		echo json_encode($data);

	}

	public function add_submit_staff_Schedule(){

        $staff = $this->input->post('staff');
        $timeinam = $this->input->post('timein_am');
        $timeoutam = $this->input->post('timeout_am');
        $timeinpm = $this->input->post('timein_pm');
        $timeoutpm = $this->input->post('timeout_pm');
        $totalhours = $this->input->post('totalhours');
        $days = implode(',', $this->input->post('days'));


        $check = $this->attendance_model->get_check_staff_attendance($staff);
        $in = 0;

        if (empty($check) ) {
	        $data = array(
	        	'biono' => $staff,
	        	'timein_am' => $timeinam,
	        	'timeout_am' => $timeoutam,
	        	'timein_pm' => $timeinpm,
	        	'timeout_pm' => $timeoutpm,
	        	'days' => $days,
	        	'total' => $totalhours,
	        );

	        $this->attendance_model->insert_staff_schedule($data);
        } else {
	    	$this->session->set_flashdata('message','Cannot Override Employee Scheduling'); 
        }

		redirect(base_url('/employee_scheduling'));
	}

	public function get_list_staff_schedule_teaching(){

		$sem_sy = $this->template->get_sem_sy();
		$year = $sem_sy['sem_sy'][0]->sy;
		$semester = $sem_sy['sem_sy'][0]->sem;

		$lists = $this->attendance_model->get_emp_staff_scheduling_teaching($year, $semester);


		$data['data'] = [];
		foreach ($lists as $key => $value) {

			if($value->teaching != 0) {

				$data['data'][] = array(
					'id' => $value->id,
					'biono' => $value->BiometricsID,
					'fileno' => $value->FileNo,
					'lastname' => $value->LastName,
					'firstname' => $value->FirstName,
					'middlename' => $value->MiddleName,
					'department' => $value->DEPTNAME,
					'classification' => $value->teaching,
					'timein_am' => date('h:i A', strtotime($value->start)),
					'timeout_am' => '',
					'timein_pm' => '',
					'timeout_pm' => date('h:i A', strtotime($value->end)),
					'total' => $value->end - $value->start,
					'days' => $value->days,
				);
			}

		}

		echo json_encode($data);

	}

	public function view_staff_teaching_sched(){
		$fileno = $this->input->post('fileno');
		$sem_sy = $this->template->get_sem_sy();
		$year = $sem_sy['sem_sy'][0]->sy;
		$semester = $sem_sy['sem_sy'][0]->sem;

		$lists = $this->attendance_model->get_staff_teaching_schedule($fileno, $year, $semester);



		$data = [];

		foreach ($lists as $key => $value) {

			$enrolled_students = $this->attendance_model->get_students($value->schedid, $year, $semester);
			$sched_days = count(explode(',', $value->days));
			$to_time = strtotime("2008-12-13 ".$value->end."");
			$from_time = strtotime("2008-12-13 ".$value->start."");
			$result = round(abs($to_time - $from_time) / 60,2). " minute";
			$hours = floor($result / 60);
			$minutes = floor($result % 60);

			$total_result = round(abs($to_time - $from_time) / 60,2) * $sched_days. " minute";
			$total_h = floor($total_result / 60);
			$total_m = floor($total_result % 60);

			$format = '%02d:%02d';

			$data[] = array(
				'id' => $value->id,
				'name' => $value->LastName.', ' .$value->FirstName.' '.$value->MiddleName,
				'start' => date('h:i A', strtotime($value->start)),
				'end' => date('h:i A', strtotime($value->end)),
				'hours_week' => sprintf($format, $hours, $minutes),
				'days' => $value->days,
				'section' => $value->section,
				'acadyear' => $value->acadyear,
				'yearlvl' => $value->yearlvl,
				'course' => $value->course,
				'courseno' => $value->courseno,
				'code' => $value->code,
				'schedid' => $value->schedid,
				'room' => $value->room,
				'number_of_students' => count($enrolled_students),
				'total_hours' => sprintf($format, $total_h, $total_m),
			);
		}		
		echo json_encode($data);

	}

}
