<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record_list_contg extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->load->model('sched_cs_record_model');
		$this->load->model('sched_cs_record_model_contg');
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->admin->_check_login();
	}

	public function table( $settings ,  $labunits ,  $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);

		$data2['cs']=$this->sched_cs_record_model_contg->get_cs( $sched_id ,$teacher_id,$type);
		$data2['conf']=$this->sched_record_model->get_conf( $check_sched[0]['coursecode'], $sched_id ,$teacher_id);
		$data2['conf']['configs']=json_decode($data2['conf'][0]->configs);
		$data3['exam']=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
		$type_d['prcnt'] = $data2['conf']['configs']->percent;
		if($data2['cs']['cs_num']>0){
			$data2['cs_items_total']=$this->sched_cs_record_model_contg->get_cs( $sched_id ,$teacher_id,$type,'SUM(items) as items_sum')['cs_query'][0]->items_sum;
			$transmutation_cs=$this->transmutation->create_json($data2['cs_items_total'],$type_d['prcnt']);
		}else{
			$data2['cs_items_total']=0;
			$transmutation_cs=0;
		}
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){$type_d[8]=  $type_d[8];}
		else{$type_d[8]= $type_d[5];}

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

		if($check_sched['count']>1){
			$tester = ($check_sched[0]['lecunits']!=0 || $check_sched[0]['labunits']!=0) ? 1:0;
			$tester1 = ($check_sched[1]['lecunits']!=0 || $check_sched[1]['labunits']!=0) ? 1:0;
			$tester2 = ($check_sched[1]['lecunits']!=0 && $check_sched[1]['labunits']==0) ? 1:0;
			$tester3 = ($check_sched[1]['lecunits']==0 && $check_sched[1]['labunits']!=0) ? 1:0;

				if( $tester  && $check_sched[0]['teacherid']==str_pad($teacher_id,6,0,STR_PAD_LEFT) && substr($type,0,1)!='l' ){
						$data3['teacher']=1;
						$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $pdf );
				}elseif($tester1  && $check_sched[1]['teacherid']==str_pad($teacher_id,6,0,STR_PAD_LEFT) && substr($type,0,1)=='l' ){
						$data3['teacher']=1;
						$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $pdf );
				}elseif($tester2==1  ||  $tester3==1 ){
						$data3['teacher']=1;
						$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $pdf );
				}else{
						$data3['teacher']=0;
						$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $pdf );
				}
		}else{
			$data3['teacher']=1;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $pdf);
		}

		$th_data = $this->table_th($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $data2 , $data3 , $pdf);
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
					<input type="hidden" id="percent" value="'.$data2['conf']['configs']->percent.'" />
						';

		return $data;
	}

	public function table_th($lecunits, $labunits , $teacher_id ,$type , $sched_id ,$type_d , $cs , $exam  , $pdf){
			$data['th']='';
			$total_cs_prcnt = 0;
			$cs_items_count=0;

			$rowspan='rowspan="1"';
			$colspan='colspan="1"';
			$rowspanx='rowspan="1"';
			$rowspan2e='rowspan="1"';

			if($cs['cs']['cs_num']>0 ){
				$rowspan2='rowspan="1"';
				$rowspan='rowspan="2"';
				$colspan2='colspan="'.($cs['cs']['cs_num']>0?$cs['cs']['cs_num']:1).'"';
			}else{
				$rowspan2="rowspan='1'";
				$colspan2='colspan="1"';
			}
			$data['th'] = "<tr>
								<th ".$colspan." ".$rowspan."  >No</th>
								<th ".$colspan." ".$rowspan."  >ID</th>
								<th ".$colspan." ".$rowspan." class='name_tgrades' >Name</th>
								<th ".$colspan2." ".$rowspan2." ><input type='hidden' name='cs_count-$type' id='cs_count-$type' value='".$cs['cs']['cs_num']."' />Class Standing </th>
								<th ".$colspan." ".$rowspan2." >Total</th>
								<th ".$colspan." ".$rowspan." >TRANS</th>
								<th ".$colspan." ".$rowspan."> $type_d[0] Grade</th>
							</tr>";

      if($cs['cs']['cs_num']>0 ){
      		$total_cs=0;
      		$cs_id_list = '' ;
		    $data['th'] .= "<tr>";

						for($x=0;$x<$cs['cs']['cs_num'];$x++){
							$total_cs = $total_cs + $cs['cs']['cs_query'][$x]->items ;
							$cs_id_list .= $cs['cs']['cs_query'][$x]->id.',';
							$data['th'] .= '<th   >
													'.$cs['cs']['cs_query'][$x]->title.'<br />
													('.$cs['cs']['cs_query'][$x]->items.')<br />
													<small>'.$cs['cs']['cs_query'][$x]->cs_date.'</small>
													<input type="hidden" id="max_cs_'.$sched_id.'_'.$cs['cs']['cs_query'][$x]->id.'_'.$x.'_'.$type.'" value="'.$cs['cs']['cs_query'][$x]->items.'" />
													<input type="hidden" id="cs_id_'.$sched_id.'_'.$x.'_'.$type.'" value="'.$cs['cs']['cs_query'][$x]->id.'" />
											</th>';
						}

						$data['th'] .=	'<th>'.$total_cs.'<br />
											(#Items = '.$cs['cs']['cs_num'].')
											<input type="hidden" id="cs_id_length" value="'.$cs['cs']['cs_num'].'" />
											<input type="hidden" id="cs_id_list" value="'.$cs_id_list.'" />
										</th>';
		    $data['th'] .=  '</tr>';
    	}
     		$data['total_cs_prcnt'] = $total_cs_prcnt;
			return $data;
	}

	public function table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $cs , $exam ,$trans_cs , $pdf ){

		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid ,  $cs ,  $exam  ,$trans_cs , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $cs ,  $exam ,$trans_cs  , $pdf ){

		$td='';
		$score_total=0;
		$totalscore_items=0;
		if($cs['cs']['cs_num']>0){
			for($x=0;$x<$cs['cs']['cs_num'];$x++){
				$cs_id=$cs['cs']['cs_query'][$x]->id;
				$max_cs = $cs['cs']['cs_query'][$x]->items;
				$score = '';
				if(!$this->_check_score($this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type ),'score') && $pdf==FALSE){
							$td .= '<td><input type="number" name="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" id="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" min="0" max="'.$max_cs.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cs_id.'\',\''.$x.'\');" /></td>';
				}elseif($this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type )){
							$score =	$this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type )[0]->score;
							$score_total = $score_total+$score;
							$td .='<td  ondblclick="$(this).ena_edit_cs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cs_id.'\',\''.$x.'\');" ><input type="hidden" name="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" id="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" min="0" max="'.$max_cs.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cs_id.'\',\''.$x.'\');" value="'.$score.'" />
									<span>'.$score.'</span></td>';
				}else{
						$td .='<td></td>';
				}
					if($score!='E'){
								$totalscore_items = $totalscore_items+$max_cs;
					}
			}
		}else{ $td .= '<td></td>'; }
		$trans_new = $trans_cs;
		if($totalscore_items!=$cs['cs_items_total'] && $cs['cs_items_total']>0 && $cs['cs']['cs_num']>0){
			$trans_new=$this->transmutation->create_json($totalscore_items,55);
		}
		$td .='<td id="cs_scoretotal_'.$studentid.'-'.$type.'" >'.$score_total.'</td>';

		$cs_prcntx=0;
		if(($score_total>0)){

			$cs_prcntx=($trans_new[$score_total]);
			$td .='<td id="cs_trans_'.$studentid.'-'.$type.'" >'.$trans_new[$score_total].'</td>';
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.$trans_new[$score_total].'</td>';
		}else{
			$td .='<td id="cs_trans_'.$studentid.'-'.$type.'" ></td>';
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'"></td>'; $cs_prcntx=0;
		}
		$final = round($cs_prcntx,2);
		$table_e_f=( $labunits>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($lecunits==0 && $labunits>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}

		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $final );
		}else{
			if($this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f , $final  )){

			}
		}
		return $td;
	}



	public function other_table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $cs , $exam ,$trans_cs ,$trans_exam , $pdf ){
		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->other_student_cs_score( $lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid ,  $cs ,  $exam  ,$trans_cs ,$trans_exam , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function other_student_cs_score( $lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $cs ,  $exam  ,$trans_cs ,$trans_exam , $pdf ){
		$td='';
		$score_total=0;
		$totalscore_items=0;
		if($cs['cs']['cs_num']>0){
			for($x=0;$x<$cs['cs']['cs_num'];$x++){
				$cs_id=$cs['cs']['cs_query'][$x]->id;
				$max_cs = $cs['cs']['cs_query'][$x]->items;
				$score = '';
				if(!$this->_check_score($this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type ),'score') && $pdf==FALSE){
							$td .= '<td></td>';
				}elseif($this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type )){
							$score =	$this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type )[0]->score;
							$score_total = $score_total+$score;
							$td .='<td   >'.$score.'</td>';
				}else{
						$td .='<td></td>';
				}
					if($score!='E'){
								$totalscore_items = $totalscore_items+$max_cs;
					}
			}
		}else{ $td .= '<td></td>'; }
		$trans_new = $trans_cs;
		if($totalscore_items!=$cs['cs_items_total'] && $cs['cs_items_total']>0 && $cs['cs']['cs_num']>0){
			$trans_new=$this->transmutation->create_json($totalscore_items,55);
		}
		$td .='<td id="cs_scoretotal_'.$studentid.'-'.$type.'" >'.$score_total.'</td>';

		$cs_prcntx=0;
		if(($score_total>0)){

			$cs_prcntx=($trans_new[$score_total]) * ($type_d[1]);
			$td .='<td id="cs_trans_'.$studentid.'-'.$type.'" >'.$trans_new[$score_total].'</td>';
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.round($cs_prcntx,2) .'</td>';
		}else{
			$td .='<td id="cs_trans_'.$studentid.'-'.$type.'" ></td>';
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'"></td>'; $cs_prcntx=0;
		}
		$td .=$this->other_student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $exam , $cs_prcntx ,$trans_cs ,$trans_exam , $pdf );
		return $td;
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