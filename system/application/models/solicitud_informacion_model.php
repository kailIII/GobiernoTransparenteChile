<?php
class Solicitud_informacion_model extends Planillas_model {

    function Solicitud_informacion_model()
    {
        parent::__construct();

        $this->nombre_tabla='solicitud_informacion';
        $this->search_cols=array('oficina','direccion');
    }
    
}
?>