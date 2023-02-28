<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_grades extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('template/template');
		$this->load->model('student/student_model');
		$this->load->model('admin/user_model');
		$this->load->model('template/template_model');
		$this->load->module('student/student_record');
		$this->load->model('student_grades/student_grades_model');
		$this->load->model('admin_registrar/fg_only_model');
		$this->load->module('sched_grades/sched_grades_checker');
	}

	 public function student_gradesx()
	{
		$this->student_record->_check_login();
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['student_id'] = $this->session->userdata('id');
		$data['nav']=$this->student_record->_nav();
		$data['user'] =$this->student_model->get_student_info($data['student_id'],'LastName , FirstName , MiddleName');
		$data['user_role'] =$this->user_model->get_user_role($data['student_id'],'pcc_roles.role');
		$data['subject_year']=$this->student_grades_model->get_subjects_year($data['student_id'],'year');
		$data['t_subject_year']=$this->student_grades_model->get_tsubjects_school($data['student_id']);
		$data['o_subject_year']=$this->student_grades_model->get_osubjects_school($data['student_id']);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;

		$data['view_content']='student_grades/student_grades';
		$data['get_plugins_js']='student_grades/plugins_js_student_grades';
		$data['get_plugins_css']='student_grades/plugins_css_student_grades';

		$this->load->view('template/init_views',$data);
	}

	public function get_grades_record(){
		$sem=$this->input->post('sem', TRUE);
		$sy=$this->input->post('sy', TRUE);
		$school=$this->input->post('school', TRUE);
		$type=$this->input->post('type', TRUE);
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['student_id'] = $this->session->userdata('id');
			$this->leclab_grades($data['student_id'],$sem,$sy);
	}

	public function leclab_grades($student_id,$sem,$sy){
		$this->load->model('admin_registrar/grades_submission_model');
		$this->load->helper('date');
		$data['semx'] = $sem;
		$data['syx'] = $sy;
		$data['st_grade_submission']['p'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'p');
		$data['st_grade_submission']['m'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'m');
		$data['st_grade_submission']['tf'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'tf');
		$data['student_id'] = $this->session->userdata('id');

		$data['sem'] =$sem;
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['sem_w'] =$this->template->get_sem_w($sem,$sy);
		$subject_grades = $this->student_grades_model->get_stud_fgrades($student_id,$sem,$sy);
        $subject_grades_i = $this->student_grades_model->get_stud_fgrades_internships($student_id,$sem,$sy);
        $data['subject_grades'] = array_merge($subject_grades,$subject_grades_i);

        $data['table'] = $this->set_tbody($data);
		// $data['lec']=$this->student_grades_model->get_student_grades_lec($student_id,$sem,$sy,'sc.semester,sc.courseno,sc.description,sc.lecunits,sc.labunits,lc.prelim,lc.midterm,lc.tentativefinal');
		// $data['leclab']=$this->student_grades_model->get_student_grades_leclab($student_id,$sem,$sy,'sc.semester,sc.courseno,sc.description,sc.lecunits,sc.labunits,lcb.prelim,lcb.midterm,lcb.tentativefinal,lcb.lab_prelim,lcb.lab_midterm,lcb.lab_tentativefinal,se.percentage');
		$this->load->view('student_grades/student_grade_data',$data);
	}


	public function set_tbody($data){
		$data_merge = $data['subject_grades'];
		$tbody = '';
		$total_units = 0;
		$total_passed_units = 0;
		$total_failed_units = 0;
		$show_note = false;
		for($x=0;$x<count($data_merge);$x++){
			$z['check_sched'][0]['subjectid'] = $data_merge[$x]->subjectid;
	        $smpt = $this->sched_grades_checker->summer_pmtf($z['check_sched']);
	        $checker = $this->sched_grades_checker->check_subject_type($z['check_sched']);

	        $total_units += $data_merge[$x]->totalunits;
	        	$prelim = 0;
		        $midterm = 0;
		        $tentativefinal = 0;
		         $remarks =  '';
	        if(isset($data_merge[$x]->prelim)){
	        	 $prelim = $data_merge[$x]->prelim;
		        $midterm = $data_merge[$x]->midterm;
		        $tentativefinal = $data_merge[$x]->tentativefinal;
		        $remarks = $data_merge[$x]->remarks;
	        }

	        $final = ($prelim) ;

	        $totalunitsx = '';
				if($smpt || $data_merge[$x]->semester == '3' ){
					$div = 2;
				}else{
					$div = 3;
				}

				if($remarks == 'Passed' ){  $class ='passed'; $total_passed_units += $data_merge[$x]->totalunits; }
        		else{   $class='failed'; $total_failed_units += $data_merge[$x]->totalunits; }

				 $final = ( $midterm + $tentativefinal) + $final ;
				 $final = $final/$div;

				 $finalx = finalg($final ,$remarks);
				 $finalx = gremarks($finalx,$remarks);
				 $check_st_view = $this->sched_grades_checker->check_st_view($z['check_sched']);
				 if($check_st_view){
				 	$finalx = '';
				 	$remarks = '<strong style="color:#9e0404">**n</strong>';
				 	$show_note = true;
				 }


			 $tbody .='<tr class="'.$class.'"><td>'.$data_merge[$x]->courseno.'<td>'.$data_merge[$x]->description.'<td>'.$finalx.'<td>'.$remarks.'</td><td>'.$totalunitsx.'</td></tr>';
		}
		$passed = '';
		$failed = '';
			if($total_units > 0){
				$passed = ($total_passed_units / $total_units) * 100;
		  		$failed = ($total_failed_units / $total_units) * 100;
		  		$passed = number_format($passed,2).'%';
				$failed =  number_format($failed,2).'%';
			}



		  	$data['passed'] = $passed;
		  	$data['failed'] = $failed;

		  	$data['tbody'] = $tbody;
		  	$data['show_note'] = $show_note;

		  	return $data;

	}

	public function leclab_grades2($student_id,$sem,$sy){
		$this->load->model('admin_registrar/grades_submission_model');
		$this->load->helper('date');
		$data['semx'] = $sem;
		$data['syx'] = $sy;
		$data['st_grade_submission']['p'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'p');
		$data['st_grade_submission']['m'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'m');
		$data['st_grade_submission']['tf'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'tf');
		$data['student_id'] = $this->session->userdata('id');

		$data['sem'] =$sem;
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['sem_w'] =$this->template->get_sem_w($sem,$sy);
		$data['subject_grades'] = $this->student_grades_model->get_stud_fgrades($student_id,$sem,$sy);

		// $data['lec']=$this->student_grades_model->get_student_grades_lec($student_id,$sem,$sy,'sc.semester,sc.courseno,sc.description,sc.lecunits,sc.labunits,lc.prelim,lc.midterm,lc.tentativefinal');
		// $data['leclab']=$this->student_grades_model->get_student_grades_leclab($student_id,$sem,$sy,'sc.semester,sc.courseno,sc.description,sc.lecunits,sc.labunits,lcb.prelim,lcb.midterm,lcb.tentativefinal,lcb.lab_prelim,lcb.lab_midterm,lcb.lab_tentativefinal,se.percentage');
		$this->load->view('student_grades/registrar/student_grade_data',$data);
	}

	public function transfer_grades($student_id,$sem,$sy,$school){
		$data['sem'] =$sem;
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['transfer_grades']=$this->student_grades_model->get_tsubjects_school($student_id,$school,$sem,$sy);
		$this->load->view('student_grades/student_grade_tdata',$data);
	}


	public function old_grades($student_id,$sem,$sy,$school){
		$data['sem'] =$sem;
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['transfer_grades']=$this->student_grades_model->get_osubjects_school($student_id,$school,$sem,$sy);
		$this->load->view('student_grades/student_grade_odata',$data);
	}
}
