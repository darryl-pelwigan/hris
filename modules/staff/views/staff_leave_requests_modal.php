<div class="modal fade" id="newleave" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Leave Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('add_leave_application_employee')?>">
                <div class="modal-body form-horizontal add_leave">
                <div class="panel panel-default">
                    <div class="panel-heading">Leave Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8" id="div_leave">
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly value="<?=$fileno?>" />
                                <select name="leavetype" id="leavetype" class="form-control" required onchange="$(this).getLeaveBal('<?=$fileno?>', $(this).val())">
                                 <option value=""></option>
                                    <?php foreach($leave_credits as $lc): ?>
                                        <?php if(($user[0]->yearsofservice > 0 && $user[0]->teaching == '0') || ($user->teaching[0] == '1' && $user[0]->nature_emp == 'part-time')) { ?>
                                                <option value="<?=$lc->type_id?>"><?=$lc->type?></option>
                                        <?php }elseif($lc->type_id != 4){ ?>
                                                <option value="<?=$lc->type_id?>"><?=$lc->type?></option>
                                        <?php }?>
                                        <?php if($lc->type_id == 1): ?>
                                         <!-- <option value="11">Emergency</option> -->
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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


<div class="modal fade" id="updateleavemodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Update Leave Request</h4>
            </div>
          
            <form method="post" action="<?=base_url('add_leave_application_employee')?>">
                <div class="modal-body form-horizontal update_leave_data">
                <div class="panel panel-default">
                    <div class="panel-heading">Leave Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="leavetype" name="leavetype" type="text" readonly />
                                <input  class="form-control" id="leave_type_id" name="leavetype" type="hidden" readonly />
                                  <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly value="<?=$fileno?>" />
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