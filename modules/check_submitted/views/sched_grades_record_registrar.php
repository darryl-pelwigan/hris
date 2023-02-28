    <div id="page-wrapper">

        <!-- Subject info -->
        <div class="row">
            <div class="col-lg-12">
                <a href='<?=base_url()?>ViewSubmittedGradesRegistrar'>&#8592; Back</a><br/>

               <div class="panel panel-success " data-panel-body="subject_info">
                    <div class="panel-heading">
                         Subject
                         <!-- <span class="pull-right glyphicon glyphicon glyphicon-eye-open" data-toggle="collapse" data-target="#subject_info"></span> -->
                    </div><!-- /.panel-heading -->
                    <div class="panel-body collapse in" id="subject_info">

                  

                    <div class='col-md-8'>Decription : <strong class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->description)?></strong></div>
                    <div class='col-md-6'>Type : <strong><?=strtoupper($subject_info['sched_query'][0]->type)?></strong></div>
                    <div class='col-md-6'>Subject : <strong><?=strtoupper($subject_info['sched_query'][0]->courseno)?></strong></div>
                    <div class='col-md-6'>Schedule :<br />
                     <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                            <strong><?=strtoupper($check_sched[$x]['days'])?> <?=($check_sched[$x]['start'])?> - <?=($check_sched[$x]['end'])?>
                            <?=($check_sched[$x]['lecunits']>0)?"LECTURE":""?>
                            <?=($check_sched[$x]['labunits']>0)?"LABORATORY":""?>
                            </strong>
                            <strong class="blue-label">
                            <?=($check_sched[$x]['teacher_name'])?>
                             </strong> <br />
                     <?php } ?>
                    </div>
                    <div class='col-md-6'>Room :<br />
                        <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                                    <strong><?=strtoupper($check_sched[$x]['room'])?></strong><br />
                        <?php } ?>
                      </div>
                     </div>
            </div>
            </div><!-- /.panel-heading -->
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <?php
                  if(count($this->session->flashdata('error'))>0){
                    echo '<div class="alert alert-danger"> <strong>ERROR!!!</strong>';
                    foreach ($this->session->flashdata('error') as $key => $value) {
                      echo $value.'<br />';
                    }
                    echo '</div>';
                  }
                  if($this->session->flashdata('success_upload_excel')){
                    echo '<div class="alert alert-info"> <strong>Success!</strong> UPLOADING FILE </div>';
                  }
            ?>
          </div>
        </div>
  

  <hr />
         <div class="row">
            <div class="col-lg-12">
               <div class="panel panel-success " data-panel-body="subject_excel_file">
                    <div class="panel-heading">
                         UPLOADED EXCEL FILES
                         <!-- <span class="pull-right glyphicon glyphicon glyphicon-eye-open" data-toggle="collapse" data-target="#subject_excel_file"></span> -->
                    </div><!-- /.panel-heading -->
                    <div class="panel-body collapse in" id="subject_excel_file">
                      <table class="table table-border table-hover">
                        <thead>
                          <tr>
                            <th>FILENAME</th>
                            <th>GRADING</th>
                            <th>UPLOADED AT</th>
                            <th>LAST UPDATED</th>
                          </tr>
                        </thead>

                        <tbody>
                              <?php 

                              foreach ($excel_list as $key => $value) {
                                  echo '<tr>';
                                      echo '<td> <form method="POST" action="'.base_url('check_submitted/check_submitted_registrar/download_excel').'" ><input type="hidden" name="sched_id" value="'.$this->input->get('data_key').'" /><input type="hidden" name="excel_file" value="'.$this->encryption->encrypt($value->id).'" /> <button type="submit" class="btn btn-success" > DOWNLOAD </button></form></td>'; 
                                      echo '<td> '.$value->for_type.'</td>'; 
                                      echo '<td> '.$value->created_at.'</td>';
                                      echo '<td> '.$value->updated_at.'</td>'; 
                                  echo '</tr>'; 
                              } 

                            ?>
                        </tbody>
                      </table>

                     
                     </div><!-- /.panel-body -->
            </div><!-- /.panel- -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
  
    <hr />

 <div class="panel panel-default panel-overflow">
    <div class="panel-heading"> STUDENT LIST 
      </div>
    <div class="panel-body">
       <form method="POST"  target="__blank" action="<?=base_url('check_submitted/check_submitted_registrar/export_pdf')?>"> 
         <input type="hidden" name="sched_id" value="<?=$enc_sched_id?>" />
         <input type="hidden" name="print_this" value="FINAL" />
       <button type="submit" name="export_to_pdf" >PRINT</button>

     </form>

        <table class="table table-border" id="shed_record_list">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>ID</th>
                    <th>STUDENT NAME</th>
                    <?php if(!$checker['fg_only']): ?>
                    <?php if($check_sched[0]['semester'] != 3){ ?>
                         <th>PRELIM</th>
                    <?php } ?>
                    <th>MIDTERM</th>
                    <?php endif;?>
                    <th>TENTATIVE FINAL</th>
                    <th>GRADE</th>
                    <th>REMARKS</th>
                    <th>RECTIFICATION</th>
                </tr>
            </thead>

            <tbody>
                

                <?php
                    echo $table;
                ?>


            </tbody>

            <tfoot>
              <?php
              echo $tfoot;
              ?>
            </tfoot>

        </table>

    </div>
</div>