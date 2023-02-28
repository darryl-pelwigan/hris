<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

$.fn.getALL = function(){

    if ( $.fn.dataTable.isDataTable( '.table' ) ) {
      $('.table').dataTable().fnDestroy();
    }

  $(document).ready(function(){
        var position = $('#holidayTables').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              ajax:{
                "type": 'POST',
                "url" : "<?php echo base_url();?>hr/datatables/get_list_holidays",
              },
              "columns": [
                    { "data": "date"},
                    { "data": "day_of_week"},
                    { "data" : "description"},
                    { "data" : "type"},
                    { data: null, render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).viewholiday('+data.holiday_id+');" class="btn btn-success btn-xs showInfo" target="_blank" > Edit </a>\
                                    <a type="button" onclick="$(this).deleteholiday('+data.holiday_id+');" class="btn btn-danger btn-xs showInfo" target="_blank" > Delete </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
              ],
        });
 
    });
};

$.fn.getALL();

$.fn.viewholiday = function(holiday_id)
  {
      $('#editholi').modal('show');
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url();?>hr/datatables/get_list_holidays',
          dataType: 'json',
          cache: false,
          data : 'holiday_id=' + holiday_id,
          success: function(result) {
              console.log(result);
              var holiday = result.data[0].date.split(' ');
              var month = holiday[0];
              var date = holiday[1];
              $('.update_holiday #holiday_id').val(result.data[0].holiday_id);
              $('.update_holiday #month').val(month);
              $('.update_holiday #month_date').val(date);
              $('.update_holiday #description').val(result.data[0].description);
              $('.update_holiday #holiday_type').val(result.data[0].type);
          }
      });
  }

$(document).ready(function(){
  $.fn.deleteholiday = function(holiday_id) {
    if (confirm("Are You Sure You want To delete This Records?") ==  true){
      var el = this;  
        $.ajax({  
          url:"<?php echo base_url();?>hr/holidays/delete_holiday",  
          method:"POST",  
          dataType: "json",
          cache: false,
          data : 'holiday_id=' + holiday_id, 
          success:function(data)  
           {  
             $(el).closest('tr').css('background','tomato');
              $(el).closest('tr').fadeOut(800, function(){ 
                $(this).remove();
              });
            }
        });  
    }
  } 
});

</script>