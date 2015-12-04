<?php //$max_fontsize=50;

echo '<div class="tagcloud">';
foreach($tags as $t)
	echo '<a href="'.site_url('busqueda/resultados?buscarpor=personas&q='.urlencode($t->busqueda)).'" class="tag" style="font-size: '.$t->fontsize.'px;">'.$t->busqueda.'</a>';
echo '</div>';
?>