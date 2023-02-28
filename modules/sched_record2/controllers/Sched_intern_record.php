<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_intern_record extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->model('grade_submission_model');
		$this->admin->_check_login();
	}

	public function get_intern_record( $settings ,  $labunits ,  $type , $sched_idx , $check_sched , $teacher_id ,$pdf=FALSE ){
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$this->load->helper('transmutation');
		$sched_id=$check_sched[0]['schedid'];
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$data['student_list']=$student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid');

		$check_grade_submission = $this->grade_submission_model->check_sched_fgrades($sched_id,$type_d[5]);

		$get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $sched_id , $teacher_id , $type );
			if($check_grade_submission && !$get_gradeupdate_request){
					$tbody = $this->other_table_tbody( $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
			}elseif($get_gradeupdate_request){
				if($get_gradeupdate_request[0]->status==1){
					$tbody = $this->other_table_tbody( $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
				}else{
					$tbody = $this->table_tbody( $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
				}
			}else{
				$tbody = $this->table_tbody( $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
			}

		$data['table']=" <div class='panel panel-default panel-overflow'>
      						<div class='panel-heading'>".strtoupper('Student list  '.$type_d[7].'  '.$type_d[0])."
							   <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
							  </div>
							<div class='panel-body'>
							".$settings."
									<table data-page-length='25' class='table table-condensed table-hover table-striped table-bordered myGradesTable dataTable no-footer myGradesTable' id='dataTables-example-p'>
										<thead>".$this->table_th(  $labunits , $teacher_id , $type , $sched_id ,$type_d , $pdf)."</thead>
										<tbody>".$tbody."</tbody>
									</table>
							</div>
						</div>
					<input type='hidden' id='_this_type' value='".$type."' />
						";

		return $data;
	}

	public function table_th( $labunits , $teacher_id ,$type , $sched_id ,$type_d , $pdf ){
			$rowspan='';
			$colspan='';

			$th = "
					<tr >
						<th >No</th>
						<th  >ID</th>
						<th   class='name_tgrades' >Name</th>
						<th > $type_d[0] Grade</th>
					</tr>";
			return $th;
	}

	public function table_tbody( $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf ){
		 $tr='';
		 $count=1;
		 $table_e_f='pcc_gs_student_gradeslec';
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				if(!$this->sched_record_model->get_intern_grades($sched_id,$student_list[$x]->studentid  , 'final') && $pdf==FALSE ){
					$score = '<td><input type="number" name="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" id="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" max="100" min="65" class="form-control inp-sm text-center empty-cs "  onblur="$(this).computeIntern(\''.$student_list[$x]->studentid.'\',\''.$sched_id.'\',\''.$type.'\');" /> </td>';
				}else{
					if( $this->sched_record_model->get_intern_grades( $sched_id,$student_list[$x]->studentid  , 'final')){
						if($this->sched_record_model->get_intern_grades( $sched_id,$student_list[$x]->studentid  , 'final')[0]->{'final'}==NULL && $pdf==FALSE){
								$score = '<td><input type="number" name="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" id="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" max="100" min="65" class="form-control inp-sm text-center empty-cs "  onblur="$(this).computeIntern(\''.$student_list[$x]->studentid.'\',\''.$sched_id.'\',\''.$type.'\');" /> </td>';
							}else{
								$score = '<td ondblclick="$(this).ena_edit_intern(\''.$student_list[$x]->studentid.'\',\''.$sched_id.'\',\''.$type.'\');"><input type="hidden" name="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" id="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" max="100" min="65" value="'.$this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-cs " onblur="$(this).computeIntern(\''.$student_list[$x]->studentid.'\',\''.$sched_id.'\',\''.$type.'\');" />
									<span>'.$this->sched_record_model->get_intern_grades( $sched_id,$student_list[$x]->studentid  , 'final')[0]->{'final'}.'<span></td>';
							}
						}else{
							$score = '<td></td>';
						}

				}
				$tr .=" <tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$student_lfm[0]->middlename[0].".</td>
							".$score."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function other_table_tbody( $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf ){
		 $tr='';
		 $count=1;
		 $table_e_f='pcc_gs_student_gradeslec';
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
						if( $this->sched_record_model->get_intern_grades( $sched_id,$student_list[$x]->studentid  , 'final')){
						$score = '<td ondblclick="$(this).ena_edit_intern(\''.$student_list[$x]->studentid.'\',\''.$sched_id.'\',\''.$type.'\');"><input type="hidden" name="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" id="final_score_'.$sched_id.'_'.$student_list[$x]->studentid.'-'.$type.'" max="100" min="65" value="'.$this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-cs " onblur="$(this).computeIntern(\''.$student_list[$x]->studentid.'\',\''.$sched_id.'\',\''.$type.'\');" />
									<span>'.$this->sched_record_model->get_intern_grades( $sched_id,$student_list[$x]->studentid  , 'final')[0]->{'final'}.'<span></td>';
						}else{
							$score = '<td></td>';
						}
				$middlename  = isset($student_lfm[0]->middlename[0]) && $student_lfm[0]->middlename[0] != '' ? $student_lfm[0]->middlename[0] : '';
				$tr .=" <tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$middlename.".</td>
							".$score."
						</tr>";
			$count++;
			}
		return $tr;
	}
}
