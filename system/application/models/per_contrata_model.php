<?php

class Per_contrata_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='per_contrata';
        $this->search_cols=array('apellido_paterno','apellido_materno','nombres');
    }



}

?>