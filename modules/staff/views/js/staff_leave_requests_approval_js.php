<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>js/jquery.timepicker.js"></script>

<script type="text/javascript">

  $('.time').timepicker({
        scrollbar:true,
        timeFormat: 'h:i A'
    });
  
  $('.date').datepicker();

   $.fn.getTotalHours = function(e_class)
    {
        // add_pass_slip      
        var from = $(".timeout").val();
        var to = $(".timereturn").val();

        var date = new Date();
        var month = date.getMonth();
        var day = date.getDate();
        var year = date.getFullYear();
        var fullfrom_time = month + '/'+ day + '/'+year + ' '+from;
        var fullto_time = month + '/'+ day + '/'+year + ' '+to;
        var time1 = new Date(fullfrom_time);
        var time2 = new Date(fullto_time);

        var numhours = Math.abs(time2 - time1) / 36e5;

        $(".numhours").val(numhours);



    }

$.fn.getALL = function(){

    if ( $.fn.dataTable.isDataTable( '#example' ) ) {
      $('#example').dataTable().fnDestroy();
    }

    $(document).ready(function(){
        $('#t_leave_pending').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_status_leave_requests",
                data : {
                  "status" : 0
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "ltype" },
                  { "data": "num_days" },
                  { "data": "leave_dates"},
                  { "data": "date_filed" },
                  { "data": "reason" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-success btn-xs" type="button" onclick="$(this).pendingapproval('+data.leave_id+', 1)"><i class="glyphicon glyphicon-check"></i> Approve</a>\
                                  <a class="btn btn-danger btn-xs" onclick="$(this).pendingapproval('+data.leave_id+', 2)"><i class="glyphicon glyphicon-remove-sign"></i> Decline</a>\
                                </center>';
                      }
                  },
              ]
        });

        $('#t_leave_approved').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_status_leave_requests",
                data : {
                  "status" : 1
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "ltype" },
                  { "data": "num_days" },
                  { "data": "leave_dates"},
                  { "data": "date_filed" },
                  { "data": "reason" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-danger btn-xs" onclick="$(this).pendingapproval('+data.leave_id+', 2)"><i class="glyphicon glyphicon-remove-sign"></i> Decline</a>\
                                </center>';
                      }
                  },
              ]
        });
        
        $('#t_leave_declined').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_status_leave_requests",
                data : {
                  "status" : 2
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "ltype" },
                  { "data": "num_days" },
                  { "data": "leave_dates"},
                  { "data": "date_filed" },
                  { "data": "reason" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-success btn-xs" type="button" onclick="$(this).pendingapproval('+data.leave_id+', 1)"><i class="glyphicon glyphicon-check"></i> Approve</a>\
                                </center>';
                      }
                  },
              ]
        });

        $('#pending_overtime').DataTable({
              "processing": true,
              "responsive": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_overtime_requests",
                data : {
                  "status" : 0
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "date_overtime" },
                  { "data": "numhours" },
                  { "data": "reason"},
                  { "data": "timefrom" },
                  { "data": "timeto" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-success btn-xs" type="button" onclick="$(this).pendingApprovalOvertime('+data.id+', 1)"><i class="glyphicon glyphicon-check"></i> Approve</a>\
                                  <a class="btn btn-danger btn-xs" onclick="$(this).pendingApprovalOvertime('+data.id+', 2)"><i class="glyphicon glyphicon-remove-sign"></i> Decline</a>\
                                </center>';
                      }
                  },
              ]
        });

        $('#approved_overtime').DataTable({
              "processing": true,
              "responsive": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_overtime_requests",
                data : {
                  "status" : 1
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "date_overtime" },
                  { "data": "numhours" },
                  { "data": "reason"},
                  { "data": "timefrom" },
                  { "data": "timeto" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-primary btn-xs" type="button" onclick="$(this).viewpayovertimerecord('+data.id+')"><i class="glyphicon glyphicon-eye-open"></i> View</a>\
                                  \
                                </center>';
                      }
                  },
              ]
        });

        $('#decline_overtime').DataTable({
              "processing": true,
              "responsive": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_overtime_requests",
                data : {
                  "status" : 2
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "date_overtime" },
                  { "data": "numhours" },
                  { "data": "reason"},
                  { "data": "timefrom" },
                  { "data": "timeto" },
                  // { "data": null,
                  //     render: function(data, type, row){
                  //       return '<center>\
                  //                 <a class="btn btn-success btn-xs" type="button" onclick="$(this).pendingApprovalPassslip('+data.id+', 1)"><i class="glyphicon glyphicon-check"></i> Approve</a>\
                  //                 <a class="btn btn-danger btn-xs" onclick="$(this).pendingApprovalPassslip('+data.id+', 2)"><i class="glyphicon glyphicon-remove-sign"></i> Decline</a>\
                  //               </center>';
                  //     }
                  // },
              ]
        });


        $('#t_passslip_pending').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_pass_slip_requests",
                data : {
                  "status" : 0
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "type" },
                  { "data": "slip_date" },
                  { "data": "destination"},
                  { "data": "purpose" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours" },
                  { "data": "exp_undertime" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-success btn-xs" type="button" onclick="$(this).pendingApprovalPassslip('+data.id+', 1)"><i class="glyphicon glyphicon-check"></i> Approve</a>\
                                  <a class="btn btn-danger btn-xs" onclick="$(this).pendingApprovalPassslip('+data.id+', 2)"><i class="glyphicon glyphicon-remove-sign"></i> Decline</a>\
                                </center>';
                      }
                  },
              ]
        });

        $('#t_passslip_approved').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_pass_slip_requests",
                data : {
                  "status" : 1
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "type" },
                  { "data": "slip_date" },
                  { "data": "destination"},
                  { "data": "purpose" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours" },
                  { "data": "exp_undertime" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-primary btn-xs" type="button" onclick="$(this).viewpaysliprecord('+data.id+')"><i class="glyphicon glyphicon-eye-open"></i> View</a>\
                                  \
                                </center>';
                      }
                  },
              ]
        });

        $('#t_passslip_declined').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_pass_slip_requests",
                data : {
                  "status" : 2
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "type" },
                  { "data": "slip_date" },
                  { "data": "destination"},
                  { "data": "purpose" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours" },
                  { "data": "exp_undertime" },
              ]
        });
        
        $('#t_travelo_pending').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_travelo_requests",
                data : {
                  "status" : 0
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "travelo_date" },
                  { "data": "destination" },
                  { "data": "purpose"},
                  { "data": "date_of_travel" },
                  { "data": null,
                      render: function(data, type, row){
                        return '<center>\
                                  <a class="btn btn-success btn-xs" type="button" onclick="$(this).pendingApprovalTravelOrder('+data.id+', 1)"><i class="glyphicon glyphicon-check"></i> Approve</a>\
                                  <a class="btn btn-danger btn-xs" onclick="$(this).pendingApprovalTravelOrder('+data.id+', 2)"><i class="glyphicon glyphicon-remove-sign"></i> Decline</a>\
                                </center>';
                      }
                  },
              ]
        });

        $('#t_travelo_approved').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_travelo_requests",
                data : {
                  "status" : 1
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "travelo_date" },
                  { "data": "destination" },
                  { "data": "purpose"},
                  { "data": "date_of_travel" },
                  { "data": "remarks" },
              ]
        });

        $('#t_travelo_declined').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_travelo_requests",
                data : {
                  "status" : 2
                },
              },
              "columns": [
                  { "data": "name"},
                  { "data": "travelo_date" },
                  { "data": "destination" },
                  { "data": "purpose"},
                  { "data": "date_of_travel" },
                  { "data": "remarks" },
              ]
        });

    });
};

$.fn.getALL();

$.fn.pendingapproval = function(leave_id, status)
{
    $('.leave_status .alert').removeClass('alert-success');
    $('.leave_status .alert').removeClass('alert-danger');

    $('#addrem').modal('show');
    $('#dept_status').val(status);
    $('#leave_id').val(leave_id);

    if(status == 1){
      $('.leave_status .alert').addClass('alert-success');
      $('#leave_app_disapp').text('approve');
    }else{
      $('.leave_status .alert').addClass('alert-danger');
      $('#leave_app_disapp').text('decline');
    }

}

$.fn.pendingApprovalOvertime = function(overt_id, status)
{
    $('.modal_status .alert').removeClass('alert-success');
    $('.modal_status .alert').removeClass('alert-danger');

    $('#update_overtime_request').modal('show');
    $('#over_dept_status').val(status);
    $('#overtime_id').val(overt_id);

    if(status == 1){
      $('.modal_status .alert').addClass('alert-success');
      $('#over_app_disapp').text('approve');
    }else{
      $('.modal_status .alert').addClass('alert-danger');
      $('#over_app_disapp').text('decline');
    }
}

$.fn.pendingApprovalPassslip = function(pass_slip_id, status)
{
    $('.modal_status .alert').removeClass('alert-success');
    $('.modal_status .alert').removeClass('alert-danger');

    $('#update_pass_slip').modal('show');
    $.ajax({
        type: 'POST',
         url: 'hr/leave_ot_records/get_staff_emp_pass_slip_request',
        dataType: 'json',
        cache: false,
        data : 'pass_id=' + pass_slip_id,
        success: function(result) {
          $('#timeout').val(result.exp_timeout);

              $('#pass_dept_status').val(status);
              $('#pass_slip_id').val(pass_slip_id);

              if(status == 1){
                $('.modal_status .alert').addClass('alert-success');
                $('#pass_app_disapp').text('approve');
              }else{
                $('.modal_status .alert').addClass('alert-danger');
                $('#pass_app_disapp').text('decline');
              }
        }
    }); 

}

$.fn.pendingApprovalTravelOrder = function(travel_order_id, status)
{
    $('#travel_budget').find('tbody').empty();
    $('.modal_status .alert').removeClass('alert-success');
    $('.modal_status .alert').removeClass('alert-danger');

    $('#travel_app_disapp').modal('show');
    $('#travel_dept_status').val(status);
    $('#travel_order_id').val(travel_order_id);

    if(status == 1){
      $('.modal_status .alert').addClass('alert-success');
      $('#travelo_app_disapp').text('approve');
    }else{
      $('.modal_status .alert').addClass('alert-danger');
      $('#travelo_app_disapp').text('decline');
    }

   $.ajax({
      type: 'POST',
      url: 'hr/leave_ot_records/get_travel_order_records',
      dataType: 'json',
      cache: false,
      data : 'travelo_id=' + travel_order_id,
      success: function(result) {
        $('#employee_id').val(result.data[0].fileno);

        var val = '';
        var total_budget = 0;
        for (var i = 0; i < result.data[0].budget.length; i++) {
          var numbers = parseFloat(result.data[0].budget[i].amount);
          total_budget += numbers;
          val += '<tr>\
              <td style="display: none"><input type="text" name="budget_id[]" value='+result.data[0].budget[i].id+' class="form-control"/></td>\
              <td style="width:60%"><input  class="form-control" type="text" name="budget_type[]" value="'+result.data[0].budget[i].types+'"/></td>\
               \
              <td style="width:30%"><input type="number" min="0" step="0.01" name="budget_amount[]" value='+result.data[0].budget[i].amount+' class="form-control add_amount" onkeyup="sumfunction()"/></td>\
              <td><button type="button" class="btn btn-danger btn-xs" id="remove_rows" onclick="delete_travel_budget('+result.data[0].budget[i].id+')" ><i class="fa fa-minus"></i></button></td>\
            </tr>';
        }

        $('#travel_budget tbody').append(val);
        $('#total_amount').val(total_budget);
      }
  }); 


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
              $('#hr-notice').text('');
                $('#employee_name').val(result.data[0].name);
                $('#employee_id').val(result.data[0].fileno);
                $('#employee_fileno').val(result.data[0].fileno);
                $('#employee_department').val(result.data[0].department);
                $('#employee_position').val(result.data[0].position);

                $('#pass_slip_type').text(result.data[0].type);
                $('#pass_slip_date').text(result.data[0].slip_date);
                $('#destination').text(result.data[0].destination);
                $('#reason').text(result.data[0].purpose);
                $('#fromtime').text(result.data[0].exp_timeout);
                $('#totime').text(result.data[0].exp_timreturn);
                $('#numhours').text(result.data[0].numhours);
                $('#undertime').text((result.data[0].exp_undertime * 60) +' minutes/s');

                var status = 0;
                if(result.data[0].exact_timeout && result.data[0].exact_timereturn && result.data[0].exact_numhours && result.data[0].exact_undertime){
                   status = 1;
                }

                if(status == 1){
                    $('#hr-notice').text('');
                    $('#hr-check').show(100);
                    $('#exact_from').text(result.data[0].exact_timeout);
                    $('#exact_to').text(result.data[0].exact_timereturn);
                    $('#exact_numhours').text(result.data[0].exact_numhours + " hours");
                    $('#exact_undertime').text((result.data[0].exact_undertime * 60) + " minute/s");                  
                }else{
                  $('#hr-check').hide(100);
                    $('#hr-notice').text('Not yet verified.');
                }

                var req_status = '';
                if(result.data[0].dept_head_approval == 1){
                  req_status = 'Approved';
                }else if(result.data[0].dept_head_approval == 2){
                  req_status = 'Declined';
                }

                $('#dept_head_approval').text(req_status);
                $('#date_approve_decline').text(result.data[0].dept_head_date_approval);
                $('#updatepayslip').modal('show');
            }
        });
    }


  $.fn.viewpayovertimerecord = function(overt_id)
    {
        $('#viewovertime').modal('show');
        $.ajax({
            type: 'POST',
             url: 'hr/leave_ot_records/get_overtime_records',
            dataType: 'json',
            cache: false,
            data : 'overt_id=' + overt_id,
            success: function(result) {
                $('.update_overtime #employee_name').val(result.data[0].name);
                $('.update_overtime #employee_id').val(result.data[0].fileno);
                $('.update_overtime #employee_fileno').val(result.data[0].fileno);
                $('.update_overtime #employee_department').val(result.data[0].department);
                $('.update_overtime #employee_position').val(result.data[0].position);

                $('.update_overtime #date_overtime').val(result.data[0].date_ot);
                $('.update_overtime #timefrom').val(result.data[0].timefrom);
                $('.update_overtime #timeto').val(result.data[0].timeto);
                $('.update_overtime #hours_rendered').val(result.data[0].hours_rendered);
                $('.update_overtime #reason').val(result.data[0].reason);
                $('.update_overtime #dept_head_approval').val(result.data[0].dept_head_approval);
                $('.update_overtime #date_approve_decline').val(result.data[0].dept_head_date_approval);

                var req_status = '';
                if(result.data[0].dept_head_approval == 1){
                  req_status = 'Approved';
                }else if(result.data[0].dept_head_approval == 2){
                  req_status = 'Declined';
                }

                $('.update_overtime #dept_head_approval').val(req_status);
                $('.update_overtime #date_approve_decline').val(result.data[0].dept_head_date_approval);
                $('#viewovertime').modal('show');
            }
        });
    }

  $(document).on("click", "#add_travel_budget", function(){
    var table = document.getElementById("travel_budget");
    $('<tr>\
        <td style="display: none">\
          <input type="text" name="budget_id[]" placeholder="Types" value="0" class="form-control"/>\
        </td>\
        <td style="width:60%">\
            <input  class="form-control" type="text" name="budget_type[]" placeholder="Budget Specification"/>\
        </td>\
        <td style="width:30%">\
            <input type="text" name="budget_amount[]" step="0.01" placeholder="Estimated Amount" class="form-control add_amount" onkeyup="sumfunction()"/>\
        </td>\
        <td>\
            <button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button>\
        </td></tr>').appendTo(table);
  });

  function sumfunction(){
    var sum = 0;
    var amounts = document.getElementsByClassName('add_amount');

    for(var i=0; i<amounts .length; i++) {
        var a = +amounts[i].value;
        sum += parseFloat(a) || 0;
    }
    document.getElementById("total_amount").value = sum;
  }
    $(document).on("click","#lesscol",function(){
        $(this).closest('tr').remove();
        sumfunction();
    });

    function delete_travel_budget(id){
        var message = confirm('are you sure you want to delete this Budget Records');
        if (message == true ) {
            $(document).on("click","#remove_rows",function(){
                $(this).closest('tr').remove();
                sumfunction();
            });

            $.ajax({
                type: 'POST',
                url: 'hr/leave_ot_records/delete_travel_budgets',
                dataType: 'json',
                cache: false,
                data : 'id=' + id,
                success: function(result) {
                }
            });
        }
    }


</script>