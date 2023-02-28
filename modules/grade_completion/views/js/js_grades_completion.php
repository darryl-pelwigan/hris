<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	
	 $(document).ready(function(){
        var table = $('#grade_list_completion').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              // "scrollX": true,
              ajax:{
                "type": 'POST',
                "data":{
                	"sched_id": "<?php echo $_SESSION['sched_id']?>"
                },
                "url" : "grade_completion/grade_completion/final_grades_dt",
              },
              "columns": [
                    { "data": "full_name"},
                    { "data": "student_id"},
                    { "data": "full_name"},
                    { "data" : "tentativefinal"},
                    { data: null, render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" href="grade_completion/complete_grade_form/'+data.student_id+'" class="btn btn-success btn-xs showInfo" target="_blank" > Compute Final </a>\
                                    <a type="button" class="btn btn-primary btn-xs showInfo" target="_blank" > Generate Report </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
              ],
              "columnDefs": [ {
	            "searchable": false,
	            "orderable": false,
	            "targets": 0
	         } ],

        });
 		
         table.on( 'order.dt search.dt', function () {
	        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        } );
	    } ).draw();

    });

</script>