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
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</div> 
<br />
<div class="container">
        <!-- 
            action="registersuccess"
            action="viewregistration.php"
        -->
        <form name="regform" id="regform" method="post" action="<?=base_url()?>Submit_Early_Enrollment" class="form-horizontal">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1><b>Early Enrollment Registration</b></h1>
                        <h4>For : <?=($sem_sy['sem_sy_e']['csemword'])?> <?=($sem_sy['sem_sy_e']['sy2'])?></h4>
                    </div>
                    <div class="panel-body">
                        <h3 class="panel-title"><u><b>Personal Information</b></u></h3>
                        <table class="table">
                            <tr>
                                <td align='right'><b>* Select Type</b></td>
                                <td><label><input type="radio" name="stype" class="local" value="local"  onclick="checkType(this.value);"> Filipino</label>
                                    <td><label><input type="radio" name="stype" id="sforeign" value="foreign" onclick="checkType(this.value)"> Foreign</label>
                                        <td><label><input type="radio" name="stype" id="sdual" value="dual" onclick="checkType(this.value)"> Dual Citizenship</label> <span id="radio_error" style="color:red;"></span></td>
                            </tr>
                            <tr>
                                <td class="bordernone-top"></td>
                                <td colspan="10" class="bordernone-top" ><span id="error_type" style="color:red;"></span></td>
                            </tr>
                            <tr id="foreign" class="bordernone-top">
                                <td class="bordernone-top"><b></b>
                                    <td class="bordernone-top"><label><input type="radio" class="sTypess" name="studenttype" id="newforeign" value="1"> Freshmen</label>
                                        <td class="bordernone-top"><label><input type="radio" name="studenttype" class="sTypess" id="transfereeforeign" value="2"> Transferee</label>
                                            <td class="bordernone-top"><label><input type="radio" name="studenttype" class="sTypess crossenroll" value="6"> Cross Enrollee</label></td>
                            </tr>
                            <tr id="local">
                                <td class="bordernone-top" ><b></b>
                                    <td class="bordernone-top" ><label><input type="radio" class="sTypess" name="studenttype" id="newlocal" value="1"> Freshmen</label>
                                        <td class="bordernone-top" ><label><input type="radio" name="studenttype" class="sTypess" id="transfereelocal" value="2"> Transferee</label>
                                            <td class="bordernone-top" ><label><input type="radio" name="studenttype" class="sTypess crossenroll" value="6"> Cross Enrollee</label></td>
                            </tr>
                        </table>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Last Name</label>
                            <div class="col-sm-9">
                                <input class="form-control only-text check_exist"  type="text" name="lname" value="<?=set_value('lname','lname')?>" required />
                             <?=form_error('lname', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* First Name</label>
                            <div class="col-sm-9">
                                <input class="form-control only-text check_exist"  type="text" name="fname" value="<?=set_value('fname','fname')?>" required />
                             <?=form_error('fname', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span id="middlename-asterisk">*</span> Middle Name</label>
                            <div class="col-sm-9">
                                <input class="form-control only-text check_exist" id="middlename" type="text" pattern=".{2,}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'Middle name must be longer than 2 characters' : '');" name="mname" value="<?=set_value('mname','mname')?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name Suffix</label>
                            <div class="col-sm-9">
                                <input class="form-control only-text" type="text" name="nsname" value="<?=set_value('nsname','nsname')?>" placeholder="ex.(JR, SR, III)" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Civil Status</label>
                            <div class="col-sm-9">
                                <select id="cstatus" onchange="javascript:cstatus2($(this));" class="form-control" name="cstatus" required />
                                    <option>Single</option>
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
                                   <option>Filipino</option>
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
                                    <option>Aglipayan</option>
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
                                <input class="form-control" type="text" id="geocomplete" value="<?=set_value('po_birth','Baguio')?>" name="po_birth" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Birth Date</label>
                            <div class="col-sm-9">
                                <div class="col-sm-4">
                                    <label class="sr-only">Month</label>
                                    <select class="form-control bdates" name="month" id="month" oninput="getBdate()" required>
                                        <option value="2">January</option>
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
                                    <select disabled="disabled" class="form-control bdates" name="year" id="year" oninput="getBdate()" required>
                                        <option value="">1989</option>
                                        <?php 
                                            for($i=date('Y')-15;$i>date('Y')-80;$i--){
                                                echo "<option>".$i."</option>";
                                            }
                                        ?>
                                        </select>
                                        <input class="check_exist" value="<?=set_value('bdate','01/01/1989')?>" type="hidden" name="bdate" id="bdate" />
                                    <!-- birthdate joined string -->
                                </div>
                                
                                 <div class="col-sm-4">
                                    <label class="sr-only">Day</label>
                                    <select disabled="disabled" class="form-control bdates" name="day" id="day" oninput="getBdate()" required>
                                        <option value="">01</option>
                                    </select>
                                </div>
                                
                                <span id="error_bday" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Sex</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="sex" required>
                                    <option value="male">Male</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
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
                                <input class="form-control" id="age_input" value="<?=set_value('age','27')?>" type="hidden" name="age" id="age" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Height</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="height">
                                <option>160 cm</option>
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
                                <option>50 kg</option>
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
                                <select class="form-control" name="famBG_1" oninput="birthOrder($(this));">
                                    <option>2</option>
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
                                <option>Second</option>
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
                                <input class="form-control phone" rel="2" value="<?=set_value('cphone','0910 123  4567')?>" name="cphone" class="phone" type="tel" required />
                                 <?=form_error('cphone', '<div class="alert-danger">', '</div>')?>
                            </div>
                            <div class="col-sm-3" style="padding-top:8px;" id="tel2"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Email Address</label>
                            <div class="col-sm-9">
                                <input id="emailadd" class="form-control" value="<?=set_value('emailadd','ben.testpcc@gmail.com')?>" type="email" placeholder="ex.( mail@gmail.com, mail@yahoo.com )" autocomplete="off" required />
                                <span id="alert_email"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Verify Email Address</label>
                            <div class="col-sm-9">
                                <input id="checkemailadd" class="form-control" value="<?=set_value('checkemailadd','ben.testpcc@gmail.com')?>" onblur="CheckEmail();" type="email" name="checkemailadd" placeholder="ex.( mail@gmail.com, mail@yahoo.com )" autocomplete="off" required />
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
                                    <input class="form-control current-address" value="<?=set_value('c_add_hn','20')?>" name="c_add_hn" type="text" required />
                                    <?=form_error('c_add_hn', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Street Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control current-address" value="<?=set_value('c_add_sn','test')?>" name="c_add_sn" type="text" required/>
                                    <?=form_error('c_add_sn', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* District/Barangay</label>
                                <div class="col-sm-9">
                                    <input class="form-control current-address" value="<?=set_value('c_add_b','test')?>" name="c_add_b" type="text" required/>
                                     <?=form_error('c_add_b', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* City/Municipality</label>
                                <div class="col-sm-9">
                                    <input class="form-control current-address" value="<?=set_value('c_add_m','testm')?>" name="c_add_m" type="text" required />
                                    <?=form_error('c_add_m', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Province</label>
                                <div class="col-sm-9">
                                    <input class="form-control current-address" value="<?=set_value('c_add_p','testps')?>" name="c_add_p" type="text" required>
                                    <?=form_error('c_add_p', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Country</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control current-address" value="Philippines" readonly required />
                                    <input type="hidden" id="baguioAdd" name="baguioAdd">
                                    <?=form_error('baguioAdd', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset id="YourAddress">
                            <legend id="pAddress">Permanent Address <small><a id="sameAs" type="button" onclick="copyCurrentadd();currentAddress();">Same as Current Address &#8592;</a></small></legend>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">House No.</label>
                                <div class="col-sm-9">
                                    <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_p','')?>" name="p_add_p" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Street Name/Sitio</label>
                                <div class="col-sm-9">
                                    <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_sn','')?>" name="p_add_sn"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* District/Barangay</label>
                                <div class="col-sm-9">
                                    <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_db','')?>" name="p_add_db" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* City/Municipality</label>
                                <div class="col-sm-9">
                                    <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_cm','')?>" name="p_add_cm" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Province</label>
                                <div class="col-sm-9">
                                    <input class="form-control permanent-address" type="text" value="<?=set_value('p_add_pr','')?>" name="p_add_pr" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Country</label>
                                <div class="col-sm-9">
                                    <span id="error_country" style="color:red;"></span>
                                    <select class="form-control permanent-address selectpicker" id="Pcountry" data-live-search="true" onChange="permanentAddress()">
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
                                <input class="form-control" id="" type="text" name="spouse_lname" value="<?=set_value('spouse_lname','spouse_lname')?>" />
                                <?=form_error('spouse_lname', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* First Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="spouse_flname" value="<?=set_value('spouse_flname','spouse_flname')?>" />
                                <?=form_error('spouse_flname', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Middle Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="spouse_mlname" value="<?=set_value('spouse_mlname','spouse_mlname')?>" />
                                <?=form_error('spouse_mlname', '<div class="alert-danger">', '</div>')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name Suffix</label>
                            <div class="col-sm-9">
                                <input style="text-transform:none;" class="form-control spouse-notreq" type="text" name="spouse_nsname" value="<?=set_value('spouse_nsname','')?>"  placeholder="ex.(JR, SR, III)" />
                            </div>
                        </div>
                        <fieldset>
                            <legend>Contact No</legend>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Telephone No</label>
                                <div class="col-sm-6">
                                    <input type="tel" class="form-control phone spouse-notreq" rel="3" name="spousetel" value="<?=set_value('spousetel','')?>" />
                                </div>
                                <div class="col-sm-3" style="padding-top:8px;" id="tel3"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Cellphone No</label>
                                <div class="col-sm-6">
                                    <input type="tel" class="form-control phone" rel="4" name="spousecp" value="<?=set_value('spousecp','0910 222 2222')?>" />
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
                                    <input class="form-control check_exist" type="text" name="famBG_mom" value="<?=set_value('famBG_mom','famBG_mom')?>" placeholder="Mother's Maiden Name" required />
                                <?=form_error('famBG_mom', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Deceased:</label>
                                <div class="col-sm-9">
                                    <label><input onclick="checkMother(this)" id="mDeceasedYes" type="checkbox" name="famBG[]" value='yes' > Yes</label>&emsp;
                                    <label><input onclick="checkMother(this)" id="mDeceasedNo" type="checkbox" name='famBG[]' value='no' checked> No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span id="mother-occu-asterisk">*</span> Occupation</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="famBG_mom_occupation" value="<?=set_value('famBG_mom_occupation','famBG_mom_occupation')?>" placeholder="Mother's Occupation" id="mother-occu" required />
                                    <?=form_error('famBG_mom_occupation', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span id="motherasterisk">*</span> Telephone No</label>
                                <div class="col-sm-6">
                                    <input type="tel" class="form-control phone" rel="5" value="" id="mothercontact"  value="<?=set_value('famBG_mom_tel','0910 133 1334')?>" name="famBG_mom_tel" required />
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
                                    <input type="tel" class="form-control phone" rel="6" id="cpmother" value="<?=set_value('famBG_mom_cphone','0910 133 1333')?>" name="famBG_mom_cphone" required />
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
                                    <input class="form-control" type="text" name="famBG_dad" value="<?=set_value('famBG_dad','famBG_dad')?>" placeholder="Father's Name" required />
                                    <?=form_error('famBG_dad', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Deceased:</label>
                                <div class="col-sm-9">
                                    <label><input onclick="checkFather(this)" id="fDeceasedYes" type="checkbox" name="famBG[]" value='yes'> Yes</label>&emsp;
                                    <label><input onclick="checkFather(this)" id="fDeceasedNo" type="checkbox" name='famBG[]' value='no' checked> No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span id="father-occu-asterisk">*</span> Occupation</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="famBG_dad_occupation"  value="<?=set_value('famBG_dad_occupation','famBG_dad_occupation')?>" placeholder="Father's Occupation" id="father-occu" required />
                                 <?=form_error('famBG_dad_occupation', '<div class="alert-danger">', '</div>')?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span id="fatherasterisk">*</span> Telephone No</label>
                                <div class="col-sm-6">
                                    <input type="tel" class="form-control phone" rel="7" value="<?=set_value('famBG_dad_tel','0910 158 1998')?>" id="fathercontact" name="famBG_dad_tel" required />
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
                                    <input type="tel" class="form-control phone" rel="8" id="cpfather" value="<?=set_value('famBG_dad_cphone','0910 158 1999')?>" name="famBG_dad_cphone" required />
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
                                <input class="form-control" type="text" value="<?=set_value('famBG_guardian','famBG_guardian')?>" name="famBG_guardian" id="g-name" required />
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
                            <legend>Address <small><a id="sameAs" type="button" onclick="copyBaguioadd();gbaguioAddress();">Same as Current Address &#8592;</a></small></legend>
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
                                <input class="form-control phone" value="<?=set_value('famBG_gurdian_tel','0910 155 1555')?>" type="text" rel="9" name="famBG_gurdian_tel" id="g-contact" required />
                            </div>
                            <div class="col-sm-3" style="padding-top:8px;"><label><input type="checkbox" id="g-no-tel" /> N/A</label></div>
                            <br style="clear:both;" />
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6" style="padding-top:8px;" id="tel9"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">* Cellphone No.</label>
                            <div class="col-sm-6">
                                <input class="form-control phone" type="text" rel="10" value="<?=set_value('famBG_gurdian_cphone','0910 155 1777')?>" name="famBG_gurdian_cphone" required />
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
                                <td><textarea class="form-control" placeholder="Elementary" name="elem_educ" required><?=set_value('elem_educ','elem_educ')?></textarea>
                                    <td><textarea class="form-control" placeholder="Location" name="elem_educ_loc" required><?=set_value('elem_educ_loc','elem_educ_loc')?></textarea>
                                        <td>
                                            <select class="form-control" name="educ[]">
                                                <?php
                                                        for ($i=date('Y'); $i>date('Y')-80; $i--)
                                                        {
                                                            echo "<option>".$i."</option>";
                                                        }
                                                ?>
                                            </select>
                                            <td><textarea class="form-control" placeholder="Honors(if any)" name="educ[]"></textarea></td>
                            </tr>
                            <tr>
                                <td><textarea class="form-control" placeholder="High School" name="high_educ" required><?=set_value('high_educ','high_educ')?></textarea>
                                    <td><textarea class="form-control" placeholder="Location" name="high_educ_loc" required><?=set_value('high_educ_loc','high_educ_loc')?></textarea>
                                        <td>
                                            <select class="form-control" name="educ[]">
                                               <?php
                                                    for ($i=date('Y'); $i>date('Y')-80; $i--)
                                                    {
                                                        echo "<option>".$i."</option>";
                                                    }
                                                ?>
                                            </select>
                                            <td><textarea class="form-control" placeholder="Honors(if any)" name="educ[]"></textarea></td>
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
                                <td><textarea class="form-control" placeholder="College" name="educ[]"></textarea></td>
                                <td><textarea class="form-control" placeholder="Location" name="educ[]"></textarea></td>
                                <td align="center">
                                   <select id="college-inclussive1" class="form-control">
                                        <option></option>
                                        <?php
                                            $years = (int) date('Y') - 20;
                                            $today = (int) date('Y');
                                            for ($years; $years <= $today; $years++)
                                            {
                                                echo '<option>'.$years.'</option>';
                                            }
                                        ?>
                                    </select><br/>TO<br/><select id="college-inclussive2" class="form-control">
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
                                    <input type="hidden" name="educ[]" id="col-incl-dates" />
                                </td>
                                <td><textarea class="form-control" placeholder="Honors(if any)" name="educ[]"></textarea></td>
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
                <div class="panel panel-default">
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
                            <label>
                                    <input type="checkbox" value="terms" name="checker" id="agreement" />
                                    *  I accept the Terms and Conditions
                                </label><br/>
                            <p id="terms_error" style="color:red;"></p>
                            <img src="<?=$_SESSION["captcha_info"]["image_src"]?>" class="img-responsive" id="captcha_data" />
                            <p style="font-size:10px;"><a href='javascript: refreshCaptcha();' id="refresh">Refresh Captcha</a></p>
                            <p><input type="text" id="capthca_inp" name="capthca_inp"  placeholder="Input captcha code" style="text-transform:none;" />
                            <br/><span style="color:red;font-size:10px;" id="wrongCaptcha"></span></p>
                            <p id="not_unique" style="color:red;"></p>
                            <input type="hidden" name="submitReg" />
                            <input type="hidden" id="pcc_tokenizer_data" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            
                            
                            <button onsubmit="return false;" type="submit" id="submit_button" class="btn btn-success"><i class="fa fa-angle-double-right"></i> Continue</button>
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


