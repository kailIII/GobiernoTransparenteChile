<?php
class Vinculos_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='vinculos';
        $this->search_cols=array('entidad','descripcion','fuente_legal');
    }
    

}
?>