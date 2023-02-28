  <!DOCTYPE html>
  <html>
  <head>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon -->
<link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">

<title>Pines City Colleges</title>

<!-- Core CSS - Include with every page -->
<link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?=base_url()?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

<!-- SB Admin CSS - Include with every page -->
<link href="<?=base_url()?>assets/css/sb-admin.css" rel="stylesheet">
    

    <link href="<?=base_url()?>assets/css/navbar-fixed-top.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/front.css" rel="stylesheet" />
    
    <?php $this->load->view($get_plugins_css?$get_plugins_css:'plugins_css'); ?> 
    
    
  </head>
  <body>    <!-- Static navbar -->

<?php

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


