<?php
class Otras_compras_model extends Planillas_model {

    function __construct(){
        parent::__construct();

        $this->nombre_tabla='otras_compras';
        $this->search_cols=array('tipo_de_contratacion','razon_social','nombres','apellido_paterno','apellido_materno','rut','socios_y_accionistas');
    }
    
    
}
?>