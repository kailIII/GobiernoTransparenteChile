<?php

class Parser_normativa_a7c extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Normativa_a7c_model');
		$this->model=$this->CI->Normativa_a7c_model;
                $this->nombre_pagina='normativa_a7c';
                $this->nombre='Marco Normativo';

                $datos['tipo_de_norma']->keyword='norma';
		$datos['numero']->keyword='número';
		$datos['nombre']->keyword='nombre';
                $datos['diario_oficial']->keyword='publicado.+diario';
                $datos['fecha_diario_oficial']->keyword='fecha.+diario';
		$datos['url']->keyword='enlace';
                $datos['fecha_modificacion']->keyword='modificaci.+n';
		$datos['tipo_de_norma']->type='string';
		$datos['numero']->type='string';
		$datos['nombre']->type='string';
                $datos['diario_oficial']->type='string';
                $datos['fecha_diario_oficial']->type='date';
		$datos['url']->type='url';
                $datos['fecha_modificacion']->type='date';

                $this->reglas=$datos;
	}
	

	
}
?>