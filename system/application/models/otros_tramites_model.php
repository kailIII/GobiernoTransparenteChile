<?php
class Otros_tramites_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='otros_tramites';
        $this->search_cols=array('nombre','descripcion','a_quien_esta_dirigido','donde_se_realiza');
    }
    
}
?>