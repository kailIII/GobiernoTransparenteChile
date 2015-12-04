<h2>Resultados de Búsqueda</h2>
<?php echo validation_errors(); ?>
<?php 
if (empty($results_entidades) && empty($results_servicios)){
	echo '<h3>No se encontraron resultados</h3>';
}
else{
	if (!empty($results_entidades)){
		echo '<h3>Resultados en Entidades</h3>';
		echo '<ul class="searchResults">';
			foreach ($results_entidades as $result)
				echo '<li><a href="'.site_url('directorio/entidad/'.$result->id).'">'.$result->entidad.'</a></li>';
		echo '</ul>';
	}
	if (!empty($results_servicios)){
		echo '<h3>Resultados en Servicios</h3>';
		echo '<ul class="searchResults">';
			foreach ($results_servicios as $result)
				echo '<li><a href="'.site_url('directorio/entidad/'.$result->entidades_id.'/'.$result->id).'">'.$result->servicio.'</a></li>';
		echo '</ul>';
	}
}
?>