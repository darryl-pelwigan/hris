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
    min-width: 70px;
    max-width: 70px;
    min-height: 70px;
    height: 70px;
    margin-left: 20mm;
}

p {
    padding: 0px;
    margin: 0px;
}

.header {
    margin:0 auto;
    width: 600px;
}

.header_title {
    font-family: 'trajanpro2';
    font-size: 25px;
    color: #000;
    margin-top: -18mm;
    margin-left: 30mm;
    text-shadow: 1px 1px 1px #CCC;
    text-align: center;
}

.header_title_l {
    font-family: 'Times New Roman', Times, serif;
    font-size: 11px;
    margin-left: 31mm;
    margin-top: -7mm;
    margin-bottom: .1mm;
}



/*fix header size*/

#header {
    width: 100%;
    height: 95px;
    min-height: 95px;

}



  #shed_record_list{
    width: 95%;
    font-size: 15px !important;
    margin: 0 auto;
  }
    #shed_record_list_header{
    width: 95%;
    font-size: 11.5px !important;
    margin: 0 auto;
  }


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

  .t_sm1,.t_sm2,.t_sm3{
    text-align: center;
  }

  td, th{
    text-transform: none;
  }

  .tr_rows td,.tr_rows th{
    padding-top: 4px;
  }

  .passed,.passed td{
    color: #003300;
  }

  .failed{
    color: #660000;
  }

  #grades tbody tr td{
    border-top: 1px solid #ccc;
    margin: 1px 0 0 0 ;
    padding: 1px 0 1px 0 ;
  }

  strong,b{
    font-weight: bold;
  }



  hr {

    background: #000;
    height: 1px;
}

hr.dotted {border-top: 1px dashed #000; background: transparent; }

.student_info{
  font-family: SansitaOne;
  font-size: 15px;
}

.subject_info{
  font-family: TitilliumWeb;
  /*padding-left: 5px;*/
  padding-right: 10px;
  font-weight: 700;

}

.adjust{
  font-size: 10px;
}


</style>
</head>
<body>

  <div class=" header-wrapper">
                <div class="col-md-5 header"  >
                 <img class="logo" src="assets/images/logo.png"  />
                        <p class="header_title " >Pines City Colleges</p><br/>
                        <p class="header_title_l t_sm1">(Owned and operated by THORNTONS INTERNATIONAL STUDIES, INC.)</p>
                        <p class="header_title_l t_sm1">Magsaysay Avenue, Baguio City, 2600 Philippines</p>
                        <p class="header_title_l t_sm2">Tel. nos.:(074)445-2210, 445-2209 Fax:(074)445-2208</p>
                        <p class="header_title_l t_sm3">http://www.pcc.edu.ph</p>

                </div>
  </div>

  <hr />

   <h2 class="text-center" style="margin: 0; padding: 0; font-family: dancewithme; font-weight: bold;   ">FINAL GRADES</h2>
                        <h3  class="text-center" style="margin:0; padding: 0; font-family: beholder; font-weight: bold;     letter-spacing: 2px; font-size: 18px;  "> <?=($sem_w['csem'])?> , <?=$sem_w['sy']?></h3>
  <hr />
<div id="page-wrapper">

    <table class="table"  width="95%" align="center" style="padding: 0; margin: 5px 0 6px 0 ;">
      <thead>
        <tr>
          <th><i>ID NUMBER</i></th>
          <th><i>Student Name</i></th>
          <th><i>Course and Year</i></th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td class="student_info"><strong><?=$student_id?></strong></td>
          <td class="student_info"><strong><?=strtoupper($student_info[0]->LastName)?> , <?=strtoupper($student_info[0]->FirstName)?> <?= isset($student_info[0]->MiddleName[0]) ?  strtoupper($student_info[0]->MiddleName[0] ).'.' : '' ?></strong></td>
          <td class="student_info"><strong><?=strtoupper($student_info[0]->code)?> - <?=strtoupper($student_info[0]->yearlvl)?></strong></td>
        </tr>
      </tbody>
    </table>
  <hr />

<?php
$sem=$sem;
if($sem==3)
   { $div=2;
    $pre='';
   }
else
   { $div=3;
   $pre='<th class="subject_info text-center" >Prelim</th>';
   }
$data_merge = $subject_grades;
?>


<?php

$data='';



$total_units = 0;
$total_passed_units = 0;
$total_failed_units = 0;
$show_passed_failed = false;
for($x=0;$x<count($data_merge);$x++){
         $final =  0;
        $total_units += $data_merge[$x]->totalunits;

        $prelim = isset($data_merge[$x]->prelim) ? $data_merge[$x]->prelim : '' ;
        $midterm = isset($data_merge[$x]->midterm) ? $data_merge[$x]->midterm : '' ;
        $tentativefinal = isset($data_merge[$x]->tentativefinal) ? $data_merge[$x]->tentativefinal : '' ;

        $remarks_z = isset($data_merge[$x]->remarks) ? $data_merge[$x]->remarks : '';

        if($remarks_z == 'Passed' ){  $class ='passed'; $total_passed_units += $data_merge[$x]->totalunits; }
        else{   $class='failed'; $total_failed_units += $data_merge[$x]->totalunits; }

        if(isset($data_merge[$x]->prelim)){
        $final = ($prelim) ;
      }

        if(isset($data_merge[$x]->midterm)){
         $final = ( $midterm + $tentativefinal) + $final ;
        }
       if($midterm != '' && $tentativefinal != ''){
          $final = $final/$div;
       }


         if($final>=75 || $final<70){
            $final=round( $final,0 );
        }else{
            if($remarks_z == 'Passed'){
                $final=75;
            }else{
                $final=floor( $final );
            }
    }

        if(isset($data_merge[$x]->prelim)){
              if( $tentativefinal > 0){
                $final = $final;
              }else{
                $final =  0;
              }
            }

        switch ($remarks_z) {

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
                         $reamarksx = $remarks_z;

                         $totalunitsx = 0;
                         if($reamarksx == 'Passed'){
                           $totalunitsx = $data_merge[$x]->totalunits;
                         }

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
         $reamarksx = $remarks_z;
         $totalunitsx = 0;
                         if($reamarksx == 'Passed'){
                           $totalunitsx = $data_merge[$x]->totalunits;
                         }
         $show_passed_failed = true;
        }

         if($data_merge[$x]->semester==3)
            $prel='';
        else
            $prel='<td class="text-center" >'. $prelimx.'</td>';

        $adjust = '';

        if(strlen($data_merge[$x]->description) > 50){
           $adjust = 'adjust';
        }

        $data .='<tr class="'.$class.' tr_rows">
                          <td class="text-left">'.strtoupper($data_merge[$x]->courseno).'</td>
                          <td colspan="3" class="'.$adjust.'">'.strtoupper($data_merge[$x]->description).
                          ($prel)
                          .'<td class="text-center">'.$midtermx.'</td>
                          <td class="'.$class.' text-center">'.$finalx.'</td>

                          <td  class="'.$class.' text-center">'.$totalunitsx.'</td>
                        </tr>';

                        //<td  class="'.$class.' text-center">'.strtoupper($reamarksx).'</td>

 }

// <th  class="subject_info text-center">REMARKS</th>
 ?>

<table class='table' id="grades" style="margin-bottom: 0;" >
  <thead>
<tr><th class="subject_info">SUBJECT CODE </th><th colspan="3"   class="subject_info" >SUBJECT DESCRIPTION</th><?=$pre?><th class="subject_info text-center">Midterm</th><th  class="subject_info text-center text-center" >FINAL</th><th  class="subject_info text-center">UNIT</th></tr>
</thead>
<tbody>
<?=$data?>
</tbody>

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
  <tr class="tr_rows">
    <th colspan="5">&nbsp;</th>
    <th>Passed : </th>
    <th style="font-weight: 700;"><?=$passed?></th>
  </tr>
   <tr class="tr_rows">
     <th colspan="5">&nbsp;</th>
    <th>Failed : </th>
    <th style="font-weight: 700;"><?=$failed?></th>
  </tr>
</tfoot>
</table>


<h3 class="text-center" style="margin-top: 0;font-size: 12px; font-family: dancewithme; letter-spacing: 2px;"><strong> * * * ENTRIES BELOW NOT VALID * * * </strong></h3>
</div>


<table border="0" class="table" style="width:100%;border-top:1px dashed black">
                <tr>
                    <td width="200"></td>
                    <td width="250"></td>
                    <td style="border-bottom: 1px solid #000;"><br><center><b><?=$signatories[0]->staff_name?></b><br>
                        </center>
                    </td>
                </tr>
                   <tr>
                    <td width="200"></td>
                    <td width="250"></td>
                    <td style="padding: 0; margin: 0; vertical-align: top; text-align: center; font-weight: bold;"><?=strtoupper($signatories[0]->position)?>
                    </td>
                </tr>
</table>

</body>
</html>
</html>

<?php
  // die();
?>