
<?php
$sem=$sem; 
if($sem==3)
   { $div=2;
    $pre='';
   }
else
   { $div=3;
   $pre='<th>Prelim</th>';
   }
$data_merge = $subject_grades; 
?>

<table class='table'>

<?php

if($sem_w['sy']!=NULL && $sem_w['sy2']!=NULL && $sem_w['csem']==''  ){
    echo '<strong> School Year :</strong>'.$sem_w['sy'];
}elseif ($sem_w['sy']!=NULL && $sem_w['sy2']!=NULL  && $sem_w['csem']!='') {
    echo '<strong>Sem : </strong> '.$sem_w['csem'].' <strong> SY : </strong>'.$sem_w['sy'];
}
$data='';
$colspan = 3;
$total_units = 0;
$total_passed_units = 0;
$total_failed_units = 0;
$show_passed_failed = false;
for($x=0;$x<count($data_merge);$x++){ 
 

        $final = 0;
        $total_units += $data_merge[$x]->totalunits;
        
        $prelim = $data_merge[$x]->prelim;
        $midterm = $data_merge[$x]->midterm;
        $tentativefinal = $data_merge[$x]->tentativefinal;

        if($data_merge[$x]->remarks == 'Passed' ){  $class ='passed'; $total_passed_units += $data_merge[$x]->totalunits; }
        else{   $class='failed'; $total_failed_units += $data_merge[$x]->totalunits; }

      if(isset($data_merge[$x]->prelim)){
        $final = ($prelim) ;
      }

        if(isset($data_merge[$x]->midterm)){
         $final = ( $midterm + $tentativefinal) + $final ;
        }
       
        $final = $final/$div;
        

        $prelimx =  '';
        $midtermx =  '';
        $tentativefinalx =  '';
        $finalx = '';
        $reamarksx = '';
        $totalunitsx = '';
       
        if($sem_sy['sem_sy'][0]->sem == $semx && $sem_sy['sem_sy'][0]->sy == $syx ){
              if(isset($st_grade_submission['m'][0])){

                  if( human_to_unix($st_grade_submission['p'][0]->start_date) <= now()  ){
                       $prelimx = explode('.', $prelim)[0];
                  }

                  if(isset($st_grade_submission['m'][0])){
                    if( human_to_unix($st_grade_submission['m'][0]->start_date) <= now()  ){
                       $midtermx = explode('.', $midterm)[0] ;
                    }



                    if(isset($st_grade_submission['tf'][0])){
                      if( human_to_unix($st_grade_submission['tf'][0]->start_date) <= now()  ){
                         $tentativefinalx = explode('.', $tentativefinal)[0];
                         $reamarksx = $data_merge[$x]->remarks;
                         $finalx = finalg($final ,$reamarksx);
                         $totalunitsx = $data_merge[$x]->totalunits;
                         $show_passed_failed = true;
                      }
                    }
                  }

              }
        }else{
          $prelimx = explode('.', $prelim)[0];
          $midtermx = explode('.', $midterm)[0];
          $tentativefinalx = explode('.', $tentativefinal)[0];
          
         $reamarksx = $data_merge[$x]->remarks;
         $finalx = finalg($final ,$reamarksx);
         $totalunitsx = $data_merge[$x]->totalunits;
         $show_passed_failed = true;


        }
        
        $finalx = gremarks($finalx,$data_merge[$x]->remarks);

        

          



        $data .='<tr class="'.$class.'"><td>'.$data_merge[$x]->courseno.' - '.$data_merge[$x]->subjectid.'<td>'.$data_merge[$x]->description.'<td>'.$finalx.'<td>'.$reamarksx.'</td><td>'.$totalunitsx.'</td></tr>';
 
 } 


 ?>

<tr><th>Course No</th><th>Description</th><th>Final</th><th>Remarks</th><th>Unit</th></tr>
<?=$data?>


<?php
$passed = '';
$failed = '';
if($show_passed_failed){
  $passed = ($total_passed_units / $total_units) * 100;
  $failed = ($total_failed_units / $total_units) * 100;

  $passed = number_format($passed,2).'%';
  $failed = number_format($failed,2).'%';
}
  
?>
<tfoot>
  <tr>
    <th colspan="<?=$colspan?>">&nbsp;</th>
    <th>Passed</th>
    <th><?=$passed?></th>
  </tr>
   <tr>
     <th colspan="<?=$colspan?>">&nbsp;</th>
    <th>Failed</th>
    <th><?=$failed?></th>
  </tr>
</tfoot>
</table>


<h2 class="text-center"><strong> * * * ENTRIES BELOW NOT VALID * * * </strong></h2>
