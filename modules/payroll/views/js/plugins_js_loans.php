<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>

<script type="text/javascript">
	
	$('#t_loans').dataTable({
		"processing": true,
	      "serverSide": false,
	      "stateSave": true,
	      "paging" : true,
	      "scrollX": true,
	      ajax:{
	        "type": 'POST',
	        "url" : "payroll/loans/get_emp_loans_dt",
	      },
               "columns": [
                  {
                    data: null,
                    render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewloandetails('+data.id+');" class="btn btn-success btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-eye-open"></i> </a>\
                                    <a type="button" onclick="$(this).deleteloan('+data.id+');" class="btn btn-danger btn-xs showInfo" target="_blank" ><i class="glyphicon glyphicon-trash"></i> </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
                  { "data": "name"},
                  { "data": "loan_description" },
                  { "data": "months_payable" },
                  { "data": "amt_per_month"},
                  { "data": "cut_off"},
                  { "data": "total_amt" },
                  { "data": "remarks"},
                ]
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
                        html += '<a style="background-color:#99CC66"; class="list-group-item" id="'+result[i].FileNo+'" onclick="$(this).viewdata();" >('+result[i].FileNo+') ' + full_name + '</a>';
                    }
                }
                $('.name_seach').html(html);
            }
        });
    }

     $.fn.viewdata = function()
    {
        var val = $(this).attr('id');
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
                            options += '<option value="'+result.leave[i].type_id+'">'+result.leave[i].type+'</option>';
                        }
                   }
                   $('.add_leave #div_leave').html('<select name="leavetype" id="leavetype" class="form-control" required onchange="$(this).getLeaveBal('+fileno+', $(this).val())">\
                                 <option value=""></option>\
                                 '+options+'\
                                </select>');
                }
            }
        });
    }

     $.fn.viewloandetails = function(loan_id)
    {
        $('#updateLoan').modal('show');
        $.ajax({
            type: 'POST',
            url: 'payroll/loans/get_emp_loan_details',
            dataType: 'json',
            cache: false,
            data : 'loan_id=' + loan_id,
            success: function(result) {

                $('.update_loans #employee_name').val(result.data[0].name);
                $('.update_loans #employee_id').val(result.data[0].fileno);
                $('.update_loans #employee_fileno').val(result.data[0].fileno);
                $('.update_loans #employee_department').val(result.data[0].department);
                $('.update_loans #employee_position').val(result.data[0].position);
                $('.update_loans #loan_description').val(result.data[0].loan_description);
                $('.update_loans #months_payable').val(result.data[0].months_payable);
                $('.update_loans #amt_per_month').val(result.data[0].amt_per_month);
                $('.update_loans #cut_off').val(result.data[0].cut_off);
                $('.update_loans #total_amt').val(result.data[0].total_amt);
                $('.update_loans #remarks').val(result.data[0].remarks);
                $('.update_loans #loan_id').val(result.data[0].loan_id);
            }
        });
    }

    $(document).ready(function(){
        $.fn.deleteloan = function(empid) {
          if (confirm("Are You Sure You want To delete this loan?") ==  true){
            var el = this;  
              $.ajax({  
                url:"<?php echo base_url(); ?>payroll/loans/delete_loan",  
                method:"POST",  
                cache: false,
                data : 'loan_id=' + empid, 
                success:function(data)  
                 {  
                   $(el).closest('tr').css('background','tomato');
                    $(el).closest('tr').fadeOut(800, function(){ 
                      $(this).remove();
                      alert('Successfully Deleted Leave Requests');
                    });

                  }
              });  
          }
        } 
    });

</script>