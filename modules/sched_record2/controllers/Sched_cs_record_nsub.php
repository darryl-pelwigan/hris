<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_cs_record_nsub extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record2');
		$this->load->model('sched_cs_record_model_nsub');
		$this->load->model('sched_record_model');
		$this->load->helper('date');
		$this->admin->_check_login();
	}

     public function get_cs_record( $settings , $type , $sched_id , $check_sched , $teacher_id){
		$sched_id=$check_sched[0]['schedid'];
		$data['type_d'] =$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$data['uri'] = $sched_id;
		$data['teacher_id'] = $this->session->userdata('id');
        $data['cs'] = $this->sched_cs_record_model_nsub->get_cs($sched_id,$data['teacher_id'],$type);
		$mydept= $this->session->userdata('mydept');
		$data['table'] = $this->cs_table( $settings ,$check_sched, $sched_id,$data['type_d'],$data['cs'] ,$data['teacher_id'],$mydept);
        return $data;
     }

	 public function cs_table( $settings , $check_sched, $sched_id,$type_d,$cs_list , $teacher_id,$mydept){
	 	$teacher_id = $this->session->userdata('id');
	 	$table = '<input type="hidden" id="_this_type" value="'.$type_d[6].'">';
		$table .= "

                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                            CLASS STANDING $type_d[7] <span id='typeWord'>".strtoupper($type_d[0])."</span>
							 <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
                        </div>";

                        $table .= "<div class=\"panel-body\">". $settings;
                        $sum_prcnt=0;
						 if($cs_list['cs_num']!=0 ){
						 	$sum_prcnt = $this->sched_cs_record_model_nsub->get_cs($sched_id,$teacher_id,$type_d[6],'SUM(percent) as percent')['cs_query'][0]->percent;
						 	$sum_prcnt=($sum_prcnt*.1)/0.5;
   						 }
   						 if($sum_prcnt<20){
	   						$gt_o = '';
	                        for($x=1;$x<=(20-$sum_prcnt);$x++){
	                            $gt=$x*5;
	                            $gt_o .="<option value='". $gt."'>". $gt ."</option> ";
	                        }
	                        $table .= ' <form action="#" class="form-horizontal" id="createCsCats" target="_blank">

											 <div class="form-group">
					                          <label class="control-label col-md-3">Category</label>
					                          <div class="col-md-4">
					                                  <input type="text" class="form-control" id="cs_createcs_category" placeholder="Category" value="" />
					                          </div>
											  <div class="col-md-1">
													 <select class="form-control" id="cs_createcs_category_percent" >
					                                  '.$gt_o.'
					                                 </select>
					                          </div>
					                                  <button type="button" class="btn btn-success btn-xs" id="tpl_more_cats"><i class="fa fa-plus"></i></button>
					                           </div>
	                        			 </form>';
   						 }

                        $table .= $this->cs_tbody($sched_id,$type_d,$cs_list, $teacher_id,$sum_prcnt);
				$data["table"] = $table;
				return $data;
	 }

	 public function cs_tbody($sched_id,$type_d,$cs_list, $teacher_id,$sum_prcnt){
	 	$cats='<div class="panel-group" id="accordion">';
	 	for($x=0;$x<$cs_list['cs_num'];$x++){
	 		$subs_c='';
   				$collapse = '';
				if($x==0){
					$collapse = 'in';
				}
				$table_body = "<table id=\"sub_items_".$cs_list['cs_query'][$x]->id."_".$x."\"  class='table table-bordered table-condensed' >";
		 		$table_body .= "<thead>
									<tr class=\"text-center\"><th class=\"text-center\">NO.</th><th class=\"text-center\">Decription</th><th class=\"text-center\">Items</th><th class=\"text-center\" >Date</th><th class=\"text-center\">ADD/DELETE</th></tr>
								</thead>
								<tbody>".$this->cs_category($sched_id,$type_d,$teacher_id,$cs_list['cs_query'][$x]->id,$x)."</tbody>
								</table>";


	 		$cats .='<div class="panel panel-primary" >
				  <div class="panel-heading">
					<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#collapse'.$x.'">
				  		<strong class="text-default" >'.$cs_list['cs_query'][$x]->description.' '.$cs_list['cs_query'][$x]->percent.'%</strong>
					</a>

					<button type="button" class="dspl-hide col-md-offset-1 btn btn-info btn-xs "  onclick="$(this).editCSCats('.$cs_list['cs_query'][$x]->id.',\''.$cs_list['cs_query'][$x]->description.'\',\''.$cs_list['cs_query'][$x]->percent.'\',\''.$sum_prcnt.'\');" ><i class="glyphicon glyphicon-pencil"></i></button>
					<button type="button" class="dspl-hide btn btn-danger btn-xs" onclick="$(this).deleteCSCats('.$cs_list['cs_query'][$x]->id.');" ><i class="glyphicon glyphicon-trash"></i></button>

				  </div>
				    <div id="collapse'.$x.'" class="panel-collapse collapse '.$collapse.'">
					  <div class="panel-body">
					    '.$subs_c.'
					    '.$table_body.'
					  </div>
				   </div>
				</div>';
	 	}
	 	$cats .='</div>';


	 	return ($cats);
	 }

	 public function cs_category($sched_id,$type_d,$teacher_id,$cats_id,$t){
	 	$cs_sub_items = $this->sched_cs_record_model_nsub->get_cs_items($sched_id,$teacher_id,$cats_id);
	 	$tr ='';

	 	if($cs_sub_items['cs_num']>0){
			$tr_adddel ='';
			$count=0;
			for($x=0;$x<($cs_sub_items['cs_num']);$x++){
				$cs_q = $cs_sub_items['cs_query'][$x];
				if($x==0){
					$tr_adddel = ' <button type="button" class="col-md-1 col-md-offset-1 btn btn-success btn-xs" onclick="$(this).createCsItems(\''.$x.'\',\''.$t.'\',\''.$cats_id.'\');" ><i class="fa fa-plus"></i></button>';
				}else{
					$tr_adddel = ' ';
				}
				$tr .='
					  <tr id="tr_'.$x.'">
					  <td>'.$count++.'</td>
					  <td><div class="input-group col-sm-10 col-sm-offset-1" ><input type="hidden" class="form-control " id="cs_desc_'.$cats_id.'_'.$x.'" value="'.$cs_q->title.'"   /><span id="cs_desc_i_'.$cats_id.'_'.$x.'" > '.$cs_q->title.'</span></div></td>
					  <td><div class="input-group col-sm-7 col-sm-offset-1"><input type="hidden" min="5" max="1000" class="form-control" id="cs_items_'.$cats_id.'_'.$x.'" value="'.$cs_q->items.'" /><span id="cs_items_i_'.$cats_id.'_'.$x.'" > '.$cs_q->items.'</span></div></td>
					  <td>
							<div class=" dspl-hide input-group date datetimepicker1 col-sm-7 col-sm-offset-1" onclick="$(this).datePickershow('.$x.');" >
			                    <input type="text" class="form-control" id="cs_date_'.$cats_id.'_'.$x.'" onclick="$(this).datePickershow('.$x.');"  value="'.$cs_q->cs_date.'" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			                <span id="cs_date_i_'.$cats_id.'_'.$x.'" > '.$cs_q->cs_date.'</span>

					  </td>
					  <td style="width:255px">
						  <div class="input-group col-sm-12 " >
							  	<button type="button" class="col-md-1 col-md-offset-1 btn btn-info btn-xs "  onclick="$(this).editCSitems(\''.$x.'\','.$cs_q->id.',\''.$cats_id.'\');" ><i class="glyphicon glyphicon-pencil"></i></button>
							  	<button type="button" class="col-md-1 col-md-offset-1 btn btn-danger btn-xs" onclick="$(this).deleteCSitems(\''.$x.'\',\''.$cs_q->id.'\',\''.$cats_id.'\');" ><i class="glyphicon glyphicon-trash"></i></button>
							  	'.$tr_adddel.'
						  </div>
					  </td>
					  </tr>
					  ';

			}

		}else{
			$tr .='
					  <tr class="cs_adding_wc">
						  <td>1
							<input type="hidden" id="cats_id_0" value="'.$cats_id.'" />
						  </td>
						  <td><div class="input-group col-sm-10 col-sm-offset-1" ><input type="text" class="form-control" id="cs_desc_'.$cats_id.'_0"  /></div></td>
						  <td><div class="input-group col-sm-7 col-sm-offset-1"><input type="number" min="5" max="1000" class="form-control" id="cs_items_'.$cats_id.'_0"></div></td>
						  <td>
								<div class="input-group date datetimepicker1 col-sm-7 col-sm-offset-3" onclick="$(this).datePickershow(0);" >
				                    <input type="text" class="form-control" id="cs_date_'.$cats_id.'_0" onclick="$(this).datePickershow(0);" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
						  </td>
						  <td>
						  		<button type="button" class="btn btn-success btn-xs" onclick="$(this).createCsItems(0,\''.$t.'\',\''.$cats_id.'\');" ><i class="fa fa-plus"></i></button>
						  		<button type="button" class="btn btn-primary btn-xs "  onclick="$(this).saveCSitems(0,\''.$cats_id.'\');" ><i class="glyphicon glyphicon-floppy-disk"></i></button>
						  </td>
					  </tr>

					  ';

		}
		return $tr;
	 }

	 public function cs_create_cats(){
	 	$this->load->helper('date');
		$teacher_id = $this->session->userdata('id');
		$type = $this->input->post('typex', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$cats_desc = $this->input->post('cats_desc', TRUE);
		$cats_percent = $this->input->post('cats_percent', TRUE);
		$data = array(
						'sched_id' => $sched_id,
						'teacher_id' => $teacher_id,
						'description' => $cats_desc,
						'type' => $type,
						'percent' => $cats_percent,
						'date_created' => mdate('%Y-%m-%d  %H:%i %a')

					);
		$this->sched_cs_record_model_nsub->create_sched_cs_cats($data);
	 }

	 public function create_cs_items(){
	 	$teacher_id = $this->session->userdata('id');
		$cats_id = $this->input->post('cats_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$cs_items = $this->input->post('cs_items', TRUE);
		$cs_date = $this->input->post('cs_date', TRUE);
		$data = array(
						'teacher_id' => $teacher_id,
						'sched_id' => $sched_id,
						'cs_nsub_id' => $cats_id,
						'title' => $cs_desc,
						'items' => $cs_items,
						'cs_date' => mdate('%Y-%m-%d',strtotime($cs_date)),
						'date_created' => mdate('%Y-%m-%d  %H:%i %a')
					);
	 	$this->sched_cs_record_model_nsub->create_cs_items($data);
	 }

	  public function cs_update_cats(){
	 	$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$cats_id = $this->input->post('cats_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$cs_percent = $this->input->post('cs_percent', TRUE);
		$this->sched_cs_record_model_nsub->update_cs_cats($teacher_id,$cats_id,$sched_id,$cs_desc,$cs_percent);

	 }

	 public function cs_delete_cats(){
	 	$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$cats_id = $this->input->post('cats_id', TRUE);
		echo $this->sched_cs_record_model_nsub->delete_cats($teacher_id,$cats_id,$sched_id);
	 }

	 public function cs_delete_cats_sub(){
	 	$teacher_id = $this->session->userdata('id');
		$sched_id = $this->input->post('sched_id', TRUE);
		$cats_id = $this->input->post('cats_id', TRUE);
		$sub_id = $this->input->post('sub_id', TRUE);
		$type = $this->input->post('typex', TRUE);
		echo $this->sched_cs_record_model_nsub->delete_items($teacher_id,$cats_id,$sched_id,$sub_id);
	 }

	 public function cs_update_items(){
	 	$teacher_id = $this->session->userdata('id');
		$cats_id = $this->input->post('cats_id', TRUE);
		$sub_id = $this->input->post('sub_id', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$cs_desc = $this->input->post('cs_desc', TRUE);
		$cs_items = $this->input->post('cs_items', TRUE);
		$cs_date = $this->input->post('cs_date', TRUE);
		echo $this->sched_cs_record_model_nsub->update_items($teacher_id,$cats_id,$sub_id,$cs_desc,$cs_items,$cs_date,$sched_id);
	 }


	 public function update_student_cs(){
		$studentid = $this->input->post('studentid', TRUE);
		$sched_id = $this->input->post('schedid', TRUE);
		$type = $this->input->post('type', TRUE);


		$cs_items = $this->input->post('cs_val', TRUE);
		$cs_id = $this->input->post('cs_id', TRUE);
		$cs_i_id = $this->input->post('cs_i_id', TRUE);
		$cs_items = ($cs_items=='NULL')?NULL:$cs_items;

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

		$type_d=$this->sched_record_model->type($type,$data['check_sched'][0]['acadyear']);

		if($this->sched_cs_record_model_nsub->get_student_cs( $studentid,$cs_id,$cs_i_id,$sched_id,$type )){
			$trans_status=$this->sched_cs_record_model_nsub->update_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type );
			echo $trans_status;
		}else{
			if($this->sched_cs_record_model_nsub->insert_student_cs( $studentid,$cs_id,$cs_i_id,$cs_items,$sched_id,$type ))
				echo TRUE;
			else
				echo FALSE;
		}



	}



}

