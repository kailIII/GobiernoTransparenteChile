<ul class="breadcrumb">
	<li><a href="<?php echo site_url('directorio/entidad')?>">Inicio</a></li>
	<li><a href="<?php echo site_url('directorio/entidad/'.$entidad->id)?>"><?php echo $entidad->entidad?></a></li>
	<li><?php echo $servicio->servicio?></li>
</ul>
<div style="overflow:hidden; font-size: 12px;">
	<a style="float:left;" target="_blank" href="<?= $servicio->url?>">Fuente desde donde fueron obtenidos los datos</a><img class="tooltip external" src="<?=base_url()?>assets/images/external.png" alt="" title="Enlace a sitio externo" />
	<?php if($servicio->modified) echo '<span style="float: right;">Última actualización que publica el organismo: '.strftime('%d/%m/%Y',strtotime($servicio->modified)).'</span>';?>
</div>
	
<div style="overflow: hidden;">
<?php 
$resultsCol[0]=array('marco_normativo','actos_y_resoluciones','estructura_organica','dotacion_de_personal');
$resultsCol[1]=array('compras_y_adquisiciones','transferencias_cat','presupuesto','auditorias_cat');
//Se removio gestion_de_solicitudes_cat momentaneamente.
$resultsCol[2]=array('tramites','participacion_ciudadana','subsidios_y_beneficios','vinculos_cat');
$resultsCol[3]=array('solicitud_informacion_cat', 'costos_de_reproduccion_cat','ley20416_cat', 'ley20285_cat');

foreach ($resultsCol as $col){
	echo '<div class="column_4">';
	foreach($col as $categoria){
		$hay_items=false;
		echo '<div class="widget">';
		echo '<div class="widgetHeader">'.$this->lang->line($categoria).'</div>';
		echo '<div class="widgetBody">';
		echo '<ul>';
		foreach ($servicio->paginas as $pagina){
			if ($pagina->categoria==$categoria && $pagina->url){
				echo '<li>';
				if($pagina->external)$target='target="_blank"'; else $target='';
				echo '<a '.$target.' href="'.$pagina->url.'">'.$this->lang->line($pagina->pagina).'</a>';
				if ($pagina->external) echo '<img class="tooltip external" src="'.base_url().'assets/images/external.png" alt="" title="Enlace a sitio externo" />';
				echo '</li>';
				$hay_items=true;
			}
		}
		if (!$hay_items)
			echo '<li>No es posible acceder a la información</li>';
		echo '</ul>';
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';
}

?>
</div>

<?php if ($servicio->info){
	echo '<div class="infoServicio">';
	echo $servicio->info;
	echo '</div>';
}
?>