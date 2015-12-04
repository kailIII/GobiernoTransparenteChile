<?php
class Parser_otras_compras extends Parser_planilla{
		
	function __construct(){
		parent::__construct();
		$this->CI->load->model('Otras_compras_model');
		$this->model=$this->CI->Otras_compras_model;
                $this->nombre_pagina='otras_compras';
                $this->nombre='Otras Compras';
		
		$datos['fecha_del_acto']->keyword='fecha del acto';
		$datos['numero_del_acto']->keyword='n.+mero\s+del\s+acto';
		$datos['tipo_de_contratacion']->keyword='tipo de contratación';
		$datos['inicio_del_contrato']->keyword='inicio del contrato';
		$datos['termino_del_contrato']->keyword='término del contrato';
		$datos['unidad_monetaria']->keyword='unidad monetaria';
		$datos['monto_total']->keyword='monto';
		$datos['razon_social']->keyword='razón social';
		$datos['nombres']->keyword='nombres';
		$datos['apellido_paterno']->keyword='apellido paterno';
		$datos['apellido_materno']->keyword='apellido materno';
		$datos['rut']->keyword='rut';
		$datos['socios_y_accionistas']->keyword='socios';
		$datos['url_contrato']->keyword='enlace.+ntegro.+contrato';
                $datos['url_modificaciones_contrato']->keyword='enlace.+modificaci.+n';
                $datos['observaciones']->keyword='observaciones';
		
		$datos['fecha_del_acto']->type='date';
		$datos['numero_del_acto']->type='string';
		$datos['tipo_de_contratacion']->type='string';
		$datos['inicio_del_contrato']->type='date';
		$datos['termino_del_contrato']->type='date';
		$datos['unidad_monetaria']->type='string';
		$datos['monto_total']->type='numeric';
		$datos['razon_social']->type='string';
		$datos['nombres']->type='string';
		$datos['apellido_paterno']->type='string';
		$datos['apellido_materno']->type='string';
		$datos['rut']->type='string';
		$datos['socios_y_accionistas']->type='string';
		$datos['url_contrato']->type='url';
                $datos['url_modificaciones_contrato']->type='url';
                $datos['observaciones']->type='string';

                $this->reglas=$datos;

        }
        
        
	

	
}
?>