<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>js/jquery.timepicker.js"></script>
<script type="text/javascript" src="<?=ROOT_URL?>/modules/assets/functions/js/auto_save_hr_edi.js"></script>

<script type="text/javascript">

$.fn.getALL = function(){

    if ( $.fn.dataTable.isDataTable( '#example' ) ) {
      $('#example').dataTable().fnDestroy();
    }

   
};

$.fn.getALL();

$(document).on('click','.edit',function(){
    $table = $(this).closest("tr");

    $('input[name=update_description]').val($table.find("td").eq(0).text());
    $('#update_types option:contains('+$table.find("td").eq(1).text()+')').prop('selected',true);
    $('input[name=update_amount]').val($table.find("td").eq(2).text());

    update_deduction.action = '<?=base_url('payroll/update_deductions')?>/'+$(this).attr('id');

    return false;
  });

$(document).on('click','.delete',function(){

   var ask = window.confirm("Are you sure you want to delete this deduction/allowance?");
    if (ask) {
    	var ask = window.confirm("Please confirm to delete this record?");
    	if(ask){
    		window.location.href = '<?=base_url('payroll/delete_deductions')?>/'+$(this).attr('id');
    	}
    }
  });
</script>