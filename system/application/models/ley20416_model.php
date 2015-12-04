<?php
class Ley20416_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='ley20416';
        $this->search_cols=array('organismo_que_dicta_la_norma','denominacion_propuesta_normativa','tipo_de_norma','efectos_de_la_norma');
    }
    
    

}
?>