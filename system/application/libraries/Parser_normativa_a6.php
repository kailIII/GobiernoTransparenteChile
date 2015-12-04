<?php

class Parser_normativa_a6 extends Parser_planilla {

    function __construct() {
        parent::__construct();
        $this->CI->load->model('Normativa_a6_model');
        $this->model = $this->CI->Normativa_a6_model;
        $this->nombre_pagina = 'normativa_a6';
        $this->nombre = 'Diario Oficial';

        $datos['tipo_de_norma']->keyword = 'norma';
        $datos['numero']->keyword = 'número';
        $datos['fecha_de_publicacion']->keyword = 'fecha.+publicaci.+n';
        $datos['nombre']->keyword = 'nombre';
        $datos['url']->keyword = 'enlace.+correspondiente';
        $datos['fecha_modificacion']->keyword = 'fecha.+modificaci.+n';
        $datos['url_modificacion']->keyword = 'enlace.+modific';
        $datos['tipo_de_norma']->type = 'string';
        $datos['numero']->type = 'string';
        $datos['fecha_de_publicacion']->type = 'date';
        $datos['nombre']->type = 'string';
        $datos['url']->type = 'url';
        $datos['fecha_modificacion']->type = 'date';
        $datos['url_modificacion']->type = 'url';

        $this->reglas = $datos;
    }

}

?>