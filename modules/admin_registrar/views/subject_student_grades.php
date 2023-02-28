<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                            	<tr>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    
                                                    <?php  if($subjct_info['sched_query'][0]->semester != '3'){ ?> <td><input type="text" /></td> <?php }  ?>
                                                    <td><input type="text" /></td>
                                                    <td colspan="4" style="border-top: 1px solid;font-weight: bold; background: antiquewhite;">GRADE</td>

                                                    <td><input type="text" /></td>
                                                </tr>

                                        <tr>
                                            <th>ID No</th>
                                            <th>Last Name</th>
                                            <th>Given Name</th>
                                            <th>Middle Name</th>
                                            <th>Course</th>
                                           <?php  if($subjct_info['sched_query'][0]->semester != '3'){ ?> <th>PRELIM</th> <?php }  ?>
                                            <th>Midterm</th>
                                            <th>Tentative Final</th>
                                            <th>FINAL</th>
                                            <th>Remarks</th>

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
        $('.dataTables-example2').dataTable({"order":[1,"asc"]}).dataTableSearch();
    });
 </script>
