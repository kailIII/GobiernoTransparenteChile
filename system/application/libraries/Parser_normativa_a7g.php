<?php
class Parser_normativa_a7g extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Normativa_a7g_model');
		$this->model=$this->CI->Normativa_a7g_model;
                $this->nombre_pagina='normativa_a7g';
                $this->nombre='Terceros';

                $datos['denominacion']->keyword='denominaci.+n';
                $datos['tipo_de_norma']->keyword='norma';
		$datos['numero']->keyword='número';
		$datos['nombre']->keyword='nombre';
		$datos['url']->keyword='enlace';
                $datos['fecha']->keyword='fecha(?!.+(medio|ltima))';
                $datos['forma_publicacion']->keyword='forma.+public';
                $datos['tiene_efectos_generales']->keyword='tiene.+efectos.+gen';
                $datos['fecha_modificacion']->keyword='fecha.+ltima';
                $datos['descripcion']->keyword='descripci';
                $datos['denominacion']->type='string';
		$datos['tipo_de_norma']->type='string';
		$datos['numero']->type='string';
		$datos['nombre']->type='string';
		$datos['url']->type='url';
                $datos['fecha']->type='date';
                $datos['forma_publicacion']->type='string';
                $datos['tiene_efectos_generales']->type='string';
                $datos['fecha_modificacion']->type='date';
                $datos['descripcion']->type='string';

                $this->reglas=$datos;
	}


	
}
?>