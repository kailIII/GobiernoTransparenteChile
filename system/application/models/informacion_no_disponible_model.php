<?php
class Informacion_no_disponible_model extends Planillas_model {

    function Informacion_no_disponible_model()
    {
        parent::__construct();

        $this->nombre_tabla='informacion_no_disponible';
        $this->search_cols=array('nombre_acto_respuesta','nombre_acto_desaparecido','identificacion_acto');
    }
    
}
?>