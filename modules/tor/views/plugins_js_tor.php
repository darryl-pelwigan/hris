<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-select.min.js"></script>
<script src="<?=base_url()?>assets/functions/js/tor-list.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#select_sy").on("change", "#schoolyear", function() {
    var this_val = $(this).val();
        $.ajax({
             type: "POST",
             url: "tor/get_tor_studentsx",
             data: {sy:this_val},
             dataType: "html",
             error: function() {
                 console.log("ERROR");
             },
             success: function(data) {
                 $("#table-responsive").html(data);
             }
         });
    });
  });
</script>