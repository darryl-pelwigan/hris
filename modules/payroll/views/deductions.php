<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Salary Matrix</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Add Deduction/Allowance
            </div>
            <div class="panel-body">
                <form action="<?=base_url('payroll/add_deductions')?>" method="POST">
                    <div class="form-group row">
                        <label for="" class="col-md-2">Description</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="description">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2">Amount</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2">Type</label>
                        <div class="col-md-8">
                            <select name="type" id="" class="form-control">
                                <option value="0">Deduction</option>
                                <option value="1">Allowance</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Deduction/Allowance
            </div>
            <div class="panel-body">

                <table class="table table-bordered display compact tbl_salary_matrix" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($deductions): ?>
                        <?php foreach($deductions as $data): ?>
                            <tr>
                                <td><?=$data->description?></td>
                                <td><?=($data->status == 0 ? 'Deduction' : 'Allowance')?></td>
                                <td><?=$data->amount?></td>
                                <td><a class="btn btn-success btn-xs edit" data-toggle="modal" data-target='#updateDeduction' id='<?=$data->id?>'><i class="glyphicon glyphicon-pencil"></i></a>
                                <a class="btn btn-danger btn-xs delete" id='<?=$data->id?>'><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- /#page-wrapper -->


