<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Itdept extends MY_Controller {

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

	function __construct(){
		parent::__construct();
		$this->_check_login();
	}

	 public function test(){
		 echo "test lang";
	 }

	public function release_id_list()
	{
		$this->load->model('it/itdept_model');
		$sem=  $this->input->post('sem',TRUE);
		$sy=  $this->input->post('sy',TRUE);
		$data['aaData']= $this->itdept_model->get_student_list($sem,$sy,' pr.studid AS studentid,pr.lastname AS lastname ,pr.firstname AS firstname,pr.middlename AS middlename,pr.baguioadd AS address,pr.birthdate AS birthdate,pr.mobile AS contactno,pr.emailadd AS emailadd , pei.date_admitted AS date_admitted');
		   echo json_encode( $data );
		// $this->load->view('subject/subject_enrollees',$data);
	}

	public function _check_login(){
		if($this->session->userdata('username') &&  $this->session->userdata('role')==5  ){
 			return TRUE;
		}else{
		     return redirect(ROOT_URL.'login');
		}

	}
}
