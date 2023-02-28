<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>

<script type="text/javascript">
	
$('.time').timepicker({
        scrollbar:true,
        timeFormat: 'h:i A'
    });
	
	$('.date').datepicker();

	 $.fn.getTotalHours = function(e_class)
    {
        // add_pass_slip      
        var from = $("."+e_class+" .fromtime").val();
        var to = $("."+e_class+" .totime").val();

        var date = new Date();
        var month = date.getMonth();
        var day = date.getDate();
        var year = date.getFullYear();
        var fullfrom_time = month + '/'+ day + '/'+year + ' '+from;
        var fullto_time = month + '/'+ day + '/'+year + ' '+to;
        var time1 = new Date(fullfrom_time);
        var time2 = new Date(fullto_time);

        var numhours = Math.abs(time2 - time1) / 36e5;

        $("."+e_class+" .numhours").val(numhours);



    }

    $.fn.viewovertimerecords = function(overtid)
    {
        $('#updateovertime').modal('show');
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/get_overtime_records',
            dataType: 'json',
            cache: false,
            data : 'overt_id=' + overtid,
            success: function(result) {
                $('.update_overtime #overt_id').val(overtid);
                $('.update_overtime .overtime_date').val(result.data[0].date_ot);
                $('.update_overtime .fromtime').val(result.data[0].timefrom);
                $('.update_overtime .totime').val(result.data[0].timeto);
                $('.update_overtime .numhours').val(result.data[0].hours_rendered);
                $('.update_overtime #reason').val(result.data[0].reason);
                $('.update_overtime #remarks').val(result.data[0].remarks);
            }
        });
    }
</script>