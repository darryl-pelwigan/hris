<script type="text/javascript">


var div = <?=$div?>;
var final = 0;
var lec_p = 1;
var lab_p = 1;

<?php if($leclab): ?>
	lec_p = ($('#lec_percnt').val() / 100);
	lab_p = ($('#lab_percnt').val() / 100);

$('#lec_percnt').change(function(){
	lec_p = ($('#lec_percnt').val() );
	lab_p = 100-lec_p;
	$('#lab_percnt').val(lab_p)
	lec_p = lec_p / 100;
	lab_p = lab_p / 100;
	$.fn.leclabGrade();
});

$('#lab_percnt').change(function(){

	lab_p = parseFloat($('#lab_percnt').val());
	lec_p = 100-lab_p;
	$('#lec_percnt').val(lec_p);
	lec_p = lec_p / 100;
	lab_p = lab_p / 100;
	$.fn.leclabGrade();
});

<?php endif; ?>
$.fn.lecGrade = function(){

		var csp = $('#lec_cs_prcnt').val();
		var exmp = $('#lec_exam_prcnt').val();

		var lec_total = (parseFloat($('#lec_cs').val()) * csp ) + ( parseFloat($('#lec_exam').val()) * exmp );

		lec_total = parseFloat(lec_total/100 );
		var lec_total_p = parseFloat(lec_total * lec_p );

		$('#lec_total').val((lec_total.toFixed(2)));
		$('#tfinal_lec_total').val((lec_total_p.toFixed(2)));
		$('.tfinal_grade').val((lec_total.toFixed(2)));

		$.fn.finalGrade();




};

$.fn.leclabGrade = function(){
	$.fn.lecGrade();
		var lec_cs_prcnt = $('#lec_cs_prcnt').val();
		var lec_cs_prcnt = $('#lec_exam_prcnt').val();
		var csp = $('#lab_cs_prcnt').val();
		var exmp = $('#lab_exam_prcnt').val();
		var lab_total =  (parseFloat($('#lab_cs').val()) * exmp) + ( parseFloat($('#lab_exam').val()) * csp );

		var lec_total = $('#lec_total').val();
		lec_total = parseFloat(lec_total );

		lab_total = parseFloat(lab_total/100 );
		console.log(lab_total);
		var lec_total_p = parseFloat(lec_total * lec_p );
		var lab_total_p = parseFloat(lab_total * lab_p );
		console.log(lab_p + ' ===== '+ lab_total + ' * ' +lab_p);
		$('#lab_total').val(lab_total.toFixed(2));
		var tfinal_grade = parseFloat(lec_total_p+lab_total_p);
		$('#tfinal_lec_total').val(lec_total_p.toFixed(2));
		$('#tfinal_lab_total').val(lab_total_p.toFixed(2));
		$('.tfinal_grade').val(tfinal_grade.toFixed(2));
		$.fn.finalGrade();
};

$('#lab_cs , #lab_exam').on('keyup change load',function(){
		$.fn.leclabGrade();
});

$('#lec_cs , #lec_exam').on('keyup change',function(){
	$.fn.lecGrade();
});





$.fn.finalGrade = function(){
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

};


$('#lec_cs_prcnt').change(function(){
		var csp = $(this).val();
		var exmp = $('#lec_exam_prcnt');
		exmp.val(100-csp);
		$.fn.leclabGrade();
});

$('#lab_cs_prcnt').change(function(){
		var csp = $(this).val();
		var exmp = $('#lab_exam_prcnt');
		exmp.val(100-csp);
		$.fn.leclabGrade();
});


$.fn.gRemarks = function(){
	var _el = $('#grade_remarks');
	if(_el.val() == 'Passed'){
		var finalg = $('#final_grade').val();
		if(final < 75){
			$('#final_grade').val(75);
		}
	}else{
		$.fn.finalGrade();
	}
};

$('#grade_remarks').change(function(){
	var option = $('#grade_remarks :selected').text();
	if(option == 'Passed'){
		$('#grade_remarks option[value="Passed"]').attr('selected', true);
		$('#grade_remarks option[value="Failed"]').attr('selected', false);
		$('#grade_remarks option[value="No Grade"]').attr('selected', false);
	}else if(option == 'Failed'){
		$('#grade_remarks option[value="Passed"]').attr('selected', false);
		$('#grade_remarks option[value="Failed"]').attr('selected', true);
		$('#grade_remarks option[value="No Grade"]').attr('selected', false);
	}else{
		$('#grade_remarks option[value="Failed"]').attr('selected', false);
		$('#grade_remarks option[value="Passed"]').attr('selected', false);
		$('#grade_remarks option[value="No Grade"]').attr('selected', true);
	}
	$.fn.gRemarks();
});




	<?php if(!$leclab): ?>
			$.fn.lecGrade();
	<?php else: ?>
		$.fn.leclabGrade(); // test
	<?php endif ; ?>



$('#save_grade_completion').click(function(){
	var tentative = $('#tentative').val();
	var grade_remarks = $('#grade_remarks').val();
	var final_grade = $('#final_grade').val();

	if(tentative != '' && grade_remarks != '' && final_grade != '' ){
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
                                	// location.reload();
                                });
                        }
                });
	}else{
		swal({
                                  title: 'ERROR SUBMITTING GRADES',
                                  html: '<h4 class="red">PLEASE Enter Grades </h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
	}
});



</script>