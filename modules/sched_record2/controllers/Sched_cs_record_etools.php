<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_etools extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record2');
		$this->load->model('sched_cs_record_model_wc');
		$this->load->model('sched_cs_record_model_etools');
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$this->admin->_check_login();
	}

     public function get_cs_record( $settings , $type , $sched_id , $check_sched , $teacher_id){
		$sched_id=$check_sched[0]['schedid'];
		$data['type_d'] =$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$data['uri'] = $sched_id;
		$data['teacher_id'] = $this->session->userdata('id');
        $data['cs'] = $this->sched_cs_record_model_etools->get_cs($sched_id,$data['teacher_id'],$type);
		$mydept= $this->session->userdata('mydept');
		$data['table'] = $this->cs_table( $settings ,$check_sched, $sched_id,$data['type_d'],$data['cs'] ,$data['teacher_id'],$mydept);
        return $data;
     }
	 public function cs_table( $settings , $check_sched, $sched_id,$type_d,$cs_list , $teacher_id,$mydept){
	 	$etools = $this->sched_cs_record_model_etools->get_etools('','id,title,etool_code');
	 	$cs_tbody =$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id,$etools);
		  $table = "
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            CLASS STANDING $type_d[7] <span id='typeWord'>".strtoupper($type_d[0])."</span>
							 <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
                        </div>";

                        $table .= "<div class=\"panel-body\">". $settings;
                        $table .='<input type="hidden" id="etools_options" value=\''.str_replace("'","&apos;",json_encode($etools)).'\' />';
						$table .= "<table class='table table-bordered table-condensed' id=\"createCSwcItems\">";
                        $table .= "<thead>
												<tr class=\"text-center\"><th class=\"text-center\">NO.</th><th class=\"text-center\" style=\"width: 50%;\" >ETOOLS</th><th class=\"text-center\" >Date</th><th class=\"text-center\">ADD/DELETE</th></tr>
										   </thead>
										   <tbody>".$cs_tbody['tr']."</tbody>
										</table>
									</div>
									<input type='hidden' id='_this_type' value='".$type_d[6]."' />
								";
				$data["table"] = $table;
				return $data;
	 }

	 public function cs_tbody($sched_id,$type_d,$cs_list, $teacher_id,$etools){

		$tbody['tr'] = '';
		$count=1;
		$total_cs=0;
		$total_cs_prcnt=0;
		$options='<option value="">ITEMS</option>';

		$options = '';
		for ($z=0;$z<$etools['cs_num'];$z++) {
			$options .= '<option value="'.$etools['cs_query'][$z]->id.'">'.$etools['cs_query'][$z]->etool_code.'</option>';
		}
		if($cs_list['cs_num']>0){
			$tr_adddel ='';
			for($x=0;$x<($cs_list['cs_num']);$x++){
				$cs_q = $cs_list['cs_query'][$x];
				$etools_i = $this->sched_cs_record_model_etools->get_etools($cs_q->etools_id,'etool_code,title');
				if($x==0){
					$tr_adddel = ' <button type="button" class="col-md-1 col-md-offset-1 btn btn-success btn-xs" id="tpl_more"><i class="fa fa-plus"></i></button>';
				}else{
					$tr_adddel = ' ';
				}
				$tbody['tr'] .='
					  <tr>
					  <td>'.$count++.'</td>
					  <td><div class="input-group col-sm-10 col-sm-offset-1" >
								<span id="etools_sei_'.$x.'" >'.$etools_i['cs_query'][0]->title.'</span>
					  		<select class="form-control hide" id="etools_se_'.$x.'" >'.($options).' </select></div></td>
					  <td>
							<div class=" dspl-hide input-group date datetimepicker1 col-sm-7 col-sm-offset-1" onclick="$(this).datePickershow('.$x.');" >
			                    <input type="text" class="form-control" id="cs_date_'.$x.'" onclick="$(this).datePickershow('.$x.');"  value="'.$cs_q->cs_date.'" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			                <span id="cs_date_i_'.$x.'" > '.$cs_q->cs_date.'</span>

					  </td>
					  <td style="width:255px">
						  <div class="input-group col-sm-12 " >
							  	<button type="button" class="col-md-1 col-md-offset-1 btn btn-danger btn-xs" onclick="$(this).deleteCSitems('.$x.','.$cs_q->etools_id.');" ><i class="glyphicon glyphicon-trash"></i></button>
							  	'.$tr_adddel.'
						  </div>
					  </td>
					  </tr>
					  ';
					  // <button type="button" class="col-md-1 col-md-offset-1 btn btn-info btn-xs "  onclick="$(this).editCSitems('.$x.','.$cs_q->id.');" ><i class="glyphicon glyphicon-pencil"></i></button>

			}

		}else{
			$tbody['tr'] .='

					  <tr class="cs_adding_wc">
						  <td>1</td>
						  <td><div class="input-group col-sm-10 col-sm-offset-1" ><select class="form-control" id="etools_se_0" >'.($options).' </select></div></td>
						  <td>
								<div class="input-group date datetimepicker1 col-sm-7 col-sm-offset-3" onclick="$(this).datePickershow(0);" >
				                    <input type="text" class="form-control" id="cs_date_0" onclick="$(this).datePickershow(0);" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
						  </td>
						  <td>
						  		<button type="button" class="btn btn-success btn-xs" id="tpl_more"><i class="fa fa-plus"></i></button>
						  		<button type="button" class="btn btn-primary btn-xs "  onclick="$(this).saveCSitems(0);" ><i class="glyphicon glyphicon-floppy-disk"></i></button>
						  </td>
					  </tr>

					  ';

		}

		$tbody['count']=$count;
		$tbody['total_cs']=$total_cs;
		$tbody['total_cs_prcnt']=$total_cs_prcnt;
		return $tbody;
	 }

	 public function total_table($total_cs,$total_cs_prcnt,$count){
		 $table = "
					<table class='table' >
						<thead>
								<tr>
									<th>".($count-1)." items</th>
									<th>TOTAL</th>
									<th><input type='hidden' name='total_cs' id='total_cs' value='$total_cs' />$total_cs   </th>
									<th colspan='2'> $total_cs_prcnt%</th>
								</tr>
								<tr>
								<td colspan='4'> </td>

								</tr>
						</thead>
						<tbody>

						</tbody>
					</table
		 		  ";

				   return $table;
	 }

	 public function save_sched_cs(){
	 	$se_etools = $this->input->post('se_etools',TRUE);
	 	$cs_date = $this->input->post('cs_date',TRUE);
	 	$sched_id = $this->input->post('sched_id',TRUE);
	 	$type = $this->input->post('type',TRUE);
	 	$teacher_id = $this->session->userdata('id');

	 	if($se_etools=='' || $cs_date=='' || $sched_id=='' || $type=='' || $teacher_id=='' ){
	 		echo json_encode('error');
	 	}else{
	 		$data = array(
	 						'sched_id'=> $sched_id,
	 						'teacher_id'=> $teacher_id,
	 						'etools_id'=> $se_etools,
	 						'cs_date'=> mdate('%Y-%m-%d', strtotime($cs_date)),
	 						'cs_type'=> $type,
	 						'date_created'=> mdate('%Y-%m-%d %H:%i %a'),
	 					);
	 		if($this->sched_cs_record_model_etools->get_cs($sched_id,$teacher_id,$type,$se_etools)['cs_num']>0){
	 			echo json_encode(array('error'=>1,'error_msg'=>'ETOOLS ALREADY ADDED '));
	 		}else{
	 			$id =  $this->sched_cs_record_model_etools->save_sched_cs($data);
	 			echo json_encode(array('error'=>0,'etool_id'=>$id));
	 		}

	 	}
	 }

	 public function get_etools_student(){
	 	$data['etool_id'] = $this->input->post('etool_id',TRUE);
	 	$data['studentid'] = $this->input->post('studentid',TRUE);
	 	$data['sched_id'] = $this->input->post('sched_id',TRUE);
	 	$data['etools'] = $this->sched_cs_record_model_etools->get_etools($data['etool_id']);
	 	$data['etools_cats'] = $this->sched_cs_record_model_etools->get_etools_cats($data['etool_id']);
	 	$data['studentname']=($this->student_model->get_student_info($data['studentid'],'lastname , firstname , middlename '));
		$data['studentname']['m_nme'] = ($data['studentname'][0]->middlename!='')?$data['studentname'][0]->middlename[0].'.':'';
	 	$data['agency'] =  $this->sched_cs_record_model_etools->get_agency();;
	 	$data['clinical_area'] =  $this->sched_cs_record_model_etools->get_clinical_area();
	 	for($x=0;$x<$data['etools_cats']['cs_num'];$x++){
	 		$data['etools_cats'][$x] = $data['etools_cats']['cs_query'][$x]->id;
	 		$data['etools_cats']['items'][$x]=  $this->sched_cs_record_model_etools->get_etools_cats_items($data['etool_id'],$data['etools_cats'][$x]);
	 	}
	 	$data['student_score_d'] = '';
	 	if($this->sched_cs_record_model_etools->etools_stu_score($data['sched_id'],$data['etool_id'],$data['studentid'])['cs_num']>0){
	 		$data['student_score_d'] = $this->sched_cs_record_model_etools->etools_stu_score($data['sched_id'],$data['etool_id'],$data['studentid']);
	 	}
	 	$this->load->view('sched_record2/etools_get_stu',$data);
	 }



	public function student_score_update(){
		$studentid = $this->input->post('studentid',TRUE);
		$etool_id = $this->input->post('etool_id',TRUE);
		$clinical_area = $this->input->post('clinical_area',TRUE);
		$agency = $this->input->post('agency',TRUE);
		$group_number = $this->input->post('group_number',TRUE);
		$date_of_exposure = $this->input->post('date_of_exposure',TRUE);
		$total_score = $this->input->post('total_score',TRUE);
		$data_etools = $this->input->post('data_etools');
		$sched_id = $this->input->post('sched_id');
		$score = json_encode($data_etools);

		if($this->sched_cs_record_model_etools->etools_stu_score($sched_id,$etool_id,$studentid)['cs_num']>0){
			$data = array(
						'score' 			=> $score,
						'total' 			=> $total_score,
						'date_of_expsre' 	=> mdate('%Y-%m-%d', strtotime($date_of_exposure)),
						'grp_nmber' 		=> $group_number,
						'clinical_area' 	=> $clinical_area,
						'agency' 			=> $agency,
						'date_updated' 		=> mdate('%Y-%m-%d %H:%i %a'),
					);
				echo $this->sched_cs_record_model_etools->update_student_etools_score($sched_id,$etool_id,$studentid,$data);
		}else{
			$data = array(
						'sched_id' 			=> $sched_id,
						'sched_etools_id' 	=> $etool_id,
						'student_id' 		=> $studentid,
						'score' 			=> $score,
						'total' 			=> $total_score,
						'date_of_expsre' 	=> mdate('%Y-%m-%d', strtotime($date_of_exposure)),
						'grp_nmber' 		=> $group_number,
						'clinical_area' 	=> $clinical_area,
						'agency' 			=> $agency,
						'date_created' 		=> mdate('%Y-%m-%d %H:%i %a'),
					);
				echo $this->sched_cs_record_model_etools->save_student_etools_score($data);
		}
	}

	public function delete_sched_cs(){
		$type = $this->input->post('type', TRUE);
		$schedid = $this->input->post('sched_id', TRUE);
		$etool_id = $this->input->post('etool_id', TRUE);
		$teacher_id = $this->session->userdata('id');
		$trans_status=$this->sched_cs_record_model_etools->delete_sched_cs( $schedid,$teacher_id,$etool_id,$type );
			return $trans_status;
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

