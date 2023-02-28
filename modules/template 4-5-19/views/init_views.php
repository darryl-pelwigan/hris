<?php
/*
    start header
*/
$this->load->view('template/header');

/*
    start navigation
*/
$this->load->view('template/nav');




/*
    start content
*/
$this->load->view($view_content);



/*
    start script
*/
$this->load->view('template/script');

$this->load->view($get_plugins_js?$get_plugins_js:'plugins_js');
/*
    start footer
*/
$this->load->view('template/footer');


