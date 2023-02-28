<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>

<script type="text/javascript">

    $('.date').datepicker();
    $('.hide_div').addClass('hidden');

    $('.time').timepicker({
        scrollbar:true,
        timeFormat: 'h:i A'
    });

    $('#newleave, #newovetime').on('shown.bs.modal', function () {
        $('input').val("");
        $('select').val("");
        $('.name_seach').removeClass('list-group');
    });

    $.fn.searchemployee = function(val)
    {
        $.ajax({
            type: 'POST',
            url: 'hr/employees/search',
            dataType: 'json',
            cache: false,
            data : 'search=' + val,
            success: function(result) {
                $('.name_seach').addClass('list-group');
                var html = '';
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        var full_name = result[i].Firstname+' '+result[i].LastName;
                        html += '<a style="background-color:#99CC66"; class="list-group-item" id="'+result[i].FileNo+'" staff="'+result[i].teaching+'" year="'+result[i].yearsofservice+'" nature="'+result[i].nature_emp+'" onclick="$(this).viewdata();" >('+result[i].FileNo+') ' + full_name + '</a>';
                    }
                }
                $('.name_seach').html(html);
            }
        });
    }

    $.fn.viewdata = function()
    {
        var val = $(this).attr('id');
        var staff = $(this).attr('staff');
        var year = $(this).attr('year');
        var nature = $(this).attr('nature');
        console.log(staff);
        console.log(year);
        $(this).parent().removeClass('list-group');
        $(this).parent().html("");
        $('#div_leave').html("");
        $.ajax({
            type: 'POST',
            url: 'hr/employees/viewdata',
            dataType: 'json',
            cache: false,
            data : 'view_emp_data=' + val,
            success: function(result) {
              if(result.info){
                   $('.modal #employee_name').val(result.info[0].Firstname+" "+result.info[0].LastName);
                   $('.modal #employee_id').val(result.info[0].FileNo);
                   $('.modal #employee_fileno').val(result.info[0].FileNo);
                   $('.modal #employee_department').val(result.info[0].DEPTNAME);
                   $('.modal #employee_position').val(result.info[0].position);
                   var options = "";
                   var fileno = "";
                   if(result.leave.length > 0){
                        fileno = result.info[0].FileNo;
                        for (var i = 0; i < result.leave.length; i++) {
                            if((staff == 1 && nature == 'part-time') || (staff == 0 && year > 0))
                            {
                              options += '<option value="'+result.leave[i].type_id+'">'+result.leave[i].type+'</option>';
                            }else if(result.leave[i].type_id != 4){
                              options += '<option value="'+result.leave[i].type_id+'">'+result.leave[i].type+'</option>';
                            }
                        }
                   }
                   $('.add_leave #div_leave').html('<select name="leavetype" id="leavetype" class="form-control" required onchange="$(this).getLeaveBal(`'+fileno+'`, $(this).val())">\
                                 <option value=""></option>\
                                 '+options+'\
                                </select>');
                }
            }
        });
    }

    $.fn.getLeaveBal = function(emp_id, leave)
    {


      if(leave == 5)
      {
        $('.hide_div').removeClass('hidden');
      }
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/leave_balance',
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

    $(document).on('change', '.update_travel_order_order .fromdate', function(){
       $.fn.getTravelDays('update_travel_order_order');
    });

    $(document).on('change', '.update_travel_order_order .todate', function(){
        $.fn.getTravelDays('update_travel_order_order');
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

    $.fn.getALL = function(){

        if ( $.fn.dataTable.isDataTable( '#example' ) ) {
          $('#example').dataTable().fnDestroy();
        }

        $(function() { 
            $('a[data-toggle="tab"]').on('click', function (e) {
              localStorage.setItem('lastTab', $(e.target).attr('href'));
            });
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('a[href="'+lastTab+'"]').click();
            }
        });
   
        $(document).ready(function(){
            var table = $('.emp_leave_records').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_leave_records",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewleaverecord('+data.leave_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).deleteleaverecord('+data.leave_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "biometrics"},
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "leave_type" },
                  { "data": "leave_from"},
                  { "data": "leave_to" },
                  { "data": "num_days" },
                  { "data": "reason" },
                  { "data": "days_with_pay" },
                  { "data": "days_without_pay" }
                ]
            });

        });

        $(document).ready(function(){
            var tbl_credits = $('.emp_leave_credits').DataTable({
              "processing": true,
              "serverSide": false,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_leave_credits",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewleave_credits(`'+data.fileno+'`, `'+data.leave_type_id+'`);" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "biometrics"},
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "leave_type" },
                  { "data": "credit"},
                  { "data": "credit_date" },
                  { "data": "balance" },
                  { "data": "teaching" }
                ]
            });

            // $('#changeClassification').on('change',function(){
            //   tbl_credits.columns( 9 ).search( this.value ).draw();
            // });

           });


        $(document).ready(function(){
              var table = $('.emp_overtime_records').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_overtime_records",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewovertimerecord('+data.overt_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).delovertimerecord('+data.overt_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "date_ot" },
                  { "data": "timefrom" },
                  { "data": "timeto" },
                  // { "data": "hours_requested"},
                  { "data": "hours_rendered" },
                  { "data": "reason" },
                  { "data": "dept_head_date_approval" },
                  { "data": "remarks" }
                ]
            });
        });

        $(document).ready(function() {
          $('#summary_leave_records').DataTable({
            processing: true,
            serverSide: false,
            stateSave: true,
            paging: true,
            scrollX: true,
            ajax: {
              type: 'GET',
              url: '<?php echo base_url() ?>hr/datatables/get_summary_records'
            },
            columns: [
              {
                data: null,
                render: function(data, type, full) {
                     return '<center>\
                                <a type="button" onclick="$(this).viewleaverecord('+data.leave_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                <a type="button" onclick="$(this).deleteleaverecord('+data.leave_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                            </center>';
                },
                "searchable": false 
              },
              {data: 'biometrics'},
              {data: 'fileno'},
              {data: 'name'},
              {data: 'position'},
              {data: 'department'},
              {data: 'leave_type'},
              {data: 'leave_from'},
              {data: 'leave_to'},
              {data: 'num_days'},
              {data: 'reason'},
              {data: 'days_with_pay'},
              {data: 'days_without_pay'},
            ]
          });
        });

        $(document).ready(function(){
              var table = $('.emp_payslip_records_summary').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_passlip_records_summary",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewpaysliprecord('+data.pass_slip_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).delpaysliprecord('+data.pass_slip_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "slip_date" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours"},
                  { "data": "purpose" },
                  { "data": "dept_head_date_approval" },
                ]
            });

            var table2 = $('.personal_emp_payslip_records').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_passlip_records",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewpaysliprecord('+data.pass_slip_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).delpaysliprecord('+data.pass_slip_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "slip_date" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours"},
                  { "data": "purpose" },
                  { "data": "dept_head_date_approval" },
                ]
            });

            var table3 = $('.official_emp_payslip_records').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_official_passlip_records",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewpaysliprecord('+data.pass_slip_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).delpaysliprecord('+data.pass_slip_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "slip_date" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours"},
                  { "data": "purpose" },
                  { "data": "dept_head_date_approval" },
                ]
            });


          var table4 = $('.emp_official_payslip_records_summary').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_official_passlip_records_summary",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewpaysliprecord('+data.pass_slip_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).delpaysliprecord('+data.pass_slip_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "slip_date" },
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours"},
                  { "data": "purpose" },
                  { "data": "dept_head_date_approval" },
                ]
            });

        });

        $(document).ready(function(){
              var table = $('.emp_travel_order_records').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_travel_order_records",
              },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewtravelrecord('+data.travelo_id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).deltravelrecord('+data.travelo_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department"},
                  { "data": "travelo_date" },
                  { "data": "datefrom" },
                  { "data": "dateto" },
                  { "data": "destination"},
                  { "data": "purpose" },
                  { "data": "dept_head_date_approval" },
                  { "data": "remarks" }

                ]
            });

        });

         var tbl_non_teaching = $('#non_teaching_employees').DataTable({
              "oLanguage": {
                 "sProcessing": "<img src='<?=ROOT_URL?>assets/images/ajax-loader.gif' style='width:20px;'>"
             },
            "processing": true,
            "serverSide": false,
            "paging" : true,
            "scrollX": true,
            ajax:{
              "type": 'POST',
              "url" : "hr/datatables/get_emp_non_teaching_leavecredits",
            },
            "columns": [
                { "data": "fileno" },
                { "data": "biometrics" },
                { data: null, render: function(data, type, full) {
                     return data.lastname+', '+data.firstname+' '+data.middlename;
                  }
                },
                // { "data": "department" },
                // { "data": "position" },
                { "data": "employment_status" },
                { "data": "date_employ" },
                { "data": "yrs_service"},
                { "data" : "vl_credit" },
                { data: null, render: function(data, type, full) {
                    if(data.yrs_service >= 1 && data.employment_status == 'regular'){
                      return '<input type="number" class="form-control leavebalance" name="leavebalance[]">\
                      <input type="hidden" name="fileno[]" value="'+data.fileno+'">';
                    }else{
                      return '<span class="text-danger">N/A</span>';
                    }
                  }
                },
                // { data: null, render: function(data, type, full) {
                //      return '<input type="text" class="form-control">';
                //   }
                // }
            ],
      });

      $('.leavelbaldate').datepicker();
      
    }

    $.fn.getALL();

    $.fn.viewleaverecord = function(empid)
    {
        $('#updateleave').modal('show');
        $('#leave_type').empty();
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/view_leave',
            dataType: 'json',
            cache: false,
            data : 'leave_id=' + empid,
            success: function(result) {
              for (var i = 0; i < result.info[0].leave_type_credits.length; i++) {
                $('#leave_type').append('<option value="'+result.info[0].leave_type_credits[i]+'">'+result.info[0].leave_type_credits[i]+'</option>');
              }
              
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
              $('.update_leave_data #leave_status').val(result.info[0].dept_head_approval);
              $('.update_leave_data #date_approve_decline').val(result.info[0].head_date_approval);
              $('.update_leave_data #dept_remarks').val(result.info[0].head_approval_remarks);
              $('.update_leave_data #leave_id').val(result.info[0].leave_id);
              $('.update_leave_data #leave_type_id').val(result.info[0].leave_type_id);
              $('.update_leave_data #daysavailable').val(result.info[0].leave_balance);

              $('.update_leave_data select[name="leavetype"').val(result.info[0].leave_type);

              console.log(result.info[0].maternity_type);
              if(result.info[0].leave_type_id == 5)
              {
                $('.hide_div').removeClass('hidden');
                $('.update_leave_data #maternitytype').val((result.info[0].maternity_type).toUpperCase());
              }else{
                $('.hide_div').addClass('hidden');
              }

              $('.update_leave_data #dayswithpay').keyup(function(){

                var actual_days = $('.update_leave_data #actualdays').val();
                var input = $(this).val();

                var val = " ";
                if(input.length > 1 && input > 1){
                  var validation = input.replace(/^0+/, '');
                  var set_input = $(this).val(validation);
                  val = parseInt(validation);
                } else {
                  val = input;
                }

                if (val > actual_days) {
                  $('.error_message').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Value must be less than or equal to " + actual_days).show();
                } else if( val < 0) {
                  $('.error_message').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Value must be greater than or equal to 0").show();
                } else {
                  $('.update_leave_data #dayswitouthpay').val(actual_days - val);
                  $('.error_message').hide();
                }
              });

              $('.update_leave_data #dayswitouthpay').keyup(function(){
                var actual_days = $('.update_leave_data #actualdays').val();
                var input = $(this).val(); 

                var val = " ";
                if(input.length > 1 && input > 1){
                  var validation = input.replace(/^0+/, '');
                  var set_input = $(this).val(validation);
                  val = parseInt(validation);
                } else {
                  val = input;
                }

                if (val > actual_days) {
                  $('.error_message2').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Value must be less than or equal to " + actual_days).show();
                } else if( val < 0) {
                  $('.error_message2').html("<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Value must be greater than or equal to 0").show();
                } else {
                  $('.update_leave_data #dayswithpay').val(actual_days - val);
                  $('.error_message2').hide();
                }

              });
                
                
            }
        });
    }

  $(document).ready(function(){
    $.fn.deleteleaverecord = function(empid) {
      if (confirm("Are You Sure You want To delete This Records?") == true){
        var el = this;  
          $.ajax({  
            url:"hr/leave_ot_records/delete_leave",  
            method:"POST",  
            cache: false,
            data : 'leave_id=' + empid, 
            success:function(data) {  
               $(el).closest('tr').css('background','tomato');
                $(el).closest('tr').fadeOut(800, function(){ 
                  $(this).remove();
                });

            }
          });  
      }
    } 
  });

  $.fn.viewovertimerecord = function(overtid)
    {
        $('#updateovertime').modal('show');
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/get_overtime_records',
            dataType: 'json',
            cache: false,
            data : 'overt_id=' + overtid,
            success: function(result) {
                $('.update_overtime #employee_name').val(result.data[0].sname);
                $('.update_overtime #employee_id').val(result.data[0].fileno);
                $('.update_overtime #employee_fileno').val(result.data[0].fileno);
                $('.update_overtime #employee_department').val(result.data[0].department);
                $('.update_overtime #employee_position').val(result.data[0].position);
                $('.update_overtime .overtime_date').val(result.data[0].date_ot);
                $('.update_overtime .fromtime').val(result.data[0].timefrom);
                $('.update_overtime .totime').val(result.data[0].timeto);
                $('.update_overtime .numhours').val(result.data[0].hours_rendered);
                $('.update_overtime #reason').val(result.data[0].reason);
                $('.update_overtime #remarks').val(result.data[0].remarks);
                $('.update_overtime #dept_head_approval').val(result.data[0].dept_head_approval);
                $('.update_overtime #date_approve_decline ').val(result.data[0].dept_head_date_approval);
                $('.update_overtime #overt_id').val(result.data[0].overt_id);
            }
        });
    }

    $(document).ready(function(){
      $.fn.delovertimerecord = function(overtid) {
        if (confirm("Are You Sure You want To delete This Records?") ==  true){
          var el = this;  
            $.ajax({  
              url:"hr/leave_ot_records/delete_overtime_record",  
              method:"POST",  
              cache: false,
              data : 'overt_id=' + overtid, 
              success:function(data){
                 $(el).closest('tr').css('background','tomato');
                  $(el).closest('tr').fadeOut(800, function(){ 
                    $(this).remove();
                  });
              }
          });  
        }
      } 
    });

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
              console.log(result);
                $('.update_pass_slip #employee_name').val(result.data[0].name);
                $('.update_pass_slip #employee_id').val(result.data[0].fileno);
                $('.update_pass_slip #employee_fileno').val(result.data[0].fileno);
                $('.update_pass_slip #employee_department').val(result.data[0].department);
                $('.update_pass_slip #employee_position').val(result.data[0].position);
                $('.update_pass_slip #pass_slip_type').val(result.data[0].type);
                $('.update_pass_slip .pass_slip_date').val(result.data[0].slip_date);
                $('.update_pass_slip #destination').val(result.data[0].destination);
                $('.update_pass_slip #reason').val(result.data[0].purpose);
                $('.update_pass_slip .fromtime').val(result.data[0].exp_timeout);
                $('.update_pass_slip .totime').val(result.data[0].exp_timreturn);
                $('.update_pass_slip .numhours').val(result.data[0].numhours);
                $('.update_pass_slip .undertime').val(result.data[0].exact_undertime);
                $('.update_pass_slip .exacttimeout').val(result.data[0].exact_timeout);
                $('.update_pass_slip .exacttimereturn').val(result.data[0].exact_timereturn);
                $('.update_pass_slip .exactnumhours').val(result.data[0].exact_numhours);
                $('.update_pass_slip .exactundertime').val(result.data[0].exact_undertime);
                $('.update_pass_slip #dept_head_approval').val(result.data[0].dept_head_approval);
                $('.update_pass_slip .date_approve_decline').val(result.data[0].dept_head_date_approval);
                $('.update_pass_slip #pass_slip_id').val(result.data[0].pass_slip_id);

                if (result.data[0].date_return != "Jan 01 1970") {
                  $('.update_pass_slip #date_return').val(result.data[0].date_return);
                }
            }
        });
    }

    $(document).ready(function(){
      $.fn.delpaysliprecord = function(pass_slip_id) {
        if (confirm("Are You Sure You want To delete This Records?") ==  true){
          var el = this;  
            $.ajax({  
              url:"hr/leave_ot_records/delete_slip_record",  
              method:"POST",  
              cache: false,
              data : 'pass_slip_id=' + pass_slip_id, 
              success:function(data)  
               {  
                 $(el).closest('tr').css('background','tomato');
                  $(el).closest('tr').fadeOut(800, function(){ 
                    $(this).remove();
                  });

                }
            });  
        }
      } 
    });

    $.fn.viewtravelrecord = function(travelid)
    {
        $('#edit_travel_budget').find('tbody').empty();
        $('#updatetravelform').modal('show');
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/get_travel_order_records',
            dataType: 'json',
            cache: false,
            data : 'travelo_id=' + travelid,
            success: function(result) {

              console.log(result);

              $('.update_travel_order #employee_name').val(result.data[0].name);
              $('.update_travel_order #employee_id').val(result.data[0].fileno);
              $('.update_travel_order #employee_fileno').val(result.data[0].fileno);
              $('.update_travel_order #employee_department').val(result.data[0].department);
              $('.update_travel_order #employee_position').val(result.data[0].position);
              $('.update_travel_order .travel_date').val(result.data[0].travelo_date);
              $('.update_travel_order #destination').val(result.data[0].destination);
              $('.update_travel_order #reason').val(result.data[0].purpose);
              $('.update_travel_order .fromdate').val(result.data[0].datefrom);
              $('.update_travel_order .todate').val(result.data[0].dateto);
              $('.update_travel_order .numdays').val(result.data[0].numberofdays);
              $('.update_travel_order #to_status').val(result.data[0].dept_head_approval);
              $('.update_travel_order .date_approve_decline').val(result.data[0].dept_head_date_approval);
              $('.update_travel_order #travelo_id').val(result.data[0].travelo_id);

              var val = '';
                var total_budget = 0;
                for (var i = 0; i < result.data[0].budget.length ; i++) {
                    var numbers = parseFloat(result.data[0].budget[i].amount);
                    total_budget += numbers;
                    val += '<tr>\
                                <td style="display: none"><input type="text" name="budget_id[]" value='+result.data[0].budget[i].id+' class="form-control"/></td>\
                                <td style="width:60%"><input  class="form-control" type="text" name="budget_type[]" value="'+result.data[0].budget[i].types+'"/></td>\
                                 \
                                <td style="width:30%"><input type="number" min="0" step="0.01" name="budget_amount[]" value='+result.data[0].budget[i].amount+' class="form-control amount" onkeyup="sumfunction()"/></td>\
                                <td><button type="button" class="btn btn-danger btn-xs" id="remove_rows" onclick="delete_travel_budget('+result.data[0].budget[i].id+')" ><i class="fa fa-minus"></i></button></td>\
                            </tr>';
                }
                $('#edit_travel_budget tbody').append(val);
                $('#total_amount').val(total_budget);


            }
        });
    }

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

  function sumfunction(){
    var sum = 0;
    var amounts = document.getElementsByClassName('amount');

    for(var i=0; i<amounts .length; i++) {
        var a = +amounts[i].value;
        sum += parseFloat(a) || 0;
    }
    document.getElementById("total_amount").value = sum;

  }


  $(document).on("click","#edit_add_travel_budget",function(){
        var table = $('#edit_travel_budget');
        $('<tr>\
          <td style="display: none">\
              <input type="text" name="budget_id[]" placeholder="Types" value="0" class="form-control"/>\
          </td>\
          <td style="width:60%">\
              <input  class="form-control" type="text" name="budget_type[]"/>\
          </td>\
          <td style="width:30%">\
              <input type="number" name="budget_amount[]" step="0.01" placeholder="Estimated Amount" class="form-control amount" onkeyup="sumfunction()"/>\
          </td>\
          <td>\
              <button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button>\
          </td></tr>').appendTo(table);
    });

  $(document).on("click","#lesscol",function(){
      $(this).closest('tr').remove();
      sumfunction();
  });

    $(document).ready(function(){
      $.fn.deltravelrecord = function(travelo_id) {
        if (confirm("Are You Sure You want To delete This Records?") ==  true){
          var el = this;  
            $.ajax({  
              url:"hr/leave_ot_records/delete_travel_record",  
              method:"POST",  
              cache: false,
              data : 'travelo_id=' + travelo_id, 
              success:function(data)  
               {  
                 $(el).closest('tr').css('background','tomato');
                  $(el).closest('tr').fadeOut(800, function(){ 
                    $(this).remove();
                  });
                }
            });  
        }
      } 
    });



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

        // var numhours = Math.abs(time2 - time1) / 36e5;
        var numhours = Math.abs(time2.getTime() - time1.getTime() ) / 1000;

        var d = Number(numhours);

        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);

        var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
        var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";

        var result = hDisplay + mDisplay + sDisplay;

        $("."+e_class+" .numhours").val(result);

        //exact

        var from = $("."+e_class+" .exacttimeout").val();
        var to = $("."+e_class+" .exacttimereturn").val();

        var date = new Date();
        var month = date.getMonth();
        var day = date.getDate();
        var year = date.getFullYear();
        var fullfrom_time = month + '/'+ day + '/'+year + ' '+from;
        var fullto_time = month + '/'+ day + '/'+year + ' '+to;
        var time1 = new Date(fullfrom_time);
        var time2 = new Date(fullto_time);

        var numhours = Math.abs(time2 - time1) / 36e5;

        $("."+e_class+" .exactnumhours").val(numhours);

    }


    $('#add_new_personal').on('click', function () {
        $('#pass_slip_type').val('personal');
    });

    $('#add_new_official').on('click', function () {
        $('#pass_slip_type').val('official');
    });

    $(document).ready(function(){
      $("#education_degree").keypress(function(event){
          var inputValue = event.charCode;
          if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
              event.preventDefault();
          }
      });

      $('.btn-loader').removeClass('hide');

      // $.ajax({
      //     type: 'POST',
      //     url: '<?=ROOT_URL?>modules/hr/employees/update_employee_leave_credits/0',
      //     dataType: 'json',
      //     cache: false,
      //     data : 'update_emp_lc=true',
      //     success: function(result) {
      //         $('.btn-loader').addClass('hide');
      //     }
      // });
    });

     // add leave credits
    $.fn.addleavecredits = function()
    {
        $('#addLeaveCredits').modal('show');
    }

    $('.leave_date').datepicker();

    $(document).on('click', '#btn-save-leave-credits', function(){
        var form = $('#leave-credit-form').serialize();
        console.log($('.leavelbaldate').val());
        $.ajax({
          type: 'POST',
          url: 'hr/leave_ot_records/save_vl_leave_credits',
          dataType: 'json',
          cache: false,
          data : form,
          success: function(result) {
            alert('Record saved');
            window.location = 'employee_leave_credits';
          }
      });
    });

    $.fn.viewleave_credits = function(empid, ltype){
        $('#leave_credit_log tbody').html('');
        $('#view_leave_log').modal('show');

        $.ajax({
            url: "<?php echo base_url(); ?>profile/viewlog",
            type: "POST",
            dataType: 'json',
            data: "empid=" + empid + '&leave_type=' + ltype,
            success: function(data){
                var tbl = $('#leave_credit_log tbody');
                var html = "";

                for (var i = 0; i < data.result.length; i++) {
                    html += '<tr>\
                        <td>'+data.result[i].date_added+'</td>\
                        <td>'+data.result[i].leave_type+'</td>\
                        <td>'+data.result[i].leave_credit+'</td>\
                    </tr>';
                }
                $(html).appendTo(tbl);
            },
            error: function(request, status, error){
                alert(request.responseText);
            }  
        });
    }


</script>
