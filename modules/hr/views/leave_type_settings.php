    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"></h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
       
    <div class="panel panel-default">
        <div class="panel-heading">
            Leave Type Settings
        </div>
        <div class="panel-body">
            <form method="post" action="<?=base_url('update_leave_type_days ')?>">
                <table class="table table-bordered" style="width: 50%;">
                   <thead>
                       <th>Leave Type</th>
                       <th>Number of Days</th>
                   </thead>
                   <tbody>
                        <?php foreach($leave_type as $lt): ?>
                            <tr>
                                <td><?=$lt->type?></td>
                                <td><input type="text" name="days[]" value="<?=$lt->days?>" class="form-control">
                                    <input type="hidden" name="leave_id[]" value="<?=$lt->id?>"></td>
                            </tr>
                        <?php endforeach; ?>
                   </tbody>
                </table>
                <button type="submit" class="btn btn-sm btn-success" name="save"> Save Record</button>
           </form>
        </div>
    </div>
</div> 