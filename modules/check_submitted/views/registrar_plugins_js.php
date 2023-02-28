<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/FixedColumns-3.2.1/js/dataTables.fixedColumns.js"></script>




<script type="text/javascript">


  $('.subject_listx').dataTable();

	$.fn.checkreviewGrade = function(data_key){

	$.ajax({
                    type: "POST",
                    url: "<?=base_url('check_submitted/check_submitted_registrar/submitted')?>",
                    data : {
                           data_key : data_key
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                      console.log(data[0]);
                      if(data[0] == 1){
                        swal({
                                  title: 'Continue checking grades',
                                  text: '',
                                  type: 'question',
                                  showCancelButton: true,
                                  confirmButtonText: 'Continue',
                                  cancelButtonText: 'Cancel',
                                  cancelButtonColor: '#d33',
                                }).then(function(){

                                       window.location.replace('<?=base_url()?>check_submitted/check_submitted_registrar/view_grades?data_key='+data[2]);
                            });
                      }else{
                            swal({
                                  title: data[1],
                                  text: '',
                                  type: 'warning',
                                });
                      }
                    }
            });	


	};

  $.fn.notifyToSubmit = function(data_key){
  $.ajax({
                    type: "POST",
                    url: "<?=base_url('check_submitted/check_submitted_registrar/submitted_notify')?>",
                    data : {
                           data_key : data_key
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                      console.log(data[0]);
                      if(data[0] == 1){
                        

                        swal({
                                  title: data[1],
                                  text: '',
                                  type: 'info',
                                  confirmButtonText: 'OK',
                                });
                      }else{
                            swal({
                                  title: data[1],
                                  text: '',
                                  type: 'question',
                                  confirmButtonText: 'continue',
                                }).then(function(){
                                  console.log(data_key);
                                      $.fn.sentNotify(data_key); 
                            });;
                      }
                    }
            }); 


  };


$.fn.sentNotify = function(data_key){
  $.ajax({
                    type: "POST",
                    url: "<?=base_url('check_submitted/check_submitted_registrar/sent_notify')?>",
                    data : {
                           data_key : data_key
                    },
                    dataType: "json",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                      console.log(data[0]);
                      if(data[0] == 1){
                        

                        swal({
                                  title: data[1],
                                  text: '',
                                  type: 'info',
                                  confirmButtonText: 'OK',
                                }).then(function(){
                                       window.location.reload();
                            });
                      }else{
                            swal({
                                  title: data[1],
                                  text: '',
                                  type: 'question',
                                  confirmButtonText: 'continue',
                                });
                      }
                    }
            }); 
};

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
	
</script>