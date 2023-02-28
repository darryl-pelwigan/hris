
<script type="text/javascript">
 $(document).ready(function(){
     
     $.fn.checkInput = function(inp_int,l){
         var pattern=/[A]/;
         var pattern2=/[0-9]/;
         var check;
        if(pattern2.test(inp_int) && inp_int.length<=l)
            check=true;
        else
            check=false;
       return check;
     };
     
     $.fn.computeIntern  = function(studentid,score,type){
        var maxx="100";
        var inputed=$(this).val(); 
          if((parseInt(inputed)>parseInt(maxx) || $.fn.checkInput(inputed,maxx.length)===false) && inputed!=''){
                 alert(inputed+' greaterthan '+maxx);
                 $(this).val('');
                 $(this).attr('onblur','');
            }else{
                var url ="<?=base_url('UpdateStudentIntern')?>";
                var data_int_array={};
                    data_int_array["studentid"]=studentid;
                    data_int_array["type"]=type;
                    data_int_array["schedid"]=sched_id;
                    data_int_array["grades_val"]= (inputed=='') ? 'NULL':inputed;
                    console.log(data_int_array);
                    $.fn.sent_data_intern(data_int_array,studentid,url);
            }
     };

     $.fn.sent_data_intern = function(data_int_array,studentid,url){
     
             $.ajax({
                                        type: "POST",
                                        url: url,
                                        data :  $.param(data_int_array),
                                        dataType: "html",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            console.log(data);
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

       $.fn.ena_edit_intern = function(studentid,sched_id,type){
          $(this).find("span").text('');
          $(this).find("input").attr('type','number');
      };
    
    
});           
</script>