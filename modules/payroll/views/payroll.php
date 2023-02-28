<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Payroll</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <div>
        <?php if($this->session->flashdata('error')){ ?>
           <?php echo $this->session->flashdata('error'); ?>
        <?php }?>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#payroll" aria-controls="payroll" role="tab" data-toggle="tab">Payroll</a></li>
            <li role="presentation"  class="active"><a href="#deductions" aria-controls="deductions" role="tab" data-toggle="tab">Deductions</a></li>
            <li role="presentation"><a href="#cut_off" aria-controls="cut_off" role="tab" data-toggle="tab">Cut Off</a></li>          
            <!-- <li role="presentation"><a href="#cut_off" aria-controls="cut_off" role="tab" data-toggle="tab">Salary Off</a></li>           -->
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane " id="payroll">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payroll
                    </div>
                    <div class="panel-body">
                        <!-- <button class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#newCutOff"><i class="glyphicon glyphicon-pencil"></i>Add New</button> -->
                        <div class="table-responsive">
                            <table class="table table-bordered display compact tbl_payroll" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%" rowspan="2">File No.</th>
                                        <!-- <th width="8%">Biometrics No.</th> -->
                                        <th rowspan="2">Full Name</th>
                                        <th colspan="2">Employee Status</th>
                                        <th rowspan="2">Salary</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Employement Stataus</th>
                                        <th>Classification</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane active" id="deductions">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Deductions
                    </div>
                    <div class="panel-body">
                        <div class="well">
                            <form action="<?=base_url('payroll/add_emp_deductions_allowances')?>" method="POST">
                                <div class="form-group row">
                                    <label for="" class="col-md-2">File No:</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="fileno" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-2">Benefits:</label>
                                    <div class="col-md-8">
                                        <table class="table small" id="deductions_table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>1st Cut Off Amount</th>
                                                    <th>2nd Cut Off Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($deductions): ?>
                                                <?php foreach($deductions as $data): ?>
                                                <tr>
                                                    <td><input type="checkbox" value="<?=$data->id?>" name="deduction_id[]" id="check_deduction<?=$data->id?>" ></td>
                                                    <td><?=$data->description?></td>
                                                    <td><?=$data->amount?></td>
                                                    <td><input type="text" class="form-control" name="first_cut[]" id="add_first_cut<?=$data->id?>" onkeyup="add_key_function(<?=$data->id?>)"></td>
                                                    <td><input type="text" class="form-control"  name="second_cut[]" id="add_second_cut<?=$data->id?>" onkeyup="add_second_cut_key_function(<?=$data->id?>)"></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-success" name="save" id="save_deduction_allowance"> <i class="fa fa-save"></i> Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered display compact tbl_emp_deductions" id="tbl_emp_deductions" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Fileno</th>
                                        <th>Name</th>
                                        <?php if($deductions): ?>
                                            <?php foreach($deductions as $data): ?>
                                                <th><?=$data->description?>(<?=$data->amount?>)</th>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach($emp_deduction as $emp): ?>
                                        <form action="" method="POST" id="form_deductions_">
                                            <tr>
                                                <td><?=$emp['emp_id']?></td>
                                                <td><?=$emp['fname']?> <?=$emp['lname']?></td>
                                                <?php foreach($deductions as $dec): ?>
                                                  <?php 
                                                        if(in_array($dec->id, $emp['deductions'])){
                                                            echo '<td><input type="checkbox" checked="" value="1"></td>';
                                                        } else {
                                                            echo '<td><input type="checkbox" value="0"></td>';
                                                        }
                                                     ?>
                                                <?php endforeach; ?>
                                                <td>
                                                    <a type="button" class="btn btn-primary btn-xs edit_deduction" onclick="edit_deduction_function(<?=$emp['emp_id']?>)"><i class="glyphicon glyphicon-edit"></i></a>

                                                    <a type="button" class="btn btn-danger btn-xs delete_deduction" target="_blank"><i class="glyphicon glyphicon-trash">
                                                </td>
                                        </form>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <div role="tabpanel" class="tab-pane " id="cut_off">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Cut Off Periods
                    </div>
                    <div class="panel-body">
                        <!-- <button class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#newCutOff"><i class="glyphicon glyphicon-pencil"></i>Add New</button> -->
                        <div class="table-responsive">
                            <table class="table table-bordered display compact tbl_cutoff" cellspacing="5px" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Classification</th>
                                        <th rowspan="2">Employee's Status</th>
                                        <th colspan="2">1st Cutt Off</th>
                                        <th colspan="2">2nd Cutt-Off</th>
                                    </tr>
                                    <tr>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <form method="post" action="<?=base_url('payroll/add_cutoff_period')?>">
                                    <tr>
                                        <td rowspan="6">Non-Teaching</td>
                                    </tr>
                                       <?php 
                                            $classification = ['Regular', 'Contractual', 'Project Based', 'Probationary', 'Fixed Term'];

                                            $days = array();
                                            for ($i=1; $i <= 31; $i++) { 
                                                array_push($days, 'Day '.$i.' ');
                                            }


                                            $days_option = '';
                                            $last_day = end($days);
                                            $val = 1;

                                            foreach ($days as $key => $d) {

                                                if ($d == $last_day) {
                                                    $days_option .= '<option value = "end">End Of Month</option>';
                                                } else {
                                                    $days_option .= '<option value = '.$val.'>'.$d.'</option>';
                                                }
                                                $val ++;
                                            }

                                            $indication = 0;

                                        ?>
                                    <!-- For Non-Teaching Employees -->
                                     <?php foreach ($classification as $c): ?>
                                        <tr>
                                            <td><?= $c ?></td>
                                            <td>
                                                <select name = 'first_cut_from[]' id="first_cut_from_<?= $indication ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = 'first_cut_to[]' id="first_cut_to_<?= $indication ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = 'second_cut_from[]' id="second_cut_from_<?= $indication ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = 'second_cut_to[]' id="second_cut_to_<?= $indication ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                           
                                        </tr>
                                    <?php $indication++ ?>
        
                                    <?php endforeach; ?>


                                    <tr>
                                        <td bgcolor="#5b945f" colspan="6">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td rowspan="10">Teaching</td>
                                    </tr>

                                    <!-- For Teaching Employees -->
                                    <?php $indication2 = 0 ?>
                                    <?php foreach ($classification as $c): ?>
                                        <tr>
                                            <td><?= $c ?></td>
                                            <td>
                                                <select name = 't_first_cut_from[]' id="t_first_cut_from_<?= $indication2 ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = 't_first_cut_to[]' id="t_first_cut_to_<?= $indication2 ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = 't_second_cut_from[]' id="t_second_cut_from_<?= $indication2 ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = 't_second_cut_to[]' id="t_second_cut_to_<?= $indication2 ?>" class='form-control'>
                                                    <option selected="" value="0"></option>
                                                    <?= $days_option ?>
                                                </select>
                                            </td>
                                           
                                        </tr>
                                     <?php $indication2++ ?>
        
                                    <?php endforeach; ?>


                                       
                                    <tr>
                                        <td style="text-align: center;" colspan="6">
                                            <button class="btn btn-success btn-lg" type="submit"> <i class="fa fa-save"> Save</i></button>
                                            <button class="btn btn-danger btn-lg" type="submit"> <i class="fa fa-pencil"> Edit</i></button><br>
                                            
                                        </td>
                                    </tr>

                                </form>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="edit_deduction_modal" tabindex="-1" role="dialog" aria-labelledby="empRecord" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?=base_url('payroll/update_emp_deductions_allowances')?>" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center;">Payroll Deductions</h4>
                </div>
                <div class="modal-body">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding:1.5%">
                            <h3 class="panel-title">Payroll Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label" style="text-align: center;">File No.</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="fileno" id="edit_fileno" required readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 control-label" style="text-align: center;">Benifits:</label>
                                <div class="col-md-8">
                                    <table class="table small edit_deduction_table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>1st Cut Off Amount</th>
                                                <th>2nd Cut Off Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($deductions): ?>
                                            <?php foreach($deductions as $dec): ?>
                                            <tr>
                                                <td><input type="checkbox" class="check_box" value="<?=$dec->id?>" name="deduction_id[]" id="deduction_id<?= $dec->id ?>"></td>
                                                <td><?=$dec->description?></td>
                                                <td><?=$dec->amount?></td>
                                                <td><input type="text" class="form-control data_value" name="first_cut[]" id="first_cut<?= $dec->id ?>" onkeyup="keyup_function(<?= $dec->id ?>)"></td>
                                                <td><input type="text" class="form-control data_value" name="second_cut[]" id="second_cut<?= $dec->id ?>" onkeyup="second_cut_key_function(<?= $dec->id ?>)"></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success" name="save"> <i class="fa fa-save"></i> Submit</button>
                            </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


</div> <!-- /#page-wrapper -->


