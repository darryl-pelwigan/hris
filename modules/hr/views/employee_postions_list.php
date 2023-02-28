    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Postition</h1>
            <button class="btn btn-primary btn-sm pull-left" style="margin-bottom: 5px" type="button" data-controls-modal="#new_position" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#new_position">Add Position</button>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Lists
        </div>
        <div class="panel-body">
            <table id="employee-position-list" class="table table-bordered display compact small employee" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Categories</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="color: black;"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="new_position" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center;">Edit Position </h4>
                </div>
                <form method="post" action="<?php echo base_url(); ?>hr/employees/add_update_emp_posision">
                <div class="modal-body update_holiday">
                    <div class="modal-body form-horizontal">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="padding:1.5%">
                                <h3 class="panel-title">Position Information</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Position</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="position_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="position_category">
                                            <option value=""></option>
                                            <option value="Dean">Dean</option>
                                            <option value="OIC">OIC</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Staff">Staff</option>
                                            <option value="Faculty">Faculty</option>
                                            <option value="VP">VP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<div class="modal fade" id="edit_position" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center;">Edit Position </h4>
                </div>
                <form method="post" action="<?php echo base_url(); ?>hr/employees/add_update_emp_posision">
                <div class="modal-body update_holiday">
                    <div class="modal-body form-horizontal">
                        <input  class="form-control" name="position_id"  id="position_id" type="hidden">

                        <div class="panel panel-default">
                            <div class="panel-heading" style="padding:1.5%">
                                <h3 class="panel-title">Psotion Information</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Position</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="position_name" id="position_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="position_category" id="position_category">
                                            <option value=""></option>
                                            <option value="Dean">Dean</option>
                                            <option value="OIC">OIC</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Staff">Staff</option>
                                            <option value="Faculty">Faculty</option>
                                            <option value="VP">VP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
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