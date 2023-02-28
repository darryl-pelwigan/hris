<style type="text/css">
    table.dataTable.fixedHeader-floating {
         display: none !important; 
    }
     
    .dataTables_scrollHeadInner{
        margin-left: 0;
        width: 78% !important;
        position: fixed;
        display: block;
        overflow: hidden;
        margin-right: 0; /*30px*/
        background: white;
        z-index: 1000;
        padding-bottom: 8px;
    }
     
    .dataTables_scrollBody{
        padding-top: 60px;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Staff</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Lists
        </div>
        <div class="panel-body">
            <table id="emp_lists_inactive" style="cursor: pointer;" class="table table-bordered display compact small employee" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Change Status</th>
                        <th>Biometrics</th>
                        <th>FileNo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Date of Employment</th>
                        <th>Years of Service</th>
                        <th>Classification</th>
                        <th>Separation Details</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div> <!-- /#page-wrapper -->
