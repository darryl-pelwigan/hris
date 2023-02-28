<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>

<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/fh-3.1.4/datatables.min.js"></script> -->
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables2.min.js"></script>

<script src="<?=base_url()?>assets/plugins/DataTables/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons-1.5.4/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script> -->
<script type="text/javascript" src="<?=base_url()?>assets/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript">
$.fn.getALL = function(){

    if ( $.fn.dataTable.isDataTable( '.table' ) ) {
      $('.table').dataTable().fnDestroy();
    }

    $(document).ready(function(){
        var table = $('#emp_lists').DataTable({
              "processing": true,
              "serverSide": false,
              "paging" : true,
              "scrollX": true,
              fixedHeader: true,
              fixedColumns: {
                leftColumns: 4
              },
              "initComplete": function(settings,json){
                $(document).on('click', '#sidebarToggle', function() {
                  var display = $('.sidebar').css('display');
                  if (display == 'none') {
                    $('.dataTables_scrollHeadInner').css('cssText', 'width: 100% !important');
                  } else if (display == 'block') {
                    $('.dataTables_scrollHeadInner').css('cssText', 'width: 78% !important');
                  }
                });
 
                $('.dataTables_scrollBody').on('scroll',function(){
                    $('.dataTables_scrollHeadInner').scrollLeft($(this).scrollLeft());
                });
                $(document).on('scroll',function(){
                  var scroll_pos = $(window).scrollTop();
                  var margin = $('.dataTables_scrollHead').offset().top;
                  var header_pos = margin - scroll_pos;
                  if(header_pos < 0)
                    header_pos = 0;
                  $('.dataTables_scrollHeadInner').css({"top" : header_pos});
                });

                // column filters
                this.api().columns([5,6/*,32*/]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"><option></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    // .appendTo('#empListFilter')
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                  column.data().unique().sort().each( function (data) {
                    select.append('<option value="'+data+'">'+data+'</option>');
                  });
                });

                this.api().columns([15]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                  column.data().unique().sort().each( function () {
                    select.empty();
                    select.append('<option></option>');
                    select.append('<option>Non-Teaching</option>');
                    select.append('<option>Teaching</option>');
                  });
                } );

                this.api().columns([9]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                  column.data().unique().sort().each( function () {
                    select.empty();
                    select.append('<option></option>');
                    select.append('<option>Female</option>');
                    select.append('<option>Male</option>');
                  });
                } );

                this.api().columns([10]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(  
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                  column.data().unique().sort().each( function () {
                    select.empty();
                    select.append('<option></option>');
                    select.append('<option>Married</option>');
                    select.append('<option>Single</option>');
                    select.append('<option>Divorced</option>');
                  });
                } );

                this.api().columns([17]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                  column.data().unique().sort().each( function () {
                    select.empty();
                    select.append('<option></option>');
                    select.append('<option>Contractual</option>');
                    select.append('<option>Fixed Term</option>');
                    select.append('<option>Regular</option>');
                    select.append('<option>Probationary</option>');
                  });
                } );

                this.api().columns([18]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                  column.data().unique().sort().each( function () {
                    select.empty();
                    select.append('<option></option>');
                    select.append('<option>Full-Time</option>');
                    select.append('<option>Part-Time</option>');
                  });
                } );

                this.api().columns([32]).every( function () {
                  var column = this;
                  var select = $('<select class="form-control" id="colFilter"></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ? '^'+val : '', true, false )
                            .draw();
                    } );

                  var data = column.data().unique().sort();
                  var length = column.data().unique().length;
                  var finArr = [];

                  for (var i = 0; i < length; i++) {
                    for (var j = 1; j < length; j++) {
                      if (data[i] != null && data[i] != "" && data[j] != null && data[j] != "") {
                        if (data[i].toUpperCase() == data[j].toUpperCase()) {
                          // finArr.push(data[i].toLowerCase()); // duplicates only..
                          data.splice(j,1);
                        }
                      }
                    }
                  }

                  select.empty();
                  for (var i = 0; i < length; i++) {
                    if (data[i] != null && data[i] != null) {
                      select.append('<option>'+data[i].toLowerCase()+'</option>');
                    }
                  }
                });
                // end column filters
                $(document).on('mouseover', '#emp_lists', function() {
                  var tHeight = $('.DTFC_LeftBodyWrapper .DTFC_LeftBodyLiner table').css('height');
                  $('.DTFC_LeftBodyWrapper').css('cssText', 'height: '+tHeight+' !important');
                  $('.DTFC_LeftBodyLiner').css('cssText', 'height: '+tHeight+' !important');
                });            
                
                $(document).on('change', '#colFilter', function() {
                  var tHeight = $('.DTFC_LeftBodyWrapper .DTFC_LeftBodyLiner table').css('height');
                  $('.DTFC_LeftBodyWrapper').css('cssText', 'height: '+tHeight+' !important');
                  $('.DTFC_LeftBodyLiner').css('cssText', 'height: '+tHeight+' !important');
                });
            },
              dom: 'Bfrtip',
              "buttons": [
                {
                  extend: 'colvis',
                  postfixButtons: ['colvisRestore'],
                  collectionLayout: 'fixed four-column',
                }
              ],
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_emp_lists",
              },
              "columns": [
                  { data: null,
                    render: function(data, type){
                      return "<a id='change_inactive' href='<?php echo base_url('hr/employees/update_status_inactive/" + data.fileno + "'); ?>' class='btn btn-danger btn-sm'>Inactive</a>";  
                    }
                  },
                  // { data: "biometrics"},
                  { data: "lastname" }, // color or bold line (right)
                  { data: "firstname" }, // color or bold line (right)
                  { data: "middlename"}, // color or bold line (right)
                  { data: "fileno"},
                  { data: "position" },
                  { data: "department" },
                  { data: null, render: function(data, type, dataToSet) {
                    var dat = '';
                     if (data.birthdate == '30 November -0001') {
                        dat = '';
                     } else {
                        dat = data.birthdate;
                     }
                     return dat;
                    }
                  },
                  { data: "age"},
                  { data: "sex"},
                  { data: "civil_status"},
                  { data: "religion"},
                  { data: "date_employ"},
                  { data: "yrs_service"},
                  { data: null, render: function(data, type, dataToSet) {
                    var dat = '';
                     if (data.end_contract == '1 January 1970') {
                        dat = '';
                     } else {
                        dat = data.end_contract;
                     }
                     return dat;
                    }
                  },
                  
                  { data: null, render: function(data, type, dataToSet) {
                      return ((data.teaching == 1) ? 'Teaching' : 'Non-teaching');
                    }
                  },
                  { data: "union"},
                  { data: "employment_status"},
                  { data: "nature_employment"},
                  { data: "home_address"},
                  { data: "prov_address"},
                  { data: "email_address"},
                  { data: "contact"},
                  { data: "w_dependents"},
                  { data: "tin"},
                  { data: "sss"},
                  { data: "love"},
                  { data: "health"},
                  { data: "peraa"},
                  { data: "person_emergency"},
                  { data: "address_emergency"},
                  { data: "emergency_contact"},
                  { data: "relationship"},
                  { data: "highest_educ"},
                  { data: "eligibilities"},
              ],
              "order": [[ 1, "asc" ]],
            });

        var table_inactive = $('#emp_lists_inactive').DataTable({
              "processing": true,
              "serverSide": false,
              // "stateSave": true,
              fixedHeader: true,
              "initComplete": function(settings,json){ //////////////
 
                $('.dataTables_scrollBody').on('scroll',function(){
                    $('.dataTables_scrollHeadInner').scrollLeft($(this).scrollLeft());
                });
                $(document).on('scroll',function(){
                  // var scroll_pos = $(this).scrollTop();
                  var scroll_pos = $(window).scrollTop();
                  var margin = $('.dataTables_scrollHead').offset().top;
                  // var margin = $('#emp_lists').offset().top;
                  var header_pos = margin - scroll_pos;
                  // console.log(header_pos);
                  // var cur_pos = $('.dataTables_scrollHeadInner').position();
                  // var header_pos = cur_pos.top;
                  // scroll_pos < margin
                  // scroll_pos > margin
                  if(header_pos < 0)
                    header_pos = 0;
                  // else
                  //   header_pos = $('.dataTables_scrollHeadInner').offset().top - scroll_pos;
                    // var header_pos = margin - scroll_pos;
                  // else
                  //   header_pos = 0;

                  $('.dataTables_scrollHeadInner').css({"top" : header_pos});
                });
            }, ////////////
              "paging" : true,
              "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_emp_lists_inactive",
              },
              dom: 'Bfrtip',
              buttons: [
                {
                  extend: 'colvis',
                  postfixButtons: ['colvisRestore'],
                }
              ],
              "columns": [
                { "data": null,
                      render: function(data, type){
                        return "<a id='change_active' href='<?php echo base_url('hr/employees/update_status_active/" + data.fileno + "'); ?>' class='btn btn-success btn-sm'>Active</a>";
                      }
                  },
                { "data": "biometrics"},
                { "data": "fileno" },
                { "data": "name" },
                { "data": "position"},
                { "data": "dept_name" },
                { "data": "dateofemploy" },
                { "data": "yearsofservice"},
                { "data": "teaching" },
                { "data": "separation" }
              ]
        });
        
    

        var position = $('#employee-position-list').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              // "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_emp_position_lists",
              },
              "columns": [
                    { "data": "position"},
                    { "data": "position_category"},
                    { data: null, render: function(data, type, full) {
                         return '<center>\
                                    <a type="button" onclick="$(this).view_edit_position('+data.id+');" class="btn btn-success btn-xs showInfo" target="_blank" > Edit </a>\
                                    <a type="button" onclick="$(this).delete_position('+data.id+');" class="btn btn-danger btn-xs showInfo" target="_blank" > Delete </a>\
                                </center>';
                    },
                    "searchable": false 
                  },
              ]
        });

        var position = $('#holidayTables').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              // "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hris/employees/get_list_holidays",
              },
              "columns": [
                    { "data": "date"},
                    { "data" : "description"},
              ]
        });

        var yearsOfService = $('#years_of_service').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              // "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/employees/get_emp_lists",
              },
              "columns": [
                  { "data": "biometrics"},
                  { "data": "teaching"},
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "dept_name" },
                  { "data": "dateofemploy" },
                  // { "data": "yearsofservice"},
                  // { "data": "teaching" },
              ]
        });

        var leave_credits_log = $('#service_leave_credits_log').DataTable({
              "processing": true,
              "serverSide": false,
              "stateSave": true,
              "paging" : true,
              // "scrollX": true,
              ajax:{
                "type": 'POST',
                "url" : "hr/datatables/get_service_log_dt",
              },
              "columns": [
                  { "data": "fileno" },
                  { "data": "name" },
                  { "data": "position"},
                  { "data": "department" },
                  { "data": "leave_credits" },
                  { "data": "date_added" },
                  // { "data": "yearsofservice"},
                  // { "data": "teaching" },
              ]
        });
   
        var lastIdx = null;
        $('#emp_lists tbody').on('mouseover', 'td', function() {
            var colIdx = table.cell(this).index().column;
            if (colIdx !== lastIdx) {
                $(table.cells().nodes()).removeClass('highlight');
                $(table.column(colIdx).nodes()).addClass('highlight');
            }
            }).on('mouseleave', function() {
                $(table.cells().nodes()).removeClass('highlight');
            }).on('click','tr',function(){
                var id =table.row(this).data();
                document.location.href = "employees/" + id.fileno;
                // window.open("employees/" + id.fileno, '_blank');
          });

        $('#emp_lists_inactive tbody').on('mouseover', 'td', function() {
            var colIdx = table_inactive.cell(this).index().column;
            if (colIdx !== lastIdx) {
                $(table_inactive.cells().nodes()).removeClass('highlight');
                $(table_inactive.column(colIdx).nodes()).addClass('highlight');
            }
            }).on('mouseleave', function() {
                $(table_inactive.cells().nodes()).removeClass('highlight');

            }).on('click','tr',function(){
                var id =table_inactive.row(this).data();
                document.location.href = "employees/" + id.fileno;
        }); 
    });


    $(document).ready(function(){
      var table = $('#employee-years_of_service').DataTable({
            "processing": true,
            "serverSide": false,
            "stateSave": true,
            "paging" : true,
            "scrollX": true,
            ajax:{
              "type": 'POST',
              "url" : "hr/datatables/get_emp_lists",
            },
            "columns": [
                { "data": "fileno" },
                { "data": "lastname" },
                { "data": "position"},
                { "data": "department" },
                { "data": "employment_status" },
                { "data": "date_employ" },
                { "data": "yrs_service"},
                 { data: null, render: function(data, type, full) {
                     return (data.teaching == 1 ? 'Teaching' : 'Non-teaching')
                  }
                },
                { data: null, render: function(data, type, full) {
                     return '<center>\
                                <a type="button" onclick="$(this).view_years_of_service(`'+data.fileno+'`);" class="btn btn-success btn-xs"> View </a>\
                            </center>';
                  }
                },
            ],
            "columnDefs": [
            {
                "targets": [ 6 ],
                "visible": true,
                "searchable": true
            }
        ]
      });

      $('#changeClassification').on('change',function(){
        table.columns( 6 ).search( this.value ).draw();
      });
    });
};

$.fn.view_edit_position = function(id){
  $('#edit_position').modal('show');
  $.ajax({
    type: 'POST',
    url: '<?php echo base_url() ?>hr/employees/get_position_details',
    dataType: 'json',
    cache: false,
    data: "id=" + id,
    success: function(result) {
      console.log(result);
      $('#position_id').val(result.id);
      $('#position_name').val(result.position);
      document.getElementById('position_category').value=result.position_category;

    }
  });

}

$.fn.delete_position = function(id){
  message = confirm('Are you sure you want to delete this Position?');
  if (message == true) {
    $(this).closest('tr').remove();
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url() ?>hr/employees/delete_position_details',
      dataType: 'json',
      cache: false,
      data: "id=" + id,
      success: function(result) {

      }
    });
  }
}

$(document).on('click', '#change_inactive', function(e) {
  e.preventDefault();
  confirm("Change user status to inactive?");
  if (confirm) {
    alert("Successfully changed user status");
    window.location = $(this).attr('href');
  }
});

$(document).on('click', '#change_active', function(e) {
  e.preventDefault();
  confirm("Change user status to active?");
  if (confirm) {
    alert("Successfully changed user status");
    window.location = $(this).attr('href');
  }
});

$.fn.getALL();

</script>