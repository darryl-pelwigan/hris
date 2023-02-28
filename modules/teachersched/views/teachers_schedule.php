<div id="page-wrapper">

<?php
    if($grade_submission['p']!=''){


?>
 <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">GRADE SUBMISSION DATES</h1>
                <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>GRADING</th>
                                <th>START</th>
                                <th>END</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

			if($set_sem != 3){

                       ?>
                            <tr>
                                <td>PRELIM</td>
                                <td><strong><?= isset($grade_submission['p'][0]->end_date) ? date('F d D Y h:m:i A',strtotime($grade_submission['p'][0]->start_date)) : '' ?></strong></td>
                                <td><strong><?= isset($grade_submission['p'][0]->end_date) ? date('F d D Y h:m:i A',strtotime($grade_submission['p'][0]->end_date))  : ''  ?></strong></td>
                            </tr>
                        <?php  } ?>
                            <tr>
                                <td>MIDTERM</td>
                                <td><strong><?= isset($grade_submission['m'][0]->end_date) ? date('F d D Y h:m:i A',strtotime($grade_submission['m'][0]->start_date))  : ''  ?></strong></td>
                                <td><strong><?= isset($grade_submission['m'][0]->end_date) ? date('F d D Y h:m:i A',strtotime($grade_submission['m'][0]->end_date))  : ''  ?></strong></td>
                            </tr>
                            <tr>
                                <td>FINALS</td>
                                <td><strong><?= isset($grade_submission['tf'][0]->end_date) ? date('F d D Y h:m:i A',strtotime($grade_submission['tf'][0]->start_date)) : '' ?></strong></td>
                                <td><strong><?= isset($grade_submission['tf'][0]->end_date) ? date('F d D Y h:m:i A',strtotime($grade_submission['tf'][0]->end_date)) : '' ?></strong></td>
                            </tr>
                        </tbody>
                </table>

            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

<?php
}
?>




<div class="row">
   <div class="col-lg-12">
        <h1 class="page-header">GRADE MEMO AND RULES</h1>
        <table class="table table-bordered table-hover" id="grade_memo">
                <thead>
                    <tr>
                        <th>MEMO DESCRIPTION</th>
                        <th>START</th>
                        <th>FILE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="info">
                        <td><strong>Final grade that falls from 74.5 to 74.9 will round to 75 and mark as PASSED</strong></td>
                        <td>December 18,2018</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<div class="row">
   <div class="col-lg-12">
        <h1 class="page-header">TRANSMUTATION TABLE</h1>
          <form method="POST" class="form-inline" id="grades_transmutation">
            <div class="form-group">
                <label class="mr-sm-2" for="total_score">TOTAL SCORE</label>
                <input type="number" class="form-control" id="total_score" name="total_score" required>
            </div>
            <div class="form-group">
                <label class="mr-sm-2" for="base_trans">BASE</label>
                <input type="number" class="form-control" id="base_trans" name="base_trans" value="55">
            </div>
        <button type="button" class="btn btn-primary" onclick="$(this).get_transmutation();">Submit</button>
        </form>
        <table class="table table-bordered table-hover" id="transmutation">
            <thead>
                <tr>
                    <th>SCORE</th>
                    <th>EQUIVALENT</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->


        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Schedule List</h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <form method="POST" class="form-inline" id="teacher_sched_sem_sy">

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
        $selected1 = 'selected';
        $selected2 = '';

        if($this->session->userdata('new_sem_Sy')['sy'] != NULL && $this->session->userdata('new_sem_Sy')['sy'] != $sem_sy['sem_sy'][0]->sy){
            $selected2 = 'selected';
            $selected1 = '';
        }


      ?>



        <label class="mr-sm-2" for="set_sy">SELECT School Year</label>
          <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="set_sy" name="set_sy">
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

        <label class="mr-sm-2" for="set_sem">SELECT Sem</label>
          <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="set_sem" name="set_sem">
            <option selected value="<?=$set_sem?>"><?=$sem_w?></option>
            <option value="1">First Semester</option>
            <option value="2">Second Semester</option>
            <option  value="3">Summer</option>
          </select>
        <button type="button" class="btn btn-primary" onclick="$(this).set_semsy();">Submit</button>
        </form>
        <table id="example" class="display" cellspacing="0" >
            <thead>
                <tr>
                    <!-- <th></th> -->
                    <th>CourseNo</th>
                    <th>Description</th>
                    <th>Days</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Room</th>
                    <th>Section</th>
                    <th>Course</th>
                    <th>View Records</th>
                    <th>GRADES</th>
                </tr>
            </thead>
        </table>

    </div> <!-- /#page-wrapper -->

<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="dailyenrolleesModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center" id="dailyenrolleesModalLabel"><b>PRIVACY NOTICE</b></h3>
            </div>
                <div class="modal-body">
                    <h4>WE COLLECT PERSONAL DATA</h4>

                    <p>Pines City Colleges is the data controller of the data you provide to us.  This means the school determines the purposes for which, and the manner in which, any personal data relating to students, their families, guests, and visitors are to be processed. </p>

                    <p>In some cases, your data will be outsourced to a third-party processor; however, this will only be done with your consent, unless the law requires the school to share your data.  Where the school outsources data to a third-party processor, the same data protections standards that the school upholds are imposed on the processor.  </p>

                    <h4>OUR PURPOSE FOR COLLECTING</h4>

                    <p>Pines City Colleges holds the legal right to collect and use personal data relating to students and their families.  We may also receive information regarding them from their previous school.  We collect and use personal data in order to meet legal requirements and legitimate interests set out in the Data Privacy Act of 2012.  </p>

                    <p>This information will only be collected for the purposes necessary to the functions and activities of the school.  The categories of information that the school collects, holds, and shares include the following, among others: (1) Personal Information – e.g. names, addresses; (2) Characteristics – e.g. ethnicity, language, nationality; (3) Attendance Information – e.g. number of absences, reasons; (4) Assessment information – e.g. grades; (5) Relevant medical information.</p>

                    <h4>WHAT WE DO WITH COLLECTED PERSONAL DATA</h4>

                    <p>To the extent permitted or required by law, we use your personal data to pursue our legitimate interests as an educational institution, including a variety of academic, administrative, research, historical, and statistical purposes. </p>

                    <p>Your personal data is stored and transmitted securely in a variety of paper and electronic formats, including databases that are shared between the school’s different units or offices. Access to your personal data is limited to school personnel who have a legitimate interest in them for the purpose of carrying out their contractual duties. Rest assured that our use of your personal data will not be excessive.</p>

                    <p>Unless otherwise provided by law or by appropriate policies, we will retain your relevant personal data indefinitely for historical and statistical purposes. Where a retention period is provided by law and/or a school policy, all affected records will be securely disposed of after such period.</p>

                    <p>The school may, from time to time and at its sole discretion, review and update this policy to take account of new laws and technology, changes to the school’s operations and practices and to make sure it remains appropriate to the changing environment.  We will post and publish notice of any such modification, which shall be effective immediately upon posting or publication.</p>

                    <p>For inquiries, concerns, or questions regarding our Privacy Policy, you may email at  privacy@pcc.edu.ph or call 445-2209.</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </fxorm>
        </div>
    </div>
</div>
