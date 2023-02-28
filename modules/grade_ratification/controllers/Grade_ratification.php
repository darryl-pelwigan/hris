<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Grade_ratification extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('admin_registrar/fg_only_model');
		$this->load->model('sched_record2/sched_record_model');
		$this->load->model('teachersched/sched_model');
		$this->load->model('admin/user_model');
		$this->load->module('admin/admin');
		$this->load->module('template/template');
		$this->load->model('template/template_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->load->model('sched_grades/sched_grades_model');
		$this->load->model('sched_record2/grade_submission_model');
		$this->load->model('student/student_model');
        $this->load->model('admin_registrar/grades_submission_model');
        $this->load->model('student_grades/student_grades_model');
		$this->load->model('student/student_model');
		$this->load->model('grade_completion/grade_completion_model');
        $this->load->model('grade_ratification/grade_ratification_model');
        $this->load->model('subject/subject_enrollees_model');
        $this->load->module('sched_grades/sched_grades_checker');


    }





    public function ratify_student_grades(){
        $this->load->module('admin_registrar/admin_reg');
        $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        if(!$sched_id && !$student_id){
            redirect('grade_completion/view_grade_completion/');
        }
        $data['sem_sy'] =$this->template->get_sem_sy();

        $data['student_id'] = $student_id ;
        $data['sched_id'] = $sched_id ;
        $data['teacher_id'] = $this->session->userdata('id');
        $data['nav']=$this->admin_reg->_nav();

        $data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
        $data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
        $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;

        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        $data['div'] = 3;


        $data['grade_completion'] = $this->grade_ratification_model->get_grade_ratification_student($sched_id,$student_id);
        $data['checker'] = $this->sched_grades_checker->check_subject_type($data['check_sched']);

        if($data['sub_sem_sy']['sem'] == 3){
            $data['div'] = 2;
        }


        $data['student_info'] = $this->student_model->get_student_infocie($data['student_id'],'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;


        $data['subject_grades'] = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        $data['leclab'] = false;
        if( $data['check_sched']['lecunits'] != 0 && $data['check_sched']['labunits'] != 0 ){
            $data['leclab'] = true;
        }


             if($data['checker']['fg_only']):

                    $data['view_content']='grade_ratification/ratify_student_grade_tfx';
                    $data['get_plugins_js']='grade_ratification/js/js_ratify_student_grade_tfx';
            else:
                    $data['view_content']='grade_ratification/ratify_student_grade_tf';
                    $data['get_plugins_js']='grade_ratification/js/js_ratify_student_grade_tf';
            endif;



        $data['get_plugins_css']='grade_ratification/css/css_complete_student_grade';
        $this->load->view('template/init_views',$data);
    }


    public function save_grade_ratify(){
       $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $prelim = $this->input->post('prelim', TRUE);
        $midterm = $this->input->post('midterm', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $comment = $this->input->post('comment', TRUE);
        $grade_remarks = $this->input->post('grade_remarks', TRUE);

        $grade_ratification = $this->grade_ratification_model->get_grade_ratification_student($sched_id,$student_id);

        $data['teacher_id'] = $this->session->userdata('id');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;
        $dtn = Carbon\Carbon::now();

        $old_data = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
            $old_datax[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];

       $data = [
                        'sched_id' =>$sched_id,
                        'student_id' =>$student_id,
                        'teacher_id' =>$data['check_sched']['teacherid'][0],
                        'prelim' =>$prelim,
                        'midterm' =>$midterm,
                        'tentativefinal' =>$tentativefinal,
                        'final_grade' =>$final_grade,
                        'grade_remarks' => $grade_remarks,
                        'comment' =>$comment,
                        'old_data' => json_encode($old_datax),
                        'created_at' =>mdate('%Y-%m-%d %H:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %H:%i:%s'),

                    ];



        if(!$grade_ratification){

            $igrade_completion = $this->grade_ratification_model->insert_grade_ratification_student($data);
            if($igrade_completion){
                $dataz = ['success','SUCCESSFULLY SAVE',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $dataz = ['error','PLEASE TRY AGAIN',''];
            }

        }else{
            $old_datay = json_decode($grade_ratification[0]->old_data, true);
            $old_datay[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data['old_data'] = json_encode($old_datay);
            $ugrade_completion = $this->grade_ratification_model->update_grade_ratification_student($data);
            if($ugrade_completion){
                    $dataz = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $dataz = ['error','PLEASE TRY AGAIN',''];
            }

        }
         $datax = array(
                        'student_id' => $student_id,
                        'sched_id' => $sched_id,
                        'submitted_by' => $data['teacher_id'],
                        'tentativefinal' =>$tentativefinal,
                        'final' =>$final_grade,
                        'remarks' => $grade_remarks,
                        'date_created' => mdate('%Y-%m-%d %H:%i:%s')
                    );
        $grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$student_id,'');
        if(!isset($grades[0]->prelim)){
             $this->grade_submission_model->insert_grades($datax);
        }

         if(($dataz[0] == 'success')){

               $fgrade_completion =  $this->grade_completion_model->update_grades_finalxz($data);
               if($grade_remarks == 'Incomplete'){
                $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
                    if($grade_completion){
                         $this->grade_completion_model->update_grade_completion_student_incomplete($data);
                    }
               }
                if($fgrade_completion){
                    $dataz = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
                }else{
                    $dataz = ['error','PLEASE TRY AGAIN',''];
                }

        }

        echo json_encode($dataz);
    }


    public function save_grade_ratify_fg(){
       $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $comment = $this->input->post('comment', TRUE);
        $grade_remarks = $this->input->post('grade_remarks', TRUE);

        $grade_ratification = $this->grade_ratification_model->get_grade_ratification_student($sched_id,$student_id);
         $data['teacher_id'] = $this->session->userdata('id');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;
        $dtn = Carbon\Carbon::now();
        $datax = [];
        $old_data = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
            $old_datax[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $prelim =  0;
            $midterm =  $tentativefinal;
            if($data['check_sched'][0]['semester'] != 3){
                    $prelim = $tentativefinal;
            }
       $data = [
                        'sched_id' =>$sched_id,
                        'student_id' =>$student_id,
                        'teacher_id' => $data['check_sched']['teacherid'][0],
                        'prelim' =>$prelim,
                        'midterm' =>$midterm,
                        'tentativefinal' =>$tentativefinal,
                        'final_grade' =>$final_grade,
                        'grade_remarks' => $grade_remarks,
                        'comment' =>$comment,
                        'old_data' => json_encode($old_datax),
                        'created_at' =>mdate('%Y-%m-%d %H:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %H:%i:%s'),

                    ];



        if(!$grade_ratification){

            $igrade_completion = $this->grade_ratification_model->insert_grade_ratification_student($data);
            if($igrade_completion){
                $datax = ['success','SUCCESSFULLY SAVE',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $datax = ['error','PLEASE TRY AGAIN',''];
            }

        }else{
            $old_datay = json_decode($grade_ratification[0]->old_data, true);
            $old_datay[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data['old_data'] = json_encode($old_datay);
            $ugrade_completion = $this->grade_ratification_model->update_grade_ratification_student($data);
            if($ugrade_completion){
                    $datax = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $datax = ['error','PLEASE TRY AGAIN',''];
            }

        }
        $datax = array(
                                    'student_id' => $student_id,
                                    'sched_id' => $sched_id,
                                    'submitted_by' => $data['teacher_id'],
                                    'tentativefinal' =>$tentativefinal,
                                    'final' =>$final_grade,
                                    'remarks' => $grade_remarks,
                                    'date_created' => mdate('%Y-%m-%d %H:%i:%s')
                                );
        $grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$student_id,'');
        if(!isset($grades[0]->prelim)){
             $this->grade_submission_model->insert_grades($datax);
        }
         if(($datax[0] == 'success')){
               $fgrade_completion =  $this->grade_completion_model->update_grades_final($sched_id,$student_id,$this->finalg($final_grade,$grade_remarks),$tentativefinal,$grade_remarks);
               if($grade_remarks == 'Incomplete'){
                $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
                    if($grade_completion){
                         $this->grade_completion_model->update_grade_completion_student_incomplete($data);
                    }
               }
                if($fgrade_completion){
                    $datax = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
                }else{
                    $datax = ['error','PLEASE TRY AGAIN',''];
                }

        }

        redirect('grade_completion/view_grade_completion/');
    }

    public function finalg($final,$student_remarks_r){
                if($final>=75 || $final<70){
                    $final=round( $final,2 );
                }else{
                    if($student_remarks_r == 'Passed'){
                        $final=75;
                    }else{
                        $final=round( $final,2);
                    }
                }

                return $final;
    }


}
