<?php 
if($this->session->flashdata('error')){

echo '<div class="alert alert-danger"> <strong>NOTE:</strong> '.$this->session->flashdata('error').' </div>';
}

?>

<table class="table table-bordered  display  dataTable dtr-inline no-footer">
<thead>
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>Name</th>
        <th>Lecture</th>
        <th><?=($lec*100)?>%</th>
        <th>Laboratory</th>
        <th><?=($lab*100)?>%</th>
        <th>Grade</th>
    </tr>
</thead>
<tbody>
<?php
for($x = 0 ; $x<count($grades);$x++){
    if($grades[$x]->{$type_d[0]}<75){
        $class = 'failed';
    }else{
        $class = 'passed';
    }
    $total = ($grades[$x]->{$type_d[0]}*$lec) + ($grades[$x]->{$type_d[1]}*$lab) ;
     echo   '<tr>
                <td>'.$x.'</td>
                <td>'.$grades[$x]->studid.'</td>
                <td>'.ucfirst ($grades[$x]->lastname.', '.$grades[$x]->firstname.' '.$grades[$x]->middlename.' '.$grades[$x]->namesuffix).'</td>
                <td><span class="'.$class.'">'.$grades[$x]->{$type_d[0]}.'</span></td>
                 <td><span class="'.$class.'">'.round($grades[$x]->{$type_d[0]}*$lec,2).'</span></td>
                <td><span class="'.$class.'">'.$grades[$x]->{$type_d[1]}.'</span></td>
                <td><span class="'.$class.'">'.round($grades[$x]->{$type_d[1]}*$lab,2).'</span></td>
                <td><span class="'.$class.'">'.round($total,2).'</span></td>
            </tr>';
}

 ?>
</tbody>
</table>
