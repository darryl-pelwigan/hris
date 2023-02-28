
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


?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grades</h1>
             <a href='<?=base_url()?>check_submitted/check_submitted_registrar/view_grades?data_key=<?=$sched_id?>'>&#8592; Back</a><br/>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
<form method="post" id="save_grade_ratification_form" action="<?=base_url()?>grade_ratification/save_grade_ratify">

    <input type="hidden" name="sched_id" value="<?=$sched_id?>" />
    <input type="hidden" name="studentid" value="<?=$student_id?>" />
    <div class="panel panel-default">
    	<div class="panel-heading">
    		Grade Rectifying Record
    	</div>
    	<div class="panel-body">


            <table class="table table-condense">
                    <tbody>
                        <tr>
                            <td class="text-left">Name: </td>
                            <td class="text-left"><strong> <?=strtoupper($student_info[0]->FirstName)?> <?=isset($student_info[0]->MiddleName)?> <?=strtoupper($student_info[0]->LastName)?>  </strong></td>
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
                        <td>Remarks</td>
    				</thead>
    				<tr>
    					<?php if($div == 3): ?>
                        <td><input class="form-control text-right grade" type="number" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->prelim : $subject_grades[0]->prelim ?>" id="prelim" name="prelim"  /></td>
                        <?php endif; ?>
			  			<td><input class="form-control text-right grade" type="number" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->midterm : $subject_grades[0]->midterm ?>"  id="midterm" name="midterm"  /></td>
                        <td><input class="form-control text-right tfinal_grade grade" id="tentative" name="tentative" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->tentativefinal : $subject_grades[0]->tentativefinal ?>"  min="0" step="0.1" max='99' type="number" required  /></td>


			  			<td><input class="form-control text-right" type="number" id="final_grade" name="final_grade" value="" readonly required /></td>
    				    <td>

                                 <select class="form-control" id="grade_remarks" name="grade_remarks" required>
                                <option value="" data_index="0"></option>
                                <option value="Passed" data_index="1"  >Passed</option>
                                <option value="Failed" data_index="2" >Failed</option>
                                <option value="No Final Examination" data_index="3" >No Final Examination</option>
                                <option value="No GRADE" data_index="4" >No Grade</option>
                                <option value="Incomplete" data_index="5" >Incomplete</option>
                                <option value="No CREDIT" data_index="6" >No Credit</option>
                                <option value="DROPPED" data_index="7" >Dropped</option>
                                <option value="Withdrawal with Permission" data_index="8" >Withdrawal with Permission</option>
                                <option value="No Attendance" data_index="9" >No Attendance</option>

                            </select>
                        </td>

                    </tr>
    			</table>
                 <div class="form-group">
                        <textarea name="comment" class="form-control" placeholder="Enter Comment" required><?=isset($grade_completion[0]) ? $grade_completion[0]->comment : '' ?></textarea>
                </div>
    		</div>

    	</div>


    	<div class='panel-footer' style="margin-top: 20px;">
                            <input type="submit" class="btn btn-primary" id="save_grade_completion" value="SAVE" />

                <a class="btn btn-default pull-right" href='<?=base_url()?>check_submitted/check_submitted_registrar/view_grades?data_key=<?=$sched_id?>'>Back</a>
    	</div>
    </div>
</form>
</div> <!-- /#page-wrapper -->



