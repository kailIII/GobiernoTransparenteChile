<?php $hidden_cols = array('id', 'directorio_id') ?>

<ul class="breadcrumb">
    <li><a href="<?php echo site_url('directorio/entidad') ?>">Inicio</a></li>
    <li><a href="<?php echo site_url('directorio/entidad/' . $entidad->id) ?>"><?php echo $entidad->entidad ?></a></li>
    <li><a href="<?php echo site_url('directorio/entidad/' . $entidad->id . '/' . $servicio->id) ?>"><?php echo $servicio->servicio ?></a></li>
    <li><a href="<?php echo site_url('directorio/entidad/' . $entidad->id . '/' . $servicio->id . '/' . $pagina) ?>"><?php echo $this->lang->line($pagina) ?></a></li>
    <?php
    if ($subseccion1 && $subseccion2)
        echo '<li><a href="' . site_url('directorio/entidad/' . $entidad->id . '/' . $servicio->id . '/' . $pagina . '/' . $subseccion1) . '">' . $subseccion1 . '</a></li>';
    else if ($subseccion1 && !$subseccion2)
        echo '<li>' . $subseccion1 . '</li>';
    ?>
    <?= $subseccion2 ? '<li>' . $subseccion2 . '</li>' : '' ?>
</ul>
<p><a target="_blank" href="<?= $directorio->url ?>">Fuente desde donde fueron obtenidos los datos</a><img class="tooltip external" src="<?= base_url() ?>assets/images/external.png" alt="" title="Enlace a sitio externo" /></p>
    <?php if (isset($message)) {
 ?>
    <p><?= $message ?></p>
<?php } else if (!empty($results)) { ?>
        <p><?= str_replace('nombre_del_organismo', $servicio->servicio, $this->lang->line('header_' . $pagina)) ?></p>
<?php
        if ($number_of_pages > 1) {
            echo '<ul class="pagination">';
            if ($page_number != 1) //Si no es la primera pagina
                echo '<li>' . anchor($this->uri->uri_string() . '?x=0&y=0&page_number=' . ($page_number - 1) . '&sort=' . $sort . '&direction=' . $direction, 'Anterior', 'class="anterior"') . '</li>';
            for ($i = 1; $i <= $number_of_pages; $i++) {
                if ($i == $page_number)
                    echo '<li class="activo">' . $i . '</li>';
                else
                    echo '<li>' . anchor($this->uri->uri_string() . '?x=0&y=0&page_number=' . $i . '&sort=' . $sort . '&direction=' . $direction, $i) . '</li>';
            }
            if ($page_number != $number_of_pages) //Si no es la ultima pagina
                echo '<li>' . anchor($this->uri->uri_string() . '?x=0&y=0&page_number=' . ($page_number + 1) . '&sort=' . $sort . '&direction=' . $direction, 'Siguiente', 'class="siguiente"') . '</li>';
            echo '</ul>';
        }
?>

        <table>
            <thead>
                <tr>
            <?php
            foreach ($results[0] as $nombre_columna => $value)
                if (!in_array($nombre_columna, $hidden_cols)) {
                    if ($nombre_columna == $sort)
                        if ($direction == 'asc')
                            $new_direction = 'desc';
                        else
                            $new_direction='asc';
                    else
                        $new_direction='desc';

                    echo '<th><a href="' . site_url($this->uri->uri_string() . '?x=0&y=0&page_number=' . $page_number . '&sort=' . $nombre_columna . '&direction=' . $new_direction) . '">' . $this->lang->line($nombre_columna) . '</a></th>';
                }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($results as $result) {
                echo '<tr>';
                foreach ($result as $nombre_columna => $value)
                    if (!in_array($nombre_columna, $hidden_cols)) {
                        //if ($value != NULL) {
                            //if (strpos($nombre_columna,'url')===0)
                            //	echo '<td><a class="download" title="Descargar" href="'.$value.'">Descargar</a></td>';
                            if (strpos($nombre_columna, 'fecha') === 0 || $nombre_columna == 'inicio_del_contrato' || $nombre_columna == 'termino_del_contrato') {
                                if ($value == '9999-12-31')
                                    echo '<td>Indefinido</td>';
                                else if($nombre_columna=='fecha_modificacion' && $value==NULL)
                                    echo '<td>Sin modificaciones</td>';
                                else if($value==NULL)
                                    echo '<td></td>';
                                else
                                    echo '<td>' . strftime('%d/%m/%Y', strtotime($value)) . '</td>';
                            }

                            else if ($nombre_columna == 'honorario_bruto_mensual' || $nombre_columna == 'total_remuneracion_bruta' || $nombre_columna == 'remuneracion_bruta_mensualizada')
                                echo '<td>' . number_format($value, 0, ',', '.') . '</td>';
                            //else if ($nombre_columna == 'grado_eus' && $url_remuneraciones && $value)
                            //    echo '<td>' . anchor($url_remuneraciones, $value) . '</td>';
                            else
                                echo '<td>' . $value . '</td>';
                        //}
                        //else
                        //    echo '<td></td>';
                    }
                echo '<tr>';
            }
        ?>
        </tbody>
    </table>

<?= $directorio->footnotes ? '<p>' . $directorio->footnotes . '</p>' : '' ?>

<?php
            if ($number_of_pages > 1) {
                echo '<ul class="pagination">';
                if ($page_number != 1) //Si no es la primera pagina
                    echo '<li>' . anchor($this->uri->uri_string() . '?x=0&y=0&page_number=' . ($page_number - 1) . '&sort=' . $sort . '&direction=' . $direction, 'Anterior', 'class="anterior"') . '</li>';
                for ($i = 1; $i <= $number_of_pages; $i++) {
                    if ($i == $page_number)
                        echo '<li class="activo">' . $i . '</li>';
                    else
                        echo '<li>' . anchor($this->uri->uri_string() . '?x=0&y=0&page_number=' . $i . '&sort=' . $sort . '&direction=' . $direction, $i) . '</li>';
                }
                if ($page_number != $number_of_pages) //Si no es la ultima pagina
                    echo '<li>' . anchor($this->uri->uri_string() . '?x=0&y=0&page_number=' . ($page_number + 1) . '&sort=' . $sort . '&direction=' . $direction, 'Siguiente', 'class="siguiente"') . '</li>';
                echo '</ul>';
            }
?>

<?php if($this->lang->line('footer_' . $pagina) != ''){ ?>
	<p><?= $this->lang->line('footer_' . $pagina) ?></p>
<?php } ?>

<?php } ?>

            
<?php if ($servicio->info){
	echo '<div class="infoServicio">';
	echo $servicio->info;
	echo '</div>';
}
?>