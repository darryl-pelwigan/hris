<style type="text/css">
    table.dataTable.fixedHeader-floating {
         display: none !important; 
    }
     
    .dataTables_scrollHeadInner{
        margin-left: 0;
        width: 78% !important;
        position: fixed;
        display: block;
        overflow: hidden;
        margin-right: 0; /*30px*/
        background: white;
        z-index: 1000;
        padding-bottom: 8px;
    }
     
    .dataTables_scrollBody{
        padding-top: 65px;
    }

    .DTFC_LeftBodyLiner > table {
        margin-top: 0 !important; 
        margin-bottom: 0 !important; 
        border: 2px solid black;
    }

    .DTFC_LeftFootWrapper {
        display: none;
    }
    
    table.dataTable {
        margin-top: 0 !important;
    }

    .DTFC_LeftBodyWrapper {
        /*height: 61.5em !important;*/
        /*min-height: 200px !important;
        max-height: 900px !important;*/
        color: #5cb162;
    }
</style>
<div id="page-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Lists
        </div>
        <div class="panel-body">
            <button class="btn btn-warning btn-sm pull-right" style="margin-bottom: 5px" type="button" data-controls-modal="#new_modal" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#new_modal"><i class="fa fa-folder-open"></i> New Employee</button>
            
            <table id="emp_lists" class="table table-bordered display compact small employee" style="cursor: pointer;" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Change Status</th>
                        <!-- <th>Biometrics No</th> -->
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>File No</th>
                        <th>Position / Rank</th>
                        <th>Department</th>
                        <th>Birth Date</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Civil Status</th>
                        <th>Religion</th>
                        <th>Date of Employment</th>
                        <th>Years of Service</th>
                        <th>End of Contract</th>
                        <th>Teaching / Non-Teaching</th>  
                        <th>Union</th>
                        <th>Employment Status</th>
                        <th>Nature of Employement</th>
                        <th>Home Address</th>
                        <th>Provincial Address</th>
                        <th>Email Address</th>
                        <th>Contact No.</th>
                        <th>With / Without Dependents</th>
                        <th>Tin No.</th>
                        <th>SSS No.</th>
                        <th>PAG-IBIG No.</th>
                        <th>PhilHealth No.</th>
                        <th>PERAA No.</th>
                        <th>Emergency Contact</th>
                        <th>Emergency Contact Address</th>
                        <th>Emergency Contact No.</th>
                        <th>Relationship</th>
                        <th>Highest Educational Attainment</th>
                        <th>Eligibilities</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <!-- <th></th> -->
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th><!-- Position / Rank -->
                        <th></th><!-- Department -->
                        <th></th>
                        <th></th>
                        <th></th><!-- Sex -->
                        <th></th><!-- Civil Status -->
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th><!-- Teaching / Non-Teaching -->
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

            <button class="btn btn-loader hide"><img src="<?=base_url()?>assets/images/facebook.gif" class="loader" style="height: 30px" /> Generating Years of Service</button> 
        </div>
    </div>
</div> <!-- /#page-wrapper -->

<div class="modal fade" id="new_modal" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <?php
        $deps = '';
        $pos = '';
        foreach($position_lists as $p){
            $pos .= '<option value="'.$p->id.'">'.$p->position.'</option>';
        }
        foreach($dept_lists as $d){
            $deps .= '<option value="'.$d->DEPTID.'">'.$d->DEPTNAME.'</option>';
        }
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="" id="modal_empRecordAdd" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="dentalRecord">New Employee Record</h4>
                <input type="hidden" id="root_url" value="">
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input style="visibility: hidden;" onclick="$(this).changeAutoSave();" type="checkbox" name="auto_save" id="fancy-checkbox-primary" autocomplete="off" checked="checked" />
                                <div class="btn-group">
                                  <label for="fancy-checkbox-primary" id="fancy-checkbox-primary2" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                  </label>
                                  <label for="fancy-checkbox-primary" id="fancy-checkbox-primary" class=" btn btn-info active">AUTO SAVE ON</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <span style="float:right;margin-right:5%">
                                <input type="radio" name="active" id="active" value="1" required checked="" /> Active&emsp;
                                <input type="radio" name="active" id="inactive" value="0" required/> Inactive
                            </span>
                        </div>
                    </div>
                    <br style="clear:both;">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">File No:</label>
                        <div class="col-sm-3">
                            <input class="form-control fileno" pattern="[0-9]{4}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'File no. must consist of 4 numbers' : '');" maxlength="4" type="text" name="fileno" required >
                            <div id="fileid"></div>
                        </div>
                        
                        <label  class="col-sm-3 control-label">Biometrics ID:</label>
                        <div class="col-sm-3">
                            <input class="form-control biono" pattern="[0-9]{4}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'Biometrics no. must consist of 4 numbers' : '');" maxlength="4" type="text" name="biono" required>
                            <div id="bioid"></div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding:1.5%">
                            <h3 class="panel-title">Personal Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">First Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="fname" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Middle Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="mname" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Last Name</label>
                                <div class="col-sm-9">
                                   <input class="form-control" type="text" name="lname" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Birth Date</label>
                                <div class="col-sm-2">
                                   <select class="form-control" name="month" id="month" onChange="getBdate()" required>
                                     <option value="">Month</option>
                                         <option value="1">January</option>
                                         <option value="2">February</option>
                                         <option value="3">March</option>
                                         <option value="4">April</option>
                                         <option value="5">May</option>
                                         <option value="6">June</option>
                                         <option value="7">July</option>
                                         <option value="8">August</option>
                                         <option value="9">September</option>
                                         <option value="10">October</option>
                                         <option value="11">November</option>
                                         <option value="12">December</option>
                                     </select>
                                </div>
                                <div class="col-sm-2">
                                   <select class="form-control" name="day" id="day" onChange="getBdate()" required>
                                        <option value="">Day</option>
                                         <?php 
                                            for($z=1;$z<32;$z++){
                                        ?>
                                            <option ><?=$z;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                   <select class="form-control" name="year" id="year" onChange="getBdate()" required>
                                        <option value="">Year</option>
                                         <?php 
                                            for($c=date('Y')-10;$c>date('Y')-80;$c--){
                                        ?>
                                            <option><?=$c;?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Age:</label>
                                <div class="col-sm-3">
                                    <input class="form-control" readonly type="text" id="age" name="age" required placeholder="Age">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Birth Place</label>
                                <div class="col-sm-9">
                                  <input class="form-control" type="text" name="birthp" required>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Gender</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <label for="" class="col-sm-3 control-label">Civil Status</label>
                                <div class="col-sm-3">
                                    <select name="civil" id="civil" class="form-control" onchange="getSpouse()" required>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="widowed">Widowed</option>
                                        <option value="widower">Widower</option>
                                        <option value="annulled">Annulled</option>
                                        <option value="separated">Separated</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Religion</label>
                                <div class="col-sm-9">
                                    <ul class="dropdown-menu" style="max-width: 100%; min-width: 100%;max-height: 500px;" role="menu" ></ul>
                                    <input id="religion" class="form-control" type="text" name="religion">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Home/City Address</label>
                                <div class="col-sm-3">
                                   <input class="form-control" type="text" id="haddr_sitio" name="haddr_sitio" required placeholder="Sitio/Street, Barangay">
                                </div>
                                <div class="col-sm-3">
                                   <input class="form-control" type="text" id="haddr_town" name="haddr_town" required placeholder="Town">
                                </div>
                                <div class="col-sm-3">
                                  <input class="form-control" type="text" id="haddr_prov" name="haddr_prov" required placeholder="Province">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Provincial Address</label>
                                <div class="col-sm-3">
                                   <input class="form-control" type="text" id="paddr_sitio" name="paddr_sitio" required placeholder="Sitio/Street, Barangay">
                                </div>
                                <div class="col-sm-3">
                                   <input class="form-control" type="text" id="paddr_town" name="paddr_town" required placeholder="Town">
                                </div>
                                <div class="col-sm-3">
                                  <input class="form-control" type="text" id="paddr_prov" name="paddr_prov" required placeholder="Province">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Email Address</label>
                                <div class="col-sm-9">
                                   <input style="text-transform:none" class="form-control" type="email" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Landline No</label>
                                <div class="col-sm-3">
                                  <input class="form-control licno" type="text" name="landline" maxlength="8">
                                </div>
                                 <label for="" class="col-sm-3 control-label">Mobile No</label>
                                <div class="col-sm-3">
                                  <input class="form-control cont" type="text" name="contact" required>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"> <u>Spouse Information</u></label>
                                <div class="col-sm-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Name of Spouse</label>
                                <div class="col-sm-9">
                                   <input type="text" name="realspousename" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Occupation</label>
                                <div class="col-sm-9">
                                   <input type="text" name="realspouseocc" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" name="realspouseadd" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Mobile Number</label>
                                <div class="col-sm-9">
                                    <input type="text" name="realspousecon" class="form-control cont" maxlength="11" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Dependents</label>
                                <div class="col-sm-9">
                                    <input type="radio" name="dependents" class="dependents" value="with dependents" required/> With Dependent(s)
                                    <input type="radio" name="dependents" class="dependents" value="without dependents" required/> Without Dependent
                                </div>
                            </div>
                            <div class="form-group" id="div_dependent" hidden>
                                <label for="" class="col-sm-3"></label>
                                <div class="col-sm-9">
                                    <table id="dependent">
                                        <tr><th>Name of Dependent</th><th>Date of Birth</th><th>Relationship</th></tr>
                                        <tr>
                                            <td><input type="text" class="form-control" name="dpntname[]"></td>
                                            <td><input type="text" class="form-control dateemp" name="dpntbday[]"/></td>
                                            <td><input type="text" class="form-control" name="dpntrel[]"/></td>
                                            <td><button type="button" class="btn btn-success btn-sm" id="moredep"><i class="fa fa-plus"></i></button></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>                  
                        </div>
                    </div>  <!-- end panel personal information -->

                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding:1.5%">
                            <h3 class="panel-title">Parent's/Contact Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Name of Father</label>
                                <div class="col-sm-3">
                                    <input type="text" name="fathername" id="fathername" class="form-control"/>
                                </div>
                                <label for="" class="col-sm-3 control-label">Father's Date of Birth</label>
                                <div class="col-sm-3">
                                    <input type="text" name="fatherbday" class="form-control dateemp"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Father's Occupation</label>
                                <div class="col-sm-3">
                                    <input type="text" name="fatheroccup" class="form-control"/>
                                </div>
                                <label for="" class="col-sm-3 control-label">Date of Death of Father</label>
                                <div class="col-sm-3">
                                    <input type="text" name="fatherddate" id="fatherddate" disabled class="form-control dateemp"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Name of Mother</label>
                                <div class="col-sm-3">
                                    <input type="text" name="mothername" id="mothername" class="form-control"/>
                                </div>
                                <label for="" class="col-sm-3 control-label">Mother's Date of Birt</label>
                                <div class="col-sm-3">
                                    <input type="text" name="motherbday" class="form-control dateemp"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Mother's Occupation</label>
                                <div class="col-sm-3">
                                    <input type="text" name="motheroccup" class="form-control"/>
                                </div>
                                <label for="" class="col-sm-3 control-label">Date of Death of Mother</label>
                                <div class="col-sm-3">
                                    <input type="text" name="motherddate" id="motherddate" disabled class="form-control dateemp"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Person to Contact in Case of Emergency</label>
                                <div class="col-sm-9">
                                    <input class="form-control"  type="text" id="spouse" name="spouse" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Mobile No</label>
                                <div class="col-sm-9">
                                    <input class="form-control cont"  type="text" id="spocont" name="spocont" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" id="spoaddr" name="spoaddr" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Relationship</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" id="sporel" name="sporel" >
                                </div>
                            </div>
                        </div>
                    </div><!-- end of parent info panel -->

    

                     <div class="panel panel-default">
                        <div class="panel-heading" style="padding:1.5%">
                            <h3 class="panel-title">Employee Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Position</label>
                                <div class="col-sm-6">
                                     <select name="pos" class="form-control" required>
                                        <option value=""></option>
                                        <?=$pos?>
                                    </select>
                                </div>
                                <label for="" class="col-sm-1">Salary/day</label>
                                <div class="col-sm-1">
                                    <input type="text" name="salary" class="form-control salary" min="0" id="salary"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Appointment</label>
                                    <div class="col-md-9">
                                    <table id="college" style="width:100%">
                                        <tr>
                                        <td style="width:50%">
                                            <input type="text" name="apps[]" placeholder="Appointment" class="form-control"/>
                                        </td>
                                        <td style="width:20%">
                                            <input type="text" name="from[]" placeholder="From" class="form-control dateemp"/>
                                        </td>
                                        <td style="width:20%">
                                            <input type="text" name="to[]" placeholder="To" class="form-control dateemp"/>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" id="morecol"><i class="fa fa-plus"></i></button>
                                        </td></tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Name of Company:</label>
                                <div class="col-sm-9">
                                    <input class="form-control name_of_company" type="text" name="name_of_company">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Department</label>
                                <div class="col-sm-9">
                                    <select name="dep" class="form-control" required>
                                        <option value=""></option>
                                        <?=$deps?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Date of Employment</label>
                                <div class="col-sm-9">
                                    <input class="form-control dateemp" type="text" name="dateemp" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">End of Contract</label>
                                <div class="col-sm-9">
                                    <input class="form-control dateemp" type="text" name="endcontract" id="endcontract" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Employment Status</label>
                                <div class="col-sm-9">
                                    <select name="empstat" id="empstat" class="form-control" required>
                                        <option value="regular">Regular</option>
                                        <option value="contractual">Contractual</option>
                                        <option value="project-based">Project-Based</option>
                                        <option value="probationary">Probationary</option>
                                        <option value="fixed-term">Fixed Term</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Classification</label>
                                <div class="col-sm-9">
                                     <select name="contract" id="contract" class="form-control" required>
                                        <option value="1">Teaching</option>
                                        <option value="0">Non-Teaching</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Nature of Employment</label>
                                <div class="col-sm-9">
                                    <select name="empnat" class="form-control" required>
                                        <option value="full-time">Full-Time</option>
                                        <option value="part-time">Part-Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Union</label>
                                <div class="col-sm-9">
                                    <select name="union" class="form-control" required>
                                        <option value="1">Union</option>
                                        <option value="0">Non-Union</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

        
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:1.5%">
                        <h3 class="panel-title">Educational Background</h3>
                    </div>
                    <div class="panel-body">
                     <br style="clear:both;">
                      <div class="form-group">
                        <div class="col-md-12">
                            <table id="educothers" width="100%">
                                <tr>
                                <td>
                                    <select name="eductype[]" id="eductype" class="form-control">\
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Masters">Masters</option>
                                        <option value="Doctorate">Doctorate</option>
                                        <option  value="Others">Others</option>
                                    </select>
                                 
                                 </td>
                                <td width="30%">
                                    <input type="text" id="education_degree" name="educdegree[]" placeholder="Degree" class="form-control"/>
                                </td>
                                <td>
                                     <select name="educstatus[]" id="educstatus" class="form-control educstatus">
                                        <option selected disabled>Status</option>
                                        <option value="On Going" data-placeholder="Remarks">On Going</option>
                                        <option value="Completed" data-placeholder="Year Completed">Completed</option>
                                        <option value="Units Earned" data-placeholder="Units Earned">Units Earned</option>
                                    </select>                                
                                </td>
                                <td width="15%;">
                                    <input type="text" name="educremarks[]" id="educremarks" class="form-control educremarks"/>
                                </td>
                                <td width="30%;">
                                    <input type="text" name="educnameschool[]" class="form-control" placeholder="Name of School and Address"/>
                                </td>
                                <td><button type="button" class="btn btn-success btn-xs" id="moreeduc"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>

                 <div class="panel panel-default">
                    <div class="panel-heading" style="padding:1.5%">
                        <h3 class="panel-title">Eligibilities</h3>
                    </div>
                    <div class="panel-body">
                        <table id="elig" style="width:100%" >
                        <tr><th>Type of Eligibility</th><th>Date of Examination</th><th>License No.</th><th>Rating</th><th>Expiry</th></tr>
                        <tr>
                            <td><input type="text" id="eligname" class="form-control" name="eligname[]"></td>
                            <td><input type="text" class="form-control dateemp" name="eligdate[]"/></td>
                            <td><input type="text" class="form-control licno" type="text" name="eligno[]"/></td>
                            <td width="130px"><input type="text" class="form-control rating" name="eligrate[]"/></td>
                            <td width="130px"><input type="text" class="form-control dateemp" name="expiry[]"/></td>
                            <td><button type="button" class="btn btn-success btn-xs" id="moreelig"><i class="fa fa-plus"></i></button></td>
                        </tr>
                    </table>

                     <br style="clear:both;">
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:1.5%">
                        <h3 class="panel-title">Government Issued IDs</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">SSS No</label>
                            <div class="col-sm-9">
                                <input class="form-control sss" pattern="[0-9._-]{12}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'SSS No. must consist of 12 numbers and a dash' : '');" type="text" maxlength="12" name="sss" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">PhilHealth No</label>
                            <div class="col-sm-9">
                                <input class="form-control philhealth" pattern="[0-9._-]{14}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'PhilHealth No. must consist of 12 numbers and a dash' : '');" type="text" maxlength="14" name="philhealth" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">PERAA No</label>
                            <div class="col-sm-9">
                                <input class="form-control peraa" type="text" pattern="[0-9._-]{11}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'PERAA No. must consist of 12 numbers and a dash' : '');" type="text" maxlength="11" name="peraa" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">PAG-IBIG No</label>
                            <div class="col-sm-9">
                                <input class="form-control pagibig" maxlength="14" pattern="[0-9._-]{14}" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'PAG-IBIG No. must consist of 14 numbers and spaces' : '');" type="text" name="pagibig" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">TIN</label>
                            <div class="col-sm-9">
                                <input class="form-control tin" type="text" name="tin" maxlength="15"  onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'TIN No. must consist of 12 numbers and 3 dashes' : '');" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">PRC ID</label>
                            <div class="col-sm-9">
                                <table id="otherid" width="100%">
                                <tr><td style="width:60%"><input class="form-control prc" type="text" placeholder="PRC ID" name="prc"></td>
                                    <td><input class="form-control dateemp
                                        prc_expiration_date" type="text" placeholder="Expiration Date" name="prc_expiration_date"></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Others</label>
                            <div class="col-sm-9">
                                <table id="otherid" width="100%">
                                <tr><td style="width:60%"><input class="form-control" type="text" placeholder="ID Name" name="othername[]"></td>
                                    <td><input class="form-control licno" type="text" placeholder="Number" name="otherno[]" onkeyup="this.setCustomValidity(this.validity.patternMismatch ? 'ID No. must consist of numbers or dashes' : '');"></td>
                                    <td><button type="button" class="btn btn-success btn-sm" id="moreid"><i class="fa fa-plus"></i></button></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit_new_emp" class="btn btn-success" id="submit_save" disabled="disabled">Save</button>
                <input type="hidden" value="FALSE" id="add_done" />
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="dailyenrolleesModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" id="dailyenrolleesModalLabel"><b>PRIVACY NOTICE</b></h3>
            </div>
                <div class="modal-body">
                    <h4>WE COLLECT PERSONAL DATA</h4>
                     
                    <p>Pines City Colleges is the data controller of the data you provide to us.  This means the school determines the purposes for which, and the manner in which, any personal data relating to students, their families, guests, and visitors are to be processed. </p> 
                     
                    <p>In some cases, your data will be outsourced to a third-party processor; however, this will only be done with your consent, unless the law requires the school to share your data.  Where the school outsources data to a third-party processor, the same data protections standards that the school upholds are imposed on the processor.  </p>
                     
                    <h4>OUR PURPOSE FOR COLLECTING</h4>
                     
                    <p>Pines City Colleges holds the legal right to collect and use personal data relating to students and their families.  We may also receive information regarding them from their previous school.  We collect and use personal data in order to meet legal requirements and legitimate interests set out in the Data Privacy Act of 2012.  </p>
                     
                    <p>This information will only be collected for the purposes necessary to the functions and activities of the school.  The categories of information that the school collects, holds, and shares include the following, among others: (1) Personal Information – e.g. names, addresses; (2) Characteristics – e.g. ethnicity, language, nationality; (3) Attendance Information – e.g. number of absences, reasons; (4) Assessment information – e.g. grades; (5) Relevant medical information.</p>
                     
                    <h4>WHAT WE DO WITH COLLECTED PERSONAL DATA</h4>
                     
                    <p>To the extent permitted or required by law, we use your personal data to pursue our legitimate interests as an educational institution, including a variety of academic, administrative, research, historical, and statistical purposes. </p>
                     
                    <p>Your personal data is stored and transmitted securely in a variety of paper and electronic formats, including databases that are shared between the school’s different units or offices. Access to your personal data is limited to school personnel who have a legitimate interest in them for the purpose of carrying out their contractual duties. Rest assured that our use of your personal data will not be excessive.</p>
                     
                    <p>Unless otherwise provided by law or by appropriate policies, we will retain your relevant personal data indefinitely for historical and statistical purposes. Where a retention period is provided by law and/or a school policy, all affected records will be securely disposed of after such period.</p>
                     
                    <p>The school may, from time to time and at its sole discretion, review and update this policy to take account of new laws and technology, changes to the school’s operations and practices and to make sure it remains appropriate to the changing environment.  We will post and publish notice of any such modification, which shall be effective immediately upon posting or publication.</p>
                     
                    <p>For inquiries, concerns, or questions regarding our Privacy Policy, you may email at  privacy@pcc.edu.ph or call 445-2209.</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>