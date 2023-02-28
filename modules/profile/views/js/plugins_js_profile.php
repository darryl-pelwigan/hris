<?php
    $leavetypelists = ""; 
    if($leavetype_lists){
        foreach($leavetype_lists as $ltl){
            $leavetypelists .= '<option value="'.$ltl->id.'">'.$ltl->type.'</option>';
        }
    }
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    

    $(document).on("click",".editinfo",function(){
        var id = $(this).attr('id');
        $.ajax({
            url : "<?=ROOT_URL?>editstaff.php",
            dataType : "json",
            type: "post", 
            data: "sid="+id,
            success: function (data){
                $('.edits').html(data.result);
            },
            error: function (request, status, error){
                alert(request.responseText);
            }
        });
    });

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });

    $(document).on("click", "#lesseducothers", function(){
        $(this).closest("tr").remove();         
    });

     $(document).on("click", "#lesselig", function(){
        $(this).closest("tr").remove();         
    });

    $(document).on("click", ".deleducback", function(){
        var id = $(this).attr("id");
        var x = confirm("Are you sure to delete this record?");
        if(x)
             $.ajax({
                  url : "../profile/delete_education",
                  dataType: "json",
                  type: "post",
                  data: "del_educ=" + id,
                  success: function(data){ 
                    $("#"+id).closest("tr").remove();
                  },
                  error: function(request, status, error){
                    // alert(request.responseText);
                  }
            });
    });

    var e_eductype = ["Doctorate", "Masters", "Bachelor", "Others"];

    $(document).click(".e_eductype", function(){

        $( ".e_eductype" ).autocomplete({
        source:
            function(request, response) {
                var results = $.ui.autocomplete.filter(e_eductype, request.term);
                response(results.slice(0, 15));
            },
            minLength: 0,
            scroll: true,
            autoFocus:true
        }).focus(function(req,response) {
            $(this).autocomplete("search", "");
          
        });
    });
            

    var educstatus = ["Units Earned", "On Going", "Completed"];
    $(document).click(".e_educstatus", function(){
        $( ".e_educstatus" ).autocomplete({
            source:
                function(request, response) {
                    var results = $.ui.autocomplete.filter(educstatus, request.term);
                    response(results.slice(0, 15));
                },
            minLength: 0,
            scroll: true,
            autoFocus:true
        }).focus(function(req,response) {
            $(this).autocomplete("search", "");
          
        });
    });

    $(document).on("click", ".e_educremarks", function(){
        var id = $(this).attr("id");
        var val = $("#e_educstatus_"+id).val();
        if(val == "Completed"){
            $(this).attr("placeholder", "Year completed");
        }else if(val == "Units Earned"){
            $(this).attr("placeholder", "Number of Units");
        }else{
            $(this).attr("placeholder", "Remarks");
        }
    });

    Date.prototype.getDOY = function() {
        var onejan = new Date(this.getFullYear(),0,1);
        return Math.ceil((this - onejan) / 86400000);
    }
    function getBdate(){

        var cyear=<?php echo date('Y'); ?>;
        var cmonth=<?php echo date('m'); ?>;
        var year;
        var bmonth = document.getElementById("mmonth").value;
        var bday = document.getElementById("mday").value;
        var byear = document.getElementById("myear").value;

        var daytoday = <?php echo date('z'); ?>;

        var dmonth = bmonth - 1;
        var countd = new Date(byear,dmonth,bday);
        var daynum = countd.getDOY();

        var bdate = bmonth+'/'+bday+'/'+byear;

        year = cyear - 1;
        total1 = year - byear;
        total2 = (12 - bmonth) + cmonth;
        total3 = total2 / 12;

        var age1=(total1 + total3);
        var age2 = Math.round(age1 * 100) / 100;
        var age = Math.floor(age2); 
        var months1 = age * 12;
        var months = Math.round(months1 * 100) / 100;

        if(daynum <= daytoday){
            document.getElementById("age").value=age;
        }else if(bmonth == cmonth && daynum > daytoday){
            document.getElementById("age").value=age-1;
        }else{
            document.getElementById("age").value=age;
        }
    }
    function bDay(){
        var cyear=<?php echo date('Y'); ?>;
        var cmonth=<?php echo date('m'); ?>;
        var year;
        var bmonth = document.getElementById("mmonth").value;
        var bday = document.getElementById("mday").value;
        var byear = document.getElementById("myear").value;

        var daytoday = <?php echo date('z'); ?>;

        var dmonth = bmonth - 1;
        var countd = new Date(byear,dmonth,bday);
        var daynum = countd.getDOY();

        var bdate = bmonth+'/'+bday+'/'+byear;
       
        year = cyear - 1;
        total1 = year - byear;
        total2 = (12 - bmonth) + cmonth;
        total3 = total2 / 12;

        var age1=(total1 + total3);
        var age2 = Math.round(age1 * 100) / 100;
        var age = Math.floor(age2); 
        var months1 = age * 12;
        var months = Math.round(months1 * 100) / 100;

        if(daynum <= daytoday){
            document.getElementById("mage").value=age;
        }else if(bmonth == cmonth && daynum > daytoday){
            document.getElementById("mage").value=age-1;
        }else{
            document.getElementById("mage").value=age;
        }
    }

     $(function() {
        //for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
        $('a[data-toggle="tab"]').on('click', function (e) {
            //save the latest tab; use cookies if you like 'em better:
            localStorage.setItem('lastTab', $(e.target).attr('href'));
        });
        //go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('a[href="'+lastTab+'"]').click();
        }
    });

    var k = $('#morevac tr').length;
    $(document).on("click","#modmorevac",function(){
        var e = $("#morevac");
        $('<tr>\
                <td width="39.5%">\
                    <select name=\"leave_type[]\" id=\"leave'+(k+1)+'\" required class=\"form-control\" required>\
                        <option value=""></option>\
                        <?=$leavetypelists?>\
                    </select>\
                    <input type="hidden" name="leave_id[]" value="0"/>\
                </td>\
                <td>\
                    <input type=\"number\" id=\"vacleave'+(k+1)+'\"  required step="0.001" min=\"0\" name=\"leave_credit[]\" required class=\"form-control\"/>\
                </td>\
                <td width=\"5%\">\
                    <button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button>\
                </td>\
            </tr>').appendTo(e);
        k++;
        return false;
    });

    $(document).on('change', "[id^=\"leave\"]", function(){
        for(var i=0; i<=k; i++){
            var lvtype = $("#leave"+i).val();
            if(lvtype==4){
                $("#vacleave"+i).val(1);
            }else if(lvtype==3){
                $("#vacleave"+i).val(2);
            }else{
                $("#vacleave"+i).val();
            }
        }
    });

    $(document).on('click', "#lesscol", function(){
        $(this).closest('tr').remove();
    });


    $.fn.get_leave_type_record_dt = function(ltype) {

        var table = $('#tbl_leave_records').DataTable({
            ajax: {
                url: "<?=base_url()?>profile/datatables/get_leave_records_dt",
                type: "POST",
                data : {
                    "ltype" : ltype,
                    "staff_id" : $('#emp_fileno').val(),
                }
            },
            scrollX: true,
            deferRender: true,
            processing: true,
            serverSide: true,
            columns: [
                {
                data: null ,
                  render : function ( data, type, dataToSet ) {
                    <?php if($this->session->userdata('role') == 7): ?>
                        var text = 'Edit';
                    <?php else: ?>
                        var text = 'View';
                    <?php endif; ?>
                    return '<td><button class="btn btn-success btn-xs" onclick="$(this).edit_leave_record('+data.id+');" type="button" data-id='+data.id+' data-backdrop="static" data-keyboard="false" data-toggle="modal">'+text+'</button>';

                  },
                  "searchable": false,
                  "sortable": false
                },
                {"data": "id", visible:false},
                {"data": "type","searchable":true},
                {"data": "leave_from","searchable":true},
                {"data": "leave_to","searchable":true},
                {"data": "num_days"},
                {"data": "reason","searchable":true},
                {"data": "depremarks","searchable":true},
                {"data": "dayswithpay"},
                {"data": "dayswithoutpay"},
                {"data": "hr_remarks"},
            ],
        });

    }

    //table for pass slip info
    $(document).ready(function(){
              var table = $('#tbl_pass_slip').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "<?=base_url()?>profile/datatables/get_passlip_records_dt",
                data : {
                    "staff_id" : $('#emp_fileno').val(),
                }
              },
               "columns": [
                  { "data": "type" },
                  { "data": "slip_date"},
                  { "data": "purpose"},
                  { "data": "exp_timeout" },
                  { "data": "exp_timreturn" },
                  { "data": "numhours" },
                  { "data": "dept_head_date_approval" }
                ]
            });

        });

    //!------------------------------------------------------- 
    //table for overtime records
     $(document).ready(function(){
              var table = $('#tbl_overtime_records').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "<?=base_url()?>profile/datatables/get_overtime_records_dt",
                data : {
                    "overtime_id" : $('#emp_fileno').val(),
                }
              },

               "columns": [
                  { "data": "reason" },
                  { "data": "timefrom"},
                  { "data": "timeto"},
                  { "data": "hours_rendered" },
                  { "data": "remarks" },
                ]
            });

        });

     //!------------------------------------------------------- 

    $(document).ready(function(){
              var table = $('#tbl_travel_history').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "<?=base_url()?>profile/datatables/get_travelo_records_dt",
                data : {
                    "staff_id" : $('#emp_fileno').val(),
                }
              },
               "columns": [
                  { "data": "travelo_date" },
                  { "data": "destination"},
                  { "data": "purpose" },
                  { "data": "date_of_travel" },
                  { "data": "remarks" },
                  { "data": "dept_head_date_approval" },
                ]
            });

        });

    // ---------------------------------------------------------------

    $.fn.get_leave_type_record = function(ltype) {
        $('#tbl_leave_records').DataTable().destroy();
        $.fn.get_leave_type_record_dt(ltype);
    }

    $.fn.get_leave_type_record_dt();

    $.fn.edit_leave_record = function(leave_id) {
       $('#editleave').modal('show');
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
                $('.update_leave_data #leave_status').val(result.info[0].dept_head_approval);
                $('.update_leave_data #date_approve_decline').val(result.info[0].head_date_approval);
                $('.update_leave_data #dept_remarks').val(result.info[0].head_approval_remarks);
                $('.update_leave_data #leave_id').val(result.info[0].leave_id);
                $('.update_leave_data #leave_type_id').val(result.info[0].leave_type_id);
                $('.update_leave_data #leavetype').val(result.info[0].leave_type);

                var ltype = result.info[0].leave_type_id;
                var balance = 0;
                var options = "";
                var fileno = "";
               //  if(result.leave.length > 0){
               //      fileno = result.info[0].FileNo;
               //      balance = result.leave[0].Bal;
               //      for (var i = 0; i < result.leave.length; i++) {
               //          options += '<option '+(ltype == result.leave[i].type_id ? 'selected' : 0)+' value="'+result.leave[i].type_id+'">'+result.leave[i].type+'</option>';
               //      }
               // }

               $('.update_leave_data #daysavailable').val(result.info[0].num_days);

               // $('.update_leave_data #div_leave').html('<select name="leavetype" id="leavetype" class="form-control" required onchange="$(this).getLeaveBal('+fileno+', $(this).val())">\
               //               <option value=""></option>\
               //               '+options+'\
               //              </select>');
            }
        });
    }

    $.fn.update_leave_record = function() {
        var form = $("#update_leave_form").serialize();

        $.ajax({
            url: '../employees/update_leave_record',
            type: 'post',
            dataType: 'json',
            data: form,
            success:function(data){
                var n = noty({
                    text        : "Edited Leave Request",
                    type        : 'success',
                    dismissQueue: true,
                    timeout     : 2000,
                    closeWith   : ['click'],
                    layout      : 'topCenter',
                    theme: 'defaultTheme',
                    maxVisible  : 3,
                });
                var $oTableToUpdate =  $("#example").dataTable( { bRetrieve : true } );
                $oTableToUpdate.fnDraw();
            }
        });
        $('#editleave').modal('toggle');
        $('#tbl_leave_records').DataTable().ajax.reload();
    }


    $("#numdays2").on("blur", function(){
        $(".haspay").attr({
            "max": $(this).val()
        })
        $.fn.show_error();
    })

    $("#numdays2").on("keyup", function(){
        $("#vacl").val($(this).val());
        $.fn.show_alert();
    });

    $(".haspay").on("keyup",function(){
        $.fn.show_error();
    });

    $.fn.show_alert = function() {
        var availvac = $("#availvac").val();
        var vacsubnum = $("#vacl").val();

        if(parseFloat(vacsubnum) > parseFloat(availvac)){
            $("button[name='updateleave']").prop("disabled",true);
            $(".message").removeClass("hidden");
            $(".message").html("<div class=\"alert alert-warning\"><strong>Warning!</strong> Number of days to be subtracted from vacation leave is greater than available vacation leave.</div>");
        }else{
            $("button[name='updateleave']").prop("disabled",false);
            $(".message").addClass("hidden");
            $(".message").html("");
        }
    }

    $.fn.show_error = function() {
        var actual = $("#numdays2").val();
        var withpay = $("#withpay").val();
        var withoutpay = $("#withoutpay").val();
        var vacbalance = $("#vacl").val();
        var maxbal = $("#availabledays").val();
        if(parseFloat(actual) > parseFloat(maxbal) && (vacbalance<=0 || vacbalance=='')){
            $("button[name='updateleave']").prop("disabled",false);
            $(".message").removeClass("hidden");
            $(".message").html("<div class=\"alert alert-info\">"+(actual-maxbal).toFixed(2)+" day(s) greater than remaining balance for leave.</div>");
        }
        if(((withpay=='' || withoutpay=='') && (parseFloat(actual) <= parseFloat(maxbal)))){
            $("button[name='updateleave']").prop("disabled",false);
            $(".message").addClass("hidden");
            $(".message").html("");
        } 
        if(((parseFloat(withoutpay) + parseFloat(withpay)) != parseFloat(actual)) && (withpay!='' && withoutpay!='')){
            $("button[name='updateleave']").prop("disabled",true);
            $(".message").removeClass("hidden");
            $(".message").html("<div class=\"alert alert-warning\"><strong>Warning!</strong> Sum of days with pay and days without pay does not equal actual number of days.</div>");
        }
        if((parseFloat(withoutpay) + parseFloat(withpay) == parseFloat(actual))){
            $("button[name='updateleave']").prop("disabled",false);
            $(".message").addClass("hidden");
            $(".message").html("");
        }
    }

    $(document).on("click","#modmorecol",function(){
        var r = $("#modcollege");
        $('<tr>\
        <td style="width:50%">\
            <input type="text" name="apps[]" placeholder="Appointment" required class="form-control"/>\
        </td>\
        <td style="width:20%">\
            <input type="text" name="from[]" placeholder="From" required class="form-control moddateemp"/>\
        </td>\
        <td style="width:20%">\
            <input type="text" name="to[]" placeholder="To" required class="form-control moddateemp"/>\
        </td>\
        <td>\
            <button type="button" class="btn btn-success btn-xs" id="modmorecol"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button>\
        </td></tr>').appendTo(r);
        $(".moddateemp").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "MM d, yy"
        });
        return false;
    });

    $(document).on("click", ".delappointment", function(){
        var id = $(this).attr("id");
        var x = confirm("Are you sure to delete this record?");
        if(x)
             $.ajax({
                  url : "../profile/delete_appointment",
                  dataType: "json",
                  type: "post",
                  data: "delappoint=" + id,
                  success: function(data){
                    $("#"+id).closest("tr").remove();
                  },
                  error: function(request, status, error){
                    alert(request.responseText);
                  }
            });
    });

    $(document).on("click","#modmoreid",function(){
    var r = $("#modotherid");
    $('<tr><td style="width:60%"><input class="form-control" type="text" placeholder="ID Name" name="othername[]"></td><td><input class="form-control modlicno" type="text" placeholder="Number" name="otherno[]"></td><td><button type="button" class="btn btn-success btn-xs" id="modmoreid"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button></td></tr>').appendTo(r);
    return false;
    });


    $(document).on("click","#morecol",function(){
        var r = $("#appointment_history");
        $('<tr><td><input type="text" name="apps[]" placeholder="Appointment" class="form-control"/></td>'+
           '<td><input type="text" name="from[]" placeholder="From" class="form-control datepicker"/></td>'+
           '<td><input type="text" name="to[]" placeholder="To" class="form-control datepicker"/></td>'+
           '<td><button type="button" class="btn btn-warning btn-sm" id="lesscol"><i class="fa fa-minus"></i></button></td></tr>').appendTo(r);
       
       $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
      });
        return false;

      

    });


    $(document).on("click", ".delotherid", function(){
        var id = $(this).attr("id");
        var x = confirm("Are you sure to delete this record?");
        if(x)
            $.ajax({
                url : "../profile/delete_otherID",
                dataType: "json",
                type: "post",
                data: "del_other=" + id,
                success: function(data){
                $("#"+id).closest("tr").remove();
                },
                error: function(request, status, error){
                alert(request.responseText);
                }
            });
    });


    $(function(){
        $("#upload_link").on('click', function(e){
            e.preventDefault();
            $("#upload_profile_image:hidden").trigger('click');
        });
    });

$(document).ready(function() {
    $(document).on('change', '#upload_profile_image', function() {
        var property = document.getElementById("upload_profile_image").files[0];
        var image_name = property.name;
        var image_extension = image_name.split(".").pop().toLowerCase();

        var id = $('#emp_fileno').val();
        if(jQuery.inArray(image_extension, ['gif','png','jpg','jpeg']) == -1) {
            alert("Invalid Image File");
        }

        var form_data = new FormData();
        form_data.append("file", property);

        $.ajax({
            url: "<?php echo base_url(); ?>profile/upload_profile/"+id,
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#uploaded_image_message').html("<label class='text-success'>Image Uploading...</label>");
            },
            success:function(data)
            {
                console.log(data);
                if (!$.trim(data)) {
                    alert('Duplicated File Name... Please Re-upload again');
                } else {
                    location.reload();
                }
            }
        });
    });
});

$(document).on('click', '.viewlog', function(){
    var empid = $(this).data('empid');
    var ltype = $(this).data('leave_type');
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
                    <td>'+data.result[i].leave_credit+'</td>\
                </tr>';
            }
            $(html).appendTo(tbl);
        },
        error: function(request, status, error){
            alert(request.responseText);
        }  
    });
});

$.fn.changeActiveStat = function(value) {
    $('#employee_separation_modal').modal('show');
    $('.employee_stat #emp_status option[value="'+value+'"]').prop('selected', 'selected');

    $.ajax({
        type: 'POST',
        url: '<?=ROOT_URL?>modules/hr/employees/viewdata',
        dataType: 'json',
        cache: false,
        data : 'view_emp_data=<?=$user[0]->FileNo?>',
        success: function(result) {
            $('.employee_stat #empreasonforseparation').val(result.info[0]['leavereason']);
            $('.employee_stat #emp_lastday').val(result.info[0]['lastday']);
        }
    });
    
}

$('#edit_profile').scroll(function() {
    $('#ui-datepicker-div').css('display', 'none');
    $('.ui-autocomplete').css('display', 'none');
});


</script>
<script src="<?=ROOT_URL?>js/typeahead.bundle.js"></script>

<script type="text/javascript" src="<?=ROOT_URL?>modules/assets/js/bootstrap-checkbox.min.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>modules/assets/functions/js/edit_auto_save_hr_edi.js"></script>