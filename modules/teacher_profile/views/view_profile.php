<style>
     .ui-autocomplete {
        z-index: 2147483647;
        position:absolute;
    }
</style>
<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                
                <h1 class="page-header">
                   
                </h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Information
            <?php $position = (isset($user['position'][0])?$user['position'][0]->position:'N/A')?>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <input type="hidden" value="20000" id="teachid" name="studentid">
            <input type="hidden" value="<?=$this->session->userdata('id')?>" id="biometricsid" name="biometricsid">

            <table class="table table-bordered">
                <tr>
                    <td>Biometrics ID : &emsp;<b><?=$this->session->userdata('id')?></b></td>
                    <td>File No.: &emsp;<b><?=($user[0]->FileNo)?></b></td>
                </tr>
                <tr>
                    <td>Name : &emsp;<b><?=strtoupper($user[0]->LastName)?>,<?=strtoupper($user[0]->FirstName)?> <?=strtoupper($user[0]->MiddleName)?> </b></td>
                    <td>Date of Employment : &emsp;<b><?=date('F d , Y ',strtotime($user[0]->dateofemploy))?></b> (<?=($user[0]->yearsofservice)?> Year(s) of Service)</td>
                </tr>
                <tr>

                    <td>Classification : &emsp; <b><?=($user[0]->teaching)?'Teaching':'Non-teaching'?></b></td>
                    <td>Position : &emsp; <b><?=($position)?></b></td> 
                </tr>
            </table>      

            <div class="tab-content">
                <div class=" tab-pane active" id="info">
                    <div class="col-md-8">
                        <h2>Personal Information</h2>
                        <table class="table small">
                            <tr>
                                <td>Birthdate :&emsp; <b><?=date('F d , Y ',strtotime($user[0]->birth_date))?></b></td>
                                <td>Age :&emsp; <b><?=($this->theworld->check_val($user[0]->age)) ?></b></td>
                            </tr>
                            <tr>
                                <td>Home Address :&emsp; <b><?=strtoupper($this->theworld->check_val(str_replace('|', ',', $user[0]->home_address)))?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Provincial Address : &emsp; <b><?=strtoupper($this->theworld->check_val(str_replace('|', ',', $user[0]->prov_address)))?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Mobile No :&emsp; <b><?=$this->theworld->check_val($user[0]->mobile_no)?></b>
                                </td>
                                <!--<td>Telephone No :&emsp; <b></b>
                                </td>-->
                            </tr>
                            <tr>
                                <td>Email Address:&emsp; <b><?=$this->theworld->check_val($user[0]->email)?></b></td>
                                <td>Civil Status :&emsp; <b><?=$this->theworld->check_val($user[0]->civil_status)?></b></td>
                            </tr>
                            <tr>
                                <td>Religion :&emsp; <b><?=$this->theworld->check_val($user[0]->religion)?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Sex :&emsp; <b><?=($user[0]->sex)?></b></td>
                                <td></td>
                            </tr>
                         
                        </table>
                        <h2>Educational Background</h2>
                        <table class="table small">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Degree</th>
                                    <th>Year Completed</th>
                                    <th>Units</th>
                                    <th>Name of School and Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bachelor's</td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->bacdeg)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->bacyear)?></b></td>
                                    <td>N/A</td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->bacname)?></b></td>
                                </tr>
                                <tr>
                                    <td>Master's</td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->masdeg)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->masyear)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->masunit)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->masname)?></b></td>
                                </tr>
                                <tr>
                                    <td>Doctorate</td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->docdeg)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->docyear)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->docunit)?></b></td>
                                    <td><b><?=$this->theworld->check_val($user['education'][0]->docname)?></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <h2>Parent's Information</h2>
                        <table class="table small">
                            <tr>
                                <td>Father's Name:<br/>&emsp;<b><?=$this->theworld->check_val($user[0]->fathername)?></b>
                                </td>
                                <td>Father's Occupation:<br/>&emsp;<b><?=$this->theworld->check_val($user[0]->fatheroccup)?></b>
                                </td>
                                <td>Father's Birthdate:<br/>&emsp;<b></b><?=$this->theworld->check_val($user[0]->fatherbday)?></td>
                            </tr>
                            <tr>
                                <td>Mother's Name:<br/>&emsp;<b><?=$this->theworld->check_val($user[0]->mothername)?></b>
                                </td>
                                <td>Mother's Occupation:<br/>&emsp;<b><?=$this->theworld->check_val($user[0]->motheroccup)?></b>
                                </td>
                                <td>Mother's Birthdate:<br/>&emsp;<b><?=$this->theworld->check_val($user[0]->motherbday)?></b></td>
                            </tr>
                            <!-- <tr>
                                    <td>Contact's Name:<br/>&emsp;<b>person_contact_emergency</b></td>
                                    <td>Contact's Address:<br/>&emsp;<b>person_address</b></td>
                                    <td>Contact's Phone No:<br/>&emsp;<b>contact_number</b></td>
                                </tr> -->
                        </table>
                        <h2>Government Issued IDs</h2>
                        <form method="post" action="">
                            <table class="table small" ;>
                                <thead>
                                    <tr>
                                        <th>Tin</th>
                                        <th>SSS</th>
                                        <th>Pagibig</th>
                                        <th>PhilHealth</th>
                                        <th>Peraa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><?=$this->theworld->check_val($user[0]->tin)?></th>
                                        <th><?=$this->theworld->check_val($user[0]->sss)?></th>
                                        <th><?=$this->theworld->check_val($user[0]->pagibig)?></th>
                                        <th><?=$this->theworld->check_val($user[0]->philhealth)?></th>
                                        <th><?=$this->theworld->check_val($user[0]->peraa)?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="col-md-4 well align-center" style="margin-top:5%;">
                        <?php
                                if($user[0]->pic_path!='')
                                    $pic=$user[0]->pic_path;
                                else{
                                        $gender=($user[0]->sex)?$user[0]->sex:'bglogo';
                                        $pic='employee_pic/def/'.$gender.'.png';
                                    }
                        ?>
                       <img class="img-responsive" style="margin:0 auto;" src="<?=ROOT_URL.$pic?>" />
                    </div>
                    <div class="row">
                        <a data-controls-modal="#edit_modal" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                         data-target="#edit_modal" id="<?=$this->session->userdata('id')?>" 
                         class="btn btn-info editinfo" ><i class="glyphicon glyphicon-pencil"></i> Edit </a>
                    </div>
                </div>
                <!--/info-->

                <div class=" tab-pane " id="leave_eligibility">
                    <div class="col-md-12">
                        <!-- <h2>Leave Records</h2> -->
                        <h2>Leave History</h2>
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#Leave" data-toggle="tab">Vacation/Emergency</a></li>
                            <li><a href="#Sick" data-toggle="tab">Sick</a></li>
                            <!--     <li role="presentation" class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"> Others <span class="caret"></span></a>
                                      <ul class="dropdown-menu" role="menu"> -->
                            <li><a href="#Bereavement" id="bre" data-toggle="tab">Bereavement</a></li>
                            <li><a href="#Birth" data-toggle="tab">Birthday</a></li>
                            <li><a href="#Maternity" data-toggle="tab">Maternity</a></li>
                            <li><a href="#SoloParent" data-toggle="tab">Solo Parent</a></li>
                            <li><a href="#Union" data-toggle="tab">Union</a></li>
                            <li><a href="#Magnacarta" data-toggle="tab">Magnacarta</a></li>
                            <li><a href="#Vatica" data-toggle="tab">Sabbatical</a></li>
                            <!--   </ul>
                                </li> -->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="Leave"><br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>
                            <!-- END Leave | Emergency -->

                            <div class="tab-pane fade" id="Sick"><br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>

                            <div class="tab-pane fade" id="Bereavement">
                                <br>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>

                            <div class="tab-pane fade" id="Birth">
                                <br>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>

                            <div class="tab-pane fade" id="Maternity">
                                <br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>

                            <div class="tab-pane fade" id="Paternity">
                                <br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>

                            <div class="tab-pane fade" id="SoloParent">
                                <br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>

                            <div class="tab-pane fade" id="Union">
                                <br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>
                            <div class="tab-pane fade" id="Magnacarta">
                                <br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>
                            <div class="tab-pane fade" id="Vatica">
                                <br/>
                                <td>
                                    <h3>No Record(s) Found.</h3></td>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/leave-->

                <div class=" tab-pane " id="job_history">
                    <div class="col-md-12">
                        <h2>Job History</h2>
                        <table class="table small">
                            No job history. </tbody>
                        </table>
                    </div>
                </div>
                <!--/job-->

                <div class=" tab-pane " id="dep_history">
                    <div class="col-md-12">
                        <h2>Department History</h2>
                        <table class="table small">
                            No department history. </tbody>
                        </table>
                    </div>
                </div>
                <!--/department-->

                <div class=" tab-pane " id="ov_history">
                    <div class="col-md-12">
                        <h2>Overtime History</h2>
                        <table class="table small">
                            No overtime history. </tbody>
                        </table>
                    </div>
                </div>
                <!--/OVERTIME-->

                <div class=" tab-pane " id="travel_history">
                    <div class="col-md-12">
                        <h2>Travel History</h2>
                        <table class="table small">
                            No travel history. </tbody>
                        </table>
                    </div>
                </div>
                <!--/TRAVEL-->

                <div class=" tab-pane " id="payroll">
                    <div class="col-md-12">
                        <h2>Payroll for this semester</h2>
                        <table class="table small">
                            No data for payroll. </tbody>
                        </table>
                    </div>
                </div>
                <!--/department-->


            </div>
            <!--/TAB CONTENT-->
        </div>
        <!--/PANEL BODY-->
    </div>
    <!--/PANEL-->
</div>
<!--/page-wrapper-->

<!--EDIT MODAL-->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form method="post" action="" id="modal_empRecordEdit" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="dentalRecord">Edit Employee Record </h4>
            </div>
            
            <div class="modal-body">
               <div class="edits"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="submit" name="submit_edit_emp" class="btn btn-success">Update</button> -->
                <input type="hidden" value="TRUE" id="add_done" />
            </div>
        </form>
        </div>
    </div>
</div>
<!-- END EDIT MODAL -->