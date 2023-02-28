<div id="page-wrapper">


    <caption><strong> Legend: </strong></caption><br>
    <span><i class="fa fa-square fa-2x" style="color: #33cc66;"></i> Approved  </span><br>
    <span><i class="fa fa-square fa-2x" style="color: #cc3333;"></i> Disapproved </span><br>
    <span><i class="fa fa-square fa-2x" style="color: #3399ff;"></i> Pending</span>
 

    <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newleave" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newleave"><i class="glyphicon glyphicon-pencil"></i> Overtime Request</button>

        
    <hr>

    <?php if($overtime_records): ?>
        <?php foreach($overtime_records as $key=>$req): ?>
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
                        $btnupdate = ' <a class="btn btn-xs" onclick="$(this).viewovertimerecords('.$req->id.')"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                    }
                ?>

                <div class="col-md-4 leave"  style="margin-bottom:1%;height:220px;" >
                    <div class="panel panel_leave_requests" >
                        <div class="panel-heading <?=$bcolor?>" > Overtime Request (<?=$req->hours_rendered?> HR/S)
                            <div class="btn-group pull-right">
                                <?=$btnupdate?>
                            </div>
                        </div>
                        <div class="panel-body" >
                            <div style="padding:10px">
                              
                                <b>Date</b>: <?= date('M d, Y', strtotime($req->date_overtime)) ?> <br/>
                                <b>Time</b>: <?=$req->timefrom ?> - <?=$req->timeto ?> <em>(<?=$req->hours_rendered?>) hour/s</em><br/>
                                <?php if($req->dept_head_approval !=  0): ?>
                                <b>Date <em><?=($req->dept_head_approval == 1 ? 'Approved' : 'Disapproved')?></em></b>: <?=$req->dept_head_date_approval?><br/>
                                <?php endif; ?>
                                <b>Reason</b>: <?= $req->reason ?><br/>
                                <b>Remarks</b>: <?=$req->remarks?><br/>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div> <!-- /#page-wrapper -->

