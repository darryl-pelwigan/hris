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
                var cats_desc = $('#cs_createcs_category').val();
                var cats_percent = $('#cs_createcs_category_percent').val();
               if(cats_desc!=''){
                    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_nsub/cs_create_cats')?>",
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
$(".panel-heading").on('hover',function(){
    $(this).find('button').removeClass('dspl-hide');
});
//

$.fn.saveCSitems = function(tr_index,cats_id){
    var el= $(this);
    var cs_desc = $("#cs_desc_"+cats_id+"_"+tr_index).val();
    var cs_items = $("#cs_items_"+cats_id+"_"+tr_index).val();
    var cs_date = $("#cs_date_"+cats_id+"_"+tr_index).val();
    var type = $('#_this_type').val();

    if(cs_desc==="" || cs_items==="" || cs_date===""){
        console.log("NOT COMPLETE");

    }else{
                  $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record_nsub/create_cs_items')?>",
                                data : {
                                        cs_desc     : cs_desc,
                                        cs_items    : cs_items,
                                        cs_date     : cs_date,
                                        cats_id     : cats_id,
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
                                            $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-success auto_save_success">success</div></div></div> ');
                                            $('#statusAutoSave').modal('show');
                                            $('#statusAutoSave').delay(700).queue(function() {
                                                $('#statusAutoSave').modal('hide');
                                                $('#statusAutoSave').remove();
                                            });

                                            $('#cs_items_'+cats_id+'_'+tr_index).attr('type','hidden');
                                            $('#cs_desc_'+cats_id+'_'+tr_index).attr('type','hidden');
                                            $('#cs_date_i_'+cats_id+'_'+tr_index).closest('td').find('div').addClass('dspl-hide');

                                            $('#cs_date_i_'+cats_id+'_'+tr_index).text(cs_date);
                                            $('#cs_items_i_'+cats_id+'_'+tr_index).text(cs_items);
                                            $('#cs_desc_i_'+cats_id+'_'+tr_index).text(cs_desc);

                                            $('#cs_date_i_'+cats_id+'_'+tr_index).removeClass('dspl-hide');
                                            $('#cs_items_i_'+cats_id+'_'+tr_index).removeClass('dspl-hide');
                                            $('#cs_desc_i_'+cats_id+'_'+tr_index).removeClass('dspl-hide');

                                            el.attr('onclick','$(this).editCSitems('+tr_index+','+cats_id+','+data+');');
                                            el.find('i').removeClass('glyphicon-floppy-disk');
                                            el.find('i').addClass('glyphicon-pencil');
                                            el.removeClass('btn-primary');
                                            el.addClass('btn-info');
                                            var elc = $('#cancel_add_'+cats_id+'_'+tr_index);
                                            elc.attr('onclick','$(this).deleteCSitems('+tr_index+','+cats_id+','+data+');');
                                            elc.find('i').removeClass('fa fa-minus');
                                            elc.find('i').addClass('glyphicon glyphicon-trash');
                                            elc.removeClass('btn-warning');
                                            elc.addClass('btn-danger');
                                        }else{
                                            $.fn.getViewCsNSUB(type,sched_id);
                                        }
                                    }
                                }
                    });
    }
};


//
$.fn.createCsItems = function(tr_index,t,cats_id){

     var tr_count = document.getElementById('sub_items_'+cats_id+'_'+t).rows.length;
         tr_count --;
     var add_items =      '   <tr id="tr_'+tr_count+'" class="cs_adding_wc">'+
                            '   <td>'+tr_count+'</td>'+
                            '   <td><div class="input-group col-sm-10 col-sm-offset-1"><input type="text" class="form-control" id="cs_desc_'+cats_id+'_'+tr_count+'"><span class="dspl-hide" id="cs_desc_i_'+cats_id+'_'+tr_count+'"></span></div></td>'+
                            '   <td><div class="input-group col-sm-7 col-sm-offset-1"><input type="number" min="5" max="1000" class="form-control"  id="cs_items_'+cats_id+'_'+tr_count+'"><span id="cs_items_i_'+cats_id+'_'+tr_count+'" class="dspl-hide"></span></div></td>'+
                            '   <td>'+
                            '       <div class="input-group date datetimepicker1 col-sm-7 col-sm-offset-1" onclick="$(this).datePickershow('+tr_count+');" >'+
                            '           <input type="text" class="form-control" id="cs_date_'+cats_id+'_'+tr_count+'" onclick="$(this).datePickershow('+tr_count+');" />'+
                            '           <span class="input-group-addon">'+
                            '               <span class="glyphicon glyphicon-calendar"></span>'+
                            '           </span>'+
                            '       </div>'+
                            '      <span id="cs_date_i_'+cats_id+'_'+tr_count+'" class="dspl-hide"></span>'+
                            '   </td>'+
                            '   <td style="width:255px" >'+
                            '   <div class="input-group col-sm-12 " >'+
                            '       <button type="button" class="col-md-1 col-md-offset-1 btn btn-primary btn-xs " onclick="$(this).saveCSitems(\''+tr_count+'\',\''+cats_id+'\');" ><i class="glyphicon glyphicon-floppy-disk"></i></button>'+
                            '       <button type="button" id="cancel_add_'+cats_id+'_'+tr_count+'" class="col-md-1 col-md-offset-1  btn btn-warning btn-xs " onclick="$(this).delCSitems('+tr_count+','+cats_id+');"  ><i class="fa fa-minus"></i></button>'+
                            '    </div>'+
                            '   </td>'+
                            '   </tr>';

        $('#sub_items_'+cats_id+'_'+t+' tbody').append(add_items);
};

$.fn.delCSitems = function(tr_index,cats_id,sub_id){
    this.closest( "tr" ).remove();
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
    $('#delete_message').text('Are you sure you want to delete  this Category and all of its items?');
    $('#classStandingModalLabel').text('Delete Category CS');
    $('#classStandingModalDelCats').modal('show');
    $('#delete_cs_cats').attr('onclick','$(this).sentDeleteCats(\''+cat_id+'\')');
};

$.fn.sentUpdateCats =function(cat_id,desc,percent,sum_prcnt){
      var cs_desc = $("#cs_e_desc").val();
      var cs_percent = $("#cs_e_prcnt").val();
      if(cs_desc==='' && cs_items===''){
        console.log(cs_desc+'---'+cs_items);
      }else{
        $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_nsub/cs_update_cats')?>",
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

$.fn.sentDeleteCats =function(cats_id){
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_nsub/cs_delete_cats')?>",
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

    $.fn.deleteCSitems = function(tr_index,sub_id,cats_id){
        $('#delete_message').text('Are you sure you want to delete this Item?');
        $('#classStandingModalLabel').text('Delete CS Item');
        $('#classStandingModalDelCats').modal('show');
        $('#delete_cs_cats').attr('onclick','$(this).sentDeleteSubItems(\''+tr_index+'\',\''+sub_id+'\',\''+cats_id+'\')');
    };

    $.fn.editCSitems = function(tr_index,sub_id,cats_id){
        $('#cs_date_i_'+cats_id+'_'+tr_index).addClass('dspl-hide');
        $('#cs_items_i_'+cats_id+'_'+tr_index).addClass('dspl-hide');
        $('#cs_desc_i_'+cats_id+'_'+tr_index).addClass('dspl-hide');

        $('#cs_items_'+cats_id+'_'+tr_index).attr('type','number');
        $('#cs_desc_'+cats_id+'_'+tr_index).attr('type','text');
        $('#cs_date_i_'+cats_id+'_'+tr_index).closest('td').find('div').removeClass('dspl-hide');

        this.attr('onclick','$(this).updateCSitems('+tr_index+','+cats_id+','+sub_id+');');
        this.find('i').removeClass('glyphicon-pencil');
        this.find('i').addClass('glyphicon-floppy-disk');
        this.removeClass('btn-info');
        this.addClass('btn-primary');
    };

    $.fn.updateCSitems = function(tr_index,cats_id,sub_id){
        var el= $(this);
        var cs_desc = $("#cs_desc_"+cats_id+"_"+tr_index).val();
        var cs_items = $("#cs_items_"+cats_id+"_"+tr_index).val();
        var cs_date = $("#cs_date_"+cats_id+"_"+tr_index).val();
        var type = $('#_this_type').val();

    if(cs_desc==="" || cs_items==="" || cs_date===""){
        console.log("NOT COMPLETE");

    }else{
                  $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record_nsub/cs_update_items')?>",
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
                                        $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-success auto_save_success">success</div></div></div> ');
                                        $('#statusAutoSave').modal('show');
                                        $('#statusAutoSave').delay(700).queue(function() {
                                            $('#statusAutoSave').modal('hide');
                                            $('#statusAutoSave').remove();
                                        });

                                        $('#cs_items_'+cats_id+'_'+tr_index).attr('type','hidden');
                                        $('#cs_desc_'+cats_id+'_'+tr_index).attr('type','hidden');
                                        $('#cs_date_i_'+cats_id+'_'+tr_index).closest('td').find('div').addClass('dspl-hide');

                                        $('#cs_date_i_'+cats_id+'_'+tr_index).text(cs_date);
                                        $('#cs_items_i_'+cats_id+'_'+tr_index).text(cs_items);
                                        $('#cs_desc_i_'+cats_id+'_'+tr_index).text(cs_desc);

                                        $('#cs_date_i_'+cats_id+'_'+tr_index).removeClass('dspl-hide');
                                        $('#cs_items_i_'+cats_id+'_'+tr_index).removeClass('dspl-hide');
                                        $('#cs_desc_i_'+cats_id+'_'+tr_index).removeClass('dspl-hide');

                                        el.attr('onclick','$(this).editCSitems('+tr_index+','+cats_id+','+sub_id+');');
                                        el.find('i').removeClass('glyphicon-floppy-disk');
                                        el.find('i').addClass('glyphicon-pencil');
                                        el.removeClass('btn-primary');
                                        el.addClass('btn-info');


                                    }
                                }
                    });
    }
};



    $.fn.sentDeleteSubItems = function(tr_index,sub_id,cats_id){
        $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_nsub/cs_delete_cats_sub')?>",
                            data : {
                                    sched_id    : sched_id,
                                    typex       : type,
                                    cats_id     : cats_id,
                                    sub_id      : sub_id
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                console.log(data);
                            }
        });
         $('#classStandingModalDelCats').modal('hide');
         $('.modal-backdrop').fadeOut();
         $('body').removeClass('modal-open');
        $( "#tr_"+tr_index ).remove();
    };

});
</script>