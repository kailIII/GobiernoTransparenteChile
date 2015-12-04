<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>GobiernoTransparente - <?php echo $title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/js/jquery.autocomplete/jquery.autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/style.css" />
	<script type="text/javascript">
		var site_url="<?php echo site_url()?>";
		var base_url="<?php echo base_url()?>";
	</script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.autocomplete/jquery.autocomplete_post.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/script_parser.js"></script>
</head>

<body>

        <div id="header_wrap">
		<div id="header">
			<h1 id="logo"><a href="<?php echo site_url()?>">Directorio Probidad y Transparencia</a></h1>
            <div class="logout">
                <a style="float:right" href="<?php echo site_url('/usuarios/logout'); ?>">Salir</a>
            </div>
		</div>
	</div>


	<div class="detalle">
		<?php $this->load->view($content) ?>
	</div>
	<div class="footer">
	</div>
</body>
</html>
