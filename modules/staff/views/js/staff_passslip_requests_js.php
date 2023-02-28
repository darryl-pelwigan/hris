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

    $.fn.viewpaysliprecord = function(empid)
    {
        $('#updatepayslip').modal('show');
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/get_passlip_records',
            dataType: 'json',
            cache: false,
            data : 'pass_slip_id=' + empid,
            success: function(result) {
                $('.update_pass_slip #pass_slip_id').val(empid);
                $('.update_pass_slip #pass_slip_type').val(result.data[0].type);
                $('.update_pass_slip .pass_slip_date').val(result.data[0].slip_date);
                $('.update_pass_slip #destination').val(result.data[0].destination);
                $('.update_pass_slip #reason').val(result.data[0].purpose);
                $('.update_pass_slip .timeout').val(result.data[0].exp_timeout);
                $('.update_pass_slip .timereturn').val(result.data[0].exp_timreturn);
                $('.update_pass_slip .numhours').val(result.data[0].numhours);
                $('.update_pass_slip #dept_head_approval').val(result.data[0].dept_head_approval);
                $('.update_pass_slip #date_approve_decline').val(result.data[0].dept_head_date_approval);
                $('.update_pass_slip .undertime').val(result.data[0].exp_undertime);
            }
        });
    }
    // $.fn.viewpaysliprecord = function(empid)
    // {
    //     $('#updatepayslip').modal('show');
    //     $.ajax({
    //         type: 'POST',
    //         url: 'hr/leave_ot_records/get_passlip_records',
    //         dataType: 'json',
    //         cache: false,
    //         data : 'pass_slip_id=' + empid,
    //         success: function(result) {

    //             $('.update_pass_slip #employee_name').val(result.data[0].name);
    //             $('.update_pass_slip #employee_id').val(result.data[0].fileno);
    //             $('.update_pass_slip #employee_fileno').val(result.data[0].fileno);
    //             $('.update_pass_slip #employee_department').val(result.data[0].department);
    //             $('.update_pass_slip #employee_position').val(result.data[0].position);
    //             $('.update_pass_slip #pass_slip_type').val(result.data[0].type);
    //             $('.update_pass_slip .pass_slip_date').val(result.data[0].slip_date);
    //             $('.update_pass_slip #destination').val(result.data[0].destination);
    //             $('.update_pass_slip #reason').val(result.data[0].purpose);
    //             $('.update_pass_slip .fromtime').val(result.data[0].exp_timeout);
    //             $('.update_pass_slip .totime').val(result.data[0].exp_timreturn);
    //             $('.update_pass_slip .numhours').val(result.data[0].numhours);
    //             $('.update_pass_slip .undertime').val(result.data[0].exact_undertime);
    //             $('.update_pass_slip .exacttimeout').val(result.data[0].exact_timeout);
    //             $('.update_pass_slip .exacttimereturn').val(result.data[0].exact_timereturn);
    //             $('.update_pass_slip .exactnumhours').val(result.data[0].exact_numhours);
    //             $('.update_pass_slip .exactundertime').val(result.data[0].exact_undertime);
    //             $('.update_pass_slip #dept_head_approval').val(result.data[0].dept_head_approval);
    //             $('.update_pass_slip .date_approve_decline').val(result.data[0].dept_head_date_approval);
    //             $('.update_pass_slip #pass_slip_id').val(result.data[0].pass_slip_id);
    //         }
    //     });
    // }
</script>