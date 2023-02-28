<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Salary Matrix</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <?php if ($error_data): ?>
        <?php foreach ($error_data as $error) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <i class="glyphicon glyphicon-warning-sign"></i> &nbsp;  <strong>No Specified <?= $error ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form class="form-horizontal" method="post" id="searchform">
        <div class="col-lg-12">        
            <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"> 
                            Employee Name
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Search Employee</label>
                                <div class="col-sm-9">
                                    <select id="combobox" onchange="$(this).changeEmployee($(this).val())" class="form-control" style="width:100%">
                                        <option value=""></option>
                                    <?php foreach ($employees as $key => $value): ?>
                                        <option value="<?= $value['fileno'] ?>" <?= ($staff_selected[0]->FileNo == $value['fileno']) ? 'selected' : ' '?>><?=  $value['name'] ?></option>
                                    <?php endforeach ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-sm-3">File No.</label>
                                <div class="col-sm-9">
                                    <input id="idno" value="<?= $staff_selected[0]->FileNo ?>" class="form-control" name="sid"  readonly/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3">Postion</label>
                                <div class="col-sm-9">
                                    <input id="lname" class="form-control searchname" readonly name="lname" autocomplete="off" value="<?= $staff_selected[0]->position ?>" />
                                </div>
                            </div>

<!--                             <div class="form-group">
                                <label class="control-label col-sm-3">Last Name</label>
                                <div class="col-sm-9">
                                    <input id="lname" class="form-control searchname" readonly name="lname" autocomplete="off" value="<?= $staff_selected[0]->LastName ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">First Name</label>
                                <div class="col-sm-9">
                                    <input id="fname" class="form-control searchname" readonly name="fname" autocomplete="off" value="<?= $staff_selected[0]->FirstName ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Middle Name</label>
                                <div class="col-sm-9">
                                    <input id="mname" class="form-control searchname" readonly name="mname" autocomplete="off" value="<?= $staff_selected[0]->MiddleName ?>"/>
                                </div>
                            </div> -->
                        </div>
                    </div>
            </div>


            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        Employee Information Details
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group">

                            <?php if ($staff_selected[0]->teaching == 0): ?>
                                <label class="control-label col-sm-3">Rate Per Day</label>
                            <?php else: ?>
                                <label class="control-label col-sm-3">Rate Per Hour</label>
                            <?php endif; ?>

                            <div class="col-sm-9">
                                <input id="salary_rate" class="form-control" name="salary_rate" value="<?= $rate[0]->hour ? $rate[0]->hour : 'Salary Rate Not Yet Specified' ?>"  readonly/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nature of Employment</label>
                            <div class="col-sm-9">
                                <input id="isTeaching" class="form-control searchname" readonly name="isTeaching" autocomplete="off" value="<?= ($staff_selected[0]->teaching == 0) ? 'Non-Teaching' : 'Teaching'?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Employee Status</label>
                            <div class="col-sm-9">
                                <input id="isTeaching" class="form-control searchname" readonly name="isTeaching" autocomplete="off" value="<?= strtoupper($staff_selected[0]->emp_status) ?>"/>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading"> 
                    Payroll Settings/Filters
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="control-label col-xs-2">Cutt off Date</label>
                        <div class="col-sm-4">
                            <select id="cutt_off" name="cutt_off" class="form-control" style="width:100%" required="">
                                <option value=""></option>
                                <option value="1" <?= $val_cut_off == 1 ? 'Selected' : '' ?> > Fist Cut (<?= $first_cut ?>) </option>
                                <option value="2" <?= $val_cut_off == 2 ? 'Selected' : '' ?> > Second Cut (<?= $second_cut ?>) </option>
                            </select>
                        </div>

                        <label class="control-label col-xs-1">Month</label>
                        <div class="col-sm-4">
                            <input id="month_rate" class="form-control datepicker_month" name="month_rate" value="<?= $month ?>"  />
                        </div>
                    </div>

                    <div class="form-group" style="text-align: center;">
                        <button id="search" class="btn btn-success" name="search"><i class="fa fa-save"></i> Submit </button>

                        <!-- <button class="btn btn-success btn-sm" type="button" name="show" onclick="$(this).viewattendance();"><i class="fa fa-arrow-right"></i> Submit</button> -->
                    </div>

                </div>
            </div>
        </div>

    </form>


    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"> 
                PAYROLL DETAILS
            </div>

            <div class="panel-body">
                
                <div class="col-lg-6" id="attendance_details">
                    <h4 style="text-align: center;">Attendance</h4>
                    <table class="table table-bordered display compact small" id="staff_attendance_tbl" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th width="20%">Total Hours</th>
                                <th>Exception</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>  

                    <div class="form-group">
                        <label class="control-label col-sm-3">No. of Days</label>
                        <div class="col-sm-9">
                            <input id="total_days" class="form-control searchname" readonly name="total_days"/>                  
                        </div>
                    </div>

                </div>

            </div>

            <div class="panel-body">
                <h4 style="text-align: center;">Computation Payroll</h4>
                <div class="col-lg-6" id="attendance_details">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Total Payroll: </label>
                        <div class="col-sm-9">
                            <input id="total_payroll" class="form-control" readonly name="total_payroll"/>                  
                        </div>
                    </div>
                </div>
                   
            </div>


        </div>

    </div>


    <div id="view_attendance_data" title="Basic dialog">
    
    </div>


</div>


