<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>js/jquery.timepicker.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>/modules/assets/functions/js/auto_save_hr_edi.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>

<script type="text/javascript">

$.fn.getALL = function(){

    if ( $.fn.dataTable.isDataTable( '#example' ) ) {
      $('#example').dataTable().fnDestroy();
    }


    $('.datepicker_month').datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
          $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
      }
    });

    $(document).ready(function(){
        var table = $('.tbl_salary_matrix').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : false,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "payroll/salary/get_salary_matrix",
              },
              "order": [[ 0, "asc" ] ],
              "columns": [
                  { "data": "fullname"},
                  { "data": "position"},
                  { "data": null,
                      render: function(data, type, row){
                        var value = (data.hour ? data.hour : 0);
                        return '<input type="text" value="'+value+'" class="form-control td_update hide" onblur="$(this).updateamount($(this).val(), '+data.u_id+', 1);"/>\
                        <span class="td_view">'+value+'</span>\
                        <span class="text-success hide success_updated_'+data.u_id+'_4">Updated!</span>';
                      }
                  }
                  // ,
                  // { "data": null,
                  //     render: function(data, type, row){
                  //       var value = (data.day ? data.day : 0);
                  //       return '<input type="text" value="'+value+'" class="form-control td_update hide" readonly onblur="$(this).updateamount($(this).val(), '+data.u_id+', 2);"/>\
                  //       <span class="td_view">'+value+'</span>\
                  //       <span class="text-success hide success_updated_'+data.u_id+'_5">Updated!</span>';
                  //     }
                  // }
              ]
        });

        var table2 = $('.tbl_teaching_salary_matrix').DataTable({
            "processing": true,
            "serverSide": false,
            "stateSave": true,
            "paging" : false,
            "scrollX": true,
            ajax:{
              "type": 'POST',
              "url" : "payroll/salary/get_salary_matrix_teaching",
            },
            "order": [[ 0, "asc" ] ],
            "columns": [
                { "data": "fullname"},
                { "data": "position"},
                { "data": null,
                    render: function(data, type, row){
                      var value = (data.hour ? data.hour : 0);
                      return '<input type="text" value="'+value+'" class="form-control td_update hide" onblur="$(this).updateamount($(this).val(), '+data.u_id+', 1);"/>\
                      <span class="td_view">'+value+'</span>\
                      <span class="text-success hide success_updated_'+data.u_id+'_4">Updated!</span>';
                    }
                }
            ]
        });


        var table3 = $('.tbl_unknow_salary_matrix').DataTable({
            "processing": true,
            "serverSide": false,
            "stateSave": true,
            "paging" : false,
            "scrollX": true,
            ajax:{
              "type": 'POST',
              "url" : "payroll/salary/get_salary_matrix_unknown",
            },
            "order": [[ 0, "asc" ] ],
            "columns": [
                { "data": "fullname"},
                { "data": "position"},
                { "data": null,
                    render: function(data, type, row){
                      var value = (data.hour ? data.hour : 0);
                      return '<input type="text" value="'+value+'" class="form-control td_update hide" onblur="$(this).updateamount($(this).val(), '+data.u_id+', 1);"/>\
                      <span class="td_view">'+value+'</span>\
                      <span class="text-success hide success_updated_'+data.u_id+'_4">Updated!</span>';
                    }
                }
            ]
        });

    });
};


$.fn.getALL();

$.fn.updateamount = function(value, user_id, column){
    $('.tbl_salary_matrix .text-success').addClass('hide');
    $.ajax({
        type: 'POST',
        url: 'payroll/salary/update_salary_matrix',
        dataType: 'json',
        cache: false,
        data : 'user_id=' + user_id + '&value=' +value+ '&column=' + column,
        success: function(result) {
          console.log(result);
          $('.tbl_salary_matrix .success_updated_'+user_id+'_'+column).removeClass('hide');

        }
    });
}

$.fn.enableupdate = function(check){
  if($(this).is(':checked')){
    $('.tbl_salary_matrix .td_update').removeClass('hide');
    $('.tbl_salary_matrix .td_view').addClass('hide');
    $('.tbl_teaching_salary_matrix .td_update').removeClass('hide');
    $('.tbl_teaching_salary_matrix .td_view').addClass('hide');

  }else{
    $('.tbl_salary_matrix .td_update').addClass('hide');
    $('.tbl_salary_matrix .td_view').removeClass('hide');
    $('.tbl_teaching_salary_matrix .td_update').addClass('hide');
    $('.tbl_teaching_salary_matrix .td_view').removeClass('hide');
  }
}

  $.fn.changeEmployee = function(){
    var val = $(this).val();
    window.location.href = '<?=base_url('payroll/salary/view_salary_computaion')?>/'+val;

  }

  $(document).ready(function(){

    var fileno = $('#idno').val();
    var cutt_off  = $('#cutt_off').val();
    var month = $('#month_rate').val();

    console.log( cutt_off );
    console.log( month );

    $.ajax({ 
        url:"<?php echo base_url(); ?>payroll/salary/get_attendance_biometrics",  
        method:"POST",  
        cache: false,
        dataType: 'json',
        data : 'fileno=' + fileno + '&cutt_off=' +cutt_off+ '&month=' + month,
        success:function(data){
          var tr = '';
          var days = 0;
          var payroll = 0;

          for (var i = 0; i < data.length; i++) {

            var color = '';
            if (data[i].exception == 'Undertime') {
              color = 'style="color: #D62222;"';
            } else {
              color = 'style="color: rgb(91, 148, 95);"';
            }

            if (data[i].totalhours) {
              days ++;
            }

            tr += '<tr>\
                    <td>'+data[i].date+'</td>\
                    <td style="text-align: right;">'+data[i].totalhours+'</td>\
                    <td '+color+'>'+data[i].exception+'</td>\
                    <td>\
                        <center>\
                          <a class="btn btn-success btn-xs" type="button" onclick="$(this).showdialogbox('+data[i].biometrics+', `'+data[i].date+'`)"><i class="glyphicon glyphicon-check"></i> View</a>\
                        </center>\
                    </td>\
                </tr>';
          }

          payroll = days * data[0].rate;

          $('#staff_attendance_tbl tbody').append(tr);
          $('#total_days').val(days);
          $('#total_payroll').val(payroll.toFixed(2));

        }
      }); 
  });


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
          // location.reload();
          $.fn.showdialogbox(biono,  date);

        }
  });

});

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

</script>