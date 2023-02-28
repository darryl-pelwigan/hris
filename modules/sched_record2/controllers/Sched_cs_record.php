<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->load->model('sched_cs_record_model');
		$this->load->model('sched_record_model');
		$this->admin->_check_login();
	}

     public function get_cs_record( $settings , $type , $sched_id , $check_sched , $teacher_id){
		$sched_id=$check_sched[0]['schedid'];
		$data['type_d'] =$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$data['uri'] = $sched_id;
		$data['teacher_id'] = $this->session->userdata('id');
        $data['cs'] = $this->sched_cs_record_model->get_cs($sched_id,$data['teacher_id'],$type);
		$mydept= $this->session->userdata('mydept');
		$data['table'] = $this->cs_table( $settings ,$check_sched, $sched_id,$data['type_d'],$data['cs'] ,$data['teacher_id'],$mydept);
        return $data;
     }

     public function cs_templates( $sched_id,$type_d,$check_sched,$mydept){
     	$cs_tpl = $this->sched_cs_record_model->get_cs_template('',$mydept,$check_sched);
     	$tpl_options='<option>Select Template...</options>';
     	for($x=0;$x<count($cs_tpl);$x++){
     		$tpl_options .='<option id="'.$cs_tpl[$x]->id.'" >'.$cs_tpl[$x]->description.'</options>';
     	}
     	return $tpl_options;

     }

	 public function cs_table( $settings , $check_sched, $sched_id,$type_d,$cs_list , $teacher_id,$mydept){

	 	$cs_tpl=$this->cs_templates($sched_id,$type_d,$check_sched,$mydept);

		  $table = "
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            CLASS STANDING $type_d[7] <span id='typeWord'>".strtoupper($type_d[0])."</span>
							 <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse'' data-target='#settings'></span>
                        </div>";

                        $table .= "<div class=\"panel-body\">". $settings;
						$table .= "<div class='form-group col-md-1'><button  onclick='$(this).changeModalCs(\"$sched_id\",\"$teacher_id\",\"$type_d[6]\");' type='button' class='form-control btn btn-warning btn-xs'   > ADD NEW</button> </div> ";
						if($cs_list['cs_num']==0 && count($cs_tpl)>0){
                        	$table .= " <div class='form-group col-md-3'><label for='cs_tpl'>CS TEMPLATES :</label><select id='cs_tpl' class='form-control' >".($cs_tpl)."</select></div>";
                        	$table .= " <div class='form-group col-md-1'><button  onclick='$(this).createCStemplate(\"$sched_id\",\"$teacher_id\",\"$type_d[6]\",\"$mydept\");' type='button' class='btn btn-warning btn-xs'   > CREATE CS TEMPLATE</button> </div> ";
						}

                        $table .= "<table class='table table-bordered' id=\"dataTables-example\">";
                        $table .= "<thead>
										<tr class=\"text-center\"><th class=\"text-center\">NO.</th><th class=\"text-center\">Decription</th><th class=\"text-center\">Items</th><th class=\"text-center\">Total</th><th class=\"text-center\">Percent%</th><th class=\"text-center\" >Date Created</th><th class=\"text-center\">Update Delete</th></tr>
								   </thead>
								   <tbody>".$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id)['tr']."</tbody>
								</table>
								".$this->total_table($this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id)['total_cs'],$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id)['total_cs_prcnt'],$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id)['count'])."
							</div>
							<input type='hidden' id='_this_type' value='".$type_d[6]."' />
				";
				$data["table"] = $table;
				$data['total_cs']=$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id)['total_cs'];
				$data['total_cs_prcnt']=$this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id)['total_cs_prcnt'];
					return $data;
	 }

	 public function cs_tbody($sched_id,$type_d,$cs_list, $teacher_id){
		$tbody['tr'] = '';
		$count=1;
		$total_cs=0;
		$total_cs_prcnt=0;
		for($x=0;$x<($cs_list['cs_num']);$x++){
			$cs_items=$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_list['cs_query'][$x]->id,$type_d[6]);
			$cs_items_sum=($this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_list['cs_query'][$x]->id,$type_d[6]))?$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_list['cs_query'][$x]->id,$type_d[6],'SUM(items) as sum_items')['cs_i_query'][0]->sum_items:0;
			$cs_items_sumx = ($cs_items['cs_i_num']==0)?0:$cs_items_sum;
			$tbody['tr'] .="
				  <tr>
				  <td>".$count."</td>
				  <td>".$cs_list['cs_query'][$x]->description."</td>
				  <td>".$cs_items['cs_i_num']."</td>
				  <td>".$cs_items_sumx."</td>
				  <td>".$cs_list['cs_query'][$x]->percent."</td>
				  <td>".date('M d , Y  ',strtotime($cs_list['cs_query'][$x]->date_created)).'('.date('h:i:s A',strtotime($cs_list['cs_query'][$x]->date_created)).")</td>
				  <td>
				  		<a class='btn btn-info btn-xs' href='#' onclick='$(this).viewCSitems(\"".$teacher_id."\",\"".$cs_list['cs_query'][$x]->id."\",\"".$sched_id."\",\"".$type_d[6]."\",\"".$cs_list['cs_query'][$x]->description."\");'><i class='glyphicon glyphicon-list-alt'></i> view</a>
				  		<a class='btn btn-success btn-xs' href='#' onclick='$(this).editCS(\"".$teacher_id."\",\"".$cs_list['cs_query'][$x]->id."\",\"".$cs_list['cs_query'][$x]->description."\",\"".$cs_list['cs_query'][$x]->percent."\",\"".$sched_id."\",\"".$type_d[6]."\");'><i class='glyphicon glyphicon-edit'></i> edit</a>
                        <a class='btn btn-danger btn-xs' href='#' onclick='$(this).deleteCS(\"".$cs_list['cs_query'][$x]->id."\",\"".$sched_id."\",\"".$type_d[6]."\");'><i class='glyphicon glyphicon-remove'></i> delete</a>

				  </td>
				  </tr>
				  ";
				  $total_cs=$total_cs+$cs_items_sumx;
				  $total_cs_prcnt=$total_cs_prcnt+$cs_list['cs_query'][$x]->percent;
				  $count++;
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
		$prcnt = $this->input->post('prcnt', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$item = $this->input->post('item', TRUE);
		$data = array(
						'schedid' => $sched_id,
						'teacher_id' => $teacher_id,
						'description' => $cs_desc,
						'items' => $item,
						'percent' => $prcnt,
						'type' => $type,
						'date_created' => mdate('%Y-%m-%d %H:%i %a')
					 );
		$trans_status=$this->sched_cs_record_model->create_sched_cs( $data );
			return $trans_status;
	}


	public function delete_sched_cs(){
		$schedid = $this->input->post('schedid', TRUE);
		$cs_id = $this->input->post('cs_id', TRUE);
		$teacher_id = $this->session->userdata('id');
		$trans_status=$this->sched_cs_record_model->delete_sched_cs( $schedid,$teacher_id,$cs_id );
			return $trans_status;
	}

	public function update_sched_cs(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$cs_items = $this->input->post('cs_items', TRUE);
		$cs_prcnt = $this->input->post('cs_prcnt', TRUE);
		$teacher_id = $this->input->post('teacher_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$type = $this->input->post('type', TRUE);
		if($this->session->userdata('id')==$teacher_id){
			$trans_status=$this->sched_cs_record_model->update_sched_cs( $sched_id,$teacher_id,$type,$cs_id,$cs_desc,$cs_items,$cs_prcnt );
			return $trans_status;
		}else{
			echo "Update Failed. Please Try again later.";
		}


	}

	public function update_student_cs(){
		$studentid = $this->input->post('studentid', TRUE);
		$cs_id = $this->input->post('cs_id', TRUE);
		$cs_i_id = $this->input->post('cs_i_id', TRUE);
		$cs_items = $this->input->post('cs_val', TRUE);
		$cs_items = ($cs_items=='NULL')?NULL:$cs_items;
		$sched_id = $this->input->post('schedid', TRUE);
		$type = $this->input->post('type', TRUE);
		$teacher_id = $this->session->userdata('id');

		$data['check_sched'] = $this->sched_record->get_check_sched($teacher_id,$sched_id);
		$table_e_f=( $data['check_sched']['labunits']>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		if($data['check_sched']['lecunits']==0 && $data['check_sched']['labunits']>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}
		$final = $this->input->post('final', TRUE);
		$type_d=$this->sched_record_model->type($type,$data['check_sched'][0]['acadyear']);


		if($this->sched_cs_record_model->get_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type )){
			$trans_status=$this->sched_cs_record_model->update_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type );
			echo $trans_status;
		}else{
			if($this->sched_cs_record_model->insert_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type ))
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
		$data['items']=$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_id,$type);

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
		$this->load->view('sched_record/cs_items',$data);
	}


	public function add_cs_items(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$teacher_id = $this->input->post('teacher_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$title = $this->input->post('title', TRUE);
		$items = $this->input->post('items', TRUE);
		$cs_items=$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_id,$type,'SUM(items) as sum_items');
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
			$this->sched_cs_record_model->add_cs_items($data);
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

		echo $this->sched_cs_record_model->edit_cs_item($sched_id,$type,$cs_id,$cs_i_id,$title,$items);
	}

	public function delete_cs_items(){
		$cs_id = $this->input->post('cs_id', TRUE);
		$sched_id = $this->input->post('schedid', TRUE);
		$type = $this->input->post('type', TRUE);

		$cs_i_id =  $this->input->post('cs_i_id', TRUE);

		echo $this->sched_cs_record_model->delete_cs_item($sched_id,$cs_id,$cs_i_id);
	}
	public function show_selected_template(){
		$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_tpl_id = $this->input->post('cs_tpl_id', TRUE);
		$check_sched = $this->sched_record->get_check_sched($teacher_id,$sched_id);
		$cs_tpl = $this->sched_cs_record_model->get_cs_template($cs_tpl_id,'',$check_sched);
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
		$check_sched = $this->sched_record->get_check_sched($teacher_id,$sched_id);
		$cs_tpl = $this->sched_cs_record_model->get_cs_template($cs_tpl_id,'',$check_sched);
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
						'date_created' => mdate('%Y-%m-%d %H:%i %a')
					 );
				$trans_status=$this->sched_cs_record_model->create_sched_cs( $data );
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
						'date_created' => mdate('%Y-%m-%d %H:%i %a')
					 );
				$trans_status=$this->sched_cs_record_model->create_sched_cs( $data );
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
		$check_sched = $this->sched_record->get_check_sched($teacher_id,$sched_id);
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
			$trans_status=$this->sched_cs_record_model->create_cs_template( $data );
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
			$trans_status=$this->sched_cs_record_model->create_cs_template( $data );
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
			// $trans_status=$this->sched_cs_record_model->create_sched_cs( $data );
			// return $trans_status;

		}

	}

}

