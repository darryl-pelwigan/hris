<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grade Submissions</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="panel panel-default">
        <div class="panel-heading">
            Grade Submission   <b> <?=$sem_sy['sem_sy_w']['sy2']?> <?=$sem_sy['sem_sy_w']['csem']?> </b>
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">

                   <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Grading</th>
                                        <th>Date Start</th>
                                        <th>Date Ended</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Prelim</td>
                                        <td><div class="form-group">
                                                <div class='input-group date prelim_start' >
                                                    <input type='text' class="form-control" name="p_start" id="p_start" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <div class='input-group date prelim_end' >
                                                    <input type='text' class="form-control" name="p_end" id="p_end" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).updateGradeSubmission('p');">update</button></td>
                                    </tr>
                                    <tr>
                                        <td>Midterm</td>
                                        <td>
                                             <div class="form-group">
                                                <div class='input-group date midterm_start' >
                                                    <input type='text' class="form-control" name="m_start" id="m_start" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                             <div class="form-group">
                                                <div class='input-group date midterm_end' >
                                                    <input type='text' class="form-control" name="m_end" id="m_end" value="" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).updateGradeSubmission('m');">update</button></td>
                                    </tr>

                                    <tr>
                                        <td>Tentative Final</td>
                                        <td>
                                            <div class="form-group">
                                                <div class='input-group date tenta_start' >
                                                    <input type='text' class="form-control" name="tf_start" id="tf_start" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class='input-group date tenta_end' >
                                                    <input type='text' class="form-control" name="tf_end" id="tf_end" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary btn-md" onclick="$(this).updateGradeSubmission('tf');">update</button></td>
                                    </tr>

                                    </tbody>

                    </table>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->

<?php
    $syx =  explode('-',$sem_sy['sem_sy'][0]->sy);
    $syx =  ($syx[0]-1).'-'.($syx[1]-1);
    switch ($set_sem) {
        case 1:
            $sem_w = 'First Semester';
            break;
        case 2:
            $sem_w = 'Second Semester';
            break;

         case 3:
            $sem_w = 'Summer';
            break;

        default:
            $sem_w = 'Choose...';
            break;
    }
?>

 <div class="panel panel-default panel-blue">
        <div class="panel-heading">
            STUDENT VIEW GRADES   <b> <?=$set_sem_w['sy']?> <?=$set_sem_w['csem']?> </b>
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">
            <form method="POST" class="form-inline" id="teacher_sched_sem_sy">

                    <label class="mr-sm-2" for="set_sy">School Year</label>
                      <select class="custom-select mb-2 mr-sm-2 mb-sm-0  form-control" id="set_sy" name="set_sy">

                        <?php
                            foreach ($scool_year as $key => $value) {
                               if($set_sy == $value->schoolyear){
                                    echo '<option value="'.$value->schoolyear.'" selected >'.$value->schoolyear.'</option> ';
                               }else{
                                    echo '<option value="'.$value->schoolyear.'" >'.$value->schoolyear.'</option> ';
                               }
                            }
                        ?>
                      </select>

                    <label class="mr-sm-2" for="set_sem">Sem</label>
                      <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control" id="set_sem" name="set_sem">
                        <option selected value="<?=$set_sem?>"><?=$sem_w?></option>
                        <option value="1">First Semester</option>
                        <option value="2">Second Semester</option>
                        <option  value="3">Summer</option>
                      </select>

                      <button type="button" class="btn btn-primary" onclick="$(this).changeSemSy();">GO</button>
            </form>

                  <div id="data_search_output" >
                    <form method="POST" id="grades_view_form" action="<?=base_url('admin_registrar/student_grades_submission/save_st_grade_view')?>" >
                        <input type="hidden" name="sem_x_s" value="<?=$set_sem_w['sem']?>">
                        <input type="hidden" name="sy_x_s" value="<?=$set_sem_w['sy']?>">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                    <input type="date" class="form-control" name="set_all_date" id="set_all_date" value="<?=date('Y-m-d')?>" >
                            </div>

                            <div class="col-md-2">
                                 <input type="checkbox" class="form-control" name="set_all_check" id="set_all_check" value="true"  > set all to this date
                            </div>
                        </div>

                        <?php

                            echo ($table);
                            if($table_empty == 2):
                        ?>
                        <div class="col-lg-12">
                            <button type="submit" class="form-control btn btn-primary" name="save_st_grade_view" id="save_st_grade_view" value="true">SAVE</button>
                        </div>
                        <?php
                            endif;
                        ?>
                    </form>

            </div>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->

</div><!-- /#page-wrapper -->