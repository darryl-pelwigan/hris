<html>
<head>  
<meta charset="utf-8">
<!-- Favicon -->
<link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
<title><?=$title?></title>



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
    min-width: 50px;
    max-width: 50px;
    min-height: 50px;
    height: 50px;
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
    border-top: 1px solid #000 !important;
     border-bottom: 1px solid #000 !important;
    font-size: 12px !important;
    margin: 0 auto;
  }
  #shed_record_list>tbody>tr>td{
     border: 2px solid #000 !important;
  }

   #shed_record_list>tfoot>tr>td{
     border-bottom: 1px solid #000 !important;
    border-top: 1px solid #000 !important;
   }

  .text-center{
    text-align: center;
  }

  #subject_info{
    font-size: 12px;
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
  h4{
    text-align: center;
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


</style>
</head>
<body>
  <h4>GRADES SHEET</h4>

  <?php

    // print_r($subject_info['sched_query'][0]);
  ?>
<div class="panel panel-success " id="subject_info" data-panel-body="subject_info">
                    <div class="panel-heading " >
                       <strong  class="redlight-label" >  Subject Info </strong>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body collapse  in" id="subject_info">
                    <div class='col-md-3'>Class Code : <strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->coursecode)?></strong></div>
                    <div class='col-md-3'>Type : <strong><?=strtoupper($subject_info['sched_query'][0]->type)?></strong></div>
                    <div class='col-md-3'>Subject Code: <strong><?=strtoupper($subject_info['sched_query'][0]->courseno)?></strong></div>

                    <div class='col-md-12'>Description : <strong  class="redlight-label" ><?=strtoupper($subject_info['sched_query'][0]->description)?></strong></div>
                    
                    
                    <div class='col-md-7'>Schedule :<br />
                     <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                             <strong><?=strtoupper($check_sched[$x]['days'])?> <?=($check_sched[$x]['start'])?> - <?=($check_sched[$x]['end'])?>
                            <?=($check_sched[$x]['lecunits']>0)?"LECTURE":""?>
                            <?=($check_sched[$x]['labunits']>0)?"LABORATORY":""?>
                            </strong>
                            <strong class="blue-label">
                            <?=($check_sched[$x]['teacher_name'])?>
                             </strong> <br />
                     <?php } ?>
                    </div>
                    <div class='col-md-3'>Room :<br />
                        <?php for($x=0;$x<$check_sched['count'];$x++){ ?>
                                    <strong><?=strtoupper($check_sched[$x]['room'])?></strong><br />
                        <?php } ?>
                      </div>
                     </div>
            </div>
<br />
   <div class="panel panel-default panel-overflow">
      <div class="panel-body">
          <table class="table table-hover" id="shed_record_list">
              <thead>
                  <tr>
                      <th class="text-center">NO.</th>
                      <th class="text-center">ID</th>
                      <th class="text-center">STUDENT NAME</th>
                      <th class="text-center">COURSE YR</th>
                      <?php if($check_sched[0]['semester'] !== 3){ ?>
                           <th class="text-center">PRELIM</th>
                      <?php } ?>
                      <th class="text-center">MIDTERM</th>
                      <th class="text-center">FINAL GRADE</th>
                      <th class="text-center" >REMARKS</th>
                  </tr>
              </thead>

              <tbody>
                  

                  <?php
                      echo $table;
                  ?>


              </tbody>

              <tfoot>
                <?php
                echo $tfoot;
                ?>
              </tfoot>
          </table>
        </div>
    </div>
</body>
</html>
