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
        $final = '';

                // $final = '<li class="dropdown first-li "><a href="#" data-toggle="dropdown" class="dropdown-toggle">Final Grade <b class="caret"></b></a>
                //             <ul class="dropdown-menu dropdown-prelim">
                //                 <li role="presentation"  ><a class="first-li" href="#FinalGrade" aria-controls="FinalGrade" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> View</a></li>
                //             </ul>
                //         </li>';

              ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id="myTabs">
                            <?= $final?>


        </ul>
        <!-- end Nav tabs   <pre></pre>  -->
        <div id="gradres" ></div>



<!-- modal -->
    <div class="modal fade" id="gradeSubmissionModal" tabindex="-1" role="dialog" aria-labelledby="gradeSubmissionModalLabel">
                    <div class="modal-dialog modal-lg role="document">
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