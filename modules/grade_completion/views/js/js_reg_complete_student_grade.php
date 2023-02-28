<script type="text/javascript">

	
var div = <?=$div?>;
var final = 0;	
var lec_p = 1;
var lab_p = 1;

<?php if($leclab): ?>
 lec_p = 0.6;
 lab_p = 0.4;
<?php endif; ?>
$.fn.lecGrade = function(){
	$('#lec_cs , #lec_exam').on('keyup change',function(){
		var lec_total = (Number($('#lec_cs').val()) + Number($('#lec_exam').val()))/2;
		lec_total = Number(lec_total );
		var lec_total_p = Number(lec_total * lec_p );
		$('#lec_total').val((lec_total.toFixed(2)));
		$('#tfinal_lec_total').val((lec_total_p.toFixed(2)));
		$('.tfinal_grade').val((lec_total.toFixed(2)));
		$.fn.finalGrade();
	});



};	

$.fn.leclabGrade = function(){
	$.fn.lecGrade();
	$('#lab_cs , #lab_exam').on('keyup change',function(){
		var lab_total = (Number($('#lab_cs').val()) + Number($('#lab_exam').val()))/2
		
		var lec_total = $('#lec_total').val();
		lec_total = Number(lec_total );
		lab_total = Number(lab_total );
		var lec_total_p = Number(lec_total * lec_p );
		var lab_total_p = Number(lec_total *lab_p );
		$('#lab_total').val(lab_total.toFixed(2));
		var tfinal_grade = Number(lec_total_p+lab_total_p);
		
		$('#tfinal_lec_total').val(lec_total_p.toFixed(2));
		$('#tfinal_lab_total').val(lab_total_p.toFixed(2));
		$('.tfinal_grade').val(tfinal_grade.toFixed(2));

	$.fn.finalGrade();
	});


};	

$.fn.finalGrade = function(){
	var prelim = 0;
	if(div == 3){
		var prelim = Number($('#prelim').val());
	}
	
		var midterm = Number($('#midterm').val());
		var tentative = Number($('#tentative').val());
		var final = (prelim + midterm + tentative ) / div;
		console.log(prelim +'-'+ midterm  +'-'+ tentative);
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
		
};
	

	<?php if(!$leclab): ?>
			$.fn.lecGrade();
	<?php else: ?>
		$.fn.leclabGrade(); // test
	<?php endif ; ?>	



$('#save_grade_completion').click(function(){
		$.ajax({
                            type: "POST",
                            url: "<?=base_url('grade_completion/save_grade_completion')?>",
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