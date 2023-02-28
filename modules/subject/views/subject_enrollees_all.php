
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Department Schedules</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div class="panel panel-default">
        <div class="panel-heading">
            Schedule List
        </div><!-- /.panel-heading -->
        <div class="panel-body">

            <div class="table-responsive">

                <div class="row">
                    <div class="col-md-10">
                        <form role="form" class="form-inline" id="SubEnrolleesSearch">
                          <div class="form-group">
                            <label for="SearchBy">Search By : </label>
                            <select class="form-control" id="SearchBy">
                                 <optgroup label="">
                                 <option>All</option>
                                  </optgroup>
                                <optgroup label="Course Info">
                                    <option>Course</option>
                                    <option>Year Level</option>
                                    <option>Curriculum</option>
                                    <option>Section</option>
                                </optgroup>
                                <optgroup label="Subject Info">
                                    <option>Assigned Teacher</option>
                                    <option>Course No</option>
                                    <option>Descriptive Title</option>
                                    <option>Room</option>
                                </optgroup>

                            </select>
                        </div>
                        <br />
                        <div style="margin-top:5px;" id="search_here"></div>
                    </form>
                </div>
            </div>


            <div id="data_search_output" > <?=($table["table"])?></div>

        </div><!-- /.table-responsive -->
    </div><!-- /.panel-body -->
</div><!-- /.panel -->

</div><!-- /#page-wrapper -->

<div class="modal" id="enrollListModalSubject" tabindex="-1" role="dialog" aria-labelledby="enrollListModalSubjectLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="enrollListModalLabel">Subject Enrolled List</h4>
            </div>
            <div class="modal-body">
                
              
                <div class="modal-footer">
                 
                </div>
                
            </div>
        </div>
    </div>
</div>