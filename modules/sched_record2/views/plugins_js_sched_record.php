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
        window.open( $('#export_to_excel').attr('href') , '_blank' );
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
                          // console.log(data);
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
                                labunits:labunits,
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
                                                                         "pageLength"  :100,
                                                                          dom: 'Blfrtip',
                                                                          buttons: [
                                                                              'excelHtml5'
                                                                              // 'csvHtml5',
                                                                              // 'pdfHtml5'
                                                                          ]
                                                                     });
                             }

                        }
                });
            };



            $.fn.getInternshipGrades = function(type) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_intern_record')?>",
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
                            $('#gradres').html(data);
                            $('#dataTables-example-p').dataTable({
                               "pageLength"  :100
                           });
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
            //
            $.fn.setSettings = function(type,coursecode){
                $('#percentage').attr('oninput','$(this).checkPercentage('+coursecode+');');
                 $('#schedSettingsModal').modal('show');
            };

            $.fn.checkPercentage = function(coursecode){
                var prnctge = Number($('#percentage').val());
                if(prnctge<=85 && prnctge>=45){
                    $('#updateSchedSettings').attr('disabled',false);
                    $('#updateSchedSettings').attr('onclick','$(this).sentSchedPercentage('+coursecode+');');
                     console.log(prnctge);
                }else{
                    console.log('ERROR');
                     $('#updateSchedSettings').attr('disabled',true);
                     $('#updateSchedSettings').attr('onclick',false);
                }

            };

            $.fn.sentSchedPercentage = function(coursecode){
               var prnctge = Number($('#percentage').val());
               var type=$("#_this_type").val();
                if(prnctge<=85 && prnctge>=45){
                    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/update_sched_prcntge')?>",
                            data : {
                                       prnctge : prnctge,
                                       sched_id : sched_id,
                                       coursecode : coursecode
                            },
                            dataType: "json",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                console.log(data);
                               // if(data===false){
                               // }else{

                                  // $('#schedSettingsModal').modal('hide');
                                  // $('.modal-backdrop').fadeOut();
                                  // $('body').removeClass('modal-open');
                                  // $.fn.getGrades(type);
                               // }
                            }
                    });
                }else{
                    console.log('ERROR');
                }
            };

            $.fn.loadThis=function (type){
                  if(type_subject!='Internship'){
                      $.fn.getGrades(type);
                  }else{
                      $.fn.getInternshipGrades(type);
                  }
             };

             $('#myTabs a.first-li').click(function (e) {
                 var type = ( $(this).attr('href').slice(1).toLowerCase()[0]);
                 if(type!='f'){
                       if(type=='l'){
                           type=( $(this).attr('href').slice(1).toLowerCase()[1]!='t' )? $(this).attr('href').substr(1,2).toLowerCase() :'ltf';
                       }else{
                           type = ( $(this).attr('href').slice(1).toLowerCase()[0]!='t' )? $(this).attr('href').slice(1).toLowerCase()[0] :'tf';
                       }
                       $.fn.loadThis(type);
                }else{
                     if(type_subject!='Internship'){
                        $.fn.finalGradeShow(type);
                    }else{
                        $.fn.getInternshipGrades(type);
                    }
                }
             });

             /*Class standing*/

             $.fn.checkCScomputation  = function(type,schedid=sched_id){
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/check_cs_comp')?>",
                            data : {
                                        sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                        sched_id : schedid,
                                        labunits:labunits,
                                        type : type
                            },
                            dataType: "json",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                               if(data===false){

                                     $('#csConfigModal').modal('show');
                                      $('#updateConfCSButton').attr('onclick','$(this).setCSconfig("'+type+'","'+schedid+'")');
                               }else{
                                    if(data[0].comp_type==='wc'){
                                        $.fn.getViewCsWC(type,schedid);
                                    }else if(data[0].comp_type==='nsub'){
                                        $.fn.getViewCsNSUB(type,schedid);
                                    }else if(data[0].comp_type==='wsub'){
                                        $.fn.getViewCsWSUB(type,schedid);
                                    }else if(data[0].comp_type==='etools'){
                                        $.fn.getViewCsETOOLS(type,schedid);
                                    }else if(data[0].comp_type==='contg'){
                                        $.fn.getViewCsCONTG(type,schedid);
                                    }else{
                                        console.log('undefined error');
                                    }
                               }
                            }
                });
            };

            $.fn.setCSconfig =function(type,schedid=sched_id){
                var comp_type = $("input[name='cs_computation']:checked","#csConfig").val();
                  $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/set_computation_type')?>",
                            data : {
                                       sched_id : schedid,
                                       comp_type:comp_type,
                                       type : type
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                  $('#csConfigModal').modal('hide');
                                        $('.modal-backdrop').fadeOut();
                                        $('body').removeClass('modal-open');
                                $.fn.getGrades(type);
                            }
                });
            };



            $.fn.getViewCsWC = function(type,schedid=sched_id) {
                $('#gradres').html(preloader);
                $("#_this_type").val(type);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_sched_cs_wc')?>",
                            data : {
                                       sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                       sched_id : schedid,
                                       labunits:labunits,
                                       type : type
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                               $('#gradres').html(data);
                            }
                });
            };
            $.fn.getViewCsCONTG = function(type,schedid=sched_id) {
                $('#gradres').html(preloader);
                $("#_this_type").val(type);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_sched_cs_contg')?>",
                            data : {
                                       sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                       sched_id : schedid,
                                       labunits:labunits,
                                       type : type
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                               $('#gradres').html(data);
                            }
                });
            };

            $.fn.getViewCsNSUB = function(type,schedid=sched_id) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_sched_cs_nsub')?>",
                            data : {
                                        sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                       sched_id : schedid,
                                       labunits:labunits,
                                       type : type
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                               $('#gradres').html(data);
                            }
                });
            };

            $.fn.getViewCsWSUB = function(type,schedid=sched_id) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_sched_cs_wsub')?>",
                            data : {
                                         sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                       sched_id : schedid,
                                       labunits:labunits,
                                       type : type
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                               $('#gradres').html(data);
                            }
                });
            };

            $.fn.getViewCsETOOLS = function(type,schedid=sched_id) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_sched_cs_etools')?>",
                            data : {
                                        sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                       sched_id : schedid,
                                       labunits:labunits,
                                       type : type
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                               $('#gradres').html(data);
                            }
                });
            };

            /*view total lec lab*/
            $.fn.getViewTotal =function(type){
                $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/leclab')?>",
                                data : {
                                         sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                        sched_id : sched_id,
                                        labunits:labunits,
                                        lecunits:lecunits,
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


             $.fn.updateExamScore = function(type,sched_id) {
                var items=$('#ex_items').val();
                if(items!='default'){
                    $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/update_exam_score')?>",
                                data : {
                                        sem : "<?=$set_sem?>",
                                        sy : "<?=$set_sy?>",
                                        items_n : items,
                                        sched_id : sched_id,
                                        lecunits:lecunits,
                                        labunits:labunits,
                                        type : type
                                },
                                dataType: "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    $('#examScoreModal').modal('hide');
                                    $.fn.loadThis(type);
                                }
                    });
                }else{
                     alert("Select Exam Items");
                }


            };



             $.fn.changeModalCs=function(schedid,teacherID,type){
                $('#classStandingModalAddButton').attr('onclick','$(this).createCS("'+schedid+'","'+teacherID+'","'+type+'");');
                $('#classStandingModalAdd').modal('show');
            };

            $.fn.changeModalExam=function(schedid,teacherID,labunits,type){
                $('#updateExamButton').attr('onclick','$(this).updateExamScore("'+type+'","'+schedid+'");');
                $('#examScoreModal').modal('show');
                     $(document).one('hidden.bs.modal', '#examScoreModal', function (event) {
                            var cc=$('#_this_type').val();
                                if(cc!=type && String(cc)!='undefined'){
                                        $.fn.loadThis(type);
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
                swal(
                      'Not Authorized!',
                      'You are not permittted to view this data.',
                      'warning'
                    );
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
             $('#gradeSubmissionModal .modal-body').html(data);
<?php
if(!$this->session->flashdata('error')){
?>

             $('#gradeSubmissionModal #gradeSubmissionButton').attr('onclick','$(this).submitGradesRegistrar(\''+type2+'\',\''+type+'\',\''+sched_id+'\',\''+leclab+'\',\''+comp_type+'\');');
<?php
}
?>
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

    });



</script>

<?php if($check_sched["labunits"]>0 && $check_sched["lecunits"]>0): ?>
<script>
 $(document).ready(function(){
            $.fn.checkPercentMax =  function(){
                      var leclab_id=$(this).attr('id');
                      var lec,lab,totalx;
                        lec=$('#percentage_lecture').val();
                        lab=$('#percentage_laboratory').val();
                        if(parseInt(lec)<=99){
                            if(leclab_id=='percentage_lecture' ){
                                $('#percentage_laboratory').attr('value',(100-lec));
                            }else{
                                $('#percentage_lecture').attr('value',(100-lab));
                            }
                            lec=$('#percentage_lecture').val();
                            lab=$('#percentage_laboratory').val();
                            totalx=parseInt(lec)+parseInt(lab);
                            $('#percentage_total').attr('value',totalx);
                        }else{
                            alert("Lecture must be less than 100");
                            lec=$('#percentage_lecture').val('');
                            lab=$('#percentage_laboratory').val('');
                            $('#percentage_total').val('');
                         }
                   };
                    $.fn.percentage = function(schedid) {
                        var type=$('#type').val();
                    var lec=$('#percentage_lecture').val();
                    var lab=$('#percentage_laboratory').val();
                    var data_cs_array={};
                                        data_cs_array["schedid"]=schedid;
                                        data_cs_array["labunits"]=labunits;
                                        data_cs_array["lecunits"]=lecunits;
                                        data_cs_array["lec"]=lec;
                                        data_cs_array["lab"]=lab;
                    var data=$.param(data_cs_array);
                      $.ajax({
                                  type: "POST",
                                  url: "<?=base_url('sched_record2/sched_total_leclab/set_percentage')?>",
                                  data : data,
                                  dataType: "html",
                                  error: function(){
                                      alert('error');
                                  },
                                  success: function(data){
                                        $('#percentage_modal').modal('hide');
                                        $.fn.getViewTotal(type);
                                  }
                      });
                   };

});
</script>
<?php endif; ?>

