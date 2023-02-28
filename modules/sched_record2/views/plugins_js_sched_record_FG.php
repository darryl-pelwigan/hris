<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/FixedColumns-3.2.1/js/dataTables.fixedColumns.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/JSZip/jszip.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/request/sched_record.js"></script>
<script src="<?=base_url()?>assets/js/transmutation.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/transition.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/collapse.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
var sched_id='<?=$check_sched[0]['schedid']?>';
var type_subject = "<?=($subject_info['sched_query'][0]->type)?>";
var preloader='<div class="cssload-box-loading"></div><div class="preloader"><img src="<?=base_url('assets/images/devoops_getdata.gif')?>" class="devoops-getdata" alt="preloader"/></div>';


$.fn.sentresaonReset = function(schedid){
  var reason = $('#reset_message');
  if(schedid!='' && reason.val()!=='' ){
        $('.buttons-excel').click();
        console.log(reason.val());
                          $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/reset_all')?>",
                            data : {
                                reason : reason.val(),
                                sched_id : sched_id

                        },
                        dataType: "html",
                        error: function(){
                            alert('error');
                        },
                        success: function(data){
                            location.reload();
                        }
                });
    }
};
  $(document).ready(function(){

        $.fn.getGrades = function(type) {


                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_student_grades')?>",
                            data : {
                                sem : "<?=$set_sem?>",
                                sy : "<?=$set_sy?>",
                                sched_id : sched_id,
                                labunits:'',
                                type : type
                        },
                        dataType: "html",
                        error: function(){
                            alert('error');
                        },
                        success: function(data){
                            $('#gradres').html(data);
                            var percent = $('#percent').val();
                            var total_cs = $("#total_cs").val();
                            var total_exam = $("#total_exam_"+sched_id+"-"+type).val();
                            if(total_cs===''){total_cs='undefined';}
                            var trans_cs = $.getJSON("<?=base_url('assets/transmutation/')?>"+percent+'/'+total_cs+'.json', function(data) {
                                        $("#transmutation_json_cs").attr('value',JSON.stringify(data));
                                    });

                            var trans_exam = $.getJSON("<?=base_url('assets/transmutation/')?>"+percent+'/'+total_exam+'.json', function(data) {
                                        $("#transmutation_json_exam").attr('value',JSON.stringify(data));
                                    });

                            var grades_w = $('#gradres').width();
                            var t_width = $('#dataTables-example-p').width();

                             if((Number(t_width))>(Number(grades_w))){
                                 $('#dataTables-example-p').dataTable({
                                                                       "pageLength"  :100,
                                                                        fixedHeader: true,
                                                                        dom: 'Blfrtip',
                                                                        buttons: [
                                                                            'excelHtml5'
                                                                        ],
                                                                        "columnDefs": [
                                                                            { "width": "120px", "targets": 2 }
                                                                          ],
                                                                         // scrollY:        "1050px",
                                                                         scrollY:        false,
                                                                         scrollX:        true,
                                                                         scrollCollapse: true,

                                                                         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                                         fixedColumns:   {
                                                                                            leftColumns: 3,
                                                                                        },
                                                                     });
                             }else{
                                 $('#dataTables-example-p').dataTable({
                                                                          fixedHeader: true,
                                                                          "pageLength"  :100,
                                                                          dom: 'Blfrtip',
                                                                          buttons: [
                                                                            'excelHtml5'
                                                                            // 'csvHtml5',
                                                                            // 'pdfHtml5'
                                                                        ],
                                                                     });
                             }

                        }
                });
            };






            $.fn.exportToPDF = function(type) {
                 var params = [
                               'height='+screen.height,
                               'width='+screen.width,
                                  'scrollbars=1'
                              ].join(',');
                        var popup = window.open("<?=base_url('exporttopdf/export_mpdf/types/')?>?sched_id="+sched_id+"&sem="+sem+"&labunits="+labunits+"&type="+type+"",'winPop',params);
                        popup.moveTo(0,0);
            };


            $.fn.loadThis=function (type){
                      $.fn.getGrades(type);
             };

             $('#myTabs a.first-li').click(function (e) {
                 location.reload();
             });





           /*$.fn.finalGradeShow*/

           $.fn.finalGradeShow = function(type){
               $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/get_finalgrade')?>",
                                data : {
                                        sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                        sched_id : sched_id,
                                        labunits:labunits,
                                        type : type
                                },
                                dataType: "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    $('#examScoreModal').modal('hide');
                                     $('#gradres').html(data);
                                      $('#dataTables-example-p').dataTable({
                                         "pageLength"  :100
                                     });
                                }
                    });
           };





            $.fn.animateBg = function(el,classAddRem){
                    for(var x=0;x<classAddRem.length;x++){
                    el.addClass(classAddRem[x],300, "easeInBack");
                    el.removeClass(classAddRem[x],3000, "easeInBack");
                }

            };
            $.fn.viewOnly = function(){
                alert("View Only");
                return false;
            }

            $.fn.load_type = function(type_subject){
              if(type_subject!='Internship'){
                  if(sem==3)
                        $.fn.getGrades('<?=($check_sched['labunits']>0)?"lm":"m"?>');
                  else
                        $.fn.getGrades('<?=($check_sched['labunits']>0)?"lp":"p"?>');
              }else{
                 $.fn.getInternshipGrades('f');
              }
            };
             $.fn.load_type(type_subject);


    $.fn.submitGrades = function(type2,type,sched_id,leclab,comp_type){
         $.ajax({
            type  : 'POST',
            url   : '<?=base_url('check_grades_submitting')?>',
            data  : {
                      sem : "<?=$set_sem?>",
                      sy : "<?=$set_sy?>",
                      type2 : 'f',
                      type : 'f',
                      sched_id:sched_id,
                      leclab:leclab,
                      comp_type : comp_type
            },
            dataType : 'html',
            error : function(){
              console.log('error');
            },
            success : function(data){
             $('#gradeSubmissionModal .modal-body').html(data);
             $('#gradeSubmissionModal #gradeSubmissionButton').attr('onclick','$(this).submitGradesRegistrar(\''+type2+'\',\''+type+'\',\''+sched_id+'\',\''+leclab+'\',\''+comp_type+'\');');

             $('#gradeSubmissionModal').modal({
                                          backdrop: 'static',
                                          keyboard: false,
                                          show: true
                                        });
            }
        });
    };

    $.fn.submitGradesRegistrar  = function(type2,type,sched_id,leclab,comp_type){
       $.ajax({
            type  : 'POST',
            url   : '<?=base_url('sent_grades_registrar')?>',
            data  : {
                      type2 : type2,
                      type : type,
                      sched_id:sched_id,
                      leclab:leclab,
                      comp_type : comp_type
            },
            dataType : 'html',
            error : function(){
              console.log('error');
            },
            success : function(data){
             $('#gradeSubmissionModal .modal-body').html('<div class="alert alert-success">'+
                                                          '  <strong>Success!</strong> submitted grades'+
                                                          '</div>');
            }
        });
    };



        $.fn.requestGradesUpdate = function(type2,type,sched_id,leclab,comp_type){
      $.ajax({
            type  : 'POST',
            url   : '<?=base_url('check_update_grades_registrar')?>',
            data  : {
                      type2 : type2,
                      type : type,
                      sched_id:sched_id,
                      leclab:leclab,
                      comp_type : comp_type
            },
            dataType : 'html',
            error : function(){
              console.log('error');
            },
            success : function(data){
              $('#updateGradeSubmissionModal .modal-body').html(data);
             $('#updateGradeSubmissionModal #updateGradeSubmissionButton').attr('onclick','$(this).submitUpdateGradesRegistrar(\''+type2+'\',\''+type+'\',\''+sched_id+'\',\''+leclab+'\',\''+comp_type+'\');');

             $('#updateGradeSubmissionModal').modal({
                                                backdrop: 'static',
                                                keyboard: false,
                                                show: true
                                              });
            }
        });

    };

    $.fn.submitUpdateGradesRegistrar = function(type2,type,sched_id,leclab,comp_type){
      var reason = $('#updateGradeSubmission textarea#reason');
      var remarks = $('#updateGradeSubmission textarea#remarks');
      var request_id = $('#updateGradeSubmission #requestid');
      if(reason.val()===undefined){
          reason = remarks;
      }
      if(reason.val()==='' || reason.val().trim() ===''){
        reason.val('');
        alert('Reason is empty');
      }else{
        console.log('test');
      $.ajax({
            type  : 'POST',
            url   : '<?=base_url('sent_update_grades_registrar')?>',
            data  : {
                      reason : reason.val(),
                      type2 : type2,
                      type : type,
                      sched_id:sched_id,
                      leclab:leclab,
                      comp_type : comp_type,
                      request_id : request_id.val()
            },
            dataType : 'html',
            error : function(){
              console.log('error');
            },
            success : function(data){
              console.log(data);
             $('#updateGradeSubmissionModal .modal-body').html('<div class="alert alert-success">'+
                                                          '  <strong>Success!</strong> submitted grades'+
                                                          '</div>');
            }
        });
      }

    };

    $.fn.setRemarks = function(student_id){
              $.ajax({
            type  : 'POST',
            url   : '<?=base_url('add_remarks_grade')?>',
            data  : {
                      sched_id:sched_id,
                      student_id:student_id,
                      remarks:$(this).val(),
            },
            dataType : 'html',
            error : function(){
              console.log('error');
            },
            success : function(data){
              console.log(data);
             $('#updateGradeSubmissionModal .modal-body').html('<div class="alert alert-success">'+
                                                          '  <strong>Success!</strong> submitted grades'+
                                                          '</div>');
            }
        });
    };

    });

</script>



