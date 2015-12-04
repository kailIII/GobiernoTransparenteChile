<?php

class Normativa_a7c_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='normativa_a7c';
        $this->search_cols=array('numero','nombre');
    }



}

?>