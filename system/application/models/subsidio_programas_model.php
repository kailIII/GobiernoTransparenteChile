<?php
class Subsidio_programas_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='subsidio_programas';
        $this->search_cols=array('nombre','fuente_legal','criterio');
    }
    
}
?>