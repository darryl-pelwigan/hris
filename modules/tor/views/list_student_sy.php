<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
    <thead>
        <tr>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td></td>
        </tr>

        <tr>
            <th>ID No</th>
            <th>Last Name</th>
            <th>Given Name</th>
            <th>Middle Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Student Type</th>
            <th>Nationality</th>
            <th>Mobile #</th>
            <th width="120px">Action</th>
        </tr>
    </thead>
    
</table>

<script>
   $(document).ready(function() {
        $('#dataTables-example').dataTable({
             "oLanguage": {
                "sProcessing": "<img src='" + APP_PATH + "assets/images/ajax-loader.gif' style='width:20px;'>"
            },
           "order": [1, "asc"],
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "bFilter": true,
            "ajax": {
                "url": "tor/get_tor_students",
                "type": "POST",
                "data": function(d) {
                    return 'sy=' + <?=$sy?>;
                }
            },
            "columns": [
                { data: "studid" },
                { data: "lastname" },
                { data: "firstname" },
                { data: "middlename" },
                { data: "emailadd", "sClass": "notrans" },
                { data: "code" },
                { data: "studenttype" },
                { data: "nationality" },
                { data: "mobile" }, {
                    data: null,
                    render: function(data, type, full) {
                        return '<center><button class="btn btn-success btn-xs showTOR" ><i class="glyphicon glyphicon-eye-open"></i> TOR</button> </center>';
                    },
                    "searchable": false
                }
            ]
        }).dataTableSearch(500);
    

});


</script>