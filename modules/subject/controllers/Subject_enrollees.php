<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subject_enrollees extends MY_Controller {

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

		$this->load->module('admin/admin');
		$this->admin->_check_login2();
    }

	public function subject_enrolleesx()
	{
		$this->load->model('subject/subject_enrollees_model');
		$schedid=  $this->input->post('schedid',TRUE);
		$sem=  $this->input->post('sem',TRUE);
		$sy=  $this->input->post('sy',TRUE);
		$check_fused = $this->subject_enrollees_model->check_fused($schedid);


		if($check_fused[0]->fuse==null){
			$data['aaData']= $this->subject_enrollees_model->get_student_list($schedid,$sem,$sy,' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality');
		}else{
			$get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
			$schedids = explode(",",$get_fused[0]->sched);
			$test = array();
			for($x=0;$x<count($schedids);$x++){
				$aaData[$x]= $this->subject_enrollees_model->get_student_list($schedids[$x],$sem,$sy,' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality');
				$test = array_merge($test,$aaData[$x]);
			}
			$data['aaData'] = $test;
		}
		$data['table'] = $this->set_tbody(	$data['aaData'] );

		$this->load->view('subject/subject_enrollees',$data);
	}

	public function get_subject_enrollees(){
		$this->load->module('admin_registrar/admin_reg');
		$this->load->model('admin_registrar/admin_reg_model');
		$this->load->module('template/template');
		$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['sem_sy']=$this->template->get_sem_sy();
		$sem=$data["sem_sy"]["sem_sy"][0]->sem;
		$sy=$data["sem_sy"]["sem_sy"][0]->sy;




		$data['table']= $this->set_se_tbody($sem,$sy);

		$data['view_content']='subject/subject_enrollees_all';
		$data['get_plugins_js']='subject/plugins_js_subenrollees';
		$data['get_plugins_css']='subject/plugins_css_subenrollees';

		$this->load->view('template/init_views',$data);
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

	public function get_all_by(){
		$this->load->model('subject/subject_enrollees_model');
		$sem = $this->input->post("sem",TRUE);
		$sy = $this->input->post("sy",TRUE);
		$type = $this->input->post("type",TRUE);
		$data['aaData']= $this->subject_enrollees_model->get_search($sem,$sy,$type);
		$data['count']= count($data['aaData']);
		echo json_encode($data);
	}

	public function get_allteacher_by(){
		$this->load->model('subject/subject_enrollees_model');
		$sem = $this->input->post("sem",TRUE);
		$sy = $this->input->post("sy",TRUE);
		$data['aaData']= $this->subject_enrollees_model->get_teacher_list($sem,$sy,"CONCAT(e.LastName,', ',e.FirstName,' ',e.MiddleName) AS fullname,t.teacherid");
		$data['count']= count($data['aaData']);
		echo json_encode($data);
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
		$data["table"] = '<hr /><table class="table table-bordered" id="dataTables-example"><tr><th>Assigned Teacher</th><th>Course No</th><th>Descriptive Title</th><th>Units</th><th>Days</th><th>Time</th><th>Room</th><th>Section</th><th>Enrolled</th><th>Status</th></tr>';
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
				$count_studs = $this->subject_enrollees_model->count_subject_student($data['aaData2'][$y]->schedid,$sem,$sy,'s.studentid');

				$data["table"] .='<tr>
				<td class="text-center">'.($teacher).'
					<td>'.$data['aaData2'][$y]->courseno.'<td>'.$data['aaData2'][$y]->description.'<td>'.$data['aaData2'][$y]->totalunits.'<td>'.$data['aaData2'][$y]->days.'<td>'.$time.'<td>'.$data['aaData2'][$y]->room.'<td>'.$data['aaData2'][$y]->section.'
						<td><a href="#" onclick="$(this).showEnrolleesonSubject(\''.$data["aaData2"][$y]->schedid.'\');"  > '.$count_studs.'</a>
							<td style="text-align:center;"><span class="label label-success">Approved</span>
							</td>
						</tr>
						';
					}
				}
				$data["table"] .='</table>';
				return $data;
			}

			public function set_tbody($data){
				$this->load->module('template/template');
				$sem_sy =$this->template->get_sem_sy();
				$tr = '';

				for($x=0;$x<count($data);$x++){
					if($this->subject_enrollees_model->check_assessment($data[$x]->studid,$sem_sy['sem_sy'][0]->sem,$sem_sy['sem_sy'][0]->sy,'dateasses'))
						$stud_acct='<i class="label label-success glyphicon glyphicon-ok text-success">success</i>';
					else
						$stud_acct = '<span class="label label-warning">In Progress</span>';

					if($this->subject_enrollees_model->check_payment($data[$x]->studid,$sem_sy['sem_sy'][0]->sem,$sem_sy['sem_sy'][0]->sy,'datepaid'))
						$stud_pymnt='<i class="label label-success glyphicon glyphicon-ok text-success">success</i>';
					else
						$stud_pymnt = '<span class="label label-warning">In Progress</span>';
					$tr .=	'
					<tr>
						<td>'.$data[$x]->studid.'</td>
						<td>'.$data[$x]->lastname.'</td>
						<td>'.$data[$x]->firstname.'</td>
						<td>'.$data[$x]->middlename.'</td>
						<td>'.$data[$x]->course.'</td>
						<td>'.$data[$x]->dateadmitted.'</td>
						<td>'.$data[$x]->studenttype.'</td>
						<td>'.$stud_acct.'</td>
						<td>'.$stud_pymnt.'</td>
						<td><center><a href="'.ROOT_URL.'searchstud.php?sid='.$data[$x]->studid.'" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> View</a> </center></td>
					</tr>
					';
					$stud_acct = '';
				}
				return $tr;
			}

			/*hidden method  */
	public function _check_login(){

			if(in_array($this->session->userdata('role'),['1','2','4']) ){
     			return TRUE;
			}else{
			   redirect(ROOT_URL.'login');
			}
	}

}
