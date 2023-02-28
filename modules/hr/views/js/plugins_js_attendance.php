<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>

<script type="text/javascript">

$('.time').timepicker({
    scrollbar:true,
    timeFormat: 'h:i A'
});


$('.time2').timepicker({
    scrollbar:true,
    timeFormat: 'h:i'
}); 

$('.datepicker').datepicker();

$.fn.get_attendance = function(fdate, tdate, teaching, department){

     $(document).ready(function(){
        var table = $('.emp_attendance_tbl').DataTable({
              "processing": true,
              "serverSide": false,
              // "stateSave": true,
              "paging" : true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_emp_attendance",
                data : {
                    "fdate"    : fdate,
                    "tdate"    : tdate,
                    "teaching" : teaching,
                    "department" : department,
                }
              },
              "order": [[ 1, "asc" ] ],
              "columns": [
                  { "data": "biometrics" },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "department" },
                  { "data": "teaching" },
                  { "data": "date" },
                  { "data": "regularhours"},
                  { "data": "totalhours" },
                  { "data": "tardiness" },
                  { "data": "undertime" },
                  { "data": "overtime" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-success btn-xs" type="button" onclick="$(this).showdialogbox('+data.biometrics+', `'+data.date+'`)"><i class="glyphicon glyphicon-check"></i> View</a>\
                                </center>';
                      }
                  },
              ]
        });

    });
};

$.fn.viewattendance = function(){
    $('.emp_attendance_tbl').DataTable().destroy();
    var fdate = $('#datefrom').val();
    var tdate = $('#dateto').val();
    var teaching = $('#teaching').val(); 
    var dept = $('#department').val(); 
    $.fn.get_attendance(fdate, tdate, teaching, dept);
}

$.fn.viewattendanceAttendance = function(){
    var fdate = $('#datefrom').val();
    var tdate = $('#dateto').val();
    var teaching = $('#teaching').val(); 
    var dept = $('#department').val(); 

    var url = "<?=ROOT_URL?>attendance-report.php?datefrom="+fdate+"&dateto="+tdate+"&dept="+dept+"&teaching="+teaching;
    var a = document.createElement('a');
    a.target="_blank";
    a.href=url;
    a.click();

}


$.fn.get_attendance(fdate='', tdate='', teaching='', dept = '');

$('.datepicker').datepicker();

$.fn.showdialogbox = function(biometrics, date_attendance){

  // console.log(date_attendance);
    var dialog = $("#view_attendance_data");

    dialog.load(
        '<?=ROOT_URL?>modules/hr/attendance/view_emp_attendance_data',
        {
          biometrics:biometrics,
          date:date_attendance
        },
        function (responseText, textStatus, XMLHttpRequest) {
            dialog.dialog({
                title:"Employee Attendace",
                // modal: true,
                resizable:true,
                width: 900,
                close: function (event, ui) {
                    $("#view_attendance_data").dialog("destroy");
                    $("#view_attendance_data").html("");
                    console.log('close');
                }
            });
            $('.time').timepicker({
                scrollbar:true,
                timeFormat: 'h:i A'
            });
            $('.datepicker').datepicker();

            $(document).on('click', '.datepicker', function(){
                $('.datepicker').datepicker();
            });

            $(document).on('click', '.time', function(){
                $('.time').timepicker({
                  scrollbar:true,
                  timeFormat: 'h:i A'
                });
            });

        }
    );
    return false;
}

$(document).on('click', '.addrow', function(){
    $('.datepicker').datepicker();
    var tbl = $('.tbl_attendance');
    var content = '<tr class="new_tr">\
        <td><input type="text" name="attendance_date[]" class="form-control datepicker" /></td>\
        <td></td>\
        <td></td>\
        <td><input type="text" name="datetime[]" class="form-control time" />\
        <input type="hidden" name="attendance_id[]" value="0" /></td>\
        <td>\
            <select name="status[]"  class="form-control">\
              <option value="0">C/In</option>\
              <option value="1">C/Out</option>\
            </select>\
        </td>\
        <td>\
            <button type="button" class="btn btn-warning btn-xs remove_tr"><i class="fa fa-minus"></i></button>\
        </td>\
    </tr>';
    $(content).appendTo(tbl);

    $('.datepicker').datepicker();

    $('.time').timepicker({
      scrollbar:true,
      timeFormat: 'h:i A'
    });

});


$(document).on('click', '.btn_submit_attendance', function(){
  var form = $('.attendance_form').serialize();
  var biono = $(this).attr('data-id');
  var date = $(this).attr('data-date');

  $.ajax({
        type: 'POST',
        url: '<?=ROOT_URL?>modules/hr/attendance/update_attendance',
        dataType: 'json',
        cache: false,
        data : form,
        success: function(result) {
          var n = noty({
                text        : "Successfully Updated Attendance",
                type        : 'success',
                dismissQueue: true,
                timeout     : 2000,
                closeWith   : ['click'],
                layout      : 'topCenter',
                theme: 'defaultTheme',
                maxVisible  : 3,
          });
          $('.emp_attendance_tbl').DataTable().ajax.reload();
          $('#view_attendance_data').html('');
          $.fn.showdialogbox(biono,  date);
        }
  });
});

$(document).on('click', '.remove_tr', function(){
  $(this).closest('tr').remove();
});


$.fn.delete_attendance = function(id){
    var x  = confirm("Are you sure to delete this record?");
    if(x){
        $('#attendance_'+id).closest('tr').remove();
        $.ajax({
          type: 'POST',
          url: '<?=ROOT_URL?>modules/hr/attendance/delete_attendance',
          dataType: 'json',
          cache: false,
          data : 'attendance_id=' + id,
          success: function(result) {
            var n = noty({
                          text        : "Record Deleted!",
                          type        : 'success',
                          dismissQueue: true,
                          timeout     : 2000,
                          closeWith   : ['click'],
                          layout      : 'topCenter',
                          theme: 'defaultTheme',
                          maxVisible  : 3,
                    });

            $('.emp_attendance_tbl').DataTable().ajax.reload();

          }
      });
    }
}

$.fn.updateAttendance = function(id, column){
    var value = $(this).val();
    $.ajax({
      type: 'POST',
      url: '<?=ROOT_URL?>modules/hr/attendance/staff_update_attendance',
      dataType: 'json',
      cache: false,
      data : 'attendance_id=' + id + '&val=' +value + '&col='+column,
      success: function(result) {
        $('.success_'+column+id).removeClass('hide');
        $('.success_'+column+id).delay(2000).queue(function() {
           $('.success_'+column+id).addClass('hide');
        });
      }
  });
}

$.fn.updateAttendanceStatus = function(id){
  var val = $(this).val();
  console.log(val);
  if(val == 0){
    $(this).removeClass('btn-success').addClass('btn-warning');
    $(this).html('');
    $(this).html('<i class="fa fa-times"></i>');
    $(this).val(1);

    $.ajax({
        type: 'POST',
        url: '<?=ROOT_URL?>modules/hr/attendance/staff_update_attendance',
        dataType: 'json',
        cache: false,
        data : 'attendance_id=' + id + '&val=' + 1 + '&col=status',
        success: function(result) {
        }
    });

  }else{
    $(this).removeClass('btn-warning').addClass('btn-success');
    $(this).html('');
    $(this).html('<i class="fa fa-check"></i>');
    $(this).val(0);
  
    $.ajax({
        type: 'POST',
        url: '<?=ROOT_URL?>modules/hr/attendance/staff_update_attendance',
        dataType: 'json',
        cache: false,
        data : 'attendance_id=' + id + '&val=' + 1 + '&col=status',
        success: function(result) {
      }
    });
  }
}


 $('#import_upload_attendance').on('submit', function(event){

     $("#loader").removeClass("hide");

    event.preventDefault();
    $.ajax({
     url: '<?=ROOT_URL?>modules/hr/attendance/staff_upload_attendance',
     method:"POST",
     data:new FormData(this),
     contentType:false,
     cache:false,
     processData:false,
     success:function(data){
        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
     }

    })

 });



</script>
