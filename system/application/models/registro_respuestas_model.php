<?php
class Registro_respuestas_model extends Planillas_model {

    function Registro_respuestas_model()
    {
        parent::__construct();

        $this->nombre_tabla='registro_respuestas';
        $this->search_cols=array('materia','folio','resumen');
    }
    
}
?>