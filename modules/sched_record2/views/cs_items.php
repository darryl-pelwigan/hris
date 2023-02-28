<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>title</th>
                                            <th>Items</th>
                                            <th>date_created</th>
                                            <th>date_updated</th>
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
        $('.dataTables-example2').dataTable();
    });
 </script>