<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

$.fn.get_attendance = function(fdate, tdate){

     $(document).ready(function(){
        $('.emp_timekeeping_tbl').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_emp_timekeeping",
                data : {
                    "fdate" : fdate,
                    "tdate" : tdate,
                }
              },
              "columns": [
                  { "data": "biometrics"},
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department" },
                  { "data": "datetime" },
                  { "data": "status"},
                  { "data": "verifycode" },
                  { "data": "location" },
              ]
        });

    });
};



$.fn.viewattendance = function(){
    $('.emp_timekeeping_tbl').DataTable().destroy();
	var fdate = $('#datefrom').val();
	var tdate = $('#dateto').val();
	$.fn.get_attendance(fdate, tdate);
}

$.fn.get_attendance(fdate='', tdate='');

$('.datepicker').datepicker();


</script>
