<script type="text/javascript">
  var old_pre = 0;
<?php if($div == 3): ?>
  old_pre = Number('<?=$subject_grades[0]->prelim?>');
<?php endif; ?>

var old_mid = Number('<?=$subject_grades[0]->midterm?>');
var old_tenta = Number('<?=$subject_grades[0]->tentativefinal?>');


var div = <?=$div?>;
var final = 0;


$.fn.finalGrade = function(){
    var prelim = 0;
  if(div == 3){
    var prelim = Number($('#prelim').val());
  }

    var midterm = Number($('#midterm').val());
    var tentative = Number($('#tentative').val());
    var final = (prelim + midterm + tentative ) / div;

    if(prelim <= 99 && midterm <= 99 &&  tentative <= 99 ){
      // var grade_remarksx = $('#grade_remarks').find(":selected").text();
      if(final >= 75){
        // document.getElementById("grade_remarks").options.selectedIndex = 1;
         // $('#grade_remarks  option[value="Failed"]').remove();
         $('#final_grade').val(final.toFixed(0));
      }else{
        // if($('#grade_remarks option[value="Failed"]').length == 0){
        //             var options = $('#grade_remarks option').add($('<option value="Failed" data_index="2">Failed</option>')).sort(function(a, b) {
        //                                               return $(a).attr('data_index') < $(b).attr('data_index') ? -1 : $(a).attr('data_index') > $(b).attr('data_index') ? 1 : 0;
        //                                           }).appendTo('#grade_remarks');

        // }
        // if(grade_remarksx == ''){
        //   document.getElementById("grade_remarks").options.selectedIndex = 2;
        // }

        $('#final_grade').val(final.toFixed(2));
      }

    }else{
      if(div == 3){
        $('#prelim').val(old_pre);
      }

      $('#midterm').val(old_mid);
      $('#tentative').val(old_tenta);
      swal({
                                  title: 'ERROR GRADE',
                                  html: '<h4 class="red">GRADE SHOULD BE EQUAL OR LESS THAN 99</h4><br />',
                                  timer: 3500,
                                  type: 'error',
                                });
    }

    <?php
    if(isset($grade_completion[0])):
      $grade_completion[0]->grade_remarks;
    ?>
    if($('#grade_remarks').val() == '<?=$grade_completion[0]->grade_remarks?>'){
      $('#grade_remarks').val('<?=$grade_completion[0]->grade_remarks?>');
    }
    <?php
      endif;
    ?>
};



$('.grade').on('keyup change',function(){
      $.fn.finalGrade();
	});

$.fn.gRemarks = function(){
  var _el = $('#grade_remarks');
  if(_el.val() == 'Passed'){
    var finalg = $('#final_grade').val();
    if(final < 75){
      console.log(final);
      $('#final_grade').val(75);
    }
  }else{
    $.fn.finalGrade();
  }
};

$.fn.finalGrade();

$('#grade_remarks').change(function(){
  $.fn.gRemarks();
});


$('#save_grade_completion').click(function(e){
  e.preventDefault()
  var prelim = 0;
  if(div == 3){
    var prelim = ($('#prelim').val());
  }

    var midterm = ($('#midterm').val());
    var tentative = ($('#tentative').val());
    var final = $('#final_grade').val();
     var grade_remarks = $('#grade_remarks').val();
if(midterm != '' && tentative != '' && final != '' && grade_remarks != '' ){
     $.ajax({
                            type: "POST",
                            url: "<?=base_url('grade_ratification/save_grade_ratify')?>",
                            data : $('#save_grade_ratification_form').serialize(),
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
}else{
   swal({
          title: 'ERROR SUBMITTING GRADES',
          html: '<h4 class="red">PLEASE INPUT ALL GRADE AND TRY AGAIN</h4><br />',
          timer: 3500,
          type: 'warning',
        });

}

});



</script>