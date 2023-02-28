<style>
      .s-search-results a
        {
            cursor: pointer;
        }
        .s-search-results
        {
            position: absolute;
            z-index: 1000;
            width: 80%;
        }
        .ui-timepicker-list{
            z-index: 2147483647;
            position:absolute;
        }
</style>
<div class="modal fade" id="newleave" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Leave Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employee_leave_application ')?>">
                <div class="modal-body form-horizontal add_leave">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8" id="div_leave">
                                <select name="leavetype" id="leavetype" class="form-control" required>
                                 <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group hide_div">
                            <label class="col-sm-3 control-label">Maternity Type: </label>
                            <div class="col-sm-8">
                                <select name="maternitytype" id="maternitytype" class="form-control" required>
                                 <option value="normal">Normal Type</option>
                                 <option value="caesarian">Caesarian</option>
                                </select>
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
                                <input  class="form-control date" type="text" id="" name="datefiled" required />
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
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="dept_remarks" type="text" />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
       
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

<div class="modal fade" id="updateleave" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <select name="leavetype" id="leave_type" class="form-control" readonly disabled="disabled">
                                    <option value=""></option>
                                </select>
                                <input  class="form-control" id="leave_type_id" name="leavetype" type="hidden" readonly /> 
                                <input  class="form-control" name="leave_id"  id="leave_id" type="hidden" readonly />
                            </div>
                        </div>
                        <div class="form-group hide_div">
                            <label class="col-sm-3 control-label">Maternity Type: </label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="maternitytype"  id="maternitytype" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Entitled Days:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="daysavailable" name="daysavailable" type="text" readonly />
                            </div>
                        </div>
                              <div class="form-group">
                            <label class="col-sm-3 control-label">Date Filed:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text" id="datefiled" name="datefiled" required />
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
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Leave Status:</label>
                            <div class="col-sm-8">
                                <select name="leave_status" id="leave_status" class="form-control">
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
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
                  </div>
                  <!-- PANEL BODY -->
                </div>
                <!-- PANEL -->

                 <div class="panel panel-default">
                    <div class="panel-heading">HR</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Day/s with Pay:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max="" step="0.001" id="dayswithpay" name="dayswithpay" required/>
                                <span class="error_message" style="color: red;"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Days without Pay:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max="" step="0.001" id="dayswitouthpay" name="dayswitouthpay" required/>
                                <span class="error_message2" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" name="remarks" id="remarks" />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
       
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

<!-- <div class="modal fade" id="deleteLeaveRecord" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header panel-heading" >
                <h3>Delete Leave records</h3>
            </div>

            <form class="form-horizon" action="POST" name="deleteLeaveRecord">
              <div class="modal-body">
                  Are you sure to Delete this Leave Reocrd
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <a href="<?php echo base_url(); ?>hris/employees/delete_leave" type="submit" name="del-leave" class="btn btn-danger" id="sendButton">Delete</a>
              </div>
            </form>
        </div>
    </div>
</div> -->


<!-- <div class="modal fade" id="deleteLeaveRecord" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"> Delete Leave Records</div>
        <form class="form-horizon" action="" method="POST" name="deleteLeaveRecord">
             <div class="modal-body">
                Do you want to delete this Leave Records?
             </div><br>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger" id="sendButton">Delete</button>
                </div>
        </form>
    </div>
  </div>
</div> -->




<div class="modal fade" id="newovetime" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Overtime Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_overtime_application')?>">
                <div class="modal-body form-horizontal add_overtime">
                <?php if($this->session->userdata('role') == 7): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                    <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                    <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                    <input name="hr_approval"  type="hidden" value='true'/>
                                    <div id="name_seach" class="s-search-results name_seach"></div>
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
                <?php else: ?>
                    <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value="<?=$this->session->userdata('fileno')?>" readonly/>
                    <input name="hr_approval"  type="hidden" value='true'/>
                <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Overtime Information</div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time From:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time fromtime" type="text" name="fromtime" onblur="$(this).getTotalHours('add_overtime');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time totime" type="text" name="totime" onblur="$(this).getTotalHours('add_overtime');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Hours:</label>
                            <div class="col-sm-8">
                                <input  class="form-control numhours" type="text" min="0" max="" name="numhours" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="reason" id="reason" cols="30" rows="3" required=""></textarea>
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
                <?php if($this->session->userdata('role') == 7): ?>

                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date overtime_date" type="text" min="0" max="" name="overtime_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Status:</label>
                            <div class="col-sm-8">
                                <select name="dept_head_approval" id="dept_head_approval" class="form-control">
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                   <!--      <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="dept_remarks" type="text" />
                            </div>
                        </div> -->
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                    <?php endif; ?>
       
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

<div class="modal fade" id="updateovertime" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Update Overtime Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_overtime_application')?>">
                <div class="modal-body form-horizontal update_overtime">
                <?php if($this->session->userdata('role') == 7): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <input name="hr_approval"  type="hidden" value='true'/>
                                <div id="name_seach" class="s-search-results name_seach"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">File No:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="employee_fileno" id="employee_fileno" type="text" readonly />
                                 <input  class="form-control" name="overt_id"  id="overt_id" type="hidden" readonly />
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
                <?php else: ?>
                    <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value="<?=$this->session->userdata('fileno')?>" readonly/>
                    <input name="hr_approval"  type="hidden" value='true'/>
                    <input  class="form-control" name="overt_id"  id="overt_id" type="hidden" readonly />
                <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Overtime Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date overtime_date" type="text" min="0" max="" name="overtime_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time From:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time fromtime" type="text" name="fromtime" onblur="$(this).getTotalHours('update_overtime');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time totime" type="text" name="totime" onblur="$(this).getTotalHours('update_overtime');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Hours:</label>
                            <div class="col-sm-8">
                                <!-- <input  class="form-control numhours" type="text" min="0.01" max="" name="numhours" readonly /> -->
                                <input  class="form-control numhours" type="text" name="numhours" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="reason" id="reason" cols="30" rows="3" required=""></textarea>
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
                <?php if($this->session->userdata('role') == 7): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date overtime_date" type="text" min="0" max="" name="overtime_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Status:</label>
                            <div class="col-sm-8">
                                <select name="dept_head_approval" id="dept_head_approval" class="form-control">
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" id="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="panel panel-default">
                    <div class="panel-heading">HR</div>
                    <div class="panel-body">
                       <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" name="remarks" id="remarks" />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <?php endif; ?>
       
                <div class="form-control hidden message1" style="border:0"></div>
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="newovetime" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="newpasslip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Pass Slip Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_pass_slip_application')?>">
                <input name="hr_approval"  type="hidden" value='true'/>
                <div class="modal-body form-horizontal add_pass_slip">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>

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
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <select name="pass_slip_type" id="pass_slip_type" class="form-control" disabled="disabled" readonly>
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
                      
                    </div><!-- PANEL BODY -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pass Slip Status:</label>
                            <div class="col-sm-8">
                                <select name="overtime_status" id="overtime_status" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="panel panel-default" style="display: none;">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pass Slip Status:</label>
                            <div class="col-sm-8">
                                <select name="overtime_status" id="overtime_status" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->

                <div class="panel panel-default">
                    <div class="panel-heading">Time Information</div>
                    <div class="panel-body">
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
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label">Undertime:</label>
                            <div class="col-sm-8">
                                <input  class="form-control undertime" type="number" min="0" max="" step='0.5' name="undertime" />
                            </div>
                        </div>
                    </div>
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
          
            <form method="post" action="<?=base_url('employees_pass_slip_application')?>">
                <div class="modal-body form-horizontal update_pass_slip">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <input name="pass_slip_id"  id="pass_slip_id" type="hidden"/>
                        <input name="hr_approval"  type="hidden" value='true'/>
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">File No:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="employee_fileno" id="employee_fileno" type="text" readonly />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                
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
                    </div><!-- PANEL BODY -->
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pass Slip Status:</label>
                            <div class="col-sm-8">
                                <select name="dept_head_approval" id="dept_head_approval" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date date_approve_decline" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="panel panel-default">
                    <div class="panel-heading">Time Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time Out:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time fromtime" type="text" name="from" onblur="$(this).getTotalHours('update_pass_slip');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time of Return:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time totime" type="text" name="to" onblur="$(this).getTotalHours('update_pass_slip');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Return:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text" name="date_return" id="date_return" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Hours:</label>
                            <div class="col-sm-8">
                                <input  class="form-control numhours" type="text" min="0" max="" name="numhours" readonly />
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label">Undertime:</label>
                            <div class="col-sm-8">
                                <input  class="form-control undertime" type="number" min="0" max="" step='0.5' name="undertime" />
                            </div>
                        </div>

                    </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
       
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



<div class="modal fade" id="newtravelform" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Travel Form</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_travel_order_application')?>">
                <div class="modal-body form-horizontal add_travel_order">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <input name="hr_approval"  type="hidden" value='true'/>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>

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
                    <div class="panel-heading">Travel Order Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date travel_date" type="text" min="0" max="" name="travel_date" required />
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
                            <label class="col-sm-3 control-label">From Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date fromdate" type="text" name="fromdate" onblur="$(this).getTravelDays('add_travel_order');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date todate" type="text" name="todate" onblur="$(this).getTravelDays('add_travel_order');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Days:</label>
                            <div class="col-sm-8">
                                <input  class="form-control numdays" type="text" min="0" max="" id="numdays" name="numdays" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Estimated Allocated Budget</div>
                    <div class="panel-body">
                        <label class="control-label">Estimated Budget:</label>&nbsp;
                            <button type="button" class="btn btn-success btn-xs" id="edit_add_travel_budget"><i class="fa fa-plus"></i></button>
                            <table id="edit_travel_budget" style="width:100%">
                                <thead>
                                    <th style="display: none;">id</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Amount (PHP):</label>
                                <div class="col-sm-6">
                                    <input  class="form-control total_amount" type="text" id="total_amount" readonly />
                                </div>
                            </div>
                    </div><!-- PANEL BODY -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Travel Order Status:</label>
                            <div class="col-sm-8">
                                <select name="to_status" id="to_status" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->

                 <div class="panel panel-default">
                    <div class="panel-heading">HR</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" min="0" max="" id="remarks" name="remarks" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
       
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

<div class="modal fade" id="updatetravelform" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Update Travel Form</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_travel_order_application')?>">
                <div class="modal-body form-horizontal update_travel_order">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>
                                 <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                 <input name="hr_approval"  type="hidden" value='true'/>
                                 <input  class="form-control" name="travelo_id"  id="travelo_id" type="hidden" readonly />

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
                    <div class="panel-heading">Travel Order Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date travel_date" type="text" min="0" max="" name="travel_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Destination:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" min="0" max="" name="destination" id="destination" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Purpose:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="purpose" id="reason" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">From Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date fromdate" type="text" name="fromdate" onblur="$(this).getTravelDays('update_travel_order');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date todate" type="text" name="todate" onblur="$(this).getTravelDays('update_travel_order');" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Days:</label>
                            <div class="col-sm-8">
                                <input  class="form-control numdays" type="text" min="0" max="" name="numdays" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Estimated Allocated Budget</div>
                    <div class="panel-body">
                        <label class="control-label">Estimated Budget:</label>&nbsp;
                            <button type="button" class="btn btn-success btn-xs" id="edit_add_travel_budget"><i class="fa fa-plus"></i></button>
                            <table id="edit_travel_budget" style="width:100%">
                                <thead>
                                    <th style="display: none;">id</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Amount (PHP):</label>
                                <div class="col-sm-6">
                                    <input  class="form-control total_amount" type="text" id="total_amount" readonly />
                                </div>
                            </div>
                    </div><!-- PANEL BODY -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Travel Order Status:</label>
                            <div class="col-sm-8">
                                <select name="to_status" id="to_status" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Declined</option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date date_approve_decline" type="text"  name="date_approve_decline" required />
                            </div>
                        </div>
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                
                 <div class="panel panel-default">
                    <div class="panel-heading">HR</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" min="0" max="" id="remarks" name="remarks" />
                            </div>
                        </div>
                      
                  </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="form-control hidden message1" style="border:0"></div>
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="newtravelform" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
