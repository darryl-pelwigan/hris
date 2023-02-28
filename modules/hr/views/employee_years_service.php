    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Years of Service</h1>
            <div class='col-lg-3'>
        <select id="changeClassification" class="form-control" style="width: 250px;">
            <option value="">All</option>
            <option value="1">Teaching</option>
            <option value="0">Non-Teaching</option>
         </select>
    </div>

    <div class='col-lg-3'>
     <!-- <a class="btn btn-xs btn-primary" href='employee_service_credit_log'><i class="glyphicon glyphicon-list-alt"></i> Service Credits Log</a> -->
        
    </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

       
    <div class="panel panel-default">
        <div class="panel-heading">
            Employee Lists
        </div>
        <div class="panel-body">

            <table id="employee-years_of_service" class="table table-bordered display compact small employee" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th>File No</th>
                        <th>Name</th>
                        <th>Postion</th>
                        <th>Department</th>
                        <th>Employment Status</th>
                        <th>Date Of Employement</th>
                        <th>Years of Service</th>
                        <th>Classification</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody style="color: black;"></tbody>
            </table>
        </div>
    </div>

  


</div> 

<div class="modal fade" id="years_of_service_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editModalLabel">View Years of Service Log</h4>
            </div>
            <form action="<?php echo base_url(); ?>hr/employees/add_update_initial_yos" method="post"  class="form-horizontal">
                <div class="modal-body" >
                   <!-- <div class="form-group">
                       <label for="" class="col-md-2 control-label">Name</label>
                       <div class="col-md-9">
                           <input type="text" class="form-control" readonly="" id="fullname_teaching">
                       </div>
                   </div> -->

                   <div class="typeB hide">
                        <div class="form-group">
                           <label for="" class="col-md-2 control-label">Initial Years of Service</label>
                           <div class="col-md-9">
                               <input type="text" class="form-control"  id="initialyos"  name="initialyos">
                               <input type="hidden" class="form-control"  id="yos_empid"  name="empid">
                           </div>
                       </div> 

                       <div class="form-group">
                           <label for="" class="col-md-2 control-label">Schedules </label>
                           <div class="col-md-9" id="t_schedules">
                                <table class="table table-bordered" id="t_schedules">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Sem</th>
                                            <th rowspan="2">SY</th>
                                            <th rowspan="2">Total Units</th>
                                            <th rowspan="2">Service Credit</th>
                                            <th colspan="2" style="text-align: center;">Leaves Earned</th>
                                        </tr>
                                        <tr>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                           </div>
                       </div> 
                   </div>  

                  <div class="typeA">
                        <div class="form-group">
                           <label for="" class="col-md-2 control-label">Date of Employment</label>
                           <div class="col-md-9">
                               <input type="text" class="form-control" id="y_dateofemploy" readonly="">
                           </div>
                       </div> 

                       <div class="form-group">
                           <label for="" class="col-md-2 control-label">Years of Service </label>
                           <div class="col-md-9">
                               <input type="text" class="form-control" id="yos" readonly="">
                           </div>
                       </div> 

                        <div class="form-group">
                           <label for="" class="col-md-2 control-label">Actual Service </label>
                           <div class="col-md-9">
                               <input type="text" class="form-control" id="yos_complete" readonly="">
                           </div>
                       </div> 
                   </div>   
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
