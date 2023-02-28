<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript" src="<?=ROOT_URL?>js/jquery.timepicker.js"></script> -->
<script type="text/javascript" src="<?=ROOT_URL?>/modules/assets/functions/js/auto_save_hr_edi.js"></script>

<script type="text/javascript">

$.fn.getALL = function(){

    if ( $.fn.dataTable.isDataTable( '#example' ) ) {
      $('#example').dataTable().fnDestroy();
    }


    $('.datepicker').datepicker();

    $(document).ready(function(){

      // for Non-teaching Employee
      $.ajax({ 
          url:"<?php echo base_url(); ?>payroll/payroll/get_cutoff_period",  
          method:"POST",  
          cache: false,
          dataType: 'json',
          success:function(data){

            for (var i = 0; i < data.length; i++) {
              $('#first_cut_from_'+i).val(data[i].first_cut_from);
              $('#first_cut_to_'+i).val(data[i].first_cut_to);
              $('#second_cut_from_'+i).val(data[i].second_cut_from);
              $('#second_cut_to_'+i).val(data[i].second_cut_to);

            }


          }
        }); 

      // for Teaching Employee
      $.ajax({ 
          url:"<?php echo base_url(); ?>payroll/payroll/get_cutoff_period_teaching",  
          method:"POST",  
          cache: false,
          dataType: 'json',
          success:function(data){

            for (var i = 0; i < data.length; i++) {
              $('#t_first_cut_from_'+i).val(data[i].first_cut_from);
              $('#t_first_cut_to_'+i).val(data[i].first_cut_to);
              $('#t_second_cut_from_'+i).val(data[i].second_cut_from);
              $('#t_second_cut_to_'+i).val(data[i].second_cut_to);

            }


          }
        }); 

    });


    $(document).ready(function(){
        $.fn.deletecutoff = function(cutoff_id) {
          if (confirm("Are You Sure You want To delete this cutoff?") ==  true){
            var el = this;  
              $.ajax({  
                url:"<?php echo base_url(); ?>payroll/payroll/delete_cutoff_period",  
                method:"POST",  
                cache: false,
                data : 'cutoff_id=' + cutoff_id, 
                success:function(data)  
                 {  
                   $(el).closest('tr').css('background','tomato');
                    $(el).closest('tr').fadeOut(800, function(){ 
                      $(this).remove();
                      alert('Successfully Deleted Leave Requests');
                    });

                  }
              });  
          }
        } 
    });


        var table = $('.tbl_emp_deductions').DataTable();

        $('.tbl_payroll').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              ajax:{
                "type": 'POST',
                "url" : "<?php echo base_url() ?>payroll/payroll/get_emp_payroll",
                "dataType": 'JSON',
                data : {
                    "fdate" : '2018-06-01',
                    "tdate" : '2018-06-15',
                }
              },
              "columns": [
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "emp_status" },
                  { "data": null,
                      render: function(data){
                        if (data.teaching == 0){
                          return 'Non-Teaching';
                        } else {
                          return 'Teaching'
                        }
                      }
                  },
                  { "data": "salary" },
                  // { "data": "date" },
                  // { "data": "regularhours"},
                  // { "data": "totalhours" },
                  // { "data": "tardiness" },
                  // { "data": "overtime" },
                  // { "data": "undertime" },
                  { "data": null,
                    render: function(data, type, row){
                      return '<center>\
                                <a class="btn btn-success btn-xs" type="button" onclick="$(this).showdialogbox(\''+data.fileno+'\')" date-attendance="'+data.date+'"><i class="glyphicon glyphicon-check"></i> View</a>\
                              </center>';
                    
                    }, orderable: false, searchable: false
                  },
              ]
        });
      
    // });
};


$.fn.getALL();
      $("#tbl_emp_deductions").on('click', '.delete_deduction', function(){
          var currentRow=$(this).closest("tr"); 
          var fileno= currentRow.find("td:eq(0)").text();
          var message = confirm("Are you sure you want to delete this record?");
          if (message == true) {
            var el = this;
            $.ajax({
              type: 'POST',
              url:"<?php echo base_url(); ?>payroll/payroll/delete_deduction_allowance",  
              dataType: 'json',
              data : 'fileno=' + fileno, 
              success: function(result) {
                $(el).closest('tr').css('background','tomato');
                  $(el).closest('tr').fadeOut(800, function(){ 
                    $(this).remove();
                    alert('Successfully Deleted Records');
                  });
              }

            });

          }
          
      });


      function edit_deduction_function(fileno){

        $(".check_box").prop("checked", false);
        $('.data_value').val();

        $('#edit_deduction_modal').modal('show');


        document.getElementById('edit_fileno').value = fileno;

          $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>payroll/payroll/view_deduction_allowance',
            dataType: 'JSON',
            cache: false,
            data: 'fileno=' + fileno,
            success: function(result){
              var value = result[0].data_deduction;
              for (var i = 0; i < result.length; i++) {

                if (value.indexOf(result[i].deduction_id) != -1) {

                  $('#deduction_id'+result[i].deduction_id).prop("checked", true);
                  $('#first_cut'+result[i].deduction_id).val(result[i].first_cutoff);
                  $('#second_cut'+result[i].deduction_id).val(result[i].second_cutoff);

                } else {

                  $('#deduction_id'+result[i].deduction_id).prop("checked", false);
                  $('#first_cut'+result[i].deduction_id).val(" ");
                  $('#second_cut'+result[i].deduction_id).val(" ");

                }

              }
            }

          });        
      }

      function add_key_function(id){
         var length = $('#add_second_cut'+id).val().length;
         if (length === 0) {
          $('#add_second_cut'+id).val("0.00");
         }

      }

      function keyup_function(id){
        if ($('#second_cut'+id).val().length === 0) {
          $('#second_cut'+id).val("0.00");
        }

      }

      function add_second_cut_key_function(id){
        var length = $('#add_first_cut'+id).val().length;
        if (length === 0) {
          $('#add_first_cut'+id).val("0.00");
         }
        
      }

      function second_cut_key_function(id){
        var length = $('#first_cut'+id).val().length;
        if (length === 0) {
          $('#first_cut'+id).val("0.00");
         }
        
      }

  $.fn.showdialogbox = function(fileno){

    var id = fileno;
    window.open('<?=base_url('payroll/salary/view_salary_computaion')?>/'+id, "_blank");
  }



</script>