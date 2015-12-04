<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Gobierno de Chile - Directorio de Transparencia Activa<?php if(isset($title)) echo ' - '.$title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/js/jquery-ui-1.7.2/css/start/jquery-ui-1.7.2.custom.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/js/jquery.treeview/jquery.treeview.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/style_reportes.css" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo base_url()?>assets/css/print_reportes.css" />
	<script type="text/javascript">
		var site_url="<?php echo site_url()?>";
		var base_url="<?php echo base_url()?>";
	</script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui-1.7.2/js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.treeview/jquery.treeview.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.jqprint/jquery.jqprint.0.3.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/script_reportes.js"></script>
</head>

<body>

	<div id="header_wrap">
		<div id="header">
			<h1 id="logo"><a href="<?php echo site_url()?>">Directorio Probidad y Transparencia</a></h1>


		</div>
	</div>
	<div id="main_wrap">
		<div id="main">
			<?php $this->load->view($content)?>
		</div>
	</div>
	<div id="footer_wrap">
		<div id="footer">
			<img id="sublogo" src="<?php echo base_url()?>assets/images/sub-logo.png" alt="Probidad y Transparencia. Por un Chile mas transparente." />
			<p>Comisión de Probidad y Transparencia. Alameda 1370, oficina 201.<br />
			Ministerio Secretaría General de la Presidencia</p>
			<p><?= anchor('pagina/acercade','Acerca De')?> | <?= anchor('pagina/privacidad','Política de Privacidad')?> | <?= anchor('pagina/faq','Preguntas Frecuentes')?></p>
		</div>
	</div>



</body>
</html>
