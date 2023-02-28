
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

	var table = $('#history_log_list').DataTable({
		"processing": true,
		"serverSide": false,
		"stateSave": true,
		"paging" : true,
		ajax:{
			"type": 'GET',
			"url" : "<?=base_url()?>profile/datatables/get_history_log",
		},
		"columns": [
			{ "data": "id" },
			{ "data": "fullname" },
			{ "data": "column_name"},
			{ "data": "old_data"},
			{ "data": "new_data" },
			{ "data": "action" },
			{ "data": "updated_by"},
			{ "data": "date" }
		],

		"aoColumnDefs": [{ "sClass": "hide_id", "aTargets": [ 0 ] }
		],
		"order": [[ 0, "desc" ]],  
	});
</script>