<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Etools extends MY_Controller {

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
		$this->load->module('admin/admin');
		$this->load->module('template/template');
		$this->load->model('template/template_model');
		$this->load->model('etools_model');
		$this->admin->_check_login();
	}

	public function create_etool(){
		$data['sem_sy'] =$this->template->get_sem_sy();
		$data['teacher_id'] = $this->session->userdata('id');
		$data['nav']=$this->admin->_nav();

		$data['view_content']='etools/etools_create';
		$data['get_plugins_js']='etools/etools_js';
		$data['get_plugins_css']='etools/etools_css';
		return $this->load->view('template/init_view_windowed',$data);
	}

	public function save_etool(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('etools_title', 'etools_title', 'required||is_unique[pcc_gs_tchr_cs_evtool.etools_title]');
		if ($this->form_validation->run() == FALSE){
			$teacher_id = $this->session->userdata('id');
			$etools_title = $this->input->post('etools_title',TRUE);
			$etools_code = $this->input->post('etools_code',TRUE);
			$etools_cats_num = $this->input->post('etools_cats_num',TRUE);
			$etools_comments = $this->input->post('etools_comments',TRUE);
			$etools_cats_title = $this->input->post('etools_cats_title',TRUE);
			$etools_items_num = $this->input->post('etools_items_num',TRUE);
			$etools_items_prcnt = $this->input->post('etools_items_prcnt',TRUE);
			$etools_items = $this->input->post('etools_items',TRUE);
			# echo json_encode($this->input->post());
			$etool_cats_items_id = '';
			$data_etools = array(
									'title' => strtoupper($etools_title),
									'etool_code' => strtoupper($etools_code),
									'comments' => $etools_comments,
									'created_by_userid' => $teacher_id,
									'date_created' => mdate('%Y-%m-%d %H:%i %a')
								);
			$etool_id =  $this->etools_model->save_etool($data_etools);
			for($x=1;$x<=$etools_cats_num; $x++){
				$data_etools_cats = array(
										'evtools_id' => $etool_id,
										'description' => strtoupper($etools_cats_title[$x]),
										'percent' => array_sum($etools_items_prcnt[$x]),
										'date_created' => mdate('%Y-%m-%d %H:%i %a')
										);
				$etool_cats_id =  $this->etools_model->save_etool_cats($data_etools_cats);
				for($y=1;$y<=$etools_items_num[$x]; $y++){
					$data_etools_cats_items = array(
											'evtools_id' => $etool_id,
											'evcats_id' => $etool_cats_id,
											'description' => ucfirst($etools_items[$x][$y]),
											'percent' => $etools_items_prcnt[$x][$y],
											'date_created' => mdate('%Y-%m-%d %H:%i %a')
											);
					$etool_cats_items_id[$x][$y] =  $this->etools_model->save_etool_cats_items($data_etools_cats_items);
				}
			}
			if($etool_cats_items_id!=''){
				$etool_cats_items_id['request_info'] = 'success';
			}
			echo json_encode($etool_cats_items_id);

		}else{
			$etool_cats_items_id['request_info'] = 'error';
			echo json_encode($etool_cats_items_id);
		}
	}


}
