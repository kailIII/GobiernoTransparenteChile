<?php
class Parser_normativa_a6_2 extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Normativa_a6_2_model');
		$this->model=$this->CI->Normativa_a6_2_model;
                $this->nombre_pagina='normativa_a6_2';
                $this->nombre='Potestades';

                $datos['potestad']->keyword='potestad';
		$datos['fuente_legal']->keyword='fuente';
		$datos['url']->keyword='enlace';
		$datos['potestad']->type='string';
		$datos['fuente_legal']->type='string';
		$datos['url']->type='url';

                $this->reglas=$datos;
	}
	

	
}
?>