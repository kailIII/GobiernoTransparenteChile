<?php

class Facultades_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='facultades';
        $this->search_cols=array('unidad','facultades','fuente_legal');
    }



}

?>