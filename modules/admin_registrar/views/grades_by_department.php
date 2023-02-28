 <?php
    $syx =  explode('-',$sem_sy['sem_sy'][0]->sy);
    $syx =  ($syx[0]-1).'-'.($syx[1]-1);

    $sem_w = '';

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

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Department GRADES</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="panel panel-default">
        <div class="panel-heading">
            View Grades
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">

                <div class="row">
                    <div class="col-md-10">
                        <form role="form" class="form-inline" id="SubEnrolleesSearch">
                          <div class="form-group">
                            <label for="SearchBy">Search By : </label>
                            <select class="form-control" id="SearchBy">
                                 <optgroup label="">
                                 <option>All</option>
                                  </optgroup>
                                <optgroup label="Course Info">
                                    <option>Course</option>
                                    <option>Year Level</option>
                                    <option>Curriculum</option>
                                    <option>Section</option>
                                </optgroup>
                                <optgroup label="Subject Info">
                                    <option>Assigned Teacher</option>
                                    <option>Course No</option>
                                    <option>Descriptive Title</option>
                                    <option>Room</option>
                                </optgroup>

                            </select>
                        </div>
                        <br />
                        <div style="margin-top:5px;" id="search_here"></div>
                    </form>


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
            <button type="button" class="btn btn-primary" onclick="$(this).changeSemSy();">Submit</button>
        </form>

                </div>
            </div>


            <div id="data_search_output" > <?=($table["table"])?></div>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->

</div><!-- /#page-wrapper -->

<div class="modal" id="enrollListModalSubject" tabindex="-1" role="dialog" aria-labelledby="enrollListModalSubjectLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="enrollListModalLabel">Subject Enrolled List</h4>
            </div>
            <div class="modal-body">


                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var base_url =  '<?=base_url()?>' ;
</script>