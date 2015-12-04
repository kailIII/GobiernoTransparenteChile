<ul class="breadcrumb">
	<li><a href="<?php echo site_url('directorio/entidad')?>">Inicio</a></li>
	<li><?php echo $entidad->entidad?></li>
</ul>

<?php $resultsCol=array_chunk($entidad->servicios,ceil(count($entidad->servicios)/3));
foreach ($resultsCol as $col){
echo '<div class="column">';
	echo '<ul class="resultList">';
		foreach ($col as $result){
			echo '<li>';
			echo '<a class="primaryCat" href="'.site_url('directorio/entidad/'.$entidad->id.'/'.$result->id).'">'.$result->servicio.'</a>';
			//if($result->modified)
			//	echo '<span class="modified">Última Actualización: '.strftime('%d/%m/%Y',strtotime($result->modified)).'</span>';
			echo '</li>';
		}
	echo '</ul>';
echo '</div>';
}
?>