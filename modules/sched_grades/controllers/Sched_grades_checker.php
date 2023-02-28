<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_grades_checker extends MY_Controller {

	 function __construct()
    {
        parent::__construct();
		
		
    }

    
    public function check_subject_type($check_sched){

    	
    	
    	$fg_only =   $this->fg_only_model->get_fg_only($check_sched[0]['subjectid']);
    	if($fg_only){
    		$data['fg_only'] = true;
    		$data['completion_days'] = $this->fg_only_model->get_completion_days_type('fg')[0]->days;
    	}else{
    		$data['fg_only'] = false;
    		$data['completion_days'] = $this->fg_only_model->get_completion_days_type('pmtf');
    	}
    	return $data;
    }


    public function summer_pmtf($check_sched){

        
        $fg_only =   $this->fg_only_model->get_sem3_pmtf($check_sched[0]['subjectid']);
        if($fg_only){
            $data = true;
        }else{
            $data= false;
        }
        return $data;
    }


    public function check_st_view($check_sched){
        $this->load->model('admin_registrar/grades_submission_model');

        $viewx = $this->grades_submission_model->get_st_viewgrades_subject($check_sched[0]['subjectid']);
         $data = false;
        if($viewx){
            $dt = unix_to_human(strtotime($viewx[0]->date_view));
            if( human_to_unix($dt) > now()  ){
               $data = true;
            }
        }

        return $data;


    }
    

}
