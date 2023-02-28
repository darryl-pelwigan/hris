     <!-- Core Scripts - Include with every page -->
    <script src="<?=base_url()?>assets/js/jquery-2.2.0.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?=base_url()?>assets/js/sb-admin.js"></script>
    <script src="<?=base_url()?>assets/js/jquery-ui.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.maskedinput.min.js"></script>
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

<script>
    /* start notification **/
     $(document).ready(function() {
                var notify = function() {
            $('#notification').load('<?=ROOT_URL?>notification.php', function() {
                $('#notify-loader').hide();
            });
        };
        // load content
        var interval = setInterval(notify, 10000);
        // pause on hover
        $('#notification').click(function() {
            clearInterval(interval);
        }, function() {
            interval = setInterval(notify, 10000);
        });
        
                
    });
      /* end notification **/
</script>