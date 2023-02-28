
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
        else
            check=false;
       return check;
     };

     $.fn.prcnt = function(equiv,type , cs_exam){
            var prcnt=($('#'+cs_exam+'_prcnt').val());
           return (equiv*prcnt);
     };
     // schedid_507_1_0_p

     $.fn.computeTotalTransPrcntCS = function(studentid,sched_id,type,cs_id,tr_count){
        var total_cs = 0;
        var trans = ($("#cs_id_list").val());
            trans = trans.split(',');
             for(var t=0;t<tr_count;t++){
                var contg_el =$("#cs_score_"+sched_id+"_"+trans[t]+"_"+studentid+"-"+type+"-"+t).val();
                total_cs=total_cs+Number(contg_el);
            }
            var averg = total_cs/tr_count;
                averg = averg.toFixed(2);
            $("#cs_scoretotal_"+studentid+"-"+type).text(total_cs);
            $("#cs_trans_"+studentid+"-"+type).text(averg);
            // var prcnt = trans[total_cs]*prcnt_cs;
            //     prcnt = prcnt.toFixed(2);
            // var e_prcnt =  $("#exam_scoreprcnt_"+studentid+"_"+sched_id+"-"+type).text();
            // var final_grade = Number(prcnt)+Number(e_prcnt);
            //     final_grade = final_grade.toFixed(2);
            //     if(final_grade<75){
            //         $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").removeClass('passed');
            //         $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").addClass('failed');
            //     }else{
            //         $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").removeClass('failed');
            //         $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").addClass('passed');
            //     }
            // $("#cs_scoreprcnt_"+studentid+"-"+type).text(prcnt);
            $("#exam_scorefinal_"+studentid+"_"+sched_id+"-"+type+" span").text(averg);
     };

     $.fn.computeCs = function(studentid,sched_id,type,cs_id,c,sending=false){

        var tr_count =$("#cs_id_length").val();
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
                    inputed = (inputed=='00') ? 'E':inputed;
                    var url ="<?=base_url('UpdateStudentCS_CONTG')?>";
                    var data_cs_array={};
                        data_cs_array["studentid"]=studentid;
                        data_cs_array["type"]=type;
                        data_cs_array["schedid"]=sched_id;
                        data_cs_array["cs_val"]= (inputed=='') ? 'NULL':inputed;
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
});
</script>