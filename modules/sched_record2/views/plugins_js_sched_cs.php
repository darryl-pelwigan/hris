<script type="text/javascript">
 $(document).ready(function(){

             $.fn.createCS = function(schedid,teacherID,type) {
                 if($('#cs_c_desc').val()!='' && $('#cs_c_items').val()!='default' && $('#cs_c_prcnt').val()!='default' ){
                    $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/create_sched_cs')?>",
                                data : {
                                        cs_desc : $('#cs_c_desc').val(),
                                        item : null,
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
             $.fn.editCS = function(teacherId,csid,csdesc,csprcnt,schedid,type) {
                  $("#cs_e_desc").val(csdesc);
                  $("#cs_e_prcnt").val(csprcnt);
                  $("#edit_cs").attr('onclick','$(this).updateCS("'+teacherId+'","'+csid+'","'+csdesc+'","'+csprcnt+'","'+schedid+'","'+type+'");');
                  $('#classStandingModalEdit').modal('show');
             };


            $.fn.updateCS = function(teacherId,csid,csdesc,csprcnt,schedid,type){
                var prcnt_n=$("#cs_e_prcnt").val();
                var desc_n=$("#cs_e_desc").val();
                console.log();
                if(desc_n!=csdesc || prcnt_n!=csprcnt){
                   var c = confirm('Do you really want to continue.');
                        if(c){
                            $.ajax({
                                        type: "POST",
                                        url: "<?=base_url('sched_record2/sched_cs_record/update_sched_cs')?>",
                                        data : {
                                                cs_id : csid,
                                                cs_desc : desc_n,
                                                cs_items : null,
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

            //
             $.fn.viewCSitems = function(teacherId,csid,schedid,type,desc) {
                $('#classStandingModalViewCsItems').modal('show');
                $('#classStandingModalViewCsItemsLabel span').html(desc);
                $('#classStandingModalViewCsItems #AddCsItems span').html(desc);
                $('#classStandingModalViewCsItems #AddCsItems').attr('onclick','$(this).AddCsItems("'+teacherId+'","'+csid+'","'+schedid+'","'+type+'","'+desc+'");');
                   $.ajax({
                                        type: "POST",
                                        url: "<?=base_url('sched_record2/sched_cs_record/view_cs_items')?>",
                                        data : {
                                                cs_id : csid,
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
                                                   $("#cs_list").html(data);
                                            }
                                        }
                            });
             };

             $.fn.AddCsItems = function(teacherId,csid,schedid,type,desc){
                 $('#classStandingModalViewCsItems').modal('hide');
                 $('#classStandingModalAddCsItems').modal('show');
                 $('#classStandingModalAddCsItems #addcsitems_cs').attr('onclick','$(this).sentAddCsItems("'+teacherId+'","'+csid+'","'+schedid+'","'+type+'","'+desc+'");');
             };

              $.fn.sentAddCsItems = function(teacherId,csid,schedid,type,desc){
                    var title = $('#cs_addcs_title').val();
                    var items = $('#cs_addcs_items').val();
                    if(title!='' || items!='default'){
                             $.ajax({
                                        type: "POST",
                                        url: "<?=base_url('sched_record2/sched_cs_record/add_cs_items')?>",
                                        data : {
                                                cs_id : csid,
                                                teacher_id : teacherId,
                                                sched_id : schedid,
                                                type : type,
                                                title : title,
                                                items : items
                                        },
                                        dataType: "json",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            if(data.error_c==0){
                                                $('#classStandingModalAddCsItems').modal('hide');
                                                $('.modal-backdrop').fadeOut();
                                                $('body').removeClass('modal-open');
                                                $.fn.viewCSitems(teacherId,csid,schedid,type,desc);
                                            }else{
                                                alert(data.message);
                                            }
                                        }
                            });
                    }else{
                        alert('Please Add Title and Items.');
                    }
             };

             $.fn.editCSItem = function(teacherId,csid,csi_id,csi_title,csi_items,schedid,type){
                $('#classStandingModalViewCsItems').modal('hide');
                $('#classStandingModalEditCsItems').modal('show');
                $('#classStandingModalEditCsItemsLabel span').text(csi_title);
                var options = '<option value="'+csi_items+'" >'+csi_items+'</option>';
                var gt=0;
                for(var x=1; x<=40; x++){
                    gt=x*5;
                    options =  options + '<option value="'+gt+'" >'+gt+'</option>';
                }
                $('#cs_editcs_title').val(csi_title);
                $('#cs_editcs_items').html(options);
                $('#editcsitems_cs').attr('onclick','$(this).sentEditCSItem(\''+teacherId+'\',\''+csid+'\',\''+csi_id+'\',\''+csi_title+'\',\''+csi_items+'\',\''+schedid+'\',\''+type+'\')');
             };

             $.fn.sentEditCSItem = function(teacherId,csid,csi_id,csi_title,csi_items,schedid,type){
                var n_title = $('#cs_editcs_title').val();
                var n_items = $('#cs_editcs_items').val();

                if(n_title!=csi_title || n_items!=csi_items ){
                       $.ajax({
                                        type: "POST",
                                        url: "<?=base_url('sched_record2/sched_cs_record/edit_cs_item')?>",
                                        data : {
                                                cs_id : csid,
                                                cs_i_id : csi_id,
                                                csi_title : n_title,
                                                csi_items : n_items,
                                                teacher_id : teacherId,
                                                sched_id : schedid,
                                                type : type
                                        },
                                        dataType: "html",
                                        error: function(){
                                            alert('error');
                                        },
                                        success: function(data){
                                            $('#classStandingModalEditCsItems').modal('hide');
                                        }
                            });
                }else{
                    console.log('Nothing to update');
                }

             };

            $.fn.deleteCSItem = function(teacherId,csid,csi_id,csi_title,csi_items,schedid,type){
                var c = confirm('Do you really want to continue.');
                if(c){
                          $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/delete_cs_items')?>",
                                data : {
                                        cs_i_id : csi_id,
                                        cs_id : csid,
                                        schedid : schedid,
                                        type : type
                                },
                                dataType: "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    $('#classStandingModalViewCsItems').modal('hide');
                                    $('.modal-backdrop').fadeOut();
                                    $('body').removeClass('modal-open');
                                if(data!=''){
                                        $.fn.getViewCs(type,schedid);
                                }
                                }
                    });
                }
             };

             /*cs templates start*/
             $('#cs_tpl').on('change',function(){
                var cs_tpl_id = $(this).children(":selected").attr("id");

                   if(cs_tpl_id!==undefined){
                          $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/show_selected_template')?>",
                                data : {
                                        cs_tpl_id : cs_tpl_id,
                                        sched_id : sched_id
                                },
                                dataType: "json",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    var type = $('#_this_type').val();
                                     $('#classStandingModalCStemplate').modal('show');
                                     $('#cs_template_title span').text(data.title);
                                     $('#cs_template ').html(data.test);
                                     $('#use_cs_template').attr('onclick','$(this).use_cs_template('+cs_tpl_id+',\''+type+'\','+sched_id+');');
                                }
                    });
                }else{
                    console.log("non");
                }


             });

             $.fn.use_cs_template = function(cs_tpl_id,type,sched_id){
                  $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/insert_selected_template')?>",
                                data : {
                                        cs_tpl_id : cs_tpl_id,
                                        sched_id : sched_id,
                                        type : type
                                },
                                dataType: "json",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    $('#classStandingModalCStemplate').modal('hide');
                                    $('.modal-backdrop').fadeOut();
                                    $('body').removeClass('modal-open');
                                       $.fn.getViewCs(type,sched_id);
                                }
                    });
             };



             $.fn.createCStemplate = function(){
                 $('#classStandingModalcreateCStemplate').modal('show');
             };

             $('#tpl_more').on('click',function(){
                        var rowCount = $('#createCsTemplateTable tbody tr').length;
                        var options = '<option value="default">PERCENT</option>';
                        var gt=0;
                         for(var x=1; x<=20; x++){
                                gt=x*5;
                                options =  options + '<option value="'+gt+'" >'+gt+'</option>';
                            }
                        var tr= '<tr>'+
                                '<td><input type="text" value="" id="desc_'+rowCount+'" /></td>'+
                                '<td><select class="form-control" id="prcnt_'+rowCount+'">'+options+'</select></td>'+
                                '<td><button type="button" class="btn btn-warning btn-xs tpl_les"><i class="fa fa-minus"></i></button></td>'+
                                '</tr>';

                        $('#createCsTemplateTable tbody').append(tr);
                            $('.tpl_les').on('click',function(){
                                $(this).parent().parent().remove();
                             });
                     });

            $.fn.createCsTemplatesend = function(){
                var type = $('#_this_type').val();
                         var title = $('#cs_createcstemplate_title').val();
                         var rowCount = $('#createCsTemplateTable tbody tr').length;
                         var data_tpl = {};
                         var c = {};
                         var total_prcnt =0;
                         var error_c = 0;
                         var error_message='';
                         for(var x=0;x<(rowCount);x++){
                            var desc = $('#desc_'+x).val();
                            var prcnt = Number($('#prcnt_'+x).val());

                            if(desc!=='' && prcnt!=='' && prcnt!==0 && isNaN(prcnt)===false){
                                total_prcnt =total_prcnt+prcnt;
                                c[desc] = prcnt;
                            }else{
                                error_c++;
                                error_message='Some fields are empty\n';
                            }
                         }
                          if(total_prcnt!=100){
                                error_c++;
                                error_message +='total CS is not equal to 100\n';
                            }
                         if(title==''){
                                error_c++;
                                error_message +='TITLE field is empty\n';
                            }
                            data_tpl['c']=c;
                            data_tpl['title']=title;
                            data_tpl['sched_id']= sched_id;
                            data_tpl['rowCount']= rowCount;
                         if(error_c>0){
                            alert(error_message+'\nERROR detected count'+error_c);
                         }else{

                            $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record/create_cs_template')?>",
                                data :  $.param(data_tpl),
                                dataType: "json",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    $('#createCsTemplateTable').modal('hide');
                                    $('.modal-backdrop').fadeOut();
                                    $('body').removeClass('modal-open');
                                    $.fn.getViewCs(type,sched_id);
                                }
                            });
                         }


            };












             /*cs templates start*/


});
</script>