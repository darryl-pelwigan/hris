<script type="text/javascript">

	var allow_view = '<?=isset($allow_view[0]) ? 1 : 0 ?>';

</script>

<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/request/teachersched.js"></script>

<script type="text/javascript">
$('#grade_memo').DataTable();
</script>
<script type="text/javascript">
    <?php if($_SESSION['user_login'] == 1): ?>
        $('#privacyModal').modal({
	        backdrop: 'static',
	        keyboard: false
	    });
    <?php endif; ?>

    $('#privacyModal').on('hidden.bs.modal', function () {
       <?php $_SESSION['user_login'] = 0; ?>
    });

$.fn.get_transmutation = function(){
    var  base_trans = $('#base_trans').val();
    var  total_score = $('#total_score').val();
    if(total_score != '' && base_trans != ''){
         $.ajax({
                    type: "POST",
                    url: "<?=base_url('teachersched/get_transmutation')?>",
                    data : {
                            base_trans : $('#base_trans').val(),
                            total_score : $('#total_score').val(),

                    },
                    dataType: "json",
                    error: function(){
                        swal({
                              title: 'ERROR SUBMISSION',
                              html: '<h4 class="red">Please refresh and try again.</h4><br />',
                              timer: 3500,
                              type: 'error',
                            });
                    },
                    success: function(data){
                         if ( $.fn.DataTable.isDataTable('#transmutation') ) {
                                 $('#transmutation').DataTable().destroy();
                        }
                        var tr = '';
                        $.each(data[0],function(score, val){
                            tr += '<tr><td>'+score+'</td><td>'+val+'</td></tr>';
                        });

                        $('#transmutation>tbody').html(tr);
                        $('#transmutation').dataTable();

                    }
            });
    }else{
        swal({
              title: 'ERROR SUBMISSION',
              html: '<h4 class="red">Please add total score and base.</h4><br />',
              timer: 3500,
              type: 'error',
            });
    }

};

</script>

