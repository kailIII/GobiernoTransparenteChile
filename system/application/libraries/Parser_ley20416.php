<?php

class Parser_ley20416 extends Parser_planilla {

    function __construct() {
        parent::__construct();
        $this->CI->load->model('Ley20416_model');
        $this->model = $this->CI->Ley20416_model;
        $this->nombre_pagina = 'ley20416';
        $this->nombre = 'Ley 20416';


        $datos['fecha_de_publicacion']->keyword = 'fecha.+publica';
        $datos['organismo_que_dicta_la_norma']->keyword = 'organismo';
        $datos['denominacion_propuesta_normativa']->keyword = 'propuesta.+normativa';
        $datos['tipo_de_norma']->keyword = 'tipo.+norma';
        $datos['efectos_de_la_norma']->keyword = 'efectos.+norma';
        $datos['url_formulario']->keyword = 'enlace.+formulario';
        $datos['url_mayor_informacion']->keyword = 'enlace.+informa';
        $datos['fecha_de_publicacion']->type = 'date';
        $datos['organismo_que_dicta_la_norma']->type = 'string';
        $datos['denominacion_propuesta_normativa']->type = 'string';
        $datos['tipo_de_norma']->type = 'string';
        $datos['efectos_de_la_norma']->type = 'string';
        $datos['url_formulario']->type = 'url';
        $datos['url_mayor_informacion']->type = 'url';

        $this->reglas = $datos;
    }

}

?>