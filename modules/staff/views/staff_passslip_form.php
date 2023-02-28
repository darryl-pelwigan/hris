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

    <button class="btn btn-primary btn-sm pull-right" type="button" style="margin-bottom: 5px;" data-controls-modal="#newpasslip" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#newpasslip"><i class="glyphicon glyphicon-pencil"></i> Pass Slip Form</button>
        
     <hr>
        

        <?php if($passslip_request): ?>
            <?php foreach($passslip_request as $key=>$req): ?>
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
                            $btnupdate = ' <a class="btn btn-xs" onclick="$(this).viewpaysliprecord('.$req->id.')"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        }
                    ?>

                    <div class="col-md-4 leave"  style="margin-bottom:1%;height:220px;" >
                        <div class="panel panel_leave_requests" >
                            <div class="panel-heading <?=$bcolor?>" > <?=$req->type?> PASS SLIP
                                <div class="btn-group pull-right">
                                    <?=$btnupdate?>
                                </div>
                            </div>
                            <div class="panel-body" >
                                <div style="padding:10px">
                                    <b>Reason</b>: <?= $req->purpose ?><br/>
                                    <b>Destination</b>: <?= $req->destination ?><br/>
                                    <b>Date of Pass Slip</b>: <?= date('M d, Y', strtotime($req->slip_date)) ?> <br/>
                                    <b>Time of Pass Slip</b>: <?=$req->exp_timeout ?> - <?=$req->exp_timreturn?> <em> <?= $req->numhours?> (hour/s)</em> <br/>
                                    <b>Undertime</b>: <?=$req->exp_undertime*60 ?> (minute/s)</em> <br/>
                                    <b>Date <em><?=($req->dept_head_approval == 1 || $req->dept_head_approval == 0 ? 'Approved' : 'Disapproved')?></em></b>: <?=$req->dept_head_date_approval?><br/>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div> <!-- /#page-wrapper -->

