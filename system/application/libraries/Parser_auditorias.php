<?php

class Parser_auditorias extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Auditorias_model');
		$this->model=$this->CI->Auditorias_model;
                $this->nombre_pagina='auditorias';
                $this->nombre='Auditorias';
		
		
		$datos['nombre_del_informe']->keyword='nombre del informe';
		$datos['numero_del_informe']->keyword='número del informe';
                $datos['entidad_auditoria']->keyword='entidad';
		$datos['unidad_auditada']->keyword='unidad auditada';
		$datos['materia']->keyword='materia';
		$datos['periodo_auditado']->keyword='período';
		$datos['fecha_de_inicio']->keyword='fecha de inicio';
		$datos['fecha_de_termino']->keyword='fecha de término';
		$datos['url_informe']->keyword='enlace.+informe.+auditor.+a';
                $datos['fecha_de_publicacion']->keyword='fecha.+publica';
		$datos['url_documento_respuesta']->keyword='enlace.+respuesta';
		
		$datos['nombre_del_informe']->type='string';
		$datos['numero_del_informe']->type='numeric';
                $datos['entidad_auditoria']->type='string';
		$datos['unidad_auditada']->type='string';
		$datos['materia']->type='string';
		$datos['periodo_auditado']->type='string';
		$datos['fecha_de_inicio']->type='date';
		$datos['fecha_de_termino']->type='date';
		$datos['url_informe']->type='url';
                $datos['fecha_de_publicacion']->type='date';
		$datos['url_documento_respuesta']->type='url';

                $this->reglas=$datos;

	}
	

	
}
?>