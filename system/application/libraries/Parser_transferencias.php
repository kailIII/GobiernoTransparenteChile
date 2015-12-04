<?php
class Parser_transferencias extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
                $this->CI->load->model('Transferencias_model');
		$this->model=$this->CI->Transferencias_model;
                $this->nombre_pagina='transferencias';
                $this->nombre='Transferencias';
		
		
		$datos['mes_de_la_transferencia']->keyword='mes';
		$datos['fecha']->keyword='fecha';
		$datos['finalidad']->keyword='finalidad';
		$datos['respaldo_juridico']->keyword='jurídico';
                $datos['imputacion_presupuestaria']->keyword='imputaci.+n';
		$datos['unidad_monetaria']->keyword='monetaria';
		$datos['monto']->keyword='monto';
		$datos['razon_social']->keyword='razón social';
		$datos['nombres']->keyword='nombres';
		$datos['apellido_paterno']->keyword='apellido paterno';
		$datos['apellido_materno']->keyword='apellido materno';
		$datos['rut']->keyword='rut';
		$datos['region']->keyword='región';
		
		$datos['mes_de_la_transferencia']->type='string';
		$datos['fecha']->type='date';
		$datos['finalidad']->type='string';
		$datos['respaldo_juridico']->type='string';
                $datos['imputacion_presupuestaria']->type='string';
		$datos['unidad_monetaria']->type='string';
		$datos['monto']->type='numeric';
		$datos['razon_social']->type='string';
		$datos['nombres']->type='string';
		$datos['apellido_paterno']->type='string';
		$datos['apellido_materno']->type='string';
		$datos['rut']->type='string';
		$datos['region']->type='string';

                $this->reglas=$datos;

        }
	

	
}
?>