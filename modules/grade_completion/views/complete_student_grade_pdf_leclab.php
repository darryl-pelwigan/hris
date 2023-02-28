<html>
<head>
<meta charset="utf-8">
<!-- Favicon -->
<link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
<title>STUDENT GRADES COMPLETION PMTF</title>
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
      margin-top: -17mm;
      /*margin-left: 30mm;*/
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

  .gr{
    border-bottom: 1px solid #000;
  }

  .grx{
    border: 2px solid #000;
  }

  .dash{
    border: 0 none !important;
    border-top: 2px dashed #000 !important;
    background: none !important;
    height:0 !important;
    margin-bottom: 10px;
    margin-top: 10px;
  }


</style>
</head>
<body>

   <?php



    $teacher_name = '';
      if($check_sched[0]['lecunits']>0){
        $teacher_name = $check_sched[0]['teacher_name'];
      }else{
        if(isset($check_sched[1]['teacher_name'])){
             $teacher_name = $check_sched[1]['teacher_name'];
        }else{
            $teacher_name = $check_sched[0]['teacher_name'];
        }
      }

      $list = ['R.O Copy','Dean\'s Copy','ACAD Copy'];

      $mname = '';
                 if(($student_info[0]->MiddleName)){
                     $mname = $student_info[0]->MiddleName[0];
                  }

     foreach($list as $key => $value):?>

  <?php if($key > 0): ?>
        <div  class="dash" style="" >&nbsp;</div>
  <?php endif; ?>
  <div class=" header-wrapper">
                <div class="col-md-5 header"  >
                 <img class="logo" src="assets/images/logo.png"  />
                         <p class="header_title " >Pines City Colleges</p>
                        <h3 class="text-center" style=" margin: 0; padding: 0;"><?=($college[0]->DEPTNAME)?></h3>
                        <h4 class="text-center" style=" margin: 0; padding: 1px; font-weight: bold;">COMPLETION OF NFE/INC</h4>
                        <h4 class="text-center" style=" margin: 0; padding: 1px; "><?=($sub_sem_sy['csemword'])?>, AY <?=($sub_sem_sy['sy'])?></h4>
                        <!-- <p class="header_title_l t_sm1">(Owned and operated by THORNTONS INTERNATIONAL STUDIES, INC.)</p>
                        <p class="header_title_l t_sm1">Magsaysay Avenue, Baguio City, 2600 Philippines</p>
                        <p class="header_title_l t_sm2">Tel. nos.:(074)445-2210, 445-2209 Fax:(074)445-2208</p>
                        <p class="header_title_l t_sm3">http://www.pcc.edu.ph</p> -->
                </div>


  </div>

  <hr   />

<table class="table table-condense" style="margin: 0; padding: 0;">
                    <tbody>
                        <tr>
                            <td class="text-left" >Name: </td>
                            <td class="text-left" style="width: 320px;"><strong> <?=strtoupper($student_info[0]->FirstName)?> <?=strtoupper($mname)?>. <?=strtoupper($student_info[0]->LastName)?>  </strong></td>
                            <td class="text-left" style="width: 55px;">I.D. No.:</td>
                            <td  class="text-left"> <strong><?=$student_id?></strong></td>
                             <td  class="text-left" style="width: 120px; " >Course & Year: </td>
                            <td class="text-left" colspan="3"><strong><?=strtoupper($student_info[0]->code)?> - <?=strtoupper($student_info[0]->yearlvl)?></strong></td>
                        </tr>
                        <tr>
                            <td  class="text-left" >Subject: </td>
                            <td class="text-left" colspan="6" > <strong><?=strtoupper($subject_info2['sched_query'][0]->description)?></strong></td>
                        </tr>

                         <tr>
                            <td  class="text-left" style="width: 70px; " >Instructor: </td>
                            <td class="text-left" colspan="6" > <strong><?=strtoupper($teacher_name)?></strong></td>
                        </tr>
                    </tbody>
            </table>
<hr   />




         <!--  <table style="margin: 10px 0 3px 0; padding: 0;">
            <tbody>
            <tr>
              <td>
            <table class='table' style="width: 370px; margin: 0; padding: 0; " >
              <tbody>
                <tr >
                <td class="gr" rowspan="3" style="width: 100px;" >Lecture</td>
                 <td></td>
                  <td></td>
                   <td></td>
              </tr>
              <tr>
                  <th class="text-center">CS</th>
                  <th class="text-center">Exam</th>
                  <th class="text-center">Total</th>
              </tr>
              <tr>
                <td class="text-center gr"><?=$grade_completion[0]->lec_cs?></td>
                <td class="text-center gr"><?=$grade_completion[0]->lec_exam?></td>
                <td class="text-center gr"><?=$grade_completion[0]->lec_total?></td>
              </tr>
              </tbody>
            </table>
            </td>
          <?php if($leclab): ?>
            <td style="padding-left: 31px;">
              <table class='table'  style="width: 370px; margin: 0; padding: 0;" >
                <tbody>
                  <tr >
                    <td class="gr" rowspan="3" style="width: 100px;" >Laboratory</td>
                     <td></td>
                      <td></td>
                       <td></td>
                  </tr>
                  <tr>
                  <th class="text-center">CS</th>
                  <th class="text-center">Exam</th>
                  <th class="text-center">Total</th>
                </tr>
                 <tr>
                <td class="text-center gr"><?=$grade_completion[0]->lab_cs?></td>
                <td class="text-center gr"><?=$grade_completion[0]->lab_exam?></td>
                <td class="text-center gr"><?=$grade_completion[0]->lab_total?></td>
              </tr>
                </tbody>
              </table>
              </td>

            <?php endif; ?>
          </tr>
            </tbody>
       </table> -->
       <?php
                                $tfinal_lab_total = 0;
                                if(!$leclab):
                                    $lec_p = 1;
                                    $lab_p = 1;
                                else:
                                    $lec_p = '60';
                                    $lab_p = '40';
                                    if($lec_lab){
                                        $percentage = json_decode($lec_lab);
                                              if($percentage){
                                                  $lec_p = $percentage->lec / 100;
                                                  $lab_p = $percentage->lab / 100;
                                          }
                                    }
                                    $tfinal_lab_total = isset($grade_completion[0]) ? number_format( $grade_completion[0]->lab_total * $lab_p,2) : '';
                                endif;
                                $tfinal_lec_total = isset($grade_completion[0]) ? number_format( $grade_completion[0]->lec_total * $lec_p,2) : '';

                                $tfinal_grade =  $tfinal_lec_total + $tfinal_lab_total;


                        ?>

        <?php if($leclab): ?>
          <!-- <table class="table" style="margin: 0; padding: 0; b">
            <thead>
              <tr>
                <th class="gr" rowspan="3">TENTATIVE FINAL GRADE</th>
              </tr>
              <tr>
              <th class="text-center">Lecture</th>
              <?php if($leclab): ?>
                  <th  class="text-center">Laboratory</th>
              <?php endif; ?>
              <th  class="text-center">Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>


              <td  class="text-center gr"><?=$grade_completion[0]->lec_total?> <?= $lec_p == 1 ? '' : '('.$lec_p.')='.$tfinal_lec_total ?></td>

              <td  class="text-center gr"><?=$grade_completion[0]->lab_total?> <?= $lab_p == 1 ? '' : '('.$lab_p.')='.$tfinal_lab_total?></td>

              <td  class="text-center gr"><?=$tfinal_grade?></td>
            </tr>
            </tbody>
          </table> -->
  <?php endif; ?>
          <table class="table" style="margin: 3px 0 0 0;">
            <thead>
              <tr>
                <th rowspan="3" class="gr" >Final Grade</th>
              </tr>
              <tr>

                        <?php $final_grade = number_format( ($subject_grades[0]->prelim + $subject_grades[0]->midterm +  $tfinal_grade) / $div ,2);


                                    if($grade_completion[0]->grade_remarks == 'Passed'):
                                        $color = '#127912';
                                    elseif($grade_completion[0]->grade_remarks == 'Failed'):
                                        $color = '#b32b2b';
                                    else:
                                        $color = '';
                                    endif;


                                    $final_grade = finalg($final_grade ,$grade_completion[0]->grade_remarks);



                        ?>
                        <?php if($div == 3): ?>
              <th class="text-center ">Prelim Grade</th>
                        <?php endif; ?>
              <th class="text-center ">Midterm Grade</th>
              <th class="text-center ">Tentative Final Grade</th>
              <th class="text-center ">Final Grade</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <?php if($div == 3): ?>
                  <td  class="text-center gr"><?=$subject_grades[0]->prelim?></td>
              <?php endif; ?>
                  <td  class="text-center gr"><?=$subject_grades[0]->midterm?></td>
                  <td  class="text-center gr"><?=$tfinal_grade?></td>
                  <td  class="text-center grx" rowspan="4" style="color: <?=$color?>"><?=$final_grade?><br /><?=$grade_completion[0]->grade_remarks?></td>
            </tr>
            <tr>
              <td></td>
              <td colspan="<?=$div?>" class="text-center"  ><?=$div?></td>
              <td></td>
            </tr>
            </tbody>
          </table>

                 <!-- <div class="form-group">
                  <label>REMARKS: </label>
                    <u><?=$grade_completion[0]->remarks?></u>
                </div> -->


                <table class="table" style="margin: 0; padding: 0; width: 450px;">
                    <tbody>
                       <tr >
                         <td style="width: 150px;  text-align: right;   ">Instructor's Signature : </td>
                         <td style="width: 250px;   " class="gr"></td>

                         <td style="width: 50px; text-align: right;  ">Date : </td>
                         <td style="width: 150px;   " class="gr"><?=unix_to_human(now())?></td>
                       </tr>

                       <tr>
                         <td style="text-align: right; padding-top: 10px;" >Noted by : </td>
                         <td  class="gr" style="padding-top: 10px;"></td>
                       </tr>
                        <tr>
                         <td colspan="2" style="text-align: center;" >Dean </td>
                       </tr>
                    </tbody>
            </table>


      </div>

      <table width="100%" style="border-top:1px solid #000;">
     <tr>
          <td width="50%" style="font-size:10px;"><?=(strtoupper($student_info[0]->LastName))?>,<?=strtoupper($student_info[0]->FirstName)?> <?=(strtoupper($student_info[0]->MiddleName[0]))?> (<?=strtoupper($student_info[0]->code)?> - <?=$student_info[0]->yearlvl?>) </td>

          <td width="50%" style="text-align: right;font-size:10px;"><small> This is a Computer Generated Document. Not valid as transfer credential.</small>
          </td>
       </tr>
   </table>

    <?php endforeach; ?>
</body>
</html>
