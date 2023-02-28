<?php
    $leavetypelists = ""; 
    if($leavetype_lists){
        foreach($leavetype_lists as $ltl){
            $leavetypelists .= '<option value="'.$ltl->id.'">'.$ltl->type.'</option>';
        }
    }
?>
<style>
     .ui-autocomplete {
        /*z-index: 2147483647;*/
        position:absolute;
        height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .page-header{
        margin-top: 100px;
    }
    .emp_active {
        height: 25px;
        padding: 3px 12px;
        margin-top: -3px;
    }
    .panel-inactive{
        color: #fff;
        background-color: rgb(145, 149, 145);
        border-top: 2px solid rgb(145, 149, 145);
        border-bottom: none;
        border-color: rgb(145, 149, 145);
        padding: 10px 15px;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
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
        <?php if($user[0]->active == 1): ?>
        <div class="panel-heading">
        <?php else: ?>
        <div class="panel-inactive">
        <?php endif; ?>
             Employee Information
            <?php $position = (isset($user['position'][0])?$user['position'][0]->position:'N/A')?>
            <div class="pull-right">
                <select class="form-control emp_active" onchange="$(this).changeActiveStat(this.value);">
                    <option value="1" <?= ($user[0]->active == 1 ? 'selected' : '') ?>>Active</option>
                    <option value="0" <?= ($user[0]->active == 0 ? 'selected' : '') ?>>Inactive</option>
                </select>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <input type="hidden" value="20000" id="teachid" name="studentid">
            <input type="hidden" value="<?= $user[0]->BiometricsID ?>" id="biometricsid" name="biometricsid">
            <input type="hidden" value="<?= $user[0]->FileNo ?>" id="emp_fileno" name="emp_fileno">

            <?php if($user[0]->active == 0): ?>
                <div class="well" style="padding: 0px; margin-bottom: 10px;">
                    <table class="table small" style="margin-bottom: 0px; width: 50%;">
                        <tr>
                            <td width="30%">Reason for Separation:</td>
                            <td><b><?=$user[0]->leavereason?></b></td>
                        </tr>
                        <tr>
                            <td>Last Day:</td>
                            <td><b><?=($user[0]->lastday == '1970-01-01' || $user[0]->lastday == '0000-00-00' ? '' : $user[0]->lastday)?></b></td>
                        </tr>                    
                    </table>
                </div>
            <?php endif; ?>

            <table class="table table-bordered">
                <tr>
                    <td>Biometrics ID : &emsp;<b><?= $user[0]->BiometricsID ?></b></td>
                    <td>File No.: &emsp;<b><?=($user[0]->FileNo)?></b></td>
                </tr>
                <tr>
                    <td>Name : &emsp;<b><?=strtoupper($user[0]->LastName)?>,<?=strtoupper($user[0]->FirstName)?> <?=strtoupper($user[0]->MiddleName)?> </b></td>
                    <td>Date of Employment : &emsp;<b><?=date('F d , Y ',strtotime($user[0]->dateofemploy))?></b> (<?=$user[0]->yearsofservice?>) Year(s) of Service)</td>
                </tr>
                <tr>
                    <td>Classification : &emsp; <b><?=($user[0]->teaching)?'Teaching':'Non-teaching'?></b></td>
                    <td>Position : &emsp; <b><?=($position)?></b></td> 
                </tr>
            </table>   

            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#info" data-toggle="tab">Personal Info</a>
                </li>
                <li>
                    <a href="#job_history" data-toggle="tab">Employment Info</a>
                </li>
                <li>
                    <a href="#leave_eligibility" data-toggle="tab">Leave Info</a>
                </li>
                <li>
                    <a href="#ov_history" data-toggle="tab">Overtime Info</a>
                </li>
                <li>
                    <a href="#pass_history" data-toggle="tab">Pass Slip Info</a>
                </li>
                <li>
                    <a href="#travel_history" data-toggle="tab">Travel Info</a>
                </li>
            </ul>   

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
                                <td>Birth Place :&emsp; <b><?=$user[0]->birth_place?></b></td>
                                <td></td>
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
                                <td>Telephone No :&emsp; <b><?=$this->theworld->check_val($user[0]->landline_no)?></b></b>
                                </td>
                            </tr>
                            <tr>
                                <td>Religion :&emsp; <b><?=$this->theworld->check_val($user[0]->religion)?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Sex :&emsp; <b><?=($user[0]->sex)?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Email Address:&emsp; <b><?=$this->theworld->check_val($user[0]->email)?></b></td>
                                <td>Civil Status :&emsp; <b><?=$this->theworld->check_val($user[0]->civil_status)?></b></td>
                            </tr>
                            <tr>
                                <td><strong>IF Married:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><span style="margin-left: 20px; ">Name of Spouse :  &emsp;</span> <b><?=$this->theworld->check_val($user[0]->spousename)?> </b> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><span style="margin-left: 20px; ">Occupation :  &emsp;</span> <b><?=$this->theworld->check_val($user[0]->spouseoccup)?> </b> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><span style="margin-left: 20px; ">Address :  &emsp;</span> <b><?=$this->theworld->check_val($user[0]->spouseaddr)?> </b> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><span style="margin-left: 20px; ">Contact Numbers :  &emsp;</span> <b><?=$this->theworld->check_val($user[0]->spouseno)?> </b> </td>
                                <td></td>
                            </tr>
                        </table>
                        <strong>Dependents:</strong>
                        <table class="table small">
                            <?php if ($dependents): ?>   
                                <thead>
                                    <tr>
                                        <td>Name of Dependent</td>
                                        <td>Date of Birth</td>
                                        <td>Relationship</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($dependents as $value): ?>
                                    <tr>
                                        <td><?= $value->depname ?></td>
                                        <td><?= date('j F Y', strtotime($value->datebirth)) ?></td>
                                        <td><?= $value->relation ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            <?php else: ?>
                                <tr>
                                    <td><span style="margin-left: 20px; ">Dependents :  &emsp;</span> <b>None</b> </td>
                                    <td></td>
                                </tr>
                            <?php endif ?>
                        </table>
                        <strong>Person To Contact In Case of Emeregency:</strong>
                        <table class="table small">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Address</td>
                                        <td>Conact No.</td>
                                        <td>Relationship</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$this->theworld->check_val($user[0]->person_contact_emergency)?></td>
                                        <td><?=$this->theworld->check_val($user[0]->person_address)?></td>
                                        <td><?=$this->theworld->check_val($user[0]->contact_number)?></td>
                                        <td><?=$this->theworld->check_val($user[0]->relation_person)?></td>
                                    </tr>
                                </tbody>
                        </table>
                        <div class="row">
                            <h2 class="col-md-10">Educational Background </h2>
                            <!-- <a  data-toggle="modal" data-target="#edit_educational_background" id="<?=$this->session->userdata('id')?>" class="btn btn-info editinfo col-sm-1" style="padding: 0px; margin-top: 40px"><i class="glyphicon glyphicon-pencil"></i> Edit</a> -->
                        </div>
                        <table class="table small">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Degree</th>
                                    <th>Status</th>
                                    <th>Units</th>
                                    <th>Name of School and Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php foreach ($user_education as $value): ?>
                                <tr>
                                    <td><?= $value->type ?> </td>
                                    <td><b><?= $value->degree ?></b></td>
                                    <td><b><?= $value->status ?></b></td>
                                    <td><b><?= $value->remarks ?></b></td>
                                    <td><b><?= $value->school_address ?></b></td>
                                
                                </tr>
                            <?php endforeach; ?>
                                
<!--                                 <tr>
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
                                </tr> -->
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
                        <h3>Eligibilities or Licensure Examination</h3>
                        <form method="post" action="">
                            <table class="table small">
                                <thead>
                                    <tr>
                                        <th>Type of Eligibilities</th>
                                        <th>Date of Examination</th>
                                        <th>Licensure No.</th>
                                        <th>Rate / Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($eligibilities): ?>
                                    <?php foreach ($eligibilities as $value): ?>
                                    <tr>
                                        <th><?= $value->eligname ?></th>
                                        <th><?= $value->eligdate ?></th>
                                        <th><?= $value->passingno ?></th>
                                        <th><?= $value->grade ?></th>
                                    </tr>
                                     <?php endforeach; ?>
                                 <?php endif; ?>
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

                                if ($profile_image) {
                                    $pic = base_url().$profile_image[0]->file_path;
                                } else {
                                    $pic = base_url().'assets/employee_pic/def/'.$gender.'.png';
                                }
                               
                            }
                        ?>
                        <input style="display: none;" id="upload_profile_image" name="upload_profile_image" type="file"/>
                        <a href="" id="upload_link"><img class="img-responsive" style="margin:0 auto;" src="<?=$pic?>" /></a>
                    </div>

                    <div class="row">
                        <a  data-toggle="modal" data-target="#edit_profile" id="<?= $user[0]->BiometricsID ?>" class="btn btn-info editinfo" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>

                        <!-- <a class="btn btn-primary btn-sm" target="_blank" href="<?=base_url('/profile/employee_profile_pdf/'.$user[0]->FileNo.'')?>"><i class="glyphicon glyphicon-save"></i> Download PDF</a> -->
                        <a class="btn btn-primary btn-sm" target="_blank" href="<?=ROOT_URL?>/HRstaff_PDF.php?id=<?= $user[0]->BiometricsID ?>"><i class="glyphicon glyphicon-print"></i> Download PDF</a>

                    </div>
                </div>
                <!--/info-->
                   <div class=" tab-pane " id="job_history">
                    <div class=" tab-pane " id="job_history">
                    <div class="col-md-12">
                        <h2>Employment Information</h2>
                        <table class="table small">
                             <tr>
                                <td>Department : &emsp; <b><?=$this->theworld->check_val($user[0]->DEPTNAME)?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Employment Status :&emsp; <b><?=($this->theworld->check_val($user[0]->emp_status))?></b></td>
                                <td>End of Contract :&emsp; <b><?=($this->theworld->check_val($user[0]->end_of_contract)) ?></b></td>
                            </tr>
                             <tr>
                                <td>Nature of Employment :&emsp; <b><?=($this->theworld->check_val($user[0]->nature_emp))?></b></td>
                                <td>Union/Ununion :&emsp; <b><?= (($this->theworld->check_val($user[0]->isUnion)) == 0 ? 'Ununion' : 'Union') ?></b></td>
                            </tr>
                        </table>

                         <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#add_appointment_history" id="<?= $user[0]->FileNo ?>"><i class="glyphicon glyphicon-plus"></i> Add Appointment History</a>

                        <h2>Job Position History</h2>
                        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#job_history_modal" id="<?= $user[0]->FileNo ?>"><i class="glyphicon glyphicon-plus"></i> Add Record</a>

                        <table class="table table-bordered small">
                            <thead>
                                 <tr>
                                    <th></th>
                                    <th>Nature of Employment</th>
                                    <th>Employment Status</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Remarks</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <?php if($job_history): ?>
                                    <?php foreach($job_history as $key=>$jobh):  ?>
                                         <tr>
                                             <td><?= ($key+1) ?></td>
                                             <td><?= $jobh->nature_employment ?></td> <!-- NATURE -->
                                             <td><?= $jobh->employment_stat ?></td> <!-- STATUS -->
                                             <td><?= $jobh->positiontitle ?></td>
                                             <td><?= $jobh->deptname ?></td>
                                             <td><?=date('F d , Y ',strtotime($jobh->date_from))?></td>
                                             <td><?=date('F d , Y ',strtotime($jobh->date_to))?></td>
                                             <td><?= $jobh->remarks ?></td>
                                         </tr>       
                                    <?php endforeach; ?>
                                <?php else: ?>
                                        <tr>
                                            <td colspan="5">No data.</td>
                                        </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <h2>Appointment History</h2>
                        <table class="table table-bordered small">
                            <thead>
                                 <tr>
                                    <th></th>
                                    <th>Appointment</th>
                                    <th>From</th>
                                    <th>To</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <?php if($appointmnt): ?>
                                    <?php foreach($appointmnt as $key=>$job):  ?>
                                         <tr>
                                             <td><?= ($key+1) ?></td>
                                             <td><?= $this->theworld->check_val($job->app) ?></td>
                                             <td><?=date('F d , Y ',strtotime($job->appfrom))?></td>
                                             <td><?=date('F d , Y ',strtotime($job->appto))?></td>
                                         </tr>       
                                    <?php endforeach; ?>
                                <?php else: ?>
                                        <tr>
                                            <td colspan="5">No data.</td>
                                        </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>


                        <h2>Service Record</h2>
                        <table class="table table-bordered small">
                            <thead>
                                 <tr>
                                    <th></th>
                                    <th>Position/ Appointment</th>
                                    <th>Department</th>
                                    <th>Nature of Employment</th>
                                    <th>Employment Status</th>
                                    <th>From</th>
                                    <th>To</th>
                                 </tr>
                            </thead>
                            <tbody>
                                 <?php if($service_record): ?>
                                    <?php foreach($service_record as $key=>$sr):  ?>
                                         <tr>
                                             <td><?= ($key+1) ?></td>
                                             <td><?=  ($sr->position) ?></td>
                                             <td><?=  ($sr->DEPTNAME)?></td>
                                             <td><?=  ($sr->nature_employment) ?></td>
                                             <td><?=  ($sr->employment_stat) ?></td>
                                             <td><?=date('F d , Y ',strtotime($sr->date_from))?></td>
                                             <td><?=date('F d , Y ',strtotime($sr->date_to))?></td>
                                         </tr>       
                                    <?php endforeach; ?>
                                <?php else: ?>
                                        <tr>
                                            <td colspan="5">No data.</td>
                                        </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#" id="<?= $user[0]->FileNo ?>"><i class="glyphicon glyphicon-print"></i> Print Service Record</a>

                        <!-- <h2>Department History</h2>
                        <a class="btn btn-primary btn-xs" target="_blank" ><i class="glyphicon glyphicon-plus"></i> Add Department</a>

                        <table class="table table-bordered small">
                            <thead>
                                 <tr>
                                    <th></th>
                                    <th>Department</th>
                                    <th>From</th>
                                    <th>To</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <?php if($dept_history): ?>
                                    <?php foreach($dept_history as $key=>$depth):  ?>
                                         <tr>
                                             <td><?= ($key+1) ?></td>
                                             <td><?= $this->theworld->check_val($depth->DEPTNAME) ?></td>
                                             <td><?=date('F d , Y ',strtotime($depth->depfrom))?></td>
                                             <td><?=date('F d , Y ',strtotime($depth->depto))?></td>
                                         </tr>       
                                    <?php endforeach; ?>
                                <?php else: ?>
                                        <tr>
                                            <td colspan="4">No data.</td>
                                        </tr>
                                <?php endif; ?>
                            </tbody>
                        </table> -->



                    </div>


                </div>
                </div>
                <!--/job-->

                <div class=" tab-pane " id="leave_eligibility">
                    <div class="col-md-12"><br>
                        <!-- <h2>Employee Leave Information</h2> -->
                        <div class="row col-md-12">
                            <label class="col-md-2">Leave Type:</label>
                            <div class="col-md-5">
                                <select id="" class="form-control" onchange="$(this).get_leave_type_record(this.value);">
                                    <option value="">All</option>
                                    <?=$leavetypelists?>
                                </select>
                            </div>

                            <div class='col-md-3'>
                                <?php if($service_credit):?>
                                    <!-- <?=($service_credit[0]->date_added) <= date('Y-m-d',strtotime($service_credit[0]->date_added."+ 1 days")) ? "<span style='color:red;'>*</span>Employee has been given 1.25 credits for anoher year of service." : ""?>  -->
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="row col-md-12" style="margin-top: 20px;">
                            <legend>Leave Records</legend>
                            <table class="table table-bordered small display responsive" width="100%" id="tbl_leave_records">
                                <thead>
                                    <th></th>
                                    <th></th>
                                    <th>Leave Type</th>
                                    <th>Leave Date From</th>
                                    <th>Leave Date To</th>
                                    <th>No. of Days</th>
                                    <th>Reason</th>
                                    <th>Dean Remarks</th>
                                    <th>Days With Pay</th>
                                    <th>Days Without Pay</th>
                                    <th>HR Comment</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="row col-md-12" style="margin-top: 20px;">
                            <legend>Leave Credits</legend>
                            <?php if($this->session->userdata('role') == 7): ?>
                                <div class="col-md-2 pull-right" style="margin-bottom: 20px;">
                                    <a data-controls-modal="#edit_leave" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#edit_leave"  class="btn btn-info pull-right"><i class="glyphicon glyphicon-pencil"></i> Add Leave Credit </a>
                                </div>
                            <?php endif; ?>
                            <table class="table table-bordered small display responsive" width="100%" id="tbl_leave_records">
                                <thead>
                                    <th>Leave Type</th>
                                    <th>Leave Credits</th>
                                    <th>Used Leave</th>
                                    <th>Leave Balance</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php if(!empty($leave_balances)): ?>
                                       <?php for($i=0; $i<count($leave_balances); $i++){ ?>
                                        <tr>
                                            <td><?=$leave_balances[$i]['leave_type']?></td>
                                            <td><?=$leave_balances[$i]['leave_credit']?></td>
                                            <td><?=$leave_balances[$i]['leave_used']?></td>
                                            <td><?=$leave_balances[$i]['leave_bal']?></td>
                                            <td>
                                                <a class="btn btn-success btn-xs viewlog" data-empid="<?=$user[0]->FileNo?>" data-leave_type="<?=$leave_balances[$i]['leave_type_id']?>"><i class="fa fa-search"></i> View Log </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">No leave credits yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                     <!--<div class="row">
                            <a href="../employee_leave_form" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Add Leave Requests </a>
                        </div> -->
                    </div>
                </div>
                <!--/leave-->

                <div class=" tab-pane " id="ov_history">
                    <div class="col-md-12">
                        <h2>Overtime History</h2>
                        <div class="row col-md-12">
                            <label class="col-md-2">Leave Type:</label>
                            <div class="col-md-5">
                            <!--     <select id="" class="form-control" onchange="">
                                    <option value="">All</option>
                                   
                                </select> -->
                            </div>
                        </div>
                        <table class="table small display responsive" width="100%" id="tbl_overtime_records">
                             <thead>
                                    <th>Reason</th>
                                    <th>Time From</th>
                                    <th>Time To</th>
                                    <th>Numbers of Hours</th>
                                    <th>Remarks</th>
                                </thead>

                            <tbody></tbody>
                        </table>
                       <!--  <div class="row">
                            <a href="../employee_overtime_form" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Add Overtime Requests </a>
                        </div> -->
                    </div>
                </div>
                <!--/OVERTIME-->

                <div class=" tab-pane " id="travel_history">
                    <div class="col-md-12">
                        <h2>Travel History</h2>
                        
                        <div class="row col-md-12" style="margin-top: 20px;">
                             <table class="table table-bordered small" width="100%" id="tbl_travel_history">
                                <thead>
                                    <th>Date</th>
                                    <th>Destination</th>
                                    <th>Purpose</th>
                                    <th>Dates of Travel</th>
                                    <th>Remarks</th>
                                    <th>Date Accepted/Declined</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                       <!--  <div class="row">
                            <a href="../employee_travel_order_form" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Add Travel Form </a>
                        </div> -->
                    </div>
                </div>
                <!--/TRAVEL-->


                <div class=" tab-pane " id="pass_history">
                    <div class="col-md-12">
                        <h2>Pass Slip Info</h2>
                        
                        <div class="row col-md-12" style="margin-top: 20px;">
                             <table class="table table-bordered small" width="100%" id="tbl_pass_slip">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Purpose</th>
                                        <th>Time From</th>
                                        <th>Time To</th>
                                        <th>Number of Hours</th>
                                        <th>Date Head Approved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                       <!--  <div class="row">
                            <a href="../employee_passslip_form" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Add Pass Slip </a>
                        </div> -->
                    </div>
                </div>
                <!-- PASS SLIP RECORDS -->

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


