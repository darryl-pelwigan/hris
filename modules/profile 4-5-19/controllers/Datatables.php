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
		$this->load->model('profile/profile_model');
		$this->load->model('teacher_profile/user_model');


	}

	public function get_leave_records_dt(){
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

		$staff_overtime_id = $this->input->post('overtime_id');
		$lists = $this->profile_model->get_overtime_application($staff_overtime_id);

		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {

				$emp = $this->employee_model->view_emp_basic_data($staff_overtime_id);

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
							'dept_head_date_approval' => $value->dept_head_date_approval,
							'remarks' 			=> $value->remarks,
							'overt_id' 			=> $value->id
						);
			}
		}

		echo json_encode($data);
	}

	public function get_passlip_records_dt()
	{

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
								'numhours' 			=> $value->numhours,
								'exp_undertime' 	=> $value->exp_undertime,
								'dept_head_approval'=> $value->dept_head_approval,
								'dept_head_date_approval' => $value->dept_head_date_approval,
								'dept_head_empid' 	=> $value->dept_head_empid,
							);
			}
		}
		echo json_encode($data);
	}

	public function get_travelo_records_dt()
	{

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
								'dept_head_date_approval'					=>$value->dept_head_date_approval
 							);
			}
		}

		echo json_encode($data);
	}

	public function get_history_log(){
		$lists = $this->profile_model->get_hr_history_log();

		$data['data'] = [];
		if ($lists) {
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
					'id' 		  => $value->id,
					'fullname' 		  => $value->LastName.' '.$value->FirstName.' '.$value->MiddleName.'. ',
					'biometric_id'=> $value->biometric_id,
					'column_name' => $value->tbl_column_name,
					'action' 	  => $value->action,
					'old_data'    => $value->old_data,
					'new_data' 	  => $value->new_data,
					'updated_by'  => $value->update_by_name,
					'date'        => date('j F h:i: A', strtotime($value->timestamp)),
				);
			}
		}

		echo json_encode($data);
	}








}
