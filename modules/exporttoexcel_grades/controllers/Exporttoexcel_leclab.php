<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Exporttoexcel_leclab extends MY_Controller {

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
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->model('sched_record/sched_record_model');
		$this->load->model('sched_record/sched_cs_record_model');
		$this->load->model('student/student_model');
		$this->load->model('admin/user_model');
		$this->load->model('teachersched/sched_model');
		$this->load->helper('transmutation');
		$this->load->helper('gradingsystem');
		$this->admin->_check_login();
	}
	public function test()
	{
		$teacher_id = $this->session->userdata('id');

		
		$type = $this->input->get('type', TRUE);
		$sched_id = $this->input->get('sched_id', TRUE);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$subject_course =$this->sched_record_model->get_sched_course($subject_info['sched_query'][0]->courseid);
		$subject_info2 =$this->sched_model->get_sched_info($teacher_id,$subject_info['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($subject_info2['sched_query']);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$cs=$this->sched_record_model->get_subject_cs( $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
		$cs_items_count=0;
		$xx=2;
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){$type_d[8]=  $type_d[8];}
        else{$type_d[8]= $type_d[5];}
		$exam=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
		if($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0){
			echo 'if';
		}else{
			echo 'else';
		}


	}

	public function export_grades()
	{
		$teacher_id = $this->session->userdata('id');
		$type = $this->input->get('type', TRUE);
		$sched_id = $this->input->get('sched_id', TRUE);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$subject_course =$this->sched_record_model->get_sched_course($subject_info['sched_query'][0]->courseid);
		$subject_info2 =$this->sched_model->get_sched_info($teacher_id,$subject_info['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($subject_info2['sched_query']);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$array_type=$this->array_type($type_d[10]);

		foreach ($array_type as $key => $value) {
			echo $value.'<br />x';
		}
	}

	public function array_type($type_d){
		$array_type= array('p'=>array('p','lp'),'m'=>array('m','lm'),'tf'=>array('tf','ltf'),'f'=>array('p','lp','m','lm','tf','ltf'));
		return $array_type[$type_d];
	}


}
