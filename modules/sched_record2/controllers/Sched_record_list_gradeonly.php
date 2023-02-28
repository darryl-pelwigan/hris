<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record_list_gradeonly extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('teachersched/sched_model');
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->load->model('sched_cs_record_model');
		$this->load->model('sched_cs_record_model_gradeonly');
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->admin->_check_login();
	}

	public function table( $settings ,  $labunits ,  $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
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
		$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf);
		$th_data = $this->table_th($teacher_id , $type , $sched_id ,$type_d , $pdf);
		$data['table']='<div class="panel panel-default panel-overflow">
      						<div class="panel-heading">'.strtoupper(' Student list  '.$type_d[7].'  '.$type_d[0]).'
							   <span class="pull-right glyphicon glyphicon-cog cursor-pointer" data-toggle="collapse" data-target="#settings"></span>
							  </div>
							<div class="panel-body">
							'.$settings.'
							<input type="hidden" name="type" id="type" value="'.$type.'" />
									<table data-page-length="10" class="table table-bordered  display  dataTable dtr-inline" id="dataTables-example-p">
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
			$data['th'] = "<tr>
								<th>No </th>
								<th>ID</th>
								<th class='name_tgrades' >Name</th>
								<th > $type_d[0] Grade</th>

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
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid , $x , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $x  , $pdf ){

		$td ='';

		$table_e_f=( $labunits>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($lecunits==0 && $labunits>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}

		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}){
				$grade = $this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]};
				$td .=	'<td ondblclick="$(this).ena_edit_cs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$x.'\');" >
							<span id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'_s" > '.($grade).'</span>
							<div class="input-group col-sm-7 col-sm-offset-1">
								<input type="hidden" name="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" min="0" max="99" class="form-control inp-sm text-center empty-cs  " onblur="" oninput="$(this).computeCs(\''.$studentid.'\',\''.$x.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.$grade.'" />
							</div>
						</td>';
			}else{
				$td .=	'<td>
						<div class="input-group col-sm-7 col-sm-offset-1">
							<input type="number" name="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" min="0" max="99" class="form-control inp-sm text-center empty-cs " onblur="" oninput="$(this).computeCs(\''.$studentid.'\',\''.$x.'\',\''.$sched_id.'\',\''.$type.'\');">
						</div>
					</td>';
			}
		}else{
			$td .=	'<td>
						<div class="input-group col-sm-7 col-sm-offset-1">
							<input type="number" name="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" id="grade_'.$sched_id.'_'.$x.'_'.$studentid.'" min="0" max="99" class="form-control inp-sm text-center empty-cs " onblur="" oninput="$(this).computeCs(\''.$studentid.'\',\''.$x.'\',\''.$sched_id.'\',\''.$type.'\');">
						</div>
					</td>';
		}
		return $td;
	}



	public function other_table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $pdf ){
		 $tr='';

		return $tr;
	}

	public function other_student_cs_score( $lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $pdf ){
		$td='';
		return $td;
	}



	public function update_student_grade(){


		$studentid = $this->input->post('studentid',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$grade = $this->input->post('grade',TRUE);
		$type = $this->input->post('type',TRUE);

		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($data['subject_info2']['sched_query']);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);

		$table_e_f=( $check_sched['lecunits']>0 && $check_sched['labunits']>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($check_sched['lecunits']==0 && $check_sched['labunits']>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}

		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $grade );
			$trans_status .= 'update---'.$table_e_f;
		}else{
			$trans_status = $this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $grade );
			$trans_status .= 'insert---'.$table_e_f;
		}
		echo $trans_status;
	}

}
