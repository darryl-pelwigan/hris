<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_faculty_grades extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->module('template/template');
        $this->load->module('admin_registrar/admin_reg');
        $this->load->module('student_grades/student_grades');
        $this->load->model('admin_registrar/admin_reg_model');
        $this->load->model('admin_registrar/grades_submission_model');
        $this->load->model('sched_record2/grade_submission_model');
        $this->load->model('sched_record2/sched_record_model');
        $this->load->model('student/student_model');
        $this->admin_reg->_check_login();
    }

    public function student_list(){
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

        $data['courses'] = $this->student_model->get_all_course();

        $data['num_years'] = $this->student_model->get_all_course('MAX(numyears) as numyear');

        $data['view_content']='student_grades/registrar/grades_by_department';
        $data['get_plugins_js']='student_grades/registrar/view_grades_js';
        $data['get_plugins_css']='student_grades/registrar/view_grades_css';

        $this->load->view('template/init_views',$data);
    }

    public function student_grade(){
        if($this->input->post('student_id')){
             $this->load->model('admin_registrar/grades_submission_model');
             $this->load->model('student_grades/student_grades_model');
             $this->load->model('student/student_model');
            $this->load->helper('date');

            $sem = $this->input->post('sem');
            $sy = $this->input->post('sy');
            $student_id = $this->input->post('student_id');
            $data['semx'] = $sem;
            $data['syx'] = $sy;
            $data['st_grade_submission']['p'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'p');
            $data['st_grade_submission']['m'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'m');
            $data['st_grade_submission']['tf'] = $this->grades_submission_model->st_get_grade_submission($sy,$sem,'tf');
            $data['student_id'] = $student_id;
            $data['student_info'] = $this->student_model->get_student_infocie($data['student_id'],'r.LastName , r.FirstName , r.MiddleName,c.code,ei.yearlvl') ;



            $data['signatories'] = $this->admin_reg_model->signatories('registrar');
            $data['sem'] =$sem;
            $data['sem_sy'] =$this->template->get_sem_sy();
            $data['sem_w'] =$this->template->get_sem_w($sem,$sy);
            $subject_grades = $this->student_grades_model->get_stud_fgrades($student_id,$sem,$sy);
            $subject_grades_i = $this->student_grades_model->get_stud_fgrades_internships($student_id,$sem,$sy);
            $data['subject_grades'] = array_merge($subject_grades,$subject_grades_i);
           
            // $data['grades_tbody'] = '';
           
             $html = $this->load->view('student_grades/registrar/student_grade_data_pdf_c',$data,true);
            $this->load->library("pdf");
             $pdf = $this->pdf->load();  // L - landscape, P - portrait
             $pdf->mPDF('utf-8',array(215.9,165.1),'','',5,5,2,5,5,5);

                  
             // $pdf->SetHTMLHeader('
                                    
             //                        ',1,true);

             $pdf->SetHTMLFooter('
<table width="100%" style="border-top:1px solid #000;">
    <tr>
        <td width="60%" style="font-size:10px;">'.(strtoupper($data['student_info'][0]->LastName)).','.strtoupper($data['student_info'][0]->FirstName).' '.(strtoupper($data['student_info'][0]->MiddleName[0])).'.('.strtoupper($data['student_info'][0]->code).' - '.$data['student_info'][0]->yearlvl.') </td>
        <td width="10%" align="center"></td>
        <td width="33%" style="text-align: right;font-size:10px;">'.unix_to_human(now()).'<br  /> <small>This is a Computer Generated Document. <br />
 Not valid as transfer credential</small></td>
    </tr>
</table>');

//             $pdf->SetFooter("<strong>".(strtoupper($data['student_info'][0]->LastName)).", ".strtoupper($data['student_info'][0]->FirstName)." ".(strtoupper($data['student_info'][0]->MiddleName[0])).".(".strtoupper($data['student_info'][0]->code)." - ".$data['student_info'][0]->yearlvl.")</strong> ".'||'.date("Y-m-d , D  h:i:s A").'<br  /> <small>This is a Computer Generated Document. <br />
// Not valid as transfer credential</small>'); // Add a footer for good measure

            $pdf->WriteHTML($html); // write the HTML into the PDF

            $pdfFilePath = strtoupper($data['user'][0]->LastName).", ".strtoupper($data['user'][0]->FirstName)." ".strtoupper($data['user'][0]->MiddleName)[0].'_'.$data['teacher_id'].'_'.strtoupper($data['subject_info']['sched_query'][0]->courseno).'_'.$data['sched_id'].'('.date("Y-m-d HisA").").pdf";
            $pdf->Output($pdfFilePath , 'I'); // save to file because we can          
            


        }else{
            redirect('/student_grades/student_faculty_grades/student_list', 'location', 301);
        }
        
    }

    public function student_grade_all(){
        if($this->input->post('student_id')){
           
        }else{
            redirect('/student_grades/student_faculty_grades/student_list', 'location', 301);
        }
        
    }

    public function get_student_list(){
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
    }

     public function student_gradesx()
    {
        // $data['sem_sy'] =$this->template->get_sem_sy();
        // $data['student_id'] = $this->session->userdata('id');
        // $data['nav']=$this->admin->_nav();
        // $data['user'] =$this->student_model->get_student_info($data['student_id'],'LastName , FirstName , MiddleName');
        // $data['user_role'] =$this->user_model->get_user_role($data['student_id'],'pcc_roles.role');
        // $data['subject_year']=$this->student_grades_model->get_subjects_year($data['student_id'],'year');
        // $data['t_subject_year']=$this->student_grades_model->get_tsubjects_school($data['student_id']);
        // $data['o_subject_year']=$this->student_grades_model->get_osubjects_school($data['student_id']);
        // $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
        
        // $data['view_content']='student_grades/student_grades';
        // $data['get_plugins_js']='student_grades/plugins_js_student_grades';
        // $data['get_plugins_css']='student_grades/plugins_css_student_grades';
        
        // $this->load->view('template/init_views',$data);
    }

    public function get_grades_record(){
        $sem=$this->input->post('sem', TRUE);
        $sy=$this->input->post('sy', TRUE);
        $school=$this->input->post('school', TRUE);
        $type=$this->input->post('type', TRUE);
        $data['sem_sy'] =$this->template->get_sem_sy();
        $data['student_id'] = $this->session->userdata('id');
            $this->leclab_grades($data['student_id'],$sem,$sy);
    }

    public function leclab_grades($student_id,$sem,$sy){
        $data['sem'] =$sem;
        $data['sem_sy'] =$this->template->get_sem_sy();
        $data['sem_w'] =$this->template->get_sem_w($sem,$sy);
        $data['lec']=$this->student_grades_model->get_student_grades_lec($student_id,$sem,$sy,'sc.semester,sc.courseno,sc.description,sc.lecunits,sc.labunits,lc.prelim,lc.midterm,lc.tentativefinal');
        $data['leclab']=$this->student_grades_model->get_student_grades_leclab($student_id,$sem,$sy,'sc.semester,sc.courseno,sc.description,sc.lecunits,sc.labunits,lcb.prelim,lcb.midterm,lcb.tentativefinal,lcb.lab_prelim,lcb.lab_midterm,lcb.lab_tentativefinal,se.percentage');
        $this->load->view('student_grades/student_grade_data',$data);
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

        public function set_se_tbody(){
            
            $data['aaData']= $this->student_model->get_student_list_filtered($this->input->post('sem'),$this->input->post('sy'),$this->input->post('course'),$this->input->post('year'),' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality,r.mobile,r.phone,ei.interview AS status ');
            echo json_encode($data);
                   
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
