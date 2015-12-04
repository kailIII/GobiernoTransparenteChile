<?php foreach ($results as $result){?>
<h2><?php echo $result->servicio?> (<a target="_blank" href="<?php echo $result->url?>">Ver</a>)</h2>
<table class="tabla">
	<thead>
		<tr>
			<th>Pagina</th>
			<th>URL</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result->paginas as $pagina){
			echo '<tr>';
				echo '<td>'.$pagina->nombre.'</td>';
				echo '<td><a target="_blank" href="'.$pagina->url.'">'.$pagina->url.'</a></td>';
				echo '<td>'.$pagina->status.'</td>';
			echo '</tr>';
		}
		
		?>
	</tbody>
</table>
<?php }?>
