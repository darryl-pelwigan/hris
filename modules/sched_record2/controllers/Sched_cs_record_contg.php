<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_contg extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record2');
		$this->load->model('sched_cs_record_model_contg');
		$this->load->model('sched_record_model');
		$this->admin->_check_login();
	}

     public function get_cs_record( $settings , $type , $sched_id , $check_sched , $teacher_id){
		$sched_id=$check_sched[0]['schedid'];
		$data['type_d'] =$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$data['uri'] = $sched_id;
		$data['teacher_id'] = $this->session->userdata('id');
        $data['cs'] = $this->sched_cs_record_model_contg->get_cs($sched_id,$data['teacher_id'],$type);
		$mydept= $this->session->userdata('mydept');
		$data['table'] = $this->cs_table( $settings ,$check_sched, $sched_id,$data['type_d'],$data['cs'] ,$data['teacher_id'],$mydept);
        return $data;
     }
	 public function cs_table( $settings , $check_sched, $sched_id,$type_d,$cs_list , $teacher_id,$mydept){
	 	$cs_tbody =$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id);
		  $table = "
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            CLASS STANDING $type_d[7] <span id='typeWord'>".strtoupper($type_d[0])."</span>
							 <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
                        </div>";

                        $table .= "<div class=\"panel-body\">". $settings;
						$table .= "<table class='table table-bordered table-condensed' id=\"createCSwcItems\">";
                        $table .= "<thead>
												<tr class=\"text-center\"><th class=\"text-center\">NO.</th><th class=\"text-center\">Decription</th><th class=\"text-center\">Items</th><th class=\"text-center\" >Date</th><th class=\"text-center\">ADD/DELETE</th></tr>
										   </thead>
										   <tbody>".$cs_tbody['tr']."</tbody>
										</table>
									</div>
									<input type='hidden' id='_this_type' value='".$type_d[6]."' />
								";
				$data["table"] = $table;
				return $data;
	 }

	 public function cs_tbody($sched_id,$type_d,$cs_list, $teacher_id){

		$tbody['tr'] = '';
		$count=1;
		$total_cs=0;
		$total_cs_prcnt=0;
		$options='<option value="">ITEMS</option>';
		if($cs_list['cs_num']>0){
			$tr_adddel ='';
			for($x=0;$x<($cs_list['cs_num']);$x++){
				$cs_q = $cs_list['cs_query'][$x];
				if($x==0){
					$tr_adddel = ' <button type="button" class="col-md-1 col-md-offset-1 btn btn-success btn-xs" id="tpl_more"><i class="fa fa-plus"></i></button>';
				}else{
					$tr_adddel = ' ';
				}
				$tbody['tr'] .='
					  <tr>
					  <td>'.$count++.'</td>
					  <td><div class="input-group col-sm-10 col-sm-offset-1" ><input type="hidden" class="form-control " id="cs_desc_'.$x.'" value="'.$cs_q->title.'"   /><span id="cs_desc_i_'.$x.'" > '.$cs_q->title.'</span></div></td>
					  <td><div class="input-group col-sm-7 col-sm-offset-1"><input type="hidden" min="5" max="1000" class="form-control" id="cs_items_'.$x.'" value="'.$cs_q->items.'" /><span id="cs_items_i_'.$x.'" > '.$cs_q->items.'</span></div></td>
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
							  	<button type="button" class="col-md-1 col-md-offset-1 btn btn-info btn-xs "  onclick="$(this).editCSitems('.$x.','.$cs_q->id.');" ><i class="glyphicon glyphicon-pencil"></i></button>
							  	<button type="button" class="col-md-1 col-md-offset-1 btn btn-danger btn-xs" onclick="$(this).deleteCSitems('.$x.','.$cs_q->id.');" ><i class="glyphicon glyphicon-trash"></i></button>
							  	'.$tr_adddel.'
						  </div>
					  </td>
					  </tr>
					  ';
					  $total_cs=$total_cs+$cs_q->items;


			}

		}else{
			$tbody['tr'] .='

					  <tr class="cs_adding_wc">
						  <td>1</td>
						  <td><div class="input-group col-sm-10 col-sm-offset-1" ><input type="text" class="form-control" id="cs_desc_0"  /></div></td>
						  <td><div class="input-group col-sm-7 col-sm-offset-1"><input type="number" min="5" max="1000" class="form-control" id="cs_items_0"></div></td>
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


	 public function create_sched_cs(){
		$this->load->helper('date');
		$teacher_id = $this->session->userdata('id');
		$type = $this->input->post('type', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$cs_items = $this->input->post('cs_items', TRUE);
		$cs_date = $this->input->post('cs_date', TRUE);
		$data = array(
						'sched_id' => $sched_id,
						'teacher_id' => $teacher_id,
						'title' => $cs_desc,
						'items' => $cs_items,
						'type' => $type,
						'cs_date' => mdate('%Y-%m-%d', strtotime($cs_date)),
						'date_created' => mdate('%Y-%m-%d  %H:%i %a')
					 );
		$trans_status=$this->sched_cs_record_model_contg->create_sched_cs( $data );
			return $trans_status;
	}


	public function delete_sched_cs(){
		$type = $this->input->post('type', TRUE);
		$schedid = $this->input->post('sched_id', TRUE);
		$cs_id = $this->input->post('cs_id', TRUE);
		$teacher_id = $this->session->userdata('id');
		$trans_status=$this->sched_cs_record_model_contg->delete_sched_cs( $schedid,$teacher_id,$cs_id,$type );
			return $trans_status;
	}

	public function update_sched_cs(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$cs_items = $this->input->post('cs_items', TRUE);
		$cs_date = $this->input->post('cs_date', TRUE);
		$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$cs_date = mdate('%Y-%m-%d', strtotime($cs_date));
		if($this->session->userdata('id')==$teacher_id){
			$get_cs_item = $this->sched_cs_record_model_contg->get_cs_one( $cs_id,$sched_id,$teacher_id,$type );

			if($get_cs_item['cs_query'][0]->items>$cs_items){
				$trans_status=$this->sched_cs_record_model_contg->update_sched_cs_del_scores( $sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_date );
			}else{
				$trans_status=$this->sched_cs_record_model_contg->update_sched_cs( $sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_date );
			}

			return $trans_status;
		}else{
			echo "Update Failed. Please Try again later.";
		}


	}

	public function update_student_cs(){
		$studentid = $this->input->post('studentid', TRUE);
		$cs_id = $this->input->post('cs_id', TRUE);
		$cs_items = $this->input->post('cs_val', TRUE);
		$cs_items = ($cs_items=='NULL')?NULL:$cs_items;
		$sched_id = $this->input->post('schedid', TRUE);
		$type = $this->input->post('type', TRUE);
		$teacher_id = $this->session->userdata('id');

		$data['check_sched'] = $this->sched_record2->get_check_sched($teacher_id,$sched_id);
		$table_e_f=( $data['check_sched']['labunits']>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($data['check_sched']['lecunits']==0 && $data['check_sched']['labunits']>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}
		$final = 0;
		$type_d=$this->sched_record_model->type($type,$data['check_sched'][0]['acadyear']);

		if($this->sched_cs_record_model_contg->get_student_cs( $studentid,$cs_id,$sched_id,$type )){
			$trans_status=$this->sched_cs_record_model_contg->update_student_cs( $studentid,$cs_id,$cs_items,$sched_id,$type );
			echo $trans_status;
		}else{
			if($this->sched_cs_record_model_contg->insert_student_cs( $studentid,$cs_id,$cs_items,$sched_id,$type ))
				echo TRUE;
			else
				echo FALSE;
		}

		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f, $final );
			echo $trans_status;
		}else{
			if($this->sched_record_model->insert_student_finalgrade( $studentid , $sched_id , $type_d , $table_e_f , $final  )){
				echo TRUE;
			}else {echo FALSE;}
		}
	}
	public function view_cs_items(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$teacher_id = $this->input->post('teacher_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$data['items']=$this->sched_cs_record_model_contg->view_cs_items($teacher_id,$sched_id,$cs_id,$type);

		$data['table']='';

		for($x=0;$x<$data['items']['cs_i_num'];$x++){
			$data['table'] .="<tr>
								<td>".$x."</td>
								<td>".$data['items']['cs_i_query'][$x]->title."</td>
								<td>".$data['items']['cs_i_query'][$x]->items."</td>
								<td>".$data['items']['cs_i_query'][$x]->date_created."</td>
								<td>".$data['items']['cs_i_query'][$x]->date_updated."</td>
								<td>
									<a class='btn btn-success btn-xs' href='#' onclick='$(this).editCSItem(\"".$teacher_id."\",\"".$cs_id."\",\"".$data['items']['cs_i_query'][$x]->id."\",\"".$data['items']['cs_i_query'][$x]->title."\",\"".$data['items']['cs_i_query'][$x]->items."\",\"".$sched_id."\",\"".$type."\");'><i class='glyphicon glyphicon-edit'></i> edit</a>
                        			<a class='btn btn-danger btn-xs' href='#' onclick='$(this).deleteCSItem(\"".$teacher_id."\",\"".$cs_id."\",\"".$data['items']['cs_i_query'][$x]->id."\",\"".$data['items']['cs_i_query'][$x]->title."\",\"".$data['items']['cs_i_query'][$x]->items."\",\"".$sched_id."\",\"".$type."\");'><i class='glyphicon glyphicon-remove'></i> delete</a>
								</td>
							  </tr>";
		}
		$this->load->view('sched_record2/cs_items',$data);
	}


	public function add_cs_items(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$teacher_id = $this->input->post('teacher_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$title = $this->input->post('title', TRUE);
		$items = $this->input->post('items', TRUE);
		$cs_items=$this->sched_cs_record_model_contg->view_cs_items($teacher_id,$sched_id,$cs_id,$type,'SUM(items) as sum_items');
		$cs_items = ($cs_items['cs_i_query'][0]->sum_items)+($items);
		if($cs_items>400){
			echo json_encode(array('error_c'=>1,'message'=>'You have exceeded '.$cs_items.' the total available CS is only 400 !!!'));
		}else{
			$data = array(
						'sched_id' => $sched_id,
						'cs_id' => $cs_id,
						'title' => $title,
						'items' => $items,
						'date_updated' => mdate('%Y-%m-%d %H:%i %a'),
						'date_created' => mdate('%Y-%m-%d %H:%i %a')
					 );
			$this->sched_cs_record_model_contg->add_cs_items($data);
			echo json_encode(array('error_c'=>0,'message'=>'Successfully created '));
		}

	}

	public function edit_cs_item(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$teacher_id = $this->input->post('teacher_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$type = $this->input->post('type', TRUE);

		$cs_i_id =  $this->input->post('cs_i_id', TRUE);
		$title = $this->input->post('csi_title', TRUE);
		$items = $this->input->post('csi_items', TRUE);

		echo $this->sched_cs_record_model_contg->edit_cs_item($sched_id,$type,$cs_id,$title,$items);
	}

	public function show_selected_template(){
		$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_tpl_id = $this->input->post('cs_tpl_id', TRUE);
		$check_sched = $this->sched_record2->get_check_sched($teacher_id,$sched_id);
		$cs_tpl = $this->sched_cs_record_model_contg->get_cs_template($cs_tpl_id,'',$check_sched);
		$data='';
		$data['title']=$cs_tpl[0]->description;
		$test='<table class="table table-bordered table-bordered1"><thead><tr><th>Decription</th><th>Percent</th></tr></thead><tbody>';
		if($check_sched[0]['lecunits']>0 && $check_sched['labunits'] == 0 ){
			$cs_tpl_data=json_decode($cs_tpl[0]->lec);
			$total_val=0;
			foreach ($cs_tpl_data as $key => $value) {
				$test .='<tr><td>'.$key.'</td><td>'.$value.'%</td></tr>';
				$total_val=$total_val+$value;
			}
		}elseif($check_sched[0]['lecunits']==0 && $check_sched['labunits'] >0 ){
			$cs_tpl_data=json_decode($cs_tpl[0]->lab);
			$total_val=0;
			foreach ($cs_tpl_data as $key => $value) {
				$test .='<tr><td>'.$key.'</td><td>'.$value.'%</td></tr>';
				$total_val=$total_val+$value;
			}
		}else{
			$cs_tpl_datalec=$cs_tpl[0]->lec;
			$cs_tpl_datalab=$cs_tpl[0]->lab;

		}
		$test .='</tbody></table>';

		$data['test'] =$test;



		echo json_encode($data);

	}

	public function insert_selected_template(){
		$this->load->helper('date');
		$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_tpl_id = $this->input->post('cs_tpl_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$check_sched = $this->sched_record2->get_check_sched($teacher_id,$sched_id);
		$cs_tpl = $this->sched_cs_record_model_contg->get_cs_template($cs_tpl_id,'',$check_sched);
		if($check_sched[0]['lecunits']>0 && $check_sched['labunits'] == 0 ){
			$cs_tpl_data=json_decode($cs_tpl[0]->lec);
			foreach ($cs_tpl_data as $key => $value) {
				$data = array(
						'schedid' => $sched_id,
						'teacher_id' => $teacher_id,
						'description' => $key,
						'items' => null,
						'percent' => $value,
						'type' => $type,
						'date_created' => mdate('%Y-%m-%d %H:%i %a'),
						'date_updated' => mdate('%Y-%m-%d %H:%i %a')
					 );
				$trans_status=$this->sched_cs_record_model_contg->create_sched_cs( $data );
			}
			return $trans_status;
		}elseif($check_sched[0]['lecunits']==0 && $check_sched['labunits'] >0 ){
			$cs_tpl_data=json_decode($cs_tpl[0]->lab);
			$total_val=0;
			foreach ($cs_tpl_data as $key => $value) {
				$data = array(
						'schedid' => $sched_id,
						'teacher_id' => $teacher_id,
						'description' => $key,
						'items' => null,
						'percent' => $value,
						'type' => $type,
						'date_created' => mdate('%Y-%m-%d %H:%i %a'),
						'date_updated' => mdate('%Y-%m-%d %H:%i %a')
					 );
				$trans_status=$this->sched_cs_record_model_contg->create_sched_cs( $data );
			}
		}else{
			$cs_tpl_datalec=$cs_tpl[0]->lec;
			$cs_tpl_datalab=$cs_tpl[0]->lab;

		}
	}

	public function create_cs_template(){
		$this->load->helper('date');
		$teacher_id = $this->session->userdata('id');
		$mydept= $this->session->userdata('mydept');
		$mydept_info = $this->sched_record_model->get_sched_course_dept($mydept);
		$data_tpl = $this->input->post('c',TRUE);
		$rowCount = $this->input->post('rowCount',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$title = $this->input->post('title',TRUE);
		$check_sched = $this->sched_record2->get_check_sched($teacher_id,$sched_id);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		if($check_sched[0]['lecunits']>0 && $check_sched['labunits'] == 0 ){
			$data = array(
						'college_id' => $mydept,
						'description' => strtoupper($title).'-'.$mydept_info[0]->code.'-LEC',
						'sy' => $subject_info['sched_query'][0]->schoolyear,
						'sem' => $subject_info['sched_query'][0]->semester,
						'lec' => json_encode($data_tpl),
						'lab' => NULL,
						'date_created' => mdate('%Y-%m-%d %H:%i %a'),
						'date_updated' => mdate('%Y-%m-%d %H:%i %a')
					 );
			$trans_status=$this->sched_cs_record_model_contg->create_cs_template( $data );
			echo  json_encode($trans_status);
		}elseif($check_sched[0]['lecunits']==0 && $check_sched['labunits'] >0 ){
			$data = array(
						'college_id' => $mydept,
						'description' => strtoupper($title).'-'.$mydept_info[0]->code.'-LAB',
						'sy' => $subject_info['sched_query'][0]->schoolyear,
						'sem' => $subject_info['sched_query'][0]->semester,
						'lec' => NULL,
						'lab' => json_encode($data_tpl),
						'date_created' => mdate('%Y-%m-%d %H:%i %a'),
						'date_updated' => mdate('%Y-%m-%d %H:%i %a')
					 );
			$trans_status=$this->sched_cs_record_model_contg->create_cs_template( $data );
			echo  json_encode($trans_status);

		}else{
			// $data = array(
			// 			'college_id' => $mydept,
			// 			'description' => $title,
			// 			'sy' => $subject_info['sched_query'][0]->schoolyear,
			// 			'sem' => $subject_info['sched_query'][0]->semester,
			// 			'lec' => null,
			// 			'lab' => json_encode($data_tpl),
			// 			'date_created' => mdate('%Y-%m-%d %H:%i %a'),
			// 			'date_updated' => mdate('%Y-%m-%d %H:%i %a')
			// 		 );
			// $trans_status=$this->sched_cs_record_model_contg->create_sched_cs( $data );
			// return $trans_status;

		}

	}

	public function import_data_csv(){

		$teacher_id = $this->input->post('teacher_id',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$cs_id = $this->input->post('cs_id',TRUE);
		$type = $this->input->post('type',TRUE);
		$scores = $this->input->post('scores',TRUE);
		$student_count = $this->input->post('student_count',TRUE);
		$trans_status=0;
		$test = '';
		for($x=0;$x<$student_count;$x++){

			if(!$this->sched_cs_record_model_contg->get_student_cs( $scores[$x]['studentid'],$cs_id,$sched_id,$type )){
				$trans_status .=$this->sched_cs_record_model_contg->insert_student_cs( $scores[$x]['studentid'],$cs_id,$scores[$x]['score'],$sched_id,$type );
			}else{
				$trans_status .=$this->sched_cs_record_model_contg->update_student_cs( $scores[$x]['studentid'],$cs_id,$scores[$x]['score'],$sched_id,$type );
			}
		}
		echo json_encode(array('message'=>'Successfully imported.',$trans_status)).$test;
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

