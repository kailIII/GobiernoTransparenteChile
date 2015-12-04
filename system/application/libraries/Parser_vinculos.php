<?php

class Parser_vinculos extends Parser_planilla {

    function __construct() {
        parent::__construct();
        $this->CI->load->model('Vinculos_model');
        $this->model = $this->CI->Vinculos_model;
        $this->nombre_pagina = 'vinculos';
        $this->nombre = 'Vinculos';


        $datos['entidad']->keyword = 'entidad';
        $datos['tipo']->keyword = 'tipo';
        $datos['descripcion']->keyword = 'descripción';
        $datos['fecha_de_inicio']->keyword = 'fecha de inicio';
        $datos['fecha_de_termino']->keyword = 'fecha de término';
        $datos['fuente_legal']->keyword = 'fuente legal';
        $datos['url']->keyword = 'enlace';

        $datos['entidad']->type = 'string';
        $datos['tipo']->type = 'string';
        $datos['descripcion']->type = 'string';
        $datos['fecha_de_inicio']->type = 'date';
        $datos['fecha_de_termino']->type = 'date';
        $datos['fuente_legal']->type = 'string';
        $datos['url']->type = 'url';

        $this->reglas = $datos;
    }

}

?>