<?php $resultsCol=array_chunk($servicios,ceil(count($servicios)/3));
foreach ($resultsCol as $col){
echo '<div class="column">';
	echo '<ul class="resultList">';
		foreach ($col as $result){
			echo '<li>';
			echo '<a class="primaryCat" href="'.site_url('directorio/entidad/'.$result->entidades_id.'/'.$result->id).'">'.$result->servicio.'</a>';
			//if($result->modified)
			//	echo '<span class="modified">Última Actualización: '.strftime('%d/%m/%Y',strtotime($result->modified)).'</span>';
			echo '</li>';
		}
	echo '</ul>';
echo '</div>';
}
?>