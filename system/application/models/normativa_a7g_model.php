<?php

class Normativa_a7g_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='normativa_a7g';
        $this->search_cols=array('numero','nombre');
    }



}

?>