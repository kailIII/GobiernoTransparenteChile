<?php

class Normativa_a6_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='normativa_a6';
        $this->search_cols=array('numero','nombre');
    }



}

?>