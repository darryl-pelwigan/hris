<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_finalgrade_record extends MY_Controller {

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

     public function get_finalgrade($settings , $sem, $labunits , $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
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
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0 ){
	  		$tbody = $this->finalgrade_tbodyleclab($sem, $labunits , $sched_info  , $sched_id , $type_d , $teacher_id , $student_list , $table_e_f  , $pdf )['tr'];
		 }else{
			$tbody = $this->finalgrade_tbodylec($sem, $labunits , $sched_info  , $sched_id , $type_d , $teacher_id , $student_list , $table_e_f  , $pdf )['tr'];
		 }
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

			if($leclab_g){
					$scorelec_pre[$x] =($leclab_g[0]->{$type_d['pre']});
					$scorelec_mid[$x] =($leclab_g[0]->{$type_d['mid']});
					$scorelec_tent[$x] =($leclab_g[0]->{$type_d['tent']});
			}else{
					$scorelec_pre[$x] ='';
					$scorelec_mid[$x] ='';
					$scorelec_tent[$x] ='';
			}

			$div=3;
			if($sem==3){
				$scorelec_pre[$x]=0;
				$div=2;
			}
				$final =(($scorelec_pre[$x]) + ($scorelec_mid[$x]) + ($scorelec_tent[$x])) / $div;

				if($final>=75){	$class='passed'; }
				else{ $class='failed'; }

				$student_remarks_r = '';
				$student_remarks='<option value=""></option>';
				if($this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , 'final_remarks' , $table_e_f)){
					$r = $this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , 'final_remarks' , $table_e_f);
					$r = ($r[0]->final_remarks!=NULL)?$r[0]->final_remarks:'';
					$student_remarks = '<option value="'.$r.'">'.$r.'</option>';
					$student_remarks_r = $r;
				}

				if($final>=75 || $final<74.5){
					$final=round( $final,0 );
				}else{
					if($student_remarks_r == 'Passed'){
						$final=round( $final,0 );
					}else{
						$final=round( $final,2 );
					}
				}


					$remarks = '<select class="fnlg_remarks form-control" onchange="$(this).setRemarks(\''.$student_list[$x]->studentid.'\');" id="remarks_'.$student_list[$x]->studentid.'" name="remarks_'.$student_list[$x]->studentid.'"  >
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

							if( $pdf){
								$remarks = $student_remarks_r;
							}

						$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';

						$prel_grade = round($scorelec_pre[$x],2);
						$mid_grade = round($scorelec_mid[$x],2);
						$tf_grade = round($scorelec_tent[$x],2);

						switch ($student_remarks_r) {

							case 'No Final Examination':
									$tf_grade = 'NFE';
									$final=	'NFE';
								break;
							case 'No GRADE':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'Officially Dropped':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'Unofficially Dropped':
									$final='--';
								break;

							case 'Incomplete':
									$tf_grade = '--';
									$final='--';
								break;

							case 'No CREDIT':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'DROPPED':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'Withdrawal with Permission':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							default:
								# code...
								break;
						}

						$prel="<td>".$prel_grade."</td>";
						if($sem==3){
								$prel='';
							}

			$tbody['tr'] .="
				  			<tr>
							  <td>$count</td>
							  <td class='student_lfm' >".$student_list[$x]->studentid."</td>
							  <td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							   ".$prel."
							  <td>".$mid_grade."</td>
							  <td>".$tf_grade."</td>
							  <td><span class='".$class."'>".$final."</span></td>
							   <td><span class='".$class."'>".$remarks."</span></td>
							</tr>
							";
				  $count++;
		}
		return $tbody;
	 }

	 public function finalgrade_tbodyleclab($sem, $labunits , $sched_info  , $sched_id , $type_d , $teacher_id , $student_list , $table_e_f  , $pdf ){
		$p['lec']=0;
		$p['lab']=0;
		$array_remarks= array('NULL'=>'','P'=>'Passed','F'=>'Failed','NFE'=>'No Final Examination','NG'=>'No GRADE','OD'=>'Officially Dropped','UD'=>'Unofficially Dropped','INC'=>'Incomplete','DRP'=>'DROPPED','WP'=>'Withdrawal with Permission');
		 if($sched_info['exam_query'] && $sched_info['exam_query'][0]->percentage){
				$percentage=json_decode($sched_info['exam_query'][0]->percentage);
				$p['lec']=$percentage->{'lec'};
				$p['lab']=$percentage->{'lab'};
		}
		$tbody['tr'] = '';
		$count=1;
		$get=  $type_d[8];
		for($x=0;$x<count($student_list);$x++){
			$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
			$leclab_g=$this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , "*" , $table_e_f);

			if($leclab_g){
					$scorelec_pre[$x] =(($leclab_g[0]->{$type_d['pre']})*$p['lec'])/100;
					$scorelec_mid[$x] =(($leclab_g[0]->{$type_d['mid']})*$p['lec'])/100;
					$scorelec_tent[$x] =(($leclab_g[0]->{$type_d['tent']})*$p['lec'])/100;
					$scorelec_lab_pre[$x] =(($leclab_g[0]->{"lab_".$type_d['pre']})*$p['lab'])/100;
					$scorelec_lab_mid[$x] =(($leclab_g[0]->{"lab_".$type_d['mid']})*$p['lab'])/100;
					$scorelec_lab_tent[$x] =(($leclab_g[0]->{"lab_".$type_d['tent']})*$p['lab'])/100;
			}else{
					$scorelec_pre[$x] ='';
					$scorelec_mid[$x] ='';
					$scorelec_tent[$x] ='';
					$scorelec_lab_pre[$x] ='';
					$scorelec_lab_mid[$x] ='';
					$scorelec_lab_tent[$x] ='';
			}

					$scorelec_pre[$x] =$scorelec_pre[$x]+$scorelec_lab_pre[$x];
					$scorelec_mid[$x] =$scorelec_mid[$x]+$scorelec_lab_mid[$x];
					$scorelec_tent[$x] =$scorelec_tent[$x]+$scorelec_lab_tent[$x];
			$div=3;

			if($sem==3){
				$scorelec_pre[$x]=0;
				$div=2;
				$prel='';
			}

			$final =(($scorelec_pre[$x]) + ($scorelec_mid[$x]) + ($scorelec_tent[$x])) / $div;

			if($final>=75){ $class='passed'; }
			else{ $class='failed'; }

			$student_remarks_r = '';
			$student_remarks='<option value=""></option>';
				if($this->sched_record_model->check_remarks($student_list[$x]->studentid,$sched_id,$table_e_f)){
					$r = $this->sched_record_model->check_remarks($student_list[$x]->studentid,$sched_id,$table_e_f);
					$r = ($r[0]->final_remarks!=NULL)?$r[0]->final_remarks:'';
					$student_remarks = '<option value="'.$r.'">'.$r.'</option>';
					$student_remarks_r = $r;

				}

				$remarks = '<select class="fnlg_remarks form-control" onchange="$(this).setRemarks(\''.$student_list[$x]->studentid.'\');" id="remarks_'.$student_list[$x]->studentid.'" name="remarks_'.$student_list[$x]->studentid.'"  >
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

							if( $pdf){
								$remarks = $student_remarks_r;
							}

							$final =	round( $final,0 );
							$prel_grade = round($scorelec_pre[$x],2);
							$mid_grade = round($scorelec_mid[$x],2);
							$tf_grade = round($scorelec_tent[$x],2);

							switch ($student_remarks_r) {

							case 'No Final Examination':
									$tf_grade = 'NFE';
									$final=	'NFE';
								break;
							case 'No GRADE':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'Officially Dropped':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'Unofficially Dropped':
									$final='--';
								break;

							case 'Incomplete':
									$tf_grade = '--';
									$final='--';
								break;

							case 'No CREDIT':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'DROPPED':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							case 'Withdrawal with Permission':
									$prel_grade = '--';
									$mid_grade = '--';
									$tf_grade = '--';
									$final='--';
								break;

							default:
								# code...
								break;
						}
						$prel="<td>".$prel_grade."</td>";
						if($sem==3){
							$prel="";
						}
			$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$tbody['tr'] .="
				  			<tr>
							  <td>$count</td>
							  <td class='student_lfm' >".$student_list[$x]->studentid."</td>
							  <td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							  ".$prel."
							  <td>".$mid_grade."</td>
							  <td>".$tf_grade."</td>
							  <td><span class='".$class."'>".$final."</span></td>
							  <td>".$remarks."</td>
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

