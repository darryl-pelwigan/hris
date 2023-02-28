<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Teachersched extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');

		$this->load->model('check_submitted/check_submitted_model');
		$this->load->model('sched_grades/sched_grades_model');
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

	public function set_semsy(){
		$sem = $this->input->post("set_sem",TRUE);
        $sy = $this->input->post("set_sy",TRUE);
        $new_sem_Sy = array(
                            'sem' => $sem,
                            'sy' => $sy
                            );
        $this->session->set_userdata('new_sem_Sy',$new_sem_Sy);
         $data['test'] =$this->session->userdata('new_sem_Sy');
         echo json_encode($data);
	}

	public function get_sched(){
		// $this->output->enable_profiler(TRUE);

		$this->load->model('sched_model');
		$this->load->module('template/template');
		$this->load->module('sched_record2/sched_record2');
		$data['fileno'] = $this->session->userdata('fileno');
		$datax['sem_sy']=$this->template->get_sem_sy();
		$sem=	$this->input->post('set_sem', TRUE);
		$sy=	$this->input->post('set_sy', TRUE);
		$new_sem_Sy = array(
                            'sem' => $sem,
                            'sy' => $sy
                            );
        $this->session->set_userdata('new_sem_Sy',$new_sem_Sy);
         $data['test'] =$this->session->userdata('new_sem_Sy');


		$data['sem_sy2']=$sem;


		$sched =$this->sched_model->get_teacher_sched($this->session->userdata('id'),$sem,$sy,
		'
		t.id,
		t.teacherid ,
		t.subjid ,
		s.courseid ,
		s.coursecode ,
		s.courseno ,
		s.description ,
		s.lecunits ,
		s.labunits ,
		s.totalunits ,
		s.days ,
		s.start ,
		s.end ,
		s.room ,
		s.yearlvl ,
		s.semester ,
		s.acadyear ,
		s.section ,
		s.fuse ,
		c.code
		');


		// echo var_dump($sched);
		$data['data']=[];
		$count_sched=1;
		for($x=0;$x<count($sched);$x++){
			$completion = $this->sched_model->check_grade_completion($this->session->userdata('id'),$sched[$x]->subjid);
			if($completion != null){
				if($completion[0]->submit_final){
				$var = true;
				$date = $completion[0]->submit_final;
				}else{
				$var = false;
				$date = null;
				}
			}else{
				$var = false;
				$date = null;
			}
			$sched2=$this->sched_model->get_sched_info($this->session->userdata('id'),$sched[$x]->coursecode)['sched_query'];
			$subjid_x = $this->encryption->encrypt($sched[$x]->subjid);
				$days=[];
				$start=[];
				$end=[];
				$room=[];
				$sched_num =  $this->sched_model->get_sched_info($this->session->userdata('id'),$sched[$x]->coursecode)['sched_num'];
				for($c=0;$c<$sched_num;$c++){
						$check_sched = $this->sched_record2->get_check_sched($this->session->userdata('id'),$sched2[0]->schedid);
						$days[]=[$sched2[$c]->days];
						$start[]=[$sched2[$c]->start];
						$end[]=[$sched2[$c]->end];
						$room[]=[$sched2[$c]->room];
				}
					$sem_sy=$this->template->get_sem_w($sem,$sy);
					$url = base_url()."Schedule/Records2";
					$url2 = base_url()."Schedule/SCHED_GRADES";
					$url3 = base_url()."Grade_completion/index";
					// if($this->session->userdata('id')==='5551'){$url = base_url()."Schedule/Records2/".$sched[$x]->subjid; }
     				// else{$url = base_url()."Schedule/Records/".$sched[$x]->subjid;}
     				$notify = false;
     				$check_notify = $this->check_submitted_model->get_notify( $sched[$x]->subjid );
     				$check_submitted = $this->sched_grades_model->get_grade_review( $sched[$x]->subjid );

                    if($check_notify){

                        if( $check_notify[0]->prelim != NULL || $check_notify[0]->midterm != NULL || $check_notify[0]->tentative != NULL ){
                        	if($check_submitted){


                        		if($check_submitted[0]->submit_final){
                        			$notify = false;
                        		}
                        	}
                        	else{
                        		$notify = true;
                        	}
                        }else{
                            $notify = false;
                        }
                    }else{
                       $notify = false;
                    }


								$data['data'][]=array(
										"notify"		=>  $notify,
										"set_sem"		=>  $sem,
										"set_sy"		=>  $sy,
										"courseid"		=>	$sched2[0]->courseid,
										"acadyear"		=>	$sched2[0]->acadyear,
										"courseno"		=>	$sched2[0]->courseno,
										"lecunits"		=>	$check_sched["lecunits"],
										"labunits"		=>	$check_sched["labunits"],
										"semester"		=>	$sem_sy['csem'],
										"coursecode"	=>	$sched2[0]->coursecode,
										"description"	=>	$sched2[0]->description,
										"days"			=>	$days,
										"start"			=>	$start,
										"end"			=>	$end,
										"room" 			=> 	$room,
										"section" 		=> 	$sched2[0]->section,
										"code" 			=> 	$sched[$x]->code,
										"yearlvl" 		=> 	$sched[$x]->yearlvl,
										"subjid" 		=> 	$subjid_x,
										"urlx" 			=> 	$url,
										"urlx2" 		=> 	$url2,
										"urlx3"			=> 	$url3,
										"config"		=> 	$this->check_subject_conf($sched2[0],$check_sched,$sched[$x],$this->session->userdata('id')),
										"completion"	=>	$var,
										"completion_date"=>	$date

								);

		}
		# $this->sched_model->sett_teacher_sched($this->session->userdata('id'));
		echo json_encode($data);
	}


	public function check_subject_conf($sched2,$check_sched,$sched,$teacherid){
			if(!$this->sched_model->get_subjct_conf($sched2,$check_sched,$sched,$teacherid)){
				return $this->sched_model->create_subject_conf($sched2,$check_sched,$sched,$teacherid);
			}
			return false;
	}

	public function update_subject_conf($sched2,$check_sched,$sched,$teacherid){

	}
	public function get_sched_info($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_schedulelist', array('schedid' => $id),0, 1);
        return $query->result();
    }

	public function get_sched_info_c($coursecode,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_schedulelist', array('coursecode' => $coursecode));
        return $query->result();
    }

	public function get_tchr_sched_info($id,$select='*'){
        $this->db->select($select);
        $query = $this->db->get_where('pcc_teachersched', array('teacherid' => $id),0, 1);
        return $query->result();
    }


    public function get_transmutation(){

    	$transmutation=$this->transmutation->create_json($this->input->post('total_score'),$this->input->post('base_trans'));

    	echo '['.json_encode($transmutation).']';
    }

}
