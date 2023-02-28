<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record_list_wsub extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->load->model('sched_cs_record_model_wsub');
		$this->load->model('sched_cs_record_model');
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
        $this->load->model('subject/subject_enrollees_model');
		$this->admin->_check_login();
	}

	public function table( $settings ,  $labunits ,  $type , $sched_id , $check_sched , $teacher_id , $pdf=FALSE ){
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$data2['cs']=$this->sched_cs_record_model_wsub->get_cs( $sched_id ,$teacher_id ,$type);
		$data2['conf']=$this->sched_record_model->get_conf( $check_sched[0]['coursecode'], $sched_id ,$teacher_id);

		$data2['conf']['configs']=json_decode($data2['conf'][0]->configs);

		$data3['exam']=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$type);

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

		$data2['conf']=$this->sched_record_model->get_conf( $check_sched[0]['coursecode'], $sched_id ,$teacher_id);
		$data2['conf']['configs']=json_decode($data2['conf'][0]->configs);
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){$type_d[8]=  $type_d[8];}
		else{$type_d[8]= $type_d[5];}
		$type_d['prcnt'] = $data2['conf']['configs']->percent;
		$data3['trans_exam']=0;
		if($data3['exam']['exam_num']>0 && $data3['exam']['exam_query'][0]->{$type_d[8]}>0){
			$data3['trans_exam']=$this->transmutation->create_json($data3['exam']['exam_query'][0]->{$type_d[8]},$type_d['prcnt']);
		}
		if($check_sched['count']>1){
			$tester = ($check_sched[0]['lecunits']!=0 || $check_sched[0]['labunits']!=0) ? 1:0;
			$tester1 = ($check_sched[1]['lecunits']!=0 || $check_sched[1]['labunits']!=0) ? 1:0;
				if( $tester  && $check_sched[0]['teacherid']==str_pad($teacher_id,6,0,STR_PAD_LEFT) && substr($type,0,1)!='l' ){
						$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3  , $pdf );
				}elseif($tester1  && $check_sched[1]['teacherid']==str_pad($teacher_id,6,0,STR_PAD_LEFT) && substr($type,0,1)=='l' ){
						$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3  , $pdf );
				}else{
						$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 , $pdf );
				}
		}else{
			$test=4;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3  , $pdf);
		}

		$check_grade_submission = $this->grade_submission_model->check_sched_fgrades($sched_id,$type_d[5]);
		$get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $sched_id , $teacher_id , $type );
			if($check_grade_submission && !$get_gradeupdate_request){
					$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 , $pdf );
			}elseif($get_gradeupdate_request){
				if($get_gradeupdate_request[0]->status==1){
					$tbody = $this->other_table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3 , $pdf );
				}else{
					$data3['teacher']=1;
					$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3  , $pdf);
				}
			}else{
				$data3['teacher']=1;
				$tbody = $this->table_tbody( $check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $student_list , $data2 , $data3  , $pdf);
			}

		$th_data = $this->table_th($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $type , $sched_id ,$type_d , $data2 , $data3 , $pdf);
		$data['table']=" <div class='panel panel-default panel-overflow'>
      						<div class='panel-heading'>".strtoupper('Student list  '.$type_d[7].'  '.$type_d[0])."
							   <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
							  </div>
							<div class='panel-body'>
							".$settings."

							<input type='hidden' name='type' id='type' value='".$type."' />
									<table data-page-length='10' class=' table table-bordered  display  dataTable dtr-inline' id='dataTables-example-p'>
										<thead>".$th_data['th']."</thead>
										<tbody>".$tbody."</tbody>
									</table>
							</div>
						</div>
					<input type='hidden' id='_this_type' value='".$type."' />
					<input type='hidden' id='percent' value='".$data2['conf']['configs']->percent."' />
						";

		return $data;
	}

	public function table_th($lecunits, $labunits , $teacher_id ,$type , $sched_id ,$type_d , $cs , $exam  , $pdf){
			if($lecunits>0 && $labunits>0){ $type_d[8]=  $type_d[8];}
         	else{$type_d[8]= $type_d[5];}
			$data['th']='';
			$rowspan='';
			$rowspan2='';
			$colspan='colspan="2"';
			$total_cs_prcnt = 0;
			$cs_items_count=0;
			$cs_subs_i['cs_num']=1;
			if($cs['cs']['cs_num']>0  ){
				if($cs['cs']['cs_num']>0){
					$cs_subs_i=$this->sched_cs_record_model_wsub->get_cs_sub_items_f($sched_id,$teacher_id,$type);
					$cs_subs=$this->sched_cs_record_model_wsub->get_cs_sub_f($sched_id,$teacher_id,$type);

				}
				$rowspan="rowspan='4'";
				$rowspan2="rowspan='3'";
				$cccc =  $cs['cs']['cs_num']+($cs_subs['cs_num']*3)+$cs_subs_i['cs_num'];
				$colspan="colspan='".$cccc."'";
			}
			$data['th'] = "<tr >
								<th ".$rowspan." >No</th>
								<th   ".$rowspan."  >ID</th>
								<th  ".$rowspan." class='name_tgrades' >Name</th>
								<th   ".$colspan." ><input type='hidden' name='cs_count-$type' id='cs_count-$type' value='".$cs['cs']['cs_num']."' />Class Standing </th>
								<th >Total</th>
								<th  ".$rowspan."><input type='hidden' name='cs_prcnt' id='cs_prcnt' value='".$type_d[1]."' /> ".$type_d[3]."</th>
								<th > Exam</th>
								<th ".$rowspan.">Equiv</th>
								<th ".$rowspan."><input type='hidden' name='exam_prcnt' id='exam_prcnt' value='".$type_d[2]."' /> ".$type_d[4]."</th>
								<th ".$rowspan."> $type_d[0] Grade</th>
							</tr>";
      		$exam_max=0;
      if($cs['cs']['cs_num']>0 || ($exam['exam']['exam_num']>0 && $exam['exam']['exam_query'][0]->{$type_d[8]}!=0)){

	        $data['th'] .= "<tr>";
			$cs_catsid_list='';
					if($cs['cs']['cs_num']>0){
						for ($c=0;$c<count($cs['cs']["cs_query"]); $c++) {
								$cats_id=$cs['cs']["cs_query"][$c]->id;
								$cs_catsid_list .= $cats_id.',';
								$cats_desc=$cs['cs']["cs_query"][$c]->description;
								$cats_prcnt=$cs['cs']["cs_query"][$c]->percent;
								$cs_subs=$this->sched_cs_record_model_wsub->get_cs_sub($sched_id,$teacher_id,$cats_id);
								$cs_subs_ix=$this->sched_cs_record_model_wsub->get_cs_sub_items_fx($sched_id,$teacher_id,$cats_id,$type);
								$data['th'] .= ' <th  colspan="'.(1+($cs_subs['cs_num']*3)+$cs_subs_ix['cs_num']).'" >
												'.$cats_desc.'<br />('.$cats_prcnt.'%)
											 </th>';
						}
					}else{
						$data['th'] .='<th '.$rowspan2.' ></th><th></th>';
					}
					$data['th'] .= '<th '.$rowspan2.'  >
										CS(100%)
										<input type="hidden" name="cs_catsid_list-'.$type.'" id="cs_catsid_list-'.$type.'" value="'.$cs_catsid_list.'" />
									</th>';

					if($exam['exam']['exam_num']>0){
		       				 $data['th'] .= ' <th '.$rowspan2.'><input type="hidden" name="total_exam_'.$sched_id.'-$type" id="total_exam_'.$sched_id.'-'.$type.'" value="'.$exam['exam']['exam_query'][0]->{$type_d[8]}.'" />('.$exam['exam']['exam_query'][0]->{$type_d[8]}.')</th>';
					}else{
		        			 $data['th'] .=  '<th '.$rowspan2.'  ></th>';
		      		}

      			$data['th'] .= "</tr>";
				      if($cs['cs']['cs_num']>0){
 						$data['th'] .= "<tr>";

				      	for ($c=0;$c<count($cs['cs']["cs_query"]); $c++) {
								$cats_id=$cs['cs']["cs_query"][$c]->id;
								$cats_desc=$cs['cs']["cs_query"][$c]->description;
								$cats_prcnt=$cs['cs']["cs_query"][$c]->percent;
								$cs_subs=$this->sched_cs_record_model_wsub->get_cs_sub($sched_id,$teacher_id,$cats_id);
								$cs_csubid_list='';
								for ($v=0;$v<count($cs_subs["cs_query"]); $v++) {
									$cs_csub_id=$cs_subs["cs_query"][$v]->id;
									$cs_csubid_list .= $cs_csub_id.',';
									$cats__subdesc=$cs_subs["cs_query"][$v]->description;
									$cats_subprcnt=$cs_subs["cs_query"][$v]->percent;
									$cs_subs_i=$this->sched_cs_record_model_wsub->get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id);
									$data['th'] .= ' <th  colspan="'.(3+$cs_subs_i['cs_num']).'" >
														'.$cats__subdesc.'<br />('.$cats_subprcnt.'%)
													 </th>';
								}
								$data['th'] .= ' <th  rowspan="2" >
														TOTAL
														<input type="hidden" name="cs_csubid_list-'.$type.$cats_id.'" id="cs_csubid_list-'.$type.$cats_id.'" value="'.$cs_csubid_list.'" />
														<input type="hidden" name="cs_csubid_prcnt-'.$type.$cats_id.'" id="cs_csubid_prcnt-'.$type.$cats_id.'" value="'.(($cats_prcnt)/100).'" />
														('.$cats_desc.')

													 </th>';
						}
						$data['th'] .= "</tr>";
				      	$total_cs_sum= 0 ;
				      		$data['th'] .= "<tr >";
								for ($c=0;$c<count($cs['cs']["cs_query"]) ; $c++) {
									$cats_id=$cs['cs']["cs_query"][$c]->id;
									$cs_subs=$this->sched_cs_record_model_wsub->get_cs_sub($sched_id,$teacher_id,$cats_id);
									$cs_sum_items=0;
									for ($x=0;$x<count($cs_subs["cs_query"]); $x++) {
										$cs_csub_id=$cs_subs["cs_query"][$x]->id;
										$cs_items=$this->sched_cs_record_model_wsub->get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id);
										$cs_sum_items=0;
										$cs_csitemsid_list = '';
										if($cs_items['cs_num']>0){
											for ($v=0;$v<$cs_items['cs_num']; $v++) {
												$cs_csitemsid_list .= $cs_items['cs_query'][$v]->id.',';
												$cs_sum_items=$cs_sum_items+$cs_items['cs_query'][$v]->items;
												$data['th'] .= '<th  > '.$cs_items['cs_query'][$v]->title.' ('.$cs_items['cs_query'][$v]->items.')
															<input type="hidden" id="max_cs_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'-'.$type.'" value="'.$cs_items['cs_query'][$v]->items.'" />
															<img src="'.base_url('assets/images/icons/CSV.png').'" onclick="$(this).importDataCs(\''.$teacher_id.'\',\''.$sched_id.'\',\''.$cats_id.'\',\''.$cs_csub_id.'\',\''.$cs_items['cs_query'][$v]->id.'\',\''.$type.'\',\''.$cs["cs"]["cs_query"][$c]->description.'\',\''.$cs_items['cs_query'][$v]->title.'\',\''.date("M d , Y h:i:s A",strtotime($cs_items['cs_query'][$v]->date_updated)).'\');" width="20" />
															</th>';
											}
										}else{
											$data['th'] .= '';
										}
										$trans_new=$this->transmutation->create_json($cs_sum_items,$type_d['prcnt']);
										$data['th'] .= '<th >
																Total <br/>
																('.$cs_sum_items.')
																<input type="hidden" name="cs_csitemsid_list-'.$type.$cats_id.$cs_csub_id.'" id="cs_csitemsid_list-'.$type.$cats_id.$cs_csub_id.'" value="'.$cs_csitemsid_list.'" />
																<input type="hidden" name="cs_csitems_trans-'.$type.$cats_id.$cs_csub_id.'" id="cs_csitems_trans-'.$type.$cats_id.$cs_csub_id.'" value=\''.json_encode($trans_new).'\' />
														</th>';
							      		$data['th'] .= '<th  >Trans <br/>(99)</th>';
							      		$data['th'] .= '<th>
							      							'.$cs_subs["cs_query"][$x]->percent.'%
							      							<input type="hidden" name="cs_csitems_prcnt-'.$type.$cats_id.$cs_csub_id.'" id="cs_csitems_prcnt-'.$type.$cats_id.$cs_csub_id.'" value="'.(($cs_subs["cs_query"][$x]->percent)/100).'" />
							      						</th>';
						      		}
						   }
						   $data['th'] .= "</tr>";
						}
    	}


     		$data['total_cs_prcnt'] = $total_cs_prcnt;
			return $data;
	}

	public function table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $cs , $exam  , $pdf ){
		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td class='student_lfm' >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid ,  $cs ,  $exam  , $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $cs ,  $exam  , $pdf ){
		$td='';
		$total_cs='';
		$trans_new='';
		if($cs['cs']['cs_num']>0){
			for($c=0;$c<count($cs['cs']["cs_query"]);$c++){
				$cats_id=$cs['cs']['cs_query'][$c]->id;
				$cats_prcnt=$cs['cs']["cs_query"][$c]->percent;
				$cs_subs=$this->sched_cs_record_model_wsub->get_cs_sub($sched_id,$teacher_id,$cats_id);
				$score_total = 0;
				$scorexx ='';
				$cs_items_total=0;
				$max_sub_items=0;
				$cs_prcntx=0;
				$cs_sub_prcntx=0;
				$title_subs='';
				for($y=0;$y<count($cs_subs["cs_query"]);$y++){
					$cs_csub_id=$cs_subs["cs_query"][$y]->id;
					$cs_csub_prcnt=$cs_subs["cs_query"][$y]->percent;
					$cs_items=$this->sched_cs_record_model_wsub->get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id);
					$cs_items_sum=0;
					if($cs_items['cs_num']>0){
						$cs_items_sum=$this->sched_cs_record_model_wsub->get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id,'SUM(items) as items_sum')['cs_query'][0]->items_sum;
							for ($v=0;$v<($cs_items["cs_num"]); $v++) {
								$max=$cs_items['cs_query'][$v]->items;
								$max_sub_items=$max_sub_items+$max;
								if(!$this->_check_score($this->sched_cs_record_model_wsub->get_cs_score( $labunits ,$studentid , $sched_id , $cats_id ,$cs_csub_id ,$cs_items['cs_query'][$v]->id, $type , 'cs_score' ),'cs_score') && $pdf==FALSE){
										$scorexx .='<td><input type="number" name="cs_score_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'_'.$studentid.'-'.$type.$c.$y.$v.'" id="cs_score_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'_'.$studentid.'-'.$type.$c.$y.$v.'" min="0" max="'.$max.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cats_id.'\',\''.$cs_csub_id.'\',\''.$cs_items['cs_query'][$v]->id.'\',\''.$c.'\',\''.$y.'\',\''.$v.'\');" /></td>';

								}elseif($this->sched_cs_record_model_wsub->get_cs_score( $labunits ,$studentid , $sched_id , $cats_id ,$cs_csub_id ,$cs_items['cs_query'][$v]->id , $type , 'cs_score' )){
										$score =	$this->sched_cs_record_model_wsub->get_cs_score( $labunits ,$studentid , $sched_id , $cats_id ,$cs_csub_id ,$cs_items['cs_query'][$v]->id , $type , 'cs_score' )[0]->cs_score;
										$score_total = $score_total+$score;
										$scorexx .='<td  ondblclick="$(this).ena_edit_cs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cats_id.'\',\''.$cs_csub_id.'\',\''.$cs_items['cs_query'][$v]->id.'\',\''.$c.'\',\''.$y.'\',\''.$v.'\');" >
														<input type="hidden" name="cs_score_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'_'.$studentid.'-'.$type.$c.$y.$v.'" id="cs_score_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'_'.$studentid.'-'.$type.$c.$y.$v.'" min="0" max="'.$max.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cats_id.'\',\''.$cs_csub_id.'\',\''.$cs_items['cs_query'][$v]->id.'\',\''.$c.'\',\''.$y.'\',\''.$v.'\');" value="'.$score.'" />
														<span>'.$score.'</span>
													</td>';
								}else{
									$scorexx .='<td></td>';
								}
							}
							if($max_sub_items!=$cs_items_sum && $cs_items_sum>0 && $cs_items['cs_num']>0){
								$trans_new=$this->transmutation->create_json($cs_items_sum,$type_d['prcnt']);
							}else{
								$trans_new=$this->transmutation->create_json($max_sub_items,$type_d['prcnt']);
							}
							$cs_trans=$trans_new[$score_total];
							$cs_sub_prcntx=round(($cs_trans * ($cs_csub_prcnt/100)),2);
							$scorex =$scorexx.'<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-total">'.$score_total.'</td>
												<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-trn">'.$cs_trans.'</td>
												<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-prcnt">'.$cs_sub_prcntx.'</td>';
					}else{
						$score_total = 0;
						$trans_new=$this->transmutation->create_json($score_total,$type_d['prcnt']);
						$cs_trans=$trans_new[$score_total];
						$cs_sub_prcntx=round(($cs_trans * ($cs_csub_prcnt/100)),2);
						$scorex = '<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-total" >'.$score_total.'</td>
								   <td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-trn" >'.$cs_trans.'</td>
								   <td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-prcnt">'.$cs_sub_prcntx.'</td>';
					}

					$td .= "".($scorex)."";
					$scorex = '';
					$scorexx ='';

					$cs_items_total=$cs_items_total+$cs_sub_prcntx;
					$cs_prcntx=round(($cs_items_total * ($cats_prcnt/100)),2);


					$score_total = 0;
					$max_sub_items=0;


				}
				$total_cs=$total_cs+$cs_prcntx;
				$td .='<td id="cs_scorecats_total_'.$studentid.'_'.$sched_id.'_'.$cats_id.'-'.$type.'" >'.$cs_prcntx.'</td>';
			}
		}else{ $td .= '<td></td><td></td>'; }
		$td .='<td id="cs_scoretotal_'.$studentid.'_'.$sched_id.'-'.$type.'" >'.$total_cs.'</td>';
		$cs_prcnt_final=0;
		if(($total_cs>0)){
			$cs_prcnt_final=($total_cs) * ($type_d[1]);
			$cs_prcnt_final=round($cs_prcnt_final,2);
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.($cs_prcnt_final).'</td>';
		}else{	$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.$cs_prcnt_final.'</td>';}


		$td .=$this->student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $exam , $cs_prcnt_final  , $pdf );
		return $td;
	}

	public function student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $exam , $cs_prcnt  , $pdf ){
		if($lecunits>0 && $labunits>0)
            $type_d[8]=  $type_d[8];
         else
            $type_d[8]= $type_d[5];
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
						$scorex='<td><input type="number" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][$x]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" /></td>';
				}else{
					if($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )){
							$score = $this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )[0]->{$type_d[8]};
							$dbclck ='ondblclick="$(this).ena_edit_exam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');"';
					}else{	$score = '';
							$dbclck ='';
					}
					$scorex='<td '.$dbclck.' ><input type="hidden" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][$x]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.($score).'" />
					<span>'.$score.'</span></td>';
				}
				$td .= $scorex;
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					 $td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'">'.$exam['trans_exam'][$score].'</td>';
				}else{	$td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'" ></td>'; }
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					$exam_prcnt=($exam['trans_exam'][$score]) * ($type_d[2]);
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
			$td .= '<td></td><td></td><td></td><td id="exam_scorefinal_'.$studentid.'_'.$sched_id.'-'.$type.'" >'.($final).'</td>';
		}
		return $td;
	}

	public function other_table_tbody($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list , $cs , $exam , $pdf ){
		 $tr='';
		 $count=1;
			for($x=0;$x<count($student_list);$x++){
				$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				 $tr .="<tr id='row_".$student_list[$x]->studentid."'>
							<td >$count</td>
							<td >".$student_list[$x]->studentid."</td>
							<td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							".$this->other_student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $student_list[$x]->studentid ,  $cs ,  $exam, $pdf )."
						</tr>";
			$count++;
			}
		return $tr;
	}

	public function other_student_cs_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $cs ,  $exam , $pdf ){
		$td='';
		$total_cs='';
		$trans_new='';
		if($cs['cs']['cs_num']>0){
			for($c=0;$c<count($cs['cs']["cs_query"]);$c++){
				$cats_id=$cs['cs']['cs_query'][$c]->id;
				$cats_prcnt=$cs['cs']["cs_query"][$c]->percent;
				$cs_subs=$this->sched_cs_record_model_wsub->get_cs_sub($sched_id,$teacher_id,$cats_id);
				$score_total = 0;
				$scorexx ='';
				$cs_items_total=0;
				$max_sub_items=0;
				$cs_prcntx=0;
				$cs_sub_prcntx=0;
				$title_subs='';
				for($y=0;$y<count($cs_subs["cs_query"]);$y++){
					$cs_csub_id=$cs_subs["cs_query"][$y]->id;
					$cs_csub_prcnt=$cs_subs["cs_query"][$y]->percent;
					$cs_items=$this->sched_cs_record_model_wsub->get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id);
					$cs_items_sum=0;
					if($cs_items['cs_num']>0){
						$cs_items_sum=$this->sched_cs_record_model_wsub->get_cs_sub_items($sched_id,$teacher_id,$cats_id,$cs_csub_id,'SUM(items) as items_sum')['cs_query'][0]->items_sum;
							for ($v=0;$v<($cs_items["cs_num"]); $v++) {
								$max=$cs_items['cs_query'][$v]->items;
								$max_sub_items=$max_sub_items+$max;
								if($this->sched_cs_record_model_wsub->get_cs_score( $labunits ,$studentid , $sched_id , $cats_id ,$cs_csub_id ,$cs_items['cs_query'][$v]->id , $type , 'cs_score' )){
										$score =	$this->sched_cs_record_model_wsub->get_cs_score( $labunits ,$studentid , $sched_id , $cats_id ,$cs_csub_id ,$cs_items['cs_query'][$v]->id , $type , 'cs_score' )[0]->cs_score;
										$score_total = $score_total+$score;
										$scorexx .='<td  ondblclick="$(this).ena_edit_cs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cats_id.'\',\''.$cs_csub_id.'\',\''.$cs_items['cs_query'][$v]->id.'\',\''.$c.'\',\''.$y.'\',\''.$v.'\');" >
														<input type="hidden" name="cs_score_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'_'.$studentid.'-'.$type.$c.$y.$v.'" id="cs_score_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'_'.$cs_items['cs_query'][$v]->id.'_'.$studentid.'-'.$type.$c.$y.$v.'" min="0" max="'.$max.'" class="form-control inp-sm text-center empty-cs " onblur=""  oninput="$(this).computeCs(\''.$studentid.'\',\''.$sched_id.'\',\''.$type.'\',\''.$cats_id.'\',\''.$cs_csub_id.'\',\''.$cs_items['cs_query'][$v]->id.'\',\''.$c.'\',\''.$y.'\',\''.$v.'\');" value="'.$score.'" />
														<span>'.$score.'</span>
													</td>';
								}else{
									$scorexx .='<td></td>';
								}
							}
							if($max_sub_items!=$cs_items_sum && $cs_items_sum>0 && $cs_items['cs_num']>0){
								$trans_new=$this->transmutation->create_json($cs_items_sum,$type_d['prcnt']);
							}else{
								$trans_new=$this->transmutation->create_json($max_sub_items,$type_d['prcnt']);
							}
							$cs_trans=$trans_new[$score_total];
							$cs_sub_prcntx=round(($cs_trans * ($cs_csub_prcnt/100)),2);
							$scorex =$scorexx.'<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-total">'.$score_total.'</td>
												<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-trn">'.$cs_trans.'</td>
												<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-prcnt">'.$cs_sub_prcntx.'</td>';
					}else{
						$score_total = 0;
						$trans_new=$this->transmutation->create_json($score_total,$type_d['prcnt']);
						$cs_trans=$trans_new[$score_total];
						$cs_sub_prcntx=round(($cs_trans * ($cs_csub_prcnt/100)),2);
						$scorex = '<td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-total" >'.$score_total.'</td>
								   <td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-trn" >'.$cs_trans.'</td>
								   <td id="cs_score_'.$studentid.'_'.$sched_id.'_'.$cats_id.'_'.$cs_csub_id.'-'.$type.'-prcnt">'.$cs_sub_prcntx.'</td>';
					}

					$td .= "".($scorex)."";
					$scorex = '';
					$scorexx ='';

					$cs_items_total=$cs_items_total+$cs_sub_prcntx;
					$cs_prcntx=round(($cs_items_total * ($cats_prcnt/100)),2);


					$score_total = 0;
					$max_sub_items=0;


				}
				$total_cs=$total_cs+$cs_prcntx;
				$td .='<td id="cs_scorecats_total_'.$studentid.'_'.$sched_id.'_'.$cats_id.'-'.$type.'" >'.$cs_prcntx.'</td>';
			}
		}else{ $td .= '<td></td><td></td>'; }
		$td .='<td id="cs_scoretotal_'.$studentid.'_'.$sched_id.'-'.$type.'" >'.$total_cs.'</td>';
		$cs_prcnt_final=0;
		if(($total_cs>0)){
			$cs_prcnt_final=($total_cs) * ($type_d[1]);
			$cs_prcnt_final=round($cs_prcnt_final,2);
			$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.($cs_prcnt_final).'</td>';
		}else{	$td .='<td id="cs_scoreprcnt_'.$studentid.'-'.$type.'">'.$cs_prcnt_final.'</td>';}


		$td .=$this->other_student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid ,  $exam , $cs_prcnt_final  , $pdf );
		return $td;
	}

	public function other_student_exam_score($lecunits , $labunits , $teacher_id , $type , $sched_id ,$type_d , $studentid , $exam , $cs_prcnt, $pdf ){
		if($lecunits>0 && $labunits>0)
            $type_d[8]=  $type_d[8];
         else
            $type_d[8]= $type_d[5];
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
					// if($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )){
					// 		$score = $this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )[0]->{$type_d[8]};
					// 		$dbclck ='ondblclick="$(this).ena_edit_exam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');"';
					// }else{	$score = '';
					// 		$dbclck ='';
					// }
					// $scorex='<td '.$dbclck.' ><input type="hidden" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][$x]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.($score).'" />
					// <span>'.$score.'</span></td>';
				
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type ,  $type_d[8]),$type_d[8])<=0 && $exam['exam']['exam_query'][$x]->{$type_d[8]} > 0 && $pdf==FALSE){
						$scorex='<td><input type="number" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][$x]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" /></td>';
				}else{
					if($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )){
							$score = $this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )[0]->{$type_d[8]};
							$dbclck ='ondblclick="$(this).ena_edit_exam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');"';
					}else{	$score = '';
							$dbclck ='';
					}
					$scorex='<td '.$dbclck.' ><input type="hidden" name="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" id="exam_score_'.$exam_id.'_'.$studentid.'_'.$sched_id.'-'.$type.'" min="0" max="'.$exam['exam']['exam_query'][$x]->{$type_d[8]}.'" class="form-control inp-sm text-center empty-exam " onblur="" oninput="$(this).computeExam(\''.$studentid.'\',\''.$exam_id.'\',\''.$sched_id.'\',\''.$type.'\');" value="'.($score).'" />
					<span>'.$score.'</span></td>';
				}
				$td .= $scorex;
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					 $td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'">'.$exam['trans_exam'][$score].'</td>';
				}else{	$td .='<td id="exam_scoreequiv_'.$studentid.'_'.$sched_id.'-'.$type.'" ></td>'; }
				if($this->_check_score($this->sched_record_model->get_exam_score($lecunits , $labunits , $teacher_id , $studentid , $sched_id , $type , $type_d[8]),$type_d[8]) ){
					$exam_prcnt=($exam['trans_exam'][$score]) * ($type_d[2]);
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
			$td .= '<td></td><td></td><td></td><td id="exam_scorefinal_'.$studentid.'_'.$sched_id.'-'.$type.'" >'.($final).'</td>';
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
