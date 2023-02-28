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
</style>

<div class="modal fade" id="newLoans" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">New Loans</h4>
            </div>
          
            <form method="post" action="<?=base_url('payroll/loans/add_loans')?>">
                <div class="modal-body form-horizontal add_loans">
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Position:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" id="employee_position" name="employee_position" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="panel panel-default">
                    <div class="panel-heading">Loan Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Loan Description:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="loan_description" name="loan_description" type="text" required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Months Payable:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max="" name="months_payable" id="months_payable" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Amount Per Month:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max=""  name="amt_per_month" id="amt_per_month" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Cut Off:</label>
                            <div class="col-sm-8">
                                <select  class="form-control" name="cut_off" id="cut_off" required="required">
                                    <option value="1">First Half</option>
                                    <option value="2">Second Half</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Total Amount:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max=""  name="total_amt" id="total_amt" required />
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

<div class="modal fade" id="updateLoan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Update Loans</h4>
            </div>
          
            <form method="post" action="<?=base_url('loans/add_loans')?>">
                <div class="modal-body form-horizontal update_loans">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Info</div>
                    <div class="panel-body">
                        <div class="form-group">
                             <label class="col-sm-3 control-label">Name:</label>
                             <div class="col-sm-8">
                                <input  class="form-control" name="employee_name" id= "employee_name" type="text" onkeyup="$(this).searchemployee($(this).val());" />
                                <input  class="form-control" name="employee_id"  id="employee_id" type="hidden" readonly />
                                <input  class="form-control" name="loan_id"  id="loan_id" type="hidden" readonly />
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Position:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="text" id="employee_position" name="employee_position" readonly />
                            </div>
                        </div>
                    </div><!-- PANEL BODY -->
                </div><!-- PANEL -->
                <div class="panel panel-default">
                    <div class="panel-heading">Loan Information</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Loan Description:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" id="loan_description" name="loan_description" type="text" required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Months Payable:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max="" name="months_payable" id="months_payable" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Amount Per Month:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max=""  name="amt_per_month" id="amt_per_month" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label actual1">Cut Off:</label>
                            <div class="col-sm-8">
                                <select  class="form-control" name="cut_off" id="cut_off" required="required">
                                    <option value="1">First Half</option>
                                    <option value="2">Second Half</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Total Amount:</label>
                            <div class="col-sm-8">
                                <input  class="form-control" type="number" min="0" max=""  name="total_amt" id="total_amt" required />
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