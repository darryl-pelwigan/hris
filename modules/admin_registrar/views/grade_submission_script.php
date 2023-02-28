<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/transition.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/collapse.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">




$.fn.changeSemSy = function(){
     $.ajax({
             type: "POST",
             url: '<?=base_url()?>check_submitted/check_submitted_registrar/change_sem_sy',
             data: $('#teacher_sched_sem_sy').serialize(),
             dataType: "json",
             error: function() {
                 console.log("ERROR");
             },
             success: function(data) {
                 location.reload();
             }
         });
};

var tablex = $('#student_grade_view_sched').dataTable({
    stateSave: true, // have to comment this out so on the next page load it still has paging, else it shows all rows from table
    "searching": true,
     "lengthMenu": [[30, 60, 100, -1], [30, 60, 100, "All"]],
    // filter: false,
});

$('#save_st_grade_view').on('submit', function (e) {
   e.preventDefault();
        // Force all the rows back onto the DOM for postback
        tablex.rows().nodes().page.len(-1).draw(false);  // This is needed
        if ($(this).valid()) {
            return true;
        }

    });

$('#set_all_check').change(function(){
  var el = $(this);
  var dt = $('#set_all_date');
    if(el.is(':checked')){
        $('.subjectid_date_view').val(dt.val());
    }
});

$(function () {




                $('.prelim_start').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm A',
                    defaultDate: '<?=$grade_submission['p']?($grade_submission['p'][0]->start_date):'' ?>'
                });
                $('.prelim_end').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm A',
                    defaultDate: '<?=$grade_submission['p']?($grade_submission['p'][0]->end_date):'' ?>'
                });

                $('.midterm_start').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm A',
                    defaultDate: '<?=$grade_submission['m']?($grade_submission['m'][0]->start_date):'' ?>'
                });
                $('.midterm_end').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm A',
                    defaultDate: '<?=$grade_submission['m']?($grade_submission['m'][0]->end_date):'' ?>'
                });

                $('.tenta_start').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm A',
                    defaultDate: '<?=$grade_submission['tf']?($grade_submission['tf'][0]->start_date):'' ?>'
                });
                $('.tenta_end').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm A',
                    defaultDate: '<?=$grade_submission['tf']?($grade_submission['tf'][0]->end_date):'' ?>'
                });

                // student view



    $.fn.updateGradeSubmission = function(type){
        var start_date = $('#'+type+'_start');
        var end_date = $('#'+type+'_end');
        if(start_date.val()!='' && end_date.val()!='' ){
                $.ajax({
                    type: 'POST',
                    dataType : 'json',
                    url : 'update_grade_submission',
                    data : {
                        start   : start_date.val(),
                        end     : end_date.val(),
                        type : type
                    },
                    error : function(){
                        swal({
                                  title: ' An Error has occured please refresh and try again.',
                                  text: 'checking',
                                  timer: 3500,
                                  type: 'warning',
                                });
                         location.reload();
                    },
                    success : function(data){
                        swal({
                                  title: ' SUBMISSION UPDATED',
                                  text: 'checking',
                                  timer: 3500,
                                  type: 'warning',
                                });
                    },
                });
        }else{
            alert('please insert start and end');
        }

    };

    $.fn.updateGradeViewStudent = function(type){
        var start_date = $('#st_'+type+'_start');
        var end_date = $('#st_'+type+'_end');
        if(start_date.val()!='' && end_date.val()!='' ){
                $.ajax({
                    type: 'POST',
                    dataType : 'json',
                    url : 'student_gradeview_date',
                    data : {
                        start   : start_date.val(),
                        // end     : end_date.val(),
                        type : type
                    },
                    error : function(){
                         swal({
                                  title: ' An Error has occured please refresh and try again.',
                                  text: 'checking',
                                  timer: 3500,
                                  type: 'warning',
                                });
                         location.reload();
                    },
                    success : function(data){
                         swal({
                                  title: ' STUDENT VIEWING UPDATED',
                                  text: 'checking',
                                  timer: 3500,
                                  type: 'info',
                                });
                    },
                });
        }else{
            alert('please insert start and end');
        }

    };

    $.fn.testDate = function(){
        console.log('benebe');
                        // $(this).datetimepicker({
                        //         format: 'MMM DD YYYY',
                        //         minDate: moment().subtract(2,'month'),
                        //         maxDate: moment().add(6, 'month')
                        // });
    };

});




</script>
