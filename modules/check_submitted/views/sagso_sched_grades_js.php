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


	






</script>