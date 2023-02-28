<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">College Deans</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="panel panel-default">
        <div class="panel-heading">
            College Deans   <b> <?=$sem_sy['sem_sy_w']['sy2']?> <?=$sem_sy['sem_sy_w']['csem']?> </b>
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">

                   <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>COLLEGE DEPARTMENT</th>
                                        <th>DEAN</th>
                                        <th>Date Start</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                      <?php
                                          $count= 1;

                                          

                                                foreach ($college as $key => $value) {
                                                        $dean = '<div class="form-group"><input type="text" id="assigned_dean_'.$value->DEPTID.'" class="form-control assigned_dean" onfocus="$(this).searchTeacher(\''.$value->DEPTID.'\');" /><input type="hidden" id="assigned_dean_id_'.$value->DEPTID.'"  />  </div>';
                                                        $assign ='<button class="btn btn-primary btn-xs " onclick="$(this).assignDeans(\''.$value->DEPTID.'\'); " title="save" ><i class="glyphicon glyphicon-floppy-disk"></i></button> ';
                                                        $date_started = '<div class="input-group date datetimepicker1"><input type="text" id="assigned_dean_datestarted_'.$value->DEPTID.'" class="form-control" /> <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div>';
                                                        if(isset($college_deans[$key])  ){
                                                           $dean = $college_deans[$key]->LastName .' , '. $college_deans[$key]->FirstName .' , '. $college_deans[$key]->MiddleName  ;
                                                             $assign ='<button class="btn btn-danger btn-sm" onclick="$(this).removeDean(\''.$value->DEPTID.'\',\''.$college_deans[$key]->cd_id.'\'); " ><i class="glyphicon glyphicon-trash"></i></button> ';
                                                          
                                                           $date_started = $college_deans[$key]->date_started;
                                                           
                                                        }
                                                      echo '<tr>';
                                                          echo '<td>'.$count.'</td>';
                                                          echo '<td id="dept_'.$value->DEPTID.'" >'.$value->DEPTNAME.'</td>';
                                                          echo '<td id="teacher_'.$value->DEPTID.'" >'.$dean.'</td>';
                                                          echo '<td style="width:190px;">'.$date_started.'</td>';
                                                          echo '<td>'.$assign.'</td>';
                                                      echo '</tr>';
                                                  $count++;
                                          }
                                      ?>
                                    </tbody>

                    </table>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->

</div><!-- /#page-wrapper -->