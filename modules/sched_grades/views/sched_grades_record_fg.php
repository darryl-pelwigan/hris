    <div id="page-wrapper">
        <div class="row asdas" id="ala-lang">
            <div class="col-lg-12">
                <h1 class="page-header">
                    </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <!-- Subject info -->
        <div class="row">
            <div class="col-lg-12">
                <a href='<?=base_url()?>TeacherScheduleList'>&#8592; Back</a><br/>

               <div class="panel panel-success " data-panel-body="subject_info">
                    <div class="panel-heading " >
                         Subject
                         <span class="pull-right glyphicon glyphicon glyphicon-eye-open" data-toggle="collapse" data-target="#subject_info"></span>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body collapse  in" id="subject_info">

                    <div class='col-md-8'>Decription : <strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->description)?></strong></div>
                    <div class='col-md-6'>Type : <strong><?=strtoupper($subject_info['sched_query'][0]->type)?></strong></div>
                    <div class='col-md-6'>Subject : <strong><?=strtoupper($subject_info['sched_query'][0]->courseno)?></strong></div>
                    <div class='col-md-6'>Schedule :<br />
                     <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                            <input type="hidden" value="<?=$check_sched[$x]['schedid']?>" />
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
                  $excelxxx = 'p';
                  if($subject_info['sched_query'][0]->type == 'Lec&Lab' ){
                    $excelxxx = 'lp';
                  }
                     $excel_upload_opt = '';
                          $print_this = '';

                          $imp_excel['prelim'] = false;
                          $imp_excel['midterm'] = false;
                          $imp_excel['tentative'] = false;
                        if(isset($check_submitted[0])){


                              if($check_sched[0]['semester'] != 3  || $smpt){
                                  if($check_submitted[0]->submit_prelim == null){
                                                 $excel_upload_opt .= '<option>PRELIM</option>';
                                  }else{
                                      $print_this = 'PRELIM';
                                      $imp_excel['prelim'] = true;
                                  }
                              }

                              if($check_submitted[0]->submit_midterm == null){
                                                 $excel_upload_opt .= '<option>MIDTERM</option>';
                              }else{
                                      $print_this = 'MIDTERM';
                                      $imp_excel['midterm'] = true;
                              }
                              if($check_submitted[0]->submit_tentative == null){
                                                 $excel_upload_opt .= '<option>TENTATIVE</option>';
                              }else{
                                      $print_this = 'TENTATIVE';
                                      $imp_excel['tentative'] = true;
                              }

                               if($check_submitted[0]->submit_final == null){
                                                 $excel_upload_opt .= '<option>FINAL</option>';
                               }else{
                                      $print_this = 'FINAL';
                              }
                            }

                          ?>
          </div>
        </div>

    <hr />

         <div class="row">
            <div class="col-lg-12">
               <div class="panel panel-success hidden " data-panel-body="subject_excel_file">
                    <div class="panel-heading " >
                         EXCEL TOOLS
                         <!-- <span class="pull-right glyphicon glyphicon glyphicon-eye-open" data-toggle="collapse" data-target="#subject_excel_file"></span> -->
                    </div><!-- /.panel-heading -->
                    <div class="panel-body collapse  in" id="subject_excel_file">
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
                                      echo '<td> <form method="POST" action="'.base_url('Schedule/DOWNLOAD_EXCEL').'" ><input type="hidden" name="sched_id" value="'.$sched_id.'" /><input type="hidden" name="excel_file" value="'.$this->encryption->encrypt($value->id).'" /> <button type="submit" class="btn btn-success" > DOWNLOAD </button></form></td>';
                                      echo '<td> '.$value->for_type.'</td>';
                                      echo '<td> '.$value->created_at.'</td>';
                                      echo '<td> '.$value->updated_at.'</td>';
                                  echo '</tr>';
                              }

                            ?>
                        </tbody>
                      </table>

                     <?php


                      if($checkssss){
                           if(!isset($check_submitted[0])  ){
                            ?>
                    <form class="form-inline hidden" method="POST"  enctype="multipart/form-data" action="<?=base_url('sched_grades/upload_excel')?>">
                        <input type="hidden" name="sched_id" value="<?=$sched_id?>" />
                        <input type="hidden" name="old_file" value="<?=$this->session->flashdata('success_upload_excel')?>" />
                      <div class="form-group">
                        <label for="pwd">SUPPORTING EXCEL:</label>
                        <input type="file" name="excel_file" class="form-control" id="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet , application/vnd.ms-excel">

                        <select class="form-control" name="grading">

                          <?php
                              if($check_sched[0]['semester'] != 3  || $smpt){
                                 echo '<option>PRELIM</option>';
                              }
                               echo '<option>MIDTERM</option>
                                    <option>TENTATIVE</option>
                                    <option>FINAL</option>';
                          ?>

                        </select>
                      </div>


                      <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                  <?php }else{
                          if( $check_submitted[0]->submit_midterm == null || $check_submitted[0]->submit_tentative == null || $check_submitted[0]->submit_final == null ){

                  ?>

                       <form class="form-inline hidden" method="POST"  enctype="multipart/form-data" action="<?=base_url('sched_grades/upload_excel')?>">
                        <input type="hidden" name="sched_id" value="<?=$sched_id?>" />
                        <input type="hidden" name="old_file" value="<?=$this->session->flashdata('success_upload_excel')?>" />
                      <div class="form-group">
                        <label for="pwd">SUPPORTING EXCEL:</label>
                        <input type="file" name="excel_file" class="form-control" id="excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet , application/vnd.ms-excel">

                        <select class="form-control" name="grading">
                        <?=$excel_upload_opt?>
                        </select>
                      </div>


                      <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                  <?php
                  }
                }
                }
                ?>

                 <hr />
                 <!-- <h4>EXCEL TOOLS</h4> -->
                      <table class="table table-border table-hover">
                        <thead>
                          <tr>
                            <th>FILENAME</th>


                          </tr>
                        </thead>

                        <tbody>
                           <tr>
                            <td><a class="btn btn-sm btn-info" href="https://pcceduportal.com/modules/exporttoexcel_grades/exporttoexcel_leclab_wc/xcl?sched_id=<?=$sched_id?>&type=<?=$excelxxx?>&ms_type=ms2016" >WHOLE COMPUTATION EXCEL CLICK TO DOWNLOAD </a> </td>
                          </tr>
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
      <div class="alert alert-info"> <strong>NOTE:</strong> PLEASE ENTER THE CORRECT GRADE WITH DECIMAL VALUE </div>
      <div class="alert alert-warning"> <strong>NOTE:</strong> PLEASE SUBMIT YOUR FINAL GRADE TO GENERATE COMPLETE PDF </div>
     <?php

     if($print_this != ''){ ?>
      <form method="POST"  target="__blank" action="<?=base_url('sched_grades/export_pdf')?>">
         <input type="hidden" name="sched_id" value="<?=$ecn_sched_id?>" />
         <input type="hidden" name="print_this" value="<?=$print_this?>" />
       <button type="submit" name="export_to_pdf" >PRINT</button>
       <?php
          if(in_array($teacher_id,[])):
       ?>
          <button type="submit" name="export_to_pdf_decimal" >PRINT Decimal</button>
        <?php
          endif;
        ?>
     </form>
    <?php } ?>

        <table class="table table-border" id="shed_record_list">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>ID</th>
                    <th>STUDENT NAME</th>
                    <th>TENTATIVE FINAL
                        <br />
                         <?php if(!$imp_excel['tentative']){ ?>
                        <img src="<?=base_url('assets/images/icons/CSV.png')?>" onclick="$(this).importDataCs('<?=$sched_id?>','<?=strtoupper($subject_info['sched_query'][0]->description)?>','TENTATIVE','tenta');" width="20">
                         <?php } ?>
                    </th>
                    <th>GRADE</th>
                    <th>REMARKS</th>
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


<!-- import data to quiz/exam -->
  <div class="modal fade" id="classImportCsvDataCSE" tabindex="-1" role="dialog" aria-labelledby="classImportCsvDataCSELabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classImportCsvDataCSELabel">Import Data To <span></span> </h4>
                </div>
                <form action="#" class="form-horizontal" id="importCSV" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-8">
                                    <span id="cs_i_title"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Scores</label>
                            <div class="col-md-8">
                                   <input type="text" onblur="" class="form-control" id="cs_imp_scores" placeholder="scores" value="">
                            </div>
                        </div>
                    </div>
                    <div id="csv_check_result" class="hidden table-responsive">
                        <table id="csv_check_result_table" class="table table-striped  modal-padding ">
                            <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>SCORE</th>
                                    </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" disabled="" id="cs_imp_sent" onclick="" class="btn btn-success">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>