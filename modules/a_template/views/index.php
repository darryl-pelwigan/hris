<?php
/*
    start header
*/
$this->load->view('a_template/header');

/*
    start navigation
*/
$this->load->view('a_template/nav');

/*
    start content
*/
$this->load->view($view_content);



/*
    start script
*/
$this->load->view('a_template/script');

$this->load->view($get_plugins_js?$get_plugins_js:'plugins_js');
/*
    start footer
*/
$this->load->view('a_template/footer');