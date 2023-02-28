<?php
$score = '';
$total_score = '';
$date_of_expsrex = '';
$grp_nmberx = '';
$clinical_areax = '';
$agencyx = '';
$etool_comments = '';
    if($student_score_d){
        $score = json_decode($student_score_d['cs_query'][0]->score,TRUE);
        $total_score = $student_score_d['cs_query'][0]->total;
        $date_of_expsrex = $student_score_d['cs_query'][0]->date_of_expsre;
        $grp_nmberx = $student_score_d['cs_query'][0]->grp_nmber;
        $clinical_areax = $student_score_d['cs_query'][0]->clinical_area;
        $agencyx = $student_score_d['cs_query'][0]->agency;
        $etool_comments = $score['etool_comments'];
    }
?>
<!-- import data to quiz/exam -->
  <div class="modal fade" id="etools_data" tabindex="-1" role="dialog" aria-labelledby="classetools_data">
        <div class="modal-dialog " role="document" id="etools_data-dialog" >
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classetools_data"><span><?=strtoupper($etools['cs_query'][0]->title)?></span> </h4>
                </div>
                <form id="student_etools_score">
                    <fieldset>
                        <div class="col-sm-9">
                            <div class="form-group ">
                                <div class="col-sm-8">
                                    <div class="col-sm-3">
                                        <strong>ID : <span class="green_s"> <?=$studentid?> </span> </strong>
                                        <input type="hidden" id="studentid" name="studentid" value="<?=$studentid?>" />
                                    </div>
                                     <div class="col-sm-9">
                                        <strong>NAME : <span class="green_s"> <?=$studentname[0]->lastname?> , <?=$studentname[0]->firstname?> <?=$studentname['m_nme']?></span> </strong>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                        <strong>YEAR &amp; SECTION : <span class="green_s"> <?=$studentid?> </span> </strong>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-sm-9">
                                    <strong>DATE OF EXPOSURE :  </strong> <input type="text" onblur="$(this).checkPrcnt();" class="form-control" name="date_of_exposure" id="date_of_exposure" onclick="$(this).datePickershow();" value="<?=$date_of_expsrex?>" />
                                </div>
                                <div class="col-sm-3">
                                    <strong>GROUP NUMBER :  </strong> <input type="text" onblur="$(this).checkPrcnt();" class="form-control" name="group_number" id="group_number" value="<?=$grp_nmberx?>" />
                                </div>
                            </div>
                              <div class="form-group ">
                                <div class="col-sm-4">
                                    <strong>CLINICAL AREA :  </strong>

                                        <?php

                                            if($clinical_area['num']>0){
                                                $clinical_area_select = '';
                                                $clinical_area_input = 'hide';
                                            }else{
                                                $clinical_area_select = 'hide';
                                                $clinical_area_input = '';
                                            }
                                            $def = '<option  ></option>';
                                            echo '<select  onblur="$(this).checkPrcnt();" class="form-control selects  '.$clinical_area_select.'" id="clinical_area_'.$clinical_area_select.'" name="clinical_area_'.$clinical_area_select.'">';
                                                    for($x=0;$x<$clinical_area['num'];$x++){
                                                        if($score !='' ){
                                                            if($clinical_area['query'][$x]->id==$clinical_areax){
                                                                $def = '<option value="'.$clinical_area['query'][$x]->id.'" >'.$clinical_area['query'][$x]->description.'</option>';
                                                            }
                                                        }
                                                        echo $def;
                                                        echo '<option value="'.$clinical_area['query'][$x]->id.'" >'.$clinical_area['query'][$x]->description.'</option>';
                                                        $def = '';
                                                    }
                                            echo '<option value="others"  >Other</option>';
                                            echo '</select>';

                                            echo '<input type="text" placeholder="Others" onblur="$(this).checkPrcnt();" class="form-control '.$clinical_area_input.'" name="clinical_area_'.$clinical_area_input.'" id="clinical_area_'.$clinical_area_input.'" />';
                                        ?>

                                </div>
                                <div class="col-sm-8">
                                    <strong>  AGENCY :  </strong>
                                        <?php

                                            if($agency['num']>0){
                                                $stu_agency_select = '';
                                                $stu_agency_input = 'hide';
                                            }else{
                                                $stu_agency_select = 'hide';
                                                $stu_agency_input = '';
                                            }
                                            $def2 = '<option  ></option>';
                                             echo '<select id="stu_agency_'.$stu_agency_select.'" onblur="$(this).checkPrcnt();" class="form-control selects '.$stu_agency_select.'" name="stu_agency_'.$stu_agency_select.'">';
                                                    for($x=0;$x<$agency['num'];$x++){
                                                        if($score !='' ){
                                                            if($agency['query'][$x]->id==$agencyx){
                                                                $def2 =  '<option value="'.$agency['query'][$x]->id.'" >'.$agency['query'][$x]->title.'</option>';
                                                            }
                                                        }
                                                        echo $def2;
                                                        echo '<option value="'.$agency['query'][$x]->id.'" >'.$agency['query'][$x]->title.'</option>';
                                                        $def2 = '';
                                                    }
                                                echo '<option value="others"  >Other</option>';
                                                echo '</select>';
                                                echo '<input type="text" placeholder="Others" onblur="$(this).checkPrcnt();" class="form-control '.$stu_agency_input.'" name="stu_agency_'.$stu_agency_input.'" id="stu_agency_'.$stu_agency_input.'" />';
                                        ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div id="score">
                                <span><?=$total_score?></span>%
                                <input type="hidden" id="stud_score_total" name="" value="<?=$total_score?>" />
                            </div>
                        </div>

                    </fieldset>
                    <?php


                    $count = 1;
                    $cats_list['etool_id']=$etools['cs_query'][0]->id;
                    $alphabet=array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M',14=>'N',15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z');
                            for($x=0;$x<$etools_cats['cs_num']; $x++){
                                $cats_id = $etools_cats['cs_query'][$x]->id;
                                $cats_list['data_etools'][$x] = array('cats_id'=>$cats_id,'items_num'=>$etools_cats['items'][$x]['cs_num']);
                                $count_y = 1;
                                $scorex_sum = '';
                                for($yc=0;$yc<$etools_cats['items'][$x]['cs_num'];$yc++){
                                   $scorex = $score !='' ? $score[$x][$yc]['scorex']:0;
                                   $scorex_sum = $scorex_sum + $scorex ;
                                }

                                echo '<fieldset>';
                                    echo '<div class="form-group ">';
                                        echo '<div class="col-sm-10">';
                                            echo '<h2>'.$alphabet[$count].'. '.strtoupper($etools_cats['cs_query'][$x]->description).'</h2>';
                                            echo '</div>';
                                            echo '<div class="col-sm-2">';
                                                    echo '<h2>'.$alphabet[$count].'. Score <span id="cats_score'.$cats_id.'" >'.$scorex_sum.'</span>% <input type="hidden" id="cats_total_score_'.$cats_id.'" name="cats_total_score_'.$cats_id.'" value="" /> </h2>';
                                            echo '</div>';


                                            for($y=0;$y<$etools_cats['items'][$x]['cs_num'];$y++){
                                                $scorex = $score !='' ? $score[$x][$y]['scorex']:0;
                                                $cats_items_id=$etools_cats['items'][$x]['cs_query'][$y]->id;
                                                $cats_list['data_etools'][$x][$y] = $cats_items_id;
                                                $description_item=$etools_cats['items'][$x]['cs_query'][$y]->description;
                                                $percent_item=$etools_cats['items'][$x]['cs_query'][$y]->percent;
                                                echo '<div class="form-group" id="cats_items_'.$etools_cats['cs_query'][$x]->id.'-'.$count_y.'" >';
                                                    echo '<div class="col-sm-10">';
                                                        echo '<h3>'.$count_y.'. '.ucfirst($description_item).'</h3>';
                                                    echo '</div>';
                                                    echo '<div class="col-sm-1">';

                                                            echo '<input type="number" step="any" name="etools_items_prcnt['.$cats_id.']['.$count_y.']" id="etools_items_prcnt-'.$cats_id.'-'.$count_y.'" min="1" max="'.$percent_item.'" onblur="$(this).checkPrcnt();" onblur="" class="form-control etools_items_prcnt " value="'.$scorex.'" />';
                                                    echo '</div>';
                                                echo '</div>';
                                                $count_y++;
                                            }

                                    echo '</div>';
                                echo '</fieldset>';
                                $count++;
                            }

                    ?>
                    <fieldset>
                        <div class="form-group ">
                        <h2 style="text-align: center;">COMMENTS</h2>
                            <textarea  class="form-control" id="etool_comments" onblur="$(this).checkPrcnt();" >
                                <?=$etool_comments?>
                            </textarea>
                        </div>
                    </fieldset>

                </form>

            </div>
        </div>
    </div>
    <script type="text/javascript">
     $(document).ready(function(){

        var p_width = $('textarea').css({'width':'70%','max-width':'70%','max-height':'150px','height':'150px','margin':'0px auto'});

        $.fn.datePickershow = function(){
            $(this).datetimepicker({
                    format: 'MMM DD YYYY',
                    minDate: moment().subtract(2,'month'),
                    maxDate: moment().add(6, 'month')
            });
        };



        $( ".selects" ).change(function() {
            var el=$(this);
            var el_val =el.val();
            if(el_val==='others'){
                var el_id = el.attr('id');
                var el2=$('#'+el_id+'hide');
                el2.removeClass('hide');
                el2.attr('id',el_id);
                el2.attr('name',el_id);
                el.attr('id',el_id+'hide');
                el.attr('name',el_id+'hide');
                el.addClass('hide');
             }
        });

        $.fn.checkPrcnt = function(){
            var etools_cats_num=Number(<?=$etools_cats['cs_num']?>);
            var cats_list = JSON.parse('<?=json_encode($cats_list, JSON_FORCE_OBJECT)?>');
            var total_score = 0;
            var error_c = 0;
            for(var x=0;x<etools_cats_num;x++){
                var c_y = 1;
                var items_sum = 0;
                var cats_id = cats_list['data_etools'][x]['cats_id'];
                for(var y=0; y<cats_list['data_etools'][x]['items_num']; y++){
                    var ixx = Number($('#etools_items_prcnt-'+cats_id+'-'+c_y).val());
                    var max = Number($('#etools_items_prcnt-'+cats_id+'-'+c_y).attr('max'));
                    if(max>=ixx){
                        cats_list['data_etools'][x][y]={
                                        scorex:ixx,
                                        items_id:cats_list['data_etools'][x][y]
                                        };
                        $('#etools_items_prcnt-'+cats_id+'-'+c_y).css({'border':'1px solid rgb(204, 204, 204)'});
                        items_sum = items_sum + ixx;
                        c_y++;
                    }else{
                        error_c++
                        $('#etools_items_prcnt-'+cats_id+'-'+c_y).css({'border':'1px solid #ff6969'});
                    }
                }

                total_score = total_score + items_sum;
                items_sum = items_sum.toFixed(2);
                $('#cats_score'+cats_id).text(items_sum);
                $('#cats_total_score_'+cats_id).val(items_sum);
            }
            var studentid = $('#studentid').val();
            var comment = $('#etool_comments').val();
            var date_of_exposure = $('#date_of_exposure');
            var group_number = $('#group_number');
            var clinical_area = $('#clinical_area_');
            var agency = $('#stu_agency_');

            var date_of_exposure_val = date_of_exposure.val();
            var group_number_val = group_number.val();
            var clinical_area_val = clinical_area.val();
            var agency_val = agency.val();

           if(date_of_exposure_val!=''){
                date_of_exposure.css({'border':'1px solid rgb(204, 204, 204)'});
            }else{
                error_c++
                date_of_exposure.css({'border':'1px solid #ff6969'});
            }
            if(group_number_val!=''){
                group_number.css({'border':'1px solid rgb(204, 204, 204)'});
            }else{
                error_c++
                group_number.css({'border':'1px solid #ff6969'});
            }
            if(clinical_area_val!=''){
                clinical_area.css({'border':'1px solid rgb(204, 204, 204)'});
            }else{
                error_c++
                clinical_area.css({'border':'1px solid #ff6969'});
            }
            if(agency_val!=''){
                agency.css({'border':'1px solid rgb(204, 204, 204)'});
            }else{
                error_c++
                agency.css({'border':'1px solid #ff6969'});
            }
            cats_list['studentid'] = studentid;
            cats_list['data_etools']['etool_comments'] = comment.trim(); //
            cats_list['date_of_exposure'] = date_of_exposure_val;
            cats_list['group_number'] = group_number_val;
            cats_list['clinical_area'] = clinical_area_val;
            cats_list['agency'] = agency_val;
            cats_list['sched_id'] = sched_id;
            if(error_c==0){
                total_score = total_score.toFixed(2);
                $('#score span').css({'color':'#000'});
                $('#score span').text(total_score);
                $('#stud_score_total').val(total_score);
                cats_list['total_score'] = total_score;
                $.fn.sentData(cats_list);
            }else{
                $('#score span').css({'color':'#ff6969'});
            }
        };

        $.fn.sentData = function(cats_list){
             $.ajax({
                    type: "POST",
                    url: '<?=base_url()."sched_record2/sched_cs_record_etools/student_score_update"?>',
                    data : $.param(cats_list),
                    dataType: "html",
                    error: function(){
                        alert('error');
                    },
                    success: function(data){
                        if(data!=''){

                        }
                }
            });
        };

    });
    </script>