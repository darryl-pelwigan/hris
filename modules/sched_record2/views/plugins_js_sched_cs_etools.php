
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
     var etools = JSON.parse($('#etools_options').val());

     var options = '';
     for(var x=0;x<etools.cs_num;x++){
            options = options + '<option value="'+(etools.cs_query[x].id)+'">'+(etools.cs_query[x].etool_code)+'</option>';
     }
     tr_count = tr_count+1;
       var add_items =      '   <tr class="cs_adding_wc">'+
                            '   <td>'+tr_count+'</td>'+
                            '   <td><div class="input-group col-sm-10 col-sm-offset-1"><select class="form-control" id="etools_se_'+tr_count+'" > '+options+' </select></div></td>'+
                            '   <td>'+
                            '       <div class="input-group date datetimepicker1 col-sm-7 col-sm-offset-3" onclick="$(this).datePickershow('+tr_count+');" >'+
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



$.fn.saveCSitems = function(tr_index){
    var se_etools = $('#etools_se_'+tr_index).val();
    var cs_date = $("#cs_date_"+tr_index).val();
    var xtype = $('#_this_type').val();
    if( se_etools==="" || cs_date===""){
        alert("NOT COMPLETE");
    }else{
            $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_etools/save_sched_cs')?>",
                            data : {
                                    se_etools : se_etools,
                                    cs_date : cs_date,
                                    sched_id : sched_id,
                                    type :  xtype
                            },
                            dataType: "html",
                            error: function(){
                                alert('error');
                            },
                            success: function(data){
                                data = JSON.parse(data);
                                if(data.error==0){
                                    if(tr_index>1){
                                        $.fn.getViewCsETOOLS(xtype,sched_id);
                                    }else{
                                        $(this).remoe();
                                        var el_del = $('#cancel_add_'+tr_index);
                                            el_del.removeClass('col-md-1 col-md-offset-1  btn btn-warning btn-xs ');
                                            el_del.addClass('col-md-1 col-md-offset-1 btn btn-danger btn-xs');
                                            el_del.attr('onclick','$(this).deleteCSitems('+tr_index+','+data+');');
                                            $('#cancel_add_'+tr_index+' i').removeClass('fa fa-minus');
                                            $('#cancel_add_'+tr_index+' i').addClass('glyphicon glyphicon-trash');
                                    }
                                }else{
                                    $('body').remove("#statusAutoSave");
                                     $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-danger auto_save_danger">'+data.error_msg+'</div></div></div> ');
                                     $('#statusAutoSave').modal('show');
                                     $('#statusAutoSave').delay(5000).queue(function() {
                                         $('#statusAutoSave').modal('hide');
                                     });
                                }
                            }
                });
        }
};

 $.fn.deleteCSitems = function(tr_index,etool_id){
    var el = $(this);
    $.ajax({
                            type: "POST",
                            url: "<?=base_url('sched_record2/sched_cs_record_etools/delete_sched_cs')?>",
                            data : {
                                    etool_id : etool_id,
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