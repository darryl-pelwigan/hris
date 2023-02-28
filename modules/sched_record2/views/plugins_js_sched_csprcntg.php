<script type="text/javascript">
 $(document).ready(function(){

             $.fn.createCS = function(schedid,teacherID,type) {
                 if($('#cs_c_desc').val()!='' && $('#cs_c_items').val()!='default' && $('#cs_c_prcnt').val()!='default' ){
                    $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/create_sched_cs')?>",
                                data : {
                                        cs_desc : $('#cs_c_desc').val(),
                                        item : $('#cs_c_items').val(),
                                        prcnt : $('#cs_c_prcnt').val(),
                                        sched_id : sched_id,
                                        type : type
                                },
                                dataType: "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                if(data!=''){
                                    $('#classStandingModalAdd').modal('hide');
                                        $('.modal-backdrop').fadeOut();
                                        $('body').removeClass('modal-open');
                                        $.fn.getViewCs(type,schedid);
                                }
                                }
                    });
                }else{
                      var error_message = '' ;


                    if($('#cs_c_items').val()=='default' && $('#cs_c_prcnt').val()!='default'){
                        error_message = 'Select CS Items';
                    }else if($('#cs_c_items').val()!='default' && $('#cs_c_prcnt').val()=='default'){
                        error_message = 'Select CS Percent';
                    }else{
                        error_message = 'Select CS Items And Percent';
                    }
                   if($('#cs_c_desc').val()==''){
                            error_message =  'Add Description ,' + error_message;
                    }
                    alert(error_message);
                }
            };

             $.fn.deleteCS = function(cs_id,schedid,type) {
                 var c = confirm('Do you really want to continue.');
                 if(c){
                    $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/delete_sched_cs')?>",
                                data : {
                                        cs_id : cs_id,
                                        schedid : schedid,
                                        type : type
                                },
                                dataType: "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                if(data!=''){
                                        $.fn.getViewCs(type,schedid);
                                }
                                }
                    });
                }
            };

            //
             $.fn.editCS = function(teacherId,csid,csdesc,csitem,csprcnt,schedid,type) {
                  $("#cs_e_desc").val(csdesc);
                  $("#cs_e_items").val(csitem);
                  $("#cs_e_prcnt").val(csprcnt);
                  $("#edit_cs").attr('onclick','$(this).updateCS("'+teacherId+'","'+csid+'","'+csdesc+'","'+csitem+'","'+csprcnt+'","'+schedid+'","'+type+'");');
                $('#classStandingModalEdit').modal('show');
             };


            $.fn.updateCS = function(teacherId,csid,csdesc,csitem,csprcnt,schedid,type){
                var items_n=$("#cs_e_items").val();
                var prcnt_n=$("#cs_e_prcnt").val();
                var desc_n=$("#cs_e_desc").val();
                console.log();
                if(items_n!=csitem || desc_n!=csdesc || prcnt_n!=csprcnt){
                   var c = confirm('Do you really want to continue.');
                        if(c){
                            $.ajax({
                                        type: "POST",
                                        url: "<?=base_url('sched_record2/sched_cs_record/update_sched_cs')?>",
                                        data : {
                                                cs_id : csid,
                                                cs_desc : desc_n,
                                                cs_items : items_n,
                                                cs_prcnt : prcnt_n,
                                                teacher_id : teacherId,
                                                sched_id : schedid,
                                                type : type
                                        },
                                        dataType: "html",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            if(data!=''){
                                                    $('#classStandingModalAdd').modal('hide');
                                                    $('.modal-backdrop').fadeOut();
                                                    $('body').removeClass('modal-open');
                                                    $.fn.getViewCs(type,schedid);
                                            }
                                        }
                            });
                        }
                }else{
                    alert("Nothing to update.");
                }
            };


});
</script>