<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_grades_submission extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('template/template');
		$this->load->module('admin_registrar/admin_reg');
		$this->load->model('admin_registrar/admin_reg_model');
		$this->load->model('admin_registrar/grades_submission_model');
		 $this->load->model('sched_record2/grade_submission_model');
		 $this->load->model('sched_record2/sched_record_model');
		 $this->load->module('check_submitted/check_submitted_registrar');
		$this->admin_reg->_check_login();
	}

	public function index(){
		$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;

		$data['sem_sy']=$this->template->get_sem_sy();
        $sem=$data["sem_sy"]["sem_sy"][0]->sem;
        $sy=$data["sem_sy"]["sem_sy"][0]->sy;

         if(isset($_SESSION['new_sem_Sy'])){
            $new_sem_Sy = $this->session->new_sem_Sy;
            $sem=$new_sem_Sy['sem'];
            $sy=$new_sem_Sy['sy'];
        }else{
             $new_sem_Sy = array(
                            'sem' => $sem,
                            'sy' => $sy
                            );
            $this->session->set_userdata('new_sem_Sy',$new_sem_Sy);
        }


        $data['scool_year'] = $this->admin_reg_model->get_schoolyear('sc.schoolyear');



         $table = ' <table id="student_grade_view_sched" class="table table-bordered subject_listx" >
                                    <thead>
                                        <tr>
                                            <th>Curr & Section</th>
                                            <th>Course & Year</th>
                                            <th>Assigned Teacher</th>
                                            <th>Coursecode</th>
                                            <th>Descriptive Title  Units</th>
                                            <th>schedule</th>
                                            <th>DATE of View Student</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        $get_courses = $this->check_submitted_model->dept_courses_all( );
        $search['type'] = 's.courseid';
        $data['table_empty'] = 0;
        foreach ($get_courses as $key => $course) {
            $search['value'] = $course->courseid;
            $tablex= $this->set_se_tbody($sem,$sy,$search);
            $table .= $tablex;
            if($tablex != '' ){
            	$data['table_empty'] = 2;
            }else{
            	if($data['table_empty'] != 2){
            		$data['table_empty'] = 1;
            	}

            }
        }


        $data['set_sem'] = $sem;
        $data['set_sy'] = $sy;
        $data['set_sem_w'] = $this->template->get_sem_w($sem,$sy);

		$data['grade_submission']['p'] = $this->grades_submission_model->get_grade_submission($sy,$sem,'p');
		$data['grade_submission']['m'] = $this->grades_submission_model->get_grade_submission($sy,$sem,'m');
		$data['grade_submission']['tf'] = $this->grades_submission_model->get_grade_submission($sy,$sem,'tf');


		$data['table'] = $table.'</tbody></table>';

		$data['view_content']='admin_registrar/grade_submission';
		$data['get_plugins_js']='admin_registrar/grade_submission_script';
		$data['get_plugins_css']='admin_registrar/grade_submission_css';

		$this->load->view('template/init_views',$data);
	}


	public function save_st_grade_view(){


		foreach ($this->input->post('subjectid') as $key => $value) {
			$viewx = $this->grades_submission_model->get_st_viewgrades_subject($key);

			$data = [
						'subjectid' => $key,
						'sem' => $this->input->post('sem_x_s',true),
						'sy' => $this->input->post('sy_x_s',true),
						'date_view' => $value,
						'created_at' => mdate('%Y-%m-%d %h:%i:%s'),
						'updated_at' => mdate('%Y-%m-%d %h:%i:%s'),
					];

			if($viewx){
				$this->grades_submission_model->get_st_viewgrades_subject_update($data);
			}else{
				$this->grades_submission_model->get_st_viewgrades_subject_insert($data);
			}
		}

		redirect('/grade_submission', 'refresh');
	}

	public function set_se_tbody($sem,$sy,$search_text = ""){

        $this->load->model('subject/subject_enrollees_model');
        $data['aaData']= $this->subject_enrollees_model->get_subjects_search($search_text,$sem,$sy,'s.section, s.acadyear, s.yearlvl, s.course, c.code, s.schedid');
         $data["table"] = '';
        if(count($data['aaData']) > 0 ):
                        $data["table"] = '';
                        $y = 0;
                        for($x=0;$x<count($data['aaData']);$x++){
                            $countxy =$search_text["type"] ;
                                $data['aaData2']= $this->subject_enrollees_model->get_subject_courseinfo($search_text,$data['aaData'][$x]->section,$data['aaData'][$x]->acadyear,$data['aaData'][$x]->yearlvl,$data['aaData'][$x]->course,$sem,$sy,$data['aaData'][$x]->schedid);

                            // for($y=0;$y<count($data['aaData2']);$y++){
                                		$enc_sched_id =     $this->encryption->encrypt($data['aaData2'][$y]->schedid);
                                		$viewx = $this->grades_submission_model->get_st_viewgrades_subject($data['aaData2'][$y]->subjectid);
                                		if($viewx){
                                			$view = '<input type="date" class="form-control subjectid_date_view " name="subjectid['.$data['aaData2'][$y]->subjectid.']" value="'.$viewx[0]->date_view.'"  /> ';
                                		}else{
                                			$view = '<input type="date" class="form-control subjectid_date_view" name="subjectid['.$data['aaData2'][$y]->subjectid.']" value="'.date('Y-m-d').'"  /> ';
                                		}


                                        $teacher = $this->subject_enrollees_model->get_teacher($data['aaData2'][$y]->schedid,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName),t.id")?$this->subject_enrollees_model->get_teacher($data['aaData2'][$y]->schedid,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName) AS fullname,t.id")[0]->fullname:'<span class="label label-danger">Not Assigned</span>';
                                        $time = ($data['aaData2'][$y]->start)?date('h:i A', strtotime($data['aaData2'][$y]->start)).'-'.date('h:i A', strtotime($data['aaData2'][$y]->end)) : '-';
                                        $count_studs = $this->subject_enrollees_model->count_subject_student($data['aaData2'][$y]->schedid,$sem,$sy,'s.studentid');


                                        $data["table"] .='<tr>
                                        <td>'.$data['aaData'][$x]->acadyear.', <br /> '.$data['aaData'][$x]->section.'</td>
                                        <td>'.$data['aaData'][$x]->code.' - '.$data['aaData'][$x]->yearlvl.'</td>
                                        <td class="text-center">'.($teacher).'</td>
                                         <td>'.$data['aaData2'][$y]->courseno.'</td>
                                        <td>'.$data['aaData2'][$y]->description.' ('.$data['aaData2'][$y]->totalunits.' units) </td><td>'.$data['aaData2'][$y]->days.' '.$time.' '.$data['aaData2'][$y]->room.'</td>
                                                <td style="text-align:center;">'.$view.'</td>
                                                </tr>
                                                ';
                            // }
                        }

                                $data["table"] .='';
            endif;
                return $data["table"];
            }



	public function update(){
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=$data["sem_sy"]["sem_sy"][0]->sem;
		$sy=$data["sem_sy"]["sem_sy"][0]->sy;
		$updateV = array(
						'start_date' 		=> $this->input->post('start',true),
						'end_date' 			=> $this->input->post('end',true)
					);


		$grade_submission = $this->grades_submission_model->get_grade_submission($sy,$sem,$this->input->post('type',true));
		if($grade_submission){
			$updateV['updated_at'] = mdate('%Y-%m-%d %H:%i %a');
			$this->grades_submission_model->update_grades_submission($sy,$sem,$this->input->post('type',true),$updateV);
		}else{
			$updateV['updated_at'] = mdate('%Y-%m-%d %H:%i %a');
			$updateV['created_at'] = mdate('%Y-%m-%d %H:%i %a');
			$updateV['sem'] = $sem;
			$updateV['sy'] = $sy;
			$updateV['type'] = $this->input->post('type',true);
			 $this->grades_submission_model->insert_grades_submission($updateV);
		}



	}

		public function st_update(){
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=$data["sem_sy"]["sem_sy"][0]->sem;
		$sy=$data["sem_sy"]["sem_sy"][0]->sy;
		$updateV = array(
						'start_date' 		=> $this->input->post('start',true)

					);


		$grade_submission = $this->grades_submission_model->st_get_grade_submission($sy,$sem,$this->input->post('type',true));
		if($grade_submission){
			$updateV['updated_at'] = mdate('%Y-%m-%d %H:%i %a');
			$this->grades_submission_model->st_update_grades_submission($sy,$sem,$this->input->post('type',true),$updateV);
		}else{
			$updateV['updated_at'] = mdate('%Y-%m-%d %H:%i %a');
			$updateV['created_at'] = mdate('%Y-%m-%d %H:%i %a');
			$updateV['sem'] = $sem;
			$updateV['sy'] = $sy;
			$updateV['type'] = $this->input->post('type',true);
			 $this->grades_submission_model->st_insert_grades_submission($updateV);
		}



	}

	 public function registrar_check_request(){
	 	$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=$data["sem_sy"]["sem_sy"][0]->sem;
		$sy=$data["sem_sy"]["sem_sy"][0]->sy;
		$data['request'] = $this->grade_submission_model->get_gradeupdate_request_id($this->input->post('change_request_id',true),"gu_req.*, sc.courseno, sc.description , CONCAT(s.LastName,', ',s.FirstName,' ',s.MiddleName) as name");
		$data['type_d']=$this->sched_record_model->type($data['request'][0]->type,$sy);
        $data['view_content']='admin_registrar/check_grades_update_request';
		$data['get_plugins_js']='admin_registrar/request_grade_changes_script';
		$data['get_plugins_css']='admin_registrar/request_grade_changes_css';

		$this->load->view('template/init_views',$data);
    }

    public function validate_update_grades_registrar(){

    	$checker = $this->input->post('checker',true);
    	$remarks = $this->input->post('remarks',true);
    	$date_validity = $this->input->post('date_validity',true);
    	$request_id = $this->input->post('request',true);
    	$registrar = $this->session->userdata('id');
    	if($this->grade_submission_model->get_gradeupdate_request_idx( $request_id )){
    		 $request = $this->grade_submission_model->get_gradeupdate_request_idx( $request_id );
    		 $data = json_decode($request[0]->remarks,true);
                $key = count($data);

                $data[$key] = array(
                            'user_id' => $this->session->userdata('id'),
                            'date' => date('Y-m-d H:i:s'),
                            'remarks' => $remarks
                        );

                $date_from =  human_to_unix($date_validity);

                $date_from = date('Y-m-d H:i:s',$date_from);
                echo $checker."string";
                 echo $this->grade_submission_model->update_gradeupdate_request_id($request_id,$date_from,$data,$checker);
    	}else{
    		echo 'error';
    	}
    }



}
