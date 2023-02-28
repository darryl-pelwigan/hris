<div id="page-wrapper">

    <div class="panel panel-default">
    	<div class="panel-heading">
    		Update Employee Attendance
    	</div>


        <div class="panel-body">
            <form method="post" id="import_upload_attendance" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="" class="col-md-1">Filename</label>
                    <div class="col-md-4">
                    	<input type="file" name="file" id="file" required accept=".xls, .xlsx, .csv" class="form-control"/>
                    </div>
                </div>
                <button class="btn btn-success" name="submit" type="submit"><i class="fa fa-save"></i> UPLOAD</button>
            </form>

            <div id="loader" class="hide"></div>
            
            <hr>
            <div class="alert alert-success" id="myDiv" style="display:none;">
              <strong>Success!</strong> Successfully Uploaded Attendance
            </div>
        </div>
 
    </div>
</div> <!-- /#page-wrapper -->



