<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends MY_Controller {

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
	 
	 public function submit_test(){
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_rules('capthca_inp', 'CAPTCHA', 'trim|required|alpha_numeric');
		$captcha_info = $this->session->userdata('captcha_info');
		if($this->form_validation->run()){
			$str=$this->input->post('capthca_inp');
			if ($captcha_info['code'] == $str )
			{
				$data['info']=$this->input->post();
				$this->load->view('registration/registration_verify',$data);
				// echo json_encode($this->input->post());
			}else{
				echo $captcha_info['code'].'----x---'.$this->input->post('capthca_inp');
			}
		}else{
			echo json_encode(form_error('capthca_inp')).'----'.$captcha_info['code'].'-------';
		}
	 }

	 public function register()
	{
		$this->load->model('registration_model');
		$this->load->library('theworld');
		$this->load->helper('form');
		
		$this->captcha_re(FALSE);
		
		$data["csrf"] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
		);
		$data['sem_sy']=$this->set_sem();
		$data['religion']=$this->registration_model->religion('religion');
		$data['courses']=$this->registration_model->courses();
		$data['the_origin'] = $this->theworld->the_origin();
		$data['the_race'] = $this->theworld->the_race();
		$data['view_content']='registration/registration';
		$data['get_plugins_js']='registration/plugins_js_registration';
		$data['get_plugins_css']='registration/plugins_css_registration';
		$this->load->view('template/init_registration_views',$data);
	}

	/*auto fill*/

	public function auto_fill(){
		$this->load->model('registrationaf_model');
		$type = $this->input->post("type",true);
		$studtype = $this->input->post("studtype",true);
		$data=json_encode($this->registrationaf_model->select_rand($type,$studtype));
		echo $data;
	}
	public function registeraf()
	{
		$this->load->model('registration_model');
		$this->load->library('theworld');
		$this->load->helper('form');
		$this->captcha_re(FALSE);
		$data["csrf"] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
		);
		$data['sem_sy']=$this->set_sem();
		$data['religion']=$this->registration_model->religion('religion');
		$data['courses']=$this->registration_model->courses();
		$data['the_origin'] = $this->theworld->the_origin();
		$data['the_race'] = $this->theworld->the_race();
		$data['view_content']='registration/registration_autofill';
		$data['get_plugins_js']='registration/plugins_js_registration_af';
		$data['get_plugins_css']='registration/plugins_css_registration';
		$this->load->view('template/init_registration_views',$data);
	}

	public function captcha_re($true=FALSE){
		$this->load->library('captcha');
		$captcha = $this->captcha->main(array('controller'=>'registration/viewcaptcha'));
		$this->session->set_userdata('captcha_info', $captcha);
			echo $captcha['image_src'];
	}
	
	public function save_early_enroll(){
		   
		   if ($this->validate_data() == FALSE)
                {
                        $this->test();
                }
           else
                {
                        $this->test();
                }
				
	}
	
	public function validate_data(){
		$this->load->library('encryption');
		$this->load->helper('form');
		$this->load->module('template/template');
		$this->load->library('form_validation');
		
		$plain_text = 'This is a plain-text message!';
		
		$data['test']=$this->encryption->encrypt($plain_text);
		$data['test2']=$this->encryption->decrypt($data['test']);
		
		   
		   $this->form_validation->set_rules('reg[0]', 'Email', 'trim|required|valid_email|is_unique[pcc_registration.emailadd]');
		   $this->form_validation->set_rules('reg[1]', 'Last Name', 'trim|required');
		return $this->form_validation->run();
	}
	
	public function set_sem(){
		$this->load->module('template/template');
		$semx=$this->template->get_sem_sy();
		$sem=$semx['sem_sy'][0]->sem;
		$sy=$semx['sem_sy'][0]->sy;
		
		$data['sem_sy_e']=$this->template->get_sem_w($sem,$sy);
			return $data;
	}
	
	
	

}
