<table>
	<thead>
		<tr>
			<th>Rol</th>
			<th>Tipo de Caso</th>
			<th>Fecha Despacho</th>
			<th>Reclamante</th>
			<th>Reclamado</th>
                        <th>Decisión</th>
                        <th>Enlace</th>
                        <th>Descripción</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($decisiones as $a){
		echo '<tr>';
		echo '<td>'.$a->rol.'</td>';
		echo '<td>'.$a->tipo_de_caso.'</td>';
		echo '<td>'.$a->fecha_despacho.'</td>';
		echo '<td>'.$a->reclamante.'</td>';
                echo '<td>'.$a->reclamado.'</td>';
                echo '<td>'.$a->decision.'</td>';
		echo '<td><a class="download" title="Descargar" href="'.$a->url.'">Descargar</a></td>';
                echo '<td>'.$a->descripcion.'</td>';
		echo '</tr>';
	}
	
	?>
	</tbody>
</table>