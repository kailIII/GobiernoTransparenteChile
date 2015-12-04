<?php
class Parser_informacion_no_disponible extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
			$this->CI->load->model('Informacion_no_disponible_model');
			$this->model=$this->CI->Informacion_no_disponible_model;
			$this->nombre_pagina='informacion_no_disponible';
			$this->nombre='Informacion no Disponible';


			$datos['nombre_acto_respuesta']->keyword='notifica.+al.+solicitante';
			$datos['nombre_acto_desaparecido']->keyword='desaparecida.+la.+informaci.+n';
			$datos['identificacion_acto']->keyword='parte.+del.+acto';
			$datos['fecha_notificacion']->keyword='fecha';
			$datos['enlace_docto_respuesta']->keyword='enlace';

			$datos['nombre_acto_respuesta']->type = 'string';
			$datos['nombre_acto_desaparecido']->type = 'string';
			$datos['identificacion_acto']->type = 'string';
			$datos['fecha_notificacion']->type = 'string';
			$datos['enlace_docto_respuesta']->type = 'url';

			$this->reglas=$datos;
	}
}
?>