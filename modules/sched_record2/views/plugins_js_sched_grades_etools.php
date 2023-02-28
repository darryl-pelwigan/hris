<script type="text/javascript">
var total_cs ='';
var prcnt_cs =Number($('#cs_prcnt').val());
var prcnt_exm =Number($('#exam_prcnt').val());
 $(document).ready(function(){

     $.fn.checkInput = function(inp_cs,l){

         var pattern=/[A]/;
         var pattern2=/[0-9]/;
         var check;
        if(pattern2.test(inp_cs) && inp_cs.length<=l)
            check=true;
        // else if(pattern.test(inp_cs) && inp_cs.length==1)
        //     check=true;
        else
            check=false;
       return check;
     };

     $.fn.prcnt = function(equiv,type , cs_exam){
            var prcnt=($('#'+cs_exam+'_prcnt').val());
           return (equiv*prcnt);
     };
     $.fn.openEtool = function(etool_id,studentid){
        $('#etools_data').modal('hide');
        $('.modal-backdrop').fadeOut();
        $('body').removeClass('modal-open');
        var urlx ="<?=base_url('/sched_record2/sched_cs_record_etools/get_etools_student')?>";
         $.ajax({
                                        type: "POST",
                                        url: urlx,
                                        data :  {
                                            'etool_id' :  etool_id,
                                            'studentid' : studentid,
                                            'sched_id' : sched_id,
                                        },
                                        dataType: "html",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            $('#get_etools_stu').html(data);
                                            $('#etools_data').modal('show');
                                        }
                            });
     };

    $.fn.computeTotalTransPrcntExam = function(studentid,sched_id,type,inputed){
        var trans = JSON.parse($("#transmutation_json_exam").val());
                trans = trans[inputed];
        var cs_prcnt = $("#cs_scoreprcnt_"+studentid+"-"+type).text();
        var e_prcnt = trans*prcnt_exm;
            e_prcnt = e_prcnt.toFixed(2);
        var final_grade = Number(cs_prcnt)+Number(e_prcnt);
            final_grade = final_grade.toFixed(2);

            $("#exam_scoreequiv_"+studentid+"_"+sched_id+"-"+type).text(trans);
            $("#exam_scoreprcnt_"+studentid+"_"+sched_id+"-"+type).text(e_prcnt);
            $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").text(final_grade);

             if(final_grade<75){
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").removeClass('passed');
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").addClass('failed');
                }else{
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").removeClass('failed');
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").addClass('passed');
                }

            return final_grade;
     };

     $.fn.computeExam = function(studentid,exam_id,sched_id,type,sending=false){
        var maxx=($('#total_exam_'+sched_id+'-'+type).val());
        var inputed=($('#exam_score_'+exam_id+'_'+studentid+'_'+sched_id+'-'+type).val());
            if((parseInt(inputed)>parseInt(maxx) || $.fn.checkInput(inputed,maxx.length)===false) && inputed!='' ){
                 alert(inputed+' greaterthan '+maxx);
                 $(this).val('');
                 $(this).attr('onblur','');
                 $.fn.computeExam(studentid,exam_id,sched_id,type);
            }else{
                var finalx=$.fn.computeTotalTransPrcntExam(studentid,sched_id,type,inputed);
                var urlx ="<?=base_url('UpdateStudentExam2')?>";
                var data_exm_array={};
                    data_exm_array["lecunits"]=lecunits;
                    data_exm_array["labunits"]=labunits;
                    data_exm_array["studentid"]=studentid;
                    data_exm_array["type"]=type;
                    data_exm_array["schedid"]=sched_id;
                    data_exm_array["exm_val"]= (inputed=='') ? 'NULL':inputed;
                    data_exm_array["exm_id"]=exam_id;
                    inputed=(inputed=='')?0:inputed;
                    data_exm_array["final"]=(inputed=='') ? 'NULL': finalx;
                  $(this).attr('onblur','$(this).sent_data_exam("'+studentid+'","'+sched_id+'","'+type+'","'+exam_id+'","'+urlx+'")');
                return (data_exm_array);
            }
     };

     $.fn.sent_data_exam = function(studentid,sched_id,type,exam_id,urlx){
                            $.ajax({
                                        type: "POST",
                                        url: urlx,
                                        data :  $.param($.fn.computeExam(studentid,exam_id,sched_id,type)),
                                        dataType: "html",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            if(data!=''){
                                                 var classAddRem=['animate-bg'];
                                                 var el=$("#row_"+studentid+' td');
                                                 $.fn.animateBg(el,classAddRem);
                                            }
                                        }
                            });
      };

      $.fn.failedPassed = function (studentid,schedid,type,data){

            if(parseInt(data) >=75){
                $('td#exam_scorefinal_'+studentid+'_'+schedid+'-'+type).addClass('passed');
                $('td#exam_scorefinal_'+studentid+'_'+schedid+'-'+type).removeClass('failed');
            } else{
                $('td#exam_scorefinal_'+studentid+'_'+schedid+'-'+type).removeClass('passed');
                $('td#exam_scorefinal_'+studentid+'_'+schedid+'-'+type).addClass('failed');
            }
      };

       $.fn.ena_edit_exam = function(studentid,sched_id,type,cs_id,c){
          $(this).find("span").text('');
          $(this).find("input").attr('type','number');
            // $('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+c).attr('type','number');
      };


      $.fn.checkImportCsv = function(teacher_id,sched_id,cs_id,cs_i_id,type,cs_desc,cs_i_title,cs_i_dateu){
        $('table#csv_check_result_table tbody').empty();
        var maxx=($('#max_cs_'+sched_id+'_'+cs_id+'_'+cs_i_id+'-'+type).val());
        var data_inpt = $(this).val();
        var xx = data_inpt.split(" ");
        if(student_count==(xx.length)){
                var tbody='';
                var classx='';
                var data_sent={};
                    data_sent['sched_id']=sched_id;
                    data_sent['cs_id']=cs_id;
                    data_sent['cs_i_id']=cs_i_id;
                    data_sent['type']=type;
                    data_sent['teacher_id']=teacher_id;
                    data_sent['student_count']=student_count;
                    var count_error=0;
                for(var x=0;x<student_count;x++){
                        if(Number(xx[x])>Number(maxx)){
                            count_error++;
                            classx = 'class="bg-warning-tb"';
                        }else{
                            classx='';
                        }
                            tbody =tbody+'<tr '+classx+' ><td '+classx+' >'+x+'</td><td '+classx+' >'+student_list[x]["studentid"]+'</td><td '+classx+' >'+student_list[x]["lastname"]+','+student_list[x]["firstname"]+'</td><td '+classx+' >'+xx[x]+'</td></tr>';
                            data_sent['scores['+x+']'] = {
                                                studentid : student_list[x]["studentid"],
                                                score : xx[x]
                            };
                }
                if(count_error==0){ $('button#cs_imp_sent').attr('disabled',false); }
                $('table#csv_check_result_table>tbody').html(tbody);
                $('div#csv_check_result').removeClass('hidden');
                 $('#cs_imp_scores').val('');
                $('button#cs_imp_sent').click(function(){
                         $.ajax({
                                        type: "POST",
                                        url: '<?=base_url()?>'+'importDataCSV',
                                        data :  $.param(data_sent),
                                        dataType: "json",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            $('#classImportCsvDataCSE').modal('hide');
                                            $('div#csv_check_result').addClass('hidden');
                                            $.fn.getGrades(type);
                                        }
                            });
                });

        }else{
            if(xx!='')
                alert('The entered DATA doesn\'t match the number of students in this subject.');
        }



      };






});
</script>