<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MY_Controller {

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

    public function get_sem_sy($select="*")
    {
        $this->load->model('template_model');
        $data['sem_sy'] =$this->template_model->get_sem_sy($select);
		$data['sem_sy_w']=$this->get_sem_w( $data['sem_sy'][0]->sem , $data['sem_sy'][0]->sy);
        return $data;
		
    }
	
	
	public function get_sem_w($sem,$sy){
		$data['sy']=$sy;
		$data['sy2']=$sy;
		$data['sem']=$sem;
		if($sem == 1){
            $data['csem'] = '1st Semester';
            $data['csemword'] = 'First Semester';
        }elseif($sem == 2) {
            $data['csem'] = '2nd Semester';
            $data['csemword'] = 'Second Semester';
        }elseif($sem == 3){
			$s_sy=explode('-',$sy);
            $data['csem'] = 'Summer';
            $data['csemword'] = 'Summer';
			$data['sy2']=$s_sy[1];
        }
		return $data;
		
	}     

	public function _hr_nav($push=null){


		$this->load->model('hr/hr_model');
		$this->load->model('hr/employee_model');
		
		$staff_id = $this->session->userdata('staff_id');
		$fileno = $this->employee_model->get_user_info($this->session->userdata('fileno'));
		$teaching = $fileno[0]->teaching;

		$data = [];
		$role = $this->session->userdata('role');

		$fileno = $this->session->userdata('fileno');
		$approving_position = $this->hr_model->checkemp_for_request_approval($fileno);
		$nav_req_apprv = '';
		if($approving_position)
		{
			$nav_req_apprv = array('modules/employee_requests_approval','fa fa-check-square','Request Approval','li'=>'','a'=>'');
		}

		## NAVIGATION SETUP
		## URI, ADDEDD CLASS, NAME ,PROPERTIES array
		## multidimensional array for navigation with dropdown
		/*
			$data=array(	
				array(
					array('','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''), 
					array('','glyphicon glyphicon-book','Profile','li'=>'','a'=>''), 
				),
				array('TeacherScheduleList','glyphicon glyphicon-calendar','Teacher Sched','li'=>'','a'=>''),
			);`
		*/
		if($role == 7){
			##HR STAFF
			$data = array(	
				array(
					array('modules','glyphicon glyphicon-record','Employees','li'=>'','a'=>''),
					array('modules/employee_lists','glyphicon glyphicon-user','Employees','li'=>'','a'=>''),
					array('modules/employee_lists_inactive','glyphicon glyphicon-eye-close','Employees (Inactive)','li'=>'','a'=>''), 
					array('modules/employee_leave_records','glyphicon glyphicon-align-justify','Leave Records','li'=>'','a'=>''), 
					array('modules/employee_leave_credits','glyphicon glyphicon-file','Leave Credits','li'=>'','a'=>''), 
					array('modules/employee_position_record','glyphicon glyphicon-list-alt','Position','li'=>'','a'=>''),
					array('modules/employee_years_service','glyphicon glyphicon-calendar','Employee Years of Service','li'=>'','a'=>''),  
				),
				array(
					array('modules','glyphicon glyphicon-calendar',' Request','li'=>'','a'=>''),
					array('modules/employee_overtime_requests_approval','glyphicon glyphicon-time','Overtime Req','li'=>'','a'=>''), 
					array('modules/employee_leave_requests','glyphicon glyphicon-road','Leave Req','li'=>'','a'=>''), 
					array('modules/employee_passslip_requests_approval','glyphicon glyphicon-list-alt','Pass Slip Req','li'=>'','a'=>''), 
					array('modules/employee_travelform_requests_approval','glyphicon glyphicon-plane','Travel Form Req','li'=>'','a'=>'')
				),
				array(
					array('modules','glyphicon glyphicon-record','Attendance','li'=>'','a'=>''),
					array('modules/employee_timekeeping','glyphicon glyphicon-time','Time Keeping','li'=>'','a'=>''), 
					array('modules/employee_attendance','fa fa-list-ol','Attendance','li'=>'','a'=>''), 
					array('modules/employee_scheduling','fa fa-calendar-o','Scheduling','li'=>'','a'=>''), 
					array('modules/upload_attendance','fa fa-upload','Upload Attendance','li'=>'','a'=>''), 
				),
				array(
					array('modules','glyphicon glyphicon-list-alt','Reports','li'=>'','a'=>''),
					array('modules/hr_report','glyphicon glyphicon-list-alt','Reports','li'=>'','a'=>''),
					array('modules/hr_report_charts','glyphicon glyphicon-sound-dolby','Charts','li'=>'','a'=>''), 
				),
				array(
					array('modules','glyphicon glyphicon-cog','Settings','li'=>'','a'=>''),
					array('modules/list_holidays','glyphicon glyphicon-certificate','Holidays','li'=>'','a'=>''), 
					array('modules/setting_approving_position_ids','fa fa-thumbs-o-up','Approving Rank','li'=>'','a'=>''), 
					array('modules/settings_leave_types','fa fa-list','Leave Types','li'=>'','a'=>''), 
					// array('','fa fa-user fa-fw','User Account','li'=>'','a'=>''), 
				),
				array(
					array('modules','glyphicon glyphicon-usd','Payroll','li'=>'','a'=>''),
					array('modules/payroll','glyphicon glyphicon-usd','Generate Payroll','li'=>'','a'=>''),
					array('modules/deductions_allowances','glyphicon glyphicon-download','Deductions','li'=>'','a'=>''),
					array('modules/loans','glyphicon glyphicon-download','Loans','li'=>'','a'=>''),
					array('modules/salary_matrix','glyphicon glyphicon-download','Salary Matrix','li'=>'','a'=>''),
					// array('modules/salary_rate','glyphicon glyphicon-download','Salary Rate','li'=>'','a'=>'')
				),
				array('modules/history_log','fa fa-user fa-fw','History Log','li'=>'','a'=>''),
				array('purchaseRequest.php','fa fa-briefcase fa-fw','Purchase Request','li'=>'','a'=>''),
				$nav_req_apprv
			);
		}else{
			if($teaching == 1){
				$data = array(	
					array('modules/myprofile/0','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''),
					array(
						array('modules/modules','glyphicon glyphicon-calendar',' Application Request','li'=>'','a'=>''),
						array('modules/employee_leave_form','glyphicon glyphicon-road','Leave Req','li'=>'','a'=>''), 
						array('modules/employee_passslip_requests','glyphicon glyphicon-list-alt','Pass Slip Req','li'=>'','a'=>''), 
						array('modules/employee_travelform_requests','glyphicon glyphicon-plane','Travel Form Req','li'=>'','a'=>'')
					),
					$nav_req_apprv
				);
			}else{

				if ($role == 4) {
					$data = array(	
						array('modules/myprofile/0','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''),
						array(
							array('modules/modules','glyphicon glyphicon-calendar',' Application Request','li'=>'','a'=>''),
							array('modules/employee_overtime_requests','glyphicon glyphicon-time','Overtime Req','li'=>'','a'=>''), 
							array('modules/employee_leave_form','glyphicon glyphicon-road','Leave Req','li'=>'','a'=>''), 
							array('modules/employee_passslip_requests','glyphicon glyphicon-list-alt','Pass Slip Req','li'=>'','a'=>''), 
							array('modules/employee_travelform_requests','glyphicon glyphicon-plane','Travel Form Req','li'=>'','a'=>'')
						),

						array(
							array('modules','glyphicon glyphicon-cog','Settings','li'=>'','a'=>''),
							array('modules/list_holidays','glyphicon glyphicon-certificate','Holidays','li'=>'','a'=>''), 
						),

						array(
							array('modules','glyphicon glyphicon-record','Attendance','li'=>'','a'=>''),
							array('modules/employee_attendance','fa fa-list-ol','Attendance','li'=>'','a'=>''), 
						),

						array(
							array('modules','glyphicon glyphicon-usd','Payroll','li'=>'','a'=>''),
							array('modules/payroll','glyphicon glyphicon-usd','Generate Payroll','li'=>'','a'=>''),
							array('modules/deductions_allowances','glyphicon glyphicon-download','Deductions','li'=>'','a'=>''),
							array('modules/loans','glyphicon glyphicon-download','Loans','li'=>'','a'=>''),
							array('modules/salary_matrix','glyphicon glyphicon-download','Salary Matrix','li'=>'','a'=>''),
						),

						$nav_req_apprv
					);
					
				} else {
					$data = array(	
						array('modules/myprofile/0','glyphicon glyphicon-calendar','Profile','li'=>'','a'=>''),
						array(
							array('modules/modules','glyphicon glyphicon-calendar',' Application Request','li'=>'','a'=>''),
							array('modules/employee_overtime_requests','glyphicon glyphicon-time','Overtime Req','li'=>'','a'=>''), 
							array('modules/employee_leave_form','glyphicon glyphicon-road','Leave Req','li'=>'','a'=>''), 
							array('modules/employee_passslip_requests','glyphicon glyphicon-list-alt','Pass Slip Req','li'=>'','a'=>''), 
							array('modules/employee_travelform_requests','glyphicon glyphicon-plane','Travel Form Req','li'=>'','a'=>'')
						),
						$nav_req_apprv
					);
				}



				
			}
			
		}
		
		return array_merge($data);
	}
	   
}