<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grades</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
<form method="post" id="save_grade_completion_form"  action="<?=base_url()?>grade_completion/save_grade_completion_print">
      <input type="hidden" name="sched_id" value="<?=$sched_id?>" />
    <input type="hidden" name="studentid" value="<?=$student_id?>" />
    <input type="hidden" name="leclab" value="<?=$leclab?>" />
    <div class="panel panel-default">
    	<div class="panel-heading">
    		Completion Record
    	</div>
    	<div class="panel-body">

        <?php
                $teacher_name = '';
                  if($check_sched[0]['lecunits']>0){
                    $teacher_name = $check_sched[0]['teacher_name'];
                  }else{
                    if(isset($check_sched[1]['teacher_name'])){
                         $teacher_name = $check_sched[1]['teacher_name'];
                    }else{
                        $teacher_name = $check_sched[0]['teacher_name'];
                    }
                  }

                $lec_cs_prcnt = 50;
                $lec_exam_prcnt = 50;

                $lab_cs_prcnt = 50;
                $lab_exam_prcnt = 50;



                  if(isset($grade_completion[0])){
                    $lec_p = json_decode($grade_completion[0]->lec_percentage);
                    $lab_p = json_decode($grade_completion[0]->lab_percentage);
                    if($lec_p){
                        $lec_cs_prcnt = $lec_p->lec_cs;
                        $lec_exam_prcnt = $lec_p->lec_exam;
                    }

                    if($leclab && $lab_p){
                        $lab_cs_prcnt = $lab_p->lab_cs;
                        $lab_exam_prcnt = $lab_p->lab_exam;
                    }
                  }


                  $mname = '';

                  if(($student_info[0]->MiddleName)){
                     $mname = $student_info[0]->MiddleName[0];
                  }
                  $lec = '60';
                  $lab = '40';
                        $percentage = json_decode($lec_lab);
                            if($percentage){
                                $lec = $percentage->lec;
                                $lab = $percentage->lab;
                            }

        ?>

            <table class="table table-condense">
                    <tbody>
                        <tr>
                            <td class="text-left">Name: </td>
                            <td class="text-left"><strong> <?=strtoupper($student_info[0]->FirstName)?> <?=strtoupper($mname)?>. <?=strtoupper($student_info[0]->LastName)?>  </strong></td>
                            <td class="text-left" style="width: 70px;">I.D. No.:</td>
                            <td  class="text-left"> <strong><?=$student_id?></strong></td>
                        </tr>

                        <tr>
                            <td  class="text-left" style="width: 120px; " >Course and Year: </td>
                            <td class="text-left" colspan="3"><strong><?=strtoupper($student_info[0]->code)?> - <?=strtoupper($student_info[0]->yearlvl)?></strong></td>
                        </tr>

                        <tr>
                            <td  class="text-left" >Subject: </td>
                            <td class="text-left" colspan="3" > <strong><?=strtoupper($subject_info2['sched_query'][0]->description)?></strong></td>
                        </tr>

                         <tr>
                            <td  class="text-left" >Instructor: </td>
                            <td class="text-left" colspan="3" > <strong><?=strtoupper($teacher_name)?></strong></td>
                        </tr>
                    </tbody>
            </table>

    		<div class='col-lg-12'>

    			<div class='col-lg-6'>
    				<label>Lecture</label>
			  		<table class='table' >
			  			<tr>
			  				<td>CS</td>
			  				<td>Exam</td>
			  				<td>Total</td>
                            <td colspan="2"></td>
			  			</tr>
			  			<tr>
			  				<td><input type="number" class="form-control text-right"  min='0' step="0.01" id="lec_cs" name="lec_cs" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->lec_cs : '' ?>" /></td>
			  				<td><input type="number" class="form-control text-right"  min='0' step="0.01"  id="lec_exam" name="lec_exam" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->lec_exam : '' ?>" /></td>
			  				<td><input type="number" class="form-control text-right lec_total" step="0.01"  id="lec_total" name="lec_total"  readonly value="<?=isset($grade_completion[0]) ? $grade_completion[0]->lec_total : '' ?>" /></td>
			  			    <td colspan="2">Tenative Grade Computed</td>
                        </tr>
                        <tr>
                            <td><input type="number" class="form-control text-right"  min='0' max="100" step="1" id="lec_cs_prcnt" name="lec_p[lec_cs]" value="<?=$lec_cs_prcnt?>" /></td>
                            <td><input type="number" class="form-control text-right"  min='0' max="100" step="1"  id="lec_exam_prcnt" name="lec_p[lec_exam]" value="<?=$lec_exam_prcnt?>" readonly /></td>
                            <td><input type="number" class="form-control text-right lec_total_prcnt" step="0.01"  id="lec_total_prcnt" name="lecp_total"  readonly value="<?=$lec_cs_prcnt+$lec_exam_prcnt?>" /></td>
                            <td colspan="2">PERCENTAGE</td>
                        </tr>
			  		</table>
    			</div>

                <?php if($leclab): ?>
    			<div class='col-lg-6'>
    				<label>Lab</label>
			  		<table class='table' >
			  			<tr>
			  				<td>CS</td>
			  				<td>Exam</td>
			  				<td>Total</td>
                             <td colspan="2"></td>
			  			</tr>
			  			<tr>
			  				<td><input class="form-control text-right" type="number" min='0' step="0.01" max="100" id="lab_cs" name="lab_cs" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->lab_cs : '' ?>" /></td>
			  				<td><input class="form-control text-right" type="number" min='0' step="0.01" max="100" id="lab_exam" name="lab_exam" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->lab_exam : '' ?>" /></td>
			  				<td><input class="form-control text-right lab_total" type="number" step="0.01" id="lab_total" name="labp_total" readonly value="<?=isset($grade_completion[0]) ? $grade_completion[0]->lab_total : '' ?>" /></td>
			  			    <td colspan="2">Tentative Grade Computed</td>
                        </tr>

                         <tr>
                            <td><input type="number" class="form-control text-right"  min='0' step="1" id="lab_cs_prcnt" name="lab_p[lab_cs]" value="<?=$lab_cs_prcnt?>" /></td>
                            <td><input type="number" class="form-control text-right"  min='0' step="1"  id="lab_exam_prcnt" name="lab_p[lab_exam]" value="<?=$lab_exam_prcnt?>" readonly /></td>
                            <td><input type="number" class="form-control text-right lab_total_prcnt" step="0.01"  id="lab_total_prcnt" name="lab_total"  readonly value="<?=$lab_cs_prcnt+$lab_exam_prcnt?>" /></td>
                            <td colspan="2">PERCENTAGE</td>
                        </tr>
			  		</table>
    			</div>
    		</div>

            <?php endif; ?>


            <?php if($leclab): ?>
                        <div class="col-lg-12">
                                <label>Lecture AND LABAORATORY PERCENTAGE</label>
                                <table class="table">
                                    <thead>
                                        <td>Lecture</td>
                                        <td>Laboratory</td>
                                        <td>Total</td>
                                    </thead>
                                    <tr>
                                        <td><input class="form-control text-right" type="number" min='0' step="0.01" max="100" id="lec_percnt" name="lec_percnt" value="<?=$lec?>" /></td>
                                        <td><input class="form-control text-right" type="number" min='0' step="0.01" max="100" id="lab_percnt" name="lab_percnt" value="<?=$lab?>" /></td>
                                        <td id="total_percentage"><?=$lec + $lab ?></td>
                                    </tr>
                                </table>
                        </div>
            <?php endif; ?>


    		<div class="col-lg-12">
    			<label>Tentative Final Grade</label>
    			<table class="table">
    				<thead>
    					<td>Lecture</td>
                        <?php if($leclab): ?>
    					   <td>Laboratory</td>
                         <?php endif; ?>
    					<td>Total</td>
    				</thead>
    				<tr>

                        <?php
                                $tfinal_lab_total = 0;
                                if(!$leclab):
                                    $lec_p = 1;
                                    $lab_p = 1;
                                else:
                                    $lec_p = 0.6;
                                    $lab_p = 0.4;
                                    $tfinal_lab_total = isset($grade_completion[0]) ? number_format( $grade_completion[0]->lab_total * $lab_p,2) : '';
                                endif;
                                $tfinal_lec_total = isset($grade_completion[0]) ? number_format( $grade_completion[0]->lec_total * $lec_p,2) : '';



                                $tfinal_grade =  $tfinal_lec_total + $tfinal_lab_total;


                        ?>
    					<td><input class="form-control  text-right" id="tfinal_lec_total" step="0.01" type="number" value="<?=$tfinal_lec_total?>" readonly /></td>
                        <?php if($leclab): ?>
			  			<td><input class="form-control  text-right" id="tfinal_lab_total" step="0.01" type="number" value="<?=$tfinal_lab_total?>" readonly /></td>
                        <?php endif; ?>
			  			<td><input class="form-control tfinal_grade"  step="0.01" type="number" id="tfinal_grade" name="tfinal_grade" value="<?=$tfinal_grade?>" readonly /></td>
    				</tr>
    			</table>
    		</div>



    		<div class="col-lg-12">
    			<label>Final Grade</label>
    			<table class="table">
    				<thead>
                        <?php $final_grade = number_format( ($subject_grades[0]->prelim + $subject_grades[0]->midterm +  $tfinal_grade) / $div ,2); ?>
                        <?php if($div == 3): ?>
    					<td>Prelim Grade</td>
                        <?php endif; ?>
    					<td>Midterm Grade</td>
    					<td>Tentative Final Grade</td>
    					<td>Final Grade</td>
                        <td>Remarks</td>
    				</thead>
    				<tr>

                         <?php
                                $passed_g = '';
                                $failed_g = '';
                                $nograde_g = '';
                                 if(isset($grade_completion[0])):

                                    if($grade_completion[0]->grade_remarks == 'Passed'):
                                        if($final_grade < 75 ){
                                            $final_grade = 75;
                                        }
                                        $passed_g = 'selected';
                                    elseif($grade_completion[0]->grade_remarks == 'Failed'):
                                        $failed_g = 'selected';
                                    elseif($grade_completion[0]->grade_remarks == 'No'):
                                        $nograde_g = 'selected';
                                    endif;
                                    $final_grade = finalg($final_grade ,$grade_completion[0]->grade_remarks);
                                endif;

                            ?>


                        <?php if($div == 3): ?>
    					<td><input class="form-control text-right" type="number" step="0.01" value="<?=$subject_grades[0]->prelim?>" id="prelim" name="prelim" readonly /></td>
			  			<?php endif; ?>
                        <td><input class="form-control text-right" type="number" step="0.01" value="<?=$subject_grades[0]->midterm?>"  id="midterm" name="" readonly /></td>
			  			<td><input class="form-control text-right tfinal_grade" step="0.01" id="tentative" name="tentative" max='99' type="number" value="<?=$tfinal_grade?>"  readonly /></td>
			  			<td><input class="form-control text-right" type="number" step="0.01" id="final_grade" name="final_grade" value="<?=$final_grade?>"   readonly></td>
                        <td>




                            <select class="form-control" id="grade_remarks" name="grade_remarks" required>
                                <option value="" data_index="0"></option>
                                <option value="Passed" data_index="1" <?=$passed_g?> >Passed</option>
                                <option value="Failed" data_index="2" <?=$failed_g?> >Failed</option>
                                <option value="No Grade" data_index="3" <?=$nograde_g?> >No Grade</option>

                            </select>
                        </td>
    				</tr>
    			</table>

                 <div class="form-group">
                    <textarea name="remarks" class="form-control" placeholder="ENTER REMARKS" required><?=isset($grade_completion[0]) ? $grade_completion[0]->remarks : '' ?></textarea>
                </div>
    		</div>
    	</div>
    	<div class='panel-footer'>
    			<?php if(!isset($grade_completion[0])): ?>
    			        <button type="button" class="btn btn-primary" id="save_grade_completion">Save</button>
                <?php elseif(isset($grade_completion[0]) && $grade_completion[0]->approved_by_registrar == NULL ): ?>
                        <button type="button" class="btn btn-primary" id="save_grade_completion">Save</button>
                        <button  class="btn btn-success"  title="PRINT" type="submit">Print</button>
                <?php else: ?>
                        <button  class="btn btn-primary" type="submit">Print</button>
                <?php endif; ?>
                <button class="btn btn-default pull-right">Back</button>
    	</div>
    </div>
</form>
</div> <!-- /#page-wrapper -->



