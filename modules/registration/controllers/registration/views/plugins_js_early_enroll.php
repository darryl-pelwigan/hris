 
<!-- Jquery UI -->
<script src="<?=base_url()?>assets/jui/jquery-ui.js"></script>

 <script src="<?=base_url()?>assets/plugins/area_code/js/intlTelInput.min.js"></script>

 <!--<script src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>

    <script src="<?=base_url()?>assets/plugins/geolocation/jquery.geocomplete.js"></script>-->

    <script type="text/javascript">
        $(function() {

            // $("#geocomplete").geocomplete();

        });
 </script>
 <script type="text/javascript">
        $(".phone").intlTelInput({
            preferredCountries: ['ph'],
            utilsScript: "<?=base_url()?>assets/plugins/area_code/lib/libphonenumber/build/utils.js"
        });

        $(document).on('keyup', '.phone', function() {
            var phone = this.value;
            var id = $(this).attr('rel');
            if (phone != '' && $.trim(phone)) {
                if ($(this).intlTelInput("isValidNumber")) {
                    $('#tel' + id).html('<b style="color:green"><i class="fa fa-check"></i> Valid</b>');
                } else {
                    $('#tel' + id).html('<b style="color:red"><i class="fa fa-times"></i> Invalid number</b>');
                }
            } else
                $('#tel' + id).html('');
        });
        var els='input[name="lname"] , input[name="fname"] , input[name="mname"] , input[name="nsname"] '; 
         $(document).on('input', els , function() {
           $(this).val(  $(this).val().toUpperCase() );
        });

$(document).ready(function() {
        
            $('#requirements_view').hide();
            refreshCaptcha();
            cstatus2($('#cstatus'));
            
         
         
            $("#dORf").hide();
            $("#spouse").hide();
            $("#forTransferee").hide();

            $("#citizenship").hide();

            $('.local').attr('checked', false);
            $('#sforeign').attr('checked', false);
            $('#sdual').attr('checked', false);

            $('#newlocal').attr('checked', false);
            $('#newforeign').attr('checked', false);

            $('#transfereeforeign').attr('checked', false);
            $('#transfereelocal').attr('checked', false);

            $("#localtransferee").hide();
            $("#localnew").hide();

            $("#foreigntransferee").hide();
            $("#foreignnew").hide();

            $("#foreign").hide();
            $("#local").hide();

            $('#crossenrollee-req').hide();

            $(".local").click(function() {
                $("#citizenship").hide();
                $("#local").show();
                $("#foreign").hide();

                $("#dORf").hide();

                $('.sTypess').prop('checked', false);

                $("#foreigntransferee").hide();
                $("#foreignnew").hide();
            });

            $("#sdual").click(function() {
                $("#citizenship").show();
                $("#local").show();

                $("#dORf").show();

                $("#foreign").hide();

                $('.sTypess').prop('checked', false);

                $("#foreigntransferee").hide();
                $("#foreignnew").hide();
            });


            $("#sforeign").click(function() {
                $("#citizenship").show();
                $("#foreign").show();
                $("#local").hide();

                $("#dORf").show();

                $('.sTypess').prop('checked', false);

                $("#localtransferee").hide();
                $("#localnew").hide();
            });

            $("#newforeign").click(function() {
                $("#foreignnew").show();
                $("#foreigntransferee").hide();
                $("#forTransferee").hide();
                $('#crossenrollee-req').hide();
            });
            $("#transfereeforeign").click(function() {
                $("#foreigntransferee").show();
                $("#forTransferee").show();
                $('#crossenrollee-req').hide();
                $("#foreignnew").hide();
            });

            $("#transfereelocal").click(function() {
                $("#localtransferee").show();
                $("#forTransferee").show();
                $('#crossenrollee-req').hide();
                $("#localnew").hide();
            });

            $("#newlocal").click(function() {
                $("#localtransferee").hide();
                $("#forTransferee").hide();
                $('#crossenrollee-req').hide();
                $("#localnew").show();
            });

            $('.crossenroll').click(function() {
                $("#localtransferee").hide();
                $("#forTransferee").hide();
                $("#localnew").hide();
                $("#foreigntransferee").hide();
                $("#foreignnew").hide();
                $('#crossenrollee-req').show();
            });
            
          
 
            
            
});

function cstatus2(el) {
           if (el.val() == 'Married') {
                $("#spouse").show();
                $('#guardian-spouse').html('<small><a id="sameAs" onclick="sameSpouse()" type="button">Same as spouse info &#8592;</a></small>');
                $('#if-married').html('&emsp;&emsp;&emsp;* Marriage Certificate');
                $('#spouse :input').not('.spouse-notreq').prop('required', true);
            } else {
                $("#spouse").hide();
                $('#guardian-spouse').html('');
                $('#if-married').html('');
                $('#spouse :input').not('.spouse-notreq').prop('required', false);
            }
}



function refreshCaptcha(){
  
       $.ajax({
      type : "POST",
      url  : APP_PATH + "registration/early_enroll/captcha_re",
      data : 'test',
      dataType: "html",
      success: function(data){
        $('#captcha_data').prop('src',data);
      }
    });
}

 function checkType(types) {
            if (types == 'local') {
                $('#nationality').val("Filipino" );
                $('#nationality ').prop('disabled', true);
                $('#nationality').attr('readonly', 'readonly');
            }else if(types == 'foreign') {
                $("#middlename").prop("required",false);
                $('#middlename-asterisk').hide();
                $('#nationality ').prop('disabled', false);
                $('#nationality').removeAttr('readonly');
            } else {
                $('#nationality').val("" );
                $('#nationality ').prop('disabled', false);
                $('#nationality').removeAttr('readonly');
            }
        }

function getBdate() {
            var date = new Date();
            var cyear = date.getFullYear();
            var cmonth = parseInt(date.getMonth()) + 1;
            var year;
            var bmonth = $("#month").val();
            var bday = $("#day").val();
            var byear = $("#year").val();

            var daytoday = getCurDayOfYear();

            var dmonth = parseInt(bmonth) - parseInt(1);
            var countd = new Date(byear, dmonth, bday);
            var daynum = countd.getDOY();
            var m={2:1,3:2,4:3,5:4,6:5,7:6,8:7,9:8,10:9,11:10,12:11,1:12};
            var bdate = m[bmonth] + '/' + bday + '/' + byear;
            document.getElementById('bdate').value = bdate;

            year = cyear - 1;
            total1 = year - byear;
            total2 = (12 - bmonth) + cmonth;
            total3 = total2 / 12;

            var age1 = (total1 + total3);
            var age2 = Math.round(age1 * 100) / 100;
            var age = Math.floor(age2);
            var months1 = age * 12;
            var months = Math.round(months1 * 100) / 100;
            
            
           if(bmonth!=''){
              $("#year").prop('disabled', false);
           }else{
                $("#year").prop('disabled', true);
                  $("#year").val('');
           }
          
            if(bmonth!='' && byear !='' && bday==''){
                $("#day").prop('disabled', false);
                var day_date=new Date(byear+' '+(bmonth));
                var options='<option value="" >Day</option>';
                for(var x=1; x<=day_date.getUTCDate();x++){
                    options=options+'<option value="'+x+'" >'+x+'</option>';
                }
                $("#day").html(options);
                 $('#age').html(age);
                $('#age_input').val(age);
                
           }
           if(bmonth!='' && byear !='' && bday!=''){
                $("#day").html(options);
                 $('#age').html(age);
                $('#age_input').val(age);
           }
            if(bmonth=='' && byear==''){
                $("#day").prop('disabled', true);
                  $("#day").val('');
                   $('#age').html('  _____');
                $('#age_input').val('');
           }
           
         
        }

  Date.prototype.getDOY = function() {
            var onejan = new Date(this.getFullYear(), 0, 1);
            return Math.ceil((this - onejan) / 86400000);
        }
        
        function birthOrder(el){
             var options='<option value="" >Birth Order</option>';
             var forx=parseInt(el.val())+1;
             var birth_order_c={1:'First',2:'Second',3:'Third',4:'Fouth',5:'Fifth',6:'Sixth',7:'Seventh',8:'Eighth',9:'Ninth',10:'Tenth',11:'Eleventh',12:'Twelfth',13:'Thirteenth',14:'Fourteenth',15:'Fifteenth',16:'Sixteenth',17:'Seventeenth',18:'Eighteenth',19:'Nineteenth',20:'Twentieth',21:'Twenty-One'}
                for(var x=1; x<=forx;x++){
                    options=options+'<option value="'+birth_order_c[x]+'" >'+birth_order_c[x]+'</option>';
                }
                $("#birth_order").html(options);
                $("#birth_order").prop('disabled', false);
        }

        function getCurDayOfYear() {
            var now = new Date();
            var start = new Date(now.getFullYear(), 0, 0);
            var diff = now - start;
            var oneDay = 1000 * 60 * 60 * 24;
            var day = Math.floor(diff / oneDay);
            return day;
        }
        
        function set_ucword(){
            
        }
        
        function CheckEmail() {
            var email = $("#emailadd").val();
            var verify = $("#checkemailadd").val();
            if (email != verify) {
                $("#emailadd").addClass("btn-danger");
                $("#checkemailadd").addClass("btn-danger");
            } else {
                $("#emailadd").removeClass("btn-danger");
                $("#checkemailadd").removeClass("btn-danger");
            }
        }
        
        
        $(document).on('click', '#mother-no-phone', function() {
            checkParentDetails('tel', this.checked, 'mother');
        });

        $(document).on('click', '#mother-no-cp', function() {
            checkParentDetails('cp', this.checked, 'mother');
        });

        $(document).on('click', '#father-no-phone', function() {
            checkParentDetails('tel', this.checked, 'father');
        });

        $(document).on('click', '#father-no-cp', function() {
            checkParentDetails('cp', this.checked, 'father');
        });

        function checkParentDetails(type, status, category) {
            /**
             * Mother Contact
             */
            if (category == 'mother') {
                if (type == 'tel') {
                    $('#mothercontact').prop('required', !status);
                    $('#mothercontact').prop('readonly', status);
                    if (status) {
                        $('#mothercontact').val('');
                        $('#mothercontact').trigger('keyup');
                    }
                    if (status)
                        $('#motherasterisk').hide();
                    else
                        $('#motherasterisk').show();
                } else if (type == 'cp') {
                    $('#cpmother').prop('required', !status);
                    $('#cpmother').prop('readonly', status);
                    if (status) {
                        $('#cpmother').val('');
                        $('#cpmother').trigger('keyup');
                    }
                    if (status)
                        $('#cpmotherasterisk').hide();
                    else
                        $('#cpmotherasterisk').show();
                }
            }

            /**
             * Father Contact
             */
            else if (category == 'father') {
                if (type == 'tel') {
                    $('#fathercontact').prop('required', !status);
                    $('#fathercontact').prop('readonly', status);
                    if (status) {
                        $('#fathercontact').val('');
                        $('#fathercontact').trigger('keyup');
                    }
                    if (status)
                        $('#fatherasterisk').hide();
                    else
                        $('#fatherasterisk').show();
                } else if (type == 'cp') {
                    $('#cpfather').prop('required', !status);
                    $('#cpfather').prop('readonly', status);
                    if (status) {
                        $('#cpfather').val('');
                        $('#cpfather').trigger('keyup');
                    }
                    if (status)
                        $('#cpfatherasterisk').hide();
                    else
                        $('#cpfatherasterisk').show();
                }
            }
        }

        function checkMother(obj) {
            var id = obj.id;

            if (id == "mDeceasedYes") {
                document.getElementById('mDeceasedNo').checked = false;
                document.getElementById('mDeceasedYes').checked = true;

                checkParentDetails('tel', true, 'mother');
                checkParentDetails('cp', true, 'mother');

                $('#mother-no-phone').prop('checked', true);
                $('#mother-no-cp').prop('checked', true);

                $('#mother-no-phone').prop('disabled', true);
                $('#mother-no-cp').prop('disabled', true);

                $('#mother-occu').prop('required', false);
                $('#mother-occu-asterisk').hide();

                $('#mother-occu').prop('readonly', true);

            } else {
                document.getElementById('mDeceasedYes').checked = false;
                document.getElementById('mDeceasedNo').checked = true;

                checkParentDetails('tel', false, 'mother');
                checkParentDetails('cp', false, 'mother');

                $('#mother-no-phone').prop('checked', false);
                $('#mother-no-cp').prop('checked', false);

                $('#mother-no-phone').prop('disabled', false);
                $('#mother-no-cp').prop('disabled', false);

                $('#mother-occu').prop('required', true);
                $('#mother-occu-asterisk').show();

                $('#mother-occu').prop('readonly', false);

            }
        }

        function checkFather(obj) {
            //father-occu, father-occu-asterisk
            var id = obj.id;
            if (id == "fDeceasedYes") {
                document.getElementById('fDeceasedNo').checked = false;
                document.getElementById('fDeceasedYes').checked = true;

                checkParentDetails('tel', true, 'father');
                checkParentDetails('cp', true, 'father');

                $('#father-no-phone').prop('checked', true);
                $('#father-no-cp').prop('checked', true);

                $('#father-no-phone').prop('disabled', true);
                $('#father-no-cp').prop('disabled', true);

                $('#father-occu').prop('required', false);
                $('#father-occu-asterisk').hide();

                $('#father-occu').prop('readonly', true);
            } else {
                document.getElementById('fDeceasedYes').checked = false;
                document.getElementById('fDeceasedNo').checked = true;

                checkParentDetails('tel', false, 'father');
                checkParentDetails('cp', false, 'father');

                $('#father-no-phone').prop('checked', false);
                $('#father-no-cp').prop('checked', false);

                $('#father-no-phone').prop('disabled', false);
                $('#father-no-cp').prop('disabled', false);

                // $('#father-occu').prop('disabled', false);
                $('#father-occu').prop('required', true);
                $('#father-occu-asterisk').show();

                $('#father-occu').prop('readonly', false);

            }
        }
        
        function sameSpouse() {
            var arrVal = [];
            var i = 0;
            $('input[name^="spouse"]').each(function() {
                arrVal[i] = $(this).val();
                i++;
            });
            $('#g-name').val(arrVal[0] + ', ' + arrVal[1] + ' ' + arrVal[2]);
            $('#g-rel').val('Spouse');
            $('#g-contact').val($("input[name^='spousecp']").val());
        }
        
        function copyCurrentadd() {
            var i = 0;
            $('.current-address').each(function() {
                if (i != 5)
                    $('.permanent-address').eq(i).val(this.value);
                i++;
            });
        }
        
        function permanentAddress() {
            var vals = [];
            var i = 0;
            $('.permanent-address').each(function() {
                vals[i] = this.value;
                i++;
            });
            $('#permanentAdd').val(vals.join('|'));
        }
        
        function copyBaguioadd() {
            var i = 0;
            $('.current-address').each(function() {
                if (i != 5)
                    $('.guardian-address').eq(i).val(this.value);
                i++;
            });
        }
        
         function gbaguioAddress() {
            var vals = [];
            var i = 0;
            $('.guardian-address').each(function() {
                vals[i] = this.value;
                i++;
            });
            $('#GbaguioAdd').val(vals.join('|'));
        }
        
        function currentAddress() {
            var vals = [];
            var i = 0;
            $('.current-address').each(function() {
                vals[i] = this.value;
                i++;
            });
            $('#baguioAdd').val(vals.join('|'));
        }




$(document).ready(function(){
		$('#regform').submit(function (e){
			
             $.ajax({
                type : "POST",
                url  : APP_PATH + "early_enroll/submit_test",
                data : $(this).serialize(),
                dataType: "html",
                success: function(data){
                    console.log(data);
                }
            });
            
            
			e.preventDefault();
		});
	});
        
</script>