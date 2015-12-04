<?php

class Normativa_a6_2_model extends Planillas_model {

    function __construct() {
        parent::Model();

        $this->nombre_tabla='normativa_a6_2';
        $this->search_cols=array('potestad','fuente_legal');
    }



}

?>