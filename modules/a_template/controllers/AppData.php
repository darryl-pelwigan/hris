<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AppData extends MY_Controller {

    function __construct(){
        $this->load->module('template/template');
        parent::__construct();

    }

    public function get_sysem(){
        $data['sem_sy']=$this->template->get_sem_sy('sy,sem');

        echo json_encode($data);
    }

    public function app_login(){
        echo 'angel cute';
        echo json_encode($this->input->post(''));
        die(var_dump($_POST));
    }

}