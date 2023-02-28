<script src="<?=base_url()?>assets/js/transmutation.js"></script>

<script type="text/javascript">
var sem="<?=$sem_sy['sem_sy'][0]->sem?>";
var sy="<?=$sem_sy['sem_sy'][0]->sy?>";
var preloader='<div class="cssload-box-loading"></div><div class="preloader"><img src="<?=base_url('assets/images/devoops_getdata.gif')?>" class="devoops-getdata" alt="preloader"/></div>';

$(document).ready(function() {

        $.fn.getGrades = function(sem,sy,type="NULL",school="NULL"){
            $('#grades').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('student_grades/get_grades_record')?>",
                            data : { 
                                sem : sem,
                                sy : sy,
                                school : school,
                                type : type
                        },
                        dataType: "html",
                        error: function(){
                            alert('error');
                        },
                        success: function(data){
                                $('#grades').html(data);
                                console.log(data);
                        }
                });
        };

       
        $('#viewGrade').on( "submit", function( event ) {
            event.preventDefault();
            var sem_s=$('#sem').val();
            var sy_s=$('#year').val();
            var opt_group=($('#year :selected').closest('optgroup').prop('label'));
            if(String(opt_group)!='undefined' && String(opt_group)!='School Year' )
                {
                    var opt_type=($('#year :selected').closest('optgroup').attr('data-type'));
                     $.fn.getGrades(sem_s,sy_s,opt_type,opt_group);
                }
            else 
                $.fn.getGrades(sem_s,sy_s);
        });

         $.fn.getGrades(sem,sy);

 });
</script>


<script type="text/javascript">

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

</script>