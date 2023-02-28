<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_grades extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->module('template/template');
        $this->load->module('admin_registrar/admin_reg');
        $this->load->model('admin_registrar/admin_reg_model');
        $this->load->model('admin_registrar/grades_submission_model');
         $this->load->model('sched_record2/grade_submission_model');
         $this->load->model('sched_record2/sched_record_model');
        $this->admin_reg->_check_login();
    }

    public function deapartment(){

       $data['nav']=$this->admin_reg->_nav();
        $data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
        $data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
        $data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
        $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
        $data['sem_sy']=$this->template->get_sem_sy();
        $sem=$data["sem_sy"]["sem_sy"][0]->sem;
        $sy=$data["sem_sy"]["sem_sy"][0]->sy;

        if(isset($_SESSION['new_sem_Sy'])){
            $new_sem_Sy = $this->session->new_sem_Sy;
            $sem=$new_sem_Sy['sem'];
            $sy=$new_sem_Sy['sy'];
        }
        $data['scool_year'] = $this->admin_reg_model->get_schoolyear('sc.schoolyear');
        
        $data['set_sem'] = $sem;
        $data['set_sy'] = $sy;
        $data['table']= $this->set_se_tbody($sem,$sy);

        $data['view_content']='admin_registrar/grades_by_department';
        $data['get_plugins_js']='admin_registrar/view_grades_js';
        $data['get_plugins_css']='admin_registrar/view_grades_css';

        $this->load->view('template/init_views',$data);
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

    public function search_subject_enrollees(){
        $sem = $this->input->post("sem",TRUE);
        $sy = $this->input->post("sy",TRUE);

        $search_text = $this->input->post("search_text",TRUE);
        $data['table']= $this->set_se_tbody($sem,$sy,$search_text);
        echo json_encode($data['table']['table']);
    }

    public function search_subject_enrollees_teacher(){
        $sem = $this->input->post("sem",TRUE);
        $sy = $this->input->post("sy",TRUE);
        $search_text = $this->input->post("search_text",TRUE);
        $data['table']= $this->set_se_tbody($sem,$sy,$search_text);
        echo json_encode($data['table']['table']);
    }

    public function subject_enrolleesy(){
        $sem = $this->input->post("sem",TRUE);
        $sy = $this->input->post("sy",TRUE);
        $data['table']= $this->set_se_tbody($sem,$sy);
        echo json_encode($data['table']['table']);
    }

public function set_se_tbody($sem,$sy,$search_text = ""){
        $this->load->model('subject/subject_enrollees_model');
        if($search_text===""){
            $data['aaData']= $this->subject_enrollees_model->get_subjects($sem,$sy,'s.section, s.acadyear, s.yearlvl, s.course, c.code, s.schedid');
        }else{
            if($search_text["type"]==="t.teacherid"){
                $data['aaData']= $this->subject_enrollees_model->get_subjects_search_teacher($search_text["value"],$sem,$sy,'s.section, s.acadyear, s.yearlvl, s.course, c.code, s.schedid');
            }else{
                $data['aaData']= $this->subject_enrollees_model->get_subjects_search($search_text,$sem,$sy,'s.section, s.acadyear, s.yearlvl, s.course, c.code, s.schedid');
            }

        }
        $data["table"] = '<hr /><table class="table table-bordered" id="dataTables-example"><tr><th>Assigned Teacher</th><th>Course No</th><th>Descriptive Title</th><th>Units</th><th>Days</th><th>Time</th><th>Room</th><th>Section</th><th>Enrolled</th></tr>';
        for($x=0;$x<count($data['aaData']);$x++){

            if($search_text!="" && $search_text["type"]!==""){
                $countxy =$search_text["type"] ;
                $data['aaData2']= $this->subject_enrollees_model->get_subject_courseinfo($search_text,$data['aaData'][$x]->section,$data['aaData'][$x]->acadyear,$data['aaData'][$x]->yearlvl,$data['aaData'][$x]->course,$sem,$sy);
            }else{
                $countxy ='emptyxx' ;
                $data['aaData2']= $this->subject_enrollees_model->get_subject($data['aaData'][$x]->section,$data['aaData'][$x]->acadyear,$data['aaData'][$x]->yearlvl,$data['aaData'][$x]->course,$sem,$sy);
            }
            $countx=count($data['aaData2']);
            $data["table"] .='<tr><td colspan="10" class="text-center"><b>'.$data['aaData'][$x]->code.' - '.$data['aaData'][$x]->yearlvl.', Curr: '.$data['aaData'][$x]->acadyear.', Section: '.$data['aaData'][$x]->section.'</b></td></tr>';

            for($y=0;$y<count($data['aaData2']);$y++){
                $teacher = $this->subject_enrollees_model->get_teacher($data['aaData2'][$y]->schedid,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName),t.id")?$this->subject_enrollees_model->get_teacher($data['aaData2'][$y]->schedid,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName) AS fullname,t.id")[0]->fullname:'<span class="label label-danger">Not Assigned</span>';
                $time = ($data['aaData2'][$y]->start)?date('h:i A', strtotime($data['aaData2'][$y]->start)).'-'.date('h:i A', strtotime($data['aaData2'][$y]->end)) : '-';

                $check_fused = $this->subject_enrollees_model->check_fused($data['aaData2'][$y]->schedid);
                if($check_fused[0]->fuse==null){
                    $count_studs=$this->subject_enrollees_model->count_subject_student($data['aaData2'][$y]->schedid,$sem,$sy,'s.studentid');
                }else{
                    $get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
                    $schedids = explode(",",$get_fused[0]->sched);
                    $count_studs = 0;
                    for($xy=0;$xy<count($schedids);$xy++){
                        $count_studs = $count_studs + $this->subject_enrollees_model->count_subject_student($schedids[$xy],$sem,$sy,'s.studentid');
                    }

                }
                $data["table"] .='<tr>
                <td class="text-center">'.($teacher).'
                    <td>'.$data['aaData2'][$y]->courseno.'<td>'.$data['aaData2'][$y]->description.'<td>'.$data['aaData2'][$y]->totalunits.'<td>'.$data['aaData2'][$y]->days.'<td>'.$time.'<td>'.$data['aaData2'][$y]->room.'<td>'.$data['aaData2'][$y]->section.'
                        <td><a href="#" onclick="$(this).showEnrolleesonSubject(\''.$data["aaData2"][$y]->schedid.'\');"  > '.$count_studs.'</a>
                        </td>
                    </tr>
                        ';
                    }
                }
                $data["table"] .='</table>';
                return $data;
            }

    public function subject_grades()
    {
        $this->load->model('subject/subject_enrollees_model');
        $schedid =  $this->input->post('schedid',TRUE);
        $sem =  $this->input->post('sem',TRUE);
        $sy =  $this->input->post('sy',TRUE);
        $check_fused = $this->subject_enrollees_model->check_fused($schedid);


        if($check_fused[0]->fuse==null){
            $data['aaData']= $this->subject_enrollees_model->get_student_list($schedid,$sem,$sy,' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality');
        }else{
            $get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
            $schedids = explode(",",$get_fused[0]->sched);
            $students = array();
            for($x=0;$x<count($schedids);$x++){
                $aaData[$x]= $this->subject_enrollees_model->get_student_list($schedids[$x],$sem,$sy,' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality');
                $students = array_merge($students,$aaData[$x]);
            }
            $data['aaData'] = $students;
        }
        $data['subjct_info'] = $this->sched_record_model->get_sched_info('',$schedid);
        $data['table'] = $this->set_tbody(  $data['aaData'],$schedid );

        $this->load->view('admin_registrar/subject_student_grades',$data);
    }


    public function set_tbody( $data , $schedid ){

            $this->load->model('grade_submission_model');
            $this->load->module('template/template');
            $sem_sy =$this->template->get_sem_sy();
            $sem=$sem_sy['sem_sy'][0]->sem;
            $sy=$sem_sy['sem_sy'][0]->sy;

            $subjct_info = $this->sched_record_model->get_sched_info('',$schedid);
            

            if(isset($_SESSION['new_sem_Sy'])){
                $new_sem_Sy = $this->session->new_sem_Sy;
                $sem=$new_sem_Sy['sem'];
                $sy=$new_sem_Sy['sy'];
            }

            $tr = '';

            for($x=0;$x<count($data);$x++){
                $pre = '';
                $mid = '';
                $tf = '';
                $final = '';
                $remarks = '';

                if($this->grade_submission_model->get_stud_fgrades($schedid , $data[$x]->studid ,'*')){
                    $stud_grades = $this->grade_submission_model->get_stud_fgrades($schedid , $data[$x]->studid ,'*');
                    $remarks = $stud_grades[0]->remarks;
                    $pre = $stud_grades[0]->prelim;
                    $mid = $stud_grades[0]->midterm;
                    $tf = $stud_grades[0]->tentativefinal;
                    $final = $stud_grades[0]->final;
                    $div = 3;
                    if($subjct_info['sched_query'][0]->semester == '3'){
                        $div = 2;
                    }
                    if( $mid!=0 && $tf!=0 )
                        $final = ($pre+$mid+$tf)/$div;
                    
                    if($final>=75 || $final<74.5){
                        $final=round( $final,0 );
                    }else{
                        if($remarks == 'Passed'){
                            $final=round( $final,0 );
                        }else{
                            $final=round( $final,2 );
                        }
                    }
                    
                    if($final!=$stud_grades[0]->final)
                        if( $mid!=0 && $tf!=0 )
                            $this->grade_submission_model->update_grades($schedid,$data[$x]->studid,'final',$final);
                }


                switch ($remarks) {

                            case 'No Final Exammination':
                                    $tf = 'NFE';
                                    $final= 'NFE';
                                break;
                            case 'No GRADE':
                                    $pre = '--';
                                    $mid = '--';
                                    $tf = '--';
                                    $final='--';
                                break;

                            case 'Officially Dropped':
                                    $pre = '--';
                                    $mid = '--';
                                    $tf = '--';
                                    $final='--';
                                break;

                            case 'Unofficially Dropped':
                                    $final='--';
                                break;

                            case 'Incomplete':
                                    $tf = '--';
                                    $final='--';
                                break;

                            case 'No CREDIT':
                                    $pre = '--';
                                    $mid = '--';
                                    $tf = '--';
                                    $final='--';
                                break;

                            case 'DROPPED':
                                    $pre = '--';
                                    $mid = '--';
                                    $tf = '--';
                                    $final='--';
                                break;

                            case 'Withdrawal with Permission':
                                    $pre = '--';
                                    $mid = '--';
                                    $tf = '--';
                                    $final='--';
                                break;

                            default:
                                # code...
                                break;
                        }
                         $pre =  '<td>'.$pre.'</td>';
                    if($subjct_info['sched_query'][0]->semester == '3'){
                        $pre =  '';
                    }

                $tr .=  '
                <tr>
                    <td>'.$data[$x]->studid.'</td>
                    <td>'.$data[$x]->lastname.'</td>
                    <td>'.$data[$x]->firstname.'</td>
                    <td>'.$data[$x]->middlename.'</td>
                    <td>'.$data[$x]->course.'</td>
                    '.$pre.'
                    <td>'.$mid.'</td>
                    <td>'.$tf.'</td>
                    <td>'.$final.'</td>
                    <td>'.$remarks.'</td>
                </tr>
                ';
                $stud_acct = '';
            }
            return $tr;
        }








}