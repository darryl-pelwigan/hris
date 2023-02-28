<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.timepicker.min.js"></script>

<script type="text/javascript">
	$(document).on('click', '#allDays', function(){
        var check = this.checked;
        $('.checks:enabled').prop('checked', check);
        $('#addSched').prop('disabled', !check);
    });

    $('.timepicker').timepicker({
        'timeFormat' : 'h:i A'
    });

    function getTotalHours(){

        var in_am = $("#timein_am").val();
        var out_am = $("#timeout_am").val();
        var in_pm = $("#timein_pm").val();
        var out_pm = $("#timeout_pm").val();

        var date = new Date();
        var month = date.getMonth();
        var day = date.getDate();
        var year = date.getFullYear();


        var fullfrom_timein_am = month + '/'+ day + '/'+year + ' '+in_am;
        var fullfrom_timeout_am = month + '/'+ day + '/'+year + ' '+out_am;
        var fullto_timein_pm = month + '/'+ day + '/'+year + ' '+in_pm;
        var fullto_timeout_pm = month + '/'+ day + '/'+year + ' '+out_pm;

        var time1 = new Date(fullfrom_timein_am);
        var time3 = new Date(fullfrom_timeout_am);
        var time2 = new Date(fullto_timein_pm);
        var time4 = new Date(fullto_timeout_pm);


        var numhours = (Math.abs(time3 - time1) / 36e5) + (Math.abs(time4 - time2) / 36e5);
        var hours = (parseInt((time3 - time1) / 36e5)) + (parseInt((time4 - time2) / 36e5));       

        if(numhours >= 5){
            numhours = numhours - 1;
        }

        var minutes = Math.abs((numhours*60)-(hours*60));
        var mins = '00';
        if(minutes < 60)
        {
            mins = minutes;
        }


        $("#totalhours").val(hours+':'+mins);
    }


    $(document).ready(function() {
    	function loadSchedTable(classify){

    		$('#tablesched').DataTable().destroy();
    		if(classify == 1){
    			var url = "<?php echo base_url(); ?>hr/scheduling/get_list_staff_schedule_teaching";
    		}else{
    			var url = "<?php echo base_url(); ?>hr/scheduling/get_staff_scheduling_lists";
    		}

    		var table = $('#tablesched').DataTable({
	    	    "order":[2,"asc"],
	            "processing": true,
	            "serverSide": false,
	            "deferRender": true,
	            "bFilter" : true,
	            ajax:{
	                "type": 'GET',
	                "url" : url,
	            },
	           	"columns": [
	                  { data: "fileno"},
	                  { data: "lastname" },
	                  { data: "firstname" },
	                  { data: "middlename"},
	                  { data: "department" },
	                  { data:  null,
	                    render : function ( data, type, dataToSet ) {
	                        return ((data.classification == 1) ? 'Teaching' : 'Non-teaching');
	                    }
		                },
	                  { data: "timein_am" },
	                  { data: "timeout_am"},
	                  { data: "timein_pm" },
	                  { data: "timeout_pm"},
	                  { data: "total"},
	                    { data: null,
	                        render : function ( data, type, dataToSet ) {
	                        	if(data.classification == 0){
		                            var days = data.days.split(',');
		                            var val = '';
		                            for (var i = 0; i < days.length; i++) {
		                                switch(days[i]){
		                                    case "1":
		                                        val += 'M, ';
		                                        break;
		                                    case "2":
		                                        val += 'T, ';
		                                        break;
		                                    case "3":
		                                        val += 'W, ';
		                                        break;
		                                    case "4":
		                                        val += 'Th, ';
		                                        break;
		                                    case "5":
		                                        val += 'F, ';
		                                        break;
		                                    case "6":
		                                        val += 'S';
		                                        break;
		                                }

		                            }
		                            return val;
		                        } else {
		                        	var days = data.days;
		                        	return days;
		                        }
	                    }
	                    },
	                    { data: null, 
	                         render : function ( data, type, dataToSet ) {
	                                if(data.classification == 0){
		                         		return '<button class="btn btn-xs btn-success pull-center btn-edit" id="'+data.id+'" rel="'+data.id+'" data-toggle="modal" data-target="#editRecord"><i class="fa fa-edit"></i> </button><a class="btn btn-xs btn-danger pull-center" type="button" target="_blank" id="delete_scheduling" onclick="delete_scheduling('+data.id+')"><i class="fa fa-trash"></i> </a>';

		                         	} else {
		                         		return '<button class="btn btn-xs btn-success pull-center btn-view-sched" id="'+data.fileno+'" rel="'+data.fileno+'"><i class="fa fa-search"></i> </button>';
		                         	}
	                        }
	                    }
	      				
	            ],

	            "columnDefs": [{
	                "targets": [ 10 ],
	                "visible": false,
	                "searchable": true
	            }]
		    });
    	}

    	loadSchedTable(classify = 0);
	    $('#changeClassification').on('change',function(){
	    	if (this.value != 0){
    			loadSchedTable(classify = 1);
	    	} else {
    			loadSchedTable(classify = 0);
	    	}

	    });
	    
    });

    // $(document).ready(function() {
    // 	var table = $('#tablesched').DataTable({
	   //  	    "order":[2,"asc"],
	   //          "processing": true,
	   //          "serverSide": false,
	   //          "deferRender": true,
	   //          "bFilter" : true,
	   //          ajax:{
	   //              "type": 'GET',
	   //              "url" : "<?php echo base_url(); ?>hr/scheduling/get_staff_scheduling_lists",
	   //          },
	   //         	"columns": [
	   //                { data: "fileno"},
	   //                { data: "lastname" },
	   //                { data: "firstname" },
	   //                { data: "middlename"},
	   //                { data: "department" },
	   //                { data:  null,
	   //                  render : function ( data, type, dataToSet ) {
	   //                      return ((data.classification == 1) ? 'Teaching' : 'Non-teaching');
	   //                  }
		  //               },
	   //                { data: "timein_am" },
	   //                { data: "timeout_am"},
	   //                { data: "timein_pm" },
	   //                { data: "timeout_pm"},
	   //                { data: "total"},
	   //                  { data: null,
	   //                      render : function ( data, type, dataToSet ) {
	   //                      	if(data.classification == 0){
		  //                           var days = data.days.split(',');
		  //                           var val = '';
		  //                           for (var i = 0; i < days.length; i++) {
		  //                               switch(days[i]){
		  //                                   case "1":
		  //                                       val += 'M, ';
		  //                                       break;
		  //                                   case "2":
		  //                                       val += 'T, ';
		  //                                       break;
		  //                                   case "3":
		  //                                       val += 'W, ';
		  //                                       break;
		  //                                   case "4":
		  //                                       val += 'Th, ';
		  //                                       break;
		  //                                   case "5":
		  //                                       val += 'F, ';
		  //                                       break;
		  //                                   case "6":
		  //                                       val += 'S';
		  //                                       break;
		  //                               }

		  //                           }
		  //                           return val;
		  //                       } else {
		  //                       	var days = data.days;
		  //                       	return days;
		  //                       }
	   //                  }
	   //                  },
	   //                	{ data: "classification"},
	   //                  { data: null, 
	   //                       render : function ( data, type, dataToSet ) {
	   //                              if(data.classification == 0){
		  //                        		return '<button class="btn btn-xs btn-success pull-center btn-edit" id="'+data.id+'" rel="'+data.id+'" data-toggle="modal" data-target="#editRecord"><i class="fa fa-edit"></i> </button><a class="btn btn-xs btn-danger pull-center" type="button" target="_blank" id="delete_scheduling" onclick="delete_scheduling('+data.id+')"><i class="fa fa-trash"></i> </a>';

		  //                        	} else {
		  //                        		return '<button class="btn btn-xs btn-success pull-center btn-view-sched" id="'+data.fileno+'" rel="'+data.fileno+'"><i class="fa fa-search"></i> </button>';
		  //                        	}
	   //                      }
	   //                  }
	      				
	   //          ],

	   //          "columnDefs": [{
	   //              "targets": [ 12 ],
	   //              "visible": false,
	   //              "searchable": true
	   //          }]
		  //   });


	   //  $('#changeClassification').on('change',function(){
	   //  	table.columns( 10 ).search( this.value ).draw();

	   //  	// alert(this.value);
	   //  	if (this.value != 0){
	   //  		table.ajax.url("<?php echo base_url(); ?>hr/scheduling/get_list_staff_schedule_teaching").load();

	   //  	} else {
	   //  		table.ajax.url("<?php echo base_url(); ?>hr/scheduling/get_staff_scheduling_lists").load();
	   //  	}

	   //  });
    // });

    function updateTotalHours(){

        var from = $("#update_timein").val();
        var to = $("#update_timeout").val();
        var date = new Date();
        var month = date.getMonth();
        var day = date.getDate();
        var year = date.getFullYear();
        var fullfrom_time = month + '/'+ day + '/'+year + ' '+from;
        var fullto_time = month + '/'+ day + '/'+year + ' '+to;
        var time1 = new Date(fullfrom_time);
        var time2 = new Date(fullto_time);

        var numhours = Math.abs(time2 - time1) / 36e5;
        var hours = parseInt((time2 - time1) / 36e5);

        if(numhours >= 5){
            numhours = numhours - 1;
        }
        var minutes = Math.abs((numhours*60)-(hours*60));
        var mins = '00';
        if(minutes < 60)
        {
            mins = minutes;
        }
        $("#update_totalhours").val(hours+':'+mins);
    }


     $(document).on('click', '.btn-edit', function () {

     	$(".check_box").prop("checked", false);
        var fileno = $(this).attr('id');
        $.ajax({
            url: "<?php echo base_url(); ?>hr/scheduling/view_staff_scheduling",
            type: 'post',
            dataType: 'json',
            data: 'fileno='+fileno,
            success: function(data){
                $('#fullname').val(data.fullname);
                $('#schedid').val(data.id);
                $('#update_timein').val(data.timein);
                $('#update_timeout').val(data.timeout);
                $('#update_totalhours').val(data.totalhours);
                var days = data.days.split(',');
                for (var i = 0; i < days.length; i++)
                {
                    $('#day_'+days[i]).prop('checked', 'checked');
                }
            }
        });
    });

    function delete_scheduling(id){
    	var message = confirm("Are you sure you want to delete this record?");
        if (message == true) {
	    	$.ajax({
	            url: "<?php echo base_url(); ?>hr/scheduling/delete_staff_scheduling",
	            type: 'post',
	            dataType: 'json',
	            data: 'id='+id,
	            success: function(data){
	            	$('#tablesched').DataTable().ajax.reload();
	            }

	        });
	    }
     }

     var staff_lists = [];

	    $.ajax({
		    type: 'POST',
		    url: '<?php echo base_url(); ?>hr/scheduling/get_staff_name_lists',
		    dataType: 'json',
		    cache: false,
		    success: function(result) {
		        $.each(result, function(index, value) {
		            staff_lists.push(value['name']);
		        });
		    },
		});

			$('#staff_list').autocomplete({
		    source:
		        function(request, response) {
		            var results = $.ui.autocomplete.filter(staff_lists, request.term);
		            response(results.slice(0, 15));
		        },
		    minLength: 0,
		    scroll: true,
		    autoFocus:true,
		    select: function(event, ui) {
		    	var biono = ui.item.label.match(/\(([^)]+)\)/)[1];
		    	$('#biomentric_selected').val(biono);
		    },

		}).focus(function(req,response) {
		    $(this).autocomplete("search", "");
		});


	
    $('#classify').on('change',function(){
    	var staff_lists = [];

    	if (this.value == 0) {
    		$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url(); ?>hr/scheduling/get_staff_non_teaching_lists',
			    dataType: 'json',
			    cache: false,
			    success: function(result) {
			        $.each(result, function(index, value) {
			            staff_lists.push(value['name']);
			        });
			    },
			});
    	} else if (this.value == 1) {
    		 $.ajax({
			    type: 'POST',
			    url: '<?php echo base_url(); ?>hr/scheduling/get_staff_teaching_lists',
			    dataType: 'json',
			    cache: false,
			    success: function(result) {
			        $.each(result, function(index, value) {
			            staff_lists.push(value['name']);
			        });
			    },
			});
    	} else {
	    	$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url(); ?>hr/scheduling/get_staff_name_lists',
			    dataType: 'json',
			    cache: false,
			    success: function(result) {
			        $.each(result, function(index, value) {
			            staff_lists.push(value['name']);
			        });
			    },
			});
    	}

		$('#staff_list').autocomplete({
		    source:
		        function(request, response) {
		            var results = $.ui.autocomplete.filter(staff_lists, request.term);
		            response(results.slice(0, 15));
		        },
		    minLength: 0,
		    scroll: true,
		    autoFocus:true,
		    select: function(event, ui) {
		    	var biono = ui.item.label.match(/\(([^)]+)\)/)[1];
		    	$('#biomentric_selected').val(biono);
		    },

		}).focus(function(req,response) {
		    $(this).autocomplete("search", "");
		});



	});

	$(document).on('click', '.btn-view-sched', function () {
		$('#tbl-view-sched').find('tbody').empty();
		
		$('#viewSched').modal('show');
		var fileno = $(this).attr('id');     
        $.ajax({
            url: '<?php echo base_url() ?>hr/scheduling/view_staff_teaching_sched',
            type: 'post',
            dataType: 'json',
            data: 'fileno='+fileno,
            success: function(data){
                $('#fullname_teaching').val(data[0].name);

                console.log(data);

                var val = '';
                for (var i = 0; i < data.length; i++){
                    val += '<tr>\
                        <td>'+data[i].days+'</td>\
                        <td>'+data[i].start+' - '+data[i].end+'</td>\
                        <td>'+data[i].courseno +'</td>\
                        <td>'+data[i].course +' - '+data[i].yearlvl +'</td>\
                        <td style="text-align: center">'+data[i].hours_week+'</td>\
                        <td>'+data[i].room +'</td>\
                        <td style="text-align: center">'+data[i].number_of_students +'</td>\
                        <td style="text-align: center">'+data[i].total_hours+'</td>\
                    </tr>';
                }
                
                $('#tbl-view-sched tbody').append(val);
            }
        });


    });


</script>