<?php
class Parser_per_honorarios extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Per_honorarios_model');
		$this->model=$this->CI->Per_honorarios_model;
                $this->nombre_pagina='per_honorarios';
                $this->nombre='Personal Honorarios';

                $datos['honorario_bruto']->keyword='bruta|bruto';
		$datos['honorario_bruto']->type='numeric';
                $datos['pago_mensual']->keyword='pago\smensual';
		$datos['pago_mensual']->type='string';
		$datos['apellido_paterno']->keyword='paterno';
		$datos['apellido_paterno']->type='string';
		$datos['descripcion_de_la_funcion']->keyword='descripción';
		$datos['descripcion_de_la_funcion']->type='string';
		$datos['calificacion_profesional']->keyword='calificación';
		$datos['calificacion_profesional']->type='string';
		$datos['grado_eus']->keyword='grado';
		$datos['grado_eus']->type='url';
		$datos['region']->keyword='región';
		$datos['region']->type='string';
		$datos['fecha_de_inicio']->keyword='fecha.+inicio';
		$datos['fecha_de_inicio']->type='date';
		$datos['fecha_de_termino']->keyword='fecha.+t.+rmino';
		$datos['fecha_de_termino']->type='date';
		$datos['observaciones']->keyword='observaciones';
		$datos['observaciones']->type='string';
		$datos['unidad_monetaria']->keyword='monetaria';
		$datos['unidad_monetaria']->type='string';
		$datos['apellido_materno']->keyword='materno';
		$datos['apellido_materno']->type='string';
		$datos['nombres']->keyword='nombres';
		$datos['nombres']->type='string';

                $this->reglas=$datos;
	}
	
		
}
?>