<script type="text/javascript">


var final = 0;

$('#tentative').on('change',function(){
    var tentative = Number($('#tentative').val());
    var final_ramarks = $('#final_ramarks > option');
		var final = ( tentative );
		if(tentative <= 99){
      if(tentative > 75 ){
        final_ramarks.eq(1).attr('selected','selected');
        final_ramarks.eq(2).attr('disabled',true);
        final = Math.round(final);
      }else{
        final_ramarks.eq(2).attr('selected','selected');
        final_ramarks.eq(2).attr('disabled',false);

        final = final.toFixed(2);
      }

      $('#final_grade').val(final);

		}else{
			$('#tentative').val('');
      $('#final_grade').val('');
			swal({
                                  title: 'ERROR TENTATIVE GRADE',
                                  html: '<h4 class="red">GRADE SHOULD BE EQUAL OR LESS THAN 99</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
		}

	});

$('#final_ramarks').on('change',function(){
  var tentative = Number($('#tentative').val());
  var el = $(this);
  var final = ( tentative );
  if(el.val() == 'Passed'){
     final = Math.round(final);
  }else{
    final = final.toFixed(2);
    var finalx = (final + "").split('.');

    if( Math.round(final) >= 75 ){
        finalx = 74;
    }else{
        finalx = Math.round(final);
    }
    final = finalx;
  }

  $('#final_grade').val(final);


});

$('#save_grade_completion').click(function(){
		$.ajax({
                            type: "POST",
                            url: "<?=base_url('grade_completion/save_grade_completion_tf')?>",
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
                                  // timer: 3500,
                                  type: data[0],
                                }).then(function( text ) {
                                  location.reload();
                                });
                        }
                });
});

</script>