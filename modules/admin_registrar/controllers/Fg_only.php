<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fg_only extends MY_Controller {

    function __construct(){
       	parent::__construct();
		$this->load->module('template/template');
		$this->load->module('admin_registrar/admin_reg');
		$this->load->model('admin_registrar/admin_reg_model');
		$this->load->model('admin_registrar/fg_only_model');
		$this->load->model('admin_registrar/grades_submission_model');
		 $this->load->model('sched_record2/grade_submission_model');
		 $this->load->model('sched_record2/sched_record_model');
		$this->admin_reg->_check_login();

    }

    public function index(){
		$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=$data["sem_sy"]["sem_sy"][0]->sem;
		$sy=$data["sem_sy"]["sem_sy"][0]->sy;

		$data['fg_only'] = $this->fg_only_model->get_fgs_only();
        $data['teachers'] = $this->fg_only_model->get_teachers_only();
		$data['completion'] = $this->fg_only_model->get_completion_days();

        // xx($data['teachers']);

		$data['view_content']='admin_registrar/fg_only/fg_only_view';
		$data['get_plugins_js']='admin_registrar/fg_only/fg_only_script';
		$data['get_plugins_css']='admin_registrar/fg_only/fg_only_css';

		$this->load->view('template/init_views',$data);
	}

	public function get_subjects(){

    	$data['suggestions'] = [];
    	$subjects = $this->fg_only_model->get_subjects($this->input->post('query'));

    		foreach ($subjects as $key => $value) {
    				$data['suggestions'][$key]['subjectid'] = $value->subjectid;
    				$data['suggestions'][$key]['descriptivetitle'] = $value->descriptivetitle;
    				$data['suggestions'][$key]['value'] = $value->courseno .' - '.$value->descriptivetitle.' ( '.$value->acadyear.' ) ';

    		}
    	echo json_encode($data);
    }


    public function get_teacher(){

        $data['suggestions'] = [];
        $teacher = $this->fg_only_model->get_teachers($this->input->post('query'));
            foreach ($teacher as $key => $value) {
                    $data['suggestions'][$key]['FileNo'] = $value->FileNo;
                    $data['suggestions'][$key]['value'] = $value->FirstName .' '.$value->LastName;
            }
        echo json_encode($data);
    }

    public function add_subjects(){
    	$subjectid = $this->input->post('subjectid');
    	   $data = ['error','PLEASE TRY AGAIN',''];

    	   $fg_only = $this->fg_only_model->get_fg_only($subjectid);
    	   if($fg_only){
    	   		if($fg_only[0]->deleted_at){
                $this->fg_only_model->restore_fg_only($subjectid);
                $data = ['info','Subject Restored',''];
            }else{
                $data = ['info','ALREADY ADDED',''];
            }
    	   }else{
    	   	$datax = [
    	   				'subjectid' => $subjectid,
    	   				'created_at' =>mdate('%Y-%m-%d %h:%i:%s'),
    					'updated_at' =>mdate('%Y-%m-%d %h:%i:%s'),
    	   			];
    	   		$fg_onlyi = $this->fg_only_model->insert_fg_only($datax);

    	   		 if($fg_onlyi){
    	   				$data = ['success','Successfully Added Subject',''];
    	   		}
    	   }
    	echo json_encode($data);
    }

    public function add_teacher(){
        $teacherid = $this->input->post('teacherid');
           $data = ['error','PLEASE TRY AGAIN',''];

           $teacher_view = $this->fg_only_model->get_teacher_view($teacherid);
           if($teacher_view){
            if($teacher_view[0]->deleted_at){
                $this->fg_only_model->restore_teacher_view($teacherid);
                $data = ['info','Teacher Restored',''];
            }else{
                $data = ['info','ALREADY ADDED',''];
            }
           }else{
            $datax = [
                        'teacher_id' => $teacherid,
                        'created_at' =>mdate('%Y-%m-%d %h:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %h:%i:%s'),
                    ];
                $teacher_viewi = $this->fg_only_model->insert_teacher_view($datax);

                 if($teacher_viewi){
                        $data = ['success','Successfully Added Teacher',''];
                }
           }
        echo json_encode($data);
    }

    public function remove_teacher(){
        $teacherid = $this->input->post('teacherid');
           $data = ['error','PLEASE TRY AGAIN',''];

           $fg_only = $this->fg_only_model->get_teacher_view($teacherid);
           if(!$fg_only){
                $data = ['info','NOT ADDED',''];
           }else{
                $fg_onlyd = $this->fg_only_model->remove_teacher_view($teacherid);
            if($fg_onlyd){
                        $data = ['success','REMOVE',' Successfully Remove Teacher From Grading View Records.'];
                }
           }
        echo json_encode($data);
    }

     public function remove_subjects(){
    	$subjectid = $this->input->post('subjectid');
    	   $data = ['error','PLEASE TRY AGAIN',''];

    	   $fg_only = $this->fg_only_model->get_fg_only($subjectid);
    	   if(!$fg_only){
    	   		$data = ['info','SUBJECT NOT ADDED',''];
    	   }else{
    	   		$fg_onlyd = $this->fg_only_model->remove_fg_only($subjectid);
    	   	if($fg_onlyd){
    	   				$data = ['success','REMOVE',' Successfully Remove Subject From Final Grade Only Submission.'];
    	   		}
    	   }
    	echo json_encode($data);
    }

    public function update_completion_days(){
       $type = $this->input->post('type');
       $days = $this->input->post('days');
           $data = ['error','PLEASE TRY AGAIN',''];
                $fg_onlyi = $this->fg_only_model->update_completion_days($type,$days);

                 if($fg_onlyi){
                        $data = ['success','Update Completion Days',''];
                }
        echo json_encode($data);
    }



}