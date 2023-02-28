
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

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grades</h1>
             <a href='<?=base_url()?>check_submitted/check_submitted_registrar/view_grades?data_key=<?=$sched_id?>'>&#8592; Back</a><br/>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
<form method="post" id="save_grade_completion_form" action="<?=base_url()?>grade_completion/save_grade_completion_print">

    <input type="hidden" name="sched_id" value="<?=$sched_id?>" />
    <input type="hidden" name="studentid" value="<?=$student_id?>" />
    <div class="panel panel-default">
    	<div class="panel-heading">
    		Completion Record
    	</div>
    	<div class="panel-body">
    	

            <table class="table table-condense">
                    <tbody>
                        <tr>
                            <td class="text-left">Name: </td>
                            <td class="text-left"><strong> <?=strtoupper($student_info[0]->FirstName)?> <?=strtoupper($student_info[0]->MiddleName[0])?>. <?=strtoupper($student_info[0]->LastName)?>  </strong></td>
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
                            <td class="text-left" colspan="3" > <strong><?=strtoupper( $teacher_name )?></strong></td>
                        </tr>
                         <tr>
                            <td  class="text-left" >Schooly year and semester: </td>
                            <td class="text-left" colspan="3" > <strong><?=strtoupper($subject_info['sched_query'][0]->semester)?> - <?=strtoupper($subject_info['sched_query'][0]->schoolyear)?></strong></td>
                        </tr>
                    </tbody>
            </table>

    		<div class='col-lg-12'>
                

    		<div class="col-lg-12" style="margin-bottom: 25px;">
    			<label>Final Grade</label>
    			<table class="table">
    				<thead>
    					<?php if($div == 3): ?>
                        <td>Prelim Grade</td>
                        <?php endif; ?>
    					<td>Midterm Grade</td>
    					<td>Tentative Final Grade</td>
    					<td>Final Grade</td>
    				</thead>
    				<tr>
    					 <?php if($div == 3): ?>
                        <td><input class="form-control text-right" type="number" value="<?=$subject_grades[0]->prelim?>" id="prelim" name="prelim" readonly /></td>
                        <?php endif; ?>
			  			<td><input class="form-control text-right" type="number" value="<?=$subject_grades[0]->midterm?>"  id="midterm" name="" readonly /></td>

                        <?php if(isset($grade_completion[0])): ?>
                        <?php if(($grade_completion[0]->is_printed == 1)): ?>
                            <td><input class="form-control text-right tfinal_grade" id="tentative" name="tentative" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->tentativefinal : '' ?>"  min="0" step="0.1" max='99' type="number" required readonly /></td>
                        <?php else: ?>
                       <td><input class="form-control text-right tfinal_grade" id="tentative" name="tentative" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->tentativefinal : '' ?>"  min="0" step="0.1" max='99' type="number" required  /></td>
                    <?php endif; ?>
                    <?php else: ?>
                        <td><input class="form-control text-right tfinal_grade" id="tentative" name="tentative" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->tentativefinal : '' ?>"  min="0" step="0.1" max='99' type="number" required  /></td>
                    <?php endif; ?>

			  			
			  			<td><input class="form-control text-right" type="number" id="final_grade" name="final_grade" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->final_grade : '' ?>" readonly required /></td>
    				</tr>
    			</table>
                 <div class="form-group">

                    <?php if(isset($grade_completion[0])): ?>
                        <?php if(($grade_completion[0]->is_printed == 1)): ?>
                            <label>REMARKS : </label>
                            <?=isset($grade_completion[0]) ? $grade_completion[0]->remarks : '' ?>
                        <?php else: ?>
                        <textarea name="remarks" class="form-control" placeholder="ENTER REMARKS" required><?=isset($grade_completion[0]) ? $grade_completion[0]->remarks : '' ?></textarea>
                    <?php endif; ?>
                    <?php else: ?>
                        <textarea name="remarks" class="form-control" placeholder="ENTER REMARKS" required><?=isset($grade_completion[0]) ? $grade_completion[0]->remarks : '' ?></textarea>
                    <?php endif; ?>
                </div>
    		</div>
            
    	</div>


    	<div class='panel-footer' style="margin-top: 20px;">

    			  <?php if(isset($grade_completion[0])): ?>
                        <?php if(($grade_completion[0]->is_printed == 1)): ?>
                            <input type="hidden" name="sub_approve" value="1" />
                            <input type="submit" class="btn btn-primary" id="save_grade_completion" value="APPROVED" />
                        <?php else: ?>
                             <input type="hidden" name="sub_approve" value="0" />
                       <input type="submit" class="btn btn-primary" id="save_grade_completion" value="SAVE"> 
                    <?php endif; ?>
                    <?php else: ?>
                         <input type="hidden" name="sub_approve" value="0" />
                        <input type="submit" class="btn btn-primary" id="save_grade_completion"  value="SAVE">
                    <?php endif; ?>
                        
              
                <a class="btn btn-default pull-right" href='<?=base_url()?>check_submitted/check_submitted_registrar/view_grades?data_key=<?=$sched_id?>'>Back</a>
    	</div>
    </div>
</form>
</div> <!-- /#page-wrapper -->



