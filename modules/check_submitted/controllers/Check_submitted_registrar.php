<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Check_submitted_registrar extends MY_Controller {

	 function __construct()
    {
        parent::__construct();
        $this->load->model('admin_registrar/fg_only_model');
        $this->load->model('sched_record2/sched_record_model');
        $this->load->module('admin/admin');
         $this->load->module('admin_registrar/admin_reg');
		$this->load->model('admin/user_model');
		$this->load->model('check_submitted_model');
		$this->load->module('template/template');
		$this->load->model('template/template_model');
        $this->load->model('admin_registrar/admin_reg_model');

        $this->load->model('college_deans/college_deans_model');
        $this->load->model('subject/subject_enrollees_model');
        $this->load->model('sched_grades/sched_grades_model');
        $this->load->model('student/student_model');
        $this->load->model('sched_record2/grade_submission_model');
        $this->load->model('teachersched/sched_model');

        $this->load->module('sched_grades/sched_grades');
        $this->load->module('sched_grades/sched_grades_checker');
        $this->load->library('encryption');
        $this->encryption->initialize(
                                            array(
                                                    'cipher' => 'aes-256',
                                                    'mode' => 'OFB',
                                                    'key' => base64_encode('0-124356879-0'),
                                            )
                                    );

    }



    public function export_pdf(){
         $this->admin->_check_login_and_registrar();

        $sched_id = $this->encryption->decrypt($this->input->post('sched_id', TRUE)) ;

        if($sched_id){
            $this->sched_grades->gradesssss($sched_id,true,$this->input->post('print_this', TRUE));
        }else{
            redirect('/student_grades/student_faculty_grades/student_list/');
        }
    }

    public function  get_all_subjects(){


        $data['teacher_id'] = $this->session->userdata('id');


        $data['sem_sy']=$this->template->get_sem_sy();
        $sem=$data["sem_sy"]["sem_sy"][0]->sem;
        $sy=$data["sem_sy"]["sem_sy"][0]->sy;

         if(isset($_SESSION['new_sem_Sy'])){
            $new_sem_Sy = $this->session->new_sem_Sy;
            $sem=$new_sem_Sy['sem'];
            $sy=$new_sem_Sy['sy'];
        }else{
             $new_sem_Sy = array(
                            'sem' => $sem,
                            'sy' => $sy
                            );
            $this->session->set_userdata('new_sem_Sy',$new_sem_Sy);
        }
        $data['scool_year'] = $this->admin_reg_model->get_schoolyear('sc.schoolyear');

        $data['set_sem'] = $sem;
        $data['set_sy'] = $sy;

        $data['nav']=$this->admin_reg->_nav();
        $data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
        $data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
        $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
        $data['teacher_dean'] = $this->college_deans_model->get_teacher_deans( $this->session->userdata('staff_id') );

        $table = [];
        $get_courses = $this->check_submitted_model->dept_courses_all( );
        $search['type'] = 's.courseid';
        foreach ($get_courses as $key => $course) {
            $search['value'] = $course->courseid;
            array_push($table,$this->set_se_tbody($sem,$sy,$search));
        }


        $data['table'] = $table;

        $data['view_content']='check_submitted/subject_list_test';
        $data['get_plugins_js']='check_submitted/registrar_plugins_js';
        $data['get_plugins_css']='check_submitted/plugins_css';
        $this->load->view('template/init_views',$data);
    }

  public function set_se_tbody($sem,$sy,$search_text = ""){

        $this->load->model('subject/subject_enrollees_model');
        $data['aaData']= $this->subject_enrollees_model->get_subjects_search($search_text,$sem,$sy);
         $data["table"] = '';
        if(count($data['aaData']) > 0 ):
                        $data["table"] = '
                                <div class="table-responsive">
                                <table class="table table-bordered subject_listx" id="dataTables-example_'.$search_text['value'].'">
                                    <thead>
                                        <tr>
                                            <th>Curr & Section</th>
                                            <th>Course & Year</th>
                                            <th>Assigned Teacher</th>
                                            <th>Course No</th>
                                            <th>Descriptive Title</th>
                                            <th>Units</th>
                                            <th>Days</th>
                                            <th>Time</th>
                                            <th>Room</th>
                                            <th>Section</th>
                                            <th>Enrolled</th>
                                            <th>view grades</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        for($x=0;$x<count($data['aaData']);$x++){
                            $countxy =$search_text["type"] ;
                                $enc_sched_id =     $this->encryption->encrypt($data['aaData'][$x]->schedid);

                                if( $this->sched_grades_model->get_grade_review( $data['aaData'][$x]->schedid ) ){
                                    $get_grade_review = $this->sched_grades_model->get_grade_review( $data['aaData'][$x]->schedid );

                                    if( ( $get_grade_review[0]->requ_prelim != NULL && $get_grade_review[0]->requ_prelim_remarks != NULL ) ||  ( $get_grade_review[0]->requ_midterm != NULL && $get_grade_review[0]->requ_midterm_remarks != NULL ) ||  ( $get_grade_review[0]->requ_tentative != NULL && $get_grade_review[0]->requ_tentative_remarks != NULL ) || ( $get_grade_review[0]->requ_final != NULL && $get_grade_review[0]->requ_final_remarks != NULL ) ) {
                                        $view = '<button onclick="$(this).checkreviewGrade(\''.$enc_sched_id .'\');" class="btn btn-danger btn-sm" > requesting for updates</button>';
                                    }else{
                                         $view = '<button onclick="$(this).checkreviewGrade(\''.$enc_sched_id .'\');" class="btn btn-primary btn-sm" > view</button>';
                                    }

                                 }else{
                                    $check_notify = $this->check_submitted_model->get_notify( $data['aaData'][$x]->schedid );
                                    if($check_notify){
                                        if( $check_notify[0]->prelim != NULL || $check_notify[0]->midterm != NULL || $check_notify[0]->tentative != NULL ){
                                            $view = '<button   onclick="$(this).checkreviewGrade(\''.$enc_sched_id .'\');"  class="btn btn-info btn-sm"  > notified</button>';
                                        }else{
                                            $view = '';
                                        }
                                    }else{
                                         $view = '';
                                    }

                                 }
                                        $teacher = $this->subject_enrollees_model->get_teacher($data['aaData'][$x]->schedid,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName),t.id")?$this->subject_enrollees_model->get_teacher($data['aaData'][$x]->schedid,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName) AS fullname,t.id")[0]->fullname:'<span class="label label-danger">Not Assigned</span>';
                                        $time = ($data['aaData'][$x]->start)?date('h:i A', strtotime($data['aaData'][$x]->start)).'-'.date('h:i A', strtotime($data['aaData'][$x]->end)) : '-';
                                        $count_studs = $this->subject_enrollees_model->count_subject_student($data['aaData'][$x]->schedid,$sem,$sy,'s.studentid');


                                        $data["table"] .='<tr>
                                        <td>'.$data['aaData'][$x]->acadyear.', <br /> '.$data['aaData'][$x]->section.'</td>
                                        <td>'.$data['aaData'][$x]->code.' - '.$data['aaData'][$x]->yearlvl.'</td>
                                        <td class="text-center">'.($teacher).'</td>
                                            <td>'.$data['aaData'][$x]->courseno.'</td><td>'.$data['aaData'][$x]->description.'</td><td>'.$data['aaData'][$x]->totalunits.'</td><td>'.$data['aaData'][$x]->days.'</td><td>'.$time.'</td><td>'.$data['aaData'][$x]->room.'</td><td>'.$data['aaData'][$x]->section.'</td>
                                                <td> '.$count_studs.'
                                                    </td>
                                                <td style="text-align:center;">'.$view.'
                                                    </td>
                                                </tr>
                                                ';
                        }

                                $data["table"] .='</tbody></table></div>';
            endif;
                return $data;
            }


            public function submitted(){
                $sched_id = $this->encryption->decrypt($this->input->post('data_key')) ;
                if( $this->sched_grades_model->get_grade_review( $sched_id ) ){
                    echo json_encode([1,'success',$sched_id]);
                }else{
                    echo json_encode([0,'No grades has been submitted!.',$sched_id]);
                }
            }

            public function submitted_notify(){
                 $sched_id = $this->encryption->decrypt($this->input->post('data_key')) ;
                if( $this->sched_grades_model->get_grade_review( $sched_id ) ){
                    echo json_encode([1,'The Grades Has been submitted no need to notify.']);
                }else{
                    echo json_encode([0,'Continue to notify the Teacher to submit Grades?']);
                }
            }

            public function view_grades(){
                // $sched_id = $this->encryption->decrypt($this->input->get('data_key')) ;
                $sched_id = $this->input->get('data_key') ;
                if($sched_id != 'undefined'){
                     // $this->sched_grades->gradesssss($sched_id,false);


                        $enc_sched_id =     $this->input->get('data_key');
                        $data["sched_id"] =  $sched_id;
                        $data["enc_sched_id"] =  $this->encryption->encrypt($this->input->get('data_key'));
                        $data['subject_info'] =$this->sched_record_model->get_sched_info('',$sched_id);
                        $data['subject_info2'] =$this->sched_model->get_schedteacher_info('',$data['subject_info']['sched_query'][0]->coursecode);
                        $data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);


                        $data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
                        $data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
                        $data['check_sched']['teacher_adviser']= $data['subject_info3'];

                        $data['smpt'] = $this->sched_grades_checker->summer_pmtf($data['check_sched']);

                        $data['checker'] = $this->sched_grades_checker->check_subject_type($data['check_sched']);
                        $data['excel_list'] = $this->sched_grades_model->get_sched_excel_list($sched_id);

                        $check_fused = $this->subject_enrollees_model->check_fused($sched_id);
                        if($check_fused[0]->fuse==null){
                            $student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid');
                        }else{
                            $get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
                            $schedids = explode(",",$get_fused[0]->sched);
                            $test = array();
                            for($x=0;$x<count($schedids);$x++){
                                $aaData[$x]=$this->sched_record_model->get_student_list($schedids[$x],'s.studentid');
                                $test = array_merge($test,$aaData[$x]);
                            }
                            $student_list=$test;
                        }

                        $data['registrar'] = true;

                        $data['grade_submission']['p'] = $this->grades_submission_model->get_grade_submission($data['check_sched'][0]['schoolyear'],$data['check_sched'][0]['semester'],'p');
                        $data['grade_submission']['m'] = $this->grades_submission_model->get_grade_submission($data['check_sched'][0]['schoolyear'],$data['check_sched'][0]['semester'],'m');
                        $data['grade_submission']['tf'] = $this->grades_submission_model->get_grade_submission($data['check_sched'][0]['schoolyear'],$data['check_sched'][0]['semester'],'tf');
                        $data['check_submitted'] = $this->sched_grades_model->get_grade_review( $sched_id );
                        $data['table'] = $this->sched_grades->set_students_view($student_list,$sched_id,$data);
                        $data['tfoot'] = $this->set_tfoot($data);

                        $data['view_content']='check_submitted/sched_grades_record_registrar';
                        $data['get_plugins_js']='check_submitted/registrar_sched_grades_js';
                        $data['get_plugins_css']='check_submitted/sched_grades_css';
                        $this->load->view('template/init_view_windowed',$data);
                  }else{
                    $this->session->set_flashdata('error', ['Please refresh and try again. ']);
                    redirect('ViewSubmittedGradesRegistrar');
                  }
            }


            public function set_tfoot($data){

        $dean_tfoot = '<tr><td colspan="3">DATE APPROVED AND CHECKED BY DEAN</td>';
                $registrar_tfoot = '<tr><td colspan="3">DATE APPROVED AND CHECKED BY REGISTRAR</td>';
                $tfoot = '<tr><td colspan="3">DATE SUBMITTED</td>';
                if(!$data['checker']['fg_only']):
                    if($data['check_sched'][0]['semester'] !== 3){
                         if(  $data['check_submitted'][0]->requ_prelim != NULL && $data['check_submitted'][0]->checkdean_prelim != NULL && $data['check_submitted'][0]->checkregistrar_prelim != NULL  ){
                             $registrar_tfoot .=  '<td>
                                        </td>';
                        }elseif($data['check_submitted'][0]->submit_prelim != null && $data['check_submitted'][0]->checkdean_prelim != NULL && $data['check_submitted'][0]->checkregistrar_prelim == NULL){
                               $registrar_tfoot .=  '<td>
                                        </td>';
                        }else{
                            $nice_date_p = $data['check_submitted'][0]->checkregistrar_prelim ? '<button class="btn btn-warning" onclick="$(this).disApproved(\'prelim\',\''.$data["enc_sched_id"].'\');" >DISAPPROVE  PRELIM</button><br /><strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->checkregistrar_prelim,'M d, Y H:i').'</strong>' : "" ;
                            $registrar_tfoot .=     '<td>

                                                        '.$nice_date_p .'
                                                    </td>';
                        }
                        $tfoot .=   '<td>
                                            <strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_prelim,'M d, Y H:i').'</strong>
                                        </td>';
                        $dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_prelim,'M d, Y H:i') ) .'</strong></td>';
                    }
                endif;

                    if( ($data['check_submitted'][0]->submit_midterm != null && $data['check_submitted'][0]->checkdean_midterm != null && $data['check_submitted'][0]->checkregistrar_midterm == null)  || $data['check_submitted'][0]->requ_midterm != NULL ){
                            if(  $data['check_submitted'][0]->requ_midterm != NULL && $data['check_submitted'][0]->requ_midterm_remarks != NULL && $data['check_submitted'][0]->checkregistrar_midterm == NULL ){
                             $registrar_tfoot .=  '<td>
                                            <button class="btn btn-warning" onclick="$(this).approvedRequestUpdate(\'midterm\',\''.$data["enc_sched_id"].'\');" >APPROVE REQUEST UPDATE </button>
                                        </td>';
                            }elseif($data['check_submitted'][0]->submit_prelim != null && $data['check_sched'][0]['semester'] !== 3 && $data['check_submitted'][0]->checkdean_prelim != null && $data['check_submitted'][0]->checkregistrar_prelim != NULL && $data['check_submitted'][0]->checkregistrar_midterm == NULL  ){
                                $registrar_tfoot .=   '<td ><button class="btn btn-primary" onclick="$(this).approvedGRADEX(\'midterm\',\''.$data["enc_sched_id"].'\');" >APPROVE MIDTERM </button></td>';
                            }else{
                                $registrar_tfoot .=   '<td></td>';
                            }
                                $tfoot .=   '<td>
                                            <strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_midterm,'M d, Y H:i').'</strong>
                                        </td>';
                            $dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i') ) .'</strong></td>';
                    }else{
                            $nice_date_m = $data['check_submitted'][0]->checkregistrar_midterm ? ' <button class="btn btn-warning" onclick="$(this).disApproved(\'midterm\',\''.$data["enc_sched_id"].'\');" >DISAPPROVE  MIDTERM</button><br /><strong class="date-approve">'.nice_date($data['check_submitted'][0]->checkregistrar_midterm,'M d, Y H:i').'</strong>' : "";
                            $registrar_tfoot .=  '<td>'.$nice_date_m.'</td>';
                            $tfoot .=   '<td>
                                            <strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_midterm,'M d, Y H:i').'</strong>
                                        </td>';
                            $dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i')  ) .'</strong></td>';
                    }

                    if( ( $data['check_submitted'][0]->submit_tentative != null && $data['check_submitted'][0]->checkdean_tentative == null )  || $data['check_submitted'][0]->requ_tentative != NULL  ){
                            if(  $data['check_submitted'][0]->requ_tentative != NULL && $data['check_submitted'][0]->requ_tentative_remarks != NULL && $data['check_submitted'][0]->checkregistrar_tentative == NULL  ){
                             $registrar_tfoot .=  '<td>
                                            <button class="btn btn-warning" onclick="$(this).approvedRequestUpdate(\'tentative\',\''.$data["enc_sched_id"].'\');" >APPROVE REQUEST UPDATE </button>
                                        </td>';
                            }elseif($data['check_submitted'][0]->submit_midterm != null && $data['check_submitted'][0]->checkdean_midterm != null){
                                $registrar_tfoot .=   '<td><button class="btn btn-primary" onclick="$(this).approvedGRADEX(\'tentative\',\''.$data["enc_sched_id"].'\');" >APPROVE TENTATIVE</button></td>';
                            }else{
                                $registrar_tfoot .=   '<td></td>';
                            }
                           $tfoot .=   '<td>
                                            <strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->submit_tentative,'M d, Y H:i') ).'</strong>
                                        </td>';
                            $dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i')  ).'</strong></td>';
                    }else{
                            $nice_date_t = $data['check_submitted'][0]->checkregistrar_tentative ? '<button class="btn btn-warning" onclick="$(this).disApproved(\'tentative\',\''.$data["enc_sched_id"].'\');" >DISAPPROVE  TENTATIVE</button><br /><strong class="date-approve">'.nice_date($data['check_submitted'][0]->checkregistrar_tentative,'M d, Y H:i').'</strong>' : "";
                            $registrar_tfoot .=  '<td>

                                                        '. $nice_date_t .'</td>';
                            $tfoot .=   '<td>
                                            <strong class="date-approve">'.( $data['check_submitted'][0]->submit_tentative ? nice_date($data['check_submitted'][0]->submit_tentative,'M d, Y H:i') : "" ).'</strong>
                                        </td>';
                            $dean_tfoot .= '<td><strong class="date-approve">'.( $data['check_submitted'][0]->checkdean_tentative ? nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i') : "" ).'</strong></td>';
                    }



                        if( ($data['check_submitted'][0]->submit_final != NULL  && $data['check_submitted'][0]->checkdean_final == NULL  )  || $data['check_submitted'][0]->requ_final != NULL  ){
                            if(  $data['check_submitted'][0]->requ_final != NULL && $data['check_submitted'][0]->requ_final_remarks != NULL  && $data['check_submitted'][0]->checkregistrar_final == NULL ){
                             $registrar_tfoot .=  '<td  colspan="2">
                                            <button class="btn btn-warning" onclick="$(this).approvedRequestUpdate(\'final\',\''.$data["enc_sched_id"].'\');" >APPROVE REQUEST UPDATE </button>
                                        </td>';
                            }elseif($data['check_submitted'][0]->submit_tentative != null   && $data['check_submitted'][0]->checkdean_tentative != null){
                                $registrar_tfoot .=   '<td colspan="2"><button class="btn btn-primary" onclick="$(this).approvedGRADEX(\'final\',\''.$data["enc_sched_id"].'\');" >APPROVE FINAL</button></td>';
                            }else{
                                $registrar_tfoot .=   '<td colspan="2" ></td>';
                            }
                             $tfoot .='<td  colspan="2" ></td>';
                            $dean_tfoot .='<td  colspan="2" ></td>';
                        }else{
                            $nice_date_f = $data['check_submitted'][0]->checkregistrar_final ?  ' <button class="btn btn-warning" onclick="$(this).disApproved(\'final\',\''.$data["enc_sched_id"].'\');" >DISAPPROVE  FINAL</button><br /><strong class="date-approve">'.nice_date($data['check_submitted'][0]->checkregistrar_final,'M d, Y H:i').'</strong>' : "";
                            $registrar_tfoot .=  '<td colspan="2" >

                                                                   '.$nice_date_f.'</td>';
                            $tfoot .=   '<td  colspan="2">
                                            <strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->submit_final,'M d, Y H:i')  ).'</strong>
                                        </td>';
                            $dean_tfoot .= '<td  colspan="2" ><strong  class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_final,'M d, Y H:i')  ).'</strong></td>';
                        }
                $dean_tfoot .= ' </tr>';
                $registrar_tfoot .= ' </tr>';

                $tfoot .= ' </tr>';


                return $tfoot.$dean_tfoot.$registrar_tfoot;


    }

    public function change_sem_sy(){
        $sem = $this->input->post("set_sem",TRUE);
        $sy = $this->input->post("set_sy",TRUE);
        $new_sem_Sy = array(
                            'sem' => $sem,
                            'sy' => $sy
                            );
        $this->session->set_userdata('new_sem_Sy',$new_sem_Sy);
        echo json_encode('changing');
    }

    public function download_excel(){
        $sched_id = $this->encryption->decrypt($this->input->post('sched_id',TRUE));
        $file_id = $this->encryption->decrypt($this->input->post('excel_file',TRUE)) ;

            if($this->sched_grades_model->get_sched_excel1($file_id)){
                $excel = $this->sched_grades_model->get_sched_excel1($file_id);
                $fileDir = $excel[0]->file_path.$excel[0]->excel_file.$excel[0]->file_extension;
                $contents = file_get_contents($fileDir);
                if($excel[0]->file_extension == '.xlsx'){
                    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                }else{
                    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
                }
                header('Content-Disposition: attachment; filename="'.$excel[0]->excel_file.$excel[0]->file_extension.'"');

                echo $contents;

                die();
            }else{
                $enc_sched_id =     $this->encryption->encrypt($sched_id);
                redirect("check_submitted/view_grades?data_key=".$enc_sched_id);
            }


    }


    public function set_students($student_list,$sched_id,$data){
        $list = '';
        $count = 1;
        for($x=0;$x<count($student_list);$x++){
                        $student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
                        $midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';



                        $list .= '
                            <tr>
                              <td>'.$count.'</td>
                              <td class="student_lfm" >'.$student_list[$x]->studentid.'</td>
                              <td class="student_lfm" >'.$student_lfm[0]->lastname.", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme.'</td>
                              '.$this->get_grades($sched_id,$student_list[$x]->studentid,$data ).'
                            </tr>
                              '
                              ;
                              $count++;
        }

        return $list;
    }

    public function get_grades($sched_id,$studentid,$data){
        $grades_list = '';
        $table_e_f = 'pcc_student_final_grade';
        $grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$studentid,'');
        $student_remarks_r = '';
                $student_remarks='<option value=""></option>';
                if($this->grade_submission_model->get_stud_fgrades( $sched_id,$studentid,'')){
                    $r = $this->grade_submission_model->get_stud_fgrades( $sched_id,$studentid,'');
                    $r = ($r[0]->remarks!=NULL)?$r[0]->remarks:'';
                    $student_remarks = '<option value="'.$r.'">'.$r.'</option>';

                    if(isset($data['check_submitted'][0]) && $data['check_submitted'][0]->submit_final != null){
                                                $student_remarks = $r;
                    }


                    $student_remarks_r = $r;
                }


                if($data['check_sched'][0]['semester'] !== 3){
                    $grades_list .= $this->prelim_g($sched_id,$studentid,$data['check_submitted'],$grades);
                }
                $grades_list .= $this->midterm_g($sched_id,$studentid,$data['check_submitted'],$grades);
                $grades_list .= $this->tenta_g($sched_id,$studentid,$data['check_submitted'],$grades);
                $remarks = $this->remarks_g($sched_id,$studentid,$student_remarks_r,$student_remarks,$data,$grades);
        $grades_list .='<td id="'.$studentid.'_'.$sched_id.'_final" class="'.$remarks['class'].'" >'.$remarks['final'].'</td>';
        $grades_list .='<td class="'.$remarks['class'].'" >'.$remarks['remarks'].'</td>';
        return $grades_list;

    }


    public function prelim_g($sched_id,$studentid,$check_submitted,$grades){
            $prelim = (isset($grades[0]->prelim) ? $grades[0]->prelim : 0 );
            $class = "failed";
            if($prelim >=75 ){
                $class = "passed";
            }
                     $grades_list = '<td><div class="input-group col-md-10 col-md-offset-1 '.$class.' " > '. $prelim .' </div></td>';
                    return $grades_list;
    }

    public function midterm_g($sched_id,$studentid,$check_submitted,$grades){
        $midterm = (isset($grades[0]->midterm) ? $grades[0]->midterm : 0 );
            $class = "failed";
            if($midterm >=75 ){
                $class = "passed";
            }
                    $grades_list = '<td><div class="input-group col-md-10 col-md-offset-1 '.$class.' " > '. $midterm .' </div></td>';
                    return $grades_list;
    }

    public function tenta_g($sched_id,$studentid,$check_submitted,$grades){
         $tentativefinal = (isset($grades[0]->tentativefinal) ? $grades[0]->tentativefinal : 0 );
            $class = "failed";
            if($tentativefinal >=75 ){
                $class = "passed";
            }

                     $grades_list = '<td><div class="input-group col-md-10 col-md-offset-1 '.$class.' " > '. $tentativefinal .' </div></td>';
                    return $grades_list;
    }

    public function remarks_g($sched_id,$studentid,$student_remarks_r,$student_remarks,$data,$grades){
        $final = 0;
        $div =2;

        if($data['check_sched'][0]['semester'] !== 3){ $div =3; }
        if(isset($grades[0]->midterm)){
         $final = ( $grades[0]->midterm + $grades[0]->tentativefinal) ;
        }
        if(isset($grades[0]->prelim)){
                $final = ($grades[0]->prelim + $final) ;
        }
        $final = $final/$div;

        if($final>=75 || $final<73){
            $final=round( $final,0 );
        }else{
            if($student_remarks_r == 'Passed'){
                $final=75;
            }else{
                $final=floor( $final );
            }
        }

        if($final>=75){ $d['class'] ='passed'; }
        else{   $d['class']='failed'; }

        $d['final'] =   $final;
        $d['remarks'] =  $student_remarks;
                    switch ($student_remarks_r) {

                    case 'No Final Examination':
                            $d['final'] =   'NFE';
                        break;
                    case 'No GRADE':
                            $d['final'] ='NG';
                        break;

                    case 'Officially Dropped':
                            $d['final'] ='ODRP';
                        break;

                    case 'Unofficially Dropped':
                            $d['final'] ='UDRP';
                        break;

                    case 'Incomplete':
                            $d['final'] ='INC';
                        break;

                    case 'No CREDIT':
                            $d['final'] ='NC';
                        break;

                    case 'DROPPED':
                            $d['final'] ='DRP';
                        break;

                    case 'Withdrawal with Permission':
                            $d['final'] ='Withdrawal/P';
                        break;

                    default:
                        break;
                }

                return $d;
    }




    public function submit_grade_review(){
        $sched_id = $this->encryption->decrypt($this->input->post('sched_id')) ;
        $type = $this->input->post('type') ;

        if($sched_id && type_grade($type)  ){
            $dean = $this->session->userdata('staff_id');
            if( $this->sched_grades_model->checkregistrar_grade_review( $sched_id, $dean ,$type ) ){
                 echo json_encode([1,  'You have successfully approved '.$type.' GRADES this will be submitted to Registrar for another checking.' ]);
             }else{
                echo json_encode([0,  'Please reload page and try again'  ]);
             }

        }else{
            echo json_encode([0,  'Please reload page and try again'  ]);
        }

    }

    public function _check_login_dean(){

            if($this->college_deans_model->get_teacher_deans($this->session->userdata('staff_id')) ){
                return TRUE;
            }else{
               return redirect(ROOT_URL.'modules/admin/logout');
            }
    }

    public function sent_notify(){
         $sched_id = $this->encryption->decrypt($this->input->post('data_key')) ;
         if($sched_id){
             $dean = $this->session->userdata('staff_id');
            if( $this->check_submitted_model->get_notify( $sched_id ) ){
                 $type = $this->input->post('type') ;
                 if(type_grade($type)){
                    if($this->check_submitted_model->set_notify( $sched_id , $type )){
                        echo json_encode([1,  'You have successfully notified the instructor/teacher to submit there grades.' ]);
                    }else{
                        echo json_encode([0,  'Please reload page and try again'  ]);
                    }
                }else{
                    echo json_encode([0,  'Please reload page and try again'  ]);
                }

             }else{
                $data = [
                            'sched_id' => $sched_id,
                            'prelim' => mdate('%Y-%m-%d %h:%i:%s'),
                            'date_created' => mdate('%Y-%m-%d %h:%i:%s'),
                        ];

                if($this->check_submitted_model->insert_notify( $data )){
                    echo json_encode([1,  'You have successfully notified the instructor/teacher to submit there grades.' ]);
                }else{
                    echo json_encode([0,  'Please reload page and try again'  ]);
                }

             }
         }else{
            echo json_encode([0,  'Please reload page and try again'  ]);
         }
    }


    public function submit_grade_request_approved(){
         $sched_id = $this->encryption->decrypt($this->input->post('sched_id',TRUE)) ;

          if($sched_id){
                $dean = $this->session->userdata('staff_id');
                $dean_id =  $this->session->userdata('id');
                $type = $this->input->post('type',TRUE) ;
                $message = $this->input->post('message',TRUE) ;
                if(type_grade($type)){
                    $get_grade_review = $this->sched_grades_model->get_grade_review( $sched_id );
                    $message_enc = json_decode($get_grade_review[0]->{'requ_'.$type.'_remarks'});
                    $key = count($message_enc);
                    $message_enc[$key] = array(
                            'user_id' => $dean_id,
                            'type' => $type,
                            'who' => 'dean',
                            'date' => date('Y-m-d H:i:s'),
                            'remarks' => $message
                        );
                    $message_enc = json_encode($message_enc);

                    if($this->check_submitted_model->approved_grade_request_update( $sched_id , $type ,$message_enc)){
                        echo json_encode([1,  'You have successfully granted the instructor/teacher to update there grades.' ]);
                    }else{
                        echo json_encode([0,  'Please reload page and try again0'  ]);
                    }
                }else{
                    echo json_encode([0,  'Please reload page and try again1'  ]);
                }
          }else{
            echo json_encode([0,  'Please reload page and try again2'  ]);
         }
    }


    public function get_request_remarks(){
        $sched_id = $this->encryption->decrypt($this->input->post('sched_id',TRUE)) ;
        $type = $this->input->post('type',TRUE) ;
          if($sched_id){
                $get_grade_review = $this->sched_grades_model->get_grade_review( $sched_id );
                $message_enc = json_decode($get_grade_review[0]->{'requ_'.$type.'_remarks'});
                 $remarks_c = '';
                foreach ($message_enc as $key => $value) {
                    $name = $this->user_model->get_user_info($value->user_id,"CONCAT(LastName,', ',FirstName,' ',MiddleName) as name");
                    if( $value->user_id == $this->session->userdata('id')){
                         $remarks_c .=  '
                                      <div class="alert  messaging-left"  >
                                               <small>'.$this->session->userdata('name').' '.nice_date($value->date,'M d, Y H:i').'</small><br />
                                              <p>'. $value->remarks.'</p>
                                      </div>
                                  ';
                    }else{
                     $remarks_c  .= '
                                          <div class="alert messaging-right" >
                                                  <small>'.$name[0]->name.' '.nice_date($value->date,'M d, Y H:i').'</small><br />
                                                  <p>'. $value->remarks.'</p>
                                          </div>
                                      ';
                    }
                }

            echo json_encode([1,  '<div class="message-container" >'.$remarks_c.'</div>'  ]);
          }else{
            echo json_encode([0,  'Please reload page and try again2'  ]);
         }
    }


}
