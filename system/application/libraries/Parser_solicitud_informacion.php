<?php
/*
	Este parser se usa especificamente para las direcciones de oficinas de atencion.
*/
class Parser_solicitud_informacion extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
			$this->CI->load->model('Solicitud_informacion_model');
			$this->model=$this->CI->Solicitud_informacion_model;
			$this->nombre_pagina='solicitud_informacion';
			$this->nombre='Solicitud de Información - Oficinas de Atención';


			$datos['oficina']->keyword='oficina';
			$datos['direccion']->keyword='direcci.+n';
			$datos['telefono']->keyword='tel.+fono';
			$datos['horario_atencion']->keyword='horario.+de.+atenci.+n';
			$datos['observaciones']->keyword='observaciones';

			$datos['oficina']->type = 'string';
			$datos['direccion']->type = 'string';
			$datos['telefono']->type = 'string';
			$datos['horario_atencion']->type = 'string';
			$datos['observaciones']->type = 'string';

			$this->reglas=$datos;
	}
}
?>