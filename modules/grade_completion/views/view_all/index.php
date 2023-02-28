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


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grades</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="panel panel-default">
    	<div class="panel-heading">
    		Completion List
    	</div>
    	<div class="panel-body">

           <div class="table-responsive">
               <form method="POST" class="form-inline hidden" id="teacher_sched_sem_sy">



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

             <table class="table table-condense" id="completion_list">
                <thead>
                    <tr>
                        <td>NO</td>
                        <td>Student ID</td>
                         <td>Name</td>
                        <td>COURSE & YEAR</td>
                        <td>SEM SCHOOLYEAR</td>
                        <td>SUBJECT</td>
                        <td>Teacher</td>
                        <td>Action</td>
                    </tr>
                </thead>
                    <tbody>
                        <?=$tbody?>
                    </tbody>
            </table>

        </div><!-- /.table-responsive -->








    	<div class='panel-footer'>

    	</div>
    </div>

</div> <!-- /#page-wrapper -->



