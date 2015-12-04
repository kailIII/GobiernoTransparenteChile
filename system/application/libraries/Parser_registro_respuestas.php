<?php
class Parser_registro_respuestas extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
			$this->CI->load->model('Registro_respuestas_model');
			$this->model=$this->CI->Registro_respuestas_model;
			$this->nombre_pagina='registro_respuestas';
			$this->nombre='Registro de respuesta de solicitudes';


			$datos['materia']->keyword='materia';
			$datos['folio']->keyword='folio';
			$datos['fecha_solicitud']->keyword='fecha';
			$datos['resumen']->keyword='resumen';
			$datos['enlace_documento']->keyword='enlace';

			$datos['materia']->type = 'string';
			$datos['folio']->type = 'string';
			$datos['fecha_solicitud']->type = 'string';
			$datos['resumen']->type = 'string';
			$datos['enlace_documento']->type = 'url';

			$this->reglas=$datos;
	}
}
?>