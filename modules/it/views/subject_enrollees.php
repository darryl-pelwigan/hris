<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                            	<tr>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td></td>
                                                </tr>

                                        <tr>
                                            <th>ID No</th>
                                            <th>Last Name</th>
                                            <th>Given Name</th>
                                            <th>Middle Name</th>
                                            <th>Course</th>
                                            <th>Date Admitted</th>
                                            <th>Student Type</th>
                                            <th>Assessment</th>
                                            <th>Payment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?=($table)?>
                                    </tbody>

                                </table>
                            </div><!-- /.table-responsive -->
     <!-- Core Scripts - Include with every page -->

 <script >
    $(document).ready(function() {
        $('.dataTables-example2').dataTable({"order":[7,"desc"]}).dataTableSearch();
    });
 </script>
