<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Salary Matrix</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->



    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Lists
        </div>
        <div class="panel-body">
            <div class="alert alert-info">
                Please enter <b>DAILY RATE</b> for each person and its corresponding employment type.
            </div>
            <div class="alert alert-warning">
                Check this box to enable editing.
                <input type="checkbox" class="enable_update" onclick="$(this).enableupdate();"> Update record.
            </div>


            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#non_teaching" aria-controls="non_teaching" role="tab" data-toggle="tab">Non-Teaching</a></li>
                <li role="presentation"><a href="#teaching" aria-controls="teaching" role="tab" data-toggle="tab">Teaching</a></li>
                <li role="presentation"><a href="#unknown" aria-controls="unknown" role="tab" data-toggle="tab">Unespecified Nature of Employement</a></li>          
            </ul>
            <!-- <table class="table table-bordered display compact tbl_salary_matrix" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Regular</th>
                        <th>Probationary</th>
                        <th>Contractual</th>
                        <th>Project Based</th>
                        <th>Fixed Term</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table> -->

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="non_teaching">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payroll
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display compact tbl_salary_matrix" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Position</th>
                                        <th>Per Day</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


            <div role="tabpanel" class="tab-pane" id="teaching">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payroll
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display compact tbl_teaching_salary_matrix" cellspacing="1" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Position</th>
                                        <th>Per Hour</th>
                                        <!-- <th>Per Day</th> -->
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="unknown">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payroll
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display compact tbl_unknow_salary_matrix" cellspacing="1" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Position</th>
                                        <th>Per Hour</th>
                                        <!-- <th>Per Day</th> -->
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> <!-- /#page-wrapper -->


