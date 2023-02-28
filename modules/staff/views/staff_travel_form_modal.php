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
                    <div class="panel-heading">Travel Order Information</div>
                    <div class="panel-body">
                        <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='<?=$fileno?>' readonly />
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
                            
                        <div>
                            <label class="control-label">Estimated Budget:</label>
                            <button type="button" class="btn btn-success btn-xs" id="add_travel_budget"><i class="fa fa-plus"></i></button>
                            <table id="travel_budget" style="width:100%">
                                <thead>
                                    <th style="display: none;">id</th>
                                    <th>Specification</th>
                                    <th>Amount</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table><br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Total Amount (PHP):</label>
                                <div class="col-sm-6">
                                    <input  class="form-control total_amount" type="text" id="add_total_amount" readonly />
                                </div>
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
                    <div class="panel-heading">Travel Order Information</div>
                    <div class="panel-body">
                        <input  class="form-control" name="travelo_id"  id="travelo_id" type="hidden" value='' readonly />
                        <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" value='<?=$fileno?>' readonly />
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date travel_date" type="text" min="0" max="" name="travel_date" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Destination:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" name="destination" id="destination" />
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
                                <input  class="form-control numdays" type="text" min="0" id="numdays" max="" name="numdays" readonly />
                            </div>
                        </div>

                        <div>
                            <label class="control-label">Estimated Budget:</label>&nbsp;
                            <button type="button" class="btn btn-success btn-xs" id="edit_add_travel_budget"><i class="fa fa-plus"></i></button>
                            <table id="edit_travel_budget" style="width:100%">
                                <thead>
                                    <th style="display: none;">id</th>
                                    <th>Specification</th>
                                    <th>Amount</th>
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

                        </div>
                    </div><!-- PANEL BODY -->
                </div>
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