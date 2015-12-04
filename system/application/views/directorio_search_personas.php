<h2>Resultados de Búsqueda</h2>
<?php if (empty($matches_honorarios) && empty($matches_contrata) && empty($matches_planta))
	echo '<h3>No se encontraron resultados</h3>';
?>

<?php if (!empty($matches_planta)){?>
<h3>Personal de Planta</h3>
<table>
	<thead>
		<tr>
		<th>Estamento</th>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Nombres</th>
		<th>Grado EUS</th>
		<th>Cargo</th>
		<th>Región</th>
		<th>Inicio Contrato</th>
		<th>Término de Contrato</th>
		<th>Servicio</th>
		<th>Mes Publicación</th>
		<th>Año Publicación</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($matches_planta as $match){
			echo '<tr>';
			echo '<td>'.$match->estamento.'</td>';
			echo '<td>'.$match->apellido_paterno.'</td>';
			echo '<td>'.$match->apellido_materno.'</td>';
			echo '<td>'.$match->nombres.'</td>';
			
			if ($match->grado_eus)
				echo '<td>'.anchor('directorio/entidad/'.$match->entidades_id.'/'.$match->servicios_id.'/per_remuneraciones',$match->grado_eus).'</td>';
			else
				echo '<td></td>';
			echo '<td>'.$match->cargo.'</td>';
			echo '<td>'.$match->region.'</td>';
			if($match->fecha_de_inicio==NULL)
				echo '<td></td>';
			else
				echo '<td>'.strftime('%d/%m/%Y',strtotime($match->fecha_de_inicio)).'</td>';
			if($match->fecha_de_termino==NULL)
				echo '<td></td>';
			else if($match->fecha_de_termino=='9999-12-31')
				echo '<td>Indefinido</td>';
			else
				echo '<td>'.strftime('%d/%m/%Y',strtotime($match->fecha_de_termino)).'</td>';
			if ($match->servicio)
				echo '<td>'.anchor('directorio/entidad/'.$match->entidades_id.'/'.$match->servicios_id,$match->servicio).'</td>';
			else
				echo '<td></td>';
			if ($match->mes)
				echo '<td>'.strftime('%B',mktime(0,0,0,$match->mes)).'</td>';
			else
				echo '<td></td>';
			echo '<td>'.$match->ano.'</td>';
			echo '</tr>';
		}?>
	</tbody>
</table>

<?php }?>

<?php if (!empty($matches_contrata)){?>
<h3>Personal a Contrata</h3>
<table>
	<thead>
		<tr>
		<th>Estamento</th>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Nombres</th>
		<th>Grado EUS</th>
		<th>Cargo</th>
		<th>Región</th>
		<th>Inicio Contrato</th>
		<th>Término de Contrato</th>
		<th>Servicio</th>
		<th>Mes Publicación</th>
		<th>Año Publicación</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($matches_contrata as $match){
			echo '<tr>';
			echo '<td>'.$match->estamento.'</td>';
			echo '<td>'.$match->apellido_paterno.'</td>';
			echo '<td>'.$match->apellido_materno.'</td>';
			echo '<td>'.$match->nombres.'</td>';
			
			if ($match->grado_eus)
				echo '<td>'.anchor('directorio/entidad/'.$match->entidades_id.'/'.$match->servicios_id.'/per_remuneraciones',$match->grado_eus).'</td>';
			else
				echo '<td></td>';
			echo '<td>'.$match->cargo.'</td>';
			echo '<td>'.$match->region.'</td>';
			if($match->fecha_de_inicio==NULL)
				echo '<td></td>';
			else
				echo '<td>'.strftime('%d/%m/%Y',strtotime($match->fecha_de_inicio)).'</td>';
			if($match->fecha_de_termino==NULL)
				echo '<td></td>';
			else if($match->fecha_de_termino=='9999-12-31')
				echo '<td>Indefinido</td>';
			else
				echo '<td>'.strftime('%d/%m/%Y',strtotime($match->fecha_de_termino)).'</td>';
			if ($match->servicio)
				echo '<td>'.anchor('directorio/entidad/'.$match->entidades_id.'/'.$match->servicios_id,$match->servicio).'</td>';
			else
				echo '<td></td>';
			if ($match->mes)
				echo '<td>'.strftime('%B',mktime(0,0,0,$match->mes)).'</td>';
			else
				echo '<td></td>';
			echo '<td>'.$match->ano.'</td>';
			echo '</tr>';
		}?>
	</tbody>
</table>

<?php }?>

<?php if (!empty($matches_honorarios)){?>
<h3>Personal a Honorarios</h3>
<table>
	<thead>
		<tr>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Nombres</th>
		<th>Honorario Bruto</th>
		<th>Inicio Contrato</th>
		<th>Término de Contrato</th>
		<th>Servicio</th>
		<th>Mes Publicación</th>
		<th>Año Publicación</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($matches_honorarios as $match){
			echo '<tr>';
			echo '<td>'.$match->apellido_paterno.'</td>';
			echo '<td>'.$match->apellido_materno.'</td>';
			echo '<td>'.$match->nombres.'</td>';
			if($match->honorario_bruto_mensual)
				echo '<td>'.number_format($match->honorario_bruto_mensual,0,',','.').'</td>';
			else
				echo '<td></td>';
			if($match->fecha_de_inicio==NULL)
				echo '<td></td>';
			else
				echo '<td>'.strftime('%d/%m/%Y',strtotime($match->fecha_de_inicio)).'</td>';
			if($match->fecha_de_termino==NULL)
				echo '<td></td>';
			else if($match->fecha_de_termino=='9999-12-31')
				echo '<td>Indefinido</td>';
			else
				echo '<td>'.strftime('%d/%m/%Y',strtotime($match->fecha_de_termino)).'</td>';
			if ($match->servicio)
				echo '<td>'.anchor('directorio/entidad/'.$match->entidades_id.'/'.$match->servicios_id,$match->servicio).'</td>';
			if ($match->mes)
				echo '<td>'.strftime('%B',mktime(0,0,0,$match->mes)).'</td>';
			else
				echo '<td></td>';
			echo '<td>'.$match->ano.'</td>';
			echo '</tr>';
		}?>
	</tbody>
</table>

<?php }?>



