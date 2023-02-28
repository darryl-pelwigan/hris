<html>
<head>	
<meta charset="utf-8">
<!-- Favicon -->
<link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/datatables.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/estyles_pdf.css">
</head>
<body>
<div id="page-wrapper">
		<?=$subjec_data?>
		<?=$grades['table']?>
		<?=$grades2['table']?>
		<?=$grades3['table']?>
</div>
</body>
</html>
</html>