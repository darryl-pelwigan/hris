<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grades_submission extends MY_Controller {


     function __construct()
    {
        parent::__construct();
        $this->load->model('sched_record_model');
        $this->load->model('grade_submission_model');
        $this->load->model('admin/user_model');
        $this->load->module('admin/admin');
         $this->load->module('sched_record2');
        $this->load->model('admin/user_model');
        $this->load->module('template/template');
        $this->load->model('template/template_model');
        $this->admin->_check_login();
    }



    public function check_grades_submitting(){
       $data['sem_sy'] =$this->session->userdata('new_sem_Sy');
        $type2 = $this->input->post('type2',true);
        $type = $this->input->post('type',true);
        $sched_id = $this->input->post('sched_id',true);
        $leclab = $this->input->post('leclab',true);
        $comp_type = $this->input->post('comp_type',true);
        $type_d = $this->type_d($type2,$leclab);
        $teacher_id = $this->session->userdata('id');
        $table_e_f = $this->set_table($teacher_id,$sched_id,$type);
    if($table_e_f=='pcc_gs_student_gradeslec' ){
        $data['type_d'][0] = $type_d[0];
        $data['grades'] = $this->grade_submission_model->get_grades_lec($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.'.$type_d[0].',sg.final_remarks');
         $this->load->view('sched_record2/grade_submission',$data);
    }elseif($table_e_f=='pcc_gs_student_gradesleclab'  && $comp_type =='fgradeonly'){
        $data['type_d'][0] = 'final';
          $data['grades'] = $this->grade_submission_model->get_grades_leclab($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.final,sg.final_remarks');
                $this->load->view('sched_record2/grade_submission_final',$data);
    }else{
        $type_d = $this->type_d($type2,1);
        $percentage = $this->grade_submission_model->get_sched_leclabp($sched_id);
        if(isset($percentage[0]->percentage)){
             $percentage=json_decode($percentage[0]->percentage);
                $data['lec']=$percentage->{'lec'}/100;
                $data['lab']=$percentage->{'lab'}/100;
        }else{
	$this->session->set_flashdata('error', 'Please Set  <a href="#" class="btn btn-info" data-toggle="modal" data-target="#percentage_modal">Change Percentage</a> ');
            $data['lec']=0;
            $data['lab']=0;
        }

        $data['type_d'][0] = $type_d[0];
        $data['type_d'][1] = $type_d[1];

         if( $comp_type === 'gradeonlyleclab'){
             $data['grades'] = $this->grade_submission_model->get_grades_leclab($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.prelim,sg.midterm,sg.tentativefinal,sg.final_remarks');
            $this->load->view('sched_record2/grade_submission_final_leclab',$data);
        }else{
              $data['grades'] = $this->grade_submission_model->get_grades_leclab($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.'.$type_d[0].',sg.'.$type_d[1].',sg.final_remarks');
            $this->load->view('sched_record2/grade_submission_leclab',$data);
        }
    }
        return ;
    }



    public function set_table($teacher_id,$sched_id,$type){
        $check_sched = $this->sched_record2->get_check_sched($teacher_id,$sched_id);
        $labunits = $check_sched['labunits'];
        $lecunits = $check_sched['lecunits'];

        $table_e_f=( $labunits>0)?'pcc_gs_student_gradesleclab':'pcc_gs_student_gradeslec';

        if($lecunits==0 && $labunits>0 ){
                if(substr($type ,0,1)=='t' || substr($type ,1,1)=='t')
                    $type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
                else
                    $type= (substr($type ,0,1)=='l'?substr($type ,1,2):$type);
            $table_e_f='pcc_gs_student_gradeslec';
        }

        return $table_e_f;
    }


    public function sent_grades_registrar(){
        $type2 = $this->input->post('type2',true);
        $type = $this->input->post('type',true);
        $sched_id = $this->input->post('sched_id',true);
        $leclab = $this->input->post('leclab',true);
        $comp_type = $this->input->post('comp_type',true);
        $type_d = $this->type_d($type2,$leclab);
        $get_gradeupdate_request = $this->grade_submission_model->get_gradeupdate_requestx( $sched_id , $this->session->userdata('id') , $type );
                if($get_gradeupdate_request){
                    if($get_gradeupdate_request[0]->status!=1){
                        $this->grade_submission_model->update_gradeupdate_request_idxx($get_gradeupdate_request[0]->id);
                    }
                }

        $teacher_id = $this->session->userdata('id');

        $table_e_f = $this->set_table($teacher_id,$sched_id,$type);

        if($table_e_f=='pcc_gs_student_gradeslec' && $comp_type !='fgradeonly' ){
            $grades = $this->grade_submission_model->get_grades_lec($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.'.$type_d[0].'');
            $count = 0;
            for($x=0;$x<count($grades);$x++){
                $data = array(
                                'student_id' => $grades[$x]->studid,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                $type_d[0] => $grades[$x]->{$type_d[0]},
                            );
                if($this->grade_submission_model->get_stud_fgrades($sched_id,$grades[$x]->studid,$type_d)){
                    $this->grade_submission_model->update_grades($sched_id,$grades[$x]->studid,$type_d[0],$grades[$x]->{$type_d[0]});
                }else{
                    $this->grade_submission_model->insert_grades($data);
                }
            }
        }elseif($table_e_f=='pcc_gs_student_gradesleclab'  && $comp_type =='fgradeonly'){
            $type_d[0] = 'final';
            $grades = $this->grade_submission_model->get_grades_leclab($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.final');
             for($x=0;$x<count($grades);$x++){
                $total =  $grades[$x]->{$type_d[0]};
                $data = array(
                                'student_id' => $grades[$x]->studid,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                $type_d[0] => $total,
                            );

                 if($this->grade_submission_model->get_stud_fgrades($sched_id,$grades[$x]->studid,$type_d)){
                    $this->grade_submission_model->update_grades($sched_id,$grades[$x]->studid,$type_d[0],$total);
                }else{
                    $this->grade_submission_model->insert_grades($data);
                }
            }
        }elseif($table_e_f=='pcc_gs_student_gradeslec'  && $comp_type =='fgradeonly'){
            $type_d[0] = 'final';
            $grades = $this->grade_submission_model->get_grades_lec($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.final');

             for($x=0;$x<count($grades);$x++){
                $total =  $grades[$x]->{$type_d[0]};
                $data = array(
                                'student_id' => $grades[$x]->studid,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                $type_d[0] => $total,
                            );

                 if($this->grade_submission_model->get_stud_fgrades($sched_id,$grades[$x]->studid,$type_d)){
                    $this->grade_submission_model->update_grades($sched_id,$grades[$x]->studid,$type_d[0],$total);
                }else{
                    $this->grade_submission_model->insert_grades($data);
                }
            }
        }elseif($table_e_f=='pcc_gs_student_gradesleclab'  && $comp_type =='gradeonlyleclab'){
            $sched_inf = $this->sched_record_model->get_sched_info($this->session->userdata('id'),$sched_id );
            $grades = $this->grade_submission_model->get_grades_leclab($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.prelim,sg.midterm,sg.tentativefinal');
            $div = 3 ;

            if($sched_inf['sched_query'][0]->semester === 3 ){
                $div = 2 ;
            }
             for($x=0;$x<count($grades);$x++){
                $grade['pre'] = $grades[$x]->prelim ? $grades[$x]->prelim : 0 ;
                $grade['mid'] =  $grades[$x]->midterm;
                $grade['tf'] =  $grades[$x]->tentativefinal ? $grades[$x]->tentativefinal : 0 ;
                $grade['final'] = ($grade['tf'] +  $grade['mid'] + $grade['pre'] ) / $div;
                $data = array(
                                'student_id' => $grades[$x]->studid,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                 'prelim' => $grade['pre'],
                                'midterm' => $grade['mid'],
                                'tentativefinal' => $grade['tf'],
                                'final' => $grade['final'],
                            );

                if($this->grade_submission_model->get_stud_fgrades($sched_id,$grades[$x]->studid,$type_d)){
                    $this->grade_submission_model->update_grades_pmtf($sched_id,$grades[$x]->studid,$grade);
                }else{
                    $this->grade_submission_model->insert_grades($data);
                }
            }
        }else{
            if($comp_type == 'intern' || $comp_type == 'fgradeonly'){
                $data['type_d'][0] = $type_d[0]='final';
                $checkers = 1;
            }else{
                $checkers = 0;
                    $check_sched = $this->sched_record2->get_check_sched($teacher_id,$sched_id);
                    $sched_info=$this->sched_record_model->get_subject_exam($check_sched['lecunits'],$check_sched['labunits'] , '' ,$sched_id , $type );
                    $p['lec']=0;
                    $p['lab']=0;
                if($sched_info['exam_query'] && $sched_info['exam_query'][0]->percentage){
                    $percentage=json_decode($sched_info['exam_query'][0]->percentage);
                    $p['lec']=$percentage->{'lec'};
                    $p['lab']=$percentage->{'lab'};
                }
            }

            $grades = $this->grade_submission_model->get_grades_leclab($sched_id,'sg.schedid,r.lastname,r.firstname,r.middlename,r.namesuffix,r.studid,sg.'.$type_d[0].',sg.'.$type_d[1].'');
             for($x=0;$x<count($grades);$x++){
                if($checkers === 0){
                    $lec_g = ($grades[$x]->{$type_d[0]}*$p['lec'])/100;
                    $lab_g = ($grades[$x]->{$type_d[1]}*$p['lab'])/100;
                    $total =  $lec_g +  $lab_g;
                }else{
                    $total =  $grades[$x]->{$type_d[0]} +  $grades[$x]->{$type_d[1]};
                }


                $data = array(
                                'student_id' => $grades[$x]->studid,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                $type_d[0] => $total,
                            );

                if($this->grade_submission_model->get_stud_fgrades($sched_id,$grades[$x]->studid,$type_d)){
                    $this->grade_submission_model->update_grades($sched_id,$grades[$x]->studid,$type_d[0],$total);
                }else{
                    $this->grade_submission_model->insert_grades($data);
                }
            }
        }


    }

    public function check_update_grades_registrar(){
        $reason = $this->input->post('reason',true);
        $type2 = $this->input->post('type2',true);
        $type = $this->input->post('type',true);
        $sched_id = $this->input->post('sched_id',true);
        $leclab = $this->input->post('leclab',true);
        $comp_type = $this->input->post('comp_type',true);
        $type_d = $this->type_d($type2,$leclab);
        $teacher_id = $this->session->userdata('id');
        $data['request'] = '';
        if($this->grade_submission_model->get_gradeupdate_request($sched_id,$teacher_id,$type)){
            $data['request'] = $this->grade_submission_model->get_gradeupdate_request($sched_id,$teacher_id,$type,"gu_req.*, sc.courseno, sc.description , CONCAT(s.LastName,', ',s.FirstName,' ',s.MiddleName) as name");
            $request = $data['request'];
            $data['remarks_c'] = '';
             if($request[0]->remarks==''){
                        $data['remarks_c'] .= 'no remarks';
                }else{
                    $remarks = json_decode($request[0]->remarks,true);
                    for($x=0;$x<count($remarks);$x++){
                         if( $remarks[$x]['user_id'] == $this->session->userdata('id')){
                                $data['remarks_c'] .=  '
                                      <div class="alert  messaging-left"  >
                                              <small>'.$this->session->userdata('name').'</small><br />
                                              <p>'. $remarks[$x]['remarks'].'</p>
                                      </div>
                                  ';
                          }else{
                            $name = $this->user_model->get_user_info($remarks[$x]['user_id'],"CONCAT(LastName,', ',FirstName,' ',MiddleName) as name");
                                $data['remarks_c'] .= '
                                          <div class="alert messaging-right" >
                                                  <small>'.$name[0]->name.'</small><br />
                                                  <p>'. $remarks[$x]['remarks'].'</p>
                                          </div>
                                      ';
                          }
                    }
                }
        }
        $this->load->view('sched_record2/check_gradesupdate_submission',$data);
    }

    public function sent_update_grades_registrar(){
        $reason = $this->input->post('reason',true);
        $type2 = $this->input->post('type2',true);
        $type = $this->input->post('type',true);
        $sched_id = $this->input->post('sched_id',true);
        $leclab = $this->input->post('leclab',true);
        $request_id = $this->input->post('request_id',true);
        $comp_type = $this->input->post('comp_type',true);
        $type_d = $this->type_d($type2,$leclab);
        $teacher_id = $this->session->userdata('id');
        if($this->grade_submission_model->get_gradeupdate_request($sched_id,$teacher_id,$type)){
            $request = $this->grade_submission_model->get_gradeupdate_request($sched_id,$teacher_id,$type);
            if( ($request[0]->remarks)=='' || $request[0]->remarks==null){
                 $data[0] = array(
                            'user_id' => $teacher_id,
                            'date' => date('Y-m-d H:i:s'),
                            'remarks' => $reason
                        );
            }else{
                $data = json_decode($request[0]->remarks,true);
                $key = count($data);
                $data[$key] = array(
                            'user_id' => $teacher_id,
                            'date' => date('Y-m-d H:i:s'),
                            'remarks' => $reason
                        );
            }
            if($request_id!=0){
               echo $this->grade_submission_model->update_gradeupdate_request_idx($request_id,$data);
            }else{
               echo $this->grade_submission_model->update_gradeupdate_request($sched_id,$teacher_id,$type,$data);
            }
        }else{
         echo   $this->grade_submission_model->insert_gradeupdate_request($sched_id,$teacher_id,$type,$reason);
        }
    }


    public function add_remarks_grade(){
         $sched_id = $this->input->post('sched_id',true);
         $student_id = $this->input->post('student_id',true);
         $remarks = $this->input->post('remarks',true);
         $teacher_id = $this->session->userdata('id');

        $teacher_id = $this->session->userdata('id');

        $table_e_f = $this->set_table($teacher_id,$sched_id,'');
        $type_d[8] = 'final_remarks';
        if($this->sched_record_model->get_student_finalgrade( $student_id , $sched_id , 'final_remarks' , $table_e_f)){
            $this->sched_record_model->update_student_finalgrade( $student_id , $sched_id , $type_d , $table_e_f, $remarks );
        }else{
            $this->sched_record_model->insert_student_finalgrade( $student_id , $sched_id , $type_d , $table_e_f, $remarks );
        }

         $data = array(
                                'student_id' => $student_id,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                'remarks'=> $remarks,
                            );



        if($this->grade_submission_model->get_stud_fgrades($sched_id,$student_id,'remarks')){
            $this->grade_submission_model->update_grades($sched_id,$student_id,'remarks',$remarks);
        }else{
            $this->grade_submission_model->insert_grades($data);
        }

    }



    public function type_d($type,$leclab){
        switch($type){
                case 'p' :
                        $type_d[0] = 'prelim';
                        break;
                case 'm' :
                        $type_d[0] = 'midterm';
                        break;
                case 'tf' :
                        $type_d[0] = 'tentativefinal';
                        break;
                default :
                        $type_d[0] = 'final';
                        break;
        }
    if($leclab>0){
         $type_d[1] = 'lab_'.$type_d[0];
    }
    return $type_d;

    }
}
