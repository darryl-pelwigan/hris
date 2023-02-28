<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="frontpage">Pines City Colleges</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="http://pcc.edu.ph/" target="_blank">Website</a></li>
                <li><a href="onlineservices">Online Services</a></li>
                <li><a href="login">Portal</a></li>
                <li><a href="library">Library</a></li>
                <li><a href="registration">Register</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</div>
<br />
<div class="container">
    <!-- 
            action="registersuccess"
            action="viewregistration.php"
        -->
    <form name="regform" id="regform" method="post" class="form-horizontal">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1><b>Online Registration</b></h1>
                    <h4>For : <?=($sem_sy['sem_sy_e']['csemword'])?> <?=($sem_sy['sem_sy_e']['sy2'])?></h4>

                </div>
                <div class="panel-body">



                    <div class="alert alert-info">
                        <u style="color: #770000;font-family: monospace;">Please read first the instructions before filling out the form</u>
                        <br />
                        <ol id="instructions">
                            <?php
                                $instructions = array(
                                    'An active email address is required. If you do not have an email address, please click <a href="https://accounts.google.com/SignUp?service=mail&continue=http%3A%2F%2Fmail.google.com%2Fmail%2F%3Fpc%3Dtopnav-about-en" target="_blank">this link to create your account</a>.',
                                    'Fill-out the online registration form.',
                                    'Make sure all information are correct before you submit your application.',
                                    'Print the Registration Form (Optional).',
                                    'Login to your email account and check if you have received a confirmation message.',
                                    'Open the link in the confirmation message to complete your registration.',
                                    'Login to your portal account with the username and password provided.',
                                    'Change your username and password.',
                                    'Upload digital copies of your documents (original copies are still required before you can proceed with admission). Make sure your uploaded document(s) have a seal of certified true copy.',
                                    'Enroll your subjects.',
                                    'Present the registration form together with your original documents (Optional) to the SAGSO Office.'
                                );
                                echo '<li>' . implode('</li><li>', $instructions) . '</li>';
                            ?>
                        </ol>
                        <br />
                        <!-- TYPE : <strong>N/A</strong>  ( "IF NOT APPLICABLE" ) -->
                    </div>

                    <hr />
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <td align='right'><b>* Select Type</b></td>
                                <td><label><input type="radio" name="stype" class="local" value="local"  onclick="$(this).checkType();" required /> Filipino</label>
                                    <td><label><input type="radio" name="stype" id="sforeign" value="foreign" onclick="$(this).checkType();" required /> Foreign</label>
                                        <td><label><input type="radio" name="stype" id="sdual" value="dual" onclick="$(this).checkType();" required /> Dual Citizenship</label> <span id="radio_error" style="color:red;"></span></td>
                            </tr>
                            <tr>
                                <td class="bordernone-top"></td>
                                <td colspan="10" class="bordernone-top"><span id="error_type" style="color:red;"></span></td>
                            </tr>
                            <tr id="foreign" class="bordernone-top">
                                <td class="bordernone-top"><b></b>
                                    <td class="bordernone-top"><label><input type="radio" class="sTypess" name="studenttype" id="newforeign" value="1"> Freshmen</label>
                                        <td class="bordernone-top"><label><input type="radio" name="studenttype" class="sTypess" id="transfereeforeign" value="2"> Transferee</label>
                                            <td class="bordernone-top"><label><input type="radio" name="studenttype" class="sTypess crossenroll" value="6"> Cross Enrollee</label></td>
                            </tr>
                            <tr id="local">
                                <td class="bordernone-top"><b></b>
                                    <td class="bordernone-top"><label><input type="radio" class="sTypess" name="studenttype" id="newlocal" value="1"> Freshmen</label>
                                        <td class="bordernone-top"><label><input type="radio" name="studenttype" class="sTypess" id="transfereelocal" value="2"> Transferee</label>
                                            <td class="bordernone-top"><label><input type="radio" name="studenttype" class="sTypess crossenroll" value="6"> Cross Enrollee</label></td>
                            </tr>
                        </table>
                    </div>
                    <div class="alert alert-warning" id="set_type_first">
                        Please Select type!
                    </div>
                    <hr />
                    <h3 class="panel-title"><u><b>Personal Information</b></u></h3>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Last Name</label>
                        <div class="col-sm-9">
                            <input class="form-control " type="text" name="lname" value="<?=set_value('lname')?>" required />
                            <?=form_error('lname', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* First Name</label>
                        <div class="col-sm-9">
                            <input class="form-control " type="text" name="fname" value="<?=set_value('fname')?>" pattern="[A-z\s]+" required />
                            <?=form_error('fname', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span id="middlename-asterisk">*</span> Middle Name</label>
                        <div class="col-sm-9">
                            <input class="form-control " id="middlename" type="text" name="mname" value="<?=set_value('mname')?>" pattern=".{2,}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name Suffix</label>
                        <div class="col-sm-9">
                            <input class="form-control only-text" type="text" name="nsname" value="<?=set_value('nsname')?>" placeholder="ex.(JR, SR, III)" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Civil Status</label>
                        <div class="col-sm-9">
                            <select id="cstatus" onchange="javascript:$(this).cstatus();" class="form-control" name="cstatus" required />
                            <option></option>
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widow(er)</option>
                            <option>Legally Separated</option>
                            </select>
                            <?=form_error('cstatus', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group" id="dORf">
                        <label class="col-sm-2 control-label">Country of Origin</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="c_origin">
                                    <option></option>
                                    <?php
                                        sort($the_origin);
                                                for($w=0;$w<count($the_origin);$w++){
                                                    echo '<option>'.$the_origin[$w].'</option>';
                                                }
                                    ?>
                                    </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Nationality</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="nationality" id="nationality" required>
                                   <option></option>
                                  <?php
                                        sort($the_race);
                                                for($w=0;$w<count($the_race);$w++){
                                                    echo '<option>'.$the_race[$w].'</option>';
                                                }
                                    ?>
                                </select>
                            <?=form_error('reg[6]', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group" id="citizenship">
                        <label class="col-sm-2 control-label">Citizenship</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="citizenship">
                                   <option></option>
                                    <?php
                                    sort($the_race);
                                            for($w=0;$w<count($the_race);$w++)
                                                echo '<option>'.$the_race[$w].'</option>';
                                        ?>
                                 </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Religion</label>
                        <div class="col-sm-9" id="rel_div">
                            <select class="form-control" name="religion" id="rel" required>
                                    <option></option>
                                    <?php
                                            for($r=0;$r<count($religion);$r++)
                                                echo '<option>'.$religion[$r]->religion.'</option>';
                                        ?>
                                </select>
                            <?=form_error('religion', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Place of Birth</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="geocomplete" value="<?=set_value('po_birth')?>" name="po_birth" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Birth Date</label>
                        <div class="col-sm-9">
                            <div class="col-sm-4">
                                <label class="sr-only">Month</label>
                                <select class="form-control bdates" name="month" id="month" oninput="$(this).getBdate()" required>
                                       <option value="">Month</option>
                                       <option value='2'>January</option>
                                       <option value='3'>February</option>
                                       <option value='4'>March</option>
                                       <option value='5'>April</option>
                                       <option value='6'>May</option>
                                       <option value='7'>June</option>
                                       <option value='8'>July</option>
                                       <option value='9'>August</option>
                                       <option value='10'>September</option>
                                       <option value='11'>October</option>
                                       <option value='12'>November</option>  
                                        <option value='1'>December</option>     
                                      </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="sr-only">Year</label>
                                <select disabled="disabled" class="form-control bdates" name="year" id="year" oninput="$(this).getBdate()" required>
                                        <option value="">Year</option>
                                        <?php 
                                            for($i=date('Y')-13;$i>date('Y')-80;$i--){
                                                echo "<option>".$i."</option>";
                                            }
                                        ?>
                                        </select>
                                <input class="check_exist" value="<?=set_value('bdate','01/01/1989')?>" type="hidden" name="bdate" id="bdate" />
                                <!-- birthdate joined string -->
                            </div>

                            <div class="col-sm-4">
                                <label class="sr-only">Day</label>
                                <select disabled="disabled" class="form-control bdates" name="day" id="day" oninput="$(this).getBdate()" required>
                                      <option value="">Day</option>
                                    </select>
                            </div>

                            <span id="error_bday" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Sex</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="sex" required>
                                    <option value="">Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            <?=form_error('sex', '<div class="alert-danger">', '</div>')?>
                        </div>
                        <div class="col-sm-2 control-label">
                            <table>
                                <tr>
                                    <td><b>Age:</b>&emsp;</td>
                                    <td id="age"><u>&emsp;&emsp;&emsp;</u></td>
                                </tr>
                            </table>
                            <input class="form-control" id="age_input" value="<?=set_value('age')?>" type="hidden" name="age" id="age" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Height</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="height">
                                <option value="">Height</option>
                                <?php
                                    for ($i=100; $i <= $i ; $i++)
                                    { 
                                        echo '<option>'.$i.' cm</option>';
                                        if ($i == 609)
                                            break;
                                    }
                                ?>                         
                                </select>

                        </div>
                        <label class="col-sm-2 control-label">Weight</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="weight">
                                <option value="">Weight</option>
                                <?php
                                    for ($i=25; $i <= $i ; $i++)
                                    {
                                        echo '<option>'.$i.' kg</option>';
                                        if ($i == 500)
                                            break;
                                    }
                                ?>
                                </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">No. of Siblings 
                            </label>
                        <div class="col-sm-3">
                            <select class="form-control" name="famBG_1" oninput="$(this).birthOrder();">
                                     <?php
                                        for ($i=0; $i <= $i; $i++)
                                        {
                                            echo '<option>'.$i.'</option>';
                                            if ($i == 20)
                                                break;
                                        }
                                    ?>
                                 </select>
                        </div>
                        <label class="col-sm-2 control-label">Birth Order
                            </label>
                        <div class="col-sm-3">
                            <select class="form-control" id="birth_order" name="famBG_2" disabled="disabled">
                                </select>
                        </div>
                    </div>
                    <input type="hidden" id="wlaLng" />
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2" id="contacts-panel">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Your contact details</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Telephone No</label>
                        <div class="col-sm-6">
                            <input class="form-control phone" rel="1" name="phone" class="phone" id="phone" type="tel" />
                        </div>
                        <div class="col-sm-3" style="padding-top:8px;" id="tel1"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Cellphone No</label>
                        <div class="col-sm-6">
                            <input class="form-control phone" rel="2" value="<?=set_value('cphone')?>" name="cphone" class="phone" type="tel" required />
                            <?=form_error('cphone', '<div class="alert-danger">', '</div>')?>
                        </div>
                        <div class="col-sm-3" style="padding-top:8px;" id="tel2"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Email Address</label>
                        <div class="col-sm-9">
                            <input id="emailadd" name="emailadd" class="form-control" value="<?=set_value('emailadd')?>" type="email" placeholder="ex.( mail@gmail.com, mail@yahoo.com )" autocomplete="off" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Verify Email Address</label>
                        <div class="col-sm-9">
                            <input id="c" name="checkemailadd" class="form-control" value="<?=set_value('checkemailadd')?>" onblur="$(this).checkEmail();" type="email" placeholder="ex.( mail@gmail.com, mail@yahoo.com )" autocomplete="off" required />
                            <span id="alert_email"></span>
                            <?=form_error('checkemailadd', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Your address</h3>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <legend id="cAddress">Current Address</legend>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* House No.</label>
                            <div class="col-sm-9">
                                <input class="form-control current-address" value="<?=set_value('c_add_hn')?>" name="c_add_hn" type="text" required />
                                <?=form_error('c_add_hn', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Street Name</label>
                            <div class="col-sm-9">
                                <input class="form-control current-address" value="<?=set_value('c_add_sn')?>" name="c_add_sn" type="text" required/>
                                <?=form_error('c_add_sn', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* District/Barangay</label>
                            <div class="col-sm-9">
                                <input class="form-control current-address" value="<?=set_value('c_add_b')?>" name="c_add_b" type="text" required/>
                                <?=form_error('c_add_b', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* City/Municipality</label>
                            <div class="col-sm-9">
                                <input class="form-control current-address" value="<?=set_value('c_add_m')?>" name="c_add_m" type="text" required />
                                <?=form_error('c_add_m', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Province</label>
                            <div class="col-sm-9">
                                <input class="form-control current-address" value="<?=set_value('c_add_p')?>" name="c_add_p" type="text" required>
                                <?=form_error('c_add_p', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Country</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control  current-address" name="c_add_country" value="Philippines" readonly required />
                                <input type="hidden" id="baguioAdd" name="baguioAdd">
                                <?=form_error('baguioAdd', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset id="YourAddress">
                        <legend id="pAddress">Permanent Address <small><a id="sameAs" type="button" onclick="$(this).copyCurrentadd();$(this).currentAddress();">Same as Current Address &#8592;</a></small></legend>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">House No.</label>
                            <div class="col-sm-9">
                                <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_p')?>" name="p_add_p" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Street Name/Sitio</label>
                            <div class="col-sm-9">
                                <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_sn')?>" name="p_add_sn" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* District/Barangay</label>
                            <div class="col-sm-9">
                                <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_db')?>" name="p_add_db" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* City/Municipality</label>
                            <div class="col-sm-9">
                                <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_cm')?>" name="p_add_cm" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Province</label>
                            <div class="col-sm-9">
                                <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_pr')?>" name="p_add_pr" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Country</label>
                            <div class="col-sm-9">
                                <span id="error_country" style="color:red;"></span>
                                <select name="p_add_country" class="form-control permanent-address selectpicker" id="Pcountry" data-live-search="true" onChange="permanentAddress()">
                                        <option></option>
                                         <?php
                                        sort($the_origin);
                                                for($w=0;$w<count($the_origin);$w++){
                                                    echo '<option>'.$the_origin[$w].'</option>';
                                                }
                                    ?>
                                    </select>
                            </div>
                            <input type="hidden" id="permanentAdd" name="permanentAdd">
                            <?=form_error('permanentAdd', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2" id="spouse">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Spouse Details</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Last Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="" type="text" name="spouse_lname" value="<?=set_value('spouse_lname')?>" pattern="[A-z\s]+" required />
                            <?=form_error('spouse_lname', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* First Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="spouse_flname" value="<?=set_value('spouse_flname')?>" pattern="[A-z\s]+" required />
                            <?=form_error('spouse_flname', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Middle Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="spouse_mlname" value="<?=set_value('spouse_mlname')?>" pattern="[A-z\s]+" required />
                            <?=form_error('spouse_mlname', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name Suffix</label>
                        <div class="col-sm-9">
                            <input style="text-transform:none;" class="form-control spouse-notreq" type="text" name="spouse_nsname" value="<?=set_value('spouse_nsname')?>" placeholder="ex.(JR, SR, III)" />
                        </div>
                    </div>
                    <fieldset>
                        <legend>Contact No</legend>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Telephone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone spouse-notreq" rel="3" name="spousetel" value="<?=set_value('spousetel')?>" />
                            </div>
                            <div class="col-sm-3" style="padding-top:8px;" id="tel3"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Cellphone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone" rel="4" name="spousecp" value="<?=set_value('spousecp')?>" required />
                                <?=form_error('spousecp', '<div class="alert-danger">', '</div>')?>
                            </div>
                            <div class="col-sm-3" style="padding-top:8px;" id="tel4"></div>
                        </div>
                    </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Parent's Information</h3>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <legend>Mother's Information</legend>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Maiden Name</label>
                            <div class="col-sm-9">
                                <input class="form-control check_exist" type="text" name="famBG_mom" value="<?=set_value('famBG_mom')?>" placeholder="Mother's Maiden Name" required />
                                <?=form_error('famBG_mom', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Deceased:</label>
                            <div class="col-sm-9">
                                <label><input onclick="$.fn.checkMother(this)" id="mDeceasedYes" type="checkbox" name="famBG[]" value='yes' > Yes</label>&emsp;
                                <label><input onclick="$.fn.checkMother(this)" id="mDeceasedNo" type="checkbox" name='famBG[]' value='no' checked> No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="mother-occu-asterisk">*</span> Occupation</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="famBG_mom_occupation" value="<?=set_value('famBG_mom_occupation')?>" placeholder="Mother's Occupation" id="mother-occu" required />
                                <?=form_error('famBG_mom_occupation', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="motherasterisk">*</span> Telephone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone" rel="5" value="" id="mothercontact" value="<?=set_value('famBG_mom_tel')?>" name="famBG_mom_tel" required />
                                <span id="tel5"></span>
                            </div>
                            <div class="col-md-3">
                                <p></p>
                                <label><input type="checkbox" id="mother-no-phone"> N/A</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="cpmotherasterisk">*</span> Cellphone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone" rel="6" id="cpmother" value="<?=set_value('famBG_mom_cphone')?>" name="famBG_mom_cphone" required />
                                <span id="tel6"></span>
                            </div>
                            <div class="col-md-3">
                                <p></p>
                                <label><input type="checkbox" id="mother-no-cp"> N/A</label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Father's Information</legend>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="famBG_dad" value="<?=set_value('famBG_dad')?>" placeholder="Father's Name" required />
                                <?=form_error('famBG_dad', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Deceased:</label>
                            <div class="col-sm-9">
                                <label><input onclick="$.fn.checkFather(this)" id="fDeceasedYes" type="checkbox" name="famBG[]" value='yes'> Yes</label>&emsp;
                                <label><input onclick="$.fn.checkFather(this)" id="fDeceasedNo" type="checkbox" name='famBG[]' value='no' checked> No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="father-occu-asterisk">*</span> Occupation</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="famBG_dad_occupation" value="<?=set_value('famBG_dad_occupation')?>" placeholder="Father's Occupation" id="father-occu" required />
                                <?=form_error('famBG_dad_occupation', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="fatherasterisk">*</span> Telephone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone" rel="7" value="<?=set_value('famBG_dad_tel')?>" id="fathercontact" name="famBG_dad_tel" required />
                                <span id="tel7"></span>
                            </div>
                            <div class="col-md-3">
                                <p></p>
                                <label><input type="checkbox" id="father-no-phone"> N/A</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="cpfatherasterisk">*</span> Cellphone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone" rel="8" id="cpfather" value="<?=set_value('famBG_dad_cphone')?>" name="famBG_dad_cphone" required />
                                <span id="tel8"></span>
                            </div>
                            <div class="col-md-3">
                                <p></p>
                                <label><input type="checkbox" id="father-no-cp"> N/A</label>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Guardian Information</h3>
                </div>
                <div class="panel-body">
                    <div style="text-align:right;" id="guardian-spouse"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Guardian Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" value="<?=set_value('famBG_guardian')?>" name="famBG_guardian" id="g-name" required />
                            <?=form_error('famBG_guardian', '<div class="alert-danger">', '</div>')?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Relationship</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="famBG_gurdian_rel" id="g-rel" required>
                                    <option></option>
                                    <option>Mother</option><option>Father</option><option>Sister</option><option>Brother</option><option>Spouse</option><option>Grandmother</option><option>Grandfather</option><option>Aunt</option><option>Uncle</option><option>Cousin</option><option>Sister-in-law</option><option>Brother-in-law</option>                                
                                    </select>

                        </div>
                    </div>

                    <fieldset>
                        <legend>Address <small><a id="sameAs" type="button" onclick="$(this).copyBaguioadd();$(this).gbaguioAddress();">Same as Current Address &#8592;</a></small></legend>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">House No.</label>
                            <div class="col-sm-7">
                                <input class="form-control guardian-address" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Street Name</label>
                            <div class="col-sm-7">
                                <input class="form-control guardian-address" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">District/Barangay</label>
                            <div class="col-sm-7">
                                <input class="form-control guardian-address" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">* City/Municipality</label>
                            <div class="col-sm-7">
                                <input class="form-control guardian-address" type="text" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Province</label>
                            <div class="col-sm-7">
                                <input class="form-control guardian-address" id="" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">* Country</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control guardian-address" id="GBcountry" value="Philippines" readonly required>
                                <input type="hidden" id="GbaguioAdd" name="famBG[]">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span id="g-tel-asterisk">*</span> Tel No.</label>
                        <div class="col-sm-6">
                            <input class="form-control phone" value="<?=set_value('famBG_gurdian_tel')?>" type="text" rel="9" name="famBG_gurdian_tel" id="g-contact" required />
                        </div>
                        <div class="col-sm-3" style="padding-top:8px;"><label><input type="checkbox" id="g-no-tel" /> N/A</label></div>
                        <br style="clear:both;" />
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-6" style="padding-top:8px;" id="tel9"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">* Cellphone No.</label>
                        <div class="col-sm-6">
                            <input class="form-control phone" type="text" rel="10" value="<?=set_value('famBG_gurdian_cphone')?>" name="famBG_gurdian_cphone" required />
                            <?=form_error('famBG_gurdian_cphone', '<div class="alert-danger">', '</div>')?>
                        </div>
                        <br style="clear:both;" />
                        <div class="col-sm-2"></div>
                        <div class="col-sm-6" style="padding-top:8px;" id="tel10"></div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Educational Background</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>* Complete Name of School
                                <th>* Address of School
                                    <th>* Year Graduated
                                        <th>Honors(if any)</th>
                        </tr>
                        <tr>
                            <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="Elementary" name="elem_educ" required><?=set_value('elem_educ')?></textarea></div>
                                <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="Location" name="elem_educ_loc" required><?=set_value('elem_educ_loc')?></textarea></div>
                                    <td><div class="form-group form-remove-margin">
                                        <select class="form-control" name="educ[]">
                                                <?php
                                                        for ($i=(date('Y')-5); $i>date('Y')-80; $i--)
                                                        {
                                                            echo "<option>".$i."</option>";
                                                        }
                                                ?>
                                            </select>
                                            </div>
                                        <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="Honors(if any)" name="educ[]"></textarea></div></td>
                        </tr>
                        <tr>
                            <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="High School" name="high_educ" required><?=set_value('high_educ')?></textarea></div>
                                <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="Location" name="high_educ_loc" required><?=set_value('high_educ_loc')?></textarea></div>
                                    <td><div class="form-group form-remove-margin">
                                        <select class="form-control" name="educ[]">
                                               <?php
                                                    for ($i=date('Y'); $i>date('Y')-80; $i--)
                                                    {
                                                        echo "<option>".$i."</option>";
                                                    }
                                                ?>
                                            </select>
                                            </div>
                                        <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="Honors(if any)" name="educ[]"></textarea></div></td>
                        </tr>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2" id="forTransferee">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">For Transferees</h3>
                </div>
                <div class="panel-body">
                    
                        <table class="table table-bordered">
                            <tr>
                                <th>Complete Name of Last School Attended
                                    <th>Address of School
                                        <th>Inclusive Dates
                                            <th>Honors(if any)</th>
                            </tr>
                            <tr>
                                <td><div class="form-group form-remove-margin"><textarea class="form-control" placeholder="College" name="transferee_educ"></textarea></div></td>
                                <td><div class="form-group form-remove-margin"><textarea class="form-control " placeholder="Location" name="transferee_educ_location"></textarea></div></td>
                                <td align="center">
                                <div class="form-group form-remove-margin">
                                    <select id="college-inclussive1" class="form-control " name="transferee_educ_year1">
                                        <option></option>
                                        <?php
                                            $years = (int) date('Y') - 20;
                                            $today = (int) date('Y');
                                            for ($years; $years <= $today; $years++)
                                            {
                                                echo '<option>'.$years.'</option>';
                                            }
                                        ?>
                                    </select><br/>TO<br/><select id="college-inclussive2" class="form-control" name="transferee_educ_year2">
                                        <option></option>
                                        <?php
                                            $years = (int) date('Y') - 20;
                                            $today = (int) date('Y');
                                            for ($years; $years <= $today; $years++)
                                            {
                                                echo '<option>'.$years.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" name="transferee_educ_year12" id="col-incl-dates" />
                                    </div>
                                </td>
                                <td> <div class="form-group form-remove-margin"><textarea class="form-control" placeholder="Honors(if any)" name="transferee_educ_honors"></textarea></div></td>
                             
                            </tr>
                        </table>
                   
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Enrollment Information</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group" style="padding:10px 40px;">
                        <div style="padding:20px 10px; border:2px solid green; border-radius:4px;">
                            <label class="col-sm-12" style="font-size:18px;">* Desired Course</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="course" required>
                                        <option></option>
                                        <?php for ($i = 0; $i < count($courses); $i++) : ?>
                                            <option value="<?=$courses[$i]->courseid?>"><?=$courses[$i]->course?></option>
                                    <?php endfor; ?> 
                                     </select>
                            </div>
                            <br style="clear:both;" />
                        </div>
                    </div>
                    <table>
                        <fieldset>
                            <tr>
                                <td colspan="3"><b>What are your reasons for enrolling at Pines City Colleges (Check applicable)</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="questions[]" value="1"> Low tuition fee</td>
                                <td><input type="checkbox" name="questions[]" id="questions" value="4"> Parent's Choice</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="questions[]" value="2"> Near Home or boarding house</td>
                                <td><input type="checkbox" name="questions[]" id="questions" value="5"> Cordial and peaceful school atmosphere</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="questions[]" value="3"> Provides good instruction</td>
                                <td><input type="checkbox" id="other-q1"> Others <input type="hidden" id="other-q1-input" name="other-q1" disabled /></td>
                            </tr>
                            <tr>
                                <td><br/></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Why did you make this choice (Check applicable)</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="questions[]" value="7"> Family sugngestion or tradition</td>
                                <td><input type="checkbox" name="questions[]" value="10"> Friend's or Teacher's advice</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="questions[]" value="8"> Personal choice</td>
                                <td><input type="checkbox" name="questions[]" value="11"> It is the most profitable financially</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="checkbox" name="questions[]" value="9"> It is best suited to my abilities</td>
                                <td><input type="checkbox" id="other-q2"> Others <input type="hidden" id="other-q2-input" name="other-q2" disabled /></td>
                            </tr>
                        </fieldset>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->

        <div class="col-md-8 col-md-offset-2" id="requirements_view">
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title">Requirements to bring after Registration</h3>
                </div>
                <div class="panel-body">
                    <ul id="localnew">
                        <li>Original And Photocopy of form 138 (Report Card)</li>
                        <li>NSO copy of birth certificate</li>
                        <li>NCAE Result (if applicable)</li>
                        <li>Certificate of Good Moral Character</li>
                        <li>4 2x2 I.D pictures</li>
                        <li>Medical and Dental clearance/certificate</li>
                        <li>Original and photocopy of transfer Credentials and Otr or copy of grades(for transferees)</li>
                        <li>Letter of Explanation(for transferees)</li>
                        <li>2 long folders and envelopes</li>
                    </ul>
                    <ul id="localtransferee">
                        <li>Copy of Grades / OTR</li>
                        <li>Medical and Dental clearance/certificate</li>
                        <li>Certificate of Good Moral Character</li>
                        <li>NSO copy of birth certificate</li>
                        <li>4 2x2 I.D pictures</li>
                        <li>2 long folders and envelopes</li>
                    </ul>
                    <ol type="A" id="foreignnew">
                        <li>Requrements for notice of acceptance (Foreign - NEW)
                            <ol type="a">
                                <li>Authenticated Academic Records with Red Ribbon</li>
                                <li>Authenticated Birth Certificate with Red Ribbon</li>
                                <li>Photocopy of Passport's photopage, validity &amp; latest arival</li>
                                <li>Police Clearance</li>
                                <li>NICA Clearance</li>
                                <li>Medical Clearance from Bureau of Quarantine</li>
                                <li>2 Long envelopes and 3 long folders</li>
                            </ol>
                        </li>
                    </ol>
                    <ol type="A" id="foreigntransferee">
                        <li>Requirements for Transferees (Foreign - Transferee)
                            <ol type="a">
                                <li>Original &amp; Photocopy of Passport</li>
                                <li>Valid Student Visa</li>
                                <li>Transfer Credentials (Honorable Dismissal)</li>
                                <li>Copy of Grades/Certified True Copy of OTR</li>
                                <li>No Objection Certificate</li>
                                <li>3 Long folder &amp; 2 long envelope</li>
                                <li>Photocopy of Birth Certificate</li>
                                <li>Medical and Dental Clearance/Certificate</li>
                                <li>4 pcs. 2x2 ID pictures (white background)</li>
                            </ol>
                        </li>
                    </ol>
                    <ul id="crossenrollee-req">
                        <li>Cross enroll permit</li>
                        <li>1 Folder</li>
                        <li>1 Envelop</li>
                        <li>1 2x2 ID Picture</li>
                    </ul>
                    <span id="if-married"></span>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 /#foreigntransferee-->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Terms and Conditions</h3>
                </div>
                <div class="panel-body">
                    <p style="text-indent:50px;">I certify that the information reflected on this application form is complete and correct to the best of my knowledge. I understand that any false information given shall merit appropriate disciplinary action.</p>
                    <p style="text-indent:50px;">I am also responsible to notify and update the school regarding changes in my address, contact number, status, or any of the information stated above during the whole duration of my stay in Pines City Colleges if admitted.</p>
                    <center>
                        <div class="form-group">
                            <label>
                       
                                    <input type="checkbox" value="terms" name="checker" id="agreement" />
                                    *  I accept the Terms and Conditions
                                </label><br/>
                        </div>
                        <p id="terms_error" style="color:red;"></p>
                        <img src="" class="img-responsive" id="captcha_data" />
                        <p style="font-size:10px;"><a href='javascript: $(this).refreshCaptcha();' id="refresh">Refresh Captcha</a></p>
                        <div class="form-group">
                            <p><input autocomplete="off" type="text" id="capthca_inp" name="capthca_inp" placeholder="Input captcha code" style="text-transform:none;" required />
                                <br/><span style="color:red;font-size:10px;" id="wrongCaptcha"></span></p>
                        </div>

                        <p id="not_unique" style="color:red;"></p>
                        <input type="hidden" name="submitReg" />
                        <input type="hidden" id="pcc_tokenizer_data" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>" />

                        <div class="form-group">
                            <button type="submit" name="submit" id="submit_button" class="btn btn-success"><i class="fa fa-angle-double-right"></i> Continue</button>
                        </div>
                    </center>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

        </div>
        <!-- /.col-md-8 -->

        <input type="reset" id="resetbtn" style="display:none;" />

    </form>

    <div id="viewSubmitted"></div>

</div>
<!-- /.container -->