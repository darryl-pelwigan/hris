<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">SUBJECT GRADE SETTINGS</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->



 <div class="panel panel-default panel-blue">
        <div class="panel-heading">
          SUBJECT FINAL GRADE ONLY
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Subject CODE</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <td><div class="form-group">
                                                    <input type='text' class="form-control" name="subject_code" id="subject_code" data-subjectid="" />
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).addSubjectToFGonly();">ADD</button></td>
                                    </tr>
                                    </tbody>

                    </table>

                      <table class="table table-striped table-bordered table-hover dataTables-example2" id="fg_only_table" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Subject CODE</th>
                                        <th>Subject TITLE</th>
                                        <th>Subject ACADYEAR</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach ($fg_only as $key => $value):
                                         ?>
                                            <tr>

                                                <td class="ss"><?= $value->courseno ?></td>
                                                <td class="ss"><?= $value->descriptivetitle ?></td>
                                                <td class="ss"><?= $value->acadyear ?></td>
                                                <td><button class="btn btn-danger btn-md" onclick="$(this).deleteSubjectToFGonly('<?= $value->subjectid ?>');">DELETE</button></td>
                                            </tr>

                                        <?php endforeach;?>
                                    </tbody>

                    </table>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->


 <div class="panel panel-default panel-blue">
        <div class="panel-heading">
         GRADE COMPLETION
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Subject GRADING TYPE</th>
                                        <th>DAYS</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Subject Final Grade Only</td>
                                        <td><div class="form-group">
                                                    <input type='number' class="form-control" min="60" value="<?=$completion[0]->days?>" name="subject_completion_fgonly_days" id="subject_completion_fgonly_days" />
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).setcompletionDays('fg');">SET</button></td>
                                    </tr>

                                    <tr>
                                        <td>Subject WITH PRELIM / MIDTERM / TENTATIVE Grade</td>
                                        <td><div class="form-group">
                                                    <input type='number' class="form-control" min="30" value="<?=$completion[1]->days?>" name="subject_completion_pmtf_days" id="subject_completion_pmtf_days" />
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).setcompletionDays('pmtf');">SET</button></td>
                                    </tr>
                                    </tbody>

                    </table>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->


<div class="panel panel-default panel-blue">
        <div class="panel-heading">
         Teacher Allow for Grade Records
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">

                 <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Teacher Name </th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <td><div class="form-group">
                                                    <input type='text' class="form-control" name="teacher_name" id="teacher_name" data-teacherid="" />
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).addTeacher();">ADD</button></td>
                                    </tr>
                                    </tbody>

                    </table>

            <table class="table table-striped table-bordered table-hover dataTables-example2" id="teacher_names" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Teacher</th>
                                         <th>Department </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach ($teachers as $key => $value):
                                         ?>
                                            <tr>

                                                <td class="ss"><?= $value->FirstName ?> <?= $value->MiddleName ?> <?= $value->LastName ?></td>
                                                <td><?=strtoupper($value->DEPTNAME)?></td>
                                                <td><button class="btn btn-danger btn-md" onclick="$(this).deleteSubjectToFGonly('<?= $value->FileNo ?>');">DELETE</button></td>
                                            </tr>

                                        <?php endforeach;?>
                                    </tbody>

                    </table>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->

</div><!-- /#page-wrapper -->