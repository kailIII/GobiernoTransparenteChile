<?php

class Codtrabajo_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='codtrabajo';
        $this->search_cols=array('apellido_paterno','apellido_materno','nombres');
    }



}

?>