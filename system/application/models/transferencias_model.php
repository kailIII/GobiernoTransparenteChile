<?php
class Transferencias_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='transferencias';
        $this->search_cols=array('finalidad','respaldo_juridico','rut','razon_social','apellido_paterno','apellido_materno','nombres');
    }
    
    
}
?>