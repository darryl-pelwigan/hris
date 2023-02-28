<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once '../Classes/PHPExcel/IOFactory.php';
class Attendance extends MY_Controller {

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
		$this->load->model('hr/attendance_model');
		$this->load->model('profile/profile_model');
		$this->load->model('teacher_profile/user_model');
		$this->load->helper('attendance');
		
	}
	
	public function index()
	{
		####################################################
		$this->login->_check_login_all($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['position_lists'] =$this->hr_model->get_position_lists();

		##VIEW CONTENT
		$data['view_content']='hr/employee_timekeeping';
		$data['get_plugins_js'] = 'hr/js/plugins_js_timekeeping';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function attendance()
	{
		####################################################
		$this->login->_check_login_all($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		$data['dept_lists'] =$this->hr_model->get_department_lists();	
		
		$data['view_content']='hr/employee_attendance';
		$data['get_plugins_js'] = 'hr/js/plugins_js_attendance';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function view_emp_attendance_data()
	{
		$biono = $this->input->post('biometrics');
		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$lists = $this->attendance_model->get_emp_timekeeping_records($date, $biono);

		$emp_attendance = "";
		if($lists){
			foreach($lists as $l){
				$emp_attendance .= "<tr>
									<td>".date('M d, Y', strtotime($l->datetime))."</td>
									<td>".$l->test."</td>
									<td>".($l->verifycode == 1 ? 'FP' : 'P')."</td>
									<td>
										<input type='text' name='datetime[]' value='".date('H:i A', strtotime($l->datetime))."' class='form-control time'>
										<input type='hidden' name='attendance_id[]' value='".$l->id."'>
										<input type='hidden' name='attendance_date[]' value='".date('Y-m-d', strtotime($l->datetime))."' class='form-control time'>
									</td>
									<td width='100px;'><select name='status[]'  class='form-control'>
											<option ".($l->status == 0 ? 'selected' : '')." value='0'>C/In</option>
											<option ".($l->status == 1 ? 'selected' : '')." value='1'>C/Out</option>
										</select>
									</td>
									<td>
                            			<button type='button' id='attendance_".$l->id."' onclick='$.fn.delete_attendance(".$l->id.");' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></button>
									</td>
							</tr>";
			}
		}else{
			$emp_attendance .= "<tr><td colspan='6'>No record.</td></tr>";
		}
		$day = date('N', strtotime($this->input->post('date')));

		$day_c = "";
		if($day == 0){
			$day_c = 'M';
		}else if($day == 1){
			$day_c = 'T';
		}else if($day == 2){
			$day_c = 'W';
		}else if($day == 3){
			$day_c = 'Th';
		}else if($day == 4){
			$day_c = 'F';
		}else if($day == 5){
			$day_c = 'S';
		}

		$schedules = $this->attendance_model->get_emp_schedule($biono);
		$emp_scheduling = "";
		if($schedules){
			foreach($schedules as $s){
				$days_array = explode(',', $s->days);
				if(in_array($day, $days_array)){
					$emp_scheduling .= "<tr>
										<td>".date('h:i A', strtotime($s->timein_am))."</td>
										<td>".date('h:i A', strtotime($s->timeout_am))."</td>
								</tr>";
				}
			}
		}else{
			$emp_scheduling .= "<tr><td colspan='6'>No record.</td></tr>";
		}

		$sem_sy = $this->template->get_sem_sy();
		$schedules_teaching = $this->attendance_model->get_emp_schedule_teaching($biono, $sem_sy['sem_sy_w']['sem'], $sem_sy['sem_sy_w']['sy']);
		$emp_scheduling_teaching = "";
		$emp_scheduling_teaching_content = "";

		if($schedules_teaching){
			foreach($schedules_teaching as $st){
				$days_array_t = explode(',', $st->days);
				if(in_array($day_c, $days_array_t)){
					$emp_scheduling_teaching_content .= "<tr>
										<td>".date('h:i A', strtotime($st->start))."</td>
										<td>".date('h:i A', strtotime($st->end))."</td>
								</tr>";
				}
			}
		
		}

		$staff_attendance = $this->attendance_model->get_staff_attendance($biono, $date);

		$emp_scheduling_teaching = 
					'<table class="table table-bordered small">
						<thead>
							<tr>
								<th>Time In</th>
								<th>Time Out</th>
							</tr>
						</thead>
						<tbody>
						'.$emp_scheduling_teaching_content.'
						<tbody>
					</table>';

		$data = '
				<div class="col-md-12">
					<div class="well">
						<table class="table table-bordered small">
							<thead>
								<tr>
									<th>Regular Hours</th>
									<th>Hours Rendered</th>
									<th>Tardy</th>
									<th>Undertime</th>
									<th>Overtime</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" class="form-control" readonly="" value="'.$staff_attendance[0]->regularhours.'"></td>
									<td>
										<input type="text" class="form-control time2 " onblur="$(this).updateAttendance('.$staff_attendance[0]->id.', `totalhours`)"  value="'.$staff_attendance[0]->totalhours.'">
										<div class="hide success_totalhours'.$staff_attendance[0]->id.'">
										  <span class="text-success"><i class="fa fa-check"></i> Success!</span>  
										</div>
									</td>
									<td>
										<input  type="text" class="form-control time2 " onblur="$(this).updateAttendance('.$staff_attendance[0]->id.', `tardiness`)" value="'.$staff_attendance[0]->tardiness.'">
										<div class="hide success_tardiness'.$staff_attendance[0]->id.'">
										  <span class="text-success"><i class="fa fa-check"></i> Success!</span>  
										</div>
									</td>
									<td>
										<input type="text" class="form-control time2 " onblur="$(this).updateAttendance('.$staff_attendance[0]->id.', `undertime`)" value="'.$staff_attendance[0]->undertime.'">
										<div class="hide success_undertime'.$staff_attendance[0]->id.'">
										  <span class="text-success"><i class="fa fa-check"></i> Success!</span>  
										</div>
									</td>
									<td>
										<input type="text" class="form-control time2 " onblur="$(this).updateAttendance('.$staff_attendance[0]->id.', `overtime`)" value="'.$staff_attendance[0]->overtime.'">
										<div class="hide success_overtime'.$staff_attendance[0]->id.'">
										  <span class="text-success"><i class="fa fa-check"></i> Success!</span>  
										</div>
									</td>
									<td>';
										if($staff_attendance[0]->status == 1){
											//$data .= '<button class="btn btn-success btn-xs" onclick="$(this).updateAttendanceStatus('.$staff_attendance[0]->id.')" value="'.$staff_attendance[0]->status.'"><i class="fa fa-check"></i></button>';
										}else{
											//$data .= '<button class="btn btn-warning btn-xs" onclick="$(this).updateAttendanceStatus('.$staff_attendance[0]->id.')" value="'.$staff_attendance[0]->status.'"><i class="fa fa-times"></i></button>';
										}
							$data .= '</td>
								</tr>
							<tbody>
						</table>
					</div>
				</div>
				<div class="col-md-8">
					<form action="" method="POST" class="attendance_form">
	  					<table class="table table-bordered small tbl_attendance">
							<thead>
								<tr>
									<th>Date</th>
									<th>Location</th>
									<th>VerifyCode</th>
									<th>Time</th>
									<th>Status</th>
									<th><button type="button" class="btn btn-primary btn-xs addrow"><i class="fa fa-plus"></i></button></th>
								</tr>
							</thead>
							<tbody>
								'.$emp_attendance.'
							</tbody>
	  					</table>
	  					<input type="hidden" value="'.$biono.'" name="badgenumber">
	  					<button class="btn btn-primary btn-xs btn_submit_attendance" data-id="'.$biono.'" data-date="'.$date.'" type="button"><i class="fa fa-save"></i> Update</button>
  					</form>
			  	</div>
			  	<div class="col-md-4">
			  		<table class="table table-bordered small">
						<thead>
							<tr>
								<th>Time In</th>
								<th>Time Out</th>
							</tr>
						</thead>
						<tbody>
							'.$emp_scheduling.'
						</tbody>
  					</table>
					'.$emp_scheduling_teaching.'
			  	</div>';

		echo $data;
	}

	public function update_attendance()
	{

		$datetime = $this->input->post('datetime');
		$attendance_date = $this->input->post('attendance_date');
		$attendance_id = $this->input->post('attendance_id');
		$status = $this->input->post('status');
		$badgenumber = $this->input->post('badgenumber');

		$sem_sy = $this->template->get_sem_sy();
		$sem = $sem_sy['sem_sy'][0]->sem;
		$sy = $sem_sy['sem_sy'][0]->sy;

		for ($i = 0; $i < count($attendance_id); $i++) {
			$date = date('Y-m-d', strtotime($attendance_date[$i])).' '.date('H:i:s', strtotime($datetime[$i]));
			if($attendance_id[$i] == 0){
				$this->attendance_model
						->insert_emp_attendance([
							'badgenumber' => $badgenumber,
							'datetime' => $date,
							'status' => $status[$i],
							'location' => '',
							'verifycode' =>'',
							'dateuploaded' => null,
						]);
						
			}else{
				$x = $this->attendance_model->update_emp_attendance($attendance_id[$i], $date, $status[$i]);
			}


			// update attendance
			$attendance = get_attendance($badgenumber, $date, $sem, $sy);

			if($attendance){
				$dt = date('Y-m-d', strtotime($attendance_date[$i]));
				$stat = $this->attendance_model->get_staff_attendance($badgenumber, $dt);
				
				$totalhours = 0;
				$isTeaching = $this->attendance_model->check_nature_employement($badgenumber);
				$get_biometrics_attendance = $this->attendance_model->get_attendance_inserted($badgenumber, $dt);

				if ( !empty($isTeaching) && !empty($get_biometrics_attendance) ) {
					if ($isTeaching->teaching == 0 ) {

						$first_timein = reset($get_biometrics_attendance);
						$last_timeout = end( $get_biometrics_attendance );

						if ($first_timein['datetime'] != $last_timeout['datetime'] ) {

							$default_timein = new DateTime(date('H:i', strtotime('8:30')) );
							$default_timeout = new DateTime(date('H:i', strtotime('17:00')) );

							$timein = new DateTime(date('H:i', strtotime($first_timein['datetime']) ) );
							$timeout =new DateTime( date('H:i', strtotime($last_timeout['datetime']) ) );

							$tinein_duration = $timein->diff($timeout);
							$timein_intervals = $tinein_duration->format("%H:%I");
							$def_timein_intervals = date('H:i', strtotime($timein_intervals));

							$def_tinein_duration = $default_timein->diff($default_timeout);
							$def_timein_intervals = $def_tinein_duration->format("%H:%I");
							$def_timein_intervals = date('H:i', strtotime($def_timein_intervals));

							if ($def_timein_intervals <=  $timein_intervals) {
								$totalhours = '8:00';
							}

						}

					}
				}

				if ( empty($stat) ) {
					$staff_attendace = array(
						'biono'  => $badgenumber,
						'date'   => $dt,
						'totalhours'    => $totalhours,
						'regularhours'  => 0,
						'tardiness'   =>0,
						'overtime'   => 0,
						'undertime'   => 0,
						'status'   => 0,
						'remarks'   => null,
					);
					$this->attendance_model->insert_staff_attendance($staff_attendace);

				} else {
					$this->attendance_model->update_staff_attendance($dt, $badgenumber, $attendance, $totalhours);	
				}
			}
		
		}

		$data = true;
		echo json_encode($data);
	}

	public function delete_attendance()
	{
		$id = $this->input->post('attendance_id');
		$data = $this->attendance_model->delete_attendance($id);
		echo json_encode($data);

	}


	public function staff_update_attendance()
	{

		$attendance_id = $this->input->post('attendance_id');
		$col = $this->input->post('col');
		$val = $this->input->post('val');
	
		$x = $this->attendance_model->update_attendance($attendance_id, $val, $col);
		$data = true;


		echo json_encode($data);
	}

	public function upload_attendance(){
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['view_content']='hr/upload_employee_attendance';
		$data['get_plugins_js'] = 'hr/js/plugins_js_attendance';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	/**
	* This Function Upload excel files biometrics
	* compute for the total hours
	*/

	public function staff_upload_attendance(){
		// import library	
		$this->load->library('excel');

		// load and import current semester and Year
		$sem_sy = $this->template->get_sem_sy();
		$sem = $sem_sy['sem_sy'][0]->sem;
		$sy = $sem_sy['sem_sy'][0]->sy;

		//check excel files
		if(isset($_FILES["file"]["name"])) {

			// read excel files
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);

			$attendance_date = array();
			$biometrics_id = array();

			// loop function for every data in excel and upload to biometrics database
			foreach($object->getWorksheetIterator() as $worksheet)
			{

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();

				for($row=2; $row<=$highestRow; $row++)
				{

					$ac = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$bio_no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$time = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$state = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$new_state = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$exception = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$operation = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

					$status = 0;

					if ($state == 'C/In') {
						$status = 0;
					} else {
						$status = 1;
					}

					if ($bio_no != null) {
						$data = array(
							'badgenumber'  => $bio_no,
							'datetime'   => date('Y-m-d H:i', strtotime($time)),
							'status'    => $status,
							'location'  => $new_state,
							'verifycode'   => 1,
							'test'   => $exception,
						);

						array_push($attendance_date, date('Y-m-d', strtotime($time)) );
						array_push($biometrics_id, $bio_no );
					}

					$staff_attendance = $this->attendance_model->get_staff_attendance_biometrics($data, $time);
					
					if ($staff_attendance == false) {
						$inserted = $this->attendance_model->insert_attendance_biometrics($data);
					}

				}


				$attendance_date = array_values(array_unique( $attendance_date ));
				$biometrics_id = array_values(array_unique( $biometrics_id ));

				// loop function to compute total rendered hours and save to pcc_staff_attendance database.
				for ($i=0; $i < count( $attendance_date ) ; $i++) { 

					$att_date = $attendance_date[$i];
					
					foreach ($biometrics_id as $key => $biono) {

						$totalhours = 0;
						$isTeaching = $this->attendance_model->check_nature_employement($biono);


						$get_biometrics_attendance = $this->attendance_model->get_attendance_inserted($biono, date('Y-m-d', strtotime($att_date)) );

						// this part will check time in AM and PM. this will applicable for non-teaching employees
						if ( !empty($isTeaching) && !empty($get_biometrics_attendance) ) {
							
							if ($isTeaching->teaching == 0 && count($get_biometrics_attendance) >= 2 ) {

								$attendance = get_attendance($biono, date('Y-m-d', strtotime($att_date)) , $sem, $sy);

								// echo "<pre>";
								// print_r($attendance['totalhours']);
								// echo "</pre>";
								// die();

								$totalhours = $attendance['totalhours'];

								// $first_timein = reset($get_biometrics_attendance);
								// $last_timeout = end( $get_biometrics_attendance );

								// if ($first_timein['datetime'] != $last_timeout['datetime'] ) {

								// 	$default_timein = new DateTime(date('H:i', strtotime('8:30')) );
								// 	$default_timeout = new DateTime(date('H:i', strtotime('17:00')) );

								// 	$timein = new DateTime(date('H:i', strtotime($first_timein['datetime']) ) );
								// 	$timeout =new DateTime( date('H:i', strtotime($last_timeout['datetime']) ) );

								// 	$tinein_duration = $timein->diff($timeout);
								// 	$timein_intervals = $tinein_duration->format("%H:%I");
								// 	$def_timein_intervals = date('H:i', strtotime($timein_intervals));

								// 	$def_tinein_duration = $default_timein->diff($default_timeout);
								// 	$def_timein_intervals = $def_tinein_duration->format("%H:%I");
								// 	$def_timein_intervals = date('H:i', strtotime($def_timein_intervals));


								// 	if ($def_timein_intervals <=  $timein_intervals) {
								// 		$totalhours = '8:00';
								// 	}

		
								// }

							}
						}


						$check_staff_attendance = $this->attendance_model->check_staff_attendance($biono, date('Y-m-d', strtotime($att_date)) );


						// safe information details to pcc_staff_attendance
						if (empty($check_staff_attendance)) {
							$check_staff_biometrics = $this->attendance_model->check_staff_biometrics($biono, date('Y-m-d', strtotime($att_date)) );

							if ($check_staff_biometrics) {
								$staff_attendace = array(
									'biono'  => $biono,
									'date'   => date('Y-m-d', strtotime($att_date)),
									'totalhours'    => $totalhours,
									'regularhours'  => 0,
									'tardiness'   =>0,
									'overtime'   => 0,
									'undertime'   => 0,
									'status'   => 0,
									'remarks'   => null,
								);
								$this->attendance_model->insert_staff_attendance($staff_attendace);
							}

						} 


					}

				}



			}

		}


	}

	// public function staff_upload_attendance(){
	// 	// import library	
	// 	$this->load->library('excel');

	// 	// load and import current semester and Year
	// 	$sem_sy = $this->template->get_sem_sy();
	// 	$sem = $sem_sy['sem_sy'][0]->sem;
	// 	$sy = $sem_sy['sem_sy'][0]->sy;

	// 	//check excel files
	// 	if(isset($_FILES["file"]["name"])) {

	// 		// read excel files
	// 		$path = $_FILES["file"]["tmp_name"];
	// 		$object = PHPExcel_IOFactory::load($path);

	// 		$attendance_date = array();
	// 		$biometrics_id = array();

	// 		// loop function for every data in excel and upload to biometrics database
	// 		foreach($object->getWorksheetIterator() as $worksheet)
	// 		{

	// 			$highestRow = $worksheet->getHighestRow();
	// 			$highestColumn = $worksheet->getHighestColumn();

	// 			for($row=2; $row<=$highestRow; $row++)
	// 			{

	// 				$ac = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
	// 				$bio_no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	// 				$name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
	// 				$time = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$state = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
	// 				$new_state = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	// 				$exception = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
	// 				$operation = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

	// 				$status = 0;

	// 				if ($state == 'C/In') {
	// 					$status = 0;
	// 				} else {
	// 					$status = 1;
	// 				}

	// 				if ($bio_no != null) {
	// 					$data = array(
	// 						'badgenumber'  => $bio_no,
	// 						'datetime'   => date('Y-m-d H:i', strtotime($time)),
	// 						'status'    => $status,
	// 						'location'  => $new_state,
	// 						'verifycode'   => 1,
	// 						'test'   => $exception,
	// 					);

	// 					array_push($attendance_date, date('Y-m-d', strtotime($time)) );
	// 					array_push($biometrics_id, $bio_no );
	// 				}

	// 				$staff_attendance = $this->attendance_model->get_staff_attendance_biometrics($data, $time);
					
	// 				if ($staff_attendance == false) {
	// 					$inserted = $this->attendance_model->insert_attendance_biometrics($data);
	// 				}

	// 			}


	// 			$attendance_date = array_values(array_unique( $attendance_date ));
	// 			$biometrics_id = array_values(array_unique( $biometrics_id ));

	// 			//loop function to compute total rendered hours and save to pcc_staff_attendance database.
	// 			if ( !empty($isTeaching) && !empty($get_biometrics_attendance) ) {
							
	// 				if ($isTeaching->teaching == 0 ) {

	// 					$first_timein = reset($get_biometrics_attendance);
	// 					$last_timeout = end( $get_biometrics_attendance );

	// 					if ($first_timein['datetime'] != $last_timeout['datetime'] ) {

	// 						$default_timein = new DateTime(date('H:i', strtotime('8:30')) );
	// 						$default_timeout = new DateTime(date('H:i', strtotime('17:00')) );

	// 						$timein = new DateTime(date('H:i', strtotime($first_timein['datetime']) ) );
	// 						$timeout =new DateTime( date('H:i', strtotime($last_timeout['datetime']) ) );

	// 						$tinein_duration = $timein->diff($timeout);
	// 						$timein_intervals = $tinein_duration->format("%H:%I");
	// 						$def_timein_intervals = date('H:i', strtotime($timein_intervals));

	// 						$def_tinein_duration = $default_timein->diff($default_timeout);
	// 						$def_timein_intervals = $def_tinein_duration->format("%H:%I");
	// 						$def_timein_intervals = date('H:i', strtotime($def_timein_intervals));


	// 						if ($def_timein_intervals <=  $timein_intervals) {
	// 							$totalhours = '8:00';
	// 						}


	// 					}

	// 				}
	// 			}

	// 			for ($i=0; $i < count( $attendance_date ) ; $i++) { 

	// 				$att_date = $attendance_date[$i];
	// 				$date = date('Y-m-d', strtotime($att_date));


					
	// 				foreach ($biometrics_id as $key => $biono) {

	// 					// get attendance from Attendance Helper

	// 					$isTeaching = $this->attendance_model->check_nature_employement($biono);

	// 					$check_staff_attendance = $this->attendance_model->check_staff_attendance($biono, date('Y-m-d', strtotime($att_date)) );

	// 					// echo "<pre>";
	// 					// var_dump($date);
	// 					// var_dump($check_staff_attendance);
	// 					// echo "</pre>";
	// 					// die();

	// 					// save information details to pcc_staff_attendance
	// 					if (empty($check_staff_attendance)) {
	// 						$check_staff_biometrics = $this->attendance_model->check_staff_biometrics($biono, date('Y-m-d', strtotime($att_date)) );

	// 						$attendance = get_attendance($biono, $date, $sem, $sy);

	// 						echo "<pre>";
	// 						echo "<pre>";
	// 						echo "</pre>";
	// 						die();

	// 						if ($check_staff_biometrics) {
	// 							if ($check_staff_biometrics >= 2) {
	// 								$staff_attendace = array(
	// 									'biono'  => $biono,
	// 									'date'   => date('Y-m-d', strtotime($att_date)),
	// 									'totalhours'    => $attendance['totalhours'],
	// 									'regularhours'  => 0,
	// 									'tardiness'   => $attendance['totaltardy'],
	// 									'overtime'   => $attendance['totalovertime'],
	// 									'undertime'   => $attendance['totalundertime'],
	// 									'status'   => 0,
	// 									'remarks'   => null,
	// 								);
	// 							} else {
	// 								$staff_attendace = array(
	// 									'biono'  => $biono,
	// 									'date'   => date('Y-m-d', strtotime($att_date)),
	// 									'totalhours'    => 0,
	// 									'regularhours'  => 0,
	// 									'tardiness'   => 0,
	// 									'overtime'   => 0,
	// 									'undertime'   => 0,
	// 									'status'   => 0,
	// 									'remarks'   => null,
	// 								);
	// 							}

	// 							$this->attendance_model->insert_staff_attendance($staff_attendace);
	// 						}

	// 					} 


	// 				}

	// 			}



	// 		}

	// 	}


	// }

	

}




