<div class="modal fade" id="newCutOff" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Cut Off Period</h4>
            </div>
          
            <form method="post" action="<?=base_url('payroll/add_cutoff_period')?>">
                <div class="modal-body form-horizontal add_cutoff">
                <div class="panel panel-default">
                    <div class="panel-heading">Cut Off Details</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cutt Off Period:</label>
                            <div class="col-sm-8">
                                <select name="cutt_off_period" id="cutt_off_period" class="form-control" required>
                                    <option value="" selected="" disabled></option>
                                    <option value="1">1st Cut Off</option>
                                    <option value="2">2nd Cut Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Classification:</label>
                            <div class="col-sm-8">
                                <select name="classification" id="classification" class="form-control" required>
                                    <option value="" selected="" disabled></option>
                                    <option value="1">Teaching</option>
                                    <option value="0">Non-teaching</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status:</label>
                            <div class="col-sm-8">
                            <select name="status" id="status" class="form-control" required>
                                <option value="" selected="" disabled></option>
                                <option value="regular">Regular</option>
                                <option value="contractual">Contractual</option>
                                <option value="project-based">Project-Based</option>
                                <option value="probationary">Probationary</option>
                                <option value="fixed-term">Fixed Term</option>
                            </select>
                        </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date From:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date cut_off_from"  name="cut_off_from" type="text" required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Date To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date cut_off_to" type="text"  name="cut_off_to"  required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3" required=""></textarea>
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

<div class="modal fade" id="updateCutOff" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Update Cut Off Period</h4>
            </div>
          
            <form method="post" action="<?=base_url('payroll/add_cutoff_period')?>">
                <div class="modal-body form-horizontal update_cutoff">
                <div class="panel panel-default">
                    <div class="panel-heading">Cut Off Details</div>
                    <div class="panel-body">
                        <input type="hidden" name='cutoff_id' id="cutoff_id"/>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cutt Off Period:</label>
                            <div class="col-sm-8">
                                <select name="cutt_off_period" id="cutt_off_period" class="form-control cutt_off_period" required>
                                    <option value="" selected="" disabled></option>
                                    <option value="1">1st Cut Off</option>
                                    <option value="2">2nd Cut Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Classification:</label>
                            <div class="col-sm-8">
                                <select name="classification" id="classification" class="form-control classification" required>
                                    <option value="" selected="" disabled></option>
                                    <option value="1">Teaching</option>
                                    <option value="0">Non-teaching</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status:</label>
                            <div class="col-sm-8">
                            <select name="status" id="status" class="form-control status" required>
                                <option value="" selected="" disabled></option>
                                <option value="regular">Regular</option>
                                <option value="contractual">Contractual</option>
                                <option value="project-based">Project-Based</option>
                                <option value="probationary">Probationary</option>
                                <option value="fixed-term">Fixed Term</option>
                            </select>
                        </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date From:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date cut_off_from" name="cut_off_from" type="text" required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Date To:</label>
                            <div class="col-sm-8">
                                <input  class="form-control date cut_off_to" type="text"  name="cut_off_to"  required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Remarks:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="3"></textarea>
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