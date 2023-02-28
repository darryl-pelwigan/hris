<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record_list_wc extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->load->model('sched_cs_record_model');
		$this->load->model('sched_cs_record_model_wc');
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$this->load->model('grade_submission_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->load->model('admin_registrar/grades_submission_model');
		$this->admin->_check_login();
	}

	public function table( $settings ,  $labunits ,  $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
		
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);

		$data2['cs']=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,$type);
		$data2['conf']=$this->sched_record_model->get_conf( $check_sched[0]['coursecode'], $sched_id ,$teacher_id);
		$data2['conf']['configs']=json_decode($data2['conf'][0]->configs);
		$data3['exam']=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$type);


        $data['grade_submission'] = $this->grades_submission_model->get_grade_submission($check_sched[0]['schoolyear'],$check_sched[0]['semester'],$type_d[10]);


		$type_d['prcnt'] = $data2['conf']['configs']->percent;
		if($data2['cs']['cs_num']>0){
			$data2['cs_items_total']=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,$type,'SUM(items) as items_sum')['cs_query'][0]->items_sum;
			$transmutation_cs=$this->transmutation->create_json($data2['cs_items_total'],$type_d['prcnt']);
		}else{
			$data2['cs_items_total']=0;
			$transmutation_cs=0;
		}
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){
			$type_d[8]=  $type_d[8];
		}
		else{
			$type_d[8]= $type_d[5];
		}

		$end_date_x =  new Carbon\Carbon($data['grade_submission'][0]->end_date);
		$now =  Carbon\Carbon::now();



		$check_grade_submission = $this->grade_submission_model->check_sched_fgrades($sched_id,$type_d[5]);


		if($data3['exam']['exam_num']>0 && $data3['exam']['exam_query'][0]->{$type_d[8]}>0){
			$transmutation_exam=$this->transmutation->create_json($data3['exam']['exam_query'][0]->{$type_d[8]},$type_d['prcnt']);
		}else{
			$transmutation_exam=0;
		}

		$check_fused = $this->subject_enrollees_model->check_fused($sched_id);
			if($check_fused[0]->fuse==null){
				$student_list=$this->sched_record_model->get_student_list($sched_id,'r.*, s.*, CONCAT(r.lastname, " ", r.firstname) as fullname');
			}else{
				$get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
				$schedids = explode(",",$get_fused[0]->sched);
				$test = array();
				for($x=0;$x<count($schedids);$x++){
					$aaData[$x]=$this->sched_record_model->get_student_list($schedids[$x],'r.*, s.*, CONCAT(r.lastname, " ", r.firstname) as fullname');
					$test = array_merge($test,$aaData[$x]);
				}
				$student_list=$test;
			}

			$student_list = json_decode(json_encode($student_list), true);
			usort($student_list , build_sorter('fullname') );
			$student_list = json_decode(json_encode($student_list));
		// $data['student_list']=$student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid');
			// var_dump($subject_info['sched_query'][0]->type);
		if($check_sched['count']>1){
			$teacheridx = str_pad($teacher_id,6,0,STR_PAD_LEFT);
			$typex = substr($type,0,1);
			$sched_type = $subject_info['sched_query'][0]->type;
			// if($check_sched[$teacheridx]['type'] == 'Laboratory' && $typex =='l' ){
			// 	$data3['teacher']=1;
			// 	$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			// }elseif ($check_sched[$teacheridx]['type'] == 'Lecture' && $typex !='l') {
			// 	$data3['teacher']=1;
			// 	$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			// }elseif ($check_sched[$teacheridx]['type'] == 'Lecture' && $typex =='l') {
			// 	$data3['teacher']=0;
			// 	$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			// }elseif ($check_sched[$teacheridx]['type'] == 'Laboratory' && $typex !='l') {
			// 	$data3['teacher']=0;
			// 	$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			// }
			// 
			if($sched_type == 'Lec&Lab'  ){
				$data3['teacher']=1;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			}elseif($sched_type == 'Laboratory' && $typex =='l' ){
				$data3['teacher']=1;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			}elseif ($sched_type == 'Lecture' && $typex !='l') {
				$data3['teacher']=1;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			}elseif ($sched_type == 'Lecture' && $typex =='l') {
				$data3['teacher']=0;
				$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			}elseif ($sched_type == 'Laboratory' && $typex !='l') {
				$data3['teacher']=0;
				$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
			}

		}else{
			$data3['teacher']=1;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf);
		}

		if($check_grade_submission){
			$get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $sched_id , $teacher_id , $type );
			if($get_gradeupdate_request){
				if($get_gradeupdate_request[0]->status==1){
					$data3['teacher']=0;
					$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
				}
			}
		}

		if($now->gt($end_date_x)){
			$data3['teacher']=0;
					$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 ,$transmutation_cs , $transmutation_exam , $pdf );
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

			if($lecunits>0 && $labunits>0){ $type_d[8]=  $type_d[8];}
         	else{$type_d[8]= $type_d[5];}
			$data['th']='';
			$total_cs_prcnt = 0;
			$cs_items_count=0;

			$rowspan='rowspan="1"';
			$colspan='colspan="1"';
			$rowspanx='rowspan="1"';
			$rowspan2e='rowspan="1"';

			if($cs['cs']['cs_num']>0 || $exam['exam']['exam_num']>0 && $exam['exam']['exam_query'][0]->{$type_d[8]}!=0 ){
				$rowspan2='rowspan="1"';
				$rowspan='rowspan="3"';
				$colspan2='colspan="'.($cs['cs']['cs_num']>0?$cs['cs']['cs_num']:1).'"';
			}else{
				$rowspan2="rowspan='1'";
				$colspan2='colspan="1"';
			}
			// if($exam['exam']['exam_num']>0){$rowspan2e='rowspan="1"';}
			// else{$rowspan2e='rowspan="3"';}
			$data['th'] = "<tr>
								<th ".$colspan." ".$rowspan."  >No".$exam['exam']['exam_num']."</th>
								<th ".$colspan." ".$rowspan."  >ID".$cs['cs']['cs_num']."</th>
								<th ".$colspan." ".$rowspan." class='name_tgrades' >Name</th>
								<th ".$colspan2." ".$rowspan2." ><input type='hidden' name='cs_count-$type' id='cs_count-$type' value='".$cs['cs']['cs_num']."' />Class Standing </th>
								<th ".$colspan." ".$rowspan2." >Total</th>
								<th ".$colspan." ".$rowspan." >Trans</th>
								<th ".$colspan." ".$rowspan."><input type='hidden' name='cs_prcnt' id='cs_prcnt' value='".$type_d[1]."' /> ".$type_d[3]."</th>
								<th ".$colspan." ".$rowspan2e."> Exam</th>
								<th ".$colspan." ".$rowspan.">Equiv</th>
								<th ".$colspan." ".$rowspan."><input type='hidden' name='exam_prcnt' id='exam_prcnt' value='".$type_d[2]."' /> ".$type_d[4]."</th>
								<th ".$colspan." ".$rowspan."> $type_d[0] Grade</th>
							</tr>";
      		$exam_max=0;
      if($cs['cs']['cs_num']>0 || ($exam['exam']['exam_num']>0 && $exam['exam']['exam_query'][0]->{$type_d[8]}!=0)){
	        $data['th'] .= "<tr>";
					if($cs['cs']['cs_num']>0){

						for($x=0;$x<$cs['cs']['cs_num'];$x++){
							if($exam['teacher']!=0){
								$xcl='$(this).importDataCs(\''.$teacher_id.'\',\''.$sched_id.'\',\''.$cs["cs"]["cs_query"][$x]->id.'\',\''.$type.'\',\''.$cs["cs"]["cs_query"][$x]->title.'\',\''.mdate('%Y-%m-%d',strtotime($cs["cs"]["cs_query"][$x]->cs_date)).'\',\''.$x.'\');';
							}else{
								$xcl='';
							}
							$data['th'] .= '<th><img src="'.base_url('assets/images/icons/CSV.png').'" onclick="'.$xcl.'" width="20" /></th>';
						}
						$data['th'] .='<th rowspan="2" >'.($cs['cs_items_total']).'
											<input type="hidden" id="total_cs" value="'.($cs['cs_items_total']).'" />
											<input type="hidden" id="total_cs_count" value="'.($cs['cs']['cs_num']).'" />
										</th>';

					}else{
						$data['th'] .='<th></th><th></th>';
					}

					if($exam['exam']['exam_num']>0){
						if($exam['teacher']!=0 && $exam['exam']['exam_query'][0]->{$type_d[8]}!=0){
								$xcl_e='$(this).importDataExam(\''.$teacher_id.'\',\''.$sched_id.'\',\''.$type.'\');';
							}else{
								$xcl_e='';
							}
						if($lecunits>0 && $labunits>0){$type_d[8]=  $type_d[8];}
						else{$type_d[8]= $type_d[5];}
		       			$data['th'] .= '<th rowspan="1" ><img src="'.base_url('assets/images/icons/CSV.png').'" onclick="'.$xcl_e.'" width="20" /></th>';
					}else{
		        		$data['th'] .='<th></th>';
		      		}
		    $data['th'] .=  '</tr>';
		    $data['th'] .= "<tr>";
					if($cs['cs']['cs_num']>0){
						for($x=0;$x<$cs['cs']['cs_num'];$x++){
							$data['th'] .= '<th   >'.$cs['cs']['cs_query'][$x]->title.'<br />('.$cs['cs']['cs_query'][$x]->items.')<br /><small>'.$cs['cs']['cs_query'][$x]->cs_date.'</small><input type="hidden" id="max_cs_'.$sched_id.'_'.$cs['cs']['cs_query'][$x]->id.'_'.$x.'_'.$type.'" value="'.$cs['cs']['cs_query'][$x]->items.'" /><input type="hidden" id="cs_id_'.$sched_id.'_'.$x.'_'.$type.'" value="'.$cs['cs']['cs_query'][$x]->id.'" /></th>';
						}
					}else{
						$data['th'] .='<th></th><th></th>';
					}

					if($exam['exam']['exam_num']>0){
						if($lecunits>0 && $labunits>0){$type_d[8]=  $type_d[8];}
						else{$type_d[8]= $type_d[5];}

		       			$data['th'] .= '<th rowspan="1" >
		       											<input type="hidden" name="total_total_examid_'.$sched_id.'-'.$type.'" id="total_examid_'.$sched_id.'-'.$type.'" value="'.$exam['exam']['exam_query'][0]->id.'" />
		       											<input type="hidden" name="total_exam_'.$sched_id.'-'.$type.'" id="total_exam_'.$sched_id.'-'.$type.'" value="'.$exam['exam']['exam_query'][0]->{$type_d[8]}.'" />
		       											'.$exam['exam']['exam_query'][0]->{$type_d[8]}.
		       							'</th>';
					}else{
		        		$data['th'] .='<th></th>';
		      		}
		    $data['th'] .=  '</tr>';
    	}
     		$data['total_cs_prcnt'] = $total_cs_prcnt;
			return $data;
	}

	public function table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $cs , $exam ,$trans_cs ,$trans_exam , $pdf ){

		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid ,  $cs ,  $exam  ,$trans_cs ,$trans_exam , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $cs ,  $exam ,$trans_cs ,$trans_exam  , $pdf ){

		$td='';
		$score_total=0;
		$totalscore_items=0;
		if($cs['cs']['cs_num']>0){
			for($x=0;$x<$cs['cs']['cs_num'];$x++){
				$cs_id=$cs['cs']['cs_query'][$x]->id;
				$max_cs = $cs['cs']['cs_query'][$x]->items;
				$score = '';
				if(!$this->_check_score($this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type ),'score') && $pdf==FALSE){
							$td .= '<td><input type="number" name="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" id="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" min="0" max="'.$max_cs.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cs_id.'\',\''.$x.'\');" /></td>';
				}elseif($this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type )){
							$score =	$this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type )[0]->score;
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
		$td .='<td class="test" id="cs_scoretotal_'.$studentid.'-'.$type.'" >'.$score_total.'</td>';

		$cs_prcntx=0;
		if(($score_total>0)){

			$cs_prcntx=($trans_new[$score_total]) * ($type_d[1]);
			$td .='<td id="cs_trans_'.$studentid.'-'.$type.'" >'.$trans_new[$score_total].'</td>';
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.round($cs_prcntx,2) .'</td>';
		}else{
			$td .='<td id="cs_trans_'.$studentid.'-'.$type.'" ></td>';
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'"></td>'; $cs_prcntx=0;
		}
		$td .=$this->student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $exam , $cs_prcntx ,$trans_cs ,$trans_exam , $pdf );
		return $td;
	}

	public function student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $exam , $cs_prcnt ,$trans_cs ,$trans_exam  , $pdf ){
		if($lecunits>0 && $labunits>0){$type_d[8]=  $type_d[8];}
        else{$type_d[8]= $type_d[5];}
		$final=$cs_prcnt;
		$td='';
		if($lecunits>0 && $labunits>0 ){
					$table_e_f='pcc_gs_student_gradesleclab';
		}else{
					$table_e_f='pcc_gs_student_gradeslec';
		}
		if($exam['exam']['exam_num']>0 && $exam['exam']['exam_query'][0]->{$type_d[8]}!=0){
			for($x=0;$x<$exam['exam']['exam_num'];$x++){

				$exam_id=$exam['exam']['exam_query'][$x]->id;
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type ,  $type_d[8]),$type_d[8])<=0 && $exam['exam']['exam_query'][$x]->{$type_d[8]} > 0 && $pdf==FALSE){
						$scorex='<td><input type="number" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][0]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" /></td>';
				}else{
					if($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )){
							$score = $this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )[0]->{$type_d[8]};
							$dbclck ='ondblclick="$(this).ena_edit_exam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');"';
					}else{	$score = '';
							$dbclck ='';
					}
					$scorex='<td '.$dbclck.' ><input type="hidden" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][0]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.($score).'" />
					<span>'.$score.'</span></td>';
				}
				$td .= $scorex;
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					 $td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'">'.$trans_exam[$score].'</td>';
				}else{	$td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'" ></td>'; }
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					$exam_prcnt=$trans_exam[$score] * ($type_d[2]);
					 $td .='<td id="exam_scoreprcnt_'.$studentid.'_'.$sched_id.'-'.$type.'">'.$exam_prcnt .'</td>';
				}else{	$td .='<td id="exam_scoreprcnt_'.$studentid.'_'.$sched_id.'-'.$type.'" ></td>'; $exam_prcnt=0; }
				$final=$final+$exam_prcnt;
				if($final>=75){
					$class='passed';
				}else{
					$class='failed';
				}
				$trans_status=0;
				if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
					if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}!=round($final,2)){
										$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, round($final,2) );
					}
				}else{
					$trans_status=0;
					$this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f , round($final,2)  );
				}
				$td .='<td id="exam_scorefinal_'.$studentid.'_'.$sched_id.'-'.$type.'" ><span class="'.$class.'">'.round($final,2).'</span></td>';
			}
		}else{
			$trans_status=0;
			if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
					if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}!=round($final,2)){
										$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, round($final,2) );
					}
			}else{
					$trans_status=0;
					$this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f , round($final,2)  );
			}
			if($final>=75){
					$class='passed';
				}else{
					$class='failed';
				}
			$td .= '<td></td><td></td><td></td><td id="exam_scorefinal_'.$studentid.'_'.$sched_id.'-'.$type.'" ><span class="'.$class.'">'.($final).'<span></td>';
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
				if(!$this->_check_score($this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type ),'score') && $pdf==FALSE){
							// $td .= '<td></td>';
							$td .= '<td><input type="number" name="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" id="cs_score_'.$sched_id.'_'.$cs_id.'_'.$studentid.'-'.$type.'-'.$x.'" min="0" max="'.$max_cs.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cs_id.'\',\''.$x.'\');" /></td>';
				}elseif($this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type )){
							// $score =	$this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type )[0]->score;
							// $score_total = $score_total+$score;
							// $td .='<td   >'.$score.'</td>';

							$score =	$this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs_id,$sched_id,$type )[0]->score;
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
		$td .='<td class="test" id="cs_scoretotal_'.$studentid.'-'.$type.'" >'.$score_total.'</td>';

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

	public function other_student_exam_score( $lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $exam , $cs_prcntx ,$trans_cs ,$trans_exam , $pdf){
		if($lecunits>0 && $labunits>0){$type_d[8]=  $type_d[8];}
        else{$type_d[8]= $type_d[5];}
		$final=$cs_prcntx;
		$td='';
		if($lecunits>0 && $labunits>0 ){
					$table_e_f='pcc_gs_student_gradesleclab';
		}else{
					$table_e_f='pcc_gs_student_gradeslec';
		}
		if($exam['exam']['exam_num']>0 && $exam['exam']['exam_query'][0]->{$type_d[8]}!=0){
			for($x=0;$x<$exam['exam']['exam_num'];$x++){

				$exam_id=$exam['exam']['exam_query'][$x]->id;
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type ,  $type_d[8]),$type_d[8])<=0 && $exam['exam']['exam_query'][$x]->{$type_d[8]} > 0 && $pdf==FALSE){
						// $scorex='<td></td>';
						$scorex='<td><input type="number" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][0]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" /></td>';
				}else{
					if($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )){
							$score = $this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )[0]->{$type_d[8]};
							$dbclck ='ondblclick="$(this).ena_edit_exam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');"';
					}else{	$score = '';
							$dbclck ='';
					}
					
					$scorex='<td '.$dbclck.' ><input type="hidden" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][0]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.($score).'" />
					<span>'.$score.'</span></td>';
					// $scorex='<td >'.$score.'</td>';
				}
				$td .= $scorex;
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					 $td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'">'.$trans_exam[$score].'</td>';
				}else{	$td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'" ></td>'; }
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					$exam_prcnt=$trans_exam[$score] * ($type_d[2]);
					 $td .='<td id="exam_scoreprcnt_'.$studentid.'_'.$sched_id.'-'.$type.'">'.$exam_prcnt .'</td>';
				}else{	$td .='<td id="exam_scoreprcnt_'.$studentid.'_'.$sched_id.'-'.$type.'" ></td>'; $exam_prcnt=0; }
				$final=$final+$exam_prcnt;
				if($final>=75){
					$class='passed';
				}else{
					$class='failed';
				}
				$trans_status=0;
				if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
					if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}!=round($final,2)){
										$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, round($final,2) );
					}
				}else{
					$trans_status=0;
					$this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f , round($final,2)  );
				}
				$td .='<td id="exam_scorefinal_'.$studentid.'_'.$sched_id.'-'.$type.'" ><span class="'.$class.'">'.round($final,2).'</span></td>';
			}
		}else{
			$trans_status=0;
			if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
					if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)[0]->{$type_d[8]}!=round($final,2)){
										$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, round($final,2) );
					}
			}else{
					$trans_status=0;
					$this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f , round($final,2)  );
			}
			if($final>=75){
					$class='passed';
				}else{
					$class='failed';
				}
			$td .= '<td></td><td></td><td></td><td id="exam_scorefinal_'.$studentid.'_'.$sched_id.'-'.$type.'" ><span class="'.$class.'">'.($final).'<span></td>';
		}
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