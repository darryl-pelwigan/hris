<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/DataTables-1.10.11/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/jquery.timepicker.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/fh-3.1.4/datatables.min.css"/>


<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css">

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
	
	.ui-dialog{
		width: 950px !important;
		z-index: 10000;
	}

	.ui-timepicker-wrapper{
		z-index: 10000;
	}

	.dt-button-collection button.buttons-columnVisibility:before,
	.dt-button-collection button.buttons-columnVisibility.active span:before {
		display:block;
		position:absolute;
		top:1.2em;
	    left:0;
		width:12px;
		height:12px;
		box-sizing:border-box;
	}

	.dt-button-collection button.buttons-columnVisibility:before {
		content:' ';
		margin-top:-6px;
		margin-left:10px;
		border:1px solid black;
		border-radius:3px;
	}

	.dt-button-collection button.buttons-columnVisibility.active span:before {
		content:'\2714';
		margin-top:-11px;
		margin-left:12px;
		text-align:center;
		text-shadow:1px 1px #DDD, -1px -1px #DDD, 1px -1px #DDD, -1px 1px #DDD;
	}

	.dt-button-collection button.buttons-columnVisibility span {
	    margin-left:20px;    
	}


	#loader {
	  position: absolute;
	  left: 50%;
	  top: 50%;
	  z-index: 1;
	  width: 150px;
	  height: 150px;
	  margin: -75px 0 0 -75px;
	  border: 16px solid #f3f3f3;
	  border-radius: 50%;
	  border-top: 16px solid #3498db;
	  width: 120px;
	  height: 120px;
	  -webkit-animation: spin 2s linear infinite;
	  animation: spin 2s linear infinite;
	}


	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}
	
	#myDiv {
	  display: none;
	  text-align: center;
	}


	
</style>    

