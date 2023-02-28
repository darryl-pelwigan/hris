<script src="<?=base_url()?>assets/plugins/DataTablesN/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTablesN/DataTables-1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/functions/js/subject-grades-search.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
SEM = '<?=$set_sem?>';
SY = '<?=$set_sy?>';



     $(document).ready(function(){
        $.fn.showEnrolleesonSubject = function(schedid ){
            $('#enrollListModalSubject .modal-body').html('');
           $.ajax({
                       type: "POST",
                       url: "subject_grades",
                       data : {
                                schedid : schedid,
                                sem : SEM,
                                sy : SY
                        },
                        dataType: "html",
                        error: function(){
                            alert('error');
                        },
                        success: function(data){
                            $('#enrollListModalSubject').modal('show');
                            $('#enrollListModalSubject .modal-body').html(data);
                        }
                });
            return false;
        };
});


$.fn.loadTable = function(){
  if ( $.fn.DataTable.isDataTable('#student_view_list') ) {
     $('#student_view_list').DataTable().destroy();
    }

    var semxx =  $('#set_sem').val();
    var syxx =  $('#set_sy').val();

    $('#student_view_list').dataTable({
        dom: '<"dt-custom">frtip',
        processing: true,
        serverSide: false,
        ajax: { 'url' : APP_PATH +'student_grades/student_faculty_grades/set_se_tbody',
                type: 'POST',
                data:{
                    'sem' :semxx,
                    'sy' : syxx,
                    'course' : $('#course').val(),
                    'year' : $('#year_level').val(),
                },
                
            },
        columns: [
            { data: 
                    function(data){
                        return '<img style="width:100px; height: 100px;" src="'+APP_PATH+'assets/student_id/'+data.studid+'.JPG" />';
                }
            },
            { data: 'studid', name: 'studid' },
            { data: 'firstname', name: 'firstname' },
            { data: 'middlename', name: 'middlename' },
            { data: 'lastname', name: 'lastname' },
            { data:
                function(data){

                    var formx = '<form class="form-inline" target="_blank" method="post" action="'+APP_PATH+'student_grades/student_faculty_grades/student_grade" >'+
                                ' <div class="form-group">'+
                                '<input type="hidden" name="student_id" value="'+data.studid+'" />'+
                                '<input type="hidden" name="sem" value="'+semxx+'" />'+
                                '<input type="hidden" name="sy" value="'+syxx+'" />'+
                                '<button type="submit" class="btn btn-sm btn-info" > view </button> '+
                                '</div>'+
                                '</form> '+
                                '<form class="form-inline" method="post" action="'+APP_PATH+'student_grades/student_faculty_grades/student_grade_all" >'+
                                ' <div class="form-group">'+
                                '<input type="hidden" name="student_id" value="'+data.studid+'" />'+
                                '<button type="submit" class="btn btn-sm btn-success" > view all</button> '+
                                '</div>'+
                                '</form>';
                        return formx;
                }
            ,
                bSortable: false,
                searchable: false,
            },
        ],
        order : [[ 0, "asc" ]]
    });
 };
$.fn.loadTable();


   (function($) {

    $.fn.dataTableSearch = function(delay) {
        //console.log("data table search plugin...");

        var dt = this;

        this.find("thead input").on( 'keyup', function (event) {


            getInput = function() {
                return $(event.target);
            };

            $z.delay(delay, function() {
                var td = getInput().closest("td");
                var index = td.index();
                console.log("index is " + parseInt(index));
                dt.DataTable()
                    .columns(index)
                    .search(getInput().val())
                    .draw();
            });


        });


        return this;

    };


    function delay(){
      var timer = 0;
      return function(ms, callback){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    };

})(jQuery);


var $z = (function($z) {

    //empty object to assign custom functions / properties to
    $z.fn = {};

    //set a timeout delay that clears itself if it fires in succession before the timeout
    //is reached.  Useful when
    $z.delay = (function(){
      var timer = 0;
      return function(ms, callback){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();


    //handles the security for ajax calls
    $z.ajax = function(jQueryOpts) {
        //store the success function specified on the call
        var userSuccess = jQueryOpts.hasOwnProperty("success") === false ?
            function(){}  :
                jQueryOpts.success;

        //replace the success function
        jQueryOpts.success = function(data, status, xhr) {
            //TODO check the header to make sure we did not get denied access or were not
            //logged in

            userSuccess(data, status, xhr);
        };



        return jQuery.ajax(jQueryOpts);
    };

    $z.select2Init = function(element, callback) {
        var val = element.val().split("|");
        if (val.length === 2) {
            callback({
                id: val[0],
                text: val[1]
           });
        }


    };

    $z.setToggle = function(eles) {
        $z._toggleEles = eles;
    };

    $z.toggle = function() {
        if($z._toggleEles !== undefined) {
            $z._toggleEles.slideToggle(300, "swing");
        }
    };


    return $z;

})(window.$z || {});
</script>