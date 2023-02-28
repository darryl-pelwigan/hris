<?php
$data_merge = $transfer_grades; 
?>

<table class='table'>
<tr><th>Course No<th>Description<th>Units<th>Final<th>Remarks</th></tr>

<?php
for($x=0;$x<count($data_merge);$x++){ 
?>
<tr><td><?=$data_merge[$x]->coursecode?><td><?=$data_merge[$x]->description?><td><?=$data_merge[$x]->units?><td><?=$data_merge[$x]->grades?><td></td></tr>
<?php } ?>
</table>
