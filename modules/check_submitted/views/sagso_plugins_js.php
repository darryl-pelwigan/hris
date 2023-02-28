<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/FixedColumns-3.2.1/js/dataTables.fixedColumns.js"></script>




<script type="text/javascript">
	$.fn.checkreviewGrade = function(data_key){

	$.ajax({
                    type: "POST",
                    url: "<?=base_url('check_submitted/check_submitted_sagso/submitted')?>",
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

                                       window.location.replace('<?=base_url()?>check_submitted/check_submitted_sagso/view_grades?data_key='+data[2]);
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


	
</script>