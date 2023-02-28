<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/FixedColumns-3.2.1/js/dataTables.fixedColumns.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/JSZip/jszip.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/transition.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/collapse.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/autocomplete/jquery.autocomplete.min.js"></script>


<script type="text/javascript">

$('#fg_only_table').dataTable();
$('#teacher_names').dataTable();

	$.fn.addSubjectToFGonly = function(){
		$.ajax({
                            type: "POST",
                            url: "<?=base_url('admin_registrar/fg_only/add_subjects')?>",
                            data : {
                            	'subjectid' : $('#subject_code').attr('data-subjectid')
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
                        	swal({
                                  title: data[1],
                                  html: '<h4 class="red">'+ data[2]+'</h4><br />',
                                  type: data[0]
                                });
                        	location.reload();
                        }
                });
	};



	$.fn.deleteSubjectToFGonly = function(subjectid){
		swal({
				  title: 'Are you sure?',
				  text: 'You want to Remove This Subject  ?',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Submit',
				  cancelButtonText: 'Cancel',
				  animation: false,
				  customClass: 'animated tada'
				}).then(function() {
					$.fn.submitRemove(subjectid);
				}, function(dismiss) {
				  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
				  if (dismiss === 'cancel') {
				    swal(
				      'Cancelled',
				      ' Removing has been cancel',
				      'error'
				    )
				  }
				});
	};

$.fn.submitRemove = function(subjectid){
	$.ajax({
                            type: "POST",
                            url: "<?=base_url('admin_registrar/fg_only/remove_subjects')?>",
                            data : {
                            	'subjectid' : subjectid
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
                        	swal({
                                  title: data[1],
                                  html: '<h4 class="red">'+ data[2]+'</h4><br />',
                                  type: data[0]
                                });
                        	location.reload();
                        }
                });
};

	$('#subject_code').on('focus', function(){

		$(this).autocomplete({
          serviceUrl: '<?=base_url('/admin_registrar/fg_only/get_subjects')?>',
          dataType: 'json',
          type: 'POST',
          onSelect: function (suggestion) {
          	$('#subject_code').attr('data-subjectid' , suggestion.subjectid);
          }
      });


	});

  /***
  Teacher For View Grades
  */

  $.fn.addTeacher = function(){
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('admin_registrar/fg_only/add_teacher')?>",
                            data : {
                              'teacherid' : $('#teacher_name').attr('data-teacherid')
                            },
                        dataType: "json",
                        error: function(){
                                swal({
                                  title: 'ERROR SUBMISSION',
                                  html: '<h4 class="red">PLEASE REFRESH AND TRY AGAIN</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
                        },
                        success: function(data){
                          swal({
                                  title: data[1],
                                  html: '<h4 class="red">'+ data[2]+'</h4><br />',
                                  type: data[0]
                                }).then(function() {
                                      location.reload();
                                });
                        }
                });
  };



  $.fn.deleteSubjectToFGonly = function(teacherid){
    swal({
          title: 'Are you sure?',
          text: 'You want to Remove This Teacher  ?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Submit',
          cancelButtonText: 'Cancel',
          animation: false,
          customClass: 'animated tada'
        }).then(function() {
          $.fn.submitRemoveTeacher(teacherid);
        }, function(dismiss) {
          // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
          if (dismiss === 'cancel') {
            swal(
              'Cancelled',
              ' Removing has been cancel',
              'error'
            )
          }
        });
  };

$.fn.submitRemoveTeacher = function(teacherid){
  $.ajax({
                            type: "POST",
                            url: "<?=base_url('admin_registrar/fg_only/remove_teacher')?>",
                            data : {
                              'teacherid' : teacherid
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
                          swal({
                                  title: data[1],
                                  html: '<h4 class="red">'+ data[2]+'</h4><br />',
                                  type: data[0]
                                });
                          location.reload();
                        }
                });
};

  $('#teacher_name').on('focus', function(){
    $(this).autocomplete({
          serviceUrl: '<?=base_url('/admin_registrar/fg_only/get_teacher')?>',
          dataType: 'json',
          type: 'POST',
          onSelect: function (suggestion) {
            $('#teacher_name').attr('data-teacherid' , suggestion.FileNo);
          }
      });


  });

  $.fn.setcompletionDays = function(type){

    var daysn =  $('#subject_completion_fgonly_days').val();
    if(type == 'pmtf'){
        daysn = $('#subject_completion_pmtf_days').val();
    }

    $.ajax({
                            type: "POST",
                            url: "<?=base_url('admin_registrar/fg_only/update_completion_days')?>",
                            data : {
                              'type' : type,
                              'days' : daysn
                            },
                        dataType: "json",
                        error: function(){
                                swal({
                                  title: 'Error Updating Days of Completion',
                                  html: '<h4 class="red">PLEASE REFRESH AND TRY AGAIN</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
                        },
                        success: function(data){
                          swal({
                                  title: data[1],
                                  html: '<h4 class="red">'+ data[2]+'</h4><br />',
                                  type: data[0]
                                });
                        }
                });
  }
</script>