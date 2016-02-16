<?php $resultsCol=array_chunk($entidades,ceil(count($entidades)/3));
foreach ($resultsCol as $col){
echo '<div class="column">';
	echo '<ul class="resultList">';
		foreach ($col as $result){
			echo '<li>';
			echo '<a class="primaryCat" href="'.site_url('directorio/entidad/'.$result->id).'">'.$result->entidad.'</a><br />';
			for ($i=0;$i<3 && $i<count($result->servicios);$i++)
				echo '<a class="secondaryCat" href="'.site_url('directorio/entidad/'.$result->id.'/'.$result->servicios[$i]->id).'">'.$result->servicios[$i]->servicio.'</a>, ';
			echo ' <a style="text-decoration: none;" href="'.site_url('directorio/entidad/'.$result->id).'">...</a>';
			echo '</li>';
			
		}
	echo '</ul>';
echo '</div>';
}
?>