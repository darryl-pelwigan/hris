<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Leave Credits</h1>
            <div class='col-lg-4'>
              <select id="changeClassification" class="form-control" style="width: 250px;">
                <option value="">All</option>
                <option value="1">Teaching</option>
                <option value="0">Non-Teaching</option>
              </select>
            </div>
            <div class="col-lg-8">
                <button onclick="$(this).addleavecredits();" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add Vacation Leave Credits (NON-TEACHING)</i> </button>
                <button onclick="$(this).addleavecreditsTeaching();" class="btn btn-warning"><i class="glyphicon glyphicon-plus"></i> Add Vacation Leave Credits (TEACHING)</i> </button>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <br>
       
    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Lists
        </div>
        <div class="panel-body">
            <table class="table table-bordered display compact small emp_leave_credits" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Biometrics</th>
                        <th>FileNo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Leave Type</th>
                        <th>Leave Credit</th>
                        <th>Leave Credit Date</th>
                        <th>Leave Balance</th>
                        <th>Classification</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <!-- <button class="btn btn-loader hide"><img src="<?=base_url()?>assets/images/facebook.gif" class="loader" style="height: 30px" /> Update Employee Leave Credits</button>  -->

        </div>
    </div>
</div> 

<div class="modal fade" id="addLeaveCredits" tabindex="-1" role="dialog" aria-labelledby="addleavecredits">
    <div class="modal-dialog modal-lg" role="document" style="width: 1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <b>ADD LEAVE CREDITS (NON-TEACHING)</b>
            </div>
            <form method="POST" id="leave-credit-form" action="">
                <div class="modal-body">
                    <div class="alert alert-info">
                        Note: Leave credits are only given to employees with at least one (1) year of service and with regular employment status.
                    </div>
                    <div class="col-sm-12">
                        <div class="well">
                            <label for="" class="col-sm-3">Date:</label>
                            <div class="col-sm-6">
                                <input class="form-control leave_date" type="text" name="date" required>
                            </div>
                            <br style="clear: both;">
                        </div>
                    </div>
                   <div class="table-responsive">
                       <table class="table table-bordered compact" id="non_teaching_employees" cellspacing="0" width="100%">
                            <thead>
                                <th>File No</th>
                                <th>Biometrics ID</th>
                                <th>Name</th>
                               <!--  <th>Department</th>
                                <th>Position</th> -->
                                <th>Employment Status</th>
                                <th>Date of Employment</th>
                                <th>YOS</th>
                                <th>VL Credits</th>
                                <th>Leave Balance</th>
                                <!-- <th>Remarks</th> -->
                            </thead>
                       </table>
                   </div>   
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-save-leave-credits" name="save">Save Record</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                                    <th>Leave Type</th>
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



