<script type="text/javascript">

	
var div = <?=$div?>;
var final = 0;	

$('#tentative').on('keyup',function(){
	var prelim = 0;
	if(div == 3){
		var prelim = Number($('#prelim').val());
	}
	
		var midterm = Number($('#midterm').val());
		var tentative = Number($('#tentative').val());
		var final = (prelim + midterm + tentative ) / div;
		
		if(tentative <= 99){
			$('#final_grade').val(final.toFixed(2));
		}else{
			$('#tentative').val('');
			swal({
                                  title: 'ERROR TENTATIVE GRADE',
                                  html: '<h4 class="red">GRADE SHOULD BE EQUAL OR LESS THAN 99</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
		}
		
	});


$('#save_grade_completion').click(function(e){
  e.preventDefault()
		$.ajax({
                            type: "POST",
                            url: "<?=base_url('grade_completion/save_registrar_grade_completion_tf')?>",
                            data : $('#save_grade_completion_form').serialize(),
                        dataType: "json",
                        error: function(){
                                swal({
                                  title: 'ERROR SUBMITTING GRADES',
                                  html: '<h4 class="red">PLEASE REFRESH AND TRY AGAIN</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
                        },
                        success: function(data){
                        	swal({
                                  title: data[1],
                                  html: '<h4 class="red">'+ data[2]+'</h4><br />',
                                  timer: 3500,
                                  type: data[0],
                                });
                        }
                });
});

</script>