<?php
class Ciudadana_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='ciudadana';
        $this->search_cols=array('nombre','descripcion','proposito','participantes');
    }
    
}
?>