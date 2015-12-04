<?php

class Busqueda extends Controller {

	function Busqueda()
	{
		parent::Controller();
		
		//$this->output->enable_profiler(TRUE);
				
		$this->lang->load('transparencia');
		
		$this->load->library('form_validation');
		
		$this->load->model('Entidades_model');
		$this->load->model('Servicios_model');
		$this->load->model('Busquedas_model');

		$this->load->model('Planillas_model');
		$this->load->model('Normativa_a6_model');
    $this->load->model('Normativa_a6_2_model');
		$this->load->model('Normativa_a7g_model');
		$this->load->model('Normativa_a7c_model');
		$this->load->model('Per_honorarios_model');
		$this->load->model('Per_planta_model');
		$this->load->model('Otras_compras_model');
		$this->load->model('Transferencias_model');
		$this->load->model('Auditorias_model');
		$this->load->model('Subsidio_programas_model');
		$this->load->model('Ciudadana_model');
		$this->load->model('Vinculos_model');
		$this->load->model('Per_contrata_model');
		$this->load->model('Otros_tramites_model');
		$this->load->model('Codtrabajo_model');
		$this->load->model('Facultades_model');
		$this->load->model('Solicitud_informacion_model');
		$this->load->model('Informacion_no_disponible_model');
		$this->load->model('Registro_respuestas_model');
		$this->load->model('Secretoreserva_model');
		$this->load->model('Ley20416_model');
	}
	
	function avanzada()
	{
		
		
		$entidades=$this->Entidades_model->get()->result();
		$data['entidades']=$entidades;
		
		$categorias=array('marco_normativo','actos_y_resoluciones','dotacion_de_personal','compras_y_adquisiciones','transferencias_cat','auditorias_cat','tramites','participacion_ciudadana','subsidios_y_beneficios','vinculos_cat', 'solicitud_informacion_cat','ley20416', 'estructura_organica');
		$data['categorias']=$categorias;
		

		
		
		$data['show_search']=false;
		//$data['show_tabs']=false;
		$data['title']='Búsqueda Avanzada';
		$data['content']='busqueda_avanzada';
		$this->load->view('template',$data);
	}
	
	/*function resultados(){
		//$q=$this->input->get('q');
		$buscarpor=$this->input->get('buscarpor');
		
		if($buscarpor=='servicios')
			$this->_search_servicios();
		else
			$this->_search_global();
		
	}*/
	
	function resultados(){
		$q=addslashes($this->input->get('q'));
		$data['q']=stripslashes($q);
		$limit = 50;
		$entidades_input=$this->input->get('entidades');
		$data['entidades_input']=$entidades_input;
		$categorias_input=$this->input->get('categorias');
		$sub_categoria_input=$this->input->get('sub-categoria');
		$data['categorias_input']=$categorias_input;
		$data['sub_categoria_input']=$sub_categoria_input;
			//$buscarpor=$this->input->get('buscarpor');
		$buscarpor='global';
		$servicios=NULL;

		//Paginacion
		$page_number = $this->input->get('page_number')?$this->input->get('page_number'):1;
		
		if ($q!=NULL){			
			
			$categorias=array();
			if($categorias_input)
				$categorias=$categorias_input;
				
			$entidades=array();
			if($entidades_input)
				$entidades=$entidades_input;	
			
			//if($buscarpor=='avanzada'){
				$aux=array();
				foreach($entidades as $e){
					if($e=='*'){
						$buscarpor='global';
						break;
					}
					else
						$aux[]=$this->Servicios_model->getByEntidadesId($e)->result();
				}

				foreach($aux as $x)
					foreach($x as $y)
						$servicios[]=$y->id;
				

			//}
			if($sub_categoria_input){
				$aux_model = ucfirst($sub_categoria_input).'_model';
				$models[$sub_categoria_input] = $this->$aux_model;
			}else{
				if($buscarpor=='global' || in_array('marco_normativo',$categorias)){
					$models['normativa_a6']=$this->Normativa_a6_model;
					$models['normativa_a6_2']=$this->Normativa_a6_2_model;
					$models['normativa_a7c']=$this->Normativa_a7c_model;	
				}
				if($buscarpor=='global' || in_array('actos_y_resoluciones',$categorias)){
					$models['normativa_a7g']=$this->Normativa_a7g_model;
				}
				if($buscarpor=='global' || $buscarpor=='personas' || in_array('dotacion_de_personal',$categorias)){
					$models['per_planta']=$this->Per_planta_model;
					$models['per_contrata']=$this->Per_contrata_model;
					$models['per_honorarios']=$this->Per_honorarios_model;
					$models['codtrabajo']=$this->Codtrabajo_model;	
				}
				if($buscarpor=='global' || in_array('compras_y_adquisiciones',$categorias)){
					$models['otras_compras']=$this->Otras_compras_model;	
				}
				if($buscarpor=='global' || in_array('transferencias_cat',$categorias)){
					$models['transferencias']=$this->Transferencias_model;	
				}
				if($buscarpor=='global' || in_array('auditorias_cat',$categorias)){
					$models['auditorias']=$this->Auditorias_model;	
				}
				if($buscarpor=='global' || in_array('tramites',$categorias)){
					$models['otros_tramites']=$this->Otros_tramites_model;	
				}
				if($buscarpor=='global' || in_array('participacion_ciudadana',$categorias)){
					$models['ciudadana']=$this->Ciudadana_model;	
				}
				if($buscarpor=='global' || in_array('subsidios_y_beneficios',$categorias)){
					$models['subsidio_programas']=$this->Subsidio_programas_model;	
				}
				if($buscarpor=='global' || in_array('vinculos_cat',$categorias)){
					$models['vinculos']=$this->Vinculos_model;	
				}
				if($buscarpor=='global' || in_array('solicitud_informacion_cat',$categorias)){
					$models['solicitud_informacion']=$this->Solicitud_informacion_model;	
					$models['informacion_no_disponible']=$this->Informacion_no_disponible_model;	
					$models['registro_respuestas']=$this->Registro_respuestas_model;
					$models['secretoreserva']=$this->Secretoreserva_model;
				}
				if($buscarpor=='global' || in_array('ley20416',$categorias)){
					$models['ley20416']=$this->Ley20416_model;	
				}
				if($buscarpor=='global' || in_array('estructura_organica',$categorias)){
					$models['facultades']=$this->Facultades_model;	
				}
			}
			
			foreach($models as $cat=>$model){
				$model_results = $model->query($q, $servicios, $limit, (($page_number-1)*$limit));
				$results->contenido[$cat]=$model_results['query']->result_array();
				$results->totales[$cat]=$model_results['total'];
			}

			if(!$sub_categoria_input){
				$results->entidades=$this->Entidades_model->getLike($q)->result();
				$results->servicios=$this->Servicios_model->getLike($q)->result();
			}
			//$results->instituciones=$results_entidades+$results_servicios;
				
			//Si hay resultados, lo agregamos a nuestro contador de busquedas.
			$nResultados=0;
			foreach($results->totales as $n)
				$nResultados = $nResultados+$n;

			if(isset($results->entidades))
				foreach($results->entidades as $r)
					$nResultados++;
			if(isset($results->servicios))
				foreach($results->servicios as $r)
					$nResultados++;
			
			//Agregamos los tags
			$this->db->trans_start();
			$busqueda=trim(mb_convert_case($q, MB_CASE_LOWER));
			$record=$this->Busquedas_model->getByBusqueda($busqueda)->row();
			if ($nResultados){
				if(!$record)
					$this->Busquedas_model->insert($busqueda,1,$nResultados);
				else{
					$record->contador++;
					$record->nresultados=$nResultados;
					$this->Busquedas_model->update($record->busqueda,$record);
				}
			}
			else{
				if ($record)
					$this->Busquedas_model->delete($record->busqueda);
			}
			$this->db->trans_complete();
				
			
			$data['nresults']=$nResultados;
			$data['results']=$results;

			if($sub_categoria_input && ($nResultados > $limit)){
				$data['number_of_pages'] = ceil($nResultados/$limit);
				$data['page_number'] = $page_number;
			}
				
		}
		
		
		//$data['show_search']=false;
		//$data['show_tabs']=false;
		$data['title']='Resultados de la Busqueda';
		$data['content']='busqueda_resultados';
		$data['limit'] = $limit;
		$this->load->view('template',$data);	
	}
	

	
	function ajax_search(){
		$query=addslashes($this->input->get('q'));
		
		$query = $this->Busquedas_model->getLikeInBusqueda($query,'contador desc',10);

		if($query){
			$resultados = $query->result();
			
			if($resultados){
				foreach ($resultados as $r)
					echo $r->busqueda.';'.$r->nresultados."\n";
			}else{
				echo '';
			}
		}else{
			echo '';
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */