<script type="text/javascript">
 $(document).ready(function(){
 var type = $('#_this_type').val();
    $.fn.datePickershow = function(tr_index){
        $(this).datetimepicker({
                format: 'MMM DD YYYY',
                minDate: moment().subtract(6,'month'),
                maxDate: moment().add(6, 'month')
        });
    };
    //
$(".panel-heading").hover(
    function(){
        $(this).find('button').removeClass('dspl-hide');
    },
    function(){
        $(this).find('button').addClass('dspl-hide');
    }
);
    //
             $('#tpl_more_cats').on('click',function(){
                $(this).attr('disabled',true);
                var cats_desc = $('#cs_createcs_category').val();
                var cats_percent = $('#cs_createcs_category_percent').val();
               if(cats_desc!=''){
                    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_create_cats')?>",
                            data : {
                                    sched_id : sched_id,
                                    typex : type,
                                    cats_desc : cats_desc,
                                    cats_percent : cats_percent
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                if(data!=''){
                                    $.fn.checkCScomputation(type);
                                }
                            }
                });
               }else{
                    console.log("NOT COMPLETE");
               }

             });
//
             $('#tpl_more_subs').on('click',function(){
                var subs_desc = $('#cs_createcs_subcat').val();
                var subs_percent = $('#cs_createcs_subcat_percent').val();
                var cat_id = $('#_this_cats_id').val();
               if(subs_desc!=''){
                    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_create_subs')?>",
                            data : {
                                    sched_id : sched_id,
                                    cats_id : cat_id,
                                    subs_desc : subs_desc,
                                    subs_percent : subs_percent
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                if(data!=''){
                                        $.fn.checkCScomputation(type);
                                }
                            }
                });
               }else{
                    console.log("NOT COMPLETE");
               }

             });
//
$.fn.saveCSitems = function(tr_index,cats_id,sub_id){
    var el= $(this);
    var cs_desc = $("#cs_desc_"+cats_id+"_"+sub_id+"_"+tr_index).val();
    var cs_items = $("#cs_items_"+cats_id+"_"+sub_id+"_"+tr_index).val();
    var cs_date = $("#cs_date_"+cats_id+"_"+sub_id+"_"+tr_index).val();
    var type = $('#_this_type').val();

    if(cs_desc==="" || cs_items==="" || cs_date===""){
        console.log("NOT COMPLETE");

    }else{
                  $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record_wsub/create_cs_wsub_items')?>",
                                data : {
                                        cs_desc     : cs_desc,
                                        cs_items    : cs_items,
                                        cs_date     : cs_date,
                                        cats_id     : cats_id,
                                        sub_id      : sub_id,
                                        sched_id    : sched_id,
                                        type        : type
                                },
                                dataType:  "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    if(data!=0){
                                         if(tr_index>0){
                                                el.attr('onclick','$(this).editCSitems('+tr_index+','+data+','+cats_id+','+sub_id+');');
                                                el.removeClass('btn-primary');
                                                el.addClass('btn-info');
                                                el.children(':first').removeClass('glyphicon-floppy-disk');
                                                el.children(':first').addClass('glyphicon-pencil');
                                                $("#cs_desc_"+cats_id+"_"+sub_id+"_"+tr_index).attr('type','hidden');
                                                $("#cs_items_"+cats_id+"_"+sub_id+"_"+tr_index).attr('type','hidden');
                                                $("#cs_date_"+cats_id+"_"+sub_id+"_"+tr_index).closest( "div" ).addClass('dspl-hide');
                                                $("#cs_desc_i_"+cats_id+"_"+sub_id+"_"+tr_index).removeClass('dspl-hide');
                                                $("#cs_items_i_"+cats_id+"_"+sub_id+"_"+tr_index).removeClass('dspl-hide');
                                                $("#cs_date_i_"+cats_id+"_"+sub_id+"_"+tr_index).removeClass('dspl-hide');
                                                $("#cs_desc_i_"+cats_id+"_"+sub_id+"_"+tr_index).text(cs_desc);
                                                $("#cs_items_i_"+cats_id+"_"+sub_id+"_"+tr_index).text(cs_items);
                                                $("#cs_date_i_"+cats_id+"_"+sub_id+"_"+tr_index).text(cs_date);

                                                $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-success auto_save_success">success</div></div></div> ');
                                                 $('#statusAutoSave').modal('show');
                                                 $('#statusAutoSave').delay(700).queue(function() {
                                                     $('#statusAutoSave').modal('hide');
                                                     $('#statusAutoSave').remove();

                                                 });
                                        }else{
                                            $.fn.checkCScomputation(type);
                                        }
                                    }
                                }
                    });
    }
};
//create items box

$.fn.createCsItems = function(tr_index,cats_id,sub_id){
     var tr_count = document.getElementById('sub_items_'+cats_id+'_'+tr_index).rows.length;
     tr_count --;
     var add_items =      '   <tr class="cs_adding_wc">'+
                            '   <td>'+tr_count+'</td>'+
                            '   <td><div class="input-group col-sm-10 col-sm-offset-1"><input type="text" class="form-control" id="cs_desc_'+cats_id+'_'+sub_id+'_'+tr_count+'"><span class="dspl-hide" id="cs_desc_i_'+cats_id+'_'+sub_id+'_'+tr_count+'"></span></div></td>'+
                            '   <td><div class="input-group col-sm-7 col-sm-offset-1"><input type="number" min="5" max="1000" class="form-control"  id="cs_items_'+cats_id+'_'+sub_id+'_'+tr_count+'"><span id="cs_items_i_'+cats_id+'_'+sub_id+'_'+tr_count+'" class="dspl-hide"></span></div></td>'+
                            '   <td>'+
                            '       <div class="input-group date datetimepicker1 col-sm-7 col-sm-offset-1" onclick="$(this).datePickershow('+tr_count+');" >'+
                            '           <input type="text" class="form-control" id="cs_date_'+cats_id+'_'+sub_id+'_'+tr_count+'" onclick="$(this).datePickershow('+tr_count+');" />'+
                            '           <span class="input-group-addon">'+
                            '               <span class="glyphicon glyphicon-calendar"></span>'+
                            '           </span>'+
                            '       </div>'+
                            '      <span id="cs_date_i_'+cats_id+'_'+sub_id+'_'+tr_count+'" class="dspl-hide"></span>'+
                            '   </td>'+
                            '   <td style="width:255px" >'+
                            '   <div class="input-group col-sm-12 " >'+
                            '       <button type="button" class="col-md-1 col-md-offset-1 btn btn-primary btn-xs " onclick="$(this).saveCSitems(\''+tr_count+'\',\''+cats_id+'\',\''+sub_id+'\');" ><i class="glyphicon glyphicon-floppy-disk"></i></button>'+
                            '       <button type="button" id="cancel_add_'+tr_count+'" class="col-md-1 col-md-offset-1  btn btn-warning btn-xs " onclick="$(this).delCSitems('+tr_count+','+cats_id+','+sub_id+');"  ><i class="fa fa-minus"></i></button>'+
                            '    </div>'+
                            '   </td>'+
                            '   </tr>';

        $('#sub_items_'+cats_id+'_'+tr_index+' tbody').append(add_items);
};

$.fn.delCSitems = function(tr_index,cats_id,sub_id){
    this.closest( "tr" ).remove();
};
//
$.fn.editCSitems = function(tr_index,cs_id,cats_id,sub_id){
    $(this).attr('onclick','$(this).updateCSitems('+tr_index+','+cs_id+','+cats_id+','+sub_id+');');
    $(this).removeClass('btn-info');
    $(this).addClass('btn-primary');
    $(this).children(':first').removeClass('glyphicon-pencil');
    $(this).children(':first').addClass('glyphicon-floppy-disk');
    $("#cs_desc_"+cats_id+"_"+sub_id+"_"+tr_index).attr('type','text');
    $("#cs_items_"+cats_id+"_"+sub_id+"_"+tr_index).attr('type','number');
    $("#cs_date_"+cats_id+"_"+sub_id+"_"+tr_index).closest( "div" ).removeClass('dspl-hide');
    $("#cs_desc_i_"+cats_id+"_"+sub_id+"_"+tr_index).addClass('dspl-hide');
    $("#cs_items_i_"+cats_id+"_"+sub_id+"_"+tr_index).addClass('dspl-hide');
    $("#cs_date_i_"+cats_id+"_"+sub_id+"_"+tr_index).addClass('dspl-hide');

};

$.fn.updateCSitems = function(tr_index,cs_id,cats_id,sub_id){
    var el= $(this);
    var cs_desc = $("#cs_desc_"+cats_id+"_"+sub_id+"_"+tr_index).val();
    var cs_items = $("#cs_items_"+cats_id+"_"+sub_id+"_"+tr_index).val();
    var cs_date = $("#cs_date_"+cats_id+"_"+sub_id+"_"+tr_index).val();
    var type = $('#_this_type').val();
    if(cs_desc==="" || cs_items==="" || cs_date===""){
        console.log("NOT COMPLETE");
    }else{
          $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record_wsub/update_sched_cs')?>",
                                data : {
                                        cs_desc     : cs_desc,
                                        cs_items    : cs_items,
                                        cs_date     : cs_date,
                                        cs_id       : cs_id,
                                        cats_id     : cats_id,
                                        sub_id      : sub_id,
                                        sched_id    : sched_id,
                                        type        : type
                                },
                                dataType:  "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    if(data!=0){
                                        el.attr('onclick','$(this).editCSitems('+tr_index+','+cs_id+','+cats_id+','+sub_id+');');
                                        el.removeClass('btn-primary');
                                        el.addClass('btn-info');
                                        el.children(':first').removeClass('glyphicon-floppy-disk');
                                        el.children(':first').addClass('glyphicon-pencil');
                                        $("#cs_desc_"+cats_id+"_"+sub_id+"_"+tr_index).attr('type','hidden');
                                        $("#cs_items_"+cats_id+"_"+sub_id+"_"+tr_index).attr('type','hidden');
                                        $("#cs_date_"+cats_id+"_"+sub_id+"_"+tr_index).closest( "div" ).addClass('dspl-hide');
                                        $("#cs_desc_i_"+cats_id+"_"+sub_id+"_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_items_i_"+cats_id+"_"+sub_id+"_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_date_i_"+cats_id+"_"+sub_id+"_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_desc_i_"+cats_id+"_"+sub_id+"_"+tr_index).text(cs_desc);
                                        $("#cs_items_i_"+cats_id+"_"+sub_id+"_"+tr_index).text(cs_items);
                                        $("#cs_date_i_"+cats_id+"_"+sub_id+"_"+tr_index).text(cs_date);

                                        $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-success auto_save_success">success</div></div></div> ');
                                         $('#statusAutoSave').modal('show');
                                         $('#statusAutoSave').delay(700).queue(function() {
                                             $('#statusAutoSave').modal('hide');
                                             $('#statusAutoSave').remove();

                                         });
                                    }
                                }
                    });
    }
};

$.fn.editCSCats = function(cat_id,desc,percent,sum_prcnt){
    $('#classStandingModalLabel').text('Edit Category CS');
    $('#classStandingModalEditCats').modal('show');
    $('#cs_e_desc').val(desc);

    var options='<option value="'+percent+'" selected="selected">'+percent+'</option>';
    var gt=0;
    for(var x = 0; x<=(20-sum_prcnt);x++){
        gt=x*5;
        options = options+'<option value="'+gt+'" >'+gt+'</option>';
    }
    $("#cs_e_prcnt").html(options);
    $('#edit_cs_cats').attr('onclick','$(this).sentUpdateCats(\''+cat_id+'\',\''+desc+'\',\''+percent+'\',\''+sum_prcnt+'\')');

};

$.fn.deleteCSCats = function(cat_id){
    $('#delete_message').text('Are you sure you want to delete  this Category and all of its Sub-category and items?');
    $('#classStandingModalLabel').text('Delete Category CS');
    $('#classStandingModalDelCats').modal('show');
    $('#delete_cs_cats').attr('onclick','$(this).sentDeleteCats(\''+cat_id+'\')');
};

$.fn.deleteCSitems = function(tr_index,cs_id,cat_id,sub_id){
    $('#delete_message').text('Are you sure you want to delete this Item?');
    $('#classStandingModalLabel').text('Delete CS Item');
    $('#classStandingModalDelCats').modal('show');
    $('#delete_cs_cats').attr('onclick','$(this).sentDeleteSubItems(\''+tr_index+'\',\''+cs_id+'\',\''+cat_id+'\',\''+sub_id+'\')');
};

$.fn.editCSsubs = function(cat_id,sub_id,desc,percent,sum_prcnt){
    $('#classStandingModalLabel').text('Edit Sub-Category CS');
    $('#classStandingModalEditCats').modal('show');
    $('#cs_e_desc').val(desc);
     var options='<option value="'+percent+'" selected="selected">'+percent+'</option>';
    var gt=0;
    for(var x = 0; x<=(20-sum_prcnt);x++){
        gt=x*5;
        options = options+'<option value="'+gt+'" >'+gt+'</option>';
    }
    $("#cs_e_prcnt").html(options);
    $('#edit_cs_cats').attr('onclick','$(this).sentUpdateSubs(\''+cat_id+'\',\''+sub_id+'\',\''+desc+'\',\''+percent+'\',\''+sum_prcnt+'\')');


};

$.fn.deleteCSsubs = function(cat_id,sub_id){
    $('#delete_message').text('Are you sure you want to delete  this Sub-category and all of its items?');
    $('#classStandingModalLabel').text('Delete Sub-Category CS');
    $('#classStandingModalDelCats').modal('show');
    $('#delete_cs_cats').attr('onclick','$(this).sentDeleteSubs(\''+cat_id+'\',\''+sub_id+'\')');
};

$.fn.sentUpdateCats =function(cat_id,desc,percent,sum_prcnt){
      var cs_desc = $("#cs_e_desc").val();
      var cs_percent = $("#cs_e_prcnt").val();
      if(cs_desc==='' && cs_items===''){
        console.log(cs_desc+'---'+cs_items);
      }else{
        $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_update_cats')?>",
                            data : {
                                    sched_id         : sched_id,
                                    cats_id          : cat_id,
                                    cs_desc          : cs_desc,
                                    cs_percent       : cs_percent
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                 $('#classStandingModalLabel').modal('hide');
                                 $('.modal-backdrop').fadeOut();
                                 $('body').removeClass('modal-open');
                                 $.fn.checkCScomputation(type);
                            }
                });
      }
};

$.fn.sentUpdateSubs =function(cat_id,sub_id,desc,percent,sum_prcnt){
      var cs_desc = $("#cs_e_desc").val();
      var cs_percent = $("#cs_e_prcnt").val();
      if(cs_desc==='' && cs_items===''){
        console.log(cs_desc+'---'+cs_items);
      }else{
        $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_update_subs')?>",
                            data : {
                                    sched_id         : sched_id,
                                    cats_id          : cat_id,
                                    sub_id           : sub_id,
                                    cs_desc          : cs_desc,
                                    cs_percent       : cs_percent
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                 $('#classStandingModalLabel').modal('hide');
                                 $('.modal-backdrop').fadeOut();
                                 $('body').removeClass('modal-open');
                                 $.fn.checkCScomputation(type);
                            }
                });
      }
};

$.fn.sentDeleteCats =function(cats_id){
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_delete_cats')?>",
                            data : {
                                    sched_id         : sched_id,
                                    cats_id          : cats_id
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                 $('#classStandingModalLabel').modal('hide');
                                 $('.modal-backdrop').fadeOut();
                                 $('body').removeClass('modal-open');
                                 $.fn.checkCScomputation(type);
                            }
    });
};

$.fn.sentDeleteSubs =function(cats_id,sub_id){
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_delete_subs')?>",
                            data : {
                                    sched_id         : sched_id,
                                    cats_id          : cats_id,
                                    sub_id          : sub_id
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                 $('#classStandingModalLabel').modal('hide');
                                 $('.modal-backdrop').fadeOut();
                                 $('body').removeClass('modal-open');
                                 $.fn.checkCScomputation(type);
                            }
    });
};

$.fn.sentDeleteSubItems =function(tr_index,cs_id,cats_id,sub_id){
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wsub/cs_delete_subs_items')?>",
                            data : {
                                    sched_id         : sched_id,
                                    cats_id          : cats_id,
                                    sub_id           : sub_id,
                                    cs_id            : cs_id
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                 $('#classStandingModalLabel').modal('hide');
                                 $('.modal-backdrop').fadeOut();
                                 $('body').removeClass('modal-open');
                                 $.fn.checkCScomputation(type);
                            }
    });
};

});
</script>