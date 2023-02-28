<div id="page-wrapper">

    <div class="panel panel-default">
    	<div class="panel-heading">
    		Update/Review Employee Attendance
    	</div>


<!--         <div class="panel-body">
            <form method="post" id="import_form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="" class="col-md-1">Filename</label>
                    <div class="col-md-4">
                    	<input type="file" name="file" id="file" required accept=".xls, .xlsx" class="form-control"/>
                    </div>
                </div>
                <button class="btn btn-success" name="submit" type="submit"><i class="fa fa-save"></i> UPLOAD</button>
            </form>
        </div>
 -->
    	<div class="panel-body">
    		<div class="">
	    		<form class="form-horizontal" method="post" id="attendance_from">

		            <div class="form-group">
		                <label class="col-sm-offset-2 col-sm-2 control-label">Date From:</label>
		                <div class="col-sm-5">
		                    <input type="text" class="form-control datepicker" name="datefrom" id="datefrom">
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-sm-offset-2 col-sm-2 control-label">Date To:</label>
		                <div class="col-sm-5">
		                    <input type="text" class="form-control datepicker" name="dateto" id="dateto">
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-sm-offset-2 col-sm-2 control-label">Department:</label>
		                <div class="col-sm-5">
		                	<select name="department" id="department" class="form-control"  required="">
		                		<option value="0"></option>
		                		<?php 
		                			foreach($dept_lists as $dept){
		                				echo '<option value="'.$dept->DEPTID.'">'.$dept->DEPTNAME.'</option>';
		                			}
		                		?>
		                	</select>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-sm-offset-2 col-sm-2 control-label">Classification:</label>
		                <div class="col-sm-5">
		                	<select name="teaching" id="teaching" class="form-control">
		                		<option value="1">Teaching</option>
		                		<option value="0">Non-Teaching</option>
		                	</select>
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-sm-offset-2 col-sm-2 control-label"></label>
		                <div class="col-sm-5">
		                    <button class="btn btn-success btn-sm" type="button" name="show" onclick="$(this).viewattendance();"><i class="fa fa-arrow-right"></i> Submit</button>
		                    <button class="btn btn-primary btn-sm" type="button" name="show" onclick="$(this).viewattendanceAttendance();"><i class="fa fa-file"></i> Generate PDF</button>
		                </div>
		            </div>
		        </form>
	        </div>
			<table class="table table-bordered display compact small emp_attendance_tbl" cellspacing="0" width="100%">
	            <thead>
	                <!-- <tr> -->
	<!--                     <th>File No.</th>
	                    <th>Name</th>
	                    <th>Department</th>
	                    <th>Classification</th>
	                    <th>Date</th>
	                    <th>Time</th>
	                    <th>Status</th>
	                    <th>Exception</th> -->

	          <!--           <th>Tardiness</th>
	                    <th>Under Time</th>
	                    <th>Over Time</th> -->
	                    <!-- <th></th> -->
	                <!-- </tr> -->

	                <tr>
	                    <th>Bio. No.</th>
	                    <th>File No.</th>
	                    <th>Name</th>
	                    <th>Department</th>
	                    <th>Classification</th>
	                    <th>Date</th>
	                    <th>Regular Hours</th>
	                    <th>Total Hours Rendered</th>
	                    <th>Tardiness</th>
	                    <th>Under Time</th>
	                    <th>Over Time</th>
	                    <th></th>
	                </tr>
	            </thead>
        	</table>
    	</div>
    </div>
</div> <!-- /#page-wrapper -->

<div id="view_attendance_data" title="Basic dialog">
  	
</div>


