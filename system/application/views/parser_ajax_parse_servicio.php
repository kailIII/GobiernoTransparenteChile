<h2><?php echo $result->servicio?> (<a target="_blank" href="<?php echo $result->url?>">Ver</a>)</h2>
<p>Paginas Indexadas</p>
<ul>
<?php foreach($paginas_indexadas as $pag)
	echo '<li>'.$pag->pagina.' : <a href="'.$pag->url.'">'.$pag->url.'</a></li>';
?>
</ul>

<p>Paginas Parseadas</p>
<table class="tabla">
	<thead>
		<tr>
			<th>Pagina</th>
			<th>Observaciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result->paginas as $pagina){
			echo '<tr>';
				echo '<td>'.$pagina->nombre.'</td>';
				echo '<td><ul>';
				foreach($pagina->results as $r)
					echo '<li><a href="'.$r->url.'">'.$r->url.'</a>: '.$r->status.'</li>';
				echo '</ul></td>';
			echo '</tr>';
		}
		
		?>
	</tbody>
</table>
