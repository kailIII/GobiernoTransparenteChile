<?php echo validation_errors(); ?>
<a href="javascript:parserMarcarTodos();">Marcar todos</a> / <a href="javascript:parserMarcarNinguno();">Marcar ninguno</a>
<form method="post" action="<?=current_url()?>">
<div style="overflow: hidden;">

<?php
$resultsCol=array_chunk($entidades,ceil(count($entidades)/2));
foreach ($resultsCol as $entidadescol){
echo '<div class="column">';
echo '<ul class="treeview">';
	foreach($entidadescol as $e){
		echo '<li><input type="checkbox" onclick="javascript:toggleHijos(this);" name="entidades[]" value="'.$e->id.'"  '.set_checkbox('entidades[]',$e->id).' />'.$e->entidad;
		echo '<ul>';
		foreach ($e->servicios as $s)
			echo '<li><input onclick="javascript:togglePadre(this);" name="servicios[]" type="checkbox" value="'.$s->id.'" '.set_checkbox('servicios[]',$s->id).' />'.$s->servicio.'</li>';
		echo '</ul></li>';
	}
	
	
echo '</ul>';
echo '</div>';
}

?>
</div>

<input type="submit" value="Ver Reporte" />
</form>
<?php
if (isset($show_results) && $show_results){
$hidden_cols=array('id','servicios_id');
?>
<h2>Resultados</h2>

<div class="accordion">
	<?php foreach ($result->servicios as $s){
		echo '<h3><a href="#">'.$s->servicio.'<span class="fecha">'.(($s->modified)?strftime('%d/%m/%Y',strtotime($s->modified)):'No identificable').'</span></a></h3>';
		echo '<div>';
		echo '<input style="float: right;" type="image" src="'.base_url().'assets/images/print.png" onclick="javascript:printReport(this);" value="Imprimir" />';
		echo '<p>Fuente original: '.anchor($s->url,$s->url,'target="_blank"').'</p>';
		echo '<h4>Resultado del Parseo:</h4>';
		echo '<table>';
			echo '<tr>';
				echo '<th>Ítem</th>';
				echo '<th>¿Está publicado?</th>';
				echo '<th>Enlace externo</th>';
				echo '<th>Mensaje</th>';
				echo '<th>Error de Lectura</th>';
				//echo '<th>Excluidos</th>';
			echo '</tr>';
			foreach($s->paginas as $key=>$value){
				echo '<tr>';
					echo '<td>'.$this->lang->line($key).'</td>';
					echo '<td>';
					if ($value->tiene_enlace)
						echo '<span class="tick">Si</span>';
					else
						echo '<span class="cross">No</span>';
					echo '</td>';
					echo '<td>';
						echo '<ul class="list">';
						foreach($value->enlace_externo as $x)
							echo '<li><a href="'.$x.'" target="_blank">'.$x.'</a></li>';
						echo '</ul>';
					echo '</td>';
					echo '<td>';
						echo '<ul class="list">';
						foreach($value->con_mensaje as $x)
							echo '<li><a href="'.$x.'" target="_blank">'.$x.'</a></li>';
						echo '</ul>';
					echo '</td>';
					echo '<td>';
						echo '<ul class="list">';
						foreach($value->sin_parsear as $x)
							echo '<li><a href="'.$x.'" target="_blank">'.$x.'</a></li>';
						echo '</ul>';
					echo '</td>';
					//echo '<td>';
					//	echo '<ul class="list">';
					//	foreach($value->blacklisted as $x)
					//		echo '<li><a href="'.$x.'" target="_blank">'.$x.'</a></li>';
					//	echo '</ul>';
					//echo '</td>';
				echo '</tr>';
			}
		echo '</table>';
	if(isset($s->normativa_a6)){
			echo '<h4>'.$this->lang->line('normativa_a6').' '.$s->normativa_a6->ultimo_mes.' '.$s->normativa_a6->ultimo_ano.':</h4>';
			if (isset($s->normativa_a6->registros_sin_enlace)){
				echo '<p>Registros sin enlace ('.count($s->normativa_a6->registros_sin_enlace).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->normativa_a6->registros_sin_enlace[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->normativa_a6->registros_sin_enlace as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else
				echo '<p>Todos los registros contienen enlaces a la publicación o archivo correspondiente.</p>';
		}
		if(isset($s->normativa_a7b)){
			echo '<h4>'.$this->lang->line('normativa_a7b').' '.$s->normativa_a7b->ultimo_mes.' '.$s->normativa_a7b->ultimo_ano.':</h4>';
			if (isset($s->normativa_a7b->registros_sin_enlace)){
				echo '<p>Registros sin enlace ('.count($s->normativa_a7b->registros_sin_enlace).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->normativa_a7b->registros_sin_enlace[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->normativa_a7b->registros_sin_enlace as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else
				echo '<p>Todos los registros contienen enlaces a la publicación o archivo correspondiente.</p>';
		}
		if(isset($s->normativa_a7c)){
			echo '<h4>'.$this->lang->line('normativa_a7c').' '.$s->normativa_a7c->ultimo_mes.' '.$s->normativa_a7c->ultimo_ano.':</h4>';
			if (isset($s->normativa_a7c->registros_sin_enlace)){
				echo '<p>Registros sin enlace ('.count($s->normativa_a7c->registros_sin_enlace).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->normativa_a7c->registros_sin_enlace[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->normativa_a7c->registros_sin_enlace as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
				//echo '<ul class="list">';
				//foreach($s->normativa_a7c->registros_sin_enlace as $r)
				//	echo '<li>'.$r->numero.'</li>';
				//echo '</ul>';
			}
			else
				echo '<p>Todos los registros contienen enlaces a la publicación o archivo correspondiente.</p>';
		}
		if(isset($s->normativa_a7g)){
			echo '<h4>'.$this->lang->line('normativa_a7g').' '.$s->normativa_a7g->ultimo_mes.' '.$s->normativa_a7g->ultimo_ano.':</h4>';
			if (isset($s->normativa_a7g->registros_sin_enlace)){
				echo '<p>Registros sin enlace ('.count($s->normativa_a7g->registros_sin_enlace).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->normativa_a7g->registros_sin_enlace[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->normativa_a7g->registros_sin_enlace as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else
				echo '<p>Todos los registros contienen enlaces a la publicación o archivo correspondiente.</p>';
		}
		if (isset($s->honorarios)){
			echo '<h4>'.$this->lang->line('per_honorarios').' '.$s->honorarios->ultimo_mes.' '.$s->honorarios->ultimo_ano.':</h4>';
			//echo '<p>Total de publicados: '.$s->honorarios->total.'</p>';
			//echo '<p>Total de publicados con sueldo: '.$s->honorarios->total_con_sueldo.'</p>';
			if (isset($s->honorarios->registros_sin_honorario_bruto)){
				echo '<p>Registros sin honorario bruto ('.count($s->honorarios->registros_sin_honorario_bruto).')</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->honorarios->registros_sin_honorario_bruto[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->honorarios->registros_sin_honorario_bruto as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
				
				//echo '<ul class="list">';
				//foreach ($s->honorarios->registros_sin_honorario_bruto as $r)
				//	echo '<li>'.$r->nombres.' '.$r->apellido_paterno.' '.$r->apellido_materno.'</li>';
				//echo '</ul>';
			}
			else
				echo '<p>Todos los registros contienen información correspondiente al honorario bruto mensual.</p>';
		}
		if(isset($s->otras_compras)){
			echo '<h4>'.$this->lang->line('otras_compras').' '.$s->otras_compras->ultimo_ano.':</h4>';
			if (isset($s->otras_compras->registros_incompletos)){
				echo '<p>Registros que no publican socios y accionistas ('.count($s->otras_compras->registros_incompletos).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->otras_compras->registros_incompletos[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->otras_compras->registros_incompletos as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else
				echo '<p>Todos los registros correspondientes a personas jurídicas publican la razón social.</p>';
			if (isset($s->otras_compras->registros_sin_url)){
				echo '<p>Registros sin enlace ('.count($s->otras_compras->registros_sin_url).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->otras_compras->registros_sin_url[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->otras_compras->registros_sin_url as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else
				echo '<p>Todos los registros contienen enlaces a los contratos y a sus modificaciones.</p>';
		}
		if(isset($s->auditorias)){
			echo '<h4>Auditorias '.$this->lang->line('auditorias').' '.$s->auditorias->ultimo_mes.' '.$s->auditorias->ultimo_ano.':</h4>';
			if (isset($s->auditorias->registros_sin_enlace)){
				echo '<p>Registros sin enlace ('.count($s->auditorias->registros_sin_enlace).'):</p>';
				echo '<table>';
					echo '<tr>';
						foreach ($s->auditorias->registros_sin_enlace[0] as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<th>'.$this->lang->line($key).'</td>';
					echo '<tr>';
					foreach ($s->auditorias->registros_sin_enlace as $row){
						echo '<tr>';
						foreach($row as $key=>$val)
							if (!in_array($key,$hidden_cols)) echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
				echo '</table>';
			}
			else
				echo '<p>Todos los registros contienen enlaces al informe final de auditoría</p>';
		}
		
		echo '</div>';
	}?>

</div>



<?php }?>