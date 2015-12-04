<?php
class Auditorias_model extends Planillas_model {

    function Auditorias_model()
    {
        parent::__construct();

        $this->nombre_tabla='auditorias';
        $this->search_cols=array('nombre_del_informe','unidad_auditada','materia');
    }
    
}
?>