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
	
	$('#shed_record_list').dataTable({
                                        "pageLength"  :100,
                                        fixedHeader: true,
                                        dom: 'Blfrtip',
                                        buttons: [
                                            'excelHtml5'
                                        ],
                                         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                     });


	$.fn.UpdateGrade = function(studentid,sched_id,typed){

		var el = $('#'+studentid+'_'+sched_id+'_'+typed);
		$.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_grades/update_grades')?>",
                            data : {
                                sched_id : sched_id,
                                studentid:studentid,
                                typed : typed,
                                grade : el.val()
                        },
                        dataType: "json",
                        error: function(){
                            alert('error');
                        },
                        success: function(data){
                                var final = 0;
                                var mid = $('#'+studentid+'_'+sched_id+'_mid');
                                var tent = $('#'+studentid+'_'+sched_id+'_tent');
                            <?php if($check_sched[0]['semester'] != 3){ ?>
                                    var pre = $('#'+studentid+'_'+sched_id+'_pre');
                                    
                                    final = parseFloat(pre.val()) + parseFloat(mid.val()) + parseFloat(tent.val());
                                    final = final /3 ;
                            <?php }else{ ?>
                                    final = parseFloat(mid.val()) + parseFloat(tent.val());
                                    final = final /2 ;
                            <?php } ?>
                            if(final.toFixed(2) >= 75){
                                final = final.toFixed(0);
                                document.getElementById("remarks_"+studentid).options.selectedIndex = 1;
                                $.fn.setRemarks(sched_id , studentid , typed);
                            }else if(final.toFixed(2) <= 74.9 && final.toFixed(2) >= 74.5 ){
                                final = final.toFixed(2);
                            }else{
                                final = final.toFixed(2);
                                document.getElementById("remarks_"+studentid).options.selectedIndex = 2;
                                $.fn.setRemarks(sched_id , studentid , typed);
                            }

                            $('#'+studentid+'_'+sched_id+'_final').text(final);
                            

                            var typex = '';
                        if(typed == 'pre'){
                            typex = 'PRELIM';
                        }else if(typed == 'mid'){
                            typex = 'Midterm';
                        }else if(typed == 'tenta'){
                            typex = 'Tentative';
                        }else{
                             typex = 'Final';
                        }

                        swal({
                                  title: typex+' GRADES UPDATED',
                                  text: 'YOUR STUDENT :'+data[0].studid+'  , '+data[0].firstname+' '+data[0].lastname+'  HAS BEEN UPDATED.',
                                  timer: 3500,
                                  type: 'warning',
                                });
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
                        swal({
                                  title: ' REMARKS UPDATED',
                                  text: 'YOUR STUDENT :'+data[0].studid+'  , '+data[0].firstname+' '+data[0].lastname+'  HAS BEEN UPDATED.',
                                  timer: 3500,
                                  type: 'warning',
                                });
                        }
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
  customClass: 'animated tada'
}).then(function() {
  swal(
    'Deleted!',
    'Your '+type+' GRADES has been sent for Review for your Dean and Resgistrar.',
    'success'
  )
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


</script>