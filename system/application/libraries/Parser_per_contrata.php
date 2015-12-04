<?php

class Parser_per_contrata extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Per_contrata_model');
		$this->model=$this->CI->Per_contrata_model;
                $this->nombre_pagina='per_contrata';
                $this->nombre='Personal Contrata';

                $datos['estamento']->keyword='estamento';
		$datos['apellido_paterno']->keyword='paterno';
		$datos['apellido_materno']->keyword='materno';
		$datos['nombres']->keyword='nombres';
		$datos['grado_eus']->keyword='grado';
                $datos['calificacion']->keyword='calificaci.+n';
		$datos['cargo']->keyword='cargo';
		$datos['region']->keyword='región';
                $datos['asignaciones_especiales']->keyword='asignaciones.+espec';
                $datos['unidad_monetaria']->keyword='unidad.+monet';
                $datos['remuneracion_bruta_mensualizada']->keyword='remuneraci.+n.+bruta';
                $datos['horas_extraordinarias']->keyword='horas.+extra';
		$datos['fecha_de_inicio']->keyword='fecha.+inicio';
		$datos['fecha_de_termino']->keyword='fecha.+t.+rmino';
		$datos['observaciones']->keyword='observaciones';
		$datos['estamento']->type='string';
		$datos['apellido_paterno']->type='string';
		$datos['apellido_materno']->type='string';
		$datos['nombres']->type='string';
		$datos['grado_eus']->type='url';
                $datos['calificacion']->type='string';
		$datos['cargo']->type='string';
		$datos['region']->type='string';
                $datos['asignaciones_especiales']->type='string';
                $datos['unidad_monetaria']->type='string';
                $datos['remuneracion_bruta_mensualizada']->type='numeric';
                $datos['horas_extraordinarias']->type='url';
		$datos['fecha_de_inicio']->type='date';
		$datos['fecha_de_termino']->type='date';
		$datos['observaciones']->type='string';

                $this->reglas=$datos;
	}
	


	
}
?>