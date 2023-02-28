<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#example').dataTable();
    $.fn.removeAdviser = function(sched_id,course_code){
        var el = $(this);
        var t_adviser = $('#sched_id_'+sched_id+'_'+course_code);
        var t_adviser_td = t_adviser.closest('td');

          $.ajax({
                    type: "POST",
                    url: "<?=base_url('nursing_dept/delete_adviser')?>",
                    data : {
                            sched_id : sched_id,
                            adviser : t_adviser.val(),
                    },
                    dataType: "html",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                        if(data!=0){
                            el.removeClass('btn-danger');
                            el.addClass('btn-success');
                            el.children('i').removeClass('fa-times');
                            el.children('i').addClass('fa-check');
                            el.attr('onclick','$(this).addAdviser(\''+sched_id+'\',\''+course_code+'\')');
                            t_adviser_td.children("div").removeClass('hide');
                            $('#adviser_id_'+sched_id+'_'+course_code).remove();
                            $('#adviser_id_s_'+sched_id+'_'+course_code).remove();
                        }
                    }
            });

    };

    $.fn.addAdviser = function(sched_id,course_code){
        var el = $(this);
        var t_adviser = $('#sched_id_'+sched_id+'_'+course_code);
        var t_adviser_td = t_adviser.closest('td');
        console.log();
          $.ajax({
                    type: "POST",
                    url: "<?=base_url('nursing_dept/assign_adviser')?>",
                    data : {
                            sched_id : sched_id,
                            adviser : t_adviser.val(),
                    },
                    dataType: "html",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                        if(data!=0){
                            el.attr('onclick','$(this).removeAdviser(\''+sched_id+'\',\''+course_code+'\')');
                            el.removeClass('btn-success');
                            el.addClass('btn-danger');
                            el.children('i').removeClass('fa-check');
                            el.children('i').addClass('fa-times');
                            $('#adviser_id_'+sched_id+'_'+course_code).remove();
                            $('#adviser_id_s_'+sched_id+'_'+course_code).remove();

                                t_adviser.closest('div').addClass('hide');
                                t_adviser_td.append('<input class="adviser_id_i" type="hidden" value="'+course_code+'" id="adviser_id_'+sched_id+'_'+course_code+'">'+
                                                    '<span class="adviser_id_i_s" id="adviser_id_s_'+sched_id+'_'+course_code+'">'+t_adviser.children("option").filter(":selected").text()+'</span>');
                        }
                    }
            });


    };
});
</script>