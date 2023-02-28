


<script type="text/javascript">
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

     $.fn.computeCs = function(studentid,sched_id,type,cs_id,cs_i_id,c){
        var maxx=($('#max_cs_'+sched_id+'_'+cs_id+'_'+cs_i_id+'-'+type).val());
        var inputed=($('#cs_score_'+sched_id+'_'+cs_id+'_'+cs_i_id+'_'+studentid+'-'+type+c).val());
            if((parseInt(inputed)>parseInt(maxx) || $.fn.checkInput(inputed,maxx.length)===false) && inputed!='' ){
                 alert(inputed+' greaterthan '+maxx);
                 $(this).val('');
                 $(this).attr('onblur','');
                 $.fn.computeCs(studentid,sched_id,type,cs_id,c);
            }else{
                    var url ="<?=base_url('UpdateStudentCS')?>";
                    var data_cs_array={};
                    data_cs_array["studentid"]=studentid;
                    data_cs_array["type"]=type;
                    data_cs_array["schedid"]=sched_id;
                    data_cs_array["cs_val"]= (inputed=='') ? 'NULL':inputed;
                    data_cs_array["cs_id"]=cs_id;
                    data_cs_array["cs_i_id"]=cs_i_id;
                    $(this).attr('onblur','$(this).sent_data_cs("'+studentid+'","'+sched_id+'","'+type+'","'+cs_id+'","'+cs_i_id+'","'+inputed+'","'+c+'","'+url+'")');
                   return (data_cs_array);
            }
     };

     $.fn.sent_data_cs = function(studentid,sched_id,type,cs_id,cs_i_id,inputed,c,url){
                        $.ajax({
                                        type: "POST",
                                        url: url,
                                        data :  $.param($.fn.computeCs(studentid,sched_id,type,cs_id,cs_i_id,c)),
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

     $.fn.computeExam = function(studentid,exam_id,sched_id,type){
         var maxx=($('#total_exam_'+sched_id+'-'+type).val());
        var inputed=($('#exam_score_'+exam_id+'_'+studentid+'_'+sched_id+'-'+type).val());
            if((parseInt(inputed)>parseInt(maxx) || $.fn.checkInput(inputed,maxx.length)===false) && inputed!='' ){
                 alert(inputed+' greaterthan '+maxx);
                 $(this).val('');
                 $(this).attr('onblur','');
                 $.fn.computeExam(studentid,exam_id,sched_id,type);
            }else{
                var exm_count = parseInt($('#cs_count-'+type).val());
                var urlx ="<?=base_url('UpdateStudentExam')?>";
                var data_exm_array={};
                data_exm_array["lecunits"]=lecunits;
                data_exm_array["labunits"]=labunits;
                data_exm_array["studentid"]=studentid;
                data_exm_array["type"]=type;
                data_exm_array["schedid"]=sched_id;
                data_exm_array["exm_val"]= (inputed=='') ? 'NULL':inputed;
                data_exm_array["exm_id"]=exam_id;
                    inputed=(inputed=='')?0:inputed;
                var equiv=(inputed=='') ? '': (obj[parseInt(maxx)][parseInt(inputed)]);
                $('#exam_scoreequiv_'+studentid+'_'+sched_id+'-'+type).text(equiv);
                var prcnt=($.fn.prcnt(equiv,type,'exam'));
                    prcnt = (inputed=='') ? '': prcnt.toFixed(1);
                 $('#exam_scoreprcnt_'+studentid+'_'+sched_id+'-'+type).text(prcnt);
                var cs=$('#cs_scoreprcnt_'+studentid+'-'+type).text();
                var finalx = (Number(cs)+Number(prcnt));
                    final = (inputed=='') ? '': finalx.toFixed(1);
                 $('#exam_scorefinal_'+studentid+'_'+sched_id+'-'+type).text(final+'%');
                    $(this).attr('onblur','$(this).sent_data_exam("'+studentid+'","'+sched_id+'","'+type+'","'+exam_id+'","'+urlx+'")');
                 data_exm_array["final"]=(inputed=='') ? 'NULL': finalx.toFixed(1);
                $.fn.failedPassed(studentid,sched_id,type,final);
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

      $.fn.ena_edit_cs = function(studentid,sched_id,type,cs_id,cs_i_id,c){
          $(this).find("span").text('');
            $('#cs_score_'+sched_id+'_'+cs_id+'_'+cs_i_id+'_'+studentid+'-'+type+c).attr('type','number');
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

      $.fn.importDataCs = function(teacher_id,sched_id,cs_id,cs_i_id,type,cs_desc,cs_i_title,cs_i_dateu){
                        $('#classImportCsvDataCSELabel span').text(cs_desc);
                        $('#cs_i_title').text(cs_i_title);
                        $('#cs_i_dateu').text(cs_i_dateu);
                        $('input#cs_imp_scores').attr('onblur','$(this).checkImportCsv("'+teacher_id+'","'+sched_id+'","'+cs_id+'","'+cs_i_id+'","'+type+'","'+cs_desc+'","'+cs_i_title+'","'+cs_i_dateu+'");');
                        $('button#cs_imp_sent').attr('disabled',true);
                        $('#classImportCsvDataCSE').modal('show');
                        return false;
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

       $.fn.setRemarks = function(student_id){
              $.ajax({
            type  : 'POST',
            url   : '<?=base_url('add_remarks_grade')?>',
            data  : {
                      sched_id:sched_id,
                      student_id:student_id,
                      remarks:$(this).val(),
            },
            dataType : 'html',
            error : function(){
              console.log('error');
            },
            success : function(data){
              console.log(data);
             $('#updateGradeSubmissionModal .modal-body').html('<div class="alert alert-success">'+
                                                          '  <strong>Success!</strong> submitted grades'+
                                                          '</div>');
            }
        });
    };



});
</script>