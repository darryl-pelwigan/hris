<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nursing_dept extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->_check_login();
        $this->load->module('template/template');
        $this->load->model('nursing_dept_model');
        $this->load->library('theworld');
	}

    public function set_adviser(){
        $data['nav']=$this->_nav();
        $data['user'] =$this->nursing_dept_model->get_user_info($this->session->userdata('id'));

        if(!$data['user']){
            $data['user'] =$this->nursing_dept_model->get_user_dept($this->session->userdata('username'));
            $data['nav_title'] = $data['user']['query'][0]->DEPTNAME;

        }else{
                $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
        }
        $data['user_role'] =$this->nursing_dept_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
        $data['sem_sy']=$this->template->get_sem_sy();
        $table = $this->nursing_dept_model->get_scheduling($data['sem_sy']['sem_sy'][0]->sy,$data['sem_sy']['sem_sy'][0]->sem,1,'c.code,c.courseid,s.yearlvl,s.section,s.acadyear,s.schoolyear,s.semester');
        $data['tbody'] ='';
        for($x=0;$x<$table['num'];$x++){
                        $data['tbody'] .= '<tr>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->code.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->yearlvl.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->section.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->acadyear.'</td>';
                            $pending_subjs = $this->nursing_dept_model->check_status($table['query'][$x]->courseid,$table['query'][$x]->yearlvl,$table['query'][$x]->section,$table['query'][$x]->schoolyear,$table['query'][$x]->semester);
                            $submit_stat = $this->nursing_dept_model->check_submit_stat($table['query'][$x]->courseid,$table['query'][$x]->yearlvl,$table['query'][$x]->section,$table['query'][$x]->schoolyear,$table['query'][$x]->semester);
                            if( $pending_subjs == 0 ){ // && $submit_stat == 0
                                $status = '<span class="label label-success">Approved</span>';
                            }elseif ($submit_stat == 0){
                                $status = '<span class="label label-danger">Pending</span>';
                            }else{
                                $status = '<span class="label label-warning">Not submitted</span>';
                            }
                            $data['tbody'] .= '<td>'.$status.'</td>';
                            $data['tbody'] .= '
                                    <td style="text-align:center;">
                                        <a href="'.base_url().'nursing_dept/view_schedulist?section='.$table['query'][$x]->section.'&course='.$table['query'][$x]->courseid.'&year='.$table['query'][$x]->yearlvl.'&curr='.$table['query'][$x]->acadyear.'&sem='.$table['query'][$x]->semester.'&sy='.$table['query'][$x]->schoolyear.'" class="btn btn-success btn-xs"><i class="fa fa-search"></i> View</a>
                                    </td>';
                        $data['tbody'] .= '</tr>';
        }

        $data['view_content']='nursing_dept/assign_teacher';
        $data['get_plugins_js']='nursing_dept/plugins_js_ndept';
        $data['get_plugins_css']='';
        $this->load->view('template/init_views',$data);
    }


    public function view_schedulist(){

        $data['nav']=$this->_nav();
        $teacher_id = $this->session->userdata('id');
        $data['user'] =$this->nursing_dept_model->get_user_info($teacher_id);

        if(!$data['user']){
            $data['user'] =$this->nursing_dept_model->get_user_dept($this->session->userdata('username'));
            $data['nav_title'] = $data['user']['query'][0]->DEPTNAME;

        }else{
                $data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
        }
        $data['user_role'] =$this->nursing_dept_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
        $data['sem_sy']=$this->template->get_sem_sy();

        $section = $this->input->get('section',TRUE);
        $course = $this->input->get('course',TRUE);
        $year = $this->input->get('year',TRUE);
        $curr = $this->input->get('curr',TRUE);
        $sem = $this->input->get('sem',TRUE);
        $sy = $this->input->get('sy',TRUE);

        $data['tbody'] = '';
        $table = $this->nursing_dept_model->get_schedule_data($section,$course,$year,$curr,$sem,$sy);
        $adviser = $this->nursing_dept_model->get_nursing_adviser(1,'BiometricsID,LastName,FirstName,MiddleName');
        $advisee_ops = '';
        for($xx=0;$xx<$adviser['num'];$xx++){
             $advisee_ops .= '<option value="'.str_pad($adviser['query'][$xx]->BiometricsID,6,0,STR_PAD_LEFT).'" >'.$adviser['query'][$xx]->LastName.', '.$adviser['query'][$xx]->FirstName.' '.$adviser['query'][$xx]->MiddleName[0].'</option>';
        }
            for($x=0;$x<$table['num'];$x++){
                        $data['tbody'] .= '<tr>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->coursecode.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->courseno.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->description.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->totalunits.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->type.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->days.'</td>';
                            $data['tbody'] .= '<td>'.$table['query'][$x]->room.'</td>';


                        $teacher = $this->nursing_dept_model->check_teacher($table['query'][$x]->schedid,'teacherid');
                        $teacher_flm = '';

                        if($teacher['num']>0 && $teacher['query'][0]->teacherid != '000000' ){
                            $teacher_idx = ltrim($teacher['query'][0]->teacherid, '0');
                            $teacher_flm = $this->nursing_dept_model->get_teacher_flm($teacher_idx,'LastName,FirstName,MiddleName');
                            $data['tbody'] .= '<td>'.$teacher_flm['query'][0]->LastName.', '.$teacher_flm['query'][0]->FirstName.' '.$teacher_flm['query'][0]->MiddleName[0].'</td>';
                        }else{
                            $data['tbody'] .= '<td></td>';
                        }

                        $teacher_advisee = $this->nursing_dept_model->check_teacher_advisee($table['query'][$x]->schedid,'teacher_id');
                        $teacher_advisee_flm = '';
                        if($teacher_advisee['num']>0){
                            $teacher_idax = ltrim($teacher_advisee['query'][0]->teacher_id, '0');
                            $teacher_advisee_flm = $this->nursing_dept_model->get_teacher_flm($teacher_idax,'LastName,FirstName,MiddleName');
                            $data['tbody'] .=   '<td> <input type="hidden" value="'.$teacher_idax.'" id="adviser_id_'.$table['query'][$x]->schedid.'_'.$table['query'][$x]->coursecode.'" />
                                                    <span id="adviser_id_s_'.$table['query'][$x]->schedid.'_'.$table['query'][$x]->coursecode.'">'.$teacher_advisee_flm['query'][0]->LastName.', '.$teacher_advisee_flm['query'][0]->FirstName.' '.$teacher_advisee_flm['query'][0]->MiddleName[0].'</span>
                                                <div class="form-group hide"> <select class="form-control" id="sched_id_'.$table['query'][$x]->schedid.'_'.$table['query'][$x]->coursecode.'" >'.$advisee_ops.'</select></div>
                                                </td>';
                            $data['tbody'] .=   '<td>
                                                    <a title="Remove Teacher" class="btn btn-danger btn-xs btn-edit btn-assign-inst" href="#" onclick="$(this).removeAdviser(\''.$table['query'][$x]->schedid.'\',\''.$table['query'][$x]->coursecode.'\')"><i class="fa fa-times"></i></a>
                                                </td>';
                        }else{
                            $data['tbody'] .= '<td><div class="form-group"> <select class="form-control" id="sched_id_'.$table['query'][$x]->schedid.'_'.$table['query'][$x]->coursecode.'" >'.$advisee_ops.'</select></div></td>';
                            $data['tbody'] .= '<td><a type="button" title="Assign Teacher" class="btn btn-success btn-xs btn-edit btn-assign-inst" onclick="$(this).addAdviser(\''.$table['query'][$x]->schedid.'\',\''.$table['query'][$x]->coursecode.'\')"><i class="fa fa-check"></i></a></td>';
                        }

                        $data['tbody'] .= '<td>advisee</td>';
                        $data['tbody'] .= '</tr>';
            }

        $data['view_content']='nursing_dept/view_schedulist';
        $data['get_plugins_js']='nursing_dept/plugins_js_ndept';
        $data['get_plugins_css']='';
        $this->load->view('template/init_views',$data);
    }

    public function assign_adviser(){
        $sem_sy=$this->template->get_sem_sy();

        $data = array(
                        'sched_id' => $this->input->post('sched_id'),
                        'teacher_id' => $this->input->post('adviser'),
                        'sem' => $sem_sy['sem_sy'][0]->sem,
                        'sy' => $sem_sy['sem_sy'][0]->sy,
                        'date_created' => mdate('%Y-%m-%d %H:%i %a')
                     );
       echo $this->nursing_dept_model->set_nursing_adviser( $data );
    }

    public function delete_adviser(){
        $sem_sy=$this->template->get_sem_sy();
        $sched_id = $this->input->post('sched_id');
        echo $this->nursing_dept_model->del_nursing_adviser( $sched_id , $sem_sy['sem_sy'][0]->sem , $sem_sy['sem_sy'][0]->sy  );
    }


    public function _check_login(){
			if($this->session->userdata('username') &&  $this->session->userdata('role')=='9' ){
     			return TRUE;
			}else{
			   return redirect(ROOT_URL.'modules/admin/logout');
			}
	}



    public function _nav($push=null){

            $data=array(
            //      URI ,   added class , NAME , properties array
            array('pcc_dashboard.php','fa fa-dashboard',' Dashboard ','li'=>'','a'=>''),
            array('dept_studrecords.php','fa fa-folder-open-o','Student Records','li'=>'','a'=>''),
            array('purchaseRequest.php','fa fa-briefcase fa-fw',' Purchase Request','li'=>'','a'=>''),
            array('dept_preferences.php','fa fa-gear','Preferences','li'=>'','a'=>''),
            array('viewleave.php','glyphicon glyphicon-list-alt','View Requests ','li'=>'','a'=>''),
            array('rfp.php','fa fa-money','RFP','li'=>'','a'=>''),
            array('HRDownload.php','glyphicon glyphicon-download','Download Files','li'=>'','a'=>''),
            );
            return $data;
    }
}
