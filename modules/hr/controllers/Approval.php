<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Approval extends MY_Controller {

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

	#################################################
	##### HR ACCOUNT
	public $user_access_role  = [7];
	##### HR ACCOUNT
	#################################################

	function __construct(){
		$this->load->module('hr/login');
		$this->load->module('template/template');
		$this->load->model('hr/hr_model');
		$this->load->model('hr/employee_model');
		$this->load->model('teacher_profile/user_model');
		
	}
	
	public function index()
	{
		####################################################
		$this->login->_hr_check_login($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################
		
		$data['position_lists'] =$this->hr_model->get_position_lists();
		$data['position_category'] =$this->hr_model->get_position_category_lists();
		$data['approving_pos'] = $this->employee_model->get_approving_position();

		// $data['approving_pos'] = [];
		// foreach($data['position_lists'] as $pos){
		// 	$approving = $this->employee_model->get_approving_position($pos->id);
		// 	if($approving){
		// 		array_push($data['approving_pos'], $approving); 
		// 	}else{
		// 		array_push($data['approving_pos'], []); 
		// 	}
		// }

		#VIEW CONTENT
		$data['view_content']='hr/settings_approval';
		$data['view_modals']='hr/settings_approval_modal';
		$data['get_plugins_js'] = 'hr/js/setting_approval_js';
		$data['get_plugins_css']= 'hr/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);
	}

	public function add_approving_position()
	{

		$position_id = $this->input->post('position_id');
		$approving_pos = $this->input->post('approving_position');


		$rank = $this->employee_model->getlatestpositionrank($position_id);

		if($rank){
			$approval_level = $rank[0]->approval_level + 1;
		}else{
			$approval_level = 1;
		}
		$this->employee_model
						->insert_position_approval([
							'category' => $position_id,
							'category_approval' => $approving_pos,
							'approval_level' => $approval_level
						]);

		redirect(base_url('setting_approving_position_ids'));


	}

	public function reset_approving()
	{

		$category = $this->input->post('category');
		$this->employee_model->setting_resetapproving($category);

		$data = true;
		echo json_encode($data);


	}

	public function approval_lists(){
		$category = $this->input->post('category');	
		$lists = $this->employee_model->get_approval_lists($category);

		$data = [];
		if ($lists) {
			foreach ($lists as $key => $value) {
				$data[] = array(
					'position_name' => $value->position,
					'approval_level' => $value->approval_level,
				);
			}
		}

		echo json_encode($data);
	}

}
