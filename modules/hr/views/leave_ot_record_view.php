<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Leave, Overtime, Pass Slip and Travel Records</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="col-lg-12">
    	<div>
		  	<ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#leave" aria-controls="leave" role="tab" data-toggle="tab">Leave Records</a></li>
			    <li role="presentation"><a href="#overtime" aria-controls="overtime" role="tab" data-toggle="tab">Overtime Records</a></li>
			    <li role="presentation"><a href="#payslip" aria-controls="payslip" role="tab" data-toggle="tab">Pass Slip Records</a></li>
			    <li role="presentation"><a href="#travel" aria-controls="travel" role="tab" data-toggle="tab">Travel Order Records</a></li>
		  	</ul>

			 <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="leave">
			    	
				    <div class="panel panel-default">
				        <div class="panel-heading">
				            Leave Records
				        </div>
				        <div class="panel-body">
				            <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newleave" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newleave"><i class="glyphicon glyphicon-pencil"></i> Add New</button>
				           
				            <table class="table table-bordered display responsive compact small" width="100%%" id="summary_leave_records">
				                 <thead>
                                    <tr>
                                        <th>Options</th>
                                        <th>Biometrics</th>
                                        <th>FileNo</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Department</th>
                                        <th>Leave Type</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>No. of Days</th>
                                        <th>Reason</th>
                                        <th>Days with Pay</th>
                                        <th>Days without Pay</th>
                                    </tr>
                                </thead>
				            </table>
				        </div>
				    </div>

			    </div>
			    
			    <div role="tabpanel" class="tab-pane" id="overtime">
			    	 <div class="panel panel-default">
				        <div class="panel-heading">
				            Overtime Records
				        </div>
				        <div class="panel-body">
				            <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newovetime" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newovetime"><i class="glyphicon glyphicon-pencil"></i> Add New</button>
				            
				            <table class="table table-bordered display compact small emp_overtime_records" cellspacing="0" width="100%">
				                <thead>
				                    <tr>
				                    	<th>Options</th>
				                        <th>FileNo</th>
				                        <th>Name</th>
				                        <th>Position</th>
				                        <th>Department</th>
				                        <th>Date</th>
				                        <th>Time From</th>
				                        <th>Time To</th>
				                        <!-- <th>Hours Requested</th> -->
				                        <th>Hours Rendered</th>
				                        <th>Reason</th>
				                        <th>Date Head Approved</th>
				                        <th>Remarks</th>
				                    </tr>
				                </thead>
				                <tbody></tbody>
				            </table>
				        </div>
				    </div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="payslip">
			    	<div class="panel panel-default">
				        <div class="panel-heading">
				            Pass Slip Records (Personal)
				        </div>
				        <div class="panel-body">
				            <!-- <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newpasslip" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newpasslip"><i class="glyphicon glyphicon-pencil"></i> Add New</button> -->

				            <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newpasslip" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newpasslip" id="add_new_personal"><i class="glyphicon glyphicon-pencil"></i> Add New</button>
				            
				            <table class="table table-bordered display responsive compact small emp_payslip_records_summary" cellspacing="0" width="100%">
				                <thead>
				                    <tr>
				                    	<th>Options</th>
				                        <th>FileNo</th>
				                        <th>Name</th>
				                        <th>Position</th>
				                        <th>Department</th>
				                        <th>Date</th>
				                        <th>Time From</th>
				                        <th>Time To</th>
				                        <th>Number of Hours</th>
				                        <th>Reason</th>
				                        <th>Date Head Approved</th>
				                    </tr>
				                </thead>
				                <tbody></tbody>
				            </table>
				        </div>
				    </div>

			    	<div class="panel panel-default">
				        <div class="panel-heading">
				            Pass Slip Records (Official Business)
				        </div>
				        <div class="panel-body">
				            <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newpasslip" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newpasslip" id="add_new_official"><i class="glyphicon glyphicon-pencil"></i> Add New</button>
				            
				            <table class="table table-bordered display responsive compact small emp_official_payslip_records_summary" cellspacing="0" width="100%">
				                <thead>
				                    <tr>
				                    	<th>Options</th>
				                        <th>FileNo</th>
				                        <th>Name</th>
				                        <th>Position</th>
				                        <th>Department</th>
				                        <th>Date</th>
				                        <th>Time From</th>
				                        <th>Time To</th>
				                        <th>Number of Hours</th>
				                        <th>Reason</th>
				                        <th>Date Head Approved</th>
				                    </tr>
				                </thead>
				                <tbody></tbody>
				            </table>
				        </div>
				    </div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="travel">
			    	<div class="panel panel-default">
				        <div class="panel-heading">
				            Travel Order Records
				        </div>
				        <div class="panel-body">
				            <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newtravelform" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newtravelform"><i class="glyphicon glyphicon-pencil"></i> Add New</button>
				            
				            <table class="table table-bordered display responsive compact small emp_travel_order_records" cellspacing="0" width="100%">
				                <thead>
				                    <tr>
				                    	<th>Options</th>
				                        <th>FileNo</th>
				                        <th>Name</th>
				                        <th>Position</th>
				                        <th>Department</th>
				                        <th>Date</th>
				                        <th>Date From</th>
				                        <th>Date To</th>
				                        <th>Destination</th>
				                        <th>Purpose</th>
				                        <th>Date Head Approved</th>
				                        <th>Remarks</th>
				                    </tr>
				                </thead>
				                <tbody></tbody>
				            </table>
				        </div>
				    </div>
			    </div>
			 </div>
		</div>
	</div>  
</div> <!-- #page-wrapper -->
