  
<div id="page-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
        Add Staff Schedule
        </div>
        <div class="panel-body">
            <?php if ($this->session->flashdata('message')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?php echo $this->session->flashdata('message'); ?></strong> 
                </div>
            <?php endif; ?>

            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>hr/scheduling/add_submit_staff_Schedule">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Classification:</label>
                    <div class="col-sm-5">
                        <select name="classify" id="classify" class="form-control">
                            <option value="2"></option>
                            <option value="1">Teaching</option>
                            <option value="0">Non-Teaching</option>                    
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Staff:</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" id="staff_list" required>
                        <input class="form-control" type="hidden" name="staff" id="biomentric_selected" required>
                    </div>
                </div>

                <div class="form-group" id='sdays'>
                <label class="col-md-2 control-label">Days :</label>
                <div class="col-md-5">
                    <div class='col-md-6 '>
                        <label id='allDaysLbl'><input id='allDays' type="checkbox"> Select All</label><br/>
                        <label><input type="checkbox" name="days[]" class='checks' value="1" > Monday</label><br/>
                        <label><input type="checkbox" name="days[]" class='checks' value="2" > Tuesday</label><br/>
                        <label><input type="checkbox" name="days[]" class='checks' value="3" > Wednesday</label><br/>
                    </div>
                    <div class='col-md-6 '>
                        <br/>
                        <label><input type="checkbox" name="days[]" class='checks' value="4" > Thursday</label><br/>
                        <label><input type="checkbox" name="days[]" class='checks' value="5" > Friday</label><br/>
                        <label><input type="checkbox" name="days[]" class='checks' value="6" > Saturday</label><br/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Time In AM</label>
                <div class="col-sm-5">
                    <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timein_am" id="timein_am" value="8:00 AM">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Time Out AM</label>
                <div class="col-sm-5">
                    <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timeout_am" id="timeout_am" value="12:00 PM">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Time In PM</label>
                <div class="col-sm-5">
                    <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timein_pm" id="timein_pm" value="1:00 PM">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Time Out PM</label>
                <div class="col-sm-5">
                    <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timeout_pm" id="timeout_pm" value="5:00 PM">
                </div>
            </div>
             <div class="form-group">
                   <label for="" class="col-md-2 control-label">Total Hours</label>
                   <div class="col-md-5">
                       <input type="text" onblur="getTotalHours()" class="form-control" id="totalhours" name="totalhours" readonly="" value="8.00">
                   </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <button class="btn btn-success btn-sm" type="submit" name="submit"><i class="fa fa-arrow-right"></i> Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">

        <div class="table-responsive">
            <div class="" style="margin: 20px 0;">
                <select id="changeClassification" id="changeClassification" class="form-control" style="width: 250px;">
                    <option value="0"></option>
                    <option value="1">Teaching</option>
                    <option value="0">Non-Teaching</option>
                 </select>
            </div>
            <table id="tablesched" class="display compact table table-bordered responsive" width="100%">
                <thead>
                    <tr>
                        <th>File No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Department</th>
                        <th>Classification</th>
                        <th>Time In AM</th>
                        <th>Time Out AM</th>
                        <th>Time In PM</th>
                        <th>Time Out PM</th>
                        <th>Total Hours</th>
                        <th>Days</th>
                        <!-- <th></th> -->
                        <th width="5%"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</div> 


<div class="modal fade" id="viewSched" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editModalLabel">View Schedule</h4>
            </div>
            <form action="" method="post"  class="form-horizontal">
                <div class="modal-body" >
                   <div class="form-group">
                       <label for="" class="col-md-2 control-label">Name</label>
                       <div class="col-md-9">
                           <input type="text" class="form-control" readonly="" id="fullname_teaching">
                       </div>
                   </div>
                   <table align="center" class="table table-bordered" width="100%" id="tbl-view-sched">
                       <thead>
                            <th>Days</th>
                            <th>Time</th>
                            <th>Course No.</th>
                            <th>Course/Year Section</th>
                            <th>Hours/Week</th>
                            <th>Room</th>
                            <th>No of Students</th>
                            <th>Total Hours</th>
                       </thead>
                       <tbody>
                           
                       </tbody>
                   </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- <div class="modal fade" id="editRecord" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editModalLabel">Edit Record</h4>
            </div>
            <form action="<?php echo base_url(); ?>hr/scheduling/update_staff_scheduling" method="post"  class="form-horizontal">
                <div class="modal-body" id="edit-attendance">
                   <div class="form-group">
                       <label for="" class="col-md-3 control-label">Name</label>
                       <div class="col-md-9">
                           <input type="text" class="form-control" readonly="" id="fullname">
                           <input type="hidden" class="form-control" name="schedid" id="schedid"> 
                       </div>
                   </div>
                    <div class="form-group" id='sdays'>
                    <label class="col-md-3 control-label">Days :</label>
                    <div class="col-md-9">
                        <div class='col-md-6 '>
                            <label id='allDaysLbl'><input id='allDays' type="checkbox"> Select All</label><br/>
                            <label><input type="checkbox" name="days[]" class='check_box' value="1" id="day_1" > Monday</label><br/>
                            <label><input type="checkbox" name="days[]" class='check_box' value="2" id="day_2" > Tuesday</label><br/>
                            <label><input type="checkbox" name="days[]" class='check_box' value="3" id="day_3" > Wednesday</label><br/>
                        </div>
                        <div class='col-md-6 '>
                            <br/>
                            <label><input type="checkbox" name="days[]" class='check_box' value="4" id="day_4" > Thursday</label><br/>
                            <label><input type="checkbox" name="days[]" class='check_box' value="5" id="day_5" > Friday</label><br/>
                            <label><input type="checkbox" name="days[]" class='check_box' value="6" id="day_6" > Saturday</label><br/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Time In AM</label>
                        <div class="col-sm-5">
                            <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timein_am" id="timein" value="8:00 AM">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Time Out AM</label>
                        <div class="col-sm-5">
                            <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timeout_am" id="timeout" value="12:00 PM">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Time In PM</label>
                        <div class="col-sm-5">
                            <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timein_pm" id="timein" value="1:00 PM">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Time Out PM</label>
                        <div class="col-sm-5">
                            <input type="text" onblur="getTotalHours()" class="timepicker form-control" name="timeout_pm" id="timeout" value="5:00 PM">
                        </div>
                    </div>

                    <div class="form-group">
                       <label for="" class="col-md-3 control-label">Total Hours</label>
                       <div class="col-md-9">
                           <input type="text" onblur="updateTotalHours()" class="form-control" id="update_totalhours" name="update_hours" readonly="">
                       </div>
                    </div>
                  

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> -->
