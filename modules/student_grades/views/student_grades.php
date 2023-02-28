<?php
 $sem=$sem_sy['sem_sy'][0]->sem;
 $sy=$sem_sy['sem_sy'][0]->sy;
?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                        
                    </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
            <form id="viewGrade">
                <div class="col-md-8">
                    <div class="form-group col-md-4">
                        <label class="sr-only">Semester</label>
                        <select name="sem" id="sem" class="form-control" required>
                                <option value="<?=$sem?>"><?=$sem_sy['sem_sy_w']['csemword']?></option>
                                <option value="1">First Semester</option>
                                <option value="2">Second Semester</option>
                                <option value="3">Summer</option>
                        </select>
                        </div>
                          <div class="form-group col-md-3">
                        <select name='year' id='year' class='form-control' required>
                        <option value="<?=$sy?>"><?=$sy?></option>
                        <?php
                         echo '<optgroup data-type="simple" label="School Year">';
                                for($x=0;$x<count($subject_year);$x++){
                                        echo '<option value="'.$subject_year[$x]->year.'">'.$subject_year[$x]->year.'</option>';
                                }
                          echo '</optgroup>';
                        if(count($t_subject_year)>0){
                            for($x=0;$x<count($t_subject_year);$x++){
                                echo '<optgroup data-type="tranfeeree" label="'.$t_subject_year[$x]->school.'">';
                                        for($x=0;$x<count($t_subject_year);$x++){
                                                echo '<option value="'.$t_subject_year[$x]->sy.'">'.$t_subject_year[$x]->sy.'</option>';
                                        }
                                echo '</optgroup>';
                             }
                        }

                         if(count($o_subject_year)>0){
                            for($x=0;$x<count($o_subject_year);$x++){
                                echo '<optgroup data-type="old_subjects" label="'.$o_subject_year[$x]->school.'">';
                                        for($x=0;$x<count($o_subject_year);$x++){
                                                echo '<option value="'.$o_subject_year[$x]->sy.'">'.$o_subject_year[$x]->sy.'</option>';
                                        }
                                echo '</optgroup>';
                             }
                        }

                        ?>
                        </select>
                        </div>
                         <div class="form-group col-md-3">
                         <button class="btn btn-success btn-sm" type="submit" name="viewGrade">view <i class="glyphicon glyphicon-arrow-right"></i></button>
                         </div>
                    </div>
                    </form>
                </div>
                <!-- /.col-lg-12 -->
                <div id="grades"></div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>