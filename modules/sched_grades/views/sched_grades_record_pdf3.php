<html>
<head>  
<meta charset="utf-8">
<!-- Favicon -->
<link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
<title><?=$title?></title>
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">


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

.toupper{
  text-transform: capitalize;
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


</style>
</head>
<body>
  <h4>GRADING SHEET</h4>
  <h5 >

    <?php

      echo $sem_sy['sem_sy_w']['csem'],', SY '.$sem_sy['sem_sy_w']['sy'];
   ?>
     

   </h5>
  <hr />
  <br />  
  <br /> 
  <table class="table table-bordered" id="shed_record_list_header"  width="95%" align="center">
            <tbody>
              <tr>

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
                ?>
                <td colspan="6"><h3><strong  class="redlight-label" >  <?=$teacher_name?>  </strong></h3></td>
              </tr>
             <tr>
               <td width="10%">Class Code :</td>
               <td width="20%"> <strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->coursecode)?></strong></td>
               <td width="10%">Type :</td>
               <td width="20%"> <strong><?=strtoupper($subject_info['sched_query'][0]->type)?></strong> </td>
               <td width="12%">Subject Code :</td>
               <td width="20%"><strong><?=strtoupper($subject_info['sched_query'][0]->courseno)?></strong></td>
             </tr>
             <tr>
               <td>Description : </td>
               <td colspan="5"><strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->description)?></strong></td>
             </tr>
             <tr>
               <td>Schedule :</td>
               <td colspan="3">
                 <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                             <strong><?=strtoupper($check_sched[$x]['days'])?> <?=($check_sched[$x]['start'])?> - <?=($check_sched[$x]['end'])?>
                            <?=($check_sched[$x]['lecunits']>0)?"LECTURE":""?>
                            <?=($check_sched[$x]['labunits']>0)?"LABORATORY":""?>
                            </strong>
                            <strong class="blue-label">
                            <?=($check_sched[$x]['teacher_name'])?>
                             </strong> <br />
                     <?php } ?>
               </td>
               <td>Room :</td>
               <td>
                  <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                            <strong><?=strtoupper($check_sched[$x]['room'])?></strong><br />
                <?php } ?>
               </td>
             </tr>

             </tbody>
             
          </table>
<br />
  
          <table class="table table-striped table-bordered" id="shed_record_list">
              <thead>
                  <tr>
                      <th class="text-center" width="4%">NO.</th>
                      <th class="text-center" width="15%">ID</th>
                      <th class="text-center" width="40%">STUDENT NAME</th>
                      <th class="text-center" width="13%">COURSE YR</th>
                      <?php 
                        $array_final_only = ['INTERNSHIP'];
                        if(!in_array(strtoupper($subject_info['sched_query'][0]->type ), $array_final_only)){
                      ?>
                      <?php if($check_sched[0]['semester'] !== 3){ ?>
                           <th class="text-center" width="10%">PRELIM</th>
                      <?php } ?>
                      <th class="text-center" width="10%">MIDTERM</th>
                      <?php } ?>
                      <th class="text-center" width="13%">FINAL GRADE</th>
                      <th class="text-center" width="15%">REMARKS</th>
                  </tr>
              </thead>

              <tbody>
                  

                  <?php
                      echo $table;
                  ?>


              </tbody>

              <tfoot>
              
                
              </tfoot>
          </table>

         <p class="text-center"> <strong class="nothing-follows">*************************** NOTHING FOLLOWS ***************************</strong></p>
        
        <hr />
        <table class="table table-bordered" id="">
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
         <hr />
      
</body>
</html>
