<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/request/sched_record.js"></script>
<script src="<?=base_url()?>assets/js/transmutation.js"></script>


<script type="text/javascript">



var sched_id='<?=$check_sched[0]['schedid']?>';
var type_subject = "<?=($subject_info['sched_query'][0]->type)?>";
var preloader='<div class="cssload-box-loading"></div><div class="preloader"><img src="<?=base_url('assets/images/devoops_getdata.gif')?>" class="devoops-getdata" alt="preloader"/></div>';


 	$(document).on("change", ".fnlg_remarks", function() {
 		var this_id = $(this).attr('id');
              $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_finalgrade_record/update_remarks')?>",
                            data : {
                                student_id : this_id,
                                sched_id : sched_id,
                                remarks:$(this).val(),
                                labunits:labunits,
                                lecunits:lecunits
                        },
                        dataType: "html",
                        error: function(){
                            alert('error');
                        },
                        success: function(data){
                        }
                });
 	});


    $(document).ready(function(){
        $.fn.getGrades = function(type) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_student_grades')?>",
                            data : {
                                sem : sem,
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

            $.fn.getInternshipGrades = function(type) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_intern_record')?>",
                            data : {
                                sem : sem,
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
             $.fn.getViewCs = function(type,schedid=sched_id) {
                $('#gradres').html(preloader);
                $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/get_sched_cs')?>",
                            data : {
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
                                        sem : sem,
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

    });

</script>

<?php if($check_sched["labunits"]>0): ?>
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

