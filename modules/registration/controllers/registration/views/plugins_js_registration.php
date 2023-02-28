<script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrapValidator/js/bootstrapValidator.js">
</script>
<script src="<?=base_url()?>assets/plugins/area_code/js/intlTelInput.min.js"></script>
<script src="<?=base_url()?>assets/functions/js/js_registration_validator.js"></script>
<!--start google geolocation-->
<!--

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAKGLLnA710dQTdX_Qnb4FZsy-XsLBMIHE&libraries=places"></script>
<script src="<?=base_url()?>assets/plugins/geolocation/jquery.geocomplete.js"></script>
<script type="text/javascript">
        $(function() {
          $("#geocomplete").geocomplete();

        });
 </script>
 -->
<!--end google geolocation-->

<!--start form js properties-->
<script type="text/javascript">
    $(".phone").intlTelInput({
        preferredCountries: ['ph'],
        utilsScript: "<?=base_url()?>assets/plugins/area_code/lib/libphonenumber/build/utils.js"
    });

    $(document).ready(function() {
        $.fn.onload = function() {
            $.fn.refreshCaptcha();
            $('#foreign').hide();
            $('#local').hide();
            $('#spouse').hide();
            $('#forTransferee').hide();
            $('#requirements_view').hide();
            $('#localnew').hide();
            $('#localtransferee').hide();
            $('#foreignnew').hide();
            $('#foreigntransferee').hide();
            $('#crossenrollee-req').hide();
        };

        $.fn.refreshCaptcha = function() {

            $.ajax({
                type: "POST",
                url: APP_PATH + "registration/captcha_re",
                data: 'test',
                dataType: "html",
                success: function(data) {
                    $('#captcha_data').prop('src', data);
                }
            });
        }

        $.fn.checkType = function() {
            $('#set_type_first').fadeIn();
            $('#requirements_view').hide();
            var type = $(this).val();
            var typex = '';
            if (type == 'local') {
                typex = '1';
                $('#local').show();
                $('#foreign').hide();
                $('select[name="c_origin"]').val('Philippines');
                document.getElementById('nationality').value = "Filipino";
                $('#nationality').prop('disabled', true);
                $('select[name="citizenship"]').val('Filipino');
                $('select[name="citizenship"]').prop('disabled', true);
            } else if (type == 'foreign') {
                typex = '0';
                $('#local').hide();
                $('#foreign').show();
                $('select[name="c_origin"]').val('');
                $("#middlename").prop("required", false);
                $('#middlename-asterisk').hide();
                $('#nationality').prop('disabled', false);
                $('#nationality').val('');
                $('select[name="citizenship"]').val('');
                $('select[name="citizenship"]').prop('disabled', false);
            } else {
                typex = '1';
                $('#local').show();
                $('#foreign').hide();
                $('select[name="c_origin"]').val('');
                document.getElementById('nationality').value = "";
                $('#nationality').prop('disabled', false);
                $('#nationality').val('');
                $('select[name="citizenship"]').val('');
                $('select[name="citizenship"]').prop('disabled', false);
            }
            $('input:radio[name="studenttype"]').click(function() {
                var studtype = $(this).val();
                if (studtype == '2') {
                    $('#forTransferee').show();
                } else {
                    $('#forTransferee').hide();
                }
                $.fn.studtype(studtype, typex);
                $('#set_type_first').fadeOut();
            });
        };

        $.fn.studtype = function(studtype, typex) {
            $('#requirements_view').show();
            if (studtype == '2' && typex == '1') {
                $('#localnew').hide();
                $('#localtransferee').show();
                $('#foreignnew').hide();
                $('#foreigntransferee').hide();
                $('#crossenrollee-req').hide();
            } else if (studtype == '1' && typex == '1') {
                $('#localnew').show();
                $('#localtransferee').hide();
                $('#foreignnew').hide();
                $('#foreigntransferee').hide();
                $('#crossenrollee-req').hide();
            } else if (studtype == '2' && typex == '0') {
                $('#localnew').hide();
                $('#localtransferee').hide();
                $('#foreignnew').show();
                $('#foreigntransferee').hide();
                $('#crossenrollee-req').hide();
            } else if (studtype == '1' && typex == '0') {
                $('#localnew').hide();
                $('#localtransferee').hide();
                $('#foreignnew').hide();
                $('#foreigntransferee').show();
                $('#crossenrollee-req').hide();
            } else if (studtype == '6') {
                $('#localnew').hide();
                $('#localtransferee').hide();
                $('#foreignnew').hide();
                $('#foreigntransferee').hide();
                $('#crossenrollee-req').show();
            } else {
                $('#localnew').hide();
                $('#localtransferee').hide();
                $('#foreignnew').hide();
                $('#foreigntransferee').hide();
                $('#crossenrollee-req').hide();
            }
        };



        $.fn.getBdate = function() {
            var date = new Date();
            var cyear = date.getFullYear();
            var cmonth = parseInt(date.getMonth()) + 1;
            var year;
            var bmonth = $("#month").val();
            var bday = $("#day").val();
            var byear = $("#year").val();

            var daytoday = $.fn.getCurDayOfYear();

            var dmonth = parseInt(bmonth) - parseInt(1);
            var countd = new Date(byear, dmonth, bday);
            var daynum = countd.getDOY();
            var m = {
                2: 1,
                3: 2,
                4: 3,
                5: 4,
                6: 5,
                7: 6,
                8: 7,
                9: 8,
                10: 9,
                11: 10,
                12: 11,
                1: 12
            };
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

            if (bmonth != '' && bmonth != 'Month') {
                $("#year").prop('disabled', false);
            } else {
                $("#year").prop('disabled', true);
                $("#year").val('');
            }

            if (bmonth != '' && byear != '' && bday == '') {
                $("#day").prop('disabled', false);
                var day_date = new Date(byear + ' ' + (bmonth));
                var options = '<option value="" >Day</option>';
                for (var x = 1; x <= day_date.getUTCDate(); x++) {
                    options = options + '<option value="' + x + '" >' + x + '</option>';
                }
                $("#day").html(options);
                $('#age').html(age);
                $('#age_input').val(age);

            }
            if (bmonth != '' && byear != '' && bday != '') {
                $("#day").html(options);
                $('#age').html(age);
                $('#age_input').val(age);
            }
            if (bmonth == '' && byear == '') {
                $("#day").prop('disabled', true);
                $("#day").val('');
                $('#age').html('  _____');
                $('#age_input').val('');
            }
        };

        Date.prototype.getDOY = function() {
            var onejan = new Date(this.getFullYear(), 0, 1);
            return Math.ceil((this - onejan) / 86400000);
        }

        $.fn.birthOrder = function(el) {
            var options = '<option value="" >Birth Order</option>';
            var forx = parseInt(el.val()) + 1;
            var birth_order_c = {
                1: 'First',
                2: 'Second',
                3: 'Third',
                4: 'Fouth',
                5: 'Fifth',
                6: 'Sixth',
                7: 'Seventh',
                8: 'Eighth',
                9: 'Ninth',
                10: 'Tenth',
                11: 'Eleventh',
                12: 'Twelfth',
                13: 'Thirteenth',
                14: 'Fourteenth',
                15: 'Fifteenth',
                16: 'Sixteenth',
                17: 'Seventeenth',
                18: 'Eighteenth',
                19: 'Nineteenth',
                20: 'Twentieth',
                21: 'Twenty-One'
            }
            for (var x = 1; x <= forx; x++) {
                options = options + '<option value="' + birth_order_c[x] + '" >' + birth_order_c[x] + '</option>';
            }
            $("#birth_order").html(options);
            $("#birth_order").prop('disabled', false);
        }

        $.fn.getCurDayOfYear = function() {
            var now = new Date();
            var start = new Date(now.getFullYear(), 0, 0);
            var diff = now - start;
            var oneDay = 1000 * 60 * 60 * 24;
            var day = Math.floor(diff / oneDay);
            return day;
        };

        /*end bdate */

        /*start birth order*/
        $.fn.birthOrder = function(el) {
            var el = $(this);
            var options = '<option value="" >First</option>';
            if (el.val() != '0') {
                options = '<option value="" >Birth Order</option>';
                var forx = parseInt(el.val()) + 1;
                var birth_order_c = {
                    1: 'First',
                    2: 'Second',
                    3: 'Third',
                    4: 'Fouth',
                    5: 'Fifth',
                    6: 'Sixth',
                    7: 'Seventh',
                    8: 'Eighth',
                    9: 'Ninth',
                    10: 'Tenth',
                    11: 'Eleventh',
                    12: 'Twelfth',
                    13: 'Thirteenth',
                    14: 'Fourteenth',
                    15: 'Fifteenth',
                    16: 'Sixteenth',
                    17: 'Seventeenth',
                    18: 'Eighteenth',
                    19: 'Nineteenth',
                    20: 'Twentieth',
                    21: 'Twenty-One'
                }
                for (var x = 1; x <= forx; x++) {
                    options = options + '<option value="' + birth_order_c[x] + '" >' + birth_order_c[x] + '</option>';
                }
                $("#birth_order").prop('disabled', false);
            }
            $("#birth_order").html(options);

        };

        $(document).on('keyup', '.permanent-address', function() {
            $.fn.permanentAddress();
        });

        $(document).on('keyup', '.current-address', function() {
            $.fn.currentAddress();
        });

        $(document).on('keyup', '.guardian-address', function() {
            $.fn.gbaguioAddress();
        });

        $.fn.permanentAddress = function() {
            var vals = [];
            var i = 0;
            $('.permanent-address').each(function() {
                vals[i] = this.value;
                i++;
            });
            $('#permanentAdd').val(vals.join('|'));
        }

        $.fn.currentAddress = function() {
            var vals = [];
            var i = 0;
            $('.current-address').each(function() {
                vals[i] = this.value;
                i++;
            });
            $('#baguioAdd').val(vals.join('|'));
        }

        $.fn.gbaguioAddress = function() {
            var vals = [];
            var i = 0;
            $('.guardian-address').each(function() {
                vals[i] = this.value;
                i++;
            });
            $('#GbaguioAdd').val(vals.join('|'));
        }

        $.fn.copyPermanentadd = function() {
            var i = 0;
            $('.permanent-address').each(function() {
                if (i != 5)
                    $('.current-address').eq(i).val(this.value);
                i++;
            });
        }

        $.fn.copyCurrentadd = function() {
            var i = 0;
            var bootstrapValidator = $('#regform').data('bootstrapValidator');
            $('.current-address').each(function() {
                if (i != 6)
                    $('.permanent-address').eq(i).val(this.value);
                i++;
            });
            bootstrapValidator.updateStatus("p_add_sn", 'NOT_VALIDATED', null)
                .updateStatus("p_add_db", 'NOT_VALIDATED', null)
                .updateStatus("p_add_cm", 'NOT_VALIDATED', null)
                .updateStatus("p_add_pr", 'NOT_VALIDATED', null)
                .validateField("p_add_sn")
                .validateField("p_add_db")
                .validateField("p_add_cm")
                .validateField("p_add_pr")
                .validateField("p_add_country");
        };

        $.fn.copyBaguioadd = function() {
            var i = 0;
            $('.current-address').each(function() {
                if (i != 5)
                    $('.guardian-address').eq(i).val(this.value);
                i++;
            });
        };

        $.fn.checkEmail = function() {
            var emailadd = $('#emailadd').val();
            var checkemailadd = $('#checkemailadd').val();
            if (emailadd == checkemailadd) {
                // $.ajax({
                //     url: 'email_check.php',
                //     type: 'post',
                //     async: false,
                //     dataType: 'json',
                //     data: 'email=' + email + '&unique=true',
                //     success: function(data) {
                //         if (data.success) {
                //             $('#alert_email').html('<i style="color:red;">-- Email Already used / registered</i>');
                //         } else {
                //             $('#alert_email').html('');
                //         }
                //     }
                // });
            }
        };


        $(document).on('click', '#mother-no-phone', function() {
            $.fn.checkParentDetails('tel', this.checked, 'mother');
        });

        $(document).on('click', '#mother-no-cp', function() {
            $.fn.checkParentDetails('cp', this.checked, 'mother');
        });

        $(document).on('click', '#father-no-phone', function() {
            $.fn.checkParentDetails('tel', this.checked, 'father');
        });

        $(document).on('click', '#father-no-cp', function() {
            $.fn.checkParentDetails('cp', this.checked, 'father');
        });

        $.fn.checkParentDetails = function(type, status, category) {
            /**
             * Mother Contact
             */
            var bootstrapValidator = $('#regform').data('bootstrapValidator');

            if (category == 'mother') {
                if (type == 'tel') {

                    if (status) {
                        $('#mothercontact').val('');
                        $('#mothercontact').trigger('keyup');
                    }
                    if (status) {
                        $('#motherasterisk').hide();
                        bootstrapValidator.updateStatus("famBG_mom_tel", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_tel', false).validateField('famBG_mom_tel');
                    } else {
                        $('#motherasterisk').show();
                        bootstrapValidator.updateStatus("famBG_mom_tel", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_tel', true).validateField('famBG_mom_tel');
                    }
                    $('#mothercontact').prop('required', !status);
                    $('#mothercontact').prop('disabled', status);

                } else if (type == 'cp') {

                    if (status) {
                        $('#cpmother').val('');
                        $('#cpmother').trigger('keyup');
                    }
                    if (status) {
                        $('#cpmotherasterisk').hide();
                        bootstrapValidator.updateStatus("famBG_mom_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_cphone', false).validateField('famBG_mom_cphone');
                    } else {
                        $('#cpmotherasterisk').show();
                        bootstrapValidator.updateStatus("famBG_mom_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_cphone', true).validateField('famBG_mom_cphone');
                    }
                    $('#cpmother').prop('required', !status);
                    $('#cpmother').prop('disabled', status);
                }

            }
            /**
             * Father Contact HOY GONG GONG
             */
            else if (category == 'father') {
                if (type == 'tel') {
                    if (status) {
                        $('#fathercontact').val('');
                        $('#fathercontact').trigger('keyup');
                    }
                    if (status) {
                        $('#fatherasterisk').hide();
                        bootstrapValidator.updateStatus("famBG_dad_tel", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_tel', false).validateField('famBG_dad_tel');
                    } else {
                        $('#fatherasterisk').show();
                        bootstrapValidator.updateStatus("famBG_dad_tel", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_tel', true).validateField('famBG_dad_tel');
                    }
                    $('#fathercontact').prop('required', !status);
                    $('#fathercontact').prop('disabled', status);
                } else if (type == 'cp') {
                    if (status) {
                        $('#cpfather').val('');
                        $('#cpfather').trigger('keyup');
                    }
                    if (status) {
                        $('#cpfatherasterisk').hide();
                        bootstrapValidator.updateStatus("famBG_dad_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_cphone', false).validateField('famBG_dad_cphone');
                    } else {
                        $('#cpfatherasterisk').show();
                        bootstrapValidator.updateStatus("famBG_dad_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_cphone', true).validateField('famBG_dad_cphone');
                    }
                    $('#cpfather').prop('required', !status);
                    $('#cpfather').prop('disabled', status);
                }

            }
        }

        $.fn.checkMother = function(obj) {
            var id = obj.id;
            var bootstrapValidator = $('#regform').data('bootstrapValidator');
            if (id == "mDeceasedYes") {
                bootstrapValidator.updateStatus("famBG_mom_occupation", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_occupation', false);
                bootstrapValidator.updateStatus("famBG_mom_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_cphone', false);
                document.getElementById('mDeceasedNo').checked = false;
                document.getElementById('mDeceasedYes').checked = true;

                $.fn.checkParentDetails('tel', true, 'mother');
                $.fn.checkParentDetails('cp', true, 'mother');

                $('#mother-no-phone').prop('checked', true);
                $('#mother-no-cp').prop('checked', true);

                $('#mother-no-phone').prop('disabled', true);
                $('#mother-no-cp').prop('disabled', true);

                $('#mother-occu').prop('required', false);
                $('#mother-occu-asterisk').hide();

                $('#mother-occu').prop('disabled', true);

            } else {
                bootstrapValidator.updateStatus("famBG_mom_occupation", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_occupation', true).validateField('famBG_mom_occupation');
                bootstrapValidator.updateStatus("famBG_mom_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_mom_cphone', true).validateField('famBG_mom_cphone');
                document.getElementById('mDeceasedYes').checked = false;
                document.getElementById('mDeceasedNo').checked = true;

                $.fn.checkParentDetails('tel', false, 'mother');
                $.fn.checkParentDetails('cp', false, 'mother');

                $('#mother-no-phone').prop('checked', false);
                $('#mother-no-cp').prop('checked', false);

                $('#mother-no-phone').prop('disabled', false);
                $('#mother-no-cp').prop('disabled', false);

                $('#mother-occu').prop('required', true);
                $('#mother-occu-asterisk').show();

                $('#mother-occu').prop('disabled', false);

            }
        }

        $.fn.checkFather = function(obj) {
            //father-occu, father-occu-asterisk
            var id = obj.id;
            var bootstrapValidator = $('#regform').data('bootstrapValidator');
            if (id == "fDeceasedYes") {
                bootstrapValidator.updateStatus("famBG_dad_occupation", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_occupation', false);
                bootstrapValidator.updateStatus("famBG_dad_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_cphone', false);
                document.getElementById('fDeceasedNo').checked = false;
                document.getElementById('fDeceasedYes').checked = true;

                $.fn.checkParentDetails('tel', true, 'father');
                $.fn.checkParentDetails('cp', true, 'father');

                $('#father-no-phone').prop('checked', true);
                $('#father-no-cp').prop('checked', true);

                $('#father-no-phone').prop('disabled', true);
                $('#father-no-cp').prop('disabled', true);

                $('#father-occu').prop('required', false);
                $('#father-occu-asterisk').hide();

                $('#father-occu').prop('disabled', true);
            } else {
                bootstrapValidator.updateStatus("famBG_dad_occupation", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_occupation', true).validateField('famBG_dad_occupation');
                bootstrapValidator.updateStatus("famBG_dad_cphone", 'NOT_VALIDATED', null).enableFieldValidators('famBG_dad_cphone', true).validateField('famBG_dad_cphone');
                document.getElementById('fDeceasedYes').checked = false;
                document.getElementById('fDeceasedNo').checked = true;

                $.fn.checkParentDetails('tel', false, 'father');
                $.fn.checkParentDetails('cp', false, 'father');

                $('#father-no-phone').prop('checked', false);
                $('#father-no-cp').prop('checked', false);

                $('#father-no-phone').prop('disabled', false);
                $('#father-no-cp').prop('disabled', false);

                // $('#father-occu').prop('disabled', false);
                $('#father-occu').prop('required', true);
                $('#father-occu-asterisk').show();

                $('#father-occu').prop('disabled', false);

            }
        };

         $(document).on('click', '#g-no-tel', function() {
            var checkstat = this.checked;
            var bootstrapValidator = $('#regform').data('bootstrapValidator');
            if (checkstat) {
                 bootstrapValidator.updateStatus("famBG_gurdian_tel", 'NOT_VALIDATED', null).enableFieldValidators('famBG_gurdian_tel', false).validateField('famBG_gurdian_tel');
                $('#g-tel-asterisk').html('');
                $('#g-contact').val('');
                $('#g-contact').prop('required', false);
                $('#g-contact').prop('readonly', true);
                $('#g-contact').trigger('keyup');
            } else {
                bootstrapValidator.updateStatus("famBG_gurdian_tel", 'NOT_VALIDATED', null).enableFieldValidators('famBG_gurdian_tel', true).validateField('famBG_gurdian_tel');
                $('#g-tel-asterisk').html('*');
                $('#g-contact').prop('required', true);
                $('#g-contact').prop('readonly', false);
            }
        });

         $.fn.cstatus = function(){
           
          };
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $.fn.onload();
    });
</script>
<!--end form js properties-->