
<script type="text/javascript">

var total_cs ='';
var prcnt_cs =Number($('#cs_prcnt').val());
var prcnt_exm =Number($('#exam_prcnt').val());
 $(document).ready(function(){

     $.fn.computeCs = function(studentid,x,sched_id,type){
        var grade = $(this);
        var urlx ="<?=base_url('UpdateStudentCS_GRADELCLB')?>";
         if(grade.val()<=99){
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
                    if(data!=''){
                         var classAddRem=['animate-bg'];
                         var el=$("#row_"+studentid+' td');
                         $.fn.animateBg(el,classAddRem);
                    }
                }
        });
        var grade_total = 0;
        $('input[name="pre_grade_'+studentid+'[]"]').each(function(){
              grade_total  += parseInt($(this).val());
        });
        var divisor = SEM == 3 ? 2 : 3;
        grade_total = grade_total / Number(divisor);
        $('#'+studentid+'_final_grade').text(grade_total.toFixed(2));

        }else{
          alert('Input Exceeded');
          grade.val(0);
        }
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