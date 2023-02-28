<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/transition.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/collapse.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/dependent/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/autocomplete/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
	



	$('.datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: moment().subtract(6,'month'),
                maxDate: moment().add(6, 'month')
     });

$.fn.submitAssign = function(dept,DEPTID,teacher_id,teacher,datestarted){
	 $.ajax({
                    type: "POST",
                    url: "<?=base_url('college_deans/save_assign_dean')?>",
                    data : {
                            teacher_id 	: teacher_id.val(),
                            DEPTID		: DEPTID,
                            datestarted : datestarted.val()
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
								  swal({ title: "Assigned!", text: teacher.val()+" has been successfully assigned as dean of "+dept.text(), type: "success"}).then(function() {
                  						window.location.reload();
                				});
                    }
            });
};

$.fn.submitRemove = function(dept,DEPTID,ID,teacher){
	 $.ajax({
                    type: "POST",
                    url: "<?=base_url('college_deans/save_remove_dean')?>",
                    data : {
                            DEPTID		: DEPTID,
                            ID 			: ID
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                       			swal({ title: "Removed", text: teacher.val()+" has been successfully remove as dean of "+dept.text(), type: "success"}).then(function() {
                  						window.location.reload();
                				});

                    }
            });
};
$.fn.removeDean = function(DEPTID,ID){
	var dept = $('#dept_'+DEPTID);
	var teacher = $('#teacher_'+DEPTID);
	swal({
				  title: 'Are you sure?',
				  text: 'You want to Remove '+teacher.val()+' as Dean for '+dept.text()+' ?',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Submit',
				  cancelButtonText: 'Cancel',
				  animation: false,
				  customClass: 'animated tada'
				}).then(function() {
					$.fn.submitRemove(dept,DEPTID,ID,teacher);
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


$.fn.assignDeans = function(DEPTID){
	var dept = $('#dept_'+DEPTID);
	var teacher = $('#assigned_dean_'+DEPTID);
	var teacher_id = $('#assigned_dean_id_'+DEPTID);
	var datestarted = $('#assigned_dean_datestarted_'+DEPTID);
	if(dept.text() != '' && teacher.val() != '' &&  teacher_id.val() != '' &&  datestarted.val() != ''){
			swal({
				  title: 'Are you sure?',
				  text: 'You want to assign '+teacher.val()+' as Dean for '+dept.text()+' ?',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Submit',
				  cancelButtonText: 'Cancel',
				  animation: false,
				  customClass: 'animated tada'
				}).then(function() {
					$.fn.submitAssign(dept,DEPTID,teacher_id,teacher,datestarted);
				  
				}, function(dismiss) {
				  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
				  if (dismiss === 'cancel') {
				    swal(
				      'Cancelled',
				      ' Assigning has been cancel',
				      'error'
				    )
				  }
				});
		}else{
			 swal(
				      'Incomplete',
				      'Please enter Teacher and Date Started!.',
				      'warning'
				    )
		}
}

$.fn.searchTeacher = function(DEPTID){

	$(this).autocomplete({
          serviceUrl: '<?=base_url('/college_deans/get_teacher')?>',
          dataType: 'json',
          type: 'POST',
          params : {
                    DEPTID : DEPTID
          },
          onSelect: function (suggestion) {
          	$('#assigned_dean_id_'+DEPTID).val(suggestion.data);
          }
      });
};



  

</script>