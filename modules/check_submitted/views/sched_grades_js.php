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


$('.panel-heading-hover').hover(function(){
  var el = $(this).attr('data-panel-body');
  var panel_body = $('#'+el);
  if(!panel_body.hasClass( "in" )){
    panel_body.collapse("show");
    
  }else{
    panel_body.collapse("hide");
  }
});  


	$('#shed_record_list').dataTable({
                                        "pageLength"  :100,
                                        fixedHeader: true,
                                        dom: 'Blfrtip',
                                        buttons: [
                                            'excelHtml5'
                                        ],
                                         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                     });


	




$.fn.approvedGRADES = function(type,sched_id){

    swal({
      title: 'Approve '+type+' GRADES',
      text: '',
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
                    url: "<?=base_url('check_submitted/submit_grade_review')?>",
                    data : {
                            sched_id : sched_id,
                            type:type,
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                      console.log(data[0]);
                      if(data[0] == 1){
                        swal({
                                  title: 'Submitted',
                                  text: data[1],
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


$.fn.approvedRequestUpdate = function(type,sched_id){
 $.ajax({
                    type: "POST",
                    url: "<?=base_url('check_submitted/get_request_remarks')?>",
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
                            title: 'Approve Teacher to UPDATE '+type+' GRADES',

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
                                          url: "<?=base_url('check_submitted/submit_grade_request_approved')?>",
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
                                                        text: data[1],
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


</script>