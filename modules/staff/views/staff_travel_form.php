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

    <button class="btn btn-primary btn-sm pull-right" id="new_travel_modal" type="button" style="margin-bottom: 5px;" data-controls-modal="#newtravelform" data-backdrop="static" data-toggle="modal" data-target="#newtravelform"><i class="glyphicon glyphicon-pencil"></i>Travel Order</button>
        
    <hr>
        

        <?php if($travelorder_request): ?>
            <?php foreach($travelorder_request as $key=>$req): ?>
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
                            $btnupdate = ' <a class="btn btn-xs" onclick="$(this).viewtravelrecord('.$req->id.')"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        }
                    ?>

                    <div class="col-md-4 leave"  style="margin-bottom:1%;height:220px;" >
                        <div class="panel panel_leave_requests" >
                            <div class="panel-heading <?=$bcolor?>" >Travel Order
                                <div class="btn-group pull-right">
                                    <?=$btnupdate?>
                                </div>
                            </div>
                            <div class="panel-body" >
                                <div style="padding:10px">
                                    <b>Reason</b>: <?= $req->purpose ?><br/>
                                    <b>Destination</b>: <?= $req->destination ?><br/>
                                    <b>Date of Travel Order</b>: <?= date('M d, Y', strtotime($req->travelo_date)) ?> <br/>
                                    <b>Date of Travel</b>: <?=date('M d, Y', strtotime($req->datefrom))?> - <?=date('M d, Y', strtotime($req->dateto))?> <em> (<?= $req->numberofdays?> day/s)</em> <br/>
                                    <b>Remarks</b>: <?=$req->remarks ?> <br/>
                                    <b>Date <em><?=($req->dept_head_approval == 1 || $req->dept_head_approval == 0 ? 'Approved' : 'Disapproved')?></em></b>: <?=($req->dept_head_approval) ? date('M d, Y', strtotime($req->dept_head_date_approval)) : ''?><br/>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div> <!-- /#page-wrapper -->

