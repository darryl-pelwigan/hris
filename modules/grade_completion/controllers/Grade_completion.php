<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Grade_completion extends MY_Controller {

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
        $this->load->model('subject/subject_enrollees_model');
        $this->load->module('sched_grades/sched_grades_checker');
        $this->load->model('admin_registrar/admin_reg_model');


    }

    public function view_grade_completion(){
        $this->load->module('admin_registrar/admin_reg');
        $this->admin->_check_login_registrar();
        $data['sem_sy'] =$this->template->get_sem_sy();
        $sem=$data["sem_sy"]["sem_sy"][0]->sem;
        $sy=$data["sem_sy"]["sem_sy"][0]->sy;

        $data['teacher_id'] = $this->session->userdata('id');
        $data['nav']=$this->admin_reg->_nav();
        $data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
        $data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
        $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;




        $data['scool_year'] = $this->admin_reg_model->get_schoolyear('sc.schoolyear');

        $data['set_sem'] = $sem;
        $data['set_sy'] = $sy;

        $data['grade_completion'] = $this->grade_completion_model->get_gc();


        $data['tbody'] = $this->set_gc_tbody($data);

        $data['view_content']='grade_completion/view_all/index';
        $data['get_plugins_js']='grade_completion/view_all/js_index';

        $data['get_plugins_css']='grade_completion/view_all/css_index';
        $this->load->view('template/init_views',$data);
    }


    public function set_gc_tbody($data){
            $tr = '';
            $count = 0;
            foreach ($data['grade_completion'] as $key => $value) {

                $student_info = $this->student_model->get_student_infocie($value->student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

                $subject_info = $this->subject_enrollees_model->get_subjectx($value->sched_id);
                $user_info  =$this->user_model->get_user_info($value->teacher_id,'LastName , FirstName , MiddleName');




              $tr .= '<tr>
                        <td>'.$count++.'</td>
                        <td>'.$value->student_id.'</td>
                        <td>'.$student_info[0]->LastName.', '.$student_info[0]->FirstName.'</td>
                        <td>'.$student_info[0]->code.' - '.$student_info[0]->yearlvl.'</td>
                        <td>'.semester($subject_info[0]->semester).' - '.$subject_info[0]->schoolyear.'</td>
                        <td>'.$subject_info[0]->description.'</td>
                        <td>'.$user_info[0]->LastName.', '.$user_info[0]->FirstName.'</td>

                        <td>
                            <form method="POST" action="'.base_url().'grade_completion/enter_student_grades_registrar" target="__blank">
                            <input type="hidden" name="aprroval_only" value="true" />
                            <input type="hidden" name="sched_id" value="'.$value->sched_id.'" />
                            <input type="hidden" name="studentid" value="'.$value->student_id.'" />
                            <input type="hidden" name="approving_registrar" value="true" />
                            <button type="submit" class="btn btn-primary" title="CLICK TO GENERATE GRADES COMPLETION" > view  </button>
                        </form>
                        </td>
                    </tr>';
            }

            return $tr;
    }

    public function gccount(){
        $data['grade_completion'] = $this->grade_completion_model->count_gc();

        echo json_encode(count($data['grade_completion']));
    }


	public function enter_student_grades(){
        $this->admin->_check_login();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
    	if(!$sched_id && !$student_id){
    		redirect('TeacherScheduleList');
    	}
    	$data['sem_sy'] =$this->template->get_sem_sy();

    	$data['student_id'] = $student_id ;
		$data['sched_id'] = $sched_id ;
		$data['teacher_id'] = $this->session->userdata('id');
		$data['nav']=$this->admin->_nav();

		$data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
		$data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
		$data['subject_info2'] =$this->sched_model->get_schedteacher_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
		$data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
		$data['check_sched']['teacher_adviser']= $data['subject_info3'];
		$data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
		$data['div'] = 3;


		$data['grade_completion'] = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
        $data['checker'] = $this->sched_grades_checker->check_subject_type($data['check_sched']);

		if($data['sub_sem_sy']['sem'] == 3){
			$data['div'] = 2;
		}


        $data['student_info'] = $this->student_model->get_student_infocie($data['student_id'],'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;


        $data['subject_grades'] = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
		$data['leclab'] = false;
        $lec_lab = ['lec' => 60, 'lab' => 40,  ];
        $data['lec_lab'] = json_encode($lec_lab);
		if( $data['check_sched']['lecunits'] != 0 && $data['check_sched']['labunits'] != 0 ){
			$data['leclab'] = true;
            if($this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'schedid')['exam_num']>0){
                $data['lec_lab'] = $this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'percentage')['exam_query'][0]->percentage ;
            }
		}

         if($data['checker']['fg_only']):
		      $data['view_content']='grade_completion/complete_student_grade_tfx';
		      $data['get_plugins_js']='grade_completion/js/js_complete_student_grade_tfx';
         else:
    		  $data['view_content']='grade_completion/complete_student_grade';
    		  $data['get_plugins_js']='grade_completion/js/js_complete_student_grade';
        endif;
		$data['get_plugins_css']='grade_completion/css/css_complete_student_grade';
		$this->load->view('template/init_views',$data);
    }

    public function enter_student_grades_registrar(){
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
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infoxx($data['teacher_id'],$data['subject_info']['sched_query'][0]);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        $data['div'] = 3;


        $data['grade_completion'] = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
        $data['checker'] = $this->sched_grades_checker->check_subject_type($data['check_sched']);

        if($data['sub_sem_sy']['sem'] == 3){
            $data['div'] = 2;
        }


        $data['student_info'] = $this->student_model->get_student_infocie($data['student_id'],'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;


        $data['subject_grades'] = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);

        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);

        $lec_lab = ['lec' => 60, 'lab' => 40,  ];
        $data['leclab'] = false;
        $data['lec_lab'] = json_encode($lec_lab);
        if( $data['check_sched']['lecunits'] != 0 && $data['check_sched']['labunits'] != 0 ){
            $data['leclab'] = true;
            if($this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'schedid')['exam_num']>0){
                $data['lec_lab'] = $this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'percentage')['exam_query'][0]->percentage ;
            }
        }


        if($this->input->post('aprroval_only', TRUE)){
             if($data['checker']['fg_only']):
                    $data['view_content']='grade_completion/registrar_complete_student_grade_tfx';
                    $data['get_plugins_js']='grade_completion/js/js_registrar_complete_student_grade_tfx';
            else:

                    $data['view_content']='grade_completion/reg_complete_student_grade';
                    $data['get_plugins_js']='grade_completion/js/js_reg_complete_student_grade';
            endif;
        }else{

             $data['view_content']='grade_completion/registrar_complete_student_grade_tf';
            $data['get_plugins_js']='grade_completion/js/js_registrar_complete_student_grade_tf';
        }


        $data['get_plugins_css']='grade_completion/css/css_complete_student_grade';
        $this->load->view('template/init_views',$data);
    }


    public function save_grade_completion(){
    	$this->admin->_check_login();
    	$sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $remarks = $this->input->post('remarks', TRUE);
        $grade_remarks = $this->input->post('grade_remarks', TRUE);
        $lec_cs = $this->input->post('lec_cs', TRUE);
		$lec_exam = $this->input->post('lec_exam', TRUE);
		$lec_total = $this->input->post('lec_total', TRUE);

		$lab_cs = null;
		$lab_exam = null;
		$lab_total = null;
        $lab_p = null;
         $lec_lab = ['lec' => 60, 'lab' => 40,  ];

        if($this->input->post('leclab', TRUE)){
    			$lab_cs = $this->input->post('lab_cs', TRUE);
    			$lab_exam = $this->input->post('lab_exam', TRUE);
    			$lab_total = $this->input->post('labp_total', TRUE);
                $lab_p = json_encode($this->input->post('lab_p', TRUE));
                $lec_lab['lec'] = $this->input->post('lec_percnt', TRUE);
                $lec_lab['lab'] = $this->input->post('lab_percnt', TRUE);
    	}
        $lec_lab = json_encode($lec_lab);

        if($this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'schedid')['exam_num']>0){
                 $this->sched_record_model->update_percentage($sched_id,$lec_lab);
            }else{  $this->sched_record_model->insert_percentage($sched_id,$lec_lab);   }

        $teacher_id = $this->session->userdata('id');
    	if(!$sched_id && !$student_id && !$tentative && !$final_grade && !$remarks){
    		redirect('TeacherScheduleList');
    	}

    	 $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

    	$grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);

        $dtn = Carbon\Carbon::now();
        $old_data = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $old_datax[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
                $data = [
                        'sched_id' =>$sched_id,
                        'student_id' =>$student_id,
                        'teacher_id' =>$teacher_id,
                        'lec_cs' =>$lec_cs,
                        'lec_exam' =>$lec_exam,
                        'lec_exam' =>$lec_exam,
                        'lec_total' =>$lec_total,
                        'lec_percentage' => json_encode($this->input->post('lec_p', TRUE)),
                        'lab_cs' =>$lab_cs,
                        'lab_exam' =>$lab_exam,
                        'lab_total' =>$lab_total,
                        'lab_percentage' => $lab_p,
                        'lec_lab' =>$lec_lab,
                        'tentativefinal' =>$tentativefinal,
                        'final_grade' =>$final_grade,
                        'remarks' =>$remarks,
                        'grade_remarks' =>$grade_remarks,
                        'old_data' => json_encode($old_datax),
                        'created_at' =>mdate('%Y-%m-%d %H:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %H:%i:%s'),

                    ];

    	if(!$grade_completion){
    		$igrade_completion = $this->grade_completion_model->insert_grade_completion_student($data);
    		if($igrade_completion){
    			$data = ['success','SUCCESSFULLY SAVE',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
    		}else{
    			$data = ['error','PLEASE TRY AGAIN'];
    		}

    	}else{
            $old_datay = json_decode($grade_completion[0]->old_data, true);
            $old_datay[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data['old_data'] = json_encode($old_datay);
    		$ugrade_completion = $this->grade_completion_model->update_grade_completion_student($data);
    		if($ugrade_completion){
    				$data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
    		}else{
    			$data = ['error','PLEASE TRY AGAIN',''];
    		}

    	}

    	echo json_encode($data);

    }

    public function save_grade_completion_tf(){
    	$this->admin->_check_login();
    	$sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $final_ramarks = $this->input->post('final_ramarks', TRUE);
        $remarks = $this->input->post('remarks', TRUE);
        $teacher_id = $this->session->userdata('id');
    	if(!$sched_id && !$student_id && !$tentative && !$final_grade && !$remarks){
    		redirect('TeacherScheduleList');
    	}

    	 $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

    	$grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);

        $dtn = Carbon\Carbon::now();
        $old_data = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $old_datax[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data = [
                        'sched_id' =>$sched_id,
                        'student_id' =>$student_id,
                        'teacher_id' =>$teacher_id,
                        'tentativefinal' =>$tentativefinal,
                        'final_grade' =>$final_grade,
                        'remarks' =>$remarks,
                        'grade_remarks' => $final_ramarks,
                        'old_data' => json_encode($old_datax),
                        'created_at' =>mdate('%Y-%m-%d %H:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %H:%i:%s'),

                    ];

    	if(!$grade_completion){

    		$igrade_completion = $this->grade_completion_model->insert_grade_completion_student($data);
    		if($igrade_completion){
    			$data = ['success','SUCCESSFULLY SAVE',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
    		}else{
    			$data = ['error','PLEASE TRY AGAIN'];
    		}

    	}else{
            $old_datay = json_decode($grade_completion[0]->old_data, true);
            $old_datay[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data['old_data'] = json_encode($old_datay);
    		$ugrade_completion = $this->grade_completion_model->update_grade_completion_student_tf($data);
    		if($ugrade_completion){
    				$data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
    		}else{
    			$data = ['error','PLEASE TRY AGAIN',''];
    		}

    	}

    	echo json_encode($data);

    }

    public function save_grade_completion_print(){
    	$sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $data['student_id'] = $student_id;
        $data['teacher_id'] = $this->session->userdata('id');
        $data['college'] = $this->grade_completion_model->get_department($data['teacher_id'],'DEPTNAME');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['student_info'] = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['subject_info']['sched_query'][0]->semester,$data['subject_info']['sched_query'][0]->schoolyear);

        $data['subject_grades'] = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $data['div'] = 3;
        if($data['sub_sem_sy']['sem'] == 3){
			$data['div'] = 2;
		}

		$data['leclab'] = false;
        $lec_lab = ['lec' => 60, 'lab' => 40,  ];

		if( $data['check_sched']['lecunits'] != 0 && $data['check_sched']['labunits'] != 0 ){
			$data['leclab'] = true;
            $lec_lab['lec'] = $this->input->post('lec_percnt', TRUE);
            $lec_lab['lab'] = $this->input->post('lab_percnt', TRUE);

		}

        $lec_lab = json_encode($lec_lab);

        if($this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'schedid')['exam_num']>0){
                $lec_lab =  ($this->sched_record_model->get_subject_exam(1,1 , '',$sched_id ,'p' ,'percentage')['exam_query'][0]->percentage);
        }
        $data['lec_lab'] = $lec_lab;
        $data['grade_completion'] = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
        $data['grade_completion_printed'] = $this->grade_completion_model->update_grade_completion_student_printed($sched_id,$student_id);
        $data['checker'] = $this->sched_grades_checker->check_subject_type($data['check_sched']);
        					$this->load->library("pdf");
                            $pdf = $this->pdf->load();  // L - landscape, P - portrait

                            if(!$data['checker']['fg_only']):
                                    $html = $this->load->view('complete_student_grade_pdf_leclab', $data, true); // render the view into HTML
                            else:

                                 $html = $this->load->view('complete_student_grade_pdf_fg', $data, true); // render the view into HTML
                            endif;

                            $pdf->simpleTables = true;
                            $pdf->packTableData = true;
                            $pdf->shrink_tables_to_fit=1;
                           	// $pdf->mPDF('utf-8',array(215.9,165.1),'','',5,5,2,5,5,5);
                            $pdf->mPDF('utf-8','Legal','','',5,5,2,5,5,5);

            $pdf->WriteHTML($html); // write the HTML into the PDF

            $pdfFilePath = 'Grade_completion-'.$data['student_id'].'-'.$data['teacher_id'].'_'.strtoupper($data['subject_info']['sched_query'][0]->courseno).'_'.$data['sched_id'].'('.date("Y-m-d HisA").").pdf";
            $pdf->Output($pdfFilePath , 'D'); // save to file because we can

    }

    public function save_registrar_grade_completion_tf(){

        $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $remarks = $this->input->post('remarks', TRUE);
        $data['teacher_id'] = $this->session->userdata('id');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        if(!$sched_id && !$student_id && !$tentative && !$final_grade && !$remarks){
            redirect('grade_completion/view_grade_completion/');
        }

         $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

        $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
        if($this->input->post('sub_approve', TRUE) == 0){
         $reg_remarks = [mdate('%Y-%m-%d %H:%i:%s'),'remarksg'=>'registrar submission','remarks'=>json_encode($remarks),'reg_id' =>$this->session->userdata('id') ];
        }else{
             $reg_remarks = [mdate('%Y-%m-%d %H:%i:%s'),'remarksg'=>'','remarks'=>json_encode($remarks),'reg_id' =>$this->session->userdata('id') ];
        }

        $dtn = Carbon\Carbon::now();
        $old_data = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $old_datax[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];

        $datax = [
                        'sched_id' =>$sched_id,
                        'student_id' =>$student_id,
                        'teacher_id' =>$data['check_sched']['teacherid'][0],
                        'tentativefinal' =>$tentativefinal,
                        'final_grade' =>$final_grade,
                        'old_data' => json_encode($old_datax),
                        'approved_by_registrar' => json_encode($reg_remarks),
                        'created_at' =>mdate('%Y-%m-%d %H:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %H:%i:%s'),

                    ];

        if(!$grade_completion){

            $igrade_completion = $this->grade_completion_model->insert_grade_completion_student($datax);
            if($igrade_completion){
                $data = ['success','SUCCESSFULLY SAVE',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $data = ['error','PLEASE TRY AGAIN'];
            }

        }else{
            $old_datay = json_decode($grade_ratification[0]->old_data, true);
            $old_datay[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data['old_data'] = json_encode($old_datay);
            $ugrade_completion = $this->grade_completion_model->update__registrar_grade_completion_student_tf($data);
            if($ugrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $data = ['error','PLEASE TRY AGAIN',''];
            }

        }

        if(($data[0] == 'success')){
                $remarksg = 'Failed';
               if($final_grade >= 75){
                    $remarksg = 'Passed';
               }
               $fgrade_completion =  $this->grade_completion_model->update_grades_final($sched_id,$student_id,$this->finalg($final_grade,$remarksg),$tentativefinal,$remarksg);

                if($fgrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
                }else{
                    $data = ['error','PLEASE TRY AGAIN',''];
                }

        }

        echo json_encode($data);
    }



    public function save_registrar_grade_completion_tfx(){

        $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $remarks = $this->input->post('remarks', TRUE);
        $data['teacher_id'] = $this->session->userdata('id');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        if(!$sched_id && !$student_id && !$tentative && !$final_grade && !$remarks){
            redirect('grade_completion/view_grade_completion/');
        }

         $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

        $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);
        if($this->input->post('sub_approve', TRUE) == 0){
         $reg_remarks = [mdate('%Y-%m-%d %H:%i:%s'),'remarksg'=>'registrar submission','remarks'=>json_encode($remarks),'reg_id' =>$this->session->userdata('id') ];
        }else{
             $reg_remarks = [mdate('%Y-%m-%d %H:%i:%s'),'remarksg'=>'','remarks'=>json_encode($remarks),'reg_id' =>$this->session->userdata('id') ];
        }

        $dtn = Carbon\Carbon::now();
        $old_data = $this->student_grades_model->get_stud_fgrades_persubjectxx($sched_id,$student_id);
        $old_datax[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];

            $datax = [
                        'sched_id' =>$sched_id,
                        'student_id' =>$student_id,
                        'teacher_id' =>$data['check_sched']['teacherid'][0],
                        'tentativefinal' =>$tentativefinal,
                        'final_grade' =>$final_grade,
                        'old_data' => json_encode($old_datax),
                        'approved_by_registrar' => json_encode($reg_remarks),
                        'created_at' =>mdate('%Y-%m-%d %H:%i:%s'),
                        'updated_at' =>mdate('%Y-%m-%d %H:%i:%s'),

                    ];


        if(!$grade_completion){

            $igrade_completion = $this->grade_completion_model->insert_grade_completion_student($datax);
            if($igrade_completion){
                $data = ['success','SUCCESSFULLY SAVE',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $data = ['error','PLEASE TRY AGAIN'];
            }

        }else{
             $old_datay = json_decode($grade_ratification[0]->old_data, true);
            $old_datay[$dtn->format('Y-m-d H:i:s')] = ['data' => $old_data];
            $data['old_data'] = json_encode($old_datay);
            $ugrade_completion = $this->grade_completion_model->update__registrar_grade_completion_student_tf($data);
            if($ugrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $data = ['error','PLEASE TRY AGAIN',''];
            }

        }

        if(($data[0] == 'success')){
                $remarksg = 'Failed';
               if($final_grade >= 75){
                    $remarksg = 'Passed';
               }
               $fgrade_completion =  $this->grade_completion_model->update_grades_final($sched_id,$student_id,$this->finalg($final_grade,$remarksg),$tentativefinal,$remarksg);

                if($fgrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
                }else{
                    $data = ['error','PLEASE TRY AGAIN',''];
                }

        }

        echo json_encode($data);
    }






    public function approved_registrar_grade_completion_tf(){

        $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $remarks = $this->input->post('remarks', TRUE);
        $data['teacher_id'] = $this->session->userdata('id');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        if(!$sched_id && !$student_id && !$tentative && !$final_grade && !$remarks){
            redirect('grade_completion/view_grade_completion/');
        }

        $reg_remarks = [mdate('%Y-%m-%d %H:%i:%s'),'remarksg'=>'registrar approval','remarks'=>json_encode($remarks),'reg_id' =>$this->session->userdata('id') ];

        $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

        $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);

            $ugrade_completion = $this->grade_completion_model->approved__registrar_grade_completion_student_tf($sched_id,$student_id,$reg_remarks);
            if($ugrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $data = ['error','PLEASE TRY AGAIN',''];
            }


        if(($data[0] == 'success')){
                $remarksg = 'Failed';

                $grade_remarks = $grade_completion[0]->grade_remarks;
                $remarksg = $grade_remarks;
               $fgrade_completion =  $this->grade_completion_model->update_grades_final($sched_id,$student_id,$this->finalg($final_grade,$remarksg),$tentativefinal,$remarksg);

                if($fgrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
                }else{
                    $data = ['error','PLEASE TRY AGAIN',''];
                }

        }

        redirect('grade_completion/view_grade_completion/');

    }

     public function approved_registrar_grade_completion_tfx(){

        $this->admin->_check_login_registrar();
        $sched_id = $this->input->post('sched_id', TRUE);
        $student_id = $this->input->post('studentid', TRUE);
        $tentativefinal = $this->input->post('tentative', TRUE);
        $final_grade = $this->input->post('final_grade', TRUE);
        $remarks = $this->input->post('remarks', TRUE);
        $final_remarks = $this->input->post('final_remarks', TRUE);
        $data['teacher_id'] = $this->session->userdata('id');
        $data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
        $data['subject_info2'] =$this->sched_model->get_schedteacher_infox($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
        $data['check_sched']['teacher_adviser']= $data['subject_info3'];
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);
        if(!$sched_id && !$student_id && !$tentative && !$final_grade && !$remarks){
            redirect('grade_completion/view_grade_completion/');
        }

        $reg_remarks = [mdate('%Y-%m-%d %H:%i:%s'),'remarksg'=>'registrar approval','remarks'=>json_encode($remarks),'reg_id' =>$this->session->userdata('id') ];

        $student_info = $this->student_model->get_student_infocie($student_id,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;

        $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$student_id);

            $ugrade_completion = $this->grade_completion_model->approved__registrar_grade_completion_student_tf($sched_id,$student_id,$reg_remarks);
            if($ugrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
            }else{
                $data = ['error','PLEASE TRY AGAIN',''];
            }


        if(($data[0] == 'success')){
               $fgrade_completion =  $this->grade_completion_model->update_grades_finalx($sched_id,$student_id,$this->finalg($final_grade,$remarksg),$tentativefinal,$final_remarks);

                if($fgrade_completion){
                    $data = ['success','SUCCESSFULLY UPDATED',$student_info[0]->FirstName.' '.$student_info[0]->MiddleName.' '.$student_info[0]->LastName.' ('.$student_info[0]->code.'-'.$student_info[0]->yearlvl.')'];
                }else{
                    $data = ['error','PLEASE TRY AGAIN',''];
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

    public function init(){

         $this->load->module('admin_registrar/admin_reg');
        $this->admin->_check_login_registrar();
        $data['sem_sy'] =$this->template->get_sem_sy();
        $sem=$data["sem_sy"]["sem_sy"][0]->sem;
        $sy=$data["sem_sy"]["sem_sy"][0]->sy;

        $data['teacher_id'] = $this->session->userdata('id');
        $data['nav']=$this->admin_reg->_nav();
        $data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
        $data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
        $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;




        $data['scool_year'] = $this->admin_reg_model->get_schoolyear('sc.schoolyear');

        $data['set_sem'] = $sem;
        $data['set_sy'] = $sy;

        $data['grade_completion'] = $this->grade_completion_model->get_init();


        $data['tbody'] = $this->set_gc_tbodyx($data);


        $data['view_content']='grade_completion/view_all/init';
        $data['get_plugins_js']='grade_completion/view_all/js_init';

        $data['get_plugins_css']='grade_completion/view_all/css_init';
        $this->load->view('template/init_views',$data);
    }

    public function set_gc_tbodyx($data){
            $tr = '';
            $count = 0;
            foreach ($data['grade_completion'] as $key => $value) {

                $student_info = $this->student_model->get_student_infocie($value->studid,'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;
                $pic = 'assets/student_id/'.$value->studid.'.jpg';
                 $picx = '';
                if(file_exists($pic)){
                    $picx = '<img src="'.$pic.'" style="width:200px;" /> ';
                }


              $tr .= '<tr>
                        <td>'.$picx.'</td>
                        <td>'.$value->studid.'</td>
                        <td>'.$student_info[0]->LastName.', '.$student_info[0]->FirstName.'</td>
                        <td>'.$student_info[0]->code.' - '.$student_info[0]->yearlvl.'</td>
                    </tr>';
            }

            return $tr;
    }

}



