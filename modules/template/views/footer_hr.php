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

	function load_message_notification(view = ''){
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>hr/datatables/get_message_notification',
			dataType: 'json',
			cache: false,
			data: {view:view},
			success: function(data){
				$('#notif_expire').html(data.notif);
				if (data.unseen_count > 0) {
					$('#count_message_notification').html(data.unseen_count);
				}
	        	if (data.count > 0) {
	        		$('li[class=0]').css('background-color', '#bbff99');
	        		$('li[class=0] > a > div > div').css('background-color', '#bbff99');
	        	}
	        	// if (data.seen_status > 0) {
	        		// $('#count_message_notification').html('');
	        		// $('li[name='+data.expiry_id+']').css('background-color', 'white');
	        		// $('li[name='+data.expiry_id+']').css('background-color', '#bbff99');
	        	// }
			}
		});
	}

	load_unseen_notification();
	load_message_notification();

	$(document).on('click', '#expiry_notif', function() {
		var expiry_id = $(this).attr('name');
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() ?>hr/datatables/message_notif_highlight',
			dataType: 'json',
	        data: 'id='+expiry_id,
	        success: function(data) {

	        }
		});
	});

	$(document).on('click', '#notification_load', function(){
		$('#count_notification').html('');
		// $('#count_message_notification').html('');
		load_unseen_notification('yes');
		// load_message_notification('yes');
	});

	$(document).on('click', '#expire_notif_load', function(){
		// $('#count_notification').html('');
		$('#count_message_notification').html('');
		// $('li[class=1]').css('background-color', 'white');
		// load_unseen_notification('yes');
		load_message_notification('yes');
	});

	setInterval(function() {
		load_unseen_notification();
		load_message_notification();
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

	
	// auto adding of leave credits
	function load_emp_leave_credits(){
		$.ajax({
	        type: 'POST',
	        url: '<?=ROOT_URL?>modules/hr/leave_ot_records/get_emp_leave_credits',
	        dataType: 'json',
	        cache: false,
	        data : 'add_leave_credits=true',
	        success: function(result) {
	            // $('.btn-loader').addClass('hide');
	        }
	    });

	}

	setInterval(function() {
		load_emp_leave_credits();
	}, 10000);

});

</script>
</html>