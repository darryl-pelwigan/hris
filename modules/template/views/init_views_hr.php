<?php
/*
    start header
*/
$this->load->view('template/header_hr');

/*
    start navigation
*/
$this->load->view('template/nav_hr');




/*
    start content
*/
$this->load->view($view_content);
if(isset($view_modals)){
	$this->load->view($view_modals);
}


/*
    start script
*/
$this->load->view('template/script_hr');

$this->load->view($get_plugins_js?$get_plugins_js:'plugins_js');
if(isset($get_dt_js)){
	$this->load->view($get_dt_js?$get_dt_js:'get_dt_js');
}
/*
    start footer
*/
$this->load->view('template/footer_hr');


