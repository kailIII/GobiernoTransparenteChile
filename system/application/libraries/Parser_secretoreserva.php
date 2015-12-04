<?php
class Parser_secretoreserva extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
		$this->CI->load->model('Secretoreserva_model');
		$this->model=$this->CI->Secretoreserva_model;
                $this->nombre_pagina='secretoreserva';
                $this->nombre='Secreto Reserva';
	
		
		$datos['nombre_secreto']->keyword='nombre.+secret';
		$datos['nombre_acto']->keyword='nombre.+califica';
		$datos['identificacion_acto']->keyword='identifica';
		$datos['fundamento_legal']->keyword='fundamento';
                $datos['fecha_acto']->keyword='fecha';
		$datos['url']->keyword='enlace';
                $datos['nombre_secreto']->type='string';
		$datos['nombre_acto']->type='string';
		$datos['identificacion_acto']->type='string';
		$datos['fundamento_legal']->type='string';
                $datos['fecha_acto']->type='date';
		$datos['url']->type='url';

		$this->reglas=$datos;
	}
	

	
}
?>