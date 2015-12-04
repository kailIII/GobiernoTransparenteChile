<?php

class Directorio extends Controller {

    function Directorio() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->model('Entidades_model');
        $this->load->model('Servicios_model');
        $this->load->model('Directorio_model');
        $this->load->model('Busquedas_model');
        $this->load->model('Planillas_model');
        $this->load->model('Normativa_a6_model');
        $this->load->model('Normativa_a6_2_model');
        $this->load->model('Normativa_a7g_model');
        $this->load->model('Normativa_a7c_model');
        $this->load->model('Facultades_model');
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
        $this->load->model('Secretoreserva_model');
        $this->load->model('Ley20416_model');
        //$this->load->model('Solicitud_informacion_model');
        $this->load->model('Informacion_no_disponible_model');
        $this->load->model('Registro_respuestas_model');

        $this->blacklist = array_map('rtrim', file("./system/application/libraries/blacklist.txt"));
    }

    function index() {
        //redirect('directorio/entidad');
        $this->entidad();
    }

    function servicios() {
        if ($this->config->item('cache'))
            $this->output->cache($this->config->item('cache'));

        $servicios = $this->Servicios_model->get('servicio asc')->result();
        $data['servicios'] = $servicios;
        $data['title'] = 'Servicios';
        $data['content'] = 'directorio_servicios';
        $this->load->view('template', $data);
    }

    function entidad($entidades_id=NULL, $servicios_id=NULL, $pagina=NULL, $subseccion1=NULL, $subseccion2=NULL) {
        if ($this->config->item('cache'))
            $this->output->cache($this->config->item('cache'));

        //Para corregir parentesis que llegan como html entities al recibirlos como parametro.
        $subseccion1=html_entity_decode($subseccion1);
        $subseccion2=html_entity_decode($subseccion2);
        
        $external_pages = array('ley19862', 'organigrama', 'enlace_organigrama', 'ejecucion_presupuestaria', 'mercado_publico', 'tramites_en_chile_clic', 'gestion_de_solicitudes', 'costos_de_reproduccion', 'portal_ciudadana', 'norma_ciudadana', 'per_remuneraciones', 'normas_acceso_informacion', 'tutorial_institucional', 'tutoriales_derecho_acceso');

        if ($entidades_id != NULL && $servicios_id != NULL && $pagina != NULL && $subseccion1 != NULL && $subseccion2 != NULL) {
            $directorio = $this->Directorio_model->getByServiciosIdAndPagina($servicios_id, $pagina, $subseccion1, $subseccion2)->result();
            $this->_desplegar_datos($directorio);
        } else if ($entidades_id != NULL && $servicios_id != NULL && $pagina != NULL && $subseccion1 != NULL) {
            $entidad = $this->Entidades_model->getById($entidades_id)->row();
            $data['entidad'] = $entidad;

            $servicio = $this->Servicios_model->getById($servicios_id)->row();
            $data['servicio'] = $servicio;

            $data['pagina'] = $pagina;

            $data['subseccion1'] = $subseccion1;

            $urls = $this->Directorio_model->getByServiciosIdAndPagina($servicios_id, $pagina, $subseccion1)->result();

            //Vemos si hay subseccion
            $subsecciones = array();
            foreach ($urls as $u)
                if ($u->subseccion2) {
                    $subsecciones[$u->subseccion2]=new stdClass();
                    $subsecciones[$u->subseccion2]->external = false;
                    $subsecciones[$u->subseccion2]->url = site_url('directorio/entidad/' . $entidad->id . '/' . $servicio->id . '/' . $pagina . '/' . rawurlencode($u->subseccion1) . '/' . rawurlencode($u->subseccion2));
                }

            if (empty($subsecciones)) {
                $this->_desplegar_datos($urls);
            } else {
                $data['subsecciones'] = $subsecciones;
                $data['title'] = $servicio->servicio . ' > ' . $this->lang->line($pagina);
                $data['content'] = 'directorio_entidad_servicios_paginas_urls';
                $this->load->view('template', $data);
            }
        } else if ($entidades_id != NULL && $servicios_id != NULL && $pagina != NULL) {

            $entidad = $this->Entidades_model->getById($entidades_id)->row();
            $data['entidad'] = $entidad;

            $servicio = $this->Servicios_model->getById($servicios_id)->row();
            $data['servicio'] = $servicio;

            $data['pagina'] = $pagina;

            $urls = $this->Directorio_model->getByServiciosIdAndPagina($servicios_id, $pagina, null, null, 'url')->result();
            //Vemos si hay subseccion
            //Se invierte el orden para el ordenamiento de las fechas
            $urls = array_reverse($urls);
            $subsecciones = array();
            foreach ($urls as $u)
                if ($u->subseccion1) {
                    $subsecciones[$u->subseccion1]=new stdClass();
                    $subsecciones[$u->subseccion1]->external = false;
                    $subsecciones[$u->subseccion1]->subcategoria = $u->subcategoria;
                    if($u->subcategoria){
                    	$data['subcategoria'] = true;
                    }
                    //Se verifica si se debe apuntar directamente a la url final
                    if((!$u->parsed || preg_match('/fail/i',$u->parsed) ) && $u->url){
                    	$subsecciones[$u->subseccion1]->url = $u->url;
                    	$subsecciones[$u->subseccion1]->external = true;
                    }else{
		                  //Verifica si se está usando el nuevo campo alias para la generación de las urls
		                  if($u->alias_subseccion1){
		                  	$subsecciones[$u->subseccion1]->url = site_url('directorio/entidad/' . $entidad->id . '/' . $servicio->id . '/' . $pagina . '/' . rawurlencode($u->alias_subseccion1));
		                  }else{
												$subsecciones[$u->subseccion1]->url = site_url('directorio/entidad/' . $entidad->id . '/' . $servicio->id . '/' . $pagina . '/' . rawurlencode($u->subseccion1));
		                  }
                  	}
                }
            if (empty($subsecciones)) {
                $this->_desplegar_datos($urls);
            } else {
            		//En caso de tener subcategorias, se agrupan según estas
            		if(isset($data['subcategoria'])){
	            		$subsecciones_sort = array();
	            		foreach ($subsecciones as $s1) {
	            			foreach ($subsecciones as $nombre_pagina => $s2) {
	            				if($s2->subcategoria == '')
	            					$s2->subcategoria = 'otros_cat';
	            				if($s1->subcategoria == $s2->subcategoria && !in_array($nombre_pagina, $subsecciones_sort)){
	            					$subsecciones_sort[$nombre_pagina] = $s2;
	            				}
	            			}
	            		}
	            		$subsecciones = $subsecciones_sort;
            		}

                $data['subsecciones'] = $subsecciones;

                $data['title'] = $servicio->servicio . ' > ' . $this->lang->line($pagina);
                $data['content'] = 'directorio_entidad_servicios_paginas_urls';
                $this->load->view('template', $data);
            }
        }

        /* else if ($entidades_id && $servicios_id && $pagina) {
          $entidad = $this->Entidades_model->getById($entidades_id)->row();
          $data['entidad'] = $entidad;

          $servicio = $this->Servicios_model->getById($servicios_id)->row();
          $data['servicio'] = $servicio;

          $data['pagina'] = $pagina;

          $urls = $this->Directorio_model->getByServiciosIdAndPagina($servicios_id, $pagina)->result();
          foreach ($urls as $key => $x) {
          if (strpos($x->parsed, 'Fail') !== false || $x->blacklisted || in_array($x->pagina, $external_pages))
          $x->external = true;
          else {
          $x->external = false;
          if ($x->subseccion1 != NULL && $x->subseccion2 != NULL)
          $x->url = site_url('directorio/entidad/' . $entidades_id . '/' . $servicios_id . '/' . $x->pagina . '/' . urlencode ($x->subseccion1) . '/' . urlencode($x->subseccion2));
          else if ($x->subseccion1 != NULL)
          $x->url = site_url('directorio/entidad/' . $entidades_id . '/' . $servicios_id . '/' . $x->pagina . '/' . urlencode($x->subseccion1));
          else
          $x->url = site_url('directorio/entidad/' . $entidades_id . '/' . $servicios_id . '/' . $x->pagina);
          }
          }

          //Si es solo un resultado de año, mes, y la pagina no es externa redirigimos inmediatamente a la pagina de datos.
          //if (count($urls) == 1 && reset($urls)->external == false)
          //    redirect(reset($urls)->url);

          $data['urls'] = $urls;

          $data['title'] = $servicio->servicio . ' > ' . $this->lang->line($pagina);
          $data['content'] = 'directorio_entidad_servicios_paginas_urls';
          } */ else if ($entidades_id && $servicios_id) {
            $entidad = $this->Entidades_model->getById($entidades_id)->row();
            $data['entidad'] = $entidad;

            $servicio = $this->Servicios_model->getById($servicios_id)->row();
            $servicio->paginas = $this->Directorio_model->getByServiciosId($servicios_id, 'id asc', 'pagina')->result();

            //Los que tienen mes o año los mostraremos en una pagina aparte.
            $already_added = array();
            
            foreach ($servicio->paginas as $key => $result) {
                if ($result->url) { //Si es que se indexo la pagina
                    if (in_array($result->pagina, $already_added)) {
                        unset($servicio->paginas[$key]);
                    } else {
                        if (in_array($result->pagina, $external_pages) || in_array($result->url, $this->blacklist))
                            $result->external = true;
                        else {
                            $result->url = site_url('directorio/entidad/' . $entidades_id . '/' . $servicios_id . '/' . $result->pagina);
                            $result->external = false;
                        }
                        $already_added[] = $result->pagina;
                    }
                }
            }

            $data['servicio'] = $servicio;
            $data['title'] = $servicio->servicio;
            $data['content'] = 'directorio_entidad_servicios_paginas';
            $this->load->view('template', $data);
        } else if ($entidades_id) {
            $entidad = $this->Entidades_model->getById($entidades_id)->row();
            $entidad->servicios = $servicios = $this->Servicios_model->getByEntidadesId($entidades_id)->result();

            $data['entidad'] = $entidad;

            $data['title'] = $entidad->entidad;
            $data['content'] = 'directorio_entidad_servicios';
            $this->load->view('template', $data);
        } else {
            $entidades = $this->Entidades_model->get()->result();
            foreach ($entidades as $entidad)
                $entidad->servicios = $this->Servicios_model->getByEntidadesId($entidad->id)->result();

            $data['entidades'] = $entidades;

            $data['content'] = 'directorio_entidad';
            $this->load->view('template', $data);
        }
    }

    function _desplegar_datos($directorio) {
				if(!$directorio)
    			show_404();

        $directorio=$directorio[0];

        $page_number = $this->input->get('page_number');
        if (!$page_number)
            $page_number = 1;
        $sort = $this->input->get('sort');
        if (!$sort)
            $sort = 'id';
        $direction = $this->input->get('direction');
        if (!$direction)
            $direction = 'asc';

        $limit = 100;
        $offset = ($page_number - 1) * $limit;

        $entidad = $this->Entidades_model->getById($directorio->entidades_id)->row();
        $data['entidad'] = $entidad;

        $servicios_id = $directorio->servicios_id;
        $servicio = $this->Servicios_model->getById($servicios_id)->row();
        $data['servicio'] = $servicio;

        $pagina = $directorio->pagina;
        $data['pagina'] = $pagina;

        $subseccion1 = $directorio->subseccion1;
        $data['subseccion1'] = $subseccion1;

        $subseccion2 = $directorio->subseccion2;
        $data['subseccion2'] = $subseccion2;


        //Verificamos si se despliega solamente un mensaje, o el resultado del parseo.
        $data['directorio'] = $directorio;
        if (strpos($directorio->parsed, 'Message') !== false)
            $data['message'] = str_replace('Message: ', '', $directorio->parsed);
        else {
            if ($pagina == 'normativa_a6')
                $model = $this->Normativa_a6_model;
            else if ($pagina == 'normativa_a6_2')
                $model = $this->Normativa_a6_2_model;
            else if ($pagina == 'normativa_a7g')
                $model = $this->Normativa_a7g_model;
            else if ($pagina == 'normativa_a7c')
                $model = $this->Normativa_a7c_model;
            else if ($pagina == 'normativa_a7b')
                $model = $this->Normativa_a7b_model;
            else if ($pagina == 'facultades')
                $model = $this->Facultades_model;
            else if ($pagina == 'per_planta')
                $model = $this->Per_planta_model;
            else if ($pagina == 'per_contrata')
                $model = $this->Per_contrata_model;
            else if ($pagina == 'per_honorarios')
                $model = $this->Per_honorarios_model;
            else if ($pagina == 'otras_compras')
                $model = $this->Otras_compras_model;
            else if ($pagina == 'otros_tramites')
                $model = $this->Otros_tramites_model;
            else if ($pagina == 'auditorias')
                $model = $this->Auditorias_model;
            else if ($pagina == 'transferencias')
                $model = $this->Transferencias_model;
            else if ($pagina == 'subsidio_programas')
                $model = $this->Subsidio_programas_model;
            else if ($pagina == 'ciudadana')
                $model = $this->Ciudadana_model;
            else if ($pagina == 'vinculos')
                $model = $this->Vinculos_model;
            else if ($pagina == 'codtrabajo')
                $model = $this->Codtrabajo_model;
            else if ($pagina == 'secretoreserva')
                $model = $this->Secretoreserva_model;
            else if ($pagina == 'ley20416')
                $model = $this->Ley20416_model;
            else if ($pagina == 'solicitud_informacion')
                $model = $this->Solicitud_informacion_model;
            else if ($pagina == 'registro_respuestas')
                $model = $this->Registro_respuestas_model;
            else if ($pagina == 'informacion_no_disponible')
                $model = $this->Informacion_no_disponible_model;

            if($pagina=='per_remuneraciones'){
                $remuneraciones=$this->Directorio_model->getByServiciosIdAndPagina($servicios_id,'per_remuneraciones')->row();
                if($remuneraciones)
                    redirect($remuneraciones->url);
                else
                    show_404();
            }
                

            $total_results = $model->countByServiciosIdAndsubseccion1Andsubseccion2($servicios_id, $subseccion1, $subseccion2);
            $data['number_of_pages'] = ceil($total_results / $limit);
            $data['page_number'] = $page_number;
            $data['sort'] = $sort;
            $data['direction'] = $direction;
            $results = $model->getByServiciosIdAndsubseccion1Andsubseccion2($servicios_id, $subseccion1, $subseccion2, $limit, $offset, $sort, $direction)->result_array();
            $data['results'] = $results;
        }


        $data['title'] = $servicio->servicio . ' > ' . $this->lang->line($pagina);
        $data['content'] = 'directorio_datos';
        $this->load->view('template', $data);
    }

    function ambito() {
        if ($this->config->item('cache'))
            $this->output->cache($this->config->item('cache'));

        $data['title'] = 'Ambitos';
        $data['content'] = 'directorio_ambito';
        $this->load->view('template', $data);
    }

    function tags() {
        if ($this->config->item('cache'))
            $this->output->cache($this->config->item('cache'));

        $tags = $this->Busquedas_model->get('contador desc', 50)->result();

        $max_contador = reset($tags)->contador;
        $min_contador = end($tags)->contador;

        $max_fontsize = 50;
        $min_fontsize = 12;

        foreach ($tags as &$t)
            $t->fontsize = round($min_fontsize + (($max_fontsize * ($t->contador - $min_contador)) / ($max_contador - $min_contador)));

        shuffle($tags);

        //print_r($tags);

        $data['tags'] = $tags;

        $data['title'] = 'Tags';
        $data['content'] = 'directorio_tags';
        $this->load->view('template', $data);
    }

    /*
    function ajax_pdfpreview() {
        $unix_binaries_path = $this->config->item('unix_binaries_path');
        putenv("PATH=" . $_ENV["PATH"] . ':' . $unix_binaries_path);
        $url = $this->input->get('url');
        $filename = 'tmp/' . md5($url) . '.jpg';
        if (!file_exists($filename))
            exec('convert -resize 240x320 -gravity center -extent 240x320 ' . $url . '[0]' . ' ' . $filename);
        header('Content-Type: image/jpg');
        print file_get_contents(base_url() . $filename);
    }
     * 
     */

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */