<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/jquery.timepicker.css">

<style type="text/css" class="init">

    td.details-control {
        background: url('<?=ROOT_URL?>tableEditor/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('<?=ROOT_URL?>tableEditor/resources/details_close.png') no-repeat center center;
    }

	#emp_lists tr:hover {
		text-decoration: underline;
	}

	#emp_lists_inactive tr:hover {
		text-decoration: underline;
	}

	
	.panel-default {
		border-color: rgb(91, 148, 95) !important;
	}

	.panel-default>.panel-heading {
	    color: #fff;
	    background-color: rgb(91, 148, 95);
	    border-top: 2px solid  rgb(91, 148, 95);
	    border-bottom: none;
	    border-color: rgb(91, 148, 95);
	}
	.ui-autocomplete {
        z-index: 1510 !important;
    }
	.panel_leave_requests{
		border-radius:10px;
		box-shadow: 5px 7px 8px 8px #DCDCDC;
	}
	.panel_approved{	
		background-color:#33cc66 !important;
		color: #000 !important;
	}
	.panel_disapproved{
		background-color:#cc3333 !important;
		color: #eee !important;
	}
	.panel_pending{
		background-color:#3399ff !important;
		color: #000 !important;
	}
	.panel_leave_requests .panel-heading{
		font-weight: bold;
		font-size: 15px;
		text-transform: uppercase;
	}
	.hr_pending_approved{
		background-color:#ffcc99 !important;
		color: #000 !important;
	}

	 th.hide_id, td.hide_id {
        display: none;
    }

	
</style>    

