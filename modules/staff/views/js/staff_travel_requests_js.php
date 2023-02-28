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

        $('#edit_travel_budget').find('tbody').empty();
        $('#updatetravelform').modal('show');
        $.ajax({
            type: 'POST',
            url: 'hr/leave_ot_records/get_travel_order_records',
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


    $(document).on("click","#add_travel_budget",function(){
        var table = $('#travel_budget');
        $('<tr>\
            <td style="width:60%">\
                <input  class="form-control" type="text" name="budget_type[]"/>\
            </td>\
            <td style="width:30%">\
                <input type="number" name="budget_amount[]" step="0.01" placeholder="Estimated Amount" class="form-control add_amount" onkeyup="add_sumfunction()"/>\
            </td>\
            <td>\
                <button type="button" class="btn btn-success btn-xs" id="add_travel_budget"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button>\
            </td></tr>').appendTo(table);
    });

    function add_sumfunction(){
        var sum = 0;
        var amounts = document.getElementsByClassName('add_amount');

        for(var i=0; i<amounts .length; i++) {
            var a = +amounts[i].value;
            sum += parseFloat(a) || 0;
        }
        document.getElementById("add_total_amount").value = sum;
    }

    $(document).on("click","#lesscol",function(){
        $(this).closest('tr').remove();
        sumfunction();
    });

    $(document).on("click","#new_travel_modal",function(){
        $('#travel_budget').find('tbody').empty();
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