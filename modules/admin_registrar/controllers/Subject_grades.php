<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_grades extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->load->module('template/template');
        $this->load->module('admin_registrar/admin_reg');
        $this->load->model('admin_registrar/admin_reg_model');
        $this->load->model('admin_registrar/grades_submission_model');
         $this->load->model('sched_record2/grade_submission_model');
         $this->load->model('sched_record2/sched_record_model');
        $this->admin_reg->_check_login();
    }


    public function grades(){
        return 'test';
    }




}