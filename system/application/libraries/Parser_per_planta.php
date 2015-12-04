<?php

class Parser_per_planta extends Parser_planilla
{

    function __construct()
    {
        parent::__construct();
        $this->CI->load->model('Per_planta_model');
        $this->model = $this->CI->Per_planta_model;
        $this->nombre_pagina = 'per_planta';
        $this->nombre = 'Personal Planta';
        $datos = array();
        $datos['estamento'] = new \stdClass();
        $datos['estamento']->keyword = 'estamento';
        $datos['apellido_paterno'] = new stdClass();
        $datos['apellido_paterno']->keyword = 'paterno';
        $datos['apellido_materno'] = new stdClass();
        $datos['apellido_materno']->keyword = 'materno';
        $datos['nombres'] = new \stdClass();
        $datos['nombres']->keyword = 'nombres';
        $datos['grado_eus'] = new \stdClass();
        $datos['grado_eus']->keyword = 'grado';
        $datos['calificacion'] = new \stdClass();
        $datos['calificacion']->keyword = 'calificaci.+n';
        $datos['cargo'] = new \stdClass();
        $datos['cargo']->keyword = 'cargo';
        $datos['region'] = new \stdClass();
        $datos['region']->keyword = 'región';
        $datos['asignaciones_especiales'] = new \stdClass();
        $datos['asignaciones_especiales']->keyword = 'asignaciones.+espec';
        $datos['unidad_monetaria'] = new \stdClass();
        $datos['unidad_monetaria']->keyword = 'unidad.+monet';
        $datos['remuneracion_bruta_mensualizada'] = new \stdClass();
        $datos['remuneracion_bruta_mensualizada']->keyword = 'remuneraci.+n.+bruta';
        $datos['horas_extraordinarias'] = new \stdClass();
        $datos['horas_extraordinarias']->keyword = 'horas.+extra';
        $datos['fecha_de_inicio'] = new \stdClass();
        $datos['fecha_de_inicio']->keyword = 'fecha.+inicio';
        $datos['fecha_de_termino'] = new \stdClass();
        $datos['fecha_de_termino']->keyword = 'fecha.+t.+rmino';
        $datos['observaciones'] = new \stdClass();
        $datos['observaciones']->keyword = 'observaciones';
        $datos['estamento']->type = 'string';
        $datos['apellido_paterno']->type = 'string';
        $datos['apellido_materno']->type = 'string';
        $datos['nombres']->type = 'string';
        $datos['grado_eus']->type = 'url';
        $datos['calificacion']->type = 'string';
        $datos['cargo']->type = 'string';
        $datos['region']->type = 'string';
        $datos['asignaciones_especiales']->type = 'string';
        $datos['unidad_monetaria']->type = 'string';
        $datos['remuneracion_bruta_mensualizada']->type = 'numeric';
        $datos['horas_extraordinarias']->type = 'url';
        $datos['fecha_de_inicio']->type = 'date';
        $datos['fecha_de_termino']->type = 'date';
        $datos['observaciones']->type = 'string';

        $this->reglas = $datos;
    }


}

?>