<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_record2 extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	 function __construct()
    {
        parent::__construct();
		$this->load->model('sched_record_model');
		$this->load->model('teachersched/sched_model');
		$this->load->model('admin/user_model');
		$this->load->module('admin/admin');
		$this->load->module('template/template');
		$this->load->model('template/template_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->load->model('sched_cs_record_model');
		$this->load->model('grade_submission_model');

		$this->load->library('encryption');
		$this->encryption->initialize(
									        array(
									                'cipher' => 'aes-256',
									                'mode' => 'OFB',
									                'key' => base64_encode('0-124356879-0'),
									        )
									);


		$this->admin->_check_login();
    }





	public function get_sched_students()
	{
		$sched_id = $this->input->post('sched_id', TRUE);
		$set_sem = $this->input->post('set_sem', TRUE);
		$set_sy = $this->input->post('set_sy', TRUE);

		$sched_id = $this->encryption->decrypt($sched_id) ;
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['set_sem']=	$this->input->post('set_sem', TRUE);
		$data['set_sy']=	$this->input->post('set_sy', TRUE);
    	if(!$sched_id){
    		redirect('TeacherScheduleList');
    	}

		$data['teacher_id'] = $this->session->userdata('id');
		$data['nav']=$this->admin->_nav();
		$data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
		$data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
		$data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
		$data['check_sched']['teacher_adviser']= $data['subject_info3'];
		$comp_typeP = $this->sched_cs_record_model->get_tchr_cs_computation($sched_id,$data['teacher_id'],'p');
		$comp_typeLP = $this->sched_cs_record_model->get_tchr_cs_computation($sched_id,$data['teacher_id'],'lp');
		if($comp_typeP){
			 $comp_typeX = ($comp_typeP[0]->comp_type);
		}elseif($comp_typeLP){
			$comp_typeX = ($comp_typeLP[0]->comp_type) ;
		}else{
			$comp_typeX = '';
		}

		if(in_array($data['teacher_id'],array_unique($data['check_sched']['teacherid']))){
			$data['sched_id']=$sched_id;
			$data['disablelec']='';
			$data['disablellab']='';

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
			$data['student_list'] = $student_list;
				if($data['check_sched']['count']>1){
					$lec_teacher = $this->sched_record_model->check_leclab_teacher($data['teacher_id'],$sched_id,'Lecture');
					// $lab_teacher = $this->sched_record_model->check_leclab_teacher($data['teacher_id'],$sched_id,'Laboratory');

					$sub = $this->sched_record_model->check_lab_ifexist($sched_id,$set_sem, $set_sy);

    				if($sub){
    					$lab_teacher = $this->sched_record_model->check_leclab_teacher($data['teacher_id'] ,$sub[0]->schedid,'Laboratory');
    				}else{
    					$lab_teacher = $this->sched_record_model->check_leclab_teacher($data['teacher_id'],$sched_id,'Laboratory');
    				}
					if($lec_teacher && $lab_teacher){
						$data['disablellab']='';
						$data['disablelec']='';
					}elseif(!$lec_teacher && $lab_teacher){
						$data['disablelec']='$(this).viewOnly();';
						$data['disablellab']='';
					}elseif($lec_teacher && !$lab_teacher){
						$data['disablelec']='';
						$data['disablellab']='$(this).viewOnly();';
					}
				}
			if($comp_typeX=='fgradeonly'){
				$data['view_content']='sched_record2/sched_record_FG';
				$data['get_plugins_js']='sched_record2/plugins_js_sched_record_FG';
				$data['get_plugins_css']='sched_record2/plugins_css_sched_record_FG';
			}elseif($comp_typeX=='gradeonlyleclab'){
				$data['view_content']='sched_record2/sched_record_gradeleclab';
				$data['get_plugins_js']='sched_record2/plugins_js_sched_record_gradeleclab';
				$data['get_plugins_css']='sched_record2/plugins_css_sched_record_FG';
			}else{
				$data['view_content']='sched_record2/sched_record';
				$data['get_plugins_js']='sched_record2/plugins_js_sched_record';
				$data['get_plugins_css']='sched_record2/plugins_css_sched_record_w';
			}

			$this->load->view('template/init_view_windowed',$data);
		}else{
			redirect(ROOT_URL.'modules/TeacherScheduleList');
		}


	}

	public function get_student_grades(){
		$data['set_sem']=	$this->input->post('sem', TRUE);
		$data['set_sy']=	$this->input->post('sy', TRUE);

		$data['labunits'] = $this->input->post('labunits', TRUE);
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'student_grades';
		$data['subject_info3'] =$this->sched_record_model->get_sched_adviser($data['sched_id'],'teacher_id');
		$data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
		$data['check_sched']['teacher_adviser']= $data['subject_info3'];
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);

		if($comp_type){
			$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);

			$data['comp_type']="sched_record_list_".$comp_type[0]->comp_type;
			$this->load->module('sched_record2/'.$data['comp_type']);
			$data['grades']=$this->{$data['comp_type']}->table( $settings , $data['labunits'] ,  $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id'] );
		}else{
			$data['grades']['table']='<script>$.fn.checkCScomputation("'.$data['type'].'","'.$data['sched_id'].'")</script>';
		}
		if($comp_type[0]){
				$data['get_plugins_js']='sched_record2/plugins_js_sched_grades_'.$comp_type[0]->comp_type;
		}else{
				$data['get_plugins_js']='sched_record2/plugins_js_sched_grades';
		}

		$this->load->view('sched_record2/subgect_gradeslec',$data);
	}



	public function get_sched_cs(){
		$data['set_sem']=	$this->input->post('sem', TRUE);
		$data['set_sy']=	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_cs_record');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'cs';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['cs']=$this->sched_cs_record->get_cs_record( $settings , $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']  );
		$data['get_plugins_css']='sched_record2/plugins_js_sched_cs';
		$data['get_plugins_js']='sched_record2/plugins_js_sched_cs';
		$this->load->view('sched_record2/subgect_cs_record',$data);
	}

	public function get_sched_cs_wc(){
		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_cs_record_wc');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'cs';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['cs']=$this->sched_cs_record_wc->get_cs_record( $settings , $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']  );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_cs_wc';
		$this->load->view('sched_record2/subgect_cs_record_wc',$data);
	}

	public function get_sched_cs_contg(){
		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_cs_record_contg');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'cs';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['cs']=$this->sched_cs_record_contg->get_cs_record( $settings , $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']  );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_cs_contg';
		$this->load->view('sched_record2/subgect_cs_record_contg',$data);
	}

	public function get_sched_cs_nsub(){
		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_cs_record_nsub');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'cs';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['cs']=$this->sched_cs_record_nsub->get_cs_record( $settings , $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']  );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_cs_nsub';
		$this->load->view('sched_record2/subgect_cs_record_nsub',$data);
	}

	public function get_sched_cs_wsub(){
		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_cs_record_wsub');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'cs';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['cs']=$this->sched_cs_record_wsub->get_cs_record( $settings , $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']  );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_cs_wsub';
		$this->load->view('sched_record2/subgect_cs_record_wsub',$data);
	}



	public function get_sched_cs_etools(){
		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_cs_record_etools');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'cs';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['cs']=$this->sched_cs_record_etools->get_cs_record( $settings , $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']  );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_cs_etools';
		$this->load->view('sched_record2/subgect_cs_record_etools',$data);
	}

	public function update_exam_score(){
		$teacher_id = $this->session->userdata('id');
		$items_n = $this->input->post('items_n', TRUE);
		$lecunits = $this->input->post('lecunits', TRUE);
		$labunits = $this->input->post('labunits', TRUE);
		$type = $this->input->post('type', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$sched_info=$this->sched_record_model->get_sched_info( $teacher_id , $sched_id);
		$check_sched = $this->get_check_sched($teacher_id,$sched_id);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);

		$transmutation=$this->transmutation->create_json($items_n,55);
			if($this->sched_record_model->get_sched_escore($lecunits, $labunits , $teacher_id , $sched_id , $type_d , $items_n ,'id'  )){
				$this->sched_record_model->update_subject_exam($lecunits, $labunits , $teacher_id , $sched_id , $type_d , $items_n  );
			}else{
				$this->sched_record_model->insert_subject_exam($lecunits, $labunits , $teacher_id , $sched_id , $type_d , $items_n  );
			}

	}


	public function update_student_exam(){
		$lecunits = $this->input->post('lecunits', TRUE);
		$labunits = $this->input->post('labunits', TRUE);
		$studentid = $this->input->post('studentid', TRUE);
		$exm_id = $this->input->post('exm_id', TRUE);
		$exm_val = $this->input->post('exm_val', TRUE);
		$exm_val = ($exm_val=='NULL')?NULL:$exm_val;
		$sched_id = $this->input->post('schedid', TRUE);
		$type = $this->input->post('type', TRUE);
		$teacher_id = $this->session->userdata('id');
		$data['check_sched'] = $this->get_check_sched($teacher_id,$sched_id);
		if($lecunits>0 && $labunits>0)
            $table_e_f='pcc_gs_student_gradesleclab';
         else
            $table_e_f='pcc_gs_student_gradeslec';
		if($data['check_sched']['lecunits']==0 && $data['check_sched']['labunits']>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
			$table_e_f='pcc_gs_student_gradeslec';
		}
		$final = $this->input->post('final', TRUE);
		$type_d=$this->sched_record_model->type($type,$data['check_sched'][0]['acadyear']);

		if($lecunits>0 && $labunits>0)
            $table_e='pcc_gs_sched_exam_labscore';
         else
            $table_e='pcc_gs_sched_exam_score';

		if($this->sched_record_model->get_student_score($studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e,'id')){
			$trans_status=$this->sched_record_model->update_student_exam( $studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e);
		}else{
			if($this->sched_record_model->insert_student_exam( $studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e)){
				echo 'TRUE';
			}else {echo 'FALSE';}
		}
		if($this->sched_record_model->get_student_finalgrade( $studentid , $sched_id , $type_d[8] , $table_e_f)){
			$trans_status = $this->sched_record_model->update_student_finalgrade( $studentid,$sched_id,$type_d , $table_e_f, $final );
			echo $trans_status.$table_e_f.'test'.$type_d[8].'----'.$final.'--update_student_finalgrade';
		}else{
			if($this->sched_record_model->insert_student_finalgrade( $studentid,$sched_id,$type_d , $table_e_f , $final  )){
				echo 'TRUE';
			}else {echo 'FALSE';}
		}
	}

	/*Check CS Computation Start*/
	public function check_cs_comp(){
		$this->load->module('sched_record2/sched_cs_record');
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_compute']=$this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);
		echo json_encode($data['check_compute']);
	}

	public function set_computation_type(){
		$type = $this->input->post('type', TRUE);
		$sched_id = $this->input->post('sched_id', TRUE);
		$comp_type = $this->input->post('comp_type', TRUE);
		$teacher_id = $this->session->userdata('id');
		$type= (substr($type ,0,1)=='l'?['lp','lm','ltf']:['p','m','tf']);
		for($x = 0 ; $x< 3; $x++){
			$data = array(
						'sched_id' => $sched_id,
						'type' => $type[$x],
						'comp_type'=>$comp_type,
						'teacher_id' => $teacher_id,
						'date_created' => mdate('%Y-%m-%d %H:%i %a')
					 );
		$this->sched_cs_record_model->insert_tchr_cs_computation($data);
		}
		if($comp_type = $this->input->post('comp_type', TRUE) === 'gradeonlyleclab'){
			$leclab = '{"lec":"100","lab":"0"}';
			if($this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,$type ,'schedid')['exam_num']>0){
				echo $this->sched_record_model->update_percentage($sched_id,$leclab);
			}else{	echo $this->sched_record_model->insert_percentage($sched_id,$leclab);	}
		}


	}
	/*Check CS Computation Start*/

	public function leclab(){
		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_total_leclab');
		$data['labunits'] = $this->input->post('labunits', TRUE);
		$data['lecunits'] = $this->input->post('lecunits', TRUE);
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'leclab';
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],$data['type']);

		$settings=$this->_settings($comp_type[0]->comp_type,$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['grades']=$this->sched_total_leclab->get_total_leclab($settings,$data['lecunits'], $data['labunits'] ,  $data['type'] , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id'] );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_grades';
		$this->load->view('sched_record2/subgect_grade_leclab',$data);
	}

	public function get_intern_record( ){
		$data['set_sem']=	$this->input->post('sem', TRUE);
		$data['set_sy']=	$this->input->post('sy', TRUE);

		$this->load->module('sched_record2/sched_intern_record');
		$data['labunits'] = $this->input->post('labunits', TRUE);
		$data['type'] = $this->input->post('type', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['check_sched']['type_view'] = 'intern';


		$settings=$this->_settings('intern',$data,$data['type'],$data['set_sem'],$data['set_sy']);
		$data['grades']=$this->sched_intern_record->get_intern_record(  $settings ,  $data['labunits'] ,  $data['type'] , $data['sched_id'] , $data['check_sched'] , $data['teacher_id'] );
		$data['get_plugins_js']='sched_record2/plugins_js_sched_intern';
		$this->load->view('sched_record2/subgect_grade_leclab',$data);
	}

	public function get_finalgrade( ){
		$this->load->module('sched_record2/sched_finalgrade_record');
		$data['set_sem']=	$this->input->post('sem', TRUE);
		$data['set_sy']=	$this->input->post('sy', TRUE);

		$data['labunits'] = $this->input->post('labunits', TRUE);
		$type = $this->input->post('type', TRUE);
		$sem = $this->input->post('sem', TRUE);
		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['check_sched'] = $this->get_check_sched($data['teacher_id'],$data['sched_id']);
		$data['check_sched']['type_view'] = 'finalgrade';
		if($data['check_sched']['lecunits']==0 && $data['check_sched']['labunits']>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
		}
		$comp_type = $this->sched_cs_record_model->get_tchr_cs_computation($data['sched_id'],$data['teacher_id'],'final');
		$settings=$this->_settings($comp_type[0]->comp_type,$data,$type,$data['set_sem'],$data['set_sy']);
		$data['grades']=$this->sched_finalgrade_record->get_finalgrade($settings ,  $sem, $data['labunits'] ,  $type , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']);
		$data['get_plugins_js']='sched_record2/plugins_js_sched_grades';
		$this->load->view('sched_record2/subgect_grade_leclab',$data);
	}

	public function get_finalgradeleclab( ){

		$data['set_sem'] =	$this->input->post('sem', TRUE);
		$data['set_sy'] =	$this->input->post('sy', TRUE);

		$data['labunits'] = $this->input->post('labunits', TRUE);
		$type = $this->input->post('type', TRUE);

		$data['sched_id'] = $this->input->post('sched_id', TRUE);
		$data['teacher_id'] = $this->session->userdata('id');
		$data['check_sched'] = $this->get_check_sched($data['teacher_id'],$data['sched_id']);
		$data['check_sched']['type_view'] = 'finalgrade';
		if($data['check_sched']['lecunits']==0 && $data['check_sched']['labunits']>0 ){
				if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
				else
					$type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
		}
		$settings=$this->_settings('gradeonlyleclab',$data,$type,$data['set_sem'],$data['set_sy']);
		$this->load->module('sched_record2/sched_finalgrade_add');
		$data['grades'] = $this->sched_finalgrade_add->get_finalgradex( $settings ,  $data['set_sem'] , $data['labunits'] ,  $type , $data['sched_id'] , $data['check_sched'] ,  $data['teacher_id']);
		$data['get_plugins_js']='sched_record2/plugins_js_sched_grades_gradeonlyleclab';
		$this->load->view('sched_record2/subgect_grade_leclab',$data);
	}

	public function get_check_sched($teacher_id,$sched_id){
		$data['subject_info'] =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$data['subject_info2'] =$this->sched_model->get_sched_info($teacher_id,$data['subject_info']['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($data['subject_info2']['sched_query']);
		return $check_sched;
	}

	public function update_student_interngrades(){
		$type = $this->input->post('type', TRUE);
		$sched_id = $this->input->post('schedid', TRUE);
		$grades_val = $this->input->post('grades_val', TRUE);
		$studentid = $this->input->post('studentid', TRUE);
		if($this->sched_record_model->get_intern_grades($sched_id,$studentid,'final')){
				if($this->sched_record_model->update_intern_grades($sched_id,$studentid,$grades_val,'final'))
					echo "TRUE";
				else
					echo "FALSE";
		}else{
				if($this->sched_record_model->insert_intern_grades($sched_id,$studentid,$grades_val,'final'))
					echo "TRUE";
				else
					echo "FALSE";
		}
	}

	public function import_data_csv(){

		$teacher_id = $this->input->post('teacher_id',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$cs_id = $this->input->post('cs_id',TRUE);
		$cs_i_id = $this->input->post('cs_i_id',TRUE);
		$type = $this->input->post('type',TRUE);
		$scores = $this->input->post('scores',TRUE);
		$student_count = $this->input->post('student_count',TRUE);
		$trans_status=0;
		for($x=0;$x<$student_count;$x++){
			$data = array(
						'sched_id' => $sched_id,
						'stud_id' => $scores[$x]['studentid'],
						'cs_id' => $cs_id,
						'cs_i_id' => $cs_i_id,
						'sc_score' => $scores[$x]['score'],
						'date_created' => mdate('%Y-%m-%d %H:%i %a'),
						'date_updated' => mdate('%Y-%m-%d %H:%i %a')
					 );
			if($this->sched_cs_record_model->get_student_cs( $scores[$x]['studentid'],$cs_id,$cs_i_id,$scores[$x]['score'],$sched_id,$type )){
				$trans_status=$this->sched_cs_record_model->update_student_cs( $scores[$x]['studentid'],$cs_id,$cs_i_id,$scores[$x]['score'],$sched_id,$type );
			}else{
				$trans_status=$this->sched_cs_record_model->insert_student_cs( $scores[$x]['studentid'],$cs_id,$cs_i_id,$scores[$x]['score'],$sched_id,$type );
			}
		}
		echo json_encode(array('message'=>'Successfully imported.',$trans_status));
	}

	public function import_data_examcsv(){

		$teacher_id = $this->input->post('teacher_id',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$type = $this->input->post('type',TRUE);
		$scores = $this->input->post('scores',TRUE);
		$student_count = $this->input->post('student_count',TRUE);
		$labunits = $this->input->post('labunits',TRUE);
		$lecunits = $this->input->post('lecunits',TRUE);
		$exm_id = $this->input->post('exam_id',TRUE);
		$check_sched = $this->get_check_sched($teacher_id,$sched_id);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$trans_status=0;
		for($x=0;$x<$student_count;$x++){
			$exm_val = $scores[$x]['score'];
			$studentid = $scores[$x]['studentid'];
			if($lecunits>0 && $labunits>0)
	            $table_e='pcc_gs_sched_exam_labscore';
	        else
	            $table_e='pcc_gs_sched_exam_score';
			if($this->sched_record_model->get_student_score($studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e,'id')){
				$trans_status=$this->sched_record_model->update_student_exam( $studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e);

			}else{
				if($this->sched_record_model->insert_student_exam( $studentid,$exm_id,$exm_val,$sched_id,$type_d , $table_e)){
					echo 1;
				}else {echo 0;}
			}
		}
		echo json_encode(array('message'=>'Successfully imported.',$trans_status));
	}

	public function update_sched_prcntge(){
		$prnctge = $this->input->post('prnctge',TRUE);
		$sched_id = $this->input->post('sched_id',TRUE);
		$coursecode = $this->input->post('coursecode',TRUE);
		$teacher_id = $this->session->userdata('id');
		$get_config = json_decode($this->sched_record_model->get_conf($coursecode,$sched_id,$teacher_id)[0]->configs,true);
		if($prnctge<=85 && $prnctge>=45){
				$get_config['percent']=$prnctge;
				echo $this->sched_record_model->update_conf($coursecode,$sched_id,$teacher_id,json_encode($get_config));
		}else{

		echo json_encode('error');
		}


	}


	public function _settings($comp_type,$datax,$type,$sem=null,$sy=null){
		$type_d=$this->sched_record_model->type($type,$datax['check_sched'][0]['acadyear']);
		$this->load->model('admin_registrar/grades_submission_model');
		$prcnt='';
		$prcntx='';
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=	($sem!=null)	?	$sem :	$data["sem_sy"]["sem_sy"][0]->sem;
		$sy=	($sy!=null)?	$sy : $data["sem_sy"]["sem_sy"][0]->sy;
		if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
			$type2= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
		else
			$type2= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);



		$leclab= 0;
		if($datax['check_sched']['lecunits']>0 && $datax['check_sched']['labunits']>0 && $comp_type!='fgradeonly' && $comp_type!='gradeonly'  && $comp_type!='gradeonlyleclab'){
			$leclab= 1;
			$prcnt='<li><input type="hidden" id="type" value="'.$type.'"/><a href="#" class="btn btn-info" data-toggle="modal" data-target="#percentage_modal">Change Percentage</a></li>';
		}
		if($comp_type==='etools' && $datax['check_sched']['type_view']==='cs' && $comp_type!='fgradeonly' && $comp_type!='gradeonly' && $comp_type!='gradeonlyleclab'){
			$prcntx='<li><a class="btn btn-info" href="'.base_url().'etools/create_etool/'.$datax['sched_id'].'" >CREATE ETOOLS</a></li>';
		}

		$grade_submission = $this->grades_submission_model->get_grade_submission($sy,$sem,$type2);
		$grade_submission_menu = '';
		$pdf_type = $type;
		if($type!= 'f' && $comp_type!='fgradeonly' && $comp_type!='gradeonlyleclab' && $comp_type!='intern'   ){

			if( now() >= human_to_unix($grade_submission[0]->start_date)  && now() <= human_to_unix($grade_submission[0]->end_date)  ){
				$check_grade_submission = $this->grade_submission_model->check_sched_fgrades($datax['sched_id'],$type_d[5]);
				if($check_grade_submission){

					$get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $datax['sched_id'] , $this->session->userdata('id') , $type );
					if($get_gradeupdate_request){

						if($get_gradeupdate_request[0]->status==1){
							$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).requestGradesUpdate(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >Request Grades Updates</button></li>';
						}else {
						$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).submitGrades(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >SUBMIT GRADES</button></li>';
					}
					}elseif ($check_grade_submission) {
						$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).requestGradesUpdate(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >Request Grades Updates</button></li>';
					}else{
						$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).submitGrades(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >SUBMIT GRADES</button></li>';
					}
				}else{
					$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).submitGrades(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >SUBMIT GRADES</button></li>';
				}
			}
			$pdf_type = $type;
		}elseif($comp_type=='intern' || $comp_type == 'fgradeonly' || $comp_type == 'gradeonlyleclab' ){
			$pdf_type = 'f';
			 $data['type_d'][0] = $type_d[0]='final';
				$check_grade_submission = $this->grade_submission_model->check_sched_fgrades($datax['sched_id'],'final');
				if($check_grade_submission){
					$get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $datax['sched_id'] , $this->session->userdata('id') , $type );
					if($get_gradeupdate_request){
						if($get_gradeupdate_request[0]->status==1){
							$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).requestGradesUpdate(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >Request Grades Updates</button></li>';
						}else {
						$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).submitGrades(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >SUBMIT GRADES</button></li>';
					}
					}elseif ($check_grade_submission) {
						$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).requestGradesUpdate(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >Request Grades Updates</button></li>';
					}else{
						$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).submitGrades(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >SUBMIT GRADES</button></li>';
					}
				}else{
					$grade_submission_menu = '<li><button class="btn btn-primary btn-md " type="button" onclick="$(this).submitGrades(\''.$type2.'\',\''.$type.'\',\''.$datax['sched_id'].'\',\''.$leclab.'\',\''.$comp_type.'\');" >SUBMIT GRADES</button></li>';
				}
		}
		$settings = '
						<div id="settings" class="collapse in" style="height: 42px;">
						<ul class="nav nav-pills" role="tablist" id="myTabs">
							<li><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#resetModal" >RESET</a></li>
							<li><a class="btn btn-info" id="export_to_excel" href="'.base_url().'exporttoexcel_grades/exporttoexcel_leclab_'.$comp_type.'/xcl?sched_id='.$datax['sched_id'].'&type='.$type.'" target="_blank">ExportToEXCEL</a></button></li>
							'.$prcntx.'
							'.$prcnt.'

							<li><a class="btn btn-info" href="#" onclick="$(this).exportToPDF(\''.$pdf_type.'\');">ExportToPDF</a></li>

							<li><a class="btn btn-info" href="#" onclick="$(this).setSettings(\''.$type.'\',\''.$datax['check_sched'][0]['coursecode'].'\');">Settings</a></li>
							'.$grade_submission_menu.'
						</ul>
						</div>
						<br />
					';
					//
	return $settings;
	}

	public function reset_all(){

		$sched_id = $this->input->post('sched_id',TRUE);
		$teacher_id = $this->session->userdata('id');
		$reason = $this->input->post('reason',TRUE);

		// if($this->grade_submission_model->check_sched_fgrades($sched_id,'',true)){
		// 	echo 'Cant reset';
		// }{
				$tables2 = array(  'pcc_gs_fgrade_request_update',
		                        'pcc_gs_sched_exam_labscore',
		                        'pcc_gs_sched_exam_score',
		                        'pcc_gs_student_gradeslec',
		                        'pcc_gs_student_gradesleclab',
		                        'pcc_gs_subject_exam',
		                        'pcc_gs_subject_examlab',
		                        'pcc_gs_tchr_cs',


		                      );
				 $tables = array(  'pcc_gs_config',
		                        'pcc_gs_tchr_csscore',
		                        'pcc_gs_tchr_cs_cats',
		                        'pcc_gs_tchr_cs_cats_items',
		                        'pcc_gs_tchr_cs_cats_scores',
		                        'pcc_gs_tchr_cs_cats_subs',
		                        'pcc_gs_tchr_cs_contfg',
		                        'pcc_gs_tchr_cs_contfg_scores',
		                        'pcc_gs_tchr_cs_contg',
		                        'pcc_gs_tchr_cs_contg_scores',
		                        'pcc_gs_tchr_cs_nsub',
		                        'pcc_gs_tchr_cs_nsub_items',
		                        'pcc_gs_tchr_cs_nsub_scores',
		                        'pcc_gs_tchr_cs_sched_etools',
		                        'pcc_gs_tchr_cs_sched_etools_score',
		                        'pcc_gs_tchr_cs_wc',
		                        'pcc_gs_tchr_cs_wc_scores',
		                        'pcc_gs_tchr_items',
		                        'pcc_gs_tchr_computation',
		                        'pcc_student_final_grade'
		                      );

				$test = $this->sched_record_model->reset_grades_sched_id($sched_id,$tables);
				$test1 = $this->sched_record_model->reset_grades_schedid($sched_id,$tables2);
				$test2 = $this->sched_record_model->insert_reset_info($reason,$sched_id,$teacher_id);
		// }
	}







}
