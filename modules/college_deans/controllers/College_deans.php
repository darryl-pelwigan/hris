<?php defined('BASEPATH') OR exit('No direct script access allowed');

class College_deans extends MY_Controller {

	 function __construct()
    {
        parent::__construct();
		$this->load->model('admin/user_model');
		$this->load->model('college_deans_model');
		$this->load->module('admin_registrar/admin_reg');
		$this->load->module('template/template');
		$this->load->model('template/template_model');
		$this->load->model('admin_reg_model');
		$this->load->library('encryption');
		$this->encryption->initialize(
									        array(
									                'cipher' => 'aes-256',
									                'mode' => 'ctr',
									                'key' => base64_encode('124356879'),
									        )
									);

		$this->admin_reg->_check_login();
    }


    public function view_college_deans(){

    	$data['college_deans'] = $this->college_deans_model->get_all_college_deans('d.DEPTID,d.DEPTNAME,s.MiddleName,s.MiddleName,s.FirstName,s.LastName,c.id as cd_id,c.date_started,c.date_ended');
    	$data['college'] = $this->college_deans_model->get_all_college('d.DEPTID,d.DEPTNAME');
    		
        $new = [];
    	foreach ($data['college'] as $key => $value) {
             $new[$value->DEPTID] = $value;
        }
        $data['college'] = $new;
        $new2 = [];
        foreach ($data['college_deans'] as $key => $value) {
             $new2[$value->DEPTID] = $value;
        }
        $data['college_deans'] = $new2;
      
        
		$data['nav']=$this->admin_reg->_nav();
		$data['user'] =$this->admin_reg_model->get_user_info($this->session->userdata('id'));
		$data['user']['position']= $this->admin_reg_model->get_user_position($data['user'][0]->PositionRank,'position');
		$data['user_role'] =$this->admin_reg_model->get_user_role($this->session->userdata('id'),'pcc_roles.role');
		$data['nav_title'] = $data['user'][0]->LastName.' '.$data['user'][0]->FirstName.', '.$data['user'][0]->MiddleName;
		$data['sem_sy']=$this->template->get_sem_sy();
		$data['view_content']='college_deans/college_deans';
		$data['get_plugins_js']='college_deans/college_deans_js';
		$data['get_plugins_css']='college_deans/college_deans_css';
		$this->load->view('template/init_views',$data);
    }


    public function get_teacher(){
    	$data['suggestions'] = [];
    	$staffs = $this->college_deans_model->get_staff($this->input->post('DEPTID'),$this->input->post('query'));
        $staffs2 = $this->college_deans_model->get_staff_all($this->input->post('query'));
        $staffs3 = array_merge($staffs,$staffs2);
    		foreach ($staffs3 as $key => $value) {
    				$data['suggestions'][$key]['DEPTID'] = $value->Department;
    				$data['suggestions'][$key]['data'] = $value->ID;
    				$data['suggestions'][$key]['value'] = $value->LastName .', '.$value->FirstName;
    			
    		}
    	echo json_encode($data);
    }


    public function save_assign_dean(){
    	$teacher_id  = $this->input->post('teacher_id');
    	$DEPTID  = $this->input->post('DEPTID');
    	$datestarted = $this->input->post('datestarted');

    	$this->college_deans_model->insert_college_deans([
    														'staff_id' => $teacher_id,
    														'college_dept' => $DEPTID,
    														'date_started' => $datestarted,
    														'created_at' => mdate('%Y-%m-%d %h:%i:%s'),
    													]);
         echo json_encode(['Successfully assigned']);
    }

    public function save_remove_dean(){
    	$teacher_id  = $this->input->post('teacher_id');
    	$DEPTID  = $this->input->post('DEPTID');
    	$ID = $this->input->post('ID');
    	$this->college_deans_model->delete_college_deans($ID);

        echo json_encode(['Successfully remove']);
    }



 

    

}
