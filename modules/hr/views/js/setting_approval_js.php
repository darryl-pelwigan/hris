<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.noty.packaged.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

$.fn.resetsequence = function(val)
{
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>hr/approval/reset_approving',
        dataType: 'json',
        cache: false,
        data : 'position_id=' + val,
        success: function(result) {
            window.location = "<?=base_url('setting_approving_position_ids')?>";
        }
    });
}

$(document).ready(function(){
    // var category = ['Dean', 'OIC', 'Staff', 'Supervisor', 'Teacher'];

    // for (var i = 0; i < category.length ; i++) {
    //     var val = $('#position_id_'+category[i]).val();

    //     $.ajax({
    //         type: 'POST',
    //         url: '<?php echo base_url();?>hr/approval/approval_lists',
    //         dataType: 'json',
    //         cache: false,
    //         data : 'category=' + category[i],
    //         success: function(result) {
    //             if (result.length > 0) {
    //                  var val = '';
    //                  for (var i = 0; i < result.length; i++) {
    //                     val += '<tr>\
    //                         <td>'+result[i].position_name+'</td>\
    //                         <td>'+result[i].approval_level+'</td>\
    //                     </tr>';
    //                  }
    //                 $('#approving_table_'+category[i]+' tbody').append(val);
    //             }
    //         }
    //     });
        
    // }

    var supervisor = 'Supervisor'
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>hr/approval/approval_lists',
        dataType: 'json',
        cache: false,
        data : 'category=' +supervisor,
        success: function(result) {
            if (result.length > 0) {
                 var val = '';
                 for (var i = 0; i < result.length; i++) {
                    val += '<tr>\
                        <td>'+result[i].position_name+'</td>\
                        <td>'+result[i].approval_level+'</td>\
                    </tr>';
                 }

                 $('#approving_table_Supervisor tbody').append(val);
            }
        }
    });


    var dean = 'Dean'
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>hr/approval/approval_lists',
        dataType: 'json',
        cache: false,
        data : 'category=' +dean,
        success: function(result) {
            if (result.length > 0) {
                 var val = '';
                 for (var i = 0; i < result.length; i++) {
                    val += '<tr>\
                        <td>'+result[i].position_name+'</td>\
                        <td>'+result[i].approval_level+'</td>\
                    </tr>';
                 }

                 $('#approving_table_Dean tbody').append(val);
            }
        }
    });

   var oic = 'OIC'
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>hr/approval/approval_lists',
        dataType: 'json',
        cache: false,
        data : 'category=' +oic,
        success: function(result) {
            if (result.length > 0) {
                 var val = '';
                 for (var i = 0; i < result.length; i++) {
                    val += '<tr>\
                        <td>'+result[i].position_name+'</td>\
                        <td>'+result[i].approval_level+'</td>\
                    </tr>';
                 }
                 $('#approving_table_OIC tbody').append(val);
            }
        }
    });

   var staff = 'Staff'
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>hr/approval/approval_lists',
        dataType: 'json',
        cache: false,
        data : 'category=' +staff,
        success: function(result) {
            if (result.length > 0) {
                 var val = '';
                 for (var i = 0; i < result.length; i++) {
                    val += '<tr>\
                        <td>'+result[i].position_name+'</td>\
                        <td>'+result[i].approval_level+'</td>\
                    </tr>';
                 }
                 $('#approving_table_Staff tbody').append(val);
            }
        }
    });

   var teacher = 'Teacher'
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>hr/approval/approval_lists',
        dataType: 'json',
        cache: false,
        data : 'category=' +teacher,
        success: function(result) {
            if (result.length > 0) {
                 var val = '';
                 for (var i = 0; i < result.length; i++) {
                    val += '<tr>\
                        <td>'+result[i].position_name+'</td>\
                        <td>'+result[i].approval_level+'</td>\
                    </tr>';
                 }
                 $('#approving_table_Teacher tbody').append(val);
            }
        }
    });

});

function reset_function(category){
    var x = confirm("Are you sure to reset this record?");
    if(x == true){
        console.log(category);
         $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>hr/approval/reset_approving',
            dataType: 'json',
            cache: false,
            data : 'category=' +category,
            success: function(result) {
                 window.location = "<?=base_url('setting_approving_position_ids')?>";
            }
        });  
    } 

}



</script>
