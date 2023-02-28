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
                            <td class="text-left" colspan="3" > <strong><?=strtoupper($subject_info2['sched_query'][0]->description)?></strong></td>
                        </tr>
                    </tbody>
            </table>

    		<div class='col-lg-12'>



    		<div class="col-lg-12" style="margin-bottom: 25px;">
    			<label>Final Grade</label>
    			<table class="table">
    				<thead>
    					<td>Tentative Final Grade</td>
    					<td>Final Grade</td>
                        <td>REMARKS</td>
    				</thead>
    				<tr>
			  			<td><input class="form-control text-right tfinal_grade" id="tentative" name="tentative" value="<?=isset($grade_completion[0]) ?  $grade_completion[0]->tentativefinal : '' ?>"  min="0" step="0.1" max='99' type="number" required  /></td>
			  			<td><input class="form-control text-right" type="number" id="final_grade" name="final_grade" value="<?=isset($grade_completion[0]) ? $grade_completion[0]->final_grade : '' ?>" readonly required /></td>
    				    <td><select class="form-control" id="final_ramarks" name="final_ramarks" >
                                <option value="" data_index="0"></option>
                            <?php
                                if( isset( $grade_completion[0] ) ){
                                    if( $grade_completion[0]->grade_remarks == 'Passed' ){
                                        echo '<option value="Passed" data_index="1" selected="">Passed</option><option value="Failed" data_index="2">Failed</option>';
                                        echo '<option value="No Grade" data_index="3" >No Grade</option>';
                                    }elseif( $grade_completion[0]->grade_remarks == 'Failed' ){
                                        echo '<option value="Passed" data_index="1">Passed</option><option value="Failed" data_index="2" selected="">Failed</option>';
                                        echo '<option value="No Grade" data_index="3" >No Grade</option>';
                                    }elseif( $grade_completion[0]->grade_remarks == 'No Grade' ){
                                        echo '<option value="Passed" data_index="1">Passed</option><option value="Failed" data_index="2" >Failed</option><option value="No Grade" data_index="3" selected="" >No Grade</option>';

                                    }else{
                                         echo '<option value="Passed" data_index="1">Passed</option><option value="Failed" data_index="2">Failed</option>';
                                    }
                                 }else{
                                    echo '<option value="Passed" data_index="1">Passed</option><option value="Failed" data_index="2">Failed</option>';
                                    echo '<option value="No Grade" data_index="3" >No Grade</option>';
                                }

                            ?>


                            </select>
                        </td>
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
                        <button type="submit" class="btn btn-success"  title="PRINT" type="submit">Print</button>
                <?php else: ?>
                        <button type="button" class="btn btn-primary" id="save_grade_completion">Save</button>
                        <button type="submit" class="btn btn-primary" id="save_grade_completion" type="submit">Print</button>
                <?php endif; ?>
                <button class="btn btn-default pull-right">Back</button>
    	</div>
    </div>
</form>
</div> <!-- /#page-wrapper -->



