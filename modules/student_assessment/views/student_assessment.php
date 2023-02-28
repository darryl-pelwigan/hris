<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example2" id="dataTables-example2" width="100%">
                                    <thead>
                                            	<tr>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td><input type="text" /></td>
                                                    <td></td>
                                                </tr>

                                        <tr>
                                            <th>ID No</th>
                                            <th>Last Name</th>
                                            <th>Given Name</th>
                                            <th>Middle Name</th>
                                            <th>Course</th>
                                            <th>Date Admitted</th>
                                            <th>Student Type</th>
                                            <th>Assessment</th>
                                            <th>Payment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?=($table)?>
                                    </tbody>

                                </table>
                            </div><!-- /.table-responsive -->
     <!-- Core Scripts - Include with every page -->

 <script >
    $(document).ready(function() {
        $('.dataTables-example2').dataTable().dataTableSearch();
    });

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
		 		// console.log("index is " + parseInt(index));
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
