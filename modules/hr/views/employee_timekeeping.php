<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">TimeKeeping</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="panel panel-default">
    	<div class="panel-heading">
    		Employee Attendance
    	</div>
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
		                <label class="col-sm-offset-2 col-sm-2 control-label"></label>
		                <div class="col-sm-5">
		                    <button class="btn btn-success btn-sm" type="button" name="show" onclick="$(this).viewattendance();"><i class="fa fa-arrow-right"></i> Submit</button>
		                </div>
		            </div>
		        </form>
	        </div>

    		<table class="table table-bordered display compact small emp_timekeeping_tbl" cellspacing="0" width="100%">
	            <thead>
	                <tr>
	                    <th>Badge Number</th>
	                    <th>File No.</th>
	                    <th>Name</th>
	                    <th>Position</th>
	                    <th>Department</th>
	                    <th>DateTime</th>
	                    <th>Status</th>
	                    <th>Verify Code</th>
	                    <th>Location</th>
	                </tr>
	            </thead>
        	</table>
    	</div>
    </div>
</div> <!-- /#page-wrapper -->

