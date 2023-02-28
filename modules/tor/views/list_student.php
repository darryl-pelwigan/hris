<div id="page-wrapper">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Student Records</h1>
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->

             <div class="row" id='content-tbl'>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"> 
                            Student Data Table
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row ">
                        
                                <div class="col-md-3">
								<form class="form-inline" action="#" id="select_sy" >
                                <div class=" form-group"  >
                                        <label for="schoolyear" >School Year :</label>
                                        <select id="schoolyear" class="form-control" >
                                            <option value="<?=$sem_sy['sem_sy_w']['sy']?>"><?=$sem_sy['sem_sy_w']['sy']?></option>
                                            <option>All</option>
                                            <?php 
                                            $sy = explode('-',$sem_sy['sem_sy_w']['sy']);
                                            $sy0=$sy[0];
                                            $sy1=$sy[1];
                                                for ($i=0; $i<30; $i++)
                                                {
                                                echo '<option value="'.$sy0.'-'.$sy1.'">'.$sy0.'-'.$sy1.'</option>';
                                                $sy1=$sy0;
                                                $sy0=$sy0-1;
                                                }
                                            ?>
                                        </select> 
                                    </div>
									 </form>
                                </div>
                               
                                <div class=" col-md-offset-9">
                                </div>
                             </div>

                            <div class="table-responsive" id="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
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
                                            <th>Email</th>
                                            <th>Course</th>
                                            <th>Student Type</th>
                                            <th>Nationality</th>
                                            <th>Mobile #</th>
                                            <th width="120px">Action</th>  
                                        </tr>
                                    </thead>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div>
        <!-- /#page-wrapper -->