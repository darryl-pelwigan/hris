<html>
<head>
<meta charset="utf-8">
<!-- Favicon -->
<link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
<title><?=$title?></title>
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


  .t_sm1,.t_sm2,.t_sm3{
    text-align: center;
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

  strong, b {
    font-weight: bold;
  }
   .table-bordered>tbody>tr>td,.table-bordered>thead>tr>th{
    font-size: 14px;
  }
<?php
if($student_count <= 45){
?>
 #shed_record_list>tbody>tr>td, #shed_record_list>thead>tr>th{
    font-size: 14px;
  }
<?php
}else{
?>
 #shed_record_list>tbody>tr>td, #shed_record_list>thead>tr>th{
    font-size: 8px !important;
  }
<?php
}
?>
  #shed_record_listd>thead>tr>th{
    border-bottom: 3px solid #000 !important;
    border-top: 3px solid #000 !important;
  }


</style>
</head>
<body>
  <h2 class="text-center" style="margin: 0; padding: 0; font-family: dancewithme; "><?= strtoupper('grading sheet') ?></h2>
  <h3 class="text-center" style="margin:0; padding: 0; font-family: beholder; font-weight: bold;     letter-spacing: 2px; font-size: 18px;  ">
    <?php

      echo strtoupper($sub_sem_sy['csem']).', SY '.$sub_sem_sy['sy'];
   ?>


   </h3>
  <hr style="border-top: 2px solid #000;" />




         <div class="row">
           <div class="col-sm-12">
              <h3 class="text-left" >Faculty : <strong style="text-transform: uppercase;">  <?=($teacher_info[0]->LastName)?> <?=strtoupper($teacher_info[0]->FirstName)?>  </strong></h3>
           </div>
         </div>

  <table autosize="1"  width="95%"  style="padding: 0;">
            <tbody>
             <tr>
               <td style="width: 90px ;">Class Code :</td>
               <td   > <strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->coursecode)?></strong></td>
               <!-- <td width="10%">Type :</td>
               <td width="20%"> <strong><?=strtoupper($subject_info['sched_query'][0]->type)?></strong> </td> -->
               <td style="width: 100px ;" >Subject Code :</td>
               <td  ><strong><?=strtoupper($subject_info['sched_query'][0]->courseno)?></strong></td>

               <td  style="width: 50px ;" class="text-right" >UNIT :</td>
               <td  style="width: 50px ;" class="text-left" ><strong><?=$check_sched['lecunits'] + $check_sched['labunits']?></strong></td>
             </tr>
             <tr>
               <td >Description : </td>
               <td colspan="5"><strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->description)?></strong></td>
             </tr>

             </tbody>

          </table>
          <h4 style="margin: 0; padding: 0;" class="text-center">SCHEDULE:</h4>
          <table class="table table-striped" style="margin: 0 auto; width: 400px;">
                      <thead>
                        <tr >
                          <th style="background: #ccc;" class="text-center"><i>Time</i></th>
                          <th style="background: #ccc;" class="text-center"><i>Days</i></th>
                          <th style="background: #ccc;" class="text-center"><i>Room</i></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          for($x=0;$x<$check_sched['count'];$x++){ ?>
                            <tr>

                              <td class="text-center" ><strong> <?=($check_sched[$x]['start'])?> - <?=($check_sched[$x]['end'])?></strong></td>

                             <td class="text-center"><strong> <?=strtoupper($check_sched[$x]['days'])?></strong></td>
                            <td class="text-center"><strong><?=strtoupper($check_sched[$x]['room'])?></strong></td>
                             </tr>
                        <?php } ?>
                      </tbody>
                  </table>


<br />

          <table class="table table-striped table-bordered" id="shed_record_list" >
              <thead>
                  <tr class="">
                      <th class="text-center border2" width="5%"   >NO.</th>
                      <th class="text-center border2" width="15%"  >ID</th>
                      <th class="text-center border2" width="40%"  >STUDENT NAME</th>
                      <th class="text-center border2" width="13%"  >COURSE YR</th>
                      <?php
                        $array_final_only = ['INTERNSHIP'];
                        if(!$checker['fg_only']){
                      ?>
                      <?php if($check_sched[0]['semester'] != 3  || $smpt){ ?>
                           <th class="text-center border2" width="10%" >PRELIM</th>
                      <?php } ?>
                      <th class="text-center border2" width="10%"  >MIDTERM</th>
                      <?php } ?>
                      <th class="text-center border2" width="13%" >FINAL GRADE</th>
                      <th class="text-center border2" width="15%" >REMARKS</th>
                  </tr>
              </thead>

              <tbody>


                  <?php
                      echo $table;
                  ?>


              </tbody>
          </table>

         <p class="text-center"> <strong class="nothing-follows">*************************** NOTHING FOLLOWS ***************************</strong></p>

        <hr />
        <table class="table table-bordered" id="ben">
            <tbody>
              <tr>
                <td colspan="9" style="width: 600px;   text-align: right;">
                  <br />
                  <strong class="ins_sign">Instructor's Signature &#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;&#95;</strong><br />

                  <br /><p >Reviewed by the Dean: </p>
                </td>
                <td style="width: 200px; border: 2px solid #000; " >&nbsp;</td>
               <td style="width: 200px; border: 2px solid #000; " >&nbsp;</td>
                <td style="width: 200px; border: 2px solid #000; " >&nbsp;</td>
              </tr>
            </tbody>

        </table>

</body>
</html>
<?php



?>