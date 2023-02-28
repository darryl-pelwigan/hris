<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grades</h1>
             <a href='<?=base_url()?>TeacherScheduleList'>&#8592; Back</a><br/>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
<form method="post" id="save_grade_completion_form" action="<?=base_url()?>grade_completion/save_grade_completion_print">

    <input type="hidden" name="sched_id" value="<?=$sched_id?>" />
    <input type="hidden" name="studentid" value="<?=$student_id?>" />
    <div class="panel panel-default">
    	<div class="panel-heading">
    		Completion Record xx
    	</div>
    	<div class="panel-body">

            <?php
            $mname = '';
                 if(($student_info[0]->MiddleName)){
                     $mname = $student_info[0]->MiddleName[0];
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
                            <td class="text-left" colspan="3" > <strong><?=strtoupper($subject_info2['sched_query'][0]->description)?></strong></td>
                        </tr>
                    </tbody>
            </table>

    		<div class='col-lg-12'>

    			<!-- <div class='col-lg-6'>
    				<label>Lecture</label>
			  		<table class='table' >
			  			<tr>
			  				<td>CS</td>
			  				<td>Exam</td>
			  				<td>Total</td>
			  			</tr>
			  			<tr>
			  				<td><input type="number" class="form-control text-righ"  min='0'  id="lec_cs" name="lec_cs"></td>
			  				<td><input type="number" class="form-control text-righ"  min='0'  id="lec_exam" name="lec_exam"></td>
			  				<td><input type="number" class="form-control text-righ lec_total"  id="lec_total" name="lec_total"  readonly></td>
			  			</tr>
			  		</table>
    			</div> -->

                <?php if($leclab): ?>
    		<!-- 	<div class='col-lg-6'>
    				<label>Lab</label>
			  		<table class='table' >
			  			<tr>
			  				<td>CS</td>
			  				<td>Exam</td>
			  				<td>Total</td>
			  			</tr>
			  			<tr>
			  				<td><input class="form-control text-right" type="number" min='0' id="lab_cs" name="lab_cs"></td>
			  				<td><input class="form-control text-right" type="number" min='0' id="lab_exam" name="lab_exam"></td>
			  				<td><input class="form-control text-right lab_total" type="number" id="lab_total" name="lab_total" readonly></td>
			  			</tr>
			  		</table>
    			</div>
    		</div> -->

            <?php endif; ?>
    		<!-- <div class="col-lg-12">
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
    					<td><input class="form-control  text-right" id="tfinal_lec_total" type="number" readonly></td>
                        <?php if($leclab): ?>
			  			<td><input class="form-control  text-right" id="tfinal_lab_total" type="number" readonly></td>
                        <?php endif; ?>
			  			<td><input class="form-control tfinal_grade" type="number" id="tfinal_grade" name="tfinal_grade" readonly></td>
    				</tr>
    			</table>
    		</div> -->

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
                        <td>REMARKS</td>
    				</thead>
    				<tr>
    					 <?php if($div == 3): ?>
                        <td><input class="form-control text-right" type="number" value="<?=$subject_grades[0]->prelim?>" id="prelim" name="prelim" readonly /></td>
                        <?php endif; ?>
			  			<td><input class="form-control text-right" type="number" value="<?=$subject_grades[0]->midterm?>"  id="midterm" name="" readonly /></td>
			  			<td><input class="form-control text-right tfinal_grade" id="tentative" name="tentative" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->tentativefinal : '' ?>"  min="0" step="0.1" max='99' type="number" required  /></td>
			  			<td><input class="form-control text-right" type="number" id="final_grade" name="final_grade" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->final_grade : '' ?>" readonly required /></td>
    				    <td><input readonly class="form-control text-right" type="text" value="<?=$grade_completion[0]->grade_remarks?>"   readonly></td>
                    </tr>
    			</table>
                 <div class="form-group">
                    <textarea name="remarks" class="form-control" placeholder="ENTER REMARKS" required><?=isset($grade_completion[0]) ? $grade_completion[0]->remarks : '' ?></textarea>
                </div>
    		</div>

    	</div>


    	<div class='panel-footer' style="margin-top: 20px;">


    			<?php if(!isset($grade_completion[0])): ?>
                        <button type="button" class="btn btn-primary" id="save_grade_completion">Save</button>
                <?php elseif(isset($grade_completion[0]) && $grade_completion[0]->is_printed == 0 ): ?>
                        <button type="button" class="btn btn-primary" id="save_grade_completion">Save</button>
                        <button type="button" class="btn btn-success"  title="PRINT" type="submit">Print</button>
                <?php else: ?>
                        <button type="button" class="btn btn-primary" id="save_grade_completion" type="submit">Print</button>
                <?php endif; ?>
                <button class="btn btn-default pull-right">Back</button>
    	</div>
    </div>
</form>
</div> <!-- /#page-wrapper -->



