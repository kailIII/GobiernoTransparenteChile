

<?php if(isset($results)){?>
<a href="#" name="resultados"></a>
<h2>Resultados de la búsqueda:</h2>
<?php $hidden_cols=array('id','servicios_id','entidades_id','directorio_id')?>
<?php
echo '<p>Número de resultados: '.$nresults.'</p>';
if(!empty($results->entidades) || !empty($results->servicios)){
	echo '<div class="cont-entidades">';
}
if (!empty($results->entidades)){
	echo '<h3>Entidades</h3>';
	echo '<ul class="searchResults">';
		foreach ($results->entidades as $result)
			echo '<li><a href="'.site_url('directorio/entidad/'.$result->id).'">'.$result->entidad.'</a></li>';
	echo '</ul>';
}

if (!empty($results->servicios)){
	echo '<h3>Servicios</h3>';
	echo '<ul class="searchResults">';
		foreach ($results->servicios as $result)
			echo '<li><a href="'.site_url('directorio/entidad/'.$result->entidades_id.'/'.$result->id).'">'.$result->servicio.'</a></li>';
	echo '</ul>';
}
if(!empty($results->entidades) || !empty($results->servicios)){
	echo '</div>';
}
?>
<?php if(!$sub_categoria_input){ ?>
	<div class="cont-materias">
		<h3>Por Materia</h3>
		<ul class="searchResults">
			<?php foreach ($results->contenido as $cat=>$results_cat){ ?>	
				<?php if ($results_cat): ?>
					<li>(<span><?php echo $results->totales[$cat]; ?></span>) <a href="#<?php echo $cat; ?>"><?php echo $this->lang->line($cat); ?></a></li>	
				<?php endif ?>
			<?php } ?>
		</ul>
	</div>
<?php } ?>
<div class="clearfix"></div>
<?php
foreach ($results->contenido as $cat=>$results_cat){
	if (!empty($results_cat)){
?>
<h3 id="<?php echo $cat; ?>"><?=$this->lang->line($cat)?></h3>
<?php if($sub_categoria_input){ ?>
	<?php $url_busqueda = 'busqueda/resultados?q='.$q.'&sub-categoria='.$sub_categoria_input; ?>
	<?php
	  if ($number_of_pages > 1) {
	    echo '<ul class="pagination">';
	    if ($page_number != 1) //Si no es la primera pagina
	      echo '<li>' . anchor( $url_busqueda . '&page_number=' . ($page_number - 1) , 'Anterior', 'class="anterior"') . '</li>';
	    for ($i = 1; $i <= $number_of_pages; $i++) {
	      if ($i == $page_number)
	        echo '<li class="activo">' . $i . '</li>';
	      else
	        echo '<li>' . anchor($url_busqueda . '&page_number=' . $i , $i) . '</li>';
	    }
	    if ($page_number != $number_of_pages) //Si no es la ultima pagina
	      echo '<li>' . anchor($url_busqueda . '&page_number=' . ($page_number + 1) , 'Siguiente', 'class="siguiente"') . '</li>';
	    echo '</ul>';
	  }
	?>
<?php } ?>
<table>
	<thead>
		<tr>
			<?php foreach ($results_cat[0] as $nombre_columna=>$value)
				if (!in_array($nombre_columna,$hidden_cols))
					echo '<th class="'.$nombre_columna.'">'.$this->lang->line($nombre_columna).'</th>';
					
			?>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($results_cat as $result){
			echo '<tr>';
			foreach ($result as $nombre_columna=>$value){
				if (!in_array($nombre_columna,$hidden_cols)){
					if ($value!=NULL){
						if ($nombre_columna=='url' || $nombre_columna=='url_informe' || $nombre_columna=='url_documento_respuesta' || $nombre_columna=='url_mayor_informacion' || $nombre_columna=='url_nomina_beneficiarios')
							echo '<td>'.$value.'</td>';
						else if ($nombre_columna=='fecha_de_publicacion' || $nombre_columna=='fecha_de_inicio' || $nombre_columna=='fecha_de_termino' || $nombre_columna=='fecha_del_acto' || $nombre_columna=='inicio_del_contrato' || $nombre_columna=='termino_del_contrato')
							if($value=='9999-12-31')
								echo '<td>Indefinido</td>';
							else
								echo '<td>'.strftime('%d/%m/%Y',strtotime($value)).'</td>';
						else if ($nombre_columna=='honorario_bruto_mensual' || $nombre_columna=='total_remuneracion_bruta')
							echo '<td>'.number_format($value,0,',','.').'</td>';
						else if ($nombre_columna=='mes')
							echo '<td>'.strftime('%B',mktime(0,0,0,$value)).'</td>';
						else if ($nombre_columna=='grado_eus')
							echo '<td>'.anchor('directorio/entidad/'.$result['entidades_id'].'/'.$result['servicios_id'].'/per_remuneraciones',$value).'</td>';
						else if ($nombre_columna=='servicio')
							echo '<td>'.anchor('directorio/entidad/'.$result['entidades_id'].'/'.$result['servicios_id'],$value).'</td>';
						else if (in_array($nombre_columna, array('servicio','subseccion1','subseccion2')))
							echo '<td>'.strip_tags($value).'</td>';
						else
							echo '<td>'.$value.'</td>';
					}
					else
						echo '<td></td>';
				}
			}
			echo '<tr>';
		}
		?>
		<?php if ($results->totales[$cat] > $limit): ?>
			<tr>
				<?php if (!$sub_categoria_input): ?>
					<td colspan="<?php echo count($result); ?>" align="center"><a href="<?php echo site_url('busqueda/resultados?q='.$q.'&sub-categoria='.$cat); ?>"><b>Ver más resultados</b></a></td>
				<?php endif ?>
			</tr>
		<?php endif ?>
	</tbody>
</table>
<?php }?>
<?php }?>
<?php }?>