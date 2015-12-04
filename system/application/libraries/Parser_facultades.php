<?php
class Parser_facultades extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Facultades_model');
		$this->model=$this->CI->Facultades_model;
                $this->nombre_pagina='facultades';
                $this->nombre='Facultades';

                $datos['unidad']->keyword='unidad';
		$datos['facultades']->keyword='facultades';
		$datos['fuente_legal']->keyword='fuente\slegal';
		$datos['url']->keyword='enlace';
                $datos['fecha_modificacion']->keyword='fecha.+modificaci.+n';
		$datos['unidad']->type='string';
		$datos['facultades']->type='string';
		$datos['fuente_legal']->type='string';
		$datos['url']->type='url';
                $datos['fecha_modificacion']->type='date';

                $this->reglas=$datos;
	}
	

	

	
}
?>