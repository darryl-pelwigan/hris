<table class='table'>
  <thead>
    <tr><th>Course No</th><th>Description</th><th>Final</th><th>Remarks</th><th>Unit</th></tr>
  </thead>

  <tbody>
      <?=$table['tbody']?>
  </tbody>

<?php
  if(!$table['show_note']):
?> 
  <tfoot>
  <tr>
    <th colspan="3">&nbsp;</th>
    <th>Passed</th>
    <th><?=$table['passed']?></th>
  </tr>
   <tr>
     <th colspan="3">&nbsp;</th>
    <th>Failed</th>
    <th><?=$table['failed']?></th>
  </tr>
</tfoot>
</table>
<?php
  else:
?>
</table>
<p><strong>NOTE :</strong><strong style="color:#9e0404">**N - Your Grade will be shown after final submission of your instructor</strong></p>
<?php 
  endif;
  
?>