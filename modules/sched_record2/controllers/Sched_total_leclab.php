<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_total_leclab extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->module('sched_record');
		$this->admin->_check_login();
	}

     public function get_total_leclab($settings,$lecunits, $labunits , $type , $sched_id , $check_sched , $teacher_id, $pdf=FALSE ){
		$this->load->model('sched_record_model');
		$this->load->model('student/student_model');
		$sched_id=$sched_id;
		$data['type_d'] =$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$data['uri'] = $sched_id;
		$data['teacher_id'] = $this->session->userdata('id');
		$data['student_list']=($this->sched_record_model->get_student_list($sched_id,'s.studentid'));
		$data['sched_info']=$this->sched_record_model->get_subject_exam($lecunits,$labunits , '' ,$sched_id , $type , 'percentage');
		$data['table'] = $this->leclab_table($settings,$labunits , $sched_id,$data['type_d'] ,$data['teacher_id'] , $data['student_list'] , $data['sched_info'] ,$pdf);
        return $data;
     }

	 public function leclab_table($settings, $labunits , $sched_id , $type_d , $teacher_id , $student_list , $sched_info ,$pdf ){
		$p['lec']=0;
		$p['lab']=0;

		 if($sched_info['exam_query'] && $sched_info['exam_query'][0]->percentage){
				$percentage=json_decode($sched_info['exam_query'][0]->percentage);
				$p['lec']=$percentage->{'lec'};
				$p['lab']=$percentage->{'lab'};
		}
		  $table = "<div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                           <span id='typeWord'>".strtoupper($type_d[0])." GRADES TOTAL </span>
						   <span class='pull-right glyphicon glyphicon-cog cursor-pointer' data-toggle='collapse' data-target='#settings'></span>
                        </div>";
		$table .= "<div class=\"panel-body\">
					".$settings."
					";
        $table .= "		<table class='table table-condensed table-hover table-striped table-bordered myGradesTable dataTable no-footer' id=\"dataTables-example-p\">";
		$table .= "			<thead>
										<tr class=\"text-center\">
											<th class=\"text-center\">NO.</th>
											<th class=\"text-center\">ID</th>
											<th class=\"text-center\">NAME</th>
											<th class=\"text-center\" >LECTURE </th>
											<th class=\"text-center\">".$p['lec']."%</th>
											<th class=\"text-center\">LABORATORY</th>
											<th class=\"text-center\">".$p['lab']."%</th>
											<th class=\"text-center\">FINAL (100%)</th>
										</tr>
							</thead>
							<tbody>".$this->leclab_tbody( $labunits , $sched_id , $type_d , $teacher_id , $student_list  , $p ,$pdf )['tr']."</tbody>
						</table>
				  </div>
				";
				//
					return $table;
	 }

	 public function leclab_tbody( $labunits , $sched_id , $type_d , $teacher_id , $student_list  , $p ,$pdf ){
		$tbody['tr'] = '';
		$count=1;
		$table_e_f=$labunits>0?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';
		$get=  $type_d[5].','. $type_d[9];
		for($x=0;$x<count($student_list);$x++){
			$student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
			$leclab_g=$this->sched_record_model->get_student_finalgrade( $student_list[$x]->studentid , $sched_id , "*" , $table_e_f);
			if($leclab_g){
					$scorelec[$x] =($leclab_g[0]->{$type_d[5]});
					$scorelab[$x] =($leclab_g[0]->{$type_d[9]});
					$lec_p = (($leclab_g[0]->{$type_d[5]})*($p['lec']))/100;
					$lab_p = (($leclab_g[0]->{$type_d[9]})*($p['lab']))/100;
			}else{
					$scorelec[$x] ='';
					$scorelab[$x] ='';
					$lec_p = 0;
					$lab_p = 0;
			}

			$leclab_f = ($lec_p) + ($lab_p) ;
				if($leclab_f>=75){
					$class='passed';
					$def_rem = '<option value="P" >Passed</option>';
				}else{
					$class='failed';
					$def_rem = '<option value="F" >Failed</option>';
				}

				$remarks = '<select class="'.$class.'" >
						'.$def_rem.'
						<option value="P" >Passed</option>
						<option value="F" >Failed</option>
						<option value="NF" >No Final Exam</option>
						<option value="DRP" >Drop</option>
						<option value="UD" >Unofficially Drop</option>
						</select>';

						if( $pdf){
								$remarks = $student_remarks_r;
							}

			$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$tbody['tr'] .="
				  			<tr>
							  <td>$count</td>
							  <td class='student_lfm' >".$student_list[$x]->studentid."</td>
							  <td class='student_lfm' >".$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme."</td>
							  <td>".round($scorelec[$x],2)."</td>
							  <td>".round($lec_p,2)."%</td>
							  <td>".round($scorelab[$x],2)."</td>
							  <td>".round($lab_p,2)."%</td>
							  <td><span class='".$class."'>".round( $leclab_f,2 )."</span></td>
							</tr>
							";
				  $count++;
		}
		return $tbody;
	 }

	 public function set_percentage(){
		$this->load->model('sched_record_model');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('schedid', TRUE);
		$data['lab'] = $this->input->post('lab', TRUE);
		$data['lec'] = $this->input->post('lec', TRUE);
		$data['labunits'] = $this->input->post('labunits', TRUE);
		$data['lecunits'] = $this->input->post('lecunits', TRUE);
		$leclab=json_encode(array('lec'=>$data['lec'],'lab'=>$data['lab']));
		if($this->sched_record_model->get_subject_exam($data['lecunits'],$data['labunits'] , '',$data['sched_id'] , $data['type'] ,'schedid')['exam_num']>0){
			echo $this->sched_record_model->update_percentage($data['sched_id'],$leclab);
		}else{	echo $this->sched_record_model->insert_percentage($data['sched_id'],$leclab);	}
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

