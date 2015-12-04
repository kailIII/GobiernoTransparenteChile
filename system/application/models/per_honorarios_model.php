<?php

class Per_honorarios_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='per_honorarios';
        $this->search_cols=array('apellido_paterno','apellido_materno','nombres');
    }



}

?>