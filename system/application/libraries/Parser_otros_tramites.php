<?php
class Parser_otros_tramites extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
		$this->CI->load->model('Otros_tramites_model');
		$this->model=$this->CI->Otros_tramites_model;
                $this->nombre_pagina='otros_tramites';
                $this->nombre='Otros tramites';
		
		$datos['nombre']->keyword='nombre';
		$datos['descripcion']->keyword='consiste';
                $datos['requisitos']->keyword='requisitos';
                $datos['documentos_requeridos']->keyword='documento.+requerido';
		$datos['a_quien_esta_dirigido']->keyword='dirigido';
                $datos['tramites_a_realizar']->keyword='tr.+mites.+realizar';
		$datos['donde_se_realiza']->keyword='realiza';
		$datos['tiene_costo']->keyword='costo';
                $datos['unidad_monetaria']->keyword='unidad\smonetaria';
                $datos['valor_del_servicio']->keyword='valor';
		$datos['en_linea']->keyword='(?<!mite\sen\s)línea';
		$datos['url_tramite']->keyword='enlace.+tr.+mite';
                $datos['url_mayor_informacion']->keyword='enlace.+info';
		
		$datos['nombre']->type='string';
		$datos['descripcion']->type='string';
                $datos['requisitos']->type='string';
                $datos['documentos_requeridos']->type='string';
		$datos['a_quien_esta_dirigido']->type='string';
                $datos['tramites_a_realizar']->type='string';
		$datos['donde_se_realiza']->type='string';
		$datos['tiene_costo']->type='string';
                $datos['unidad_monetaria']->type='string';
                $datos['valor_del_servicio']->type='numeric';
		$datos['en_linea']->type='string';
		$datos['url_tramite']->type='url';
                $datos['url_mayor_informacion']->type='url';

		$this->reglas=$datos;
	}
	

	
}
?>