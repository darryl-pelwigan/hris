<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>

<script type="text/javascript">
	
$('.time').timepicker({
        scrollbar:true,
        timeFormat: 'h:i A'
    });
	
	$('.date').datepicker();

	  $(document).on('change', '.update_travel_order .fromdate', function(){
       $.fn.getTravelDays('update_travel_order');
    });

    $(document).on('change', '.update_travel_order .todate', function(){
        $.fn.getTravelDays('update_travel_order');
    });

    $(document).on('change', '.add_travel_order .fromdate', function(){
       $.fn.getTravelDays('add_travel_order');
    });

    $(document).on('change', '.add_travel_order .todate', function(){
        $.fn.getTravelDays('add_travel_order');
    });

    $.fn.getTravelDays = function(divclass){
        var fdate = new Date($('.'+divclass+' .fromdate').val());
        var tdate = new Date($('.'+divclass+' .todate').val());
        var totalSecond = tdate-fdate;
        var hour = Math.floor(totalSecond/3600000);
        var day = Math.floor(hour/24);
        var actualdays = (day > 0 ? day : 0);
        $('.'+divclass+' #numdays').val(actualdays);
    }

    $.fn.viewtravelrecord = function(travelid)
    {
        $('#updatetravelform').modal('show');
        $.ajax({
            type: 'POST',
            url: 'hris/employees/get_travel_order_records',
            dataType: 'json',
            cache: false,
            data : 'travelo_id=' + travelid,
            success: function(result) {

                $('.update_travel_order .travel_date').val(result.data[0].travelo_date);
                $('.update_travel_order #destination').val(result.data[0].destination);
                $('.update_travel_order #reason').val(result.data[0].purpose);
                $('.update_travel_order .fromdate').val(result.data[0].datefrom);
                $('.update_travel_order .todate').val(result.data[0].dateto);
                $('.update_travel_order .numdays').val(result.data[0].numberofdays);
                $('.update_travel_order #to_status').val(result.data[0].to_status);
                $('.update_travel_order #travelo_id').val(result.data[0].travelo_id);
               
            }
        });
    }
</script>