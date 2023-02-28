<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record_list_fgradeonly extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('teachersched/sched_model');
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->load->model('sched_cs_record_model');
		$this->load->model('sched_cs_record_model_fgradeonly');
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$this->load->model('grade_submission_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->admin->_check_login();
	}

	public function table( $settings ,  $labunits ,  $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$type_d[8] = 'final';
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);

		$check_fused = $this->subject_enrollees_model->check_fused($sched_id);
			if($check_fused[0]->fuse==null){
				$student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid');
			}else{
				$get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
				$schedids = explode(",",$get_fused[0]->sched);
				$test = array();
				for($x=0;$x<count($schedids);$x++){
					$aaData[$x]=$this->sched_record_model->get_student_list($schedids[$x],'s.studentid');
					$test = array_merge($test,$aaData[$x]);
				}
				$student_list=$test;
			}

		$tbody = '';


		$check_grade_submission = $this->grade_submission_model->check_sched_fgrades($sched_id,'final');
		$get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $sched_id , $teacher_id , $type );
			if($check_grade_submission && !$get_gradeupdate_request){
					$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
			}elseif($get_gradeupdate_request){
				if($get_gradeupdate_request[0]->status==1){
					$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
				}else{
					$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
				}
			}else{
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
			}

		$th_data = $this->table_th($teacher_id , $type , $sched_id ,$type_d , $pdf);
		$data['table']='<div class="panel panel-default panel-overflow">
      						<div class="panel-heading"> Student list  FINAL
							   <span class="pull-right glyphicon glyphicon-cog cursor-pointer" data-toggle="collapse" data-target="#settings"></span>
							  </div>
							<div class="panel-body">
							'.$settings.'
							<input type="hidden" name="type" id="type" value="'.$type.'" />
									<table data-page-length="10" class="table table-bordered table-condensed  display  dataTable dtr-inline" id="dataTables-example-p">
										<thead>'.$th_data["th"].'</thead>
										<tbody>'.$tbody.'</tbody>
									</table>
							</div>
						</div>
					<input type="hidden" id="_this_type" value="'.$type.'" />
						';

		return $data;
	}

	public function table_th( $teacher_id ,$type , $sched_id ,$type_d , $pdf){
		$th_widthID = '';
		$th_widthNO = '';
		$th_widthNAME = '';
		$th_widthGRADES = '';
		$th_widthREMARKS = '';
		if($pdf){
			$th_widthID = 'style="width:100px;" ';
			$th_widthNO = 'style="width:50px;" ';
			$th_widthNAME = 'style="width:250px;" ';
			$th_widthGRADES = 'style="width:80px;" ';
			$th_widthREMARKS = 'style="width:120px;" ';
		}
			$data['th'] = "<tr>
								<th ".$th_widthNO." >No </th>
								<th ".$th_widthID." >ID</th>
								<th class='name_tgrades' ".$th_widthNAME." >Name</th>
								<th ".$th_widthGRADES." > FINAL Grade</th>
								<th ".$th_widthREMARKS." > Remarks </th>
							</tr>";
			return $data;
	}

	public function table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf ){

		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';




				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' ><strong >".ucwords(strtolower($student_lfm[0]->lastname)) ."</strong >, ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->student_final_grade($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid , $x  , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function student_final_grade($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $x  , $pdf ){
		$array_remarks= array('NULL'=>'','P'=>'Passed','F'=>'Failed','NFE'=>'No Final Examination','NG'=>'No GRADE','OD'=>'Officially Dropped','UD'=>'Unofficially Dropped','INC'=>'Incomplete','DRP'=>'DROPPED','WP'=>'Withdrawal with Permission');
		$td ='';

		$table_e_f=( $labunits>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($lecunits==0 && $labunits>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}

		$student_remarks_r = '';
		$student_remarks='<option value=""></option>';
				if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , 'final_remarks' , $table_e_f)){
					$r = $this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , 'final_remarks' , $table_e_f);
					$r = ($r[0]->final_remarks!=NULL)?$r[0]->final_remarks:'';
					$student_remarks = '<option value="'.$r.'">'.$r.'</option>';
					$student_remarks_r = $r;
				}

				$remarks = '<select class="fnlg_remarks form-control" onchange="$(this).setRemarks(\''.$studentid.'\');" id="remarks_'.$studentid.'" name="remarks_'.$studentid.'"  >
								'.$student_remarks.'
								<option value="Passed" >Passed</option>
								<option value="Failed" >Failed</option>
								<option value="No Final Examination" >No Final Examination</option>
								<option value="No GRADE" >No Grade</option>
								<option value="Incomplete" >Incomplete</option>
								<option value="No CREDIT" >No Credit</option>
								<option value="DROPPED" >Dropped</option>
								<option value="Withdrawal with Permission" >Withdrawal with Permission</option>
								<option value=""></option>
							</select>';

							if($pdf){
								$remarks = $student_remarks_r;
							}
							$final = '';
							switch ($student_remarks_r) {

							case 'No Final Examination':
									$final=	'NFE';
								break;
							case 'No GRADE':
									$final='NG';
								break;

							case 'Officially Dropped':
									$final='ODRP';
								break;

							case 'Unofficially Dropped':
									$final='UDRP';
								break;

							case 'Incomplete':
									$final='INC';
								break;

							case 'No CREDIT':
									$final='NC';
								break;

							case 'DROPPED':
									$final='DRP';
								break;

							case 'Withdrawal with Permission':
									$final='Withdrawal/P';
								break;

							default:
								# code...
								break;
						}

		if(in_array($student_remarks_r, ['Passed','Failed',''])){
			if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
				if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}){
					$grade = $this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]};
						if($grade>=75){
							$class='passed';
						}else{
							$class='failed';
						}

					$td .=	'<td ondblclick="$(this).ena_edit_cs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$x.'\');" >
								<span id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'_s" class="'.$class.'"> '.($grade).'</span>
								<div class="input-group col-sm-7 col-sm-offset-1">
									<input type="hidden" name="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" min="0" max="99" class="form-control inp-sm text-center empty-cs  " onblur="" oninput="$(this).computeCs(\''.$studentid.'\',\''.$x.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.$grade.'" />
								</div>
							</td>
							<td>'.$remarks.'</td>';
				}else{
					$td .=	'<td>
							<div class="input-group col-sm-7 col-sm-offset-1">
								<input type="number" name="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" min="0" max="99" class="form-control inp-sm text-center empty-cs " onblur="" oninput="$(this).computeCs(\''.$studentid.'\',\''.$x.'\',\''.$sched_id.'\',\''.$type.'\');">
							</div>
						</td>
						<td>'.$remarks.'</td>';
				}
			}else{
				$td .=	'<td>
							<div class="input-group col-sm-7 col-sm-offset-1">
								<input type="number" name="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" min="0" max="99" class="form-control inp-sm text-center empty-cs " onblur="" oninput="$(this).computeCs(\''.$studentid.'\',\''.$x.'\',\''.$sched_id.'\',\''.$type.'\');">
							</div>
						</td>
						<td>'.$remarks.'</td>';
			}

		}else{
			$td .=	'<td>'.$final.'</td>
						<td>'.$remarks.'</td>';
		}

		return $td;
	}



	public function other_table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf ){
		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->other_student_final_grade($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid , $x  , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;

	}

	public function other_student_final_grade( $lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $x  , $pdf ){
		$td ='';

		$table_e_f=( $labunits>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($lecunits==0 && $labunits>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}

		$student_remarks='';
				if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , 'final_remarks' , $table_e_f)){
					$r = $this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , 'final_remarks' , $table_e_f);
					$r = ($r[0]->final_remarks!=NULL)?$r[0]->final_remarks:'';
					$student_remarks = $r;
				}




		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}){
				$grade = $this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]};
					if($grade>=75){
						$class='passed';
					}else{
						$class='failed';
					}
				$td .=	'<td>
							<span id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'_s" class="'.$class.'"> '.($grade).'</span>
						</td>
						<td>'.$student_remarks.'</td>';
			}else{
				$td .=	'<td></td><td>'.$student_remarks.'</td>';
			}
		}else{
				$td .=	'<td></td><td>'.$student_remarks.'</td>';
		}
		return $td;
	}

	public function update_student_fgrade(){
		$sem_sy =$this->session->userdata('new_sem_Sy');
		$studentid = $this->input->post('studentid',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$grade = $this->input->post('grade',TRUE);

		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);

		$check_sched = subject_teacher($data['subject_info2']['sched_query']);

		$table_e_f=( $check_sched['lecunits']>0 && $check_sched['labunits']>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($check_sched['lecunits']==0 && $check_sched['labunits']>0 ){
			$table_e_f='pcc_gs_student_gradeslec';
		}



		$type_d[8] = 'final';
		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}){
				$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $grade );
			}else{
				$trans_status = $this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $grade );
			}
		}else{
			$trans_status = $this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $grade );
		}
		echo $trans_status;

	}

}