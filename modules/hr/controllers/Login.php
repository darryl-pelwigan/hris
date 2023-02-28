<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends MY_Controller {

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
	}


	public function _check_login($user){
		if($this->session->userdata('username') &&  !in_array( [$this->session->userdata('role')] , $user)){ 		
 			return TRUE;
		}else{
		     return redirect(ROOT_URL.'modules/admin/logout');
		}
	}



	public function _hr_check_login($user){

		if($this->session->userdata('username') &&  $this->session->userdata('role') == '7'){ 		
 			return TRUE;
		}else{
		     return redirect(ROOT_URL.'modules/admin/logout');
		}
	}


	public function _acc_check_login($user){

		if($this->session->userdata('username') &&  $this->session->userdata('role') == '4'){ 		
 			return TRUE;
		}else{
		     return redirect(ROOT_URL.'modules/admin/logout');
		}
	}

	public function _check_login_all($user){

		if($this->session->userdata('username') &&  ($this->session->userdata('role') == '7' || $this->session->userdata('role') == '4')){ 		
 			return TRUE;
		}else{
		     return redirect(ROOT_URL.'modules/admin/logout');
		}
	}



}
