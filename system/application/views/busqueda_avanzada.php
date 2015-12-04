<?php echo validation_errors(); ?>
<form method="get" action="<?=site_url('busqueda/resultados') ?>" id="busquedaAvanzadaForm">
	<fieldset>
		<label>Buscar datos según las siguientes palabras:</label><br />
		<input id="searchInput" name="q" type="text" />
		<!--<img src="<?=base_url().'assets/images/help.png'?>" class="tooltip" title='Introduzca los terminos de búsqueda.<br /><br />Para buscar una frase, coloquela entre comillas.<br />Ej: "buses urbanos"<br /><br />Para obligar a una palabra a aparecer en la búsqueda, antecedala por el signo +<br />Ej: +transparencia<br /><br />Para evitar que una palabra aparezca en la búsqueda, antecedala por el signo -<br />Ej: -corrupcion' alt="Ayuda" /> -->
	</fieldset>
	<fieldset style="float: left;">
		<label>Seleccione en que entidades desea realizar la búsqueda:</label>
		<div class="selectionBox">
			<div class="selectAllEntidadesDiv"><input type="checkbox" name="entidades[]" value="*" checked="checked"><label>Todas las entidades</label></div>
			<?php foreach($entidades as $e)
				echo '<div class="selectEntidadesDiv"><input type="checkbox" name="entidades[]" value="'.$e->id.'" ><label>'.$e->entidad.'</label></div>';
			?>
		</div>
	</fieldset>
	<fieldset style="float: left;">
		<label>Seleccione en que categorías desea realizar la búsqueda:</label>
		<div class="selectionBox">
			<div class="selectAllCategoriasDiv"><input type="checkbox" name="categorias[]" value="*" checked="checked"><label>Todas las categorías</label></div>
			<?php foreach ($categorias as $c)
				echo '<div class="selectCategoriasDiv"><input type="checkbox" name="categorias[]" value="'.$c.'" ><label>'.$this->lang->line($c).'</label></div>';
			?>
		</div>
	</fieldset>
	<input type="hidden" name="buscarpor" value="avanzada" />
	<input type="submit" value="Buscar" />
</form>

