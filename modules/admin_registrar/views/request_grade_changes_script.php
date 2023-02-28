<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/transition.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/collapse.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

$(function () {
                        $('.datetimepicker1').datetimepicker({
                                format: 'YYYY-MM-DD HH:mm A',
                                minDate: moment().subtract(0,'month'),
                                maxDate: moment().add(1, 'month'),
                        });


    $.fn.sentGradeRequest = function(checker){
        $(this).attr('disabled',true);
        var date_validity = $('#extend_date');
        var remarks = $('#remarks');

        if(remarks.val()==='' || remarks.val().trim() ==='' ||  date_validity.val()==='' || date_validity.val().trim() ===''  ){
            alert('Please check you validity date and remakrs must not be empty.');
            $(this).attr('disabled',false);
        }else{

             $.ajax({
                type  : 'POST',
                url   : '<?=base_url('validate_update_grades_registrar')?>',
                data  : {
                        request : $('#requestid').val(),
                        date_validity :date_validity.val(),
                        remarks : remarks.val(),
                        checker : checker,
                },
                dataType : 'html',
                error : function(){
                  console.log('error');
                },
                success : function(data){
                    $('#status').removeClass('hidden');
                    $('#status').html('Successfull Grant Teacher to update grades');
                    $('#checkGradesUpdateRequest').addClass('hidden');
                }
            });
        }
    };
});

</script>
