<?php

class Reportes extends Controller {

	function __construct()
	{
		parent::__construct();
		
        if(!$this->session->userdata('logged_in') && isset($_SERVER['REMOTE_ADDR'])){
            $this->session->set_userdata('referer', current_url());
            redirect(site_url('/usuarios/login'));
        }
		
		$this->load->model('Servicios_model');
		$this->load->model('Entidades_model');
		$this->load->model('Directorio_model');
		
		$this->load->model('Normativa_a6_model');
		$this->load->model('Normativa_a7g_model');
		$this->load->model('Normativa_a7b_model');
		$this->load->model('Normativa_a7c_model');
		$this->load->model('Per_honorarios_model');
		$this->load->model('Per_planta_model');
		$this->load->model('Per_remuneraciones_model');
		$this->load->model('Otras_compras_model');
		$this->load->model('Transferencias_model');
		$this->load->model('Auditorias_model');
		$this->load->model('Subsidio_programas_model');
		$this->load->model('Ciudadana_model');
		$this->load->model('Vinculos_model');
		$this->load->model('Per_contrata_model');
		$this->load->model('Otros_tramites_model');
		$this->load->model('Codtrabajo_model');
		
		$this->load->library('form_validation');
		
		$this->lang->load('transparencia');
	}
	
	function index(){
		$data['title']='Reportes';
		$data['content']='reportes_index';
		$this->load->view('template_reportes',$data);
		
	}
	
	function categorias(){
		$categorias=array('marco_normativo'=>array('normativa_a6','normativa_a7b','normativa_a7c'),
					'actos_y_resoluciones'=>array('normativa_a7g'),
					'dotacion_de_personal'=>array('per_planta','per_contrata','per_honorarios','per_remuneraciones','codtrabajo'),
					'estructura_organica'=>array('organigrama','enlace_organigrama'),
					'compras_y_adquisiciones'=>array('otras_compras'),
					'presupuesto'=>array('ejecucion_presupuestaria'),
					'transferencias_cat'=>array('transferencias','ley19862'),
					'auditorias_cat'=>array('auditorias'),
					'tramites'=>array('otros_tramites'),
					'subsidios_y_beneficios'=>array('subsidio_programas','subsidio_nominas'),
					'participacion_ciudadana'=>array('ciudadana','norma_ciudadana','portal_ciudadana'),
					'vinculos_cat'=>array('vinculos'),
					'gestion_de_solicitudes_cat'=>array('gestion_de_solicitudes'),
					'costos_de_reproduccion_cat'=>array('costos_de_reproduccion')
					);
		
		$data['categorias']=$categorias;
		
		$this->form_validation->set_rules('categorias[]', 'Categorías');
		$this->form_validation->set_rules('paginas[]', 'Páginas', 'required');
		
		if ($this->form_validation->run() == TRUE){
			$data['show_results']=true;
			
			$input_paginas=$this->input->post('paginas');
			
			foreach($input_paginas as $p){
				$directorio=$this->Directorio_model->get(array('pagina'=>$p))->result();
				foreach($directorio as $x){
					if($x->url==NULL)
						$result->paginas[$p]->sin_enlace[]=$x;
					if(preg_match('/fail/i',$x->parsed))
						$result->paginas[$p]->parseo_fallido[]=$x;
				}
				//$parseo_fallido=$this->Directorio_model->get(array('pagina'=>$p,'url'=>NULL))->result();
				//foreach($sin_enlace as $x)
				//	$result->paginas[$p]->sin_enlace[]=$x->servicio;
			}
			

			$data['result']=$result;
		}
		
		$data['title']='Reportes por Categoria';
		$data['content']='reportes_categorias';
		$this->load->view('template_reportes',$data);
	}
	
	function servicios(){
		$entidades=$this->Entidades_model->get()->result();
		foreach($entidades as $entidad)
			$entidad->servicios=$this->Servicios_model->getByEntidadesId($entidad->id)->result();
		
		$data['entidades']=$entidades;
		
		$this->form_validation->set_rules('entidades[]', 'Servicios');
		$this->form_validation->set_rules('servicios[]', 'Servicios', 'required');
		
		if ($this->form_validation->run() == TRUE){
			$data['show_results']=true;
			
			$input_servicios=$this->input->post('servicios');
			foreach($input_servicios as $val)
				$result->servicios[$val]=$this->Servicios_model->getById($val)->row();
				
			foreach ($result->servicios as &$val){
				//Obtenemos las paginas no disponibles
				$directorio=$this->Directorio_model->getByServiciosId($val->id)->result();
				//Inicializamos las variables
				foreach($directorio as $d){
					$val->paginas[$d->pagina]->tiene_enlace=true;
					$val->paginas[$d->pagina]->enlace_externo=array();
					$val->paginas[$d->pagina]->sin_parsear=array();
					$val->paginas[$d->pagina]->con_mensaje=array();
					//$val->paginas[$d->pagina]->blacklisted=array();
				}
				//Hacemos los calculos
				foreach($directorio as $d){
					if($d->url==NULL)
						$val->paginas[$d->pagina]->tiene_enlace=false;
					else{
						if($d->parsed==NULL)
							$val->paginas[$d->pagina]->enlace_externo[]=$d->url;
						if(preg_match('/fail/i',$d->parsed))
							$val->paginas[$d->pagina]->sin_parsear[]=$d->url;
						if(preg_match('/message/i',$d->parsed))
							$val->paginas[$d->pagina]->con_mensaje[]=$d->url;
						//if ($d->blacklisted)
						//	$val->paginas[$d->pagina]->blacklisted[]=$d->url;
					}
				}
				
				//Obtenemos los reportes de honorarios
				$aux=$this->Per_honorarios_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->honorarios->ultimo_mes=$aux->mes;
					$val->honorarios->ultimo_ano=$aux->ano;
					$aux=$this->Per_honorarios_model->getByServiciosIdAndMesAndAno($val->id,$val->honorarios->ultimo_mes,$val->honorarios->ultimo_ano)->result_array();
					//$val->honorarios->total=count($aux);
					foreach($aux as $x)
						if($x['honorario_bruto_mensual']==NULL)
							$val->honorarios->registros_sin_honorario_bruto[]=$x;							
				}
				//Obtenemos los reportes de otras compras
				$aux=$this->Otras_compras_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->otras_compras->ultimo_mes=$aux->mes;
					$val->otras_compras->ultimo_ano=$aux->ano;
					$aux=$this->Otras_compras_model->getByServiciosIdAndMesAndAno($val->id,$val->otras_compras->ultimo_mes,$val->otras_compras->ultimo_ano)->result_array();
					foreach($aux as $x)
						if(!$this->_isBlank($x['razon_social']) && $this->_isBlank($x['socios_y_accionistas']))
							$val->otras_compras->registros_incompletos[]=$x;
					//$val->otras_compras->n_registros_incompletos=count($val->otras_compras->registros_incompletos);
					foreach($aux as $x)
						if($this->_isBlank($x['url']))
							$val->otras_compras->registros_sin_url[]=$x;
					//$val->otras_compras->n_registros_sin_url=count($val->otras_compras->registros_sin_url);
							
				}
				//Obtenemos los reportes de normativa a6
				$aux=$this->Normativa_a6_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->normativa_a6->ultimo_mes=$aux->mes;
					$val->normativa_a6->ultimo_ano=$aux->ano;
					$aux=$this->Normativa_a6_model->getByServiciosIdAndMesAndAno($val->id,$val->normativa_a6->ultimo_mes,$val->normativa_a6->ultimo_ano)->result_array();
					foreach($aux as $x)
						if(!$x['url'])
							$val->normativa_a6->registros_sin_enlace[]=$x;
							
				}
				//Obtenemos los reportes de normativa a7b
				$aux=$this->Normativa_a7b_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->normativa_a7b->ultimo_mes=$aux->mes;
					$val->normativa_a7b->ultimo_ano=$aux->ano;
					$aux=$this->Normativa_a7b_model->getByServiciosIdAndMesAndAno($val->id,$val->normativa_a7b->ultimo_mes,$val->normativa_a7b->ultimo_ano)->result_array();
					foreach($aux as $x)
						if(!$x['url'])
							$val->normativa_a7b->registros_sin_enlace[]=$x;
							
				}
				//Obtenemos los reportes de normativa a7c
				$aux=$this->Normativa_a7c_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->normativa_a7c->ultimo_mes=$aux->mes;
					$val->normativa_a7c->ultimo_ano=$aux->ano;
					$aux=$this->Normativa_a7c_model->getByServiciosIdAndMesAndAno($val->id,$val->normativa_a7c->ultimo_mes,$val->normativa_a7c->ultimo_ano)->result_array();
					foreach($aux as $x)
						if(!$x['url'])
							$val->normativa_a7c->registros_sin_enlace[]=$x;
				}
				//Obtenemos los reportes de normativa a7g
				$aux=$this->Normativa_a7g_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->normativa_a7g->ultimo_mes=$aux->mes;
					$val->normativa_a7g->ultimo_ano=$aux->ano;
					$aux=$this->Normativa_a7g_model->getByServiciosIdAndMesAndAno($val->id,$val->normativa_a7g->ultimo_mes,$val->normativa_a7g->ultimo_ano)->result_array();
					foreach($aux as $x)
						if(!$x['url'])
							$val->normativa_a7g->registros_sin_enlace[]=$x;	
				}
				
				//Obtenemos los reportes de auditorias
				$aux=$this->Auditorias_model->getByServiciosId($val->id,'ano desc, mes desc')->row();
				if($aux){
					$val->auditorias->ultimo_mes=$aux->mes;
					$val->auditorias->ultimo_ano=$aux->ano;
					$aux=$this->Auditorias_model->getByServiciosIdAndMesAndAno($val->id,$aux->mes,$aux->ano)->result_array();
					foreach($aux as $x)
						if(!$x['url_informe'])
							$val->auditorias->registros_sin_enlace[]=$x;	
				}
			}
			$data['result']=$result;
		}
		
		
		$data['title']='Reportes por Servicio';
		$data['content']='reportes_servicios';
		$this->load->view('template_reportes',$data);
	}
	
	private function _isBlank($value){ //Deprecada. No deberia usarse luego de un nuevo parseo.
		if (trim($value)=='' || trim($value)=='-')
			return true;
		else
			return false;
	}
	
}

?>
