<div class="modal fade" id="newpasslip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Pass Slip Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('employees_pass_slip_application')?>">
                <div class="modal-body form-horizontal add_pass_slip">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='<?=$fileno?>' readonly />
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
<!--                         <div class="form-group">
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Undertime:</label>
                            <div class="col-sm-8">
                                <input  class="form-control undertime" type="number" min="0" max="" step="0.5" name="undertime" />
                            </div>
                        </div> -->
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
          
            <form method="post" action="<?=base_url('employees_pass_slip_application')?>">
                <div class="modal-body form-horizontal update_pass_slip">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Pass Slip Information</div>
                    <div class="panel-body">
                        <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='<?=$fileno?>' readonly />
                        <input  class="form-control" name="pass_slip_id"  id="pass_slip_id" type="hidden" value=''> 
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