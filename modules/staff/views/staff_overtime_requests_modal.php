<div class="modal fade" id="newleave" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Overtime Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_overtime_application')?>">
                <div class="modal-body form-horizontal add_overtime">
                <div class="panel panel-default">
                    <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='<?=$fileno?>'readonly />
                    <input  class="form-control" name="overtime_id"  id="overtime_id" type="hidden" value=''> 

                    <div class="panel-heading">Overtime Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Overtime Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date overtime_date" id="overtime_date" type="text" min="0" max="" name="overtime_date" required />
                            </div>
                        </div>
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
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label actual1">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" name="remarks" id="remarks" />
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



<div class="modal fade" id="updateovertime" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Overtime Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_overtime_application')?>">
                <div class="modal-body form-horizontal update_overtime">
                <div class="panel panel-default">
                    <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='<?=$fileno?>' readonly />
                    <input  class="form-control" name="overt_id"  id="overt_id" type="hidden" value=''> 

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
                                <input  class="form-control numhours" type="text" min="0" max="" name="numhours" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="reason" id="reason" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label actual1">Remarks:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" name="remarks" id="remarks" />
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