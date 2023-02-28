<table class="table table-bordered  display  dataTable dtr-inline no-footer">
<thead>
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>Name</th>
        <th>Grade</th>
    </tr>
</thead>
<tbody>
<?php
for($x = 0 ; $x<count($grades);$x++){
    if($grades[$x]->final<75){
        $class = 'failed';
    }else{
        $class = 'passed';
    }
     echo   '<tr>
                <td>'.$x.'</td>
                <td>'.$grades[$x]->studid.'</td>
                <td>'.ucfirst ($grades[$x]->lastname.', '.$grades[$x]->firstname.' '.$grades[$x]->middlename.' '.$grades[$x]->namesuffix).'</td>
                <td><span class="'.$class.'">'.$grades[$x]->{$type_d[0]}.'</span></td>
            </tr>';
}

 ?>
</tbody>
</table>
