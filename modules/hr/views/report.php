<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Leave, Overtime, Pass Slip and Travel Records</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Generate Report
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="row form-group">
                    <label for="" class="col-md-2">Type:</label>
                    <div class="col-md-10">
                        <select name="type" id="type" class="form-control">
                            <option>Demographics</option>
                            <option>Employee List</option>
                            <option>Leave Reports</option>
                            <option>Overtime Reports</option>
                            <option>Faculty Quality Summary</option>
                        </select>
                    </div>
                </div>
                <form method="POST" id="form">
                    <div id="div_cat_statistical">
                        <div class="row form-group">
                        <label for="" class="col-md-2">Categorized By:</label>
                            <div class="col-md-10">
                                <div class="col-md-6">
                                    <input type="checkbox" id="classify" name="classify" value="Classification">Classification </br />
                                    <input type="checkbox" id="none" name="categorized[]" value="None">None </br />
                                    <input type="checkbox" id="graph" name="graph[]" value="Graph">Graph </br />
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="emp-status" name="categorized[]" value="Employment Status">Employment Status </br />

                                    <input type="checkbox" id="nature-emp" name="categorized[]" value="Nature of Employment">Nature of Employment </br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="div_cat_list">
                        <div class="row form-group">
                            <label for="" class="col-md-2">Title</label>
                            <div class="col-md-10">
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                        <label for="" class="col-md-2">Filtered By:</label>
                            <div class="col-md-5">
                                <div class="col-md-12">      
                                    <label for="" class="col-md-3">Active/Inactive</label>
                                    <div class="col-md-9">
                                        <select name="active" id="filterby" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Date of Employment</label>
                                        <div class="col-md-4">
                                            <input type="text" name="dateemploy_from" class="form-control datepicker">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="dateemploy_to" class="form-control datepicker">
                                        </div>  
                                </div>
                                <div class="col-md-12">                           
                                    <label for="" class="col-md-3">Classification</label>
                                    <div class="col-md-9">
                                        <select name="classification" id="filterby" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Teaching</option>
                                            <option value="0">Non-Teaching</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Nature of Employment</label>
                                    <div class="col-md-9">
                                        <select name="nature_emp" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="full-time">Full Time</option>
                                            <option value="part-time">Part Time</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Employment Status</label>
                                    <div class="col-md-9">
                                        <select name="emp_status" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="regular">Regular</option>
                                            <option value="contracutal">Contracutal</option>
                                            <option value="project-Based">Project-Based</option>
                                            <option value="probationary">Probationary</option>
                                            <option value="fixed-term">Fixed-term</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Gender</label>
                                    <div class="col-md-9">
                                        <select name="gender" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Age</label>
                                    <div class="col-md-9">
                                        <div class="col-md-4">
                                            <input type="text" name="age_from" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="age_to" class="form-control">
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Civil Status</label>
                                    <div class="col-md-9">
                                        <select name="civil_status" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Widower">Widower</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Separated">Separated</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Department</label>
                                    <div class="col-md-9">
                                        <select name="department" id="" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                foreach($departments as $dep){
                                                    echo '<option value="'.$dep->DEPTID.'">'.$dep->DEPTNAME.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Position</label>
                                    <div class="col-md-9">
                                        <select name="position" id="" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                foreach($positions as $pos){
                                                    echo '<option value="'.$pos->id.'">'.$pos->position.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Union</label>
                                    <div class="col-md-9">
                                        <select name="union" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Union</option>
                                            <option value="0">Ununion</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Religion</label>
                                    <div class="col-md-9">
                                        <select name="religion" id="" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                foreach($religion as $rel){
                                                    echo '<option value="'.$rel->id.'">'.$rel->Religion.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Birthdate</label>
                                        <div class="col-md-4">
                                            <input type="text" name="birthday_from" class="form-control datepicker">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="birthday_to" class="form-control datepicker">
                                        </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">End of Contract</label>
                                        <div class="col-md-4">
                                            <input type="text" name="contract_from" class="form-control datepicker">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="contract_to" class="form-control datepicker">
                                        </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Educational Attainment</label>
                                    <div class="col-md-5">
                                        <select name="educ" id="educ" class="form-control">
                                            <option value=""></option>
                                            <option value="doctorate">Doctorate</option>
                                            <option value="masters">Masters</option>
                                            <option value="bachelor">Bachelor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="educ_remarks" id="educ_remarks" class="form-control">
                                            <option value=""></option>
                                            <option value="Units Earned">Units Earned</option>
                                            <option value="On Going">On Going</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="col-md-3">Eligibilities</label>
                                    <div class="col-md-5">
                                        <select name="eligibility" id="" class="form-control">
                                            <option value=""></option>
                                            <?php 
                                                foreach($eligibilities as $elig){
                                                    echo '<option>'.$elig->eligname.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="elig_expiry" class="form-control datepicker" placeholder="Date of Expiration">
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <label for="" class="col-md-3">Government Issued IDs</label>
                                    <div class="col-md-4">
                                        <select name="gov_ids" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="tin">TIN</option>
                                            <option value="sss">SSS</option>
                                            <option value="philheath">PHILHEALTH</option>
                                            <option value="pag-ibig">PAG-IBIG</option>
                                            <option value="peraa">PERAA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="with_id" value="With">With
                                        <input type="radio" name="with_id" value="Without">Without
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-md-2">Columns:</label>
                            <div class="col-md-3">
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="BiometricsID">BiometricsID </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="FileNo" checked="">FileNo </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Name" checked="">Name </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Classification">Classification </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Position" checked="">Position </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Department" checked="">Department </br />   
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Date of Employment">Date of Employment </br /> 
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="YOS">YOS </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="End of Contract">End of Contract </br />
                            </div> 
                            <div class="col-md-3">
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Employment Status">Employment Status </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Nature of Employment">Nature of Employment </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Home Address">Home Address </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Email">Email </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Mobile/Landline No.">Mobile/Landline No. </br />  
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Birthdate">Birthdate </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Age">Age </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Gender">Gender </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Civil Status">Civil Status </br />               
                            </div> 
                            <div class="col-md-3">
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="With/Without Dependents">With/Without Dependents </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Religion">Religion </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="TIN">TIN </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="SSS">SSS </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Pagibig">PAG-IBIG </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="PhilHealth">PhilHealth </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Peraa">Peraa </br />
                                <input type="checkbox" class="check_box all_columns" name="columns[]" value="Union">Union </br />   
                                <input type="checkbox" class="check_box all_columns" id="checked_all_columns" value="All">All </br />
                            </div>   
                        </div>
                    </div>
                    <div id="leave-reports">
                        <div class="row form-group">
                            <label for="" class="col-md-2">Type of Leave:</label>
                            <div class="col-md-10">
                               <select name="leave_type" id="" class="form-control">
                                    <option value="all">All</option>
                                    <?php 
                                        foreach($leavetypes as $lt){
                                            echo '<option value="'.$lt->id.'">'.$lt->type.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-md-2">Departments:</label>
                            <div class="col-md-10">
                                <select name="leave_department" id="" class="form-control">
                                    <option value="all">All</option>
                                    <?php 
                                        foreach($departments as $dep){
                                            echo '<option value="'.$dep->DEPTID.'">'.$dep->DEPTNAME.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="overtime-reports">
                        <div class="row form-group">
                            <label for="" class="col-md-2">Departments:</label>
                            <div class="col-md-10">
                                <select name="ov_department" id="" class="form-control">
                                    <option value="all">All</option>
                                    <?php 
                                        foreach($departments as $dep){
                                            echo '<option value="'.$dep->DEPTID.'">'.$dep->DEPTNAME.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="from_to_dates">
                        <div class="row form-group">
                            <label for="" class="col-md-2">From:</label>
                            <div class="col-md-10">
                               <input type="text" class="form-control datepicker" id="from" name="from" value="">
                            </div>
                        </div>
                         <div class="row form-group">
                            <label for="" class="col-md-2">To:</label>
                            <div class="col-md-10">
                               <input type="text" class="form-control datepicker" id="to" name="to" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" id="report_by">
                        <label for="" class="col-md-2">Report By:</label>
                        <div class="col-md-10">
                            <div class="col-md-6">
                                <input type="checkbox" class="check_box" name="reportby[]" value="Gender">Gender </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Age">Age </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Civil Status">Civil Status </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Department">Department </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Position">Position </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Tenure">Years of Service (YOS) </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Date of Employment">Date of Employment </br />
                                 <input type="checkbox" class="check_box" name="reportby[]" value="Birthdate">Birthdate </br />

                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" class="check_box" name="reportby[]" value="Union">Union </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Religion">Religion </br />
                                <input type="checkbox" class="check_box" name="reportby[]" value="Geography">Geography </br />
                                <div id="addi-graph">
                                    <input type="checkbox" class="check_box" name="reportby[]" value="Classification">Classification </br />
                                    <input type="checkbox" class="check_box" name="reportby[]" value="Employment Status">Employment Status </br />
                                    <input type="checkbox" class="check_box" name="reportby[]" value="Nature of Employment">Nature of Employment </br />
                                </div>
                                <input type="checkbox" id="all_checkbox" class="check_box" name="reportby[]" value="All">All </br />
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row  text-center">
                        <button type="submit" name="submit" id="btn-submit" class="btn btn-success btn-md"><i class="fa fa-arrow-right"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>