<ul class="breadcrumb">
	<li><a href="<?php echo site_url('directorio/entidad')?>">Inicio</a></li>
	<li><a href="<?php echo site_url('directorio/entidad/'.$entidad->id)?>"><?php echo $entidad->entidad?></a></li>
	<li><a href="<?php echo site_url('directorio/entidad/'.$entidad->id.'/'.$servicio->id)?>"><?php echo $servicio->servicio?></a></li>
	<li><?php echo $this->lang->line($pagina)?></li>
</ul>

<div class="linksIntermedios<?php echo isset($subcategoria)?' sub_categorias':''; ?>">
<?php if(!isset($subcategoria)){ ?>
  <h2><?php echo $this->lang->line($pagina)?></h2>
<?php } ?>
<?php

$active_subcategory = '-1';

foreach ($subsecciones as $key=>$val){

	if(isset($subcategoria)){

		if($active_subcategory=='-1'){
			echo '<div class="widget">';
			echo '<div class="widgetHeader">'.$this->lang->line($val->subcategoria).'</div>';
			echo '<ul>';
		}

		if($active_subcategory!='-1' && $active_subcategory != $val->subcategoria){
			echo '</ul></div><div class="widget">';
			echo '<div class="widgetHeader">'.$this->lang->line($val->subcategoria).'</div>';
			echo '<ul>';
		}

	}elseif($active_subcategory=='-1'){
		echo '<ul>';
	}

	echo '<li><a href="'.$val->url.'" '.($val->external?'target=_blank':'').'>'.$key.'</a>';
	if ($val->external) echo '<img class="tooltip external" src="'.base_url().'assets/images/external.png" alt="" title="Enlace a sitio externo" />';
	echo '</li>';
	$active_subcategory = isset($val->subcategoria)?$val->subcategoria:null;

}
//Si existen subcategorias
if (isset($subcategoria)) {
	echo '</ul>';
	echo '</div>';
	echo '<div class="clearfix"></div>';
}else{
	echo '</ul>';
}
?>
</div>


<?php if ($servicio->info){
	echo '<div class="infoServicio">';
	echo $servicio->info;
	echo '</div>';
}
?>