<?php
class Parser_subsidio_programas extends Parser_planilla {

    function __construct() {
        parent::__construct();
        $this->CI->load->model('Subsidio_programas_model');
        $this->model = $this->CI->Subsidio_programas_model;
        $this->nombre_pagina = 'subsidio_programas';
        $this->nombre = 'Programas de Subsidio';


        $datos['nombre']->keyword = 'nombre';
        $datos['fuente_legal']->keyword = 'fuente legal';
        $datos['periodo']->keyword = 'período';
        $datos['unidad_monetaria']->keyword = 'monetaria';
        $datos['monto']->keyword = 'monto';
        $datos['criterio']->keyword = 'criterio';
        $datos['url_mayor_informacion']->keyword = 'enlace a mayor';
        $datos['url_nomina_beneficiarios']->keyword = 'enlace a nómina';

        $datos['nombre']->type = 'string';
        $datos['fuente_legal']->type = 'string';
        $datos['periodo']->type = 'string';
        $datos['unidad_monetaria']->type = 'string';
        $datos['monto']->type = 'numeric';
        $datos['criterio']->type = 'string';
        $datos['url_mayor_informacion']->type = 'url';
        $datos['url_nomina_beneficiarios']->type = 'url';

        $this->reglas = $datos;
    }

}

?>