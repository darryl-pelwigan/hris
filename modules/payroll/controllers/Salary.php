<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class salary extends MY_Controller {

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
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->module('template/template');
		$this->load->module('hr/employees');
		$this->load->model('payroll/payroll_model');
		$this->load->model('hr/hr_model');
		$this->load->model('teacher_profile/user_model');	
		$this->form_validation->set_error_delimiters('<b class="error_validation">', '</b><br />');
	}


	public function index()
	{
		####################################################
		$this->login->_check_login_all($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['view_content']='payroll/salary';
		$data['get_plugins_js'] = 'payroll/js/plugins_js_salary';
		$data['get_plugins_css']= 'payroll/css/plugins_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function get_salary_matrix()
	{
		// $lists = $this->payroll_model->get_salary_matrix();
		// $data['data'] = [];
		// if($lists){
		// 	foreach ($lists as $key => $value) {
		// 		$data['data'][] = array(
		// 						'position' 		=> $value->position,
		// 						'position_id' 	=> $value->pos_id,
		// 						'regular' 		=> $value->regular,
		// 						'probationary' 	=> $value->probationary,
		// 						'contractual'	=> $value->contractual,
		// 						'project_based' => $value->project_based,
		// 						'fixed_term' 	=> $value->fixed_term,

		// 					);
		// 	}
		// }

		// echo json_encode($data);

		$lists = $this->payroll_model->get_salary_matrix();
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
								'fullname' 		=> $value->fullname,
								'u_id' 	=> $value->u_id,
								'position' 	=> $value->position,
								'hour' 		=> $value->hour,
								// 'day' 	=> $value->day,
							);
			}
		}

		echo json_encode($data);

	}


	public function get_salary_matrix_teaching()
	{
		$lists = $this->payroll_model->get_salary_matrix_teaching();
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
								'fullname' 		=> $value->fullname,
								'u_id' 	=> $value->u_id,
								'position' 	=> $value->position,
								'hour' 		=> $value->hour,
								// 'day' 	=> $value->day,
							);
			}
		}

		echo json_encode($data);

	}

	public function get_salary_matrix_unknown()
	{
		$lists = $this->payroll_model->get_salary_matrix_unknown();
		$data['data'] = [];
		if($lists){
			foreach ($lists as $key => $value) {
				$data['data'][] = array(
								'fullname' 		=> $value->fullname,
								'u_id' 	=> $value->u_id,
								'position' 	=> $value->position,
								'hour' 		=> $value->hour,
								// 'day' 	=> $value->day,
							);
			}
		}

		echo json_encode($data);

	}

	

	public function update_salary_matrix()
	{
		$user_id = 	$this->input->post('user_id');
		$value 		 = 	$this->input->post('value');
		$column 	 = 	$this->input->post('column');

		$col_name = "";
		if($column == 1){
			$col_name = "hour";
		}else if($column == 2){
			$col_name = "day";
		}

		$data = $this->payroll_model->search_position_salary_matrix($user_id);

		if($data){
			$this->payroll_model->update_salary_matrix($user_id, $value, $col_name);
			$data = array(
					'user_id' 	  => $user_id, 
					'hour'	  	  => ($column == 1 ? $value : 0),
					// 'day'	  => ($column == 2 ? $value : 0),
					'created_at'	  => date("Y-m-d H:i:s"),
			);
			$this->payroll_model->insert_salary_matrix_log($data);

		}else{
			$data = array(
					'user_id' 	  => $user_id, 
					'hour'	  	  => ($column == 1 ? $value : 0),
					// 'day'	  => ($column == 2 ? $value : 0),
				);
			$this->payroll_model->insert_salary_matrix($data);
		}
		$data = true;
		echo $data;

	}

	public function view_salary_computaion($id){


		$this->login->_check_login_all($this->user_access_role);
		$data['nav']=$this->template->_hr_nav();
		$fileno = $this->session->userdata('fileno');
		$data['user'] =$this->employee_model->get_user_info($fileno);
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['user_role'] =$this->user_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['sem_sy']=$this->template->get_sem_sy();
		####################################################

		$data['staff_selected'] = $this->employee_model->get_user_info($id);
		$emp_all = $this->employee_model->get_employees(1);
		$data['rate'] = $this->payroll_model->get_user_rate($id);
		$data['employees'] = array();

		### cutt off periond 
		$data['get_cut_off'] = $this->payroll_model->get_user_cutt_off( $data['staff_selected'][0]->emp_status, $data['staff_selected'][0]->teaching);
		$data['first_cut'] = '';
		$data['second_cut'] = '';

		$data['val_cut_off'] = 0;
		$data['month'] = '';
		$date_now = (int)date('d');

		$cut_off = 	$this->input->post('cutt_off');
		$month = 	$this->input->post('month_rate');

		if ( !empty($data['get_cut_off']) ) {
			$data['first_cut'] = 'Day ' .$data['get_cut_off'][0]->first_cut_from. '-' .$data['get_cut_off'][0]->first_cut_to;

			$second_cut = $data['get_cut_off'][0]->second_cut_to;
			$second_cut_val = $data['get_cut_off'][0]->second_cut_to;

			if ($data['get_cut_off'][0]->second_cut_to == 'end') {
				$second_cut = 'End of Month';
				$second_cut_val = 31;
			} 
			$data['second_cut'] = 'Day ' .$data['get_cut_off'][0]->second_cut_from. '-' .$second_cut;

			if ($cut_off) {

				$data['val_cut_off'] = $cut_off;
				$data['month'] = date('F Y', strtotime($month));

			} else {
				$data['month'] = date("F Y");
				if ( $date_now >= $data['get_cut_off'][0]->first_cut_from &&  $date_now <= $data['get_cut_off'][0]->first_cut_to ) {
					$data['val_cut_off'] = 1;
				} else if ( $date_now >= $data['get_cut_off'][0]->second_cut_from &&  $date_now <= $second_cut_val ) {
					$data['val_cut_off'] = 2;
				} else {
					$data['val_cut_off'];
				}
			}

		}
		## End of Cutt off Periods Calculations

		## Error Check
		$data['error_data'] = array();

		if ($data['staff_selected'][0]->teaching == null) {
			array_push($data['error_data'], 'Nature of Employement');
			
		}
		if ($data['rate'][0]->hour == null ) {
			array_push($data['error_data'], 'Salary Rate');
		}
		if ($data['val_cut_off'] == 0) {
			array_push($data['error_data'], 'Cutt Off Date Settings');
		}
		
		## End of Error Check

		foreach ($emp_all as $key => $value) {
			
			$data['employees'][] = array(
				'bio_id' => $value->BiometricsID,
				'fileno' => $value->FileNo,
				'name' => $value->LastName. ', '.$value->FirstName. ' ' .$value->MiddleName, 
			);
		}

		$today = date("Y-m-d");

		$data['view_content']='payroll/salary_payroll';
		$data['get_plugins_js'] = 'payroll/js/plugins_js_salary';
		$data['get_plugins_css']= 'payroll/css/style_css';
		$this->load->view('template/init_views_hr',$data);

	}

	public function get_attendance_biometrics(){

		$fileno = 	$this->input->post('fileno');
		$cut_off = 	$this->input->post('cutt_off');
		$month = 	$this->input->post('month');

		$staff_biono = $this->employee_model->get_user_info($fileno);
		$salary_rate = $this->payroll_model->get_staff_salary($staff_biono[0]->ID);
		$rate = $salary_rate ? $salary_rate[0]->hour : 0;

		## Get selected cutoff date
		$get_cut_off = $this->payroll_model->get_cuttoff_date( $staff_biono[0]->teaching, $staff_biono[0]->emp_status );
		$date_from = '';
		$date_to = '';

		if ( $cut_off == 1 ) {
			$date1 = $get_cut_off[0]->first_cut_from;
			$date2 = $get_cut_off[0]->first_cut_to;
			$date_from = date('Y-m-'.$date1.'', strtotime($month));
			$date_to = date('Y-m-'.$date2.'', strtotime($month));

		} else if ( $cut_off == 2 ){
			$date1 = $get_cut_off[0]->second_cut_from;
			$date2 = $get_cut_off[0]->second_cut_to;
			$date_from = date('Y-m-'.$date1.'', strtotime($month));
			$date_to = date('Y-m-'.$date2.'', strtotime($month));

		} else {
			$date_from;
			$date_to;
		}


		$lists = $this->payroll_model->get_staff_attendance($staff_biono[0]->BiometricsID, $date_from, $date_to );
		$data = array();

		if ($lists) {
			foreach ($lists as $key => $value) {
				if ($value->totalhours == '8:00') {
					$exception = 'Completed';
					$total = 8;
				} else {
					$exception = 'Undertime';
					$total = '';
				}
				$data[] = array(
					'biometrics' => $value->biono,
					'date' => date('M d, Y', strtotime($value->date)),
					'totalhours' => $total,
					'exception' => $exception,
					'rate' => $rate,
				);
			}
		}

		echo json_encode($data);

	}
	


	
}
