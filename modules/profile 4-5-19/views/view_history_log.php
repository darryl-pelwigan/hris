
<style>
     .ui-autocomplete {
        z-index: 2147483647;
        position:absolute;
    }
    .page-header{
        margin-top: 100px;
    }
</style>

<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                </h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            History Log
            <?php $position = (isset($user['position'][0])?$user['position'][0]->position:'N/A')?>
        </div>

        <div class="panel-body">
		
			<table class="table display compact small employee"  id="history_log_list" width="100% ">
				<thead>
                    <th class="hide_id">ID</th>
					<th width="20%">Employee Profile</th>
                    <th width="5%">Type</th>
					<th width="10%">Old Data</th>
					<th width="10%">New Data</th>
					<th>Action</th>
                    <th width="20%">Updated By</th>
					<th width="15%">Date</th>
				</thead>
			</table>

		</div>

    </div>
</div>
