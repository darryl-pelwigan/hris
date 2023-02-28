<script type="text/javascript" src="<?=base_url()?>assets/functions/js/etools/etools_js_core.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#creating_etools").submit(function(e){
        var url = "<?=base_url()?>etools/save_etool"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: $("#creating_etools").serialize(), // serializes the form's elements.
               success: function(data)
               {
                    $('body').prepend('<div class="modal"  tabindex="-1" id="statusAutoSave" role="dialog" aria-labelledby="statusAutoSave" aria-hidden="false" style="display: block;z-index: 1051;top: 10%;" ><div class="modal-dialog modal-sm"><div class="modal-content   alert alert-success auto_save_success">success</div></div></div> ');
                     $('#statusAutoSave').modal('show');
                     $('#statusAutoSave').delay(500).queue(function() {
                         $('#statusAutoSave').modal('hide');
                         window.location.replace("<?=base_url()?>Schedule/Records2/<?=$this->uri->segment(3)?>")
                     });
               }
         });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
});
</script>