    <div id="page-wrapper">
        <div class="row" id="ala-lang">
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
               <div class="panel panel-success">
                    <div class="panel-heading">
                         Subject
                         <span class="pull-right glyphicon glyphicon glyphicon-eye-open" data-toggle="collapse" data-target="#subject_info"></span>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body collapse" id="subject_info">



                    <div class='col-md-8'>Decription : <strong><?=strtoupper($subject_info['sched_query'][0]->description)?></strong></div>
                    <div class='col-md-6'>Type : <strong><?=strtoupper($subject_info['sched_query'][0]->type)?></strong></div>
                    <div class='col-md-6'>Subject : <strong><?=strtoupper($subject_info['sched_query'][0]->courseno)?></strong></div>
                    <div class='col-md-6'>Schedule :<br />
                     <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                            <strong><?=strtoupper($check_sched[$x]['days'])?> <?=($check_sched[$x]['start'])?> - <?=($check_sched[$x]['end'])?>
                            <?=($check_sched[$x]['lecunits']>0)?"LECTURE":""?>
                            <?=($check_sched[$x]['labunits']>0)?"LABORATORY":""?>
                             </strong><br />
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
                                    <span id="cs_i_title"></span>   (<span id="cs_i_dateu"></span>)
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

<?php

        $sem=$set_sem;
        $prelim_lab='';
        $midterm_lab='';
        $tentative_lab='';
        $prelim_lec='';
        $midterm_lec='';
        $tentative_lec='';
        $prelim_leclab='';
        $midterm_leclab='';
        $tentative_leclab='';
        $labunits=$check_sched['labunits'];
        $lecunits=$check_sched['lecunits'];
         if($lecunits>0):
                            $disablelecpm=($disablelec=='')?'$(this).changeModalExam(\''.$check_sched[0]['schedid'].'\',\''.$teacher_id.'\',\''.$labunits.'\',\'p\');':$disablelec;
                            $disablelecpv=($disablelec=='')?'$(this).checkCScomputation(\'p\');':$disablelec;
                            $disablelecmm=($disablelec=='')?'$(this).changeModalExam(\''.$check_sched[0]['schedid'].'\',\''.$teacher_id.'\',\''.$labunits.'\',\'m\');':$disablelec;
                            $disablelecmv=($disablelec=='')?'$(this).checkCScomputation(\'m\');':$disablelec;
                            $disablelectfm=($disablelec=='')?'$(this).changeModalExam(\''.$check_sched[0]['schedid'].'\',\''.$teacher_id.'\',\''.$labunits.'\',\'tf\');':$disablelec;
                            $disablelectfv=($disablelec=='')?'$(this).checkCScomputation(\'tf\');':$disablelec;
                $prelim_lec='
                                    <li class="title">Lecture</li>
                                    <li role="presentation" class="active"><a class="first-li" href="#Prelim" aria-controls="Prelim" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View Lecture</a></li>
                                    <li role="presentation"  onclick="'.$disablelecpv.'" ><a href="#Prelim" aria-controls="Prelim" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View CS</a></li>
                                    <li role="presentation"  onclick="'.$disablelecpm.'" ><a  href="#" aria-controls="Prelim" role="tab" data-toggle="tab"  ><i class="glyphicon glyphicon-edit"></i> Update Exam</a></li>

                            ';
                $midterm_lec = '
                                    <li class="title">Lecture</li>
                                    <li role="presentation" ><a class="first-li" href="#Midterm" aria-controls="Midterm" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View Midterm</a></li>
                                    <li role="presentation" onclick="'.$disablelecmv.'"   ><a href="#Midterm" aria-controls="Midterm" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View CS</a></li>
                                    <li role="presentation" onclick="'.$disablelecmm.'"   ><a href="#Midterm" aria-controls="Midterm" role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-edit"></i> Update Exam</a></li>
                            ';
               $tentative_lec = '
                                    <li class="title">Lecture</li>
                                    <li role="presentation"  ><a class="first-li" href="#TentativeFinal" aria-controls="TentativeFinal" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View Tentative Final</a></li>
                                    <li role="presentation" onclick="'.$disablelectfv.'"  ><a href="#TentativeFinal" aria-controls="TentativeFinal" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View CS</a></li>
                                    <li role="presentation" onclick="'.$disablelectfm.'"  ><a href="#TentativeFinal" aria-controls="Midterm" role="tab" data-toggle="tab"  ><i class="glyphicon glyphicon-edit"></i> Update Exam</a></li>

                                ';

        endif;
        if($labunits>0):
             $disablellablpv=($disablellab=='')?'$(this).checkCScomputation(\'lp\');':$disablellab;
             $disablellablpm=($disablellab=='')?'$(this).changeModalExam(\''.$check_sched[0]['schedid'].'\',\''.$teacher_id.'\',\''.$labunits.'\',\'lp\');':$disablellab;
             $disablellablmv=($disablellab=='')?'$(this).checkCScomputation(\'lm\');':$disablellab;
             $disablellablmm=($disablellab=='')?'$(this).changeModalExam(\''.$check_sched[0]['schedid'].'\',\''.$teacher_id.'\',\''.$labunits.'\',\'lm\');':$disablellab;
             $disablellabltfv=($disablellab=='')?'$(this).checkCScomputation(\'ltf\');':$disablellab;
             $disablellabltfm=($disablellab=='')?'$(this).changeModalExam(\''.$check_sched[0]['schedid'].'\',\''.$teacher_id.'\',\''.$labunits.'\',\'ltf\');':$disablellab;
                $prelim_lab='

                           <li class="divider"></li>
                            <li class="title" >Laboratory</li>
                            <li role="presentation" ><a class="first-li"   href="#LPrelim" aria-controls="LPrelim" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View Laboratory</a></li>
                            <li role="presentation"  onclick="'.$disablellablpv.'" ><a href="#LPrelim" aria-controls="LPrelim"  role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-eye-open"></i> View CS</a></li>
                            <li role="presentation"  onclick="'.$disablellablpm.'" ><a href="#LPrelim" aria-controls="LPrelim"  role="tab" data-toggle="tab"  ><i class="glyphicon glyphicon-edit"></i> Update Exam</a></li>
                            ';
                $midterm_lab = '
                             <li class="divider"></li>
                            <li class="title" >Laboratory</li>
                            <li role="presentation" ><a class="first-li"   href="#LMidterm" aria-controls="LMidterm" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View Laboratory</a></li>
                            <li role="presentation"  onclick="'.$disablellablmv.'" ><a href="#LMidterm" aria-controls="LMidterm"  role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-eye-open"></i> View CS</a></li>
                            <li role="presentation"  onclick="'.$disablellablmm.'" ><a href="#LMidterm" aria-controls="LMidterm"  role="tab" data-toggle="tab"  ><i class="glyphicon glyphicon-edit"></i> Update Exam</a></li>

                            ';
               $tentative_lab = '
                             <li class="divider"></li>
                            <li class="title" >Laboratory</li>
                            <li role="presentation" ><a class="first-li"   href="#LTentativeFinal" aria-controls="LTentativeFinal" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View Laboratory</a></li>
                            <li role="presentation"  onclick="'.$disablellabltfv.'" ><a href="#LTentativeFinal" aria-controls="LTentativeFinal"  role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-eye-open"></i> View CS</a></li>
                            <li role="presentation"  onclick="'.$disablellabltfm.'" ><a href="#LTentativeFinal" aria-controls="LTentativeFinal"  role="tab" data-toggle="tab"  ><i class="glyphicon glyphicon-edit"></i> Update Exam</a></li>

                                ';
        endif;



        if($labunits>0 && $lecunits>0):
                $prelim_leclab ='
                                    <li class="divider"></li>
                                    <li role="presentation" onclick="$(this).getViewTotal(\'lp\');" ><a href="#LPrelim" aria-controls="LPrelim"  role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-eye-open"></i> View TOTAL</a></li>
                             ';
                $midterm_leclab ='
                                    <li class="divider"></li>
                                    <li role="presentation" onclick="$(this).getViewTotal(\'lm\');" ><a href="#LMidterm" aria-controls="LMidterm"  role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-eye-open"></i> View TOTAL</a></li>
                                 ';
                $tentative_leclab ='
                                    <li class="divider"></li>
                                    <li role="presentation" onclick="$(this).getViewTotal(\'ltf\');" ><a href="#LTentativeFinal" aria-controls="LTentativeFinal"  role="tab" data-toggle="tab" ><i class="glyphicon glyphicon-eye-open"></i> View TOTAL</a></li>
                                ';
        endif;

        if($check_sched[0]['type']=='Internship'):
            $prelim_menus='';
            $midterm_menus='';
            $tentative_menus='';
            $final = '<li class="dropdown active"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Final Grade <b class="caret"></b></a>
                            <ul class="dropdown-menu dropdown-prelim">
                                <li role="presentation"  ><a class="first-li" href="#FinalGrade" aria-controls="FinalGrade" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
                            </ul>
                        </li>';
        else:
            $prelim_menus=' <li class="dropdown active"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Prelims <b class="caret"></b></a>
                                <ul class="dropdown-menu dropdown-prelim">'.$prelim_lec.$prelim_lab.$prelim_leclab.' </ul>
                            </li>';
            $midterm_menus='<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Midterms <b class="caret"></b></a>
                                <ul class="dropdown-menu dropdown-prelim">'.$midterm_lec.$midterm_lab.$midterm_leclab.'</ul>
                            </li>';

            $tentative_menus='<li class="dropdown "><a href="#" data-toggle="dropdown" class="dropdown-toggle">Tentative Final <b class="caret"></b></a>
                                <ul class="dropdown-menu dropdown-prelim">'.$tentative_lec.$tentative_lab.$tentative_leclab.' </ul></li>';
            if($sem==3){
                $prelim_menus='';
                $midterm_menus='<li class="dropdown active"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Midterms <b class="caret"></b></a>
                                <ul class="dropdown-menu dropdown-prelim">'.$midterm_lec.$midterm_lab.$midterm_leclab.'</ul>
                            </li>';
             }
                $final = '<li class="dropdown "><a href="#" data-toggle="dropdown" class="dropdown-toggle">Final Grade <b class="caret"></b></a>
                            <ul class="dropdown-menu dropdown-prelim">
                                <li role="presentation"  ><a class="first-li" href="#FinalGrade" aria-controls="FinalGrade" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
                            </ul>
                        </li>';

                $final = '';


        endif;

              ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id="myTabs">

                            <?= $prelim_menus?>

                            <?= $midterm_menus?>

                           <?= $tentative_menus?>

                            <?= $final?>


        </ul>
        <!-- end Nav tabs   <pre></pre>  -->
        <div id="gradres" ></div>
       <!-- modal -->
    <div class="modal fade" id="examScoreModal" tabindex="-1" role="dialog" aria-labelledby="examScoreModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="examScoreModaltitle">UPDATE EXAM GRADE</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="updateExam-" target="_blank">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Items</label>
                                        <div class="col-md-8">
                                        <input type="number" min="10" max="500" id="ex_items" class="form-control lea" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" data-modal-id="examScoreModal" >
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="updateExamButton" onclick="" class="btn btn-success">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

           <!-- modal gradeSubmissionModalLabel -->
    <div class="modal fade" id="gradeSubmissionModal" tabindex="-1" role="dialog" aria-labelledby="gradeSubmissionModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gradeSubmissionModaltitle">Grade Submission</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="gradeSubmission" target="_blank">

                                <div class="modal-body">
                                </div>
                                <div class="modal-footer" data-modal-id="gradeSubmissionModal" >
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="gradeSubmissionButton" onclick="" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

        <!--end modal -->

    <!-- modal -->
    <div class="modal fade" id="updateGradeSubmissionModal" tabindex="-1" role="dialog" aria-labelledby="updateGradeSubmissionModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="updateGradeSubmissionModaltitle">REQUEST GRADE UPDATE</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="updateGradeSubmission" target="_blank">

                                <div class="modal-body">

                                </div>
                                <div class="modal-footer" data-modal-id="updateGradeSubmissionModal" >
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="updateGradeSubmissionButton" onclick="" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

        <!--end modal -->

    </div>

    <?php if($labunits>0): ?>
    <!-- UPDATE EXAM GRADE LAB MODAL START -->
    <div class="modal fade" id="percentage_modal" tabindex="-1" role="dialog" aria-labelledby="percentage_modalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="percentage_modal_title">UPDATE LEC AND LAB PERCENTAGE</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="updateExam-" target="_blank">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Lecture</label>
                                        <div class="col-md-8">
                                           <input oninput="$(this).checkPercentMax();" type="number" max="100" min="0" class="form-control lea" id="percentage_lecture" placeholder="Percentage Lecture">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Laboratory</label>
                                        <div class="col-md-8">
                                           <input disabled="disabled" readonly="readonly" type="number" max="100" min="0" class="form-control lea" id="percentage_laboratory" placeholder="Percentage Laboratory">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">TOTAL</label>
                                        <div class="col-md-2">
                                           <input disabled="disabled" readonly="readonly" type="number" max="100" min="0" class="form-control lea" id="percentage_total">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="updatePrntgButton" onclick="$(this).percentage('<?=$check_sched[0]["schedid"]?>');" class="btn btn-success">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    <!-- UPDATE EXAM GRADE LAB MODAL END -->

    <?php endif; ?>
<!-- SELECT COMPUTATION TYPE MODAL START -->

    <div class="modal fade" id="csConfigModal" tabindex="-1" role="dialog" aria-labelledby="csConfigModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="csConfigModaltitle">CS CONFIG</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="csConfig" target="_blank">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-12" style="text-align: center;">HOW DO YOU COMPUTE YOUR GRADES?</label>
                                        <div class="col-md-8 col-md-offset-3">
                                            <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="wc" checked>
                                                        Whole Computation
                                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div>
                                            <!-- <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="nsub">
                                                    Categories
                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div> -->
                                            <!--  <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="wsub">
                                                    Categories + Sub Categories
                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div> -->
                                            <!-- <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="etools">
                                                    RLE-WITH ETOOLS
                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div> -->
                                           <!--  <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="contg">
                                                    CONTINOUS PER GRADING
                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div> -->
                                           <!--  <?php if($labunits>0 && $lecunits>0): ?>
                                                <div class="radio">
                                                  <label>
                                                    <input type="radio" name="cs_computation" id="cs_computation" value="gradeonlyleclab">
                                                        GRADES ONLY (LEC+LAB)
                                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                                  </label>
                                                </div>
                                            <?php endif; ?> -->
                                           <!--  <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="gradeonly">
                                                    GRADES ONLY (LEC/LAB)
                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div>
                                            <div class="radio">
                                              <label>
                                                <input type="radio" name="cs_computation" id="cs_computation" value="fgradeonly">
                                                    FINAL GRADES ONLY
                                                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                              </label>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="updateConfCSButton" onclick="" class="btn btn-success">DONE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Settings -->

    <div class="modal fade" id="schedSettingsModal" tabindex="-1" role="dialog" aria-labelledby="schedSettingsModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="schedSettingsModaltitle">SETTINGS</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="schedSettings" target="_blank">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Percentage</label>
                                        <div class="col-md-8">
                                           <input oninput="$(this).checkPercentage();" type="number" max="85" min="45" class="form-control lea" id="percentage" placeholder="Percentage" value="55">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="updateSchedSettings" disabled="disabled"  onclick="" class="btn btn-success">DONE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- reason to reset -->

                    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header modal-header-lightg">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="resetModaltitle">SETTINGS</h4>
                            </div>
                            <form action="#" class="form-horizontal" id="reset_subject" target="_blank">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">REASON</label>
                                        <div class="col-md-8">
                                           <textarea class="form-control" style="max-width: 100%;" name="reset_message" id="reset_message" placeholder="Please state the reason you want to reset Grades."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="resetGradesAll"   onclick="$(this).sentresaonReset('<?=$check_sched[0]["schedid"]?>');" class="btn btn-success">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

<!-- SELECT COMPUTATION TYPE MODAL END -->
    <script>
        var student_list = <?=json_encode($student_list)?> ;
        var student_count = <?=count($student_list)?>;
        var labunits='<?=$labunits?>';
        var lecunits='<?=$lecunits?>';
        var sem='<?=$sem?>';



    </script>
