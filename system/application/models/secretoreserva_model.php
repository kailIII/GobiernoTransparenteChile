<?php
class Secretoreserva_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='secretoreserva';
        $this->search_cols=array('nombre_secreto','nombre_acto','identificacion_acto');
    }
    
    
 
}
?>