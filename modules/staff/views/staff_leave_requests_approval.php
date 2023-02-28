<div id="page-wrapper">
 

    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#leave" aria-controls="leave" role="tab" data-toggle="tab">Leave Requests</a></li>
            <li role="presentation"><a href="#overtime" aria-controls="overtime" role="tab" data-toggle="tab">Overtime Requests</a></li>
            <li role="presentation"><a href="#pass_slip" aria-controls="pass_slip" role="tab" data-toggle="tab">Pass Slip Requests</a></li>
            <li role="presentation"><a href="#travel_form" aria-controls="travel_form" role="tab" data-toggle="tab">Travel Form</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="leave">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Pending Leave Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="t_leave_pending" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Leave Type</th>
                                    <th>No. of Days</th>
                                    <th>Leave Date</th>
                                    <th>Date Filed</th>
                                    <th>Reason</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-success">
                    <div class="panel-heading">
                        Approved Leave Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="t_leave_approved" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Leave Type</th>
                                    <th>No. of Days</th>
                                    <th>Leave Date</th>
                                    <th>Date Filed</th>
                                    <th>Reason</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Declined Leave Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="t_leave_declined" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Leave Type</th>
                                    <th>No. of Days</th>
                                    <th>Leave Date</th>
                                    <th>Date Filed</th>
                                    <th>Reason</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div>
            <div role="tabpanel" class="tab-pane" id="overtime">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Pending Overtime Request
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                         <div class="form-group">
                          <label class="col-sm-1 control-label"></label>              
                            <div class="col-sm-5">        
                              <div id='loader' style="width:400px;display:none;">
                                  <div class="progress progress-striped active">
                                      <div class="progress-bar progress-bar-success bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                  </div>
                              </div>
                            </div>  
                        </div>
                        <table id="pending_overtime" class="table table-striped table-bordered table-hover" width="100%" >
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Date of Overtime</th>
                                    <th>No. of Hours</th>
                                    <th>Reason</th>
                                    <th>Time From</th>
                                    <th>Time To</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-success">
                    <div class="panel-heading">
                        Approved Overtime Request
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                         <div class="form-group">
                          <label class="col-sm-1 control-label"></label>              
                            <div class="col-sm-5">        
                              <div id='loader' style="width:400px;display:none;">
                                  <div class="progress progress-striped active">
                                      <div class="progress-bar progress-bar-success bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                  </div>
                              </div>
                            </div>  
                        </div>
                        <table id="approved_overtime" class="table table-striped table-bordered table-hover display responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Date of Overtime</th>
                                    <th>No. of Hours</th>
                                    <th>Reason</th>
                                    <th>Time From</th>
                                    <th>Time To</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Decline Overtime Request
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                         <div class="form-group">
                          <label class="col-sm-1 control-label"></label>              
                            <div class="col-sm-5">        
                              <div id='loader' style="width:400px;display:none;">
                                  <div class="progress progress-striped active">
                                      <div class="progress-bar progress-bar-success bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                  </div>
                              </div>
                            </div>  
                        </div>
                        <table id="decline_overtime" class="table table-striped table-bordered table-hover display responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Date of Overtime</th>
                                    <th>No. of Hours</th>
                                    <th>Reason</th>
                                    <th>Time From</th>
                                    <th>Time To</th>
                                    <!-- <th>Options</th> -->
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div>

            <div role="tabpanel" class="tab-pane" id="pass_slip">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Pending Pass Slip Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                        <table id="t_passslip_pending" class="table table-striped table-bordered table-hover"  width="100%">
                            <thead><tr>
                            <th>Employee Name</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>Time Out</th>
                            <th>Time Return</th>
                            <th>Total Hours</th>
                            <th>Undertime</th>
                            <th></th>
                            </tr></thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-success">
                    <div class="panel-heading">
                        Accepted Pass Slip Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="t_passslip_approved" class="table table-striped table-bordered table-hover" width="100%">
                            <thead><tr>
                            <th>Employee Name</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>Time Out</th>
                            <th>Time Return</th>
                            <th>Total Hours</th>
                            <th>Undertime</th>
                            <th></th>
                            </tr></thead>
                            <tbody></tbody>
                        </table>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Declined Pass Slip Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="t_passslip_declined" class="table table-striped table-bordered table-hover" width="100%">
                            <thead><tr>
                            <th>Employee Name</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>Time Out</th>
                            <th>Time Return</th>
                            <th>Total Hours</th>
                            <th>Undertime</th>
                            </tr></thead>
                            <tbody></tbody>
                        </table>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div>


            <div role="tabpanel" class="tab-pane" id="travel_form">


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Pending Travel Form Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                        
                        <table id="t_travelo_pending" class="table table-striped table-bordered table-hover" width='100%'>
                            <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Date</th>
                                        <th>Destination</th>
                                        <th>Purpose</th>
                                        <th>Dates of Travel</th>
                                        <th></th>
                                    </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-success">
                    <div class="panel-heading">
                        Approved Travel Form Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                        <table id="t_travelo_approved" class="table table-striped table-bordered table-hover" width='100%'>
                            <thead><tr>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>Dates of Travel</th>
                            <th>Remarks</th>
                            </tr></thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->

                <div class="panel panel-danger">
                    <div class="panel-heading">
                       Declined Travel Form Requests
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                      <form class="form-horizontal" action="" method="POST" >
                         
                        <table id="t_travelo_declined" class="table table-striped table-bordered table-hover" width='100%'>
                            <thead><tr>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Purpose</th>
                            <th>Dates of Travel</th>
                            <th>Remarks</th>
                            </tr></thead>
                            <tbody></tbody>
                        </table>
                      </form> 
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->


            </div>
        </div>
    </div>
</div> <!-- /#page-wrapper -->

<!--modal-->
<div class="modal fade" id="addrem" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <form id="form" method="POST" action="<?=base_url('update_leave_request_approval')?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title"> Leave Requests Remarks </h4>
            </div>
            <div class="modal-body leave_status">
                <div class="alert" role="alert">
                    Are you sure to <span id="leave_app_disapp"></span> this requests?
                </div>
               <textarea style="resize:vertical; max-height:250px;height:130px" placeholder="Remarks" class="form-control" name="remark"></textarea>
            </div>
                
            <div class="modal-footer">
                <input type="hidden" name="dept_status" id="dept_status">
                <input type="hidden" name="leave_id" id="leave_id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-success">Approve</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="update_overtime_request" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <form id="form" method="POST" action="<?=base_url('update_overtime_approval')?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title"> Overtime Request </h4>
            </div>
            <div class="modal-body modal_status">
                <div class="alert" role="alert">
                    Are you sure to <span id="over_app_disapp"></span> this request?
                </div>
            </div>
                
            <div class="modal-footer">
                <input type="hidden" name="dept_status" id="over_dept_status">
                <input type="hidden" name="pass_slip_id" id="overtime_id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-success">Approve</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="update_pass_slip" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form" method="POST" action="<?=base_url('update_pass_slip_approval')?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title"> Pass Slip Request </h4>
            </div>

             <div class="modal-body form-horizontal update_pass_slip">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">                        
                        <div class="modal_status">
                            <div class="alert" role="alert">
                                Are you sure to <span id="pass_app_disapp"></span> this request?
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time Out:</label>
                            <div class="col-sm-8">
                                <input  class="form-control time timeout" type="text" name="from" id="timeout" onblur="$(this).getTotalHours('add_pass_slip');" required />
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Return:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date" type="text" name="date_return" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Undertime:</label>
                            <div class="col-sm-8">
                                <input  class="form-control undertime" type="text" min="0" max="" step="0.5" name="undertime" />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div>
       
                <div class="form-control hidden message1" style="border:0"></div>
                

                </div>
                
            <div class="modal-footer">
                <input type="hidden" name="dept_status" id="pass_dept_status">
                <input type="hidden" name="pass_slip_id" id="pass_slip_id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-success">Approve</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--/modal-->

<div class="modal fade" id="travel_app_disapp" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form" method="POST" action="<?=base_url('update_travel_order_request_approval')?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <input  class="form-control" name="travelo_id"  id="travelo_id" type="hidden" value='' readonly />
                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='' readonly />
                <h4 class="modal-title" id="title"> Travel Order Request </h4>
            </div>
            <div class="modal-body modal_status">
                <div>
                    <label class="control-label">Estimated Budget:</label>
                    <button type="button" class="btn btn-success btn-xs" id="add_travel_budget"><i class="fa fa-plus"></i></button>
                    <table id="travel_budget" style="width:100%">
                        <thead>
                            <th style="display: none;">id</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table><br>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Total Amount (PHP):</label>
                        <div class="col-sm-6">
                            <input  class="form-control total_amount" type="text" id="total_amount" readonly />
                        </div>
                    </div><br>
                </div><br>
                <div class="alert" role="alert">
                    Are you sure to <span id="travelo_app_disapp"></span> this request?
                </div>
                <textarea class='form-control' name='remarks' placeholder="Remarks.."> </textarea>
            </div>
                
            <div class="modal-footer">
                <input type="hidden" name="dept_status" id="travel_dept_status">
                <input type="hidden" name="travel_order_id" id="travel_order_id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-success">Approve</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--/modal-->


<div class="modal fade" id="updatepayslip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Pass Slip Request Details</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees/add_pass_slip_application')?>">
                <div class="modal-body form-horizontal update_pass_slip">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" readonly />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">File No:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="employee_fileno" id="employee_fileno" type="text" readonly />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <input  class="form-control" name="pass_slip_id"  id="pass_slip_id" type="hidden" readonly />
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
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <span id="pass_slip_type" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-8">
                                <span id='pass_slip_date' ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Destination:</label>
                            <div class="col-sm-8">
                                <span id='destination' ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Purpose:</label>
                            <div class="col-sm-8">
                                <span id='reason' ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time Out:</label>
                            <div class="col-sm-8">
                                <span id='fromtime' ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time of Return:</label>
                            <div class="col-sm-8">
                                <span id='totime' ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Number of Hours:</label>
                            <div class="col-sm-8">
                                <span id='numhours' ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Undertime:</label>
                            <div class="col-sm-8">
                                <span id='undertime'> </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">HR Check</div>
                    <div class="panel-body">
                        <div id='hr-check'>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Exact Time Out:</label>
                                <div class="col-sm-8">
                                    <span id='exact_from'> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Exact Time of Return:</label>
                                <div class="col-sm-8">
                                    <span id='exact_to'> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Number of Hours:</label>
                                <div class="col-sm-8">
                                    <span id='exact_numhours'> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Exact Undertime:</label>
                                <div class="col-sm-8">
                                    <span id='exact_undertime'> </span>
                                </div>
                            </div>
                        </div>
                        <span id='hr-notice'></span>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pass Slip Status:</label>
                            <div class="col-sm-8">
                                <span id='dept_head_approval'></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <span id='date_approve_decline'></span>
                            </div>
                        </div>
                  </div>
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


<div class="modal fade" id="viewovertime" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Overtime Request Details</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees/add_overtime_application')?>">
                <div class="modal-body form-horizontal update_overtime">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" readonly />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <div id="name_seach" class="s-search-results name_seach"></div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">File No:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="employee_fileno" id="employee_fileno" type="text" readonly />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
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
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Overtime Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="date_overtime" type="text" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time From:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="timefrom" type="text" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Time To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="timeto" type="text" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hours Rendered:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="hours_rendered" type="text" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="reason" type="text" readonly />
                            </div>
                        </div>
                    </div>                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Approval</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="dept_head_approval" type="text" readonly />
                            </div>
                           <div class="col-sm-8">
                                <span id='date_approve_decline'></span>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Approved/Declined:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="date_approve_decline" type="text" readonly />
                            </div>
                        </div>
                  </div>
                </div>
       
                <div class="form-control hidden message1" style="border:0"></div>
                </div>

            </form>
        </div>
    </div>
</div>
