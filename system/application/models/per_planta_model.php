<?php

class Per_planta_model extends Planillas_model {

    function __construct() {
        parent::__construct();

        $this->nombre_tabla='per_planta';
        $this->search_cols=array('apellido_paterno','apellido_materno','nombres');
    }



}

?>