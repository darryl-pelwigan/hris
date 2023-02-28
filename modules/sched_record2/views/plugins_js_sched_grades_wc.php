
<script type="text/javascript">

var total_cs ='';
var prcnt_cs =Number($('#cs_prcnt').val());
var prcnt_exm =Number($('#exam_prcnt').val());
 $(document).ready(function(){

     $.fn.checkInput = function(inp_cs,l){

         var pattern=/[A]/;
         var pattern2=/[0-9]/;
         var check;
         if( inp_cs != 00 || inp_cs != 000 ){
            if(pattern2.test(inp_cs) && inp_cs.length<=l)
              check=true;
            else
              check=false;
         }else{
             check=true;
         }

       return check;
     };

     $.fn.prcnt = function(equiv,type , cs_exam){
            var prcnt=($('#'+cs_exam+'_prcnt').val());
           return (equiv*prcnt);
     };
     // schedid_507_1_0_p

     $.fn.computeTotalTransPrcntCS = function(studentid,sched_id,type,cs_id,tr_count){
        var total_cs = 0;
        var trans = JSON.parse($("#transmutation_json_cs").val());
             for(var t=0;t<tr_count;t++){
                var cs_id =$("#cs_id_"+sched_id+"_"+t+"_"+type).val();
                total_cs=total_cs+Number($("#cs_score_"+sched_id+"_"+cs_id+"_"+studentid+"-"+type+"-"+t).val());
            }
            $("#cs_scoretotal_"+studentid+"-"+type).text(total_cs);
            $("#cs_trans_"+studentid+"-"+type).text(trans[total_cs]);
            var prcnt = trans[total_cs]*prcnt_cs;
                prcnt = prcnt.toFixed(2);
            var e_prcnt =  $("#exam_scoreprcnt_"+studentid+"_"+sched_id+"-"+type).text();
            var final_grade = Number(prcnt)+Number(e_prcnt);
                final_grade = final_grade.toFixed(2);
                if(final_grade<75){
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").removeClass('passed');
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").addClass('failed');
                }else{
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").removeClass('failed');
                    $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").addClass('passed');
                }
            $("#cs_scoreprcnt_"+studentid+"-"+type).text(prcnt);
            $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").text(final_grade);
     };

     $.fn.computeCs = function(studentid,sched_id,type,cs_id,c,sending=false){

        var tr_count =$("#total_cs_count").val();
        var maxx=($('#max_cs_'+sched_id+'_'+cs_id+'_'+c+'_'+type).val());
        var inputed=($('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+'-'+c).val());

            if((parseInt(inputed)>parseInt(maxx) || $.fn.checkInput(inputed,maxx.length)===false) && inputed!='' && inputed!='NULL'     ){
                 alert(inputed+' greaterthan '+maxx);
                 $(this).val('');
                 $(this).attr('onblur','');
                 $.fn.computeCs(studentid,sched_id,type,cs_id,c);
            }else{
                if(sending===false){
                    $.fn.computeTotalTransPrcntCS(studentid,sched_id,type,cs_id,tr_count);
                }
                     switch(inputed){
                          case "000":
                                  inputed = "INC";
                                  break;
                          case "00":
                                  inputed = "E";
                                  break;
                          default:
                                  inputed;
                                  break;


                    };
                    var url ="<?=base_url('UpdateStudentCS_WC')?>";
                    var data_cs_array={};
                    data_cs_array["studentid"]=studentid;
                    data_cs_array["type"]=type;
                    data_cs_array["schedid"]=sched_id;
                    // data_cs_array["cs_val"]= (inputed=='') ? 'NULL':inputed;
                    data_cs_array["cs_val"]= inputed;
                    data_cs_array["cs_id"]=cs_id;
                    $(this).attr('onblur','$(this).sent_data_cs("'+studentid+'","'+sched_id+'","'+type+'","'+cs_id+'","'+inputed+'","'+c+'","'+url+'")');
                    return (data_cs_array);
            }
     };

     $.fn.sent_data_cs = function(studentid,sched_id,type,cs_id,inputed,c,url){
                        $.ajax({
                                        type: "POST",
                                        url: url,
                                        data :  $.param($.fn.computeCs(studentid,sched_id,type,cs_id,c,true)),
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
                                        data :  $.param($.fn.computeExam(studentid,exam_id,sched_id,type,true)),
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

      $.fn.ena_edit_cs = function(studentid,sched_id,type,cs_id,c){
          $(this).find("span").text('');
            $('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+'-'+c).attr('type','number');
      };

       $.fn.ena_edit_exam = function(studentid,sched_id,type,cs_id,c){
          $(this).find("span").text('');
          $(this).find("input").attr('type','number');
            // $('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+c).attr('type','number');
      };

       $.fn.ena_edit_intern = function(studentid,sched_id,type){
          $(this).find("span").text('');
          $(this).find("input").attr('type','number');
            // $('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+c).attr('type','number');
      };

      $.fn.importDataCs = function(teacher_id,sched_id,cs_id,type,cs_desc,cs_dateu,c){
                        $('#classImportCsvDataCSELabel span').text(cs_desc);
                        $('#cs_i_title').text(cs_desc);
                        $('#cs_i_dateu').text(cs_dateu);
                        $('input#cs_imp_scores').attr('onblur','$(this).checkImportCsv("'+teacher_id+'","'+sched_id+'","'+cs_id+'","'+type+'","'+cs_desc+'","'+cs_dateu+'","'+c+'");');
                        $('button#cs_imp_sent').attr('disabled',true);
                        $('#classImportCsvDataCSE').modal('show');
                        return false;
      };

      $.fn.checkImportCsv = function(teacher_id,sched_id,cs_id,type,cs_desc,cs_dateu,c){
        $('table#csv_check_result_table tbody').empty();
        var maxx=($('#max_cs_'+sched_id+'_'+cs_id+'_'+c+'_'+type).val());
        var data_inpt = $(this).val();
        var xx = data_inpt.trim().split(" ");
        console.log(student_count);
        if(student_count==(xx.length)){
                var tbody='';
                var classx='';
                var data_sent={};
                    data_sent['sched_id']=sched_id;
                    data_sent['cs_id']=cs_id;
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

                $('button#cs_imp_sent').click(function(){
                         $.ajax({
                                        type: "POST",
                                        url: '<?=base_url()?>'+'importDataCSV_WC',
                                        data :  $.param(data_sent),
                                        dataType: "json",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                          $('#cs_imp_scores').val('');
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

        $.fn.importDataExam = function(teacher_id,sched_id,type){
                        $('#classImportCsvDataCSELabel span').text("EXAM SCORE");
                        $('#cs_i_title').text("EXAM SCORE");
                        $('input#cs_imp_scores').attr('onblur','$(this).checkImportExamCsv("'+teacher_id+'","'+sched_id+'","'+type+'");');
                        $('button#cs_imp_sent').attr('disabled',true);
                        $('#classImportCsvDataCSE').modal('show');
                        return false;
      };

      $.fn.checkImportExamCsv = function(teacher_id,sched_id,type){
        $('table#csv_check_result_table tbody').empty();
        var maxx=($('#total_exam_'+sched_id+'-'+type).val());
        var exam_id=($('#total_examid_'+sched_id+'-'+type).val());
        var data_inpt = $(this).val();
        var xx = data_inpt.trim().split(" ");

        if(student_count==(xx.length)){
                var tbody='';
                var classx='';
                var data_sent={};
                    data_sent['lecunits']=lecunits;
                    data_sent['labunits']=labunits;
                    data_sent['sched_id']=sched_id;
                    data_sent['exam_id']=exam_id;
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

                $('button#cs_imp_sent').click(function(){
                         $.ajax({
                                        type: "POST",
                                        url: '<?=base_url()?>'+'importDataEXAMCSV_WC',
                                        data :  $.param(data_sent),
                                        dataType: "json",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            $('#cs_imp_scores').val('');
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