

<table class="table table-bordered  display  dataTable dtr-inline no-footer">
<thead>
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>Name</th>
        <?php $divisor = $sem_sy['sem'] ==2 ? 3 : 2 ;  if($sem_sy['sem'] ==2 ){ ?> <th>Prelim</th> <?php } ?>
        <th>Midterm</th>
        <th>Tentative Final</th>
        <th>Grade</th>
         <th>Remarks</th>
    </tr>
</thead>
<tbody>

<?php
for($x = 0 ; $x<count($grades);$x++){
    if($grades[$x]->midterm<75){
        $class_pre = 'failed';
    }else{
        $class_pre = 'passed';
    }

    if($grades[$x]->midterm<75){
        $class_md = 'failed';
    }else{
        $class_md = 'passed';
    }

    if($grades[$x]->tentativefinal<75){
        $class_tf = 'failed';
    }else{
        $class_tf = 'passed';
    }


    $pre = '';
    $total =$grades[$x]->midterm + $grades[$x]->tentativefinal;
     if($sem_sy['sem'] ==2 ){
            $pre = '<td><span class="'.$class_pre.'">'.$grades[$x]->prelim.'</span></td>';
            $total =  $total  + $grades[$x]->prelim;

     }
     $total = round( $total / $divisor,2);

     if($total>=75 || $total<74.5){
                    $total=round( $total,0 );
                }else{
                    if($grades[$x]->final_remarks == 'Passed'){
                        $total=round( $total,0 );
                    }else{
                        $total=round( $total,2 );
                    }
                }
     

     if($total<75){
        $class = 'failed';
    }else{
        $class = 'passed';
    }


     echo   '<tr>
                <td>'.$x.'</td>
                <td>'.$grades[$x]->studid.'</td>
                <td>'.ucfirst ($grades[$x]->lastname.', '.$grades[$x]->firstname.' '.$grades[$x]->middlename.' '.$grades[$x]->namesuffix).'</td>
                        '.$pre.'
                 <td><span class="'.$class_md.'">'.$grades[$x]->midterm.'</span></td>
                <td><span class="'.$class_tf.'">'.$grades[$x]->tentativefinal.'</span></td>
                <td><span class="'.$class.'">'.$total.'</span></td>
                <td><span class="'.$class.'">'.$grades[$x]->final_remarks.'</span></td>
            </tr>';
}

 ?>
</tbody>
</table>
