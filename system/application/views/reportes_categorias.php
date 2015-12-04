<?php echo validation_errors(); ?>
<a href="javascript:parserMarcarTodos();">Marcar todos</a> / <a href="javascript:parserMarcarNinguno();">Marcar ninguno</a>
<form method="post" action="<?=current_url()?>">
<div style="overflow: hidden;">

<?php
echo '<div class="column">';
echo '<ul class="treeview">';
	foreach($categorias as $categoria=>$paginas){
		echo '<li><input type="checkbox" onclick="javascript:toggleHijos(this);" name="categorias[]" value="'.$categoria.'"  '.set_checkbox('categorias[]',$categoria).' />'.$this->lang->line($categoria);
		echo '<ul>';
		foreach ($paginas as $pagina)
			echo '<li><input onclick="javascript:togglePadre(this);" name="paginas[]" type="checkbox" value="'.$pagina.'" '.set_checkbox('paginas[]',$pagina).' />'.$this->lang->line($pagina).'</li>';
		echo '</ul></li>';
	}
	
	
echo '</ul>';
echo '</div>';

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
	<?php foreach ($result->paginas as $key=>$value){
		echo '<h3><a href="#">'.$this->lang->line($key).'</a></h3>';
		echo '<div>';
		echo '<input style="float: right;" type="image" src="'.base_url().'assets/images/print.png" onclick="javascript:printReport(this);" value="Imprimir" />';
		if(isset($value->sin_enlace)){
			echo '<h4>Servicios que no tienen enlace a esta categoría:</h4>';
			echo '<ul class="list">';
			foreach($value->sin_enlace as $x)
				echo '<li><p><a target="_blank" href="'.$x->servicios_url.'">'.$x->servicio.'</a></p></li>';
			echo '</ul>';
		}
		if(isset($value->parseo_fallido)){
			echo '<h4>Servicios a los que no se les pudo parsear esta categoría:</h4>';
			echo '<ul class="list">';
			foreach($value->parseo_fallido as $x)
				echo '<li><p><a target="_blank" href="'.$x->url.'">'.$x->servicio.'</a> ('.$x->parsed.')</p></li>';
			echo '</ul>';
		}
		
		echo '</div>';
	}?>

</div>


<?php }?>