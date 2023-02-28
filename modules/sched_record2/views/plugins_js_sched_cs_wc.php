
<script type="text/javascript">
 $(document).ready(function(){

$.fn.datePickershow = function(tr_index){
        $(this).datetimepicker({
                format: 'MMM DD YYYY',
                minDate: moment().subtract(6,'month'),
                maxDate: moment().add(6, 'month')
        });
};

$("#tpl_more").on('click',function(){
     var tr = this.closest( "tbody" );
     var tr_count =tr.children.length;
     tr_count = tr_count+1;
       var add_items =      '   <tr class="cs_adding_wc">'+
                            '   <td>'+tr_count+'</td>'+
                            '   <td><div class="input-group col-md-10 col-md-offset-1"><input type="text" class="form-control" id="cs_desc_'+tr_count+'"><span class="dspl-hide" id="cs_desc_i_'+tr_count+'"></span></div></td>'+
                            '   <td><div class="input-group col-md-7 col-md-offset-1"><input type="number" min="5" max="1000" class="form-control"  id="cs_items_'+tr_count+'"><span id="cs_items_i_'+tr_count+'" class="dspl-hide"></span></div></td>'+
                            '   <td>'+
                            '       <div class="input-group date datetimepicker1 col-md-7 col-md-offset-3" onclick="$(this).datePickershow('+tr_count+');" >'+
                            '           <input type="text" class="form-control" id="cs_date_'+tr_count+'" onclick="$(this).datePickershow('+tr_count+');" />'+
                            '           <span class="input-group-addon">'+
                            '               <span class="glyphicon glyphicon-calendar"></span>'+
                            '           </span>'+
                            '       </div>'+
                            '      <span id="cs_date_i_'+tr_count+'" class="dspl-hide"></span>'+
                            '   </td>'+
                            '   <td style="width:255px" >'+
                            '   <div class="input-group col-sm-12 " >'+
                            '       <button type="button" class="col-md-1 col-md-offset-1 btn btn-primary btn-xs " onclick="$(this).saveCSitems('+tr_count+');" ><i class="glyphicon glyphicon-floppy-disk"></i></button>'+
                            '       <button type="button" id="cancel_add_'+tr_count+'" class="col-md-1 col-md-offset-1  btn btn-warning btn-xs " onclick="$(this).delCSitems('+tr_count+');"  ><i class="fa fa-minus"></i></button>'+
                            '    </div>'+
                            '   </td>'+
                            '   </tr>';

        $('#createCSwcItems tbody').append(add_items);
});

$.fn.delCSitems = function(tr_index){
    this.closest( "tr" ).remove();
};

$.fn.editCSitems = function(tr_index,cs_id){
    $(this).attr('onclick','$(this).updateCSitems('+tr_index+','+cs_id+');');
    $(this).removeClass('btn-info');
    $(this).addClass('btn-primary');
    $(this).children(':first').removeClass('glyphicon-pencil');
    $(this).children(':first').addClass('glyphicon-floppy-disk');
    $("#cs_desc_"+tr_index).attr('type','text');
    $("#cs_items_"+tr_index).attr('type','number');
    $("#cs_date_"+tr_index).closest( "div" ).removeClass('dspl-hide');
    $("#cs_desc_i_"+tr_index).addClass('dspl-hide');
    $("#cs_items_i_"+tr_index).addClass('dspl-hide');
    $("#cs_date_i_"+tr_index).addClass('dspl-hide');

};

$.fn.updateCSitems = function(tr_index,cs_id){
    var el= $(this);
    var cs_desc = $("#cs_desc_"+tr_index).val();
    var cs_items = $("#cs_items_"+tr_index).val();
    var cs_date = $("#cs_date_"+tr_index).val();
    if(cs_desc==="" || cs_items==="" || cs_date===""){
        alert("NOT COMPLETE");
    }else{
          $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record_wc/update_sched_cs')?>",
                                data : {
                                        cs_id     : cs_id,
                                        cs_desc   : cs_desc,
                                        cs_items  : cs_items,
                                        cs_date   : cs_date,
                                        sched_id  : sched_id,
                                        type      : $('#_this_type').val()
                                },
                                dataType:  "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    if(data!=0){
                                        el.attr('onclick','$(this).editCSitems('+tr_index+','+cs_id+');');
                                        el.removeClass('btn-primary');
                                        el.addClass('btn-info');
                                        el.children(':first').removeClass('glyphicon-floppy-disk');
                                        el.children(':first').addClass('glyphicon-pencil');

                                        $("#cs_desc_"+tr_index).attr('type','hidden');
                                        $("#cs_items_"+tr_index).attr('type','hidden');
                                        $("#cs_date_"+tr_index).closest( "div" ).addClass('dspl-hide');
                                        $("#cs_desc_i_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_items_i_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_date_i_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_desc_i_"+tr_index).text(cs_desc);
                                        $("#cs_items_i_"+tr_index).text(cs_items);
                                        $("#cs_date_i_"+tr_index).text(cs_date);

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

$.fn.saveCSitems = function(tr_index){
    var el= $(this);
    el.attr('disabled',true);
    var cs_desc = $("#cs_desc_"+tr_index).val();
    var cs_items = $("#cs_items_"+tr_index).val();
    var cs_date = $("#cs_date_"+tr_index).val();
    var type = $('#_this_type').val();
    if(cs_desc==="" || cs_items==="" || cs_date===""){
        alert("NOT COMPLETE");
    }else{
          $.ajax({
                                type: "POST",
                                url: "<?=base_url('sched_record2/sched_cs_record_wc/create_sched_cs')?>",
                                data : {
                                        cs_desc   : cs_desc,
                                        cs_items  : cs_items,
                                        cs_date   : cs_date,
                                        sched_id  : sched_id,
                                        type      : type
                                },
                                dataType:  "html",
                                error: function(){
                                    alert('error');
                                },
                                success: function(data){
                                    if(data!=0){
                                        el.attr('onclick','$(this).editCSitems('+tr_index+','+data+');');
                                        el.removeClass('btn-primary');
                                        el.addClass('btn-info');
                                        el.children(':first').removeClass('glyphicon-floppy-disk');
                                        el.children(':first').addClass('glyphicon-pencil');

                                        $("#cs_desc_"+tr_index).attr('type','hidden');
                                        $("#cs_items_"+tr_index).attr('type','hidden');
                                        $("#cs_date_"+tr_index).closest( "div" ).addClass('dspl-hide');
                                        $("#cs_desc_i_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_items_i_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_date_i_"+tr_index).removeClass('dspl-hide');
                                        $("#cs_desc_i_"+tr_index).text(cs_desc);
                                        $("#cs_items_i_"+tr_index).text(cs_items);
                                        $("#cs_date_i_"+tr_index).text(cs_date);

                                         $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-success auto_save_success">success</div></div></div> ');
                                         $('#statusAutoSave').modal('show');
                                         $('#statusAutoSave').delay(700).queue(function() {
                                             $('#statusAutoSave').modal('hide');
                                             $('#statusAutoSave').remove();
                                         });

                                         if(tr_index>0){
                                            $("#cancel_add_"+tr_index).attr('onclick','$(this).deleteCSitems('+tr_index+','+data+');');
                                            $("#cancel_add_"+tr_index).addClass('btn-danger');
                                            $("#cancel_add_"+tr_index).removeClass('btn-warning');
                                            $("#cancel_add_"+tr_index).children(':first').removeClass('fa fa-minus');
                                            $("#cancel_add_"+tr_index).children(':first').addClass('glyphicon glyphicon-trash');
                                        }else{
                                             el.attr('disabled',false);
                                            // el.closest("td").append('<button type="button" id="cancel_add_'+tr_index+'" class="btn btn-danger btn-xs " onclick="$(this).deleteCSitems('+tr_index+','+data+');"  ><i class="glyphicon glyphicon-trash"></i></button>');
                                            $.fn.getViewCsWC(type,sched_id);
                                        }
                                    }
                                }
                    });

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
                            url: "<?=base_url('sched_record2/sched_cs_record_wc/view_cs_items')?>",
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


 $.fn.deleteCSitems = function(tr_index,cs_id){
    var el = $(this);
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_wc/delete_sched_cs')?>",
                            data : {
                                    cs_id : cs_id,
                                    sched_id : sched_id,
                                    type :  $('#_this_type').val()
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                if(data!=''){
                                    el.closest( "tr" ).remove();
                                }
                            }
                });
 };

});
</script>
