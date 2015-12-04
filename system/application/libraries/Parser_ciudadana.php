<?php
class Parser_ciudadana extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
		$this->CI->load->model('Ciudadana_model');
		$this->model=$this->CI->Ciudadana_model;
                $this->nombre_pagina='ciudadana';
                $this->nombre='Ciudadana';

		
		$datos['nombre']->keyword='nombre';
		$datos['descripcion']->keyword='descripción';
                $datos['tiene_consejo_consultivo']->keyword='(?<!enlace\sa\s)consejo';
                $datos['url_consejo_consultivo']->keyword='enlace.+consejo';
                $datos['requisitos_para_participar']->keyword='requisito';
		$datos['proposito']->keyword='propósito';
		$datos['participantes']->keyword='participantes';
		$datos['url']->keyword='enlace';
		
		$datos['nombre']->type='string';
		$datos['descripcion']->type='string';
                $datos['tiene_consejo_consultivo']->type='string';
                $datos['url_consejo_consultivo']->type='string';
                $datos['requisitos_para_participar']->type='string';
		$datos['proposito']->type='string';
		$datos['participantes']->type='string';
		$datos['url']->type='url';

                $this->reglas=$datos;
	}
	

	
}
?>