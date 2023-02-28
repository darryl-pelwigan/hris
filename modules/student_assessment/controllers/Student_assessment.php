<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_assessment extends MY_Controller {

	function __constract(){
		$this->load->module('admin/admin');
		$this->_check_login();
	}

	public function student_assessment_list(){
		$this->load->model('student_assessment/student_assessment_model');
		$data['aaData']= $this->student_assessment_model->get_student_list_assesment(1,' r.studid, r.lastname, r.firstname, r.middlename, r.emailadd, CONCAT(c.code,"-",ei.yearlvl) AS course, ei.date_registered AS datereg , ei.date_admitted  AS dateadmitted , t.type   AS studenttype ,r.nationality');
		$data['table'] = $this->set_tbody(	$data['aaData'] );
		$this->load->view('student_assessment/student_assessment',$data);
	}

    public function set_tbody($data){
		$this->load->module('template/template');
		$sem_sy =$this->template->get_sem_sy();
		$tr = '';

		for($x=0;$x<count($data);$x++){
			if($this->student_assessment_model->check_assessment($data[$x]->studid,$sem_sy['sem_sy'][0]->sem,$sem_sy['sem_sy'][0]->sy,'dateasses'))
				$stud_acct='<i class="label label-success glyphicon glyphicon-ok text-success">success</i>';
			else
				$stud_acct = '<span class="label label-warning">In Progress</span>';

			if($this->student_assessment_model->check_payment($data[$x]->studid,$sem_sy['sem_sy'][0]->sem,$sem_sy['sem_sy'][0]->sy,'datepaid'))
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
							<td><center><a href="searchstud.php?sid='.$data[$x]->studid.'" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> View</a> </center></td>
						</tr>
					';
					$stud_acct = '';
		}
		return $tr;
	}

    public function approved_assessment(){
        $this->load->module('template/template');
		$sem_sy =$this->template->get_sem_sy();
        $this->load->model('student_assessment/student_assessment_model');
		$data['aaData']= $this->student_assessment_model->get_approved_list_assesment($sem_sy['sem_sy'][0]->sem,$sem_sy['sem_sy'][0]->sy," m.studid As studentid, r.lastname, r.firstname, r.middlename, CONCAT(c.code,'-',ei.yearlvl) AS course, r.phone AS contact, m.date AS date");
		echo json_encode($data);
        // $this->load->view('student_assessment/approved_assessment',$data);
    }

}
