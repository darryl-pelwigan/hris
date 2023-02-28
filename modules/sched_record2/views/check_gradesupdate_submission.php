<?php

if($request){
?>

<input type="hidden" class="form-control" id="requestid"   value="<?=$request[0]->id?>">
<div class="form-group">
    <label class="control-label col-md-3">Reason</label>
    <div class="col-md-8">
            <?=($request[0]->request_desc)?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Valid From Date : </label>
    <div class="col-md-8">
            <?=($request[0]->request_valid_from)?>
    </div>
</div>



<div class="form-group">
    <label class="control-label col-md-3">Status : </label>
    <div class="col-md-8">
            <?php
                if($request[0]->status==1){
                        echo 'not Validated';
                }elseif ($request[0]->status==0) {
                        echo 'Validated';
                }else{
                         echo 'Denied';
                }
            ?>
    </div>
</div>


<div class="form-group">
    <label class="control-label col-md-3"></label>
    <div class="col-md-8 messages">
            <?=$remarks_c?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Remarks : </label>
    <div class="col-md-8">
            <textarea name="remarks" id="remarks" class="form-control" style="min-width: 100%;max-width: 100%;"></textarea>
    </div>
</div>

<?php
}else{
?>
<input type="hidden" class="form-control" id="requestid"   value="0">
<div class="form-group">
    <label class="control-label col-md-3">Reason</label>
    <div class="col-md-8">
        <textarea name="reason" id="reason" class="form-control" style="min-width: 100%;max-width: 100%;"></textarea>
    </div>
</div>
<?php
}