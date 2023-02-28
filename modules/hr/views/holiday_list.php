

  <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Holidays</h1>
            <button class="btn btn-primary btn-sm pull-left" style="margin-bottom: 5px" type="button" data-controls-modal="#new-holiday" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#new-holiday">Add Holiday</button>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Lists of Holidays
        </div>
        <div class="panel-body">
            <table id="holidayTables" class="table table-bordered display compact small employee" cellspacing="0" width="100%">
                <thead>
                    <tr>
                      <th>Date</th>
                      <th>Day of the Week <?php echo "(".date('Y').")"; ?></th>
                      <th>Description</th>
                      <th>Holiday Type</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody style="color: black;"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- EDIT HOLIDAY MODAL -->
<div class="modal fade" id="editholi" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Holiday </h4>
                </div>
                <form method="post" action="<?=base_url('hr/holidays/add_holiday')?>">
                <div class="modal-body update_holiday">
                    <div class="modal-body form-horizontal">
                        <input  class="form-control" name="holiday_id"  id="holiday_id" type="hidden">
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-4">
                                <select name="month" id="month" required class="form-control col-sm-4">
                                    <option value=""></option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>

                            </div>
                            <div class="col-sm-4">
                                <select name="month_date" id="month_date" required class="form-control col-sm-4">> -->
                                    <?php for($i = 1; $i<=31; $i++ ){
                                        echo "<option value=".$i.">".$i."</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Description:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type:</label>
                            <div class="col-sm-8">
                                <select id="holiday_type" name="holiday_type" required class="form-control">
                                    <option value="regular">Regular</option>
                                    <option value="special">Special</option>
                                    <option value="suspension">Suspension</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="hid" value="" name="hid"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="edithol" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/END-->
<!-- EDIT HOLIDAY MODAL -->
<div class="modal fade" id="new-holiday" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="dentalRecord">Add New Holidays</h4>
            </div>
            <form method="post" action="<?=base_url('hr/holidays/add_holiday')?>">
                <div class="modal-body form-horizontal add_leave">
                <div class="panel panel-default">
                    <div class="panel-heading">Holiday Information</div>
                    <div class="panel-body">
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Date:</label>
                            <div class="col-sm-4">
                                <select name="month" required class="form-control col-sm-4">
                                    <option value=""></option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>

                            </div>
                            <div class="col-sm-4">
                                <select name="month_date" required class="form-control col-sm-4">> -->
                                    <?php for($i = 1; $i<=31; $i++ ){
                                        echo "<option value=".$i.">".$i."</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" cols="30" rows="3" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type</label>
                            <div class="col-sm-8">
                                <select name="holiday_type" required class="form-control">
                                    <option value=""></option>
                                    <option value="regular">Regular</option>
                                    <option value="special">Special</option>
                                    <option value="suspension">Suspension</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="new-holiday" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
