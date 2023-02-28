
<script type="text/javascript">

var total_cs ='';
var prcnt_cs =Number($('#cs_prcnt').val());
var prcnt_exm =Number($('#exam_prcnt').val());
 $(document).ready(function(){

     $.fn.computeCs = function(studentid,x,sched_id,type){
        var grade = $('#grade_'+sched_id+'_'+x+'_'+studentid+'');
        var urlx ="<?=base_url('UpdateStudentCS_GRADE')?>";
        $.ajax({
                type: "POST",
                url: urlx,
                data :  {
                            studentid : studentid,
                            grade : grade.val(),
                            sched_id : sched_id ,
                            type : type
                        },
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

      $.fn.ena_edit_cs = function(studentid,sched_id,type,c){
          $(this).find("span").text('');
          $('#grade_'+sched_id+'_'+c+'_'+studentid).attr('type','number');
      };
});
</script>