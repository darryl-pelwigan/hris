
<script src="<?=base_url()?>assets/plugins/DataTablesN/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTablesN/DataTables-1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
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

$('#completion_list').dataTable();
</script>