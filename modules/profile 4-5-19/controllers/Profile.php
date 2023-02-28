<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends MY_Controller {

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
	##### HR ACCOUNT & Employee
	public $user_access_role  = 7;
	##### HR ACCOUNT & Employee
	#################################################

	function __construct(){
		$this->load->library('form_validation');
		$this->load->library('theworld');
		$this->load->module('hr/login');
		$this->load->module('template/template');
		$this->load->model('profile/profile_model');
		$this->load->model('hr/employee_model');
		$this->load->model('hr/hr_model');
		$this->load->model('teacher_profile/user_model');
		
	}


	public function employee_profile($employee_id)
	{

		####################################################
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$data['nav']=$this->template->_hr_nav();
		$data['fileno'] = $this->session->userdata('fileno');
		if($employee_id == 0){
			$data['fileno'] = $this->session->userdata('fileno');
			$employee_id = $data['fileno'];
		}
		$data['user'] =$this->employee_model->get_user_info($employee_id);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['nav_title'] = $this->session->collegedept;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		##employee profile
		$data['appointmnt'] =$this->profile_model->get_staff_appointment($employee_id);
		$data['user_info'] = $this->profile_model->view_emp_basic_data($employee_id);
		$data['dept_history'] =$this->profile_model->get_staff_dept_history($employee_id);
		$data['edu_background'] = $this->profile_model->get_staff_edu_background($employee_id);
		$data['eligibilities'] = $this->profile_model->get_staff_eligibilities($employee_id);
		$data['profile_image'] = $this->profile_model->get_profile_image($employee_id);
		$data['profile_image'] = $this->profile_model->get_profile_image($employee_id);
		$data['dependents'] = $this->profile_model->get_profile_dependents($data['user'][0]->BiometricsID);
		$data['service_record']= $this->profile_model->get_service_record($employee_id);
		##employee leave

		$data['user']['position']= $this->profile_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user']['education']= $this->profile_model->get_user_education($employee_id);
		
		$data['user_education']= $this->profile_model->get_user_education($data['user'][0]->BiometricsID);
		$data['user_appointment']= $this->profile_model->get_staff_appointment($data['user'][0]->BiometricsID);




		// $data['leave_credits'] = $this->profile_model->get_emp_leave_credits($employee_id, 0);
		$data['leavetype_lists'] =$this->employee_model->get_leave_type_lists();

		##departments and Posistions
		$data['dept_names'] =$this->employee_model->get_department_lists();
		$data['position'] = $this->hr_model->get_emp_position();

		##JOB HISTORY
		$data['job_history'] = $this->profile_model->get_emp_job_history($employee_id);

		##NOTIFICATION FOR SERVICE ADDED CREDIT
		$data['service_credit'] = $this->profile_model->get_latest_service_credits($employee_id);
		$data['user_leave'] = $this->profile_model->get_employee_leave($employee_id);

		##LEAVE CREDITS/USES/BALANCE
		$leave_balances = [];
		foreach($data['leavetype_lists'] as $lt){
			$leave_id = $lt->id;
			// if($lt->id == 11){
			// 	$leave_id = 1;
			// }
			$leave_credits = $this->profile_model->get_emp_leave_credits($employee_id, $leave_id);
			$credits = ($leave_credits) ? $leave_credits[0]->leave_credit : 0;
			$leave = $this->employee_model->get_used_leave_type($employee_id, $leave_id);

			$leave_used = ($leave && $leave[0]->dayswithpay != null) ? $leave[0]->dayswithpay : 0;
			$total_balance = $credits - $leave_used;
			if($credits > 0){
				if($lt->id != 11){
					array_push($leave_balances, 
						array(
							'leave_credit'  => $credits,
							'leave_used' => $leave_used,
							'leave_bal' => $total_balance,
							'leave_type' => $lt->type,
							'leave_type_id' => $lt->id
						)
					);
				}
			}		

		}

		$data['leave_balances'] = $leave_balances;
		$data['leave_credits'] = $this->hr_model->get_emp_leave_credits($employee_id, 0);

		$data['view_content']='profile/view_profile';
		$data['view_modals']='profile/view_profile_modals';
		$data['get_plugins_js']='profile/js/plugins_js_profile';
		$data['get_plugins_css']='profile/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}
	
	public function auto_save_add_emp(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label[]",TRUE);
		$input_rules =  $this->input->post("input_rules[]",TRUE);
		$value =  $this->input->post("value[]",TRUE);
		$type =  $this->input->post("type[]",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$this->form_validation->set_rules("value[active]", $input_label['active'], $input_rules['active']);
		$this->form_validation->set_rules("value[fileno]", $input_label['fileno'], $input_rules['fileno']);
		$this->form_validation->set_rules("value[biometricsid]", $input_label['biometricsid'], $input_rules['biometricsid']);
		$this->form_validation->set_rules("value[fname]", $input_label['fname'], $input_rules['fname']);
		$this->form_validation->set_rules("value[mname]", $input_label['mname'], $input_rules['mname']);
		$this->form_validation->set_rules("value[lname]", $input_label['lname'], $input_rules['lname']);

		$this->form_validation->set_rules("value[birth_date]", $input_label['birth_date'], $input_rules['birth_date']);

				if($type=="dateofemploy"){
					$value=date("Y-m-d",strtotime($value));
				}
					$array_insert = array(
						$type["active"]=>$value["active"],
						$type["fileno"]=>$value["fileno"],
						$type["biometricsid"]=>$value["biometricsid"],
						$type["fname"]=>htmlentities($value["fname"]),
						$type["mname"]=>htmlentities($value["mname"]),
						$type["lname"]=>htmlentities($value["lname"]),
						$type["birth_date"]=>date("Y-m-d",strtotime($value["birth_date"])),
	
					);

					echo json_encode(array(
						'error_msg' => "success",
						'inserted_id' => $this->profile_model->insert_add_emp($array_insert),
					));

	}

	public function auto_save_emp_dependent(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label",TRUE);
		$input_rules =  $this->input->post("input_rules",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$value =  $this->input->post("value",TRUE);
		$type =  $this->input->post("type",TRUE);
		$count_value=count($value);
		$count_type=count($type);
		$table =  $this->input->post("table",TRUE);
		$this->form_validation->set_rules("value[]", $input_label, $input_rules);
			if ($this->form_validation->run() == TRUE)
			{
				if($count_value>1 && $count_type>1 && $table=='2'){
					$array_insert = array(
										"staff_id"=>$staff,
										$type["dpntname"]=>$value["dpntname"],
										$type["dpntbday"]=>date("Y-m-d",strtotime($value["dpntbday"])),
										$type["dpntrel"]=>$value["dpntrel"]
									);
					echo json_encode(array(
									'error_msg' => "success",
									'inserted_id' => $this->profile_model->insert_emp_dpndnt_records($array_insert),
									'status' => 1,
								));
				}else{
					if($type=="datebirth"){
						$value=date("Y-m-d",strtotime($value));
					}
					$depid =  $this->input->post("depid",TRUE);
					if($this->profile_model->get_emp_dpndnt($staff,$depid)){
						echo json_encode(array(
									'error_msg' => "success",
									'inserted_id' => $this->profile_model->update_emp_dpndnt_records($staff,$depid,$type,$value),
									'status' => 0,

								));
					}else{
							echo json_encode(array(
									'error_msg' => "NO RECORDS FOUND TO UPDATE",
								));
					}
				}
			}else{
						echo json_encode(array(
							'error_msg' => validation_errors(),
						));
			}
	}

	public function auto_save_emp_appointment(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label",TRUE);
		$input_rules =  $this->input->post("input_rules",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$value =  $this->input->post("value",TRUE);
		$type =  $this->input->post("type",TRUE);
		$count_value=count($value);
		$count_type=count($type);
		$table =  $this->input->post("table",TRUE);
		$this->form_validation->set_rules("value[]", $input_label, $input_rules);

			if ($this->form_validation->run() == TRUE)
			{
					if($count_value>1 && $count_type>1 && $table=='3'){
						$array_insert = array(
											"staff_id"=>$staff,
											$type["apps"]=>$value["apps"],
											$type["appfrom"]=>date("Y-m-d",strtotime($value["appfrom"])),
											$type["appto"]=>date("Y-m-d",strtotime($value["appto"]))
										);
						echo json_encode(array(
										'error_msg' => "success",
										'inserted_id' => $this->profile_model->insert_emp_appointment_records($array_insert),
										'status' => 1,

									));
					}else{
						if($type=="appfrom" || $type=="appto"){
							$value=date("Y-m-d",strtotime($value));
						}
						$appid =  $this->input->post("appid",TRUE);
						if($this->profile_model->get_staff_appointment($staff,$appid)){
							echo json_encode(array(
										'error_msg' => "success",
										'inserted_id' => $this->profile_model->update_emp_appointment_records($staff,$appid,$type,$value),
										'status' => 0,

									));
						}else{
							echo json_encode(array(
										'error_msg' => "NO RECORDS FOUND TO UPDATE",
									));

						}
					}
			}else{
					echo json_encode(array(
						'error_msg' => validation_errors(),
					));
			}
	}


	public function auto_save_emp_educ(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label",TRUE);
		$input_rules =  $this->input->post("input_rules",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$value =  $this->input->post("value",TRUE);
		$type =  $this->input->post("type",TRUE);
		$count_value=count($value);
		$count_type=count($type);
		$table =  $this->input->post("table",TRUE);
		$this->form_validation->set_rules("value[]", $input_label, $input_rules);



		if($count_value>1 && $count_type>1 && $table=='4'){
			$this->form_validation->set_rules("value[eductype]", $input_label['eductype'], $input_rules['eductype']);
			$this->form_validation->set_rules("value[educdegree]", $input_label['educdegree'], $input_rules['educdegree']);
			$this->form_validation->set_rules("value[educstatus]", $input_label['educstatus'], $input_rules['educstatus']);
			$this->form_validation->set_rules("value[educremarks]", $input_label['educremarks'], $input_rules['educremarks']);
			$this->form_validation->set_rules("value[educnameschool]", $input_label['educnameschool'], $input_rules['educnameschool']);

			$array_insert = array(
					"staff_id"=>$staff,
					$type["eductype"]=>$value["eductype"],
					$type["educdegree"]=>$value["educdegree"],
					$type["educstatus"]=>$value["educstatus"],
					$type["educremarks"]=>$value["educremarks"],
					$type["educnameschool"]=>$value["educnameschool"],
				);
			echo json_encode(array(
							'error_msg' => "success",
							'inserted_id' => $this->profile_model->insert_emp_educ_records($array_insert),
							'status' => 1,
						));
		}else{

			if ($this->form_validation->run() == TRUE){

				$id =  $this->input->post("educ_id",TRUE);
				if($this->profile_model->get_educ($staff,$id)){
					echo json_encode(array(
						'error_msg' =>  'success',
						'inserted_id' => $this->profile_model->update_emp_educ_records($staff,$id,$type,$value),
						'status' => 0,
					));
				}
				else{
					// echo json_encode(array(
					// 	'error_msg' => "NO RECORDS FOUND TO UPDATE",
					// ));
				}
			}else{
				echo json_encode(array(
					'error_msg' => 'error here',
				));
			}
		}

	}

	public function auto_save_emp_elig(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label",TRUE);
		$input_rules =  $this->input->post("input_rules",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$value =  $this->input->post("value",TRUE);
		$type =  $this->input->post("type",TRUE);
		$count_value=count($value);
		$count_type=count($type);
		$table =  $this->input->post("table",TRUE);
		$this->form_validation->set_rules("value[]", $input_label, $input_rules);

			if ($this->form_validation->run() == TRUE)
			{
				if($count_value>1 && $count_type>1 && $table=='5'){
					$array_insert = array(
						"staff_id"=>$staff,
						$type["eligname"]=>$value["eligname"],
						$type["eligdate"]=>date("Y-m-d",strtotime($value["eligdate"])),
						$type["eligpassing"]=>$value["eligpassing"],
						$type["eliggrade"]=>$value["eliggrade"],
						$type["eligexpiry"]=>date("Y-m-d",strtotime($value["eligexpiry"]))
					);
					echo json_encode(array(
						'error_msg' => "success",
						'inserted_id' => $this->profile_model->insert_emp_eligibilities_records($array_insert),
						'status' => 1,
					));
				}else{

				$eligid =  $this->input->post("ligid",TRUE);

					if($type=="eligdate" || $type=="expiry"){
						$value=date("Y-m-d",strtotime($value));
					}
					if($this->profile_model->get_emp_eligibility($staff,$eligid)){
						echo json_encode(array(
							'error_msg' => "success",
							'inserted_id' => $this->profile_model->update_emp_eligibilities_records($staff,$eligid,$type,$value),
							'status' => 0,
						));
					}else{
						echo json_encode(array(
							'error_msg' => "NO RECORDS FOUND TO UPDATE",
						));
					}
				}
			}else{
				echo json_encode(array(
					'error_msg' => validation_errors(),
				));
			}
	}
	public function auto_save_emp_otherids(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label",TRUE);
		$input_rules =  $this->input->post("input_rules",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$value =  $this->input->post("value",TRUE);
		$type =  $this->input->post("type",TRUE);
		$count_value=count($value);
		$count_type=count($type);
		$table =  $this->input->post("table",TRUE);
		$this->form_validation->set_rules("value[]", $input_label, $input_rules);

			if ($this->form_validation->run() == TRUE)
			{
					if($count_value>1 && $count_type>1 && $table=='6'){

						$array_insert = array(
											"staff_id"=>$staff,
											$type["othername"]=>$value["othername"],
											$type["otherno"]=>$value["otherno"]
										);
						echo json_encode(array(
										'error_msg' => "success",
										'inserted_id' => $this->profile_model->insert_emp_otherids_records($array_insert),
										'status' => 1,
									));
					}else{

						$id =  $this->input->post("govid",TRUE);
						if($this->profile_model->get_emp_otherids($staff,$id)){
							echo json_encode(array(
								'error_msg' => "success",
								'inserted_id' => $this->profile_model->update_emp_otherids_records($staff,$id,$type,$value),
								'status' => 0,
							));
						}else{
							echo json_encode(array(
										'error_msg' => "NO RECORDS FOUND TO UPDATE",
									));

						}
					}
			}else{
					echo json_encode(array(
						'error_msg' => validation_errors(),
					));
			}
	}

	public function auto_save_emp_data(){

		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$input_label =  $this->input->post("input_label",TRUE);
		$input_rules =  $this->input->post("input_rules",TRUE);
		$staff =  $this->input->post("staff",TRUE);
		$value =  $this->input->post("value",TRUE);
		$type =  $this->input->post("type",TRUE);


		$old_data = $this->profile_model->get_old_emp($staff);

		$this->form_validation->set_rules("value", $input_label, $input_rules);

		if($type=="dateofemploy"){
			$value=date("Y-m-d",strtotime($value));
		}

		if($this->profile_model->get_emp($staff)){
			if($type=="biometricsid"){
				$record=$this->profile_model->update_emp_biometricsid($staff,$type,$value);

			}else{
				$record = $this->profile_model->update_emp_records($staff,$type,htmlentities($value));

				$data_array = array(
					'biometric_id' => $staff,
					'tbl_name' => 'pcc_staff',
					'tbl_column_name' => $type,
					'action' => 'update',
					'old_data' => $old_data->$type,
					'new_data' => $value,
					'updated_by_biometrics' => $this->session->fileno,
					'update_by_name' => $this->session->collegedept,
					'timestamp' => date("Y-m-d H:i:s")
				);

				$this->profile_model->update_emp_history_log($data_array);
			}

			echo json_encode(array(
				'error_msg' => "success",
				'inserted_id' =>$record,
			));
		}else{
			echo json_encode(array(
				'error_msg' => "NO RECORDS FOUND TO UPDATE",
			));
		}
	}

	public function delete_appointment(){
		$id = $this->input->post('delappoint');
		$data = $this->profile_model->del_appointment($id);
		echo json_encode($data);
	}

	public function delete_education(){
		$id = $this->input->post('del_educ');
		$data = $this->profile_model->del_education($id);
		echo json_encode($data);
	}

	public function delete_eligibilities(){
		$id = $this->input->post('del_elig');
		$data = $this->profile_model->del_eligibilities($id);
		echo json_encode($data);

	}

	public function delete_otherID(){
		$id = $this->input->post('del_other');
		$data = $this->profile_model->del_otherID($id);
		echo json_encode($data);
	}


	// public function upload_profile($id){
 //        $type = $_FILES['file']['name'];
 //        $extension = explode('.', $type);

 //        $filename = $id.'.'.$extension[1];

 //        $config['upload_path'] = 'assets/employee_pic/';
 //        $config['overwrite'] = TRUE;
 //        $config['allowed_types'] = 'jpg|png|jpeg|gif|';
 //        $config['max_filename'] = '255';
 //        $config['encrypt_name'] = false;
 //        $config['max_size'] = '1024';
 //        $config['file_name'] = $filename;

 //        if (isset($_FILES['file']['name'])) {
 //            if (0 < $_FILES['file']['error']) {
 //                echo 'Error during file upload' . $_FILES['file']['error'];
 //            } else {
 //                if (file_exists('assets/employee_pic/' . $filename)) {
 //                	unlink('assets/employee_pic/' . $filename);
 //                } else {
 //                    $this->load->library('upload', $config);
 //                    if (!$this->upload->do_upload('file')) {
 //                        echo $this->upload->display_errors();
 //                    } else {
 //                        echo 'File successfully uploaded : assets/employee_pic/' . $filename;
 //                    }
 //                }
 //            }
 //        } else {
 //            echo 'Please choose a file';
 //        }
	// }

	public function upload_profile($id){

		$filename = $_FILES['file']['name'];

        $config['upload_path'] = 'assets/employee_pic/';
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'jpg|png|jpeg|gif|';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = false;
        $config['max_size'] = '1024';
        $config['file_name'] = $filename;

        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists('assets/employee_pic/' . $filename)) {
                	unlink('assets/employee_pic/' . $filename);
                } else {
                	$this->load->library('upload', $config);

                	if (!$this->upload->do_upload('file')) {
                        echo $this->upload->display_errors();
                    } else {
                    	$profile = $this->profile_model->get_profile_image($id);
	                	if ($profile) {
	                		$array = array(
								'user_id' => $id,
								'file_path' => 'assets/employee_pic/' . $filename,
							);
	                		$this->profile_model->profile_image_update($array, $id);
	                	} else {
	                		$array = array(
								'user_id' => $id,
								'file_path' => 'assets/employee_pic/' . $filename,
							);
	                		$this->profile_model->profile_image_upload($array, $id);
	                	}
                        echo 'File successfully uploaded : assets/employee_pic/' . $filename;
                    }
                }
            }
        } else {
            echo 'Please choose a file';
        }
	}

	public function employee_profile_pdf($employee_id){

		$data['user'] =$this->employee_model->get_user_info($employee_id);
		$data['educ'] = $this->profile_model->get_staff_edu_background($data['user'][0]->BiometricsID);
		$data['elig'] = $this->profile_model->get_staff_eligibilities($data['user'][0]->BiometricsID);
		$data['dependents'] = $this->profile_model->get_profile_dependents($data['user'][0]->BiometricsID);

        $this->load->view('css/pdf_css');
        $this->load->view('view_profile_pdf', $data);
        
        // Get output html
        $html = $this->output->get_output();
        // Load pdf library
        $this->load->library('dom_pdf');
        // Load HTML content
        $this->dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'Portrait');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("view_profile.pdf", array("Attachment"=>0));
	}

	public function history_view(){
		$this->login->_check_login([$this->session->userdata('role'), $this->user_access_role]);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['nav_title'] = $this->session->collegedept;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();

		$data['view_content']='profile/view_history_log';
		$data['get_plugins_js']='profile/js/history_log_js.php';
		$data['get_plugins_css']='profile/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function viewlog(){
		$empid = $this->input->post('empid');
		$leave_type = $this->input->post('leave_type');

		$data['result'] = $this->profile_model->get_leave_credit_log($empid, $leave_type);

		echo json_encode($data);
	}

	public function employee_job_position_record(){
		$emp_stat = $this->input->post('emp_status');
		$nature_emp = $this->input->post('nature_emp');
		$department = $this->input->post('department');
		$position = $this->input->post('position');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$remarks = $this->input->post('remarks');
		$fileno = $this->input->post('fileno');

		$data_array = array(
			'staff_id' => $fileno,
			'position' => $position,
			'department' => $department,
			'nature_employment' => $nature_emp,
			'employment_stat' => $emp_stat,
			'date_from' => date('Y-m-d', strtotime($date_from)),
			'date_to' => date('Y-m-d', strtotime($date_to)),
			'date_added' => date("Y/m/d")
		);

		$this->profile_model->add_emp_job_history_record($data_array);

		##get latest position/department then update in pcc_staff
		$latest = $this->profile_model->get_emp_job_history($fileno);
		$position_id = $latest[0]->position;
		$department = $latest[0]->department;
		$this->profile_model->update_position_dept($fileno, $position_id, $department);

		redirect($this->agent->referrer());

	}	

	public function employee_appointment_record()
	{
		$appointment = $this->input->post('apps');
		$date_from = $this->input->post('from');
		$date_to = $this->input->post('to');
		$fileno = $this->input->post('fileno');

		
		for($x = 0; $x < count($appointment); $x++)
		{
			$data_array = array(
				'staff_id' => $fileno,
				'app' => $appointment[$x],
				'appfrom' => date('Y-m-d', strtotime($date_from[$x])),
				'appto' => date('Y-m-d', strtotime($date_to[$x]))
			);

		$this->profile_model->add_appointment_history_record($data_array);

		}


		##get latest position/department then update in pcc_staff
		$latest = $this->profile_model->get_staff_appointment($fileno);


		// $position_id = $latest[0]->position;
		// $department = $latest[0]->department;
		// $this->profile_model->update_position_dept($fileno, $position_id, $department);

		redirect($this->agent->referrer());



	}

	public function update_employee_active_status(){
		$fileno = $this->input->post('fileno');
		$reasonforseparation = $this->input->post('reasonforseparation');
		$lastday = date('Y-m-d', strtotime($this->input->post('lastday')));
		$status = $this->input->post('status');
		if($lastday == '1970-01-01'){
			$lastday = null;
		}

		$this->profile_model->update_employment_separation($fileno, $reasonforseparation, $lastday, $status);

		redirect($this->agent->referrer());

	}	


}
