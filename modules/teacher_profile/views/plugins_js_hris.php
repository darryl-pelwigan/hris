
<script type="text/javascript">


 	$(document).on("click",".editinfo",function(){
        var id = $(this).attr('id');
        $.ajax({
            url : "<?=ROOT_URL?>editstaff.php",
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
                  url : "<?=ROOT_URL?>hr.json.php",
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
        var bmonth = document.getElementById("month").value;
        var bday = document.getElementById("day").value;
        var byear = document.getElementById("year").value;

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

</script>
<script src="<?=ROOT_URL?>js/typeahead.bundle.js"></script>

<script type="text/javascript" src="<?=ROOT_URL?>modules/assets/js/bootstrap-checkbox.min.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>modules/assets/functions/js/auto_save_hr_edi.js"></script>