<h2>Seleccione los servicios que desea parsear</h2>
<a href="javascript:parserMarcarTodos();">Marcar Todos</a> / <a href="javascript:parserMarcarNinguno();">Marcar Ninguno</a>
<div><input type="button" value="Parsear" onclick="javascript:parse();" /></div>
<div style="overflow: hidden;font-size: 10px;">

<div style="float:left; width:400px;">
<?php for($i=0; $i<count($servicios)/3; $i++){
	echo '<input class="servicio_check" type="checkbox" value="'.$servicios[$i]->id.'" checked="checked" />';
	echo $servicios[$i]->servicio;
	echo '<br />';
}

?>
</div>
<div style="float:left; width:400px;">
<?php for($i=1+count($servicios)/3; $i<2*(count($servicios)/3); $i++){
	echo '<input class="servicio_check" type="checkbox" value="'.$servicios[$i]->id.'" checked="checked" />';
	echo $servicios[$i]->servicio;
	echo '<br />';
}

?>
</div>
<div style="float:left; width:400px;">
<?php for($i=1+2*(count($servicios)/3); $i<count($servicios); $i++){
	echo '<input class="servicio_check" type="checkbox" value="'.$servicios[$i]->id.'" checked="checked" />';
	echo $servicios[$i]->servicio;
	echo '<br />';
}

?>
</div>
</div>

<input type="button" value="Parsear" onclick="javascript:parse();" />

<div id="results"></div>