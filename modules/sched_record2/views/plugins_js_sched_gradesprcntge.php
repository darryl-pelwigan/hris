
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
     
     $.fn.computeCs = function(studentid,sched_id,type,cs_id,c){
        var cs_total=($('#cs_'+sched_id+'-'+type+'-'+cs_id+'-total').val());
        var cs_prcnt=($('#cs_'+sched_id+'-'+type+'-'+cs_id+'-prcnt').val());
        var inputed=($('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+c).val());
        var cs_count = parseInt($('#cs_count-'+type).val());
        var cs_id_a = ($('#cs_id_list'+sched_id+'-'+type).val()).split(",");
        var cs_prcnt_t = parseFloat($('#cs_prcnt').val());
        var cs_val = '';
        var total = 0;
        var equiv = '';
        var prcnt = '';
        var prcnt_cs_t=parseFloat(total)*parseFloat(cs_prcnt_t);
            if((parseInt(inputed)>parseInt(cs_total) || $.fn.checkInput(inputed,cs_total.length)===false) && inputed!='' ){
                     alert(inputed+' greaterthan '+cs_total);
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
                    for(var x=0;x<cs_count;x++){
                            cs_total=($('#cs_'+sched_id+'-'+type+'-'+cs_id_a[x]+'-total').val());
                            cs_prcnt=($('#cs_'+sched_id+'-'+type+'-'+cs_id_a[x]+'-prcnt').val());
                            inputed=($('#cs_score_'+sched_id+'_'+cs_id_a[x]+'_'+studentid+'-'+type+x).val());
                            if(inputed==''){
                               equiv = ''; 
                               prcnt = '';
                            }else{
                                equiv = obj[cs_total][inputed];
                                prcnt = equiv*(cs_prcnt/100);
                                prcnt = prcnt.toFixed(2);
                                total=parseFloat(total)+parseFloat(prcnt);
                                total = total.toFixed(2);
                            }
                            $('#cs_score_'+studentid+'_'+sched_id+'_'+cs_id_a[x]+'-'+type+'-trn').text(equiv);
                            $('#cs_score_'+studentid+'_'+sched_id+'_'+cs_id_a[x]+'-'+type+'-prcnt').text(prcnt);
                        }
                prcnt_cs_t=parseFloat(total)*parseFloat(cs_prcnt_t);
                $('#cs_scoretotal_'+studentid+'-'+type).text(total);
                $('#cs_scoreprcnt_'+studentid+'-'+type).text(prcnt_cs_t.toFixed(2));
                $(this).attr('onblur','$(this).sent_data_cs("'+studentid+'","'+sched_id+'","'+type+'","'+cs_id+'","'+inputed+'","'+c+'","'+url+'")');
                var e_prcnt = $('#exam_scoreprcnt_'+studentid+'_'+sched_id+'-'+type).text();
                e_prcnt = (e_prcnt==='')?0:e_prcnt;

                var final = parseFloat(prcnt_cs_t)+parseFloat(e_prcnt);
                final = final.toFixed(2);
                // console.log(e_prcnt+'---'+prcnt_cs_t+'----'+final+'---'+type);
                $('#exam_scorefinal_'+studentid+'_'+sched_id+'-'+type).text(final);
                data_cs_array["final"]=final;
               $.fn.failedPassed(studentid,sched_id,type,final);
                return (data_cs_array);
            }
     };

     $.fn.sent_data_cs = function(studentid,sched_id,type,cs_id,inputed,c,url){
      console.log($.fn.computeCs(studentid,sched_id,type,cs_id,c));
             $.ajax({
                                        type: "POST",
                                        url: url,
                                        data :  $.param($.fn.computeCs(studentid,sched_id,type,cs_id,c)),
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
        var  inputed=($('#exam_score_'+exam_id+'_'+studentid+'_'+sched_id+'-'+type).val());
        var  equiv= '';
        var prcnt= '';
        var finalx = '';
        var final = '';
        var cs=$('#cs_scoreprcnt_'+studentid+'-'+type).text();
            if((parseInt(inputed)>parseInt(maxx) || $.fn.checkInput(inputed,maxx.length)===false) && inputed!='' ){
                 alert(inputed+' greaterthan '+maxx);
                 $(this).val('');
                 $(this).attr('onblur','');
                 $.fn.computeExam(studentid,exam_id,sched_id,type);
            }else{
                var exm_count = parseInt($('#cs_count-'+type).val());
                var url ="<?=base_url('UpdateStudentExam')?>";
                var data_exm_array={};
                data_exm_array["lecunits"]=lecunits;
                data_exm_array["labunits"]=labunits;
                data_exm_array["studentid"]=studentid;
                data_exm_array["type"]=type;
                data_exm_array["schedid"]=sched_id;
                data_exm_array["exm_val"]= (inputed=='') ? 'NULL':inputed;
                data_exm_array["exm_id"]=exam_id;
                    inputed=(inputed=='')?0:inputed;
                     if(inputed==''){
                               equiv = ''; 
                               prcnt = '';
                               finalx = 'NULL';
                               final = parseFloat(cs);
                               final = final.toFixed(2);
                    }else{
                                equiv = (obj[parseInt(maxx)][parseInt(inputed)]);
                                prcnt = ($.fn.prcnt(equiv,type,'exam'));
                                prcnt = prcnt.toFixed(2);
                                finalx = (parseFloat(cs)+parseFloat(prcnt));
                                final = finalx.toFixed(2);
                    }
                
                $('#exam_scoreequiv_'+studentid+'_'+sched_id+'-'+type).text(equiv);
                $('#exam_scoreprcnt_'+studentid+'_'+sched_id+'-'+type).text(prcnt);
                $('#exam_scorefinal_'+studentid+'_'+sched_id+'-'+type).text(final);
                $(this).attr('onblur','$(this).sent_data_exam("'+studentid+'","'+sched_id+'","'+type+'","'+exam_id+'","'+url+'")');
                data_exm_array["final"] = finalx ;
                $.fn.failedPassed(studentid,sched_id,type,final);
                return (data_exm_array);
            }
     };

     $.fn.sent_data_exam = function(studentid,sched_id,type,exam_id,url){
    //    console.log($.fn.computeExam(studentid,exam_id,sched_id,type));
             $.ajax({
                                        type: "POST",
                                        url: url,
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

      $.fn.ena_edit_cs = function(studentid,sched_id,type,cs_id,c){
          $(this).find("span").text('');
            $('#cs_score_'+sched_id+'_'+cs_id+'_'+studentid+'-'+type+c).attr('type','number');
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
    
    
});           
</script>