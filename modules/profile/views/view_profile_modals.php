<!--EDIT PROFILE MODAL-->
<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" data-backdrop="static">
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
                <input type="hidden" value="TRUE" id="add_done"/>
            </div>
        </form>
        </div>
    </div>
</div>


<!--APPOINTMENT HISTORY MODAL-->
<div class="modal fade" id="add_appointment_history" tabindex="-1" role="dialog" aria-labelledby="appointment_history" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Add Appointment History Record</h4>
            </div>
            <form method="post" action="<?=base_url('employee_appointment_record')?>">
                <div class="modal-body form-horizontal">
                    <div class="form-group">
                            <input type="hidden" name="fileno" value="<?=$user[0]->FileNo?>">
                            <div class="col-md-9">
                                <table id="appointment_history" class="table">
                                    <tr>
                                    <td>
                                        <input type="text" name="apps[]" placeholder="Appointment" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="from[]" placeholder="From" class="form-control datepicker"/>
                                    </td>
                                    <td>
                                        <input type="text" name="to[]" placeholder="To" class="form-control datepicker"/>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" id="morecol"><i class="fa fa-plus"></i></button>
                                    </td></tr>
                                </table>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- JOB HISTORY MODAL -->
<div class="modal fade" id="job_history_modal" tabindex="-1" role="dialog" aria-labelledby="job_history" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Add Job History Record</h4>
            </div>
            <form method="post" action="<?=base_url('employee_job_position_record')?>">
                <div class="modal-body form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Department:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="department">
                                        <option></option>
                                        <?php 
                                            foreach($dept_names as $dp){
                                                echo '<option value="'.$dp->DEPTID.'">'.$dp->DEPTNAME.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" name="fileno" value="<?=$user[0]->FileNo?>">
                                </div>
                            </div>

                            <!-- NATURE -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nature of Employment:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="nature_emp">
                                        <option></option>
                                        <option value="Part-Time">Part-Time</option>
                                        <option value="Full-Time">Full Time</option>
                                    </select>
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Employment Status:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="emp_status">
                                        <option></option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Casual">Casual</option>
                                        <option value="Contractual">Contract of Service</option>
                                        <option value="Job Order">Job Order</option>
                                        <option value="Consultant">Consultant</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label">Position:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="position">
                                        <option></option>
                                        <?php 
                                            foreach($position as $pos){
                                                echo '<option value="'.$pos->id.'">'.$pos->position.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date From:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control datepicker" name="date_from" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date To:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control datepicker" name="date_to" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Remarks:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control" name="remarks" type="text" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- JOB HISTORY MODAL -->

<!-- EMPLOYEE SEPARATION -->
<div class="modal fade" id="employee_separation_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Employee Separation</h4>
            </div>
          
            <form method="post" action="<?=base_url('update_employee_active_status')?>">
                <div class="modal-body form-horizontal employee_stat">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Employee Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status" id="emp_status">
                                <option value="1" <?= ($user[0]->active == 1 ? 'selected' : '') ?>>Active</option>
                                <option value="0" <?= ($user[0]->active == 0 ? 'selected' : '') ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Reason of Separation from the Institution</label>
                        <div class="col-sm-9">
                            <select name="reasonforseparation" class="form-control" id="empreasonforseparation">
                                <option value=""></option>
                                <option value="awol">AWOL</option>
                                <option value="early retirement">Early Retirement</option>
                                <option value="end of contract">End of Contract</option>
                                <option value="mandatory retirement">Mandatory Retirement</option>
                                <option value="resignation">Resignation</option>
                                <option value="retrenchment">Retrenchment</option>
                                <option value="termination">Termination</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Last Day in the Institution</label>
                        <div class="col-sm-9">
                           <input type="text"  name="lastday" value="" class="form-control datepicker" id="emp_lastday" />
                           <input type="hidden" name="fileno" value="<?=$user[0]->FileNo?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="newleave" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LEAVE MODAL -->
<div class="modal fade" id="view_leave_log" tabindex="-1" role="dialog" aria-labelledby="view_leave_log" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">View Leave Credit Log</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <table width='100%' class="table table-bordered" id='leave_credit_log'>
                            <thead>
                                <tr>
                                    <th>Date Added</th>
                                    <th>Leave Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--/LEAVE MODAL-->
<!-- END EDIT MODAL -->

<!-- EDIT LEAVE RECORD -->
<!-- <div class="modal fade" id="editleave" tabindex="-1" role="dialog" aria-labelledby="editleave" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="update_leave_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="">Edit Leave Information</h4>
                </div>
                <div class="modal-body form-horizontal">
                    <div class="panel panel-default">
                        <div class="panel-heading">I. Dates of Leave</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">From:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control datepicker class1" type="text" id="fromdate" name="leavefrom" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">To:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control datepicker class1" type="text" id="todate" name="leaveto" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label actual1">Available Days:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control class1" readonly id="availabledays" name="available" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Perceived Number of Days:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control" type="text" readonly id="numdays" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">II. Number of Days</div>
                        <div class="panel-body">
                            <div class="form-group vacleave">
                                <label class="col-sm-4 control-label">Vacation Leave(s) Available:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control class1 inputvac" type="text" id="availvac" name="availablevacleave" readonly/>
                                </div>
                            </div>
                            <div class="form-group vacleave">
                                <label class="col-sm-4 control-label">Days Deducted From Vacation Leave:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control class1 inputvac" type="number" min="0.25" step="0.001" onkeyup="$(this).show_alert();" id="vacl" name="vacl" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Actual Number of Days:</label>
                                <div class="col-sm-8">
                                    <input  class="form-control class1" type="number" id="numdays2" step="0.0001" min="0.25" onkeyup="$(this).show_error();;" name="numdays" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">III. Remarks</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Remarks:</label>
                                <div class="col-sm-8">
                                    <input style="text-transform:none" class="form-control" type="text" name="remark" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Days With Pay:</label>
                                <div class="col-sm-8">
                                    <input style="text-transform:none" class="form-control haspay" type="number" step="0.001" id="withpay" name="dayswithpay" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Days Without Pay:</label>
                                <div class="col-sm-8">
                                    <input style="text-transform:none" class="form-control haspay" type="number" step="0.001" id="withoutpay" name="dayswithoutpay" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message"></div>
                </div>
            
                <input type="hidden" name="lid" id="lid" value="" />
                <input type="hidden" name="vacid" id="vacid"/>
                <input type="hidden" id="empid" name="empid"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="$(this).update_leave_record();" name="updateleave" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>  -->
<div class="modal fade" id="editleave" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" >Update Leave Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employee_leave_application')?>">
                <div class="modal-body form-horizontal update_leave_data">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" readonly="" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <input  class="form-control" name="leave_id"  id="leave_id" type="hidden" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">File No:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="employee_fileno" id="employee_fileno" type="text" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="employee_department" id="employee_department" type="text" readonly />
                            </div>
                        </div>
                        <input type="hidden" name="leaveid" id="leaveid"/>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Position:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" id="employee_position" name="employee_position" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="panel panel-default">
                    <div class="panel-heading">Leave Information</div>
                    <div class="panel-body">
                      <!--   <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8" id="div_leave">
                                <select name="leavetype" id="leavetype" class="form-control" required>
                                 <option value=""></option>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <select name="leavetype" id="leavetype" class="form-control">
                                    <option value=""></option>
                                    <?php foreach($leave_credits as $lc): ?>
                                        <option value="<?=$lc->type?>"><?=$lc->type?></option>
                                        <?php if($lc->type_id == 1): ?>
                                         <!-- <option value="11">Emergency</option> -->
                                        <?php endif; ?>
                                    <?php endforeach; ?>
<!--                                     <option value="Sick">Sick</option>
                                    <option value="Vacation/Emergency">Vacation/Emergency</option> -->
                                </select>
                                <input  class="form-control" id="leave_type_id" name="leavetype" type="hidden" readonly /> 
                                <input  class="form-control" name="leave_id"  id="leave_id" type="hidden" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Entitled Days:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="daysavailable" name="daysavailable" type="text" readonly />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">From:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date fromdate" type="text" min="0" max="" name="fromdate" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date todate" type="text" min="0" max=""  name="todate" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Actual Number of Days:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0.25" max="" step="0.001" id="actualdays" onkeyup="showAlert();" name="actualdays" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="reason" id="reason" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Day/s with Pay:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max="" step="0.001" id="dayswithpay" onkeyup="showAlert();" name="dayswithpay" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Days without Pay:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max="" step="0.001" id="dayswitouthpay" onkeyup="showAlert();" name="dayswitouthpay" required/>
                            </div>
                        </div>
                           <div class="form-group">
                            <label class="col-sm-3 control-label">Date Filed:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text" id="datefiled" name="datefiled" required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" name="remarks" id="remarks" />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Leave Status:</label>
                            <div class="col-sm-8">
                                <select name="leave_status" id="leave_status" class="form-control">
                                    <option></option>
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declines</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" id="date_approve_decline" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="dept_remarks" id="dept_remarks" type="text" />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
       
                <div class="form-control hidden message1" style="border:0"></div>
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php if($this->session->userdata('role') == 7): ?>
                    <button type="submit" name="newleave" class="btn btn-success">Save</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /EDIT LEAVE RECORD -->


<!-- LEAVE MODAL -->
<div class="modal fade" id="edit_leave" tabindex="-1" role="dialog" aria-labelledby="edit_leave" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Add Leave Credit</h4>
            </div>
            <form method="post" action="<?=base_url('employee_add_leave_credit')?>">
                <div class="modal-body form-horizontal">
                    <input type="hidden" name="employee_id" value="<?=$user[0]->FileNo?>">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table width='100%' class="table table-bordered" id='morevac'>
                                <thead>
                                    <tr>
                                        <th>Type of Leave</th>
                                        <th>Leave Credit</th>
                                        <th><button type="button" class="btn btn-success btn-xs" id="modmorevac"><i class="fa fa-plus"></i> Add</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- 
                                    LIST ALL LEAVE CREDITS
                                    LIST ALL LEAVE TYPES - for select options
                                    tbl: pcc_leave
                                    tbl: pcc_leave_types 
                                 -->
                                <?php
                                    $leavetypelists = ""; 
                                    if($leavetype_lists){   
                                        foreach($leavetype_lists as $ltl){
                                            $leavetypelists .= '<option value="'.$ltl->id.'">'.$ltl->type.'</option>';
                                        }
                                    }
                                ?>
                                <?php if(!empty($leave_credits)): ?>
                                   
                                       <?php for($i=0; $i<count($leave_credits); $i++){ ?>
                                        <tr>
                                             <td>
                                                <select name="leave_type[]" step="0.001" class="form-control">
                                                    <option value="<?=$leave_credits[$i]->type_id?>"><?=$leave_credits[$i]->type?></option>
                                                    <?= $leavetypelists ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="0.001" id="vacleave"  value="<?=$leave_credits[$i]->leave_credit?>" min="0" name="leave_credit[]" class="form-control"/>
                                                <input type="hidden" name="leave_id[]" value="<?=$leave_credits[$i]->id?>"/>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-xs" id="lesscol"><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                <?php else: ?>
                                    <tr>
                                         <td width="39.5%">
                                                <select name="leave_type[]" id="leave0" required class="form-control" required>
                                                    <option value=""></option>
                                                    <?= $leavetypelists ?>
                                                </select>
                                                <input type="hidden" name="leave_id[]" value="0"/>
                                            </td>
                                            <td>
                                                <input type="number" id="vacleave0"  required step="0.001" min="0" name="leave_credit[]" required class="form-control"/>
                                            </td>
                                            <td width="5%"></td>
                                    </tr>
                                <?php endif; ?>
                              </tbody>
                            </table>
                        
    
                    </div></div>
                <input type="hidden" name="leid" id="leid"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="leaverecord" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/LEAVE MODAL-->



<!-- PASS SLIP MODAL -->
<div class="modal fade" id="newpasslip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Pass Slip Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees/add_pass_slip_application')?>">
                <div class="modal-body form-horizontal add_pass_slip">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <select name="pass_slip_type" id="pass_slip_type" class="form-control">
                                    <option value="personal">Personal</option>
                                    <option value="official">Official Bussiness</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date pass_slip_date" type="text" min="0" max="" name="pass_slip_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Destination:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" min="0" max="" name="destination" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Purpose:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="purpose" id="reason" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time Out:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time fromtime" type="text" name="from" onblur="$(this).getTotalHours('add_pass_slip');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time of Return:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time totime" type="text" name="to" onblur="$(this).getTotalHours('add_pass_slip');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Hours:</label>
                            <div class="col-sm-8">
                                <input  class="form-control numhours" type="text" min="0" max="" name="numhours" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div>
       
                <div class="form-control hidden message1" style="border:0"></div>
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="newleave" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="updatepayslip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Update Pass Slip Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees/add_pass_slip_application')?>">
                <div class="modal-body form-horizontal update_pass_slip">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <select name="pass_slip_type" id="pass_slip_type" class="form-control">
                                    <option value="personal">Personal</option>
                                    <option value="official">Official Bussiness</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date pass_slip_date" type="text" min="0" max="" name="pass_slip_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Destination:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" min="0" max="" name="destination" id="destination"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Purpose:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="purpose" id="reason" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time Out:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time timeout" type="text" name="from" onblur="$(this).getTotalHours('add_pass_slip');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time of Return:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time timereturn" type="text" name="to" onblur="$(this).getTotalHours('add_pass_slip');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Hours:</label>
                            <div class="col-sm-8">
                                <input  class="form-control numhours" type="text" min="0" max="" name="numhours" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div>
       
                <div class="form-control hidden message1" style="border:0"></div>
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="newpasslip" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- //PASS SLIP MODAL -->
