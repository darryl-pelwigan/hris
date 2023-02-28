<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Grade Submission <small>Request For Update</small></h1>

        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
 <div class="panel panel-default">
          <div class="panel-heading"></div>
         <div class="panel-body">

                <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-success hidden" id="status"></div>

                        <form class="form-horizontal" id="checkGradesUpdateRequest">
                        <input type="hidden" class="form-control" id="requestid"   value="<?=$request[0]->id?>">
                          <div class="form-group">
                            <label for="instructor" class="col-sm-3 control-label">Instructor</label>
                            <div class="col-sm-9">
                              <?=$request[0]->name?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">For</label>
                            <div class="col-sm-9">
                              <?=ucwords(strtolower($type_d[7].' '.$type_d[5]) )?>
                            </div>
                          </div>

                            <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Reason</label>
                            <div class="col-sm-9">
                              <?=ucwords(strtolower($request[0]->request_desc) )?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Subject</label>
                            <div class="col-sm-9">
                              <?=$request[0]->courseno?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Subject-Code</label>
                            <div class="col-sm-9">
                              <?=ucwords(strtolower($request[0]->description))?>
                            </div>
                          </div>

                           <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Set date</label>
                            <div class="col-sm-9">
                              <div class=" input-group date datetimepicker1"  >
                                <input type="text" class="form-control" name="extend_date" id="extend_date" value="<?=nice_date($request[0]->request_valid_from,'Y-m-d H:i A')?>" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            </div>
                          </div>

                           <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Remarks</label>
                            <div class="col-sm-9 messages">
                                    <?php
                                      if($request[0]->remarks==''){
                                              echo 'no remarks';
                                      }else{
                                          $remarks = json_decode($request[0]->remarks,true);
                                          for($x=0;$x<count($remarks);$x++){
                                              if( $remarks[$x]['user_id'] == $this->session->userdata('id')){
                                                  echo '
                                                          <div class="alert  messaging-left"  >
                                                                  <small>'.$this->session->userdata('name').'</small><br />
                                                                  <p>'. $remarks[$x]['remarks'].'</p>
                                                          </div>
                                                      ';
                                              }else{
                                                      echo '
                                                              <div class="alert messaging-right" >
                                                                      <small>'.$request[0]->name.'</small><br />
                                                                      <p>'. $remarks[$x]['remarks'].'</p>
                                                              </div>
                                                          ';
                                              }

                                          }
                                      }
                                  ?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="subject" class="col-sm-3 control-label">Add Remarks</label>
                            <div class="col-sm-9">
                              <textarea name="remarks" id="remarks" class="form-control" style="min-width: 100%;max-width: 100%;"></textarea>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-7">
                              <button type="button" class="btn btn-danger" onclick="$(this).sentGradeRequest('0');">Invalid</button>
                              <button type="button" class="btn btn-primary" onclick="$(this).sentGradeRequest('2');">Valid</button>
                            </div>
                          </div>
                        </form>
                </div>

         </div>

 </div>


</div><!-- /#page-wrapper -->