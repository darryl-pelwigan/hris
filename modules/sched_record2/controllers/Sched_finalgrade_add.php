<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_finalgrade_add extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->model('sched_record_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->admin->_check_login();
	}

	public function update_remarks(){
			$sched_id = $this->input->post('sched_id', TRUE);
			$student_id = $this->input->post('student_id', TRUE);
			$remarks = $this->input->post('remarks', TRUE);
			$labunits = $this->input->post('labunits', TRUE);
			$lecunits = $this->input->post('lecunits', TRUE);

			if($lecunits>0 && $labunits>0){	$table_e_f='pcc_gs_student_gradesleclab'; }
			else{ $table_e_f='pcc_gs_student_gradeslec'; }
			if($this->sched_record_model->check_remarks($student_id,$sched_id,$table_e_f)){
				echo $this->sched_record_model->update_remarks($student_id,$sched_id,$remarks,$table_e_f);
			}else{
				echo $this->sched_record_model->insert_remarks($student_id,$sched_id,$remarks,$table_e_f);
			}
	}

     public function get_finalgradex($settings , $sem, $labunits , $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
		$this->load->model('student/student_model');

		if($check_sched['lecunits']>0 && $labunits>0){ $table_e_f='pcc_gs_student_gradesleclab';}
         else{ $table_e_f='pcc_gs_student_gradeslec'; }

		$data['type_d'] =$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$data['uri'] = $sched_id;
		$data['teacher_id'] = $this->session->userdata('id');

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

		$data['student_list']=$student_list;

		$data['sched_info']=$this->sched_record_model->get_subject_exam($check_sched['lecunits'],$labunits , '' ,$sched_id , $type );
		$data['table'] = $this->finalgrade_table($settings , $sem, $labunits , $sched_id , $data['type_d'] , $data['teacher_id'] , $data['student_list'] , $data['sched_info'] , $check_sched , $table_e_f  , $pdf );
		return $data;
     }

	 public function finalgrade_table($settings , $sem, $labunits , $sched_id , $type_d , $teacher_id , $student_list , $sched_info , $check_sched , $table_e_f  , $pdf ){
			$tbody = $this->finalgrade_tbodylec($sem, $labunits , $sched_info  , $sched_id , $type_d , $teacher_id , $student_list , $table_e_f  , $pdf )['tr'];
		$prel='';
		 if($sem!=3){ $prel='<th class=\"text-center\" >PRELIM </th>'; }

		  $table = "<div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                           <span id='typeWord'> GRADES TOTAL </span>
						   <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
                        </div>";
		$table .= "<div class=\"panel-body\">".$settings;
        $table .= "		<table class='table table-condensed table-hover table-striped table-bordered myGradesTable dataTable no-footer' id=\"dataTables-example-p\">";
		$table .= "			<thead>
										<tr class=\"text-center\">
											<th class=\"text-center\">NO.</th>
											<th class=\"text-center\">ID</th>
											<th class=\"text-center\">NAME</th>
											".$prel."
											<th class=\"text-center\">MIDTERM</th>
											<th class=\"text-center\">TENTATIVE FINAL</th>
											<th class=\"text-center\">FINAL</th>
											<th class=\"text-center\">REMARKS</th>
										</tr>
							</thead>
							<tbody>".$tbody."</tbody>
						</table>
				  </div>
				";
					return $table;
	 }

	public function finalgrade_tbodylec($sem, $labunits , $sched_info  , $sched_id , $type_d , $teacher_id , $student_list , $table_e_f  , $pdf ){
		
		$tbody['tr'] = '';
		$count=1;
		$get=  $type_d[5];

		$array_remarks= array('NULL'=>'','P'=>'Passed','F'=>'Failed','NFE'=>'No Final Examination','NG'=>'No GRADE','OD'=>'Officially Dropped','UD'=>'Unofficially Dropped','INC'=>'Incomplete','DRP'=>'DROPPED','WP'=>'Withdrawal with Permission');
		for($x=0;$x<count($student_list);$x++){
			$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
			$leclab_g=$this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , "*" , $table_e_f);
			$pre=0;
			$mid=0;
			$tent=0;
			if($leclab_g){
				$pre=$leclab_g[0]->{$type_d['pre']};
				$mid=$leclab_g[0]->{$type_d['mid']};
				$tent=$leclab_g[0]->{$type_d['tent']};
					$scorelec_pre[$x] ='<input type="number" class="form-control inp-sm text-center empty-cs " min="0" max="99" name="pre_grade_'.$student_list[$x]->studentid.'[]" onblur="" oninput="$(this).computeCs(\''.$student_list[$x]->studentid.'\',\''.$x.'\',\''.$sched_id.'\',\'p\');" value="'.($leclab_g[0]->{$type_d['pre']}).'" /> ';
					$scorelec_mid[$x] ='<input type="number" class="form-control inp-sm text-center empty-cs " min="0" max="99" name="pre_grade_'.$student_list[$x]->studentid.'[]" onblur="" oninput="$(this).computeCs(\''.$student_list[$x]->studentid.'\',\''.$x.'\',\''.$sched_id.'\',\'m\');" value="'.($leclab_g[0]->{$type_d['mid']}).'" /> ';
					$scorelec_tent[$x] ='<input type="number" class="form-control inp-sm text-center empty-cs " min="0" max="99" name="pre_grade_'.$student_list[$x]->studentid.'[]" onblur="" oninput="$(this).computeCs(\''.$student_list[$x]->studentid.'\',\''.$x.'\',\''.$sched_id.'\',\'tf\');" value="'.($leclab_g[0]->{$type_d['tent']}).'" /> ';
			}else{
				$final = 0;
					$scorelec_pre[$x] ='<input type="number" class="form-control inp-sm text-center empty-cs " min="0" max="99" name="pre_grade_'.$student_list[$x]->studentid.'[]" onblur="" oninput="$(this).computeCs(\''.$student_list[$x]->studentid.'\',\''.$x.'\',\''.$sched_id.'\',\'p\');" value="0" /> ';
					$scorelec_mid[$x] ='<input type="number" class="form-control inp-sm text-center empty-cs " min="0" max="99" name="pre_grade_'.$student_list[$x]->studentid.'[]" onblur="" oninput="$(this).computeCs(\''.$student_list[$x]->studentid.'\',\''.$x.'\',\''.$sched_id.'\',\'m\');" value="0" /> ';
					$scorelec_tent[$x] ='<input type="number" class="form-control inp-sm text-center empty-cs " min="0" max="99" name="pre_grade_'.$student_list[$x]->studentid.'[]" onblur="" oninput="$(this).computeCs(\''.$student_list[$x]->studentid.'\',\''.$x.'\',\''.$sched_id.'\',\'tf\');" value="0" /> ';
			}
			$prel="<td>".$scorelec_pre[$x]."</td>";
			$div=3;

			if($sem==3){
				$div=2;
				$prel='';
			}
				$final = ( $pre +  $mid + $tent )  / $div;




				
				$student_remarks_r = '';
		$student_remarks='<option value=""></option>';
				if($this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , 'final_remarks' , $table_e_f)){
					$r = $this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , 'final_remarks' , $table_e_f);
					$r = ($r[0]->final_remarks!=NULL)?$r[0]->final_remarks:'';
					$student_remarks = '<option value="'.$r.'">'.$r.'</option>';
					$student_remarks_r = $r;
				}

				if($final>=75){	$class='passed'; }
				else{ $class='failed'; }
				if($final>=75 || $final<74.5){
					
					$final=round( $final,0 );
				}else{
					if($student_remarks_r == 'Passed'){
						$final=round( $final,0 );
					}else{
						$final=round( $final,2 );
					}
					
				}

				$remarks = '<select class="fnlg_remarks form-control" onchange="$(this).setRemarks(\''.$student_list[$x]->studentid .'\');" id="remarks_'.$student_list[$x]->studentid .'" name="remarks_'.$student_list[$x]->studentid .'"  >
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



						$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$tbody['tr'] .="
				  			<tr>
							  <td>$count</td>
							  <td class='student_lfm' >".$student_list[$x]->studentid."</td>
							  <td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
								".$prel."
							  <td>".$scorelec_mid[$x]."</td>
							  <td>".$scorelec_tent[$x]."</td>
							  <td><span class='".$class."' id='".$student_list[$x]->studentid."_final_grade' >".$final."</span></td>
							   <td><span class='".$class."'>".$remarks."</span></td>
							</tr>
							";
				  $count++;
		}
		return $tbody;
	 }



	 public function _check_score($score,$type_d){
		if($score){
			if($score[0]->{$type_d}!=NULL || $score[0]->{$type_d}!="")
				return 1;
			else
				return 0;
		}else{	return 0;	}
	}


}

