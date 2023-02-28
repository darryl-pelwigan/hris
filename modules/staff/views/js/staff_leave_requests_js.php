<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>js/jquery.timepicker.js"></script>

<script type="text/javascript">

$('.date').datepicker();

$.fn.getLeaveBal = function(emp_id, leave)
{
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>staff/leave_request/leave_balance',
        dataType: 'json',
        cache: false,
        data : 'emp_id=' + emp_id + '&ltype_id='+leave,
        success: function(result) {
            if(result){
                $('#daysavailable').val(result);
            }else{
                $('#daysavailable').val(0);
            }
        }
    });
}

$(document).on('change', '.add_leave .fromdate', function(){
   $.fn.getDays('add_leave');
});

$(document).on('change', '.add_leave .todate', function(){
    $.fn.getDays('add_leave');
});
    
$(document).on('change', '.update_leave_data .fromdate', function(){
   $.fn.getDays('update_leave_data');
});

$(document).on('change', '.update_leave_data .todate', function(){
    $.fn.getDays('update_leave_data');
});

$.fn.getDays = function(divclass){
    var fdate = new Date($('.'+divclass+' .fromdate').val());
    var tdate = new Date($('.'+divclass+' .todate').val());
    var totalSecond = tdate-fdate;
    var hour = Math.floor(totalSecond/3600000);
    var day = Math.floor(hour/24);
    var actualdays = (day > 0 ? day : 0);
    $('.'+divclass+' #actualdays').val(actualdays);
    var daysavail = $('.'+divclass+' #daysavailable').val();
    var dayswithpay = actualdays;
    var dayswithoutpay = 0;
    if(actualdays > daysavail){
        dayswithpay = daysavail;
        dayswithoutpay = actualdays - daysavail;
    }
    $('.'+divclass+' #dayswithpay').val(dayswithpay);
    $('.'+divclass+' #dayswitouthpay').val(dayswithoutpay);
}



$.fn.updateleaverequests = function(leave_id){
    $('#updateleavemodal').modal('show');

    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>/hr/leave_ot_records/view_leave',
        dataType: 'json',
        cache: false,
        data : 'leave_id=' + leave_id,
        success: function(result) {
            
            $('.update_leave_data #employee_name').val(result.info[0].name);
            $('.update_leave_data #employee_id').val(result.info[0].fileno);
            $('.update_leave_data #employee_fileno').val(result.info[0].fileno);
            $('.update_leave_data #employee_department').val(result.info[0].department);
            $('.update_leave_data #employee_position').val(result.info[0].position);
            $('.update_leave_data #datefiled').val(result.info[0].date_filed);
            $('.update_leave_data .fromdate').val(result.info[0].leave_from);
            $('.update_leave_data .todate').val(result.info[0].leave_to);
            $('.update_leave_data #reason').val(result.info[0].reason);
            $('.update_leave_data #actualdays').val(result.info[0].num_days);
            $('.update_leave_data #dayswithpay').val(result.info[0].days_with_pay);
            $('.update_leave_data #dayswitouthpay').val(result.info[0].days_without_pay);
            $('.update_leave_data #remarks').val(result.info[0].hr_remarks);
            $('.update_leave_data #leave_status select').val(result.info[0].dept_head_approval);
            $('.update_leave_data #date_approve_decline').val(result.info[0].head_date_approval);
            $('.update_leave_data #dept_remarks').val(result.info[0].head_approval_remarks);
            $('.update_leave_data #leave_id').val(result.info[0].leave_id);
            $('.update_leave_data #leavetype').val(result.info[0].leave_type);
            $('.update_leave_data #leave_type_id').val(result.info[0].leave_type_id);
            $('.update_leave_data #daysavailable').val(result.leave[0].leave_credit);
            

        }
    });

}

</script>