<script>
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "MM d, yy"
    });
    $('#form2').hide();

    $('#emp-status').on('click', function(){
        if($('#emp-status:checked').length){
            $('#nature-emp, #none').attr('disabled', true);
        }
        else{
            $('#nature-emp, #none').attr('disabled', false);
        }
    });
    $('#nature-emp').on('click', function(){
        if($('#nature-emp:checked').length){
            $('#emp-status, #none').attr('disabled', true);
        }
        else{
            $('#emp-status, #none').attr('disabled', false);
        }
    });
    $('#none').on('click', function(){
        if($('#none:checked').length){
            $('#nature-emp, #emp-status, #classify').attr('disabled', true);
        }
        else{
            $('#nature-emp, #emp-status, #classify').attr('disabled', false);
        }
    });
    $('#classify').on('click', function(){
        if($('#classify:checked').length){
            $('#none').attr('disabled', true);
        }
        else{
            $('#none').attr('disabled', false);
        }
    });

    $(document).on('click', '#btn-submit', function(){
        var type = $('#type').val();
        if(type == 'Demographics'){
            if($('#classify:checked').length && $('#nature-emp:checked').length==0 && $('#emp-status:checked').length==0){
                document.forms['form'].action='../HRpages/Reports/statistics-classification.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }

            if($('#classify:checked').length > 0 && $('#nature-emp:checked').length > 0 && $('#emp-status:checked').length==0){
                document.forms['form'].action='../HRpages/Reports/statistics-emp-classification.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }
            if($('#classify:checked').length > 0 && $('#emp-status:checked').length > 0 && $('#nature-emp:checked').length == 0 ){
                document.forms['form'].action='../HRpages/Reports/statistics-emp-classification.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }

            if($('#classify:checked').length == 0 && $('#emp-status:checked').length > 0 && $('#nature-emp:checked').length == 0 ){
                document.forms['form'].action='../HRpages/Reports/statistics-emp-nature-status.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }
            if($('#classify:checked').length == 0 && $('#nature-emp:checked').length > 0 && $('#emp-status:checked').length == 0 ){
                document.forms['form'].action='../HRpages/Reports/statistics-emp-nature-status.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }
            if($('#none:checked').length){
                document.forms['form'].action='../HRpages/Reports/statistics-emp.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }
            if($('#graph:checked').length){
                document.forms['form'].action='../statistics-graph.php';
                document.forms['form'].target='_blank';
                document.forms['form'].submit();
            }
        }
        else if(type == 'Employee List'){
            document.forms['form'].action='../HRpages/Reports/employee-lists.php';
            document.forms['form'].target='_blank';
            document.forms['form'].submit();
        }
        else if(type == 'Leave Reports'){
            document.forms['form'].action='../HRpages/Reports/leave-reports.php';
            document.forms['form'].target='_blank';
            document.forms['form'].submit();
        }else if(type == 'Faculty Quality Summary'){
            document.forms['form'].action='../HRpages/Reports/faculty-quality-summary.php';
            document.forms['form'].target='_blank';
            document.forms['form'].submit();
        }else if(type == 'Overtime Reports'){
            document.forms['form'].action='../HRpages/Reports/overtime-reports.php';
            document.forms['form'].target='_blank';
            document.forms['form'].submit();
        }
       
    });

    $('#div_cat_list').hide();
    $('#classify_categ').hide();
    $('#status_categ').hide();
    $('#nature_categ').hide();
    $('#leave-reports').hide();
    $(document).on('change', '#type', function(){
        var val = $(this).val();
        if(val == 'Demographics'){
            $('#div_cat_statistical').show();
            $('#div_cat_list').hide();
            $('#report_by').show();
            $('#from_to_dates').show();
            $('#leave-reports').hide();
        }
        else if(val == 'Employee List'){
            $('#div_cat_statistical').hide();
            $('#div_cat_list').show();
            $('#report_by, #from_to_dates').hide();
            $('#leave-reports').hide();

            $(document).on('click', '#classify-list', function(){
                if($('#classify-list:checked').length){
                    $('#classify_categ').show();
                    $('#none-list').attr('disabled', true);
                }
                else{
                    $('#classify_categ').hide();
                    $('#none-list').attr('disabled', false);

                }
            });
            $(document).on('click', '#emp-status-list', function(){
                if($('#emp-status-list:checked').length){
                    $('#status_categ').show();
                    $('#nature-emp-list, #none-list').attr('disabled', true);
                }
                else{
                    $('#status_categ').hide();
                    $('#nature-emp-list, #none-list').attr('disabled', false);
                }
            });
            $(document).on('click', '#nature-emp-list', function(){
                if($('#nature-emp-list:checked').length){
                    $('#nature_categ').show();
                    $('#emp-status-list, #none-list').attr('disabled', true);
                }
                else{
                    $('#nature_categ').hide();
                    $('#emp-status-list, #none-list').attr('disabled', false);
                }
            });
            $('#none-list').on('click', function(){
                if($('#none-list:checked').length){
                    $('#nature-emp-list, #emp-status-list, #classify-list').attr('disabled', true);
                }
                else{
                    $('#nature-emp-list, #emp-status-list, #classify-list').attr('disabled', false);
                }
            });
        }
        else if(val == 'Leave Reports'){
            $('#from_to_dates').show();
            $('#div_cat_statistical').hide();
            $('#div_cat_list').hide();
            $('#report_by').hide();
            $("#overtime-reports").hide();
            $('#leave-reports').show();
        }
        else if(val == 'Faculty Quality Summary'){
            $('#div_cat_statistical').hide();
            $('#div_cat_list').hide();
            $('#report_by').hide();
            $('#from_to_dates').hide();
            $('#leave-reports').hide();
        }
        else if(val == 'Overtime Reports'){
            $('#from_to_dates').show();
            $('#leave-reports').hide();
            $('#div_cat_statistical').hide();
            $('#div_cat_list').hide();
            $('#report_by').hide();
            // $('#div_cat_statistical').hide();
            // $('#div_cat_list').hide();
            // $('#report_by').hide();
            // $('#from_to_dates').hide();
            $('#overtime-reports').show();
        }
    });
        
    
    $(document).on('click', '#all_checkbox', function(){
        if($('#all_checkbox:checked').length){
            $('.check_box').prop('checked', true);
        }
        else{
            $('.check_box').prop('checked', false);
        }
    });
    $(document).on('click', '#checked_all_columns', function(){
        if($('#checked_all_columns:checked').length){
            $('.all_columns').prop('checked', true);
        }
        else{
            $('.all_columns').prop('checked', false);

        }
    });


</script>