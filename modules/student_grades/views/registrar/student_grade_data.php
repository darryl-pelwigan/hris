<html>
<head>  
<meta charset="utf-8">
<!-- Favicon -->
<link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
<title>STUDENT GRADES</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">


<style type="text/css">
/*.panel*/

.header-wrapper {
    width: 100%;
    height: 95px;
    min-height: 95px;
    padding-top: 0px;
    border-bottom: 1px solid #033E0D;
}

.logo {
    min-width: 90px;
    max-width: 90px;
    min-height: 90px;
    height: 90px;
}

p {
    padding: 0px;
    margin: 0px;
}

.header {
    margin-left: 25%;
}

.header_title {
    font-family: 'trajanpro';
    font-size: 28px;
    color: #006600;
    margin-top: -20mm;
    margin-left: 25mm;
    text-shadow: 1px 1px 1px #CCC;
}

.header_title_l {
    font-family: 'Times New Roman', Times, serif;
    font-size: 11px;
    margin-left: 25mm;
    margin-top: -5mm;
    margin-bottom: .2mm;
}



/*fix header size*/

#header {
    width: 100%;
    height: 95px;
    min-height: 95px;
}



  #shed_record_list{
    width: 95%;
/*    border-top: 1px solid #000 !important;
     border-bottom: 1px solid #000 !important;*/
    font-size: 15px !important;
    margin: 0 auto;
  }
    #shed_record_list_header{
    width: 95%;
    font-size: 11.5px !important;
    margin: 0 auto;
  }
  
  /*#shed_record_list>tbody>tr>td{
     border: 2px solid #000 !important;
  }

   #shed_record_list>tfoot>tr>td{
     border-bottom: 1px solid #000 !important;
    border-top: 1px solid #000 !important;
   }*/
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
      border: 2px solid #000 ;
    font-size: 12px;
}
  .text-center{
    text-align: center;
  }

  #subject_info{
    font-size: 11px;
     margin-left: 50px;
  }

  .panel-body{
    /*margin-left: 20px;*/
  }

  .passed{
    color: green;
  }

  .failed{
    color: red;
  }
  h4,h5{
    margin: 0;
    padding: 2px;
    text-align: center;
  }
  hr{
    margin: 0;
    padding: 0;
  }

  .col-md-12{
    float: left;
    width: 100%;
  }

  .col-md-6{
    float: left;
    width: 50%;
  }

  .col-md-7{
    float: left;
    width: 72%;
  }

  .col-md-3{
    float: left;
    width: 28%;
  }

  .nothing-follows{
    text-align: center;
    color: #535556;
    margin-left: 40px;

  }

  .span2{
    font-size: 11px;
  }

  td, th{
    text-transform: none;
  }


</style>
</head>
<body>
<div id="page-wrapper">



<?php
$sem=$sem; 
if($sem==3)
   { $div=2;
    $pre='';
   }
else
   { $div=3;
   $pre='<th>Prelim';
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



$total_units = 0;
$total_passed_units = 0;
$total_failed_units = 0;
$show_passed_failed = false;
for($x=0;$x<count($data_merge);$x++){ 
        
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

         if($final>=75 || $final<70){
            $final=round( $final,0 );
        }else{
            if($data_merge[$x]->remarks == 'Passed'){

                $final=75;
            }else{
                $final=floor( $final );
            }
    }

        if(isset($data_merge[$x]->prelim)){
              if( $data_merge[$x]->tentativefinal > 0){
                $final = $final;
              }else{
                $final = 0;
              }
            }

        switch ($data_merge[$x]->remarks) {

          case 'No Final Examination':
              $final = 'NFE';
            break;
          case 'No GRADE':
              $final ='NG';
            break;

          case 'Officially Dropped':
              $final ='ODRP';
            break;

          case 'Unofficially Dropped':
              $final ='UDRP';
            break;

          case 'Incomplete':
              $final ='INC';
            break;

          case 'No CREDIT':
              $final ='NC';
            break;

          case 'DROPPED':
              $final ='DRP';
            break;

          case 'Withdrawal with Permission':
              $final ='Withdrawal/P';
            break;

          default:
            break;
        }
        $prelimx =  '';
        $midtermx =  '';
        $tentativefinalx =  '';
        $finalx = '';
        $reamarksx = '';
        $totalunitsx = '';
        // if(){

        // }
        if($sem_sy['sem_sy'][0]->sem == $semx && $sem_sy['sem_sy'][0]->sy == $syx ){
              if(isset($st_grade_submission['p'][0])){
                  if( human_to_unix($st_grade_submission['p'][0]->start_date) <= now()  ){
                       $prelimx = explode('.', $prelim)[0];
                  }
                  if(isset($st_grade_submission['m'][0])){
                    if( human_to_unix($st_grade_submission['m'][0]->start_date) <= now()  ){
                       $midtermx = explode('.', $midterm)[0];
                    }
                    if(isset($st_grade_submission['tf'][0])){
                      if( human_to_unix($st_grade_submission['tf'][0]->start_date) <= now()  ){
                         $tentativefinalx = explode('.', $tentativefinal)[0];
                         $finalx = $final;
                         $reamarksx = $data_merge[$x]->remarks;
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
          $finalx = $final;
         $reamarksx = $data_merge[$x]->remarks;
         $totalunitsx = $data_merge[$x]->totalunits;
         $show_passed_failed = true;
        }
        

        if($data_merge[$x]->semester==3)
            $prel='';
        else
            $prel='<td>'. $prelimx.'</td>';
        

          



        $data .='<tr class="'.$class.'"><td>'.$data_merge[$x]->courseno.'<td>'.$data_merge[$x]->description.''.($prel).'<td>'.$midtermx.'</td><td>'.$tentativefinalx.'</td><td>'.$finalx.'<td>'.$reamarksx.'</td><td>'.$totalunitsx.'</td></tr>';
 
 } 


 ?>

<tr><th>Coursasde No<th>Description<?=$pre?><th>Midterm<th>Tentative Final<th>Final<th>Remarks</th><th>Units</th></tr>
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
    <th colspan="6">&nbsp;</th>
    <th>Passed</th>
    <th><?=$passed?></th>
  </tr>
   <tr>
     <th colspan="6">&nbsp;</th>
    <th>Failed</th>
    <th><?=$failed?></th>
  </tr>
</tfoot>
</table>


<h3 class="text-center"><strong> * * * ENTRIES BELOW NOT VALID * * * </strong></h3>
</div>
</body>
</html>
</html>