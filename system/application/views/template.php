<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Gobierno de Chile - Directorio de Transparencia Activa<?php if(isset($title)) echo ' - '.$title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/js/jquery.autocomplete/jquery.autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/style.css" />
	<script type="text/javascript">
		var site_url="<?php echo site_url()?>";
		var base_url="<?php echo base_url()?>";
	</script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.form-defaults/jquery.form-defaults.js"></script>	
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.autocomplete/jquery.autocomplete.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.qtip/jquery.qtip-1.0.0-rc3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/script.js"></script>
</head>

<body>
	<?php if(!(isset($show_bar) && $show_bar==false)){?>
	<?php }?>
	<div id="header_wrap">
		<div id="header">
			<h1 id="logo"><a href="<?php echo site_url()?>">Directorio Probidad y Transparencia</a></h1>
			<?php if(!(isset($show_search) && $show_search==false)){?>
			<div id="searchDiv">
			  <div class="etiqueta">Buscador</div>
<form method="get" action="<?php echo site_url('busqueda/resultados')?>">
		  <div class="caja"> 
		    <input id="searchInput" type="text" name="q" value="<?php if(isset($q))echo $q?>" />
					    <input type="submit" value="Buscar" />
					    <p><a id="busquedaAvanzadaAnchor" href="<?=site_url('busqueda/avanzada') ?>">Búsqueda avanzada</a> </p>
					</div>
					<!-- <div <?php if (current_url()==site_url()) echo 'class="hiddenUntilMouseOver"';?>><label>Buscar en: </label><input type="radio" id="radioGlobal" name="buscarpor" value="global" <?php if(!isset($buscarpor) || (isset($buscarpor) && $buscarpor=='global')) echo 'checked="checked"' ?> /> <label for="radioGlobal">todo</label> <input type="radio" id="radioGlobal" name="buscarpor" value="personas" <?php if(isset($buscarpor) && $buscarpor=='personas') echo 'checked="checked"' ?> /> <label for="radioGlobal">personas</label> <input type="radio" id="radioServicios" name="buscarpor" value="servicios" <?php if(isset($buscarpor) && $buscarpor=='servicios') echo 'checked="checked"' ?> /> <label for="radioServicios">nombres de servicios</label> </div> -->
				</form>
			</div>
			<?php }?>
			<?php if(!(isset($show_tabs) && $show_tabs==false)){?>
			<ul id="tabs">
				<li <?php if (!$this->uri->segment(2) || $this->uri->segment(2)=='entidad') echo 'class="activeTab"'; ?> ><a href="<?php echo site_url('directorio/entidad') ?>">Por Entidades</a></li>
				<li <?php if ($this->uri->segment(2)=='servicios') echo 'class="activeTab"'; ?>><a href="<?php echo site_url('directorio/servicios') ?>">Por Servicios</a></li>
				<li <?php if ($this->uri->segment(2)=='tags') echo 'class="activeTab"'; ?>><a href="<?php echo site_url('directorio/tags') ?>">Por Tags</a></li>
			</ul>
			<?php }?>
		</div>
	</div>
	<div id="main_wrap">
		<div id="main">
			<?php $this->load->view($content)?>
		</div>
	</div>
        <div style="clear: left;" />
	<div id="footer_wrap">
		<div id="footer">
			<img id="sublogo" src="<?php echo base_url()?>assets/images/sub-logo.png" alt="Probidad y Transparencia. Por un Chile mas transparente." />
			<p>Comisión de Probidad y Transparencia. <br />
		    Teatinos 333, Piso 6.</p>
			<p>Unidad de Modernización y Gobierno Eléctronico.<br />
		    Ministerio Secretaría General de la Presidencia</p>
			<p><?= anchor('pagina/acercade','Acerca de este sitio')?> | <?= anchor('pagina/privacidad','Política de Privacidad')?> | <?= anchor('pagina/faq','Preguntas Frecuentes')?></p>
		</div>
	</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11411442-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<script type="text/javascript">
window.____aParams = {"gobabierto":"1","domain":"http://www.gobiernotransparentechile.cl","width":"95%","icons":"1"};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.modernizacion.cl/barra/js/barraEstado.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

</body>
</html>
