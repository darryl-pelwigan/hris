 	</div>

    </div>
</body>


<script type="text/javascript">
$(document).ready(function(){
	function load_unseen_notification(view = ''){
		$.ajax({
			type: 'POST',
	        url: '<?php echo base_url(); ?>hr/datatables/get_all_leave_application',
	        dataType: 'json',
	        cache: false,
	        data:{view:view},
	        success: function(data) {
	        	$('#notification_lists').html(data.notification);
	        	if (data.unseen_notification > 0) {
	        		$('#count_notification').html(data.unseen_notification);
	        	}	        	
	        }
		});

	}

	load_unseen_notification();
	
	$(document).on('click', '#notification_load', function(){
		$('#count_notification').html('');
		load_unseen_notification('yes');
	});

	setInterval(function() {
		load_unseen_notification();
	}, 5000);

	$(document).on('click', '.travel_link_notif', function(){
		var id = $(this).attr("id");
		$.ajax({
			type: 'POST',
	        url: '<?php echo base_url(); ?>hr/datatables/update_highlight_status',
	        dataType: 'json',
	        data: 'id='+id,
	        success: function(data) {
				        	
	        }
		});

	});

	$(document).on('click', '.pass_link_notif', function(){
		var id = $(this).attr("id");
		$.ajax({
			type: 'POST',
	        url: '<?php echo base_url(); ?>hr/datatables/pass_highlight_status',
	        dataType: 'json',
	        data: 'id='+id,
	        success: function(data) {
				        	
	        }
		});
	});

	$(document).on('click', '.overtime_link_notif', function(){
		var id = $(this).attr("id");
		$.ajax({
			type: 'POST',
	        url: '<?php echo base_url(); ?>hr/datatables/overtime_highlight_status',
	        dataType: 'json',
	        data: 'id='+id,
	        success: function(data) {
				        	
	        }
		});
	});
	$(document).on('click', '.leave_link_notif', function(){
		var id = $(this).attr("id");
		$.ajax({
			type: 'POST',
	        url: '<?php echo base_url(); ?>hr/datatables/leave_highlight_status',
	        dataType: 'json',
	        data: 'id='+id,
	        success: function(data) {
				        	
	        }
		});
	});

});

</script>
</html>