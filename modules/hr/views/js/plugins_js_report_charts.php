
<script>
	// $(document).on("load", function(){
		console.log('asdasd');
        $.ajax({
            url : "<?=ROOT_URL?>hr_charts.php",
            dataType : "json",
            type: "post", 
            data: "charts=1",
            success: function (data){
                $('.chart-content').html(data);
            },
            error: function (request, status, error){
                alert(request.responseText);
            }
        });
    // });

    
</script>