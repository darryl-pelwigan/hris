<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/FixedColumns-3.2.1/js/dataTables.fixedColumns.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/JSZip/jszip.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons/js/buttons.html5.min.js"></script>





<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/transition.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/collapse.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>



<script type="text/javascript">
	var student_count = <?=$student_count?>;
$('.panel-heading-hover').hover(function(){
  var el = $(this).attr('data-panel-body');
  var panel_body = $('#'+el);
  if(!panel_body.hasClass( "in" )){
    panel_body.collapse("show");
    
  }else{
    panel_body.collapse("hide");
  }
});

	$('#shed_record_list').DataTable({
                                        "pageLength"  :100,
                                        fixedHeader: true,
                                        dom: 'Blfrtip',
                                        buttons: [
                                            'excelHtml5'
                                        ],
                                         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                         order : [[ 2, "asc" ]]
                                     });

$('.empty-exam').on('click',function(){
	if($(this).val() <= 0 ){
		$(this).val('');
	}
});
	$.fn.UpdateGrade = function(studentid,sched_id,typed){

		var el = $('#'+studentid+'_'+sched_id+'_'+typed);
		$.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_grades/update_grades_fg')?>",
                            data : {
                                sched_id : sched_id,
                                studentid:studentid,
                                typed : typed,
                                grade : el.val()
                        },
                        dataType: "json",
                        error: function(){
                                swal({
                                  title: 'ERROR SUBMITTING GRADES',
                                  html: '<h4 class="red">PLEASE REFRESH AND TRY AGAIN</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
                        },
                        success: function(data){
                          var typex = 'Tentative';
                                  

                          if(data[0] == 1){
                              var f_remarks = '';
                                var final = 0;
                                var mid = $('#'+studentid+'_'+sched_id+'_tenta');
                                var tent = $('#'+studentid+'_'+sched_id+'_tenta');
                                      <?php if($check_sched[0]['semester'] != 3 || $smpt){ ?>
                                              var pre = $('#'+studentid+'_'+sched_id+'_tenta');
                                              final = parseFloat(pre.val()) + parseFloat(mid.val()) + parseFloat(tent.val());

                                              final = final /3 ;
                                      <?php }else{ ?>
                                              final = parseFloat(mid.val()) + parseFloat(tent.val());
                                              final = final /2 ;
                                      <?php } ?>
                                      if(final.toFixed(2) >= 75){
                                          f_remarks = 1;
                                          final = final.toFixed(2);
                                      }else if(final.toFixed(2) <= 74.9 && final.toFixed(2) >= 74.5 ){
                                          final = final.toFixed(2);
                                          f_remarks = 2;
                                      }else{
                                        console.log(final);
                                          final = final.toFixed(2);
                                          f_remarks = 2;
                                      }
                                      var checker = 0;
                                       <?php if($check_sched[0]['semester'] != 3  || $smpt){ ?>
                                        if( parseFloat(pre.val()) > 0 && parseFloat(mid.val()) > 0 && parseFloat(tent.val()) > 0 ){
                                            $('#'+studentid+'_'+sched_id+'_final').text(final);
                                            checker = 1;
                                        }
                                      <?php }else{ ?>
                                        if( parseFloat(mid.val()) > 0 && tent.val() > 0 ){
                                          $('#'+studentid+'_'+sched_id+'_final').text(final);
                                           checker = 1;
                                        }
                                      <?php } ?>

                                      var exists = $('#remarks_'+studentid+' option').filter(function(){ return $(this).val() == 'Failed'; }).length;


                                     if(f_remarks == 2 && exists == 0){
                                        var options = $('#remarks_'+studentid+' option').add($('<option value="Failed" data_index="2">Failed</option>')).sort(function(a, b) {
                                                      return $(a).attr('data_index') < $(b).attr('data_index') ? -1 : $(a).attr('data_index') > $(b).attr('data_index') ? 1 : 0;
                                                  }).appendTo('#remarks_'+studentid);
                                     }
                                      


                                      if(checker == 1){
                                        document.getElementById("remarks_"+studentid).options.selectedIndex = f_remarks;
                                          $.fn.setRemarks(sched_id , studentid , typed);
                                      }



                                      if(f_remarks == 1){
                                          $('#'+studentid+'_'+sched_id+'_final').removeClass('failed');
                                           $('#'+studentid+'_'+sched_id+'_final').addClass('passed');
                                          
                                           $('#remarks_'+studentid+' option[value="Failed"]').remove();

                                      }else{
                                          $('#'+studentid+'_'+sched_id+'_final').removeClass('passed');
                                          $('#'+studentid+'_'+sched_id+'_final').addClass('failed');
                                          
                                          
                                      }


                                  
                          }else{
                            swal({
                                  title: 'ERROR UPDATING GRADES',
                                  html: '<h4 class="red">ALLOWED GRADES 0-99</h4><br />'+
                                        'YOUR STUDENT : <strong>'+data[1][0].studid+'</strong>  , '+data[1][0].firstname+' '+data[1][0].lastname+'  HAS NOT BEEN UPDATED.'

                                  ,
                                  timer: 3500,
                                  type: 'error',
                                });
                          }
                                
				                
                        	

				
                        }
                });
		
	};




$.fn.setRemarks = function(sched_id , studentid,typed = null){

    var e = document.getElementById("remarks_"+studentid);
    var strUser = e.options[e.selectedIndex].value;

   
    $.ajax({
                    type: "POST",
                    url: "<?=base_url('sched_grades/update_grades_remarks')?>",
                    data : {
                            sched_id : sched_id,
                            studentid:studentid,
                            remarks : strUser
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                        // swal({
                        //           title: ' REMARKS UPDATED',
                        //           text: 'YOUR STUDENT :'+data[0].studid+'  , '+data[0].firstname+' '+data[0].lastname+'  HAS BEEN UPDATED.',
                        //           timer: 3500,
                        //           type: 'warning',
                        //         });
                        }
            });
};




$.fn.submitGRADES = function(type,sched_id){

    swal({
      title: 'Are you sure?',
      text: 'You will submit '+type+' GRADES  for review?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      animation: false,
      customClass: 'animated bounceInDown'
    }).then(function() {
        $.ajax({
                    type: "POST",
                    url: "<?=base_url('sched_grades/submit_grade_review_fg')?>",
                    data : {
                            sched_id : sched_id,
                            type:type,
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                      if(data[0] == 1){
                        swal({
                                  title: 'Submitted',
                                  text: 'Your '+type+' GRADES has been sent for Review for your Dean and Resgistrar.',
                                  timer: 3500,
                                  type: 'success',
                                }).then(function(){
                                        window.location.reload();
                            });
                      }else{
                            swal({
                                  title: 'Error',
                                  text: data[1],
                                  type: 'error',
                                });
                      }
                    }
            });

    }, function(dismiss) {
      // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
      if (dismiss === 'cancel') {
        swal(
          'Cancelled',
          ' Submission for review not sent.',
          'error'
        )
      }
    });

};


$.fn.requestForUpdate = function(type,sched_id){

   $.ajax({
                    type: "POST",
                    url: "<?=base_url('sched_grades/get_request_remarks')?>",
                    data : {
                            sched_id : sched_id,
                            type:type,
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                        if(data[0] == 1){
                                          swal({
                                              title: 'Request',
                                              input: 'textarea',
                                              inputPlaceholder : 'Enter your message here.',
                                              html : data[1],
                                              type: 'warning',
                                              showCancelButton: true,
                                              confirmButtonColor: '#3085d6',
                                              cancelButtonColor: '#d33',
                                              confirmButtonText: 'Submit',
                                              cancelButtonText: 'Cancel',
                                              animation: false,
                                              customClass: 'animated bounceInDown'
                                            }).then(function( text ) {
                                               if (text) {
                                                  $.ajax({
                                                            type: "POST",
                                                            url: "<?=base_url('sched_grades/submit_grade_update')?>",
                                                            data : {
                                                                    sched_id : sched_id,
                                                                    type:type,
                                                                    message : text
                                                            },
                                                            dataType: "json",
                                                            error: function(){
                                                                alert('error');
                                                            },
                                                            success: function(data){
                                                              if(data[0] == 1){
                                                                swal({
                                                                          title: 'Submitted',
                                                                          text: 'Your '+type+' GRADES has been sent for requesting update.',
                                                                          timer: 3500,
                                                                          type: 'success',
                                                                        }).then(function(){
                                                                                window.location.reload();
                                                                    });
                                                              }else{
                                                                    swal({
                                                                          title: 'Error',
                                                                          text: data[1],
                                                                          type: 'error',
                                                                        });
                                                              }
                                                            }
                                                    });
                                                }else{
                                                   swal("Please enter a Message.");
                                                }

                                            }, function(dismiss) {
                                              // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                                              if (dismiss === 'cancel') {
                                                swal(
                                                  'Cancelled',
                                                  ' Submission for request update not sent.',
                                                  'error'
                                                )
                                              }
                                            });

                          }else{
                            swal({
                                  title: 'Error',
                                  text: data[1],
                                  type: 'error',
                                });
                      }

                                             }
            });

};

 $.fn.importDataCs = function(sched_id,cs_desc,typed,type){
                      $('#classImportCsvDataCSELabel span').text(typed);
                      $('#cs_i_title').text(cs_desc);
                        $('input#cs_imp_scores').attr('onblur','$(this).checkImportCsv("'+sched_id+'","'+typed+'","'+type+'");');
                        $('button#cs_imp_sent').attr('disabled',true);
                        $('#classImportCsvDataCSE').modal('show');
                        return false;
      };


 $.fn.checkImportCsv = function(sched_id,typed,type){
   var data_inpt = $('#cs_imp_scores').val();
   var xx = data_inpt.split(" ");
  if(student_count==(xx.length)){
    $('button#cs_imp_sent').attr('disabled',false).attr('onclick','$(this).importNow(\''+sched_id+'\',\''+typed+'\',\''+type+'\');');

  }else{
    swal({
          title: 'ERROR IMPORTING GRADES',
          html: '<h4 class="red">STUDENT COUNT DOESN\'T MATCH</h4><br />' ,
          timer: 3500,
          type: 'error',
        });
  }
  
 };


  $.fn.importNow = function(sched_id,typed,type) {
      var data_inpt = $('#cs_imp_scores').val();
      var xx = data_inpt.split(" ");
         $('#shed_record_list > tbody  > tr').each(function(i , row) {
            var tr = $(this);
            tr.find('td').each(function(c,cell){
              if(c === 1 ){
               var td_input = $('#'+$(cell).text()+'_'+sched_id+'_'+type);
               td_input.val(xx[i]).trigger('blur');
              }

            });

            $('#classImportCsvDataCSE').modal('hide');

             swal({
                title: 'SUCCESSFULLY IMPORT GRADES',
                html: '<h4 class="red">Your Grades has been successfully updated.</h4><br />' ,
                timer: 3500,
                type: 'info',
              });
  

        });   
 };

</script>
