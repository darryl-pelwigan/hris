<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/functions/js/auto_save_hr_edi.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/functions/js/hr_notification.js"></script>
<script type="text/javascript">

Date.prototype.getDOY = function() {
    var onejan = new Date(this.getFullYear(),0,1);
    return Math.ceil((this - onejan) / 86400000);
}

  function getBdate(){
        var cyear=<?php echo date('Y'); ?>;
        var cmonth=<?php echo date('m'); ?>;
        var year;
        var bmonth = document.getElementById("month").value;
        var bday = document.getElementById("day").value;
        var byear = document.getElementById("year").value;

        var daytoday = <?php echo date('z'); ?>;

        var dmonth = bmonth - 1;
        var countd = new Date(byear,dmonth,bday);
        var daynum = countd.getDOY();

        var bdate = bmonth+'/'+bday+'/'+byear;
   //     document.getElementById('bdate').value=bdate;
       
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
   //     document.getElementById('bdate').value=bdate;
       
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

// function getSpouse(){
//     var status = $("#civil").val();
//     if(status == 'married'){
//         $("#realspousename").prop('readonly',false);
//         $("#realspouseocc").prop('readonly',false);
//         $("#realspouseadd").prop('readonly',false);
//         $("#realspousecon").prop('readonly',false);
//     } else{
//         $("#realspousename").prop('readonly',true);
//         $("#realspouseocc").prop('readonly',true);
//         $("#realspouseadd").prop('readonly',true);
//         $("#realspousecon").prop('readonly',true);
//     }
// }
function readprofpic(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#profpic').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on("click",".editinfo",function()
{        var id = $(this).attr('id');
    $.ajax({
        url : "editstaff.php",
        dataType : "json",
        type: "post", 
        data: "sid=" + id,
        success: function (data){
            $('.edits').html(data.result);
        },
        error: function (request, status, error){
            alert(request.responseText);
        }
    });
});
var k = $("#morevac tr").length;
// $(".otherleave").on("change", function(){
//     alert('ads');
// })
// function getSpouse(){
//     var status = $("#civil").val();
//     if(status == 'married'){
//         $("#realspousename").prop('readonly',false);
//         $("#realspouseocc").prop('readonly',false);
//         $("#realspouseadd").prop('readonly',false);
//         $("#realspousecon").prop('readonly',false);
//     } else{
//         $("#realspousename").prop('readonly',true);
//         $("#realspouseocc").prop('readonly',true);
//         $("#realspouseadd").prop('readonly',true);
//         $("#realspousecon").prop('readonly',true);
//     }
// }

$("#empstat").on("change",function(){
    var status = $("#empstat").val();
    if(status == 'contractual'){
        $("#endcontract").prop('disabled',false);
        document.getElementById("endcontract").required = true;
    }else{
        $("#endcontract").prop('disabled',true);
        document.getElementById("endcontract").required = false;
    }
});

$(document).on("change","#modempstat",function(){
    var status = $("#modempstat").val();
    if(status == 'contractual'){
        $("#modendcontract").prop('disabled',false);
        document.getElementById("modendcontract").required = true;
    }else{
        $("#modendcontract").prop('disabled',true);
        document.getElementById("modendcontract").required = false;
    }
});

$(document).on("click","#morecol",function(){
    var r = $("#college");
    $('<tr>\
    <td style="width:50%">\
        <input type="text" name="apps[]" placeholder="Appointment" required class="form-control"/>\
    </td>\
    <td style="width:20%">\
        <input type="text" name="from[]" placeholder="From" required class="form-control dateemp"/>\
    </td>\
    <td style="width:20%">\
        <input type="text" name="to[]" placeholder="To" required class="form-control dateemp"/>\
    </td>\
    <td>\
        <button type="button" class="btn btn-success btn-sm" id="morecol"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-warning btn-sm" id="lesscol"><i class="fa fa-minus"></i></button></td>\
    </td></tr>').appendTo(r);
    $(".dateemp").datepicker({
        yearRange: "-80:+5",
        changeMonth: true,
        changeYear: true,
        dateFormat: "MM d, yy"
    });
    return false;
});
$(document).on("click","#moreid",function(){
    var r = $("#otherid");
    $('<tr>\
   <td><input class="form-control" type="text" placeholder="ID Name" name="othername[]"></td>\
   <td><input class="form-control licno" type="text" placeholder="Number" name="otherno[]"></td>\
   <td><button type="button" class="btn btn-success btn-sm" id="moreid"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-warning btn-sm" id="lesscol"><i class="fa fa-minus"></i></button></tr>').appendTo(r);
    $(".licno").bind("keypress", function (event) {
        var regex = new RegExp("^[0-9_-]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    });
    return false;
});

var rw = $("#educothers tr").size() + 1;
$(document).on("click","#moreeduc",function(){
    var e = $("#educothers");
    $('<tr><td><select name="eductype[]" id="eductype" class="form-control">\
            <option value="Bachelor">Bachelor</option><option value="Masters">Masters</option>\
            <option value="Doctorate">Doctorate</option><option  value="Others">Others</option></select></td>\
        <td><input type="text" id="education_degree" name="educdegree[]" placeholder="Degree" class="form-control education_degree"/></td>\
        <td><select name="educstatus[]" id="educstatus_'+rw+'" onchange="educationChange('+rw+')" class="form-control"><option selected disabled>Status</option>\
            <option value="On Going" data-placeholder="Remarks">On Going</option><option value="Completed" data-placeholder="Year Completed">Completed</option><option value="Units Earned" data-placeholder="Units Earned">Units Earned</option>\
            </select></td>\
        <td><input type="text" name="educremarks[]" id="educremarks_'+rw+'" class="form-control educremarks"/></td>\
        <td><input type="text" name="educnameschool[]" class="form-control" placeholder="Name of School and Address"/></td>\
        <td><button type="button" class="btn btn-success btn-xs" id="moreeduc"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-warning btn-xs" id="lesscol"><i class="fa fa-minus"></i></button</td>\
        </tr>').appendTo(e);

    $(".education_degree").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });
    
    rw++;
    return false;
});

$(document).on("click","#moredep",function(){
    var e = $("#dependent");
    $('<tr>\
    <td><input type="text" class="form-control" name="dpntname[]"></td>\
    <td><input type="text" class="form-control dateemp" name="dpntbday[]"/></td>\
    <td><input type="text" class="form-control" name="dpntrel[]"/></td>\
    <td><button type="button" class="btn btn-success btn-sm" id="moredep"><i class="fa fa-plus"></i></button>\
    <button type="button" class="btn btn-warning btn-sm" id="lessdep"><i class="fa fa-minus"></i></button></td></tr>').appendTo(e);
    $(".dateemp").datepicker({
        yearRange: "-80:+5",
        changeMonth: true,
        changeYear: true,
        dateFormat: "MM d, yy"
    });
    return false;
});
var row = $("#elig tr").length;
$(document).on("click","#moreelig",function(){
    var e = $("#elig");
    $('<tr>\
        <td><input type="text" class="form-control" id="eligname'+row+'" name="eligname[]"></td>\
        <td><input type="text" class="form-control dateemp" name="eligdate[]"/></td>\
        <td><input type="text" class="form-control licno" name="eligno[]"/></td>\
        <td><input type="text" class="form-control fileno" name="eligrate[]"/></td>\
        <td><input type="text" class="form-control dateemp" name="expiry[]"/></td>\
        <td><button type="button" class="btn btn-success btn-xs" id="moreelig"><i class="fa fa-plus"></i></button>\
    <button type="button" class="btn btn-warning btn-xs" id="lessdep"><i class="fa fa-minus"></i></button></td></tr>').appendTo(e);
    $(".dateemp").datepicker({
        yearRange: "-80:+5",
        changeMonth: true,
        changeYear: true,
        dateFormat: "MM d, yy"
    });

    $(".licno").bind("keypress", function (event) {
        var regex = new RegExp("^[0-9_-]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    });
    $(".fileno").bind("keypress", function (event) {
        var regex = new RegExp("^[0-9\\.]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    });
    var eliglist = [];
    $.ajax({
            type: 'POST',
            url: 'hr/employees/eligList',
            dataType: 'json',
            cache: false,
            success: function(result) {
                $.each(result, function(index, value) {
                    eliglist.push(value['eligname']);
                });
            }
        });

        $( '#eligname'+row ).autocomplete({
            source:
                function(request, response) {
                    var results = $.ui.autocomplete.filter(eliglist, request.term);
                    response(results.slice(0, 15));
                },
            minLength: 0,
            scroll: true,
            autoFocus:true
        }).focus(function(req,response) {
            $(this).autocomplete("search", "");
        });
    row++;
    return false;
})

$(document).on("click","#lesscol",function(){
    $(this).closest('tr').remove();
});

$(document).on("click","#lesseduc",function(){
    $(this).closest('tr').remove();
})
$(document).on("click","#lessdep",function(){
    $(this).closest('tr').remove();
});

//FORM VALIDATION
/*    $(".fileno").on("keyup", function(){
    if(!isNaN(this.value) && this.value.length!=0){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});
$(".biono").on("keyup", function(){
    if(!isNaN(this.value) && this.value.length!=0){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});*/
$(".sss").on("keyup", function(){
    if(/^[0-9._-]+$/.test(this.value)){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});
$(".philhealth").on("keyup", function(){
    if(/^[0-9._-]+$/.test(this.value)){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});
$(".peraa").on("keyup", function(){
    if(/^[0-9._-]+$/.test(this.value)){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});
$(".pagibig").on("keyup", function(){
    if(/^[0-9._-]+$/.test(this.value)){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});
$(".tin").on("keyup", function(){
    if(/^[0-9._-]+$/.test(this.value)){
        $(this).css("background-color", "white");
    }else if(this.value.length != 0){
        $(this).css("background-color", "rgb(249, 124, 124)");
    }else{
        $(this).css("background-color", "white");
    }
});
$(".licno").bind("keypress", function (event) {
    var regex = new RegExp("^[0-9_-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
$(".fileno").bind("keypress", function (event) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
$(".rating").bind("keypress", function (event) {
    var regex = new RegExp("^[0-9\\.]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
$(".biono").bind("keypress", function (event) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
$(document).on("change",".modsss",function(){
    this.setCustomValidity(this.validity.patternMismatch ? "SSS No. must consist of 12 numbers and a dash" : "");
});
$(document).on("change",".modphilhealth",function(){
    onkeyup=this.setCustomValidity(this.validity.patternMismatch ? "PhilHealth No. must consist of 12 numbers and 2 dashes" : "");
});
$(document).on("change",".modperaa",function(){
    this.setCustomValidity(this.validity.patternMismatch ? "PERAA No. must consist of 12 numbers and a dash" : "");
});
$(document).on("change",".modpagibig",function(){
    this.setCustomValidity(this.validity.patternMismatch ? "PAG-IBIG No. must consist of 14 numbers and spaces" : "");
});
$(document).on("change",".modtin",function(){
    this.setCustomValidity(this.validity.patternMismatch ? "TIN No. must consist of 12 numbers and 3 dashes" : "");
});
$(".dateemp").datepicker({
    yearRange: "-80:+5",
    changeMonth: true,
    changeYear: true,
    dateFormat: "MM d, yy"
});

$("#dependents").on("change", function(){
    var dep = $("#dependents").val();
    if(dep=='with dependents'){
        $("#dependent").prop('hidden',false);
    }else{
         document.getElementById("dependent").display="none";
    }
})
$(document).on("change",".modmonth",function(){
    bDay();
});
$(document).on("change",".modyear",function(){
    bDay();
});
$(document).on("change",".modday",function(){
    bDay();
});
jQuery(function($){
    $(".sss").mask("99-9999999-9",{placeholder:"__-_______-_"});
    $(".philhealth").mask("9999-9999-9999",{placeholder:"____-____-____"});
    $(".peraa").mask("999999-9999",{placeholder:"______-____"});
    $(".pagibig").mask("9999-9999-9999",{placeholder:"____-____-____"});
    $(".tin").mask("999-999-999-999",{placeholder:"___-___-___-___"});
    $(".cont").mask("99999999999",{placeholder:"09_________"});
});

// $('.biono').keyup(function() {
//     var biono = $('.biono').val();
//     var data = {
//         biono:biono
//     };
//     $.post('checkid.php?checkid', JSON.stringify(data),  function(result) {
//        $('#bioid').html(result);
//     });
// });
// $('.fileno').keyup(function() {
//     var fileno = $('.fileno').val();
//     var data = {
//         fileno:fileno
//     };
//     $.post('checkid.php?fileno', JSON.stringify(data),  function(result) {
//        $('#fileid').html(result);
//     });
// });

var relglist = [];
var eliglist = [];
$.ajax({
    type: 'POST',
    url: 'hr/employees/religion_list',
    dataType: 'json',
    cache: false,
    success: function(result) {
        $.each(result, function(index, value) {
            relglist.push(value['Religion']);
        });
    }
});

$('#religion').autocomplete({
    source:
        function(request, response) {
            var results = $.ui.autocomplete.filter(relglist, request.term);
            response(results.slice(0, 15));
        },
    minLength: 0,
    scroll: true,
    autoFocus:true

}).focus(function(req,response) {
    $(this).autocomplete("search", "");
});


$.ajax({
    type: 'POST',
    url: 'hr/employees/eligList',
    dataType: 'json',
    cache: false,
    success: function(result) {
        $.each(result, function(index, value) {
            eliglist.push(value['eligname']);
        });
    }
});

$( '#eligname' ).autocomplete({
    source:
        function(request, response) {
            var results = $.ui.autocomplete.filter(eliglist, request.term);
            response(results.slice(0, 15));
        },
    minLength: 0,
    scroll: true,
    autoFocus:true
}).focus(function(req,response) {
    $(this).autocomplete("search", "");
  
});

$("#mothername").on("keyup",function(){
    var mdec = $("#mothername").val();
    if(mdec.indexOf('deceased')!=-1){
        $("#motherddate").prop("disabled",false);
    }else{
        $("#motherddate").prop("disabled",true);
    }
})
$("#fathername").on("keyup",function(){
    var mdec = $("#fathername").val();
    if(mdec.indexOf('deceased')!=-1){
        $("#fatherddate").prop("disabled",false);
    }else{
        $("#fatherddate").prop("disabled",true);
    }
})

$(".editj").click(function(){
    $("#app").val($(this).data('id'));
    $("#posdate").val($(this).data('pdate'));
    $("#posto").val($(this).data('tdate'));
    $("#jobid").val($(this).data('jobid'));
})
$(".editdate").click(function(){
    $("#dname").val($(this).data('depname'));
    $("#depid").val($(this).data('id'));
    $("#depfrom").val($(this).data('fdate'));
    $("#depto").val($(this).data('tdate'));
})

$(document).on("click",'.editovertime',function(){
    $("#ovid").val($(this).data('id'));
    $("#ovremarks").val($(this).data('comment'));
    $("#rendered").val($(this).data('rendered'));
})
$(document).on("click",'.pass',function(){
    $("#psid").val($(this).data('id'));
    $("#exundertime").val($(this).data('undertime'));
    $("#fromtime").val($(this).data('timeout'));
    $("#totime").val($(this).data('timereturn'));
    $("#exnumhours").val($(this).data('numhours'));
    $("#type").val($(this).data('type'))
})
$(document).on('change', "[id^=\"leave\"]", function(){
    for(var i=0; i<=k; i++){
        var lvtype = $("#leave"+i).val();
        if(lvtype==4){
            $("#vacleave"+i).val(1);
        }else if(lvtype==3){
            $("#vacleave"+i).val(2);
        }
    }
});

function showUpdate(){
    $(".btn-sm").popover('show');
}
function destroy(){
    $(".btn-sm").popover('destroy');
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

$(document).on("click","#modmoreid",function(){
    var r = $("#modotherid");
    $('<tr>\
   <td><input class="form-control" type="text" placeholder="ID Name" name="othername[]"></td>\
   <td><input class="form-control" type="text" placeholder="Number" name="otherno[]"></td>\
   <td><button type="button" class="btn btn-success btn-xs" id="modmoreid"><i class="fa fa-plus"></i></button> <button type="button" class="btn btn-warning btn-xs " id="lesscol"><i class="fa fa-minus"></i></button></tr>').appendTo(r);
    return false;
});

$(".date").datepicker({
    changeMonth: true,
    changeYear: true,
});

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



function getTotalHours(){
    var type=$("#type").val();
    var undertimeval = $("input[name='undertime']");

    var from = $("#fromtime").val();
    var to = $("#totime").val();

    var date = new Date();
    var month = date.getMonth();
    var day = date.getDate();
    var year = date.getFullYear();
    var fullfrom_time = month + '/'+ day + '/'+year + ' '+from;
    var fullto_time = month + '/'+ day + '/'+year + ' '+to;
    var time1 = new Date(fullfrom_time);
    var time2 = new Date(fullto_time);

    var numhours = Math.abs(time2 - time1) / 36e5;

    $("input[name='numhours']").val(numhours.toFixed(3));
    if(type=='personal')
        $(undertimeval).val(numhours.toFixed(3));
    else
        $(undertimeval).val(0);
}
$(document).ready(function() {
    $('.table1').DataTable();
});

$(".travel").on("click", function(){
    $("#travelremark").val($(this).data('remark'));
    $("#tid").val($(this).data('id'));
});

$("#educstatus").on("change", function(){
    var val = $(this).val();
    var placeholder = '';
    switch (true) {
        case val == 'On Going':
            placeholder = 'Remarks';
            break;
        case val == 'Completed':
            placeholder = 'Year Completed';
            break;
        case val == 'Units Earned':
            placeholder = "Unit Earned";
            break;
        default:
            placeholder;
    }
    document.getElementById('educremarks').placeholder = placeholder;
});

function educationChange(id){
    $("#educstatus_"+id).on("change", function(){
        var val = $(this).val();
        var placeholder = '';
        switch (true) {
            case val == 'On Going':
                placeholder = 'Remarks';
                break;
            case val == 'Completed':
                placeholder = 'Year Completed';
                break;
            case val == 'Units Earned':
                placeholder = "Unit Earned";
                break;
            default:
                placeholder;
        }
        document.getElementById('educremarks_'+id).placeholder = placeholder;
    });
}


$(document).ready(function(){
    $("#education_degree").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });

    $('.btn-loader').removeClass('hide');

    <?php if(isset($load_yos)): ?>
    $.ajax({
        type: 'POST',
        url: '<?=ROOT_URL?>modules/hr/employees/update_years_of_service/0',
        dataType: 'json',
        cache: false,
        data : 'update_emp_yos=true',
        success: function(result) {
            $('.btn-loader').addClass('hide');
        }
    });
    <?php endif; ?>


});

$.fn.view_years_of_service = function(fileno){
    $('#years_of_service_modal').modal('show');
    $('#t_schedules tbody').html('');
    $('.typeA #y_dateofemploy').val('');
    $('.typeA #yos').val('');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url() ?>hr/employees/get_years_of_service_record',
        dataType: 'json',
        cache: false,
        data: "fileno=" + fileno,
        success: function(result) {
            console.log(result);
            $('.typeA #y_dateofemploy').val(result.dateofemploy);
            $('.typeA #yos').val(result.yos);
            $('#yos_empid').val(fileno);
            $('#yos_complete').val(result.yos_complete);
            if(result.type == 1){
                $('.typeB').addClass('hide');
            }else{
                $('.typeB').removeClass('hide');

                var content = '';
                var total = 0;
                for (var i = 0; i < result.getsemsy.length; i++) {
                      content += '<tr>\
                        <td>'+semester(result.getsemsy[i].sem)+'</td>\
                        <td>'+result.getsemsy[i].sy+'</td>\
                        <td>'+result.getsemsy[i].totalunits+'</td>\
                        <td>'+result.getsemsy[i].credits+'</td>\
                        <td></td>\
                        <td></td>\
                      </tr>';
                      total += parseFloat(result.getsemsy[i].credits);
                }
                content += '<tr>\
                        <td colspan="3"><b>Total</b></td>\
                        <td>'+total+'</td>\
                        <td></td>\
                        <td></td>\
                      </tr>';

                $('#t_schedules tbody').append(content);
                $('#initialyos').val(result.ini_sc);
                function semester(val){
                    if(val == 1){
                        return '1st';
                    }else if(val == 2){
                        return '2nd';
                    }else{
                        return 'Summer';
                    }
                }
            }
        }
      });

}

$('#new_modal').scroll(function() {
    $('#ui-datepicker-div').css('display', 'none');
    $('.ui-autocomplete').css('display', 'none');
});
</script>
<script type="text/javascript">
    <?php if($_SESSION['user_login'] == 1): ?>
        $('#privacyModal').modal('show');
    <?php endif; ?>

    $('#privacyModal').on('hidden.bs.modal', function () {
       <?php $_SESSION['user_login'] = 0; ?>
    });
</script>

