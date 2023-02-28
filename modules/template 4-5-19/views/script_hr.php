     <!-- Core Scripts - Include with every page -->
    <script src="<?=base_url()?>assets/js/jquery-2.2.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <!-- <script src="<?=base_url()?>assets/sb-admin-gh/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script> -->
    <!-- SB Admin Scripts - Include with every page -->
    <!-- SB Admin Scripts - Include with every page -->
    <!-- <script src="<?=base_url()?>assets/sb-admin-gh/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

    <script src="<?=base_url()?>assets/js/jquery-ui.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.maskedinput.min.js"></script>

    <!-- <script src="<?=base_url()?>assets/sb-admin-gh/vendor/jquery-easing/jquery.easing.min.js"></script> -->
     

    <!-- Custom Theme JavaScript -->
    <script src="<?=base_url()?>assets/sb-admin-gh/js/sb-admin.js"></script>
<script >
var APP_PATH ='<?=base_url()?>';
<?php if($this->session->userdata('new_sem_Sy')){ ?>
var SEM ="<?=$this->session->userdata('new_sem_Sy')['sem']?>";
var SY ="<?=$this->session->userdata('new_sem_Sy')['sy']?>";
<?php }else{?>
var SEM ='<?=$sem_sy['sem_sy_w']['sem']?>';
var SY ='<?=$sem_sy['sem_sy_w']['sy']?>';
<?php }?>
</script>
