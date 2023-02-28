<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Request Leave</h1>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    <caption><strong> Legend: </strong></caption><br>
    <span><i class="fa fa-square fa-2x" style="color: #33cc66;"></i> Approved  </span><br>
    <span><i class="fa fa-square fa-2x" style="color: #cc3333;"></i> Disapproved </span><br>
    <span><i class="fa fa-square fa-2x" style="color: #3399ff;"></i> Pending</span>
    <?php if($leave_credits): ?>

        <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newleave" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newleave"><i class="glyphicon glyphicon-pencil"></i> Leave Application</button>

        <hr>

        <?php if($leave_requests): ?>
            <?php foreach($leave_requests as $key=>$req): ?>
                    <?php 
                        $bcolor = '';
                        if($req->dept_head_approval == 0){
                            $bcolor = 'panel_pending';
                        }else if($req->dept_head_approval == 1){
                            $bcolor = 'panel_approved';
                        }else if($req->dept_head_approval == 2){
                            $bcolor = 'panel_disapproved';
                        }
                    ?>

                    <?php 
                        $btnupdate = '';
                        if($req->dept_head_approval == 0){
                            $btnupdate = ' <a class="btn btn-xs" onclick="$(this).updateleaverequests('.$req->id.')"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        }
                    ?>

                    <div class="col-md-4 leave"  style="margin-bottom:1%;height:220px;" >
                        <div class="panel panel_leave_requests" >
                            <div class="panel-heading <?=$bcolor?>" > <?=$req->type?> Leave (<?=$leave_balance[$key]?>)
                                <div class="btn-group pull-right">
                                    <?=$btnupdate?>
                                </div>
                            </div>
                            <div class="panel-body" >
                                <div style="padding:10px">
                                    <b>Reason</b>: <?= $req->reason ?><br/>
                                    <b>Date</b>: <?= date('M d, Y', strtotime($req->leave_from)) ?> - <?= date('M d, Y', strtotime($req->leave_to)) ?> <em>(<?=$req->num_days?>) Day/s</em><br/>
                                    <b>Date Filed</b>: <?= date('M d, Y', strtotime($req->date_filed)) ?> <br/>
                                    <?php if($req->dept_head_approval !=  0): ?>
                                    <b>Date <em><?=($req->dept_head_approval == 1 ? 'Approved' : 'Disapproved')?></em></b>: <?=$req->dept_head_date_approval?><br/>
                                    <?php endif; ?>
                                    <b>HR Remarks</b>: <?=$req->hr_remarks?><br/>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-danger" role="alert"><strong>Woops! As of now you do not have a leave set.</strong> Please inquire at the HR office.</div>
    <?php endif; ?>
</div> <!-- /#page-wrapper -->

