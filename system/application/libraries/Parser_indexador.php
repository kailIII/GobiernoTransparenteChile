<?php

class Parser_indexador {

    private $revisados;

    //Solo agregar url externas para los duplicados
    private $permite_duplicados = array(
    	'tutorial_institucional',
    	'tutoriales_derecho_acceso',
    	'solicitud_informacion'
    );

    function __construct() {
        $this->CI=& get_instance();
        $this->CI->load->model('Servicios_model');
        $this->CI->load->model('Directorio_model');
        $this->blacklist = array_map('rtrim', file("./system/application/libraries/blacklist.txt"));
        $this->revisados=array();
    }

    function start($servicios_id) {

        log_message('debug','INDEXADOR - INICIO');

        $servicio = $this->CI->Servicios_model->getById($servicios_id)->row();
        $url = $servicio->url;

        //$url=preg_replace('/(\/index.html$|\/index.htm$|\/$)/','',$url);
        $result = new \stdClass();
        $result->nombre = 'Home';
        $result->url = $url;

        //$result->links=array();

        $readhtml = $this->CI->parser_library->readHTML($url);
        if($readhtml === false){
        	$result->status = 'Timeout';
          return $result;
        }
        $http_code = $readhtml->http_code;
        $html = $readhtml->html;
        if ($http_code != 200) {
            $result->status = 'URL no existe';
            return $result;
        }

        //Deprecamos los ultimos datos
        $update = new stdClass();
        $update->deprecated=TRUE;
        $this->CI->Directorio_model->updateByServiciosId($servicios_id,$update);



        $html_dom = str_get_html($html);

        //Tomamos cada una de las anchors
        $anchors = $html_dom->find('a');

        if (count($anchors) == 0) {
            $result->status = 'Estructura de html no estandar: No hay anchors.';
            $html_dom->clear();
            return $result;
        }
        $etiqueta_link = array();
        $etiqueta_link['normativa_a7c'] = new \stdClass();
       	$etiqueta_link['normativa_a7c']->keyword = 'marco\s+normativo';
        $etiqueta_link['normativa_a7c']->categoria = 'marco_normativo';
        $etiqueta_link['normativa_a6_2'] = new \stdClass();
        $etiqueta_link['normativa_a6_2']->keyword = 'potestades';
        $etiqueta_link['normativa_a6_2']->categoria = 'marco_normativo';
        $etiqueta_link['normativa_a6'] = new \stdClass();
        $etiqueta_link['normativa_a6']->keyword = '(publicados|publicadas).+diario\s+oficial';
        $etiqueta_link['normativa_a6']->categoria = 'marco_normativo';
        $etiqueta_link['normativa_a7b'] = new \stdClass();
        $etiqueta_link['normativa_a7b']->keyword = 'competencias\s+y\s+responsabilidades';
        $etiqueta_link['normativa_a7b']->categoria = 'marco_normativo';

        $etiqueta_link['normativa_a7g'] = new \stdClass();
        $etiqueta_link['normativa_a7g']->keyword = '(actos?.+con\s+efectos?)|(actos?\s+y\s+resolucion(es)?)';
        $etiqueta_link['normativa_a7g']->categoria = 'actos_y_resoluciones';

        $etiqueta_link['organigrama'] = new \stdClass();
        $etiqueta_link['organigrama']->keyword = '^(?=.*?\b((estructura\s+org.+nica)|(organigrama)|(diagrama)|(estructura.+organismo))\b)((?!enlace).)*$';
        $etiqueta_link['organigrama']->categoria = 'estructura_organica';
        $etiqueta_link['enlace_organigrama'] = new \stdClass();
        $etiqueta_link['enlace_organigrama']->keyword = 'enlace.+((estructura\s+org.+nica)|(organigrama)|(diagrama)|(estructura.+organismo))';
        $etiqueta_link['enlace_organigrama']->categoria = 'estructura_organica';
        $etiqueta_link['facultades'] = new \stdClass();
        $etiqueta_link['facultades']->keyword = 'facultades';
        $etiqueta_link['facultades']->categoria = 'estructura_organica';

        $etiqueta_link['per_planta'] = new \stdClass();
        $etiqueta_link['per_planta']->keyword = 'planta';
        $etiqueta_link['per_planta']->categoria = 'dotacion_de_personal';
        $etiqueta_link['per_contrata'] = new \stdClass();
        $etiqueta_link['per_contrata']->keyword = 'contrata\s*$';
        $etiqueta_link['per_contrata']->categoria = 'dotacion_de_personal';
        $etiqueta_link['per_remuneraciones'] = new \stdClass();
        $etiqueta_link['per_remuneraciones']->keyword = 'remuneraciones|remuneraci.+n';
        $etiqueta_link['per_remuneraciones']->categoria = 'dotacion_de_personal';
        $etiqueta_link['per_honorarios'] = new \stdClass();
        $etiqueta_link['per_honorarios']->keyword = 'honorarios?';
        $etiqueta_link['per_honorarios']->categoria = 'dotacion_de_personal';
        $etiqueta_link['codtrabajo'] = new \stdClass();
        $etiqueta_link['codtrabajo']->keyword = 'c.+digo.+trabajo';
        $etiqueta_link['codtrabajo']->categoria = 'dotacion_de_personal';

        $etiqueta_link['mercado_publico'] = new \stdClass();
        $etiqueta_link['mercado_publico']->keyword = '(mercado\s*p.+blico)|(chilecompra)|(sistema de compras? p.+blicas?)|(url?.+sistema.+de.+compras.+publicas)|(compras.+p.+blicas)|(sistema.+de.+compras.+p.+blicas)';
        $etiqueta_link['mercado_publico']->categoria = 'compras_y_adquisiciones';
        $etiqueta_link['otras_compras'] = new stdClass();
        $etiqueta_link['otras_compras']->keyword = 'otras.+compras';
        $etiqueta_link['otras_compras']->categoria = 'compras_y_adquisiciones';

        $etiqueta_link['ejecucion_presupuestaria'] = new \stdClass();
        $etiqueta_link['ejecucion_presupuestaria']->keyword = '(presupuestar.+(a|o)|presupuestos?)|(dipres)';
        $etiqueta_link['ejecucion_presupuestaria']->categoria = 'presupuesto';

        $etiqueta_link['ley19862'] = new \stdClass();
        $etiqueta_link['ley19862']->keyword = '(registro.+19\.?862)|(transferencia.+19\.?862)';
        $etiqueta_link['ley19862']->categoria = 'transferencias_cat';
        $etiqueta_link['transferencias'] = new \stdClass();
        $etiqueta_link['transferencias']->keyword = 'otras.+transferencias';
        $etiqueta_link['transferencias']->categoria = 'transferencias_cat';

        $etiqueta_link['auditorias'] = new \stdClass();
        $etiqueta_link['auditorias']->keyword = '(resultados?.+aclaraciones)|auditor.+as';
        $etiqueta_link['auditorias']->categoria = 'auditorias_cat';

        $etiqueta_link['tramites_en_chile_clic'] = new \stdClass();
        $etiqueta_link['tramites_en_chile_clic']->keyword = '(chile.?click?)|(chile.?atiende)';
        $etiqueta_link['tramites_en_chile_clic']->categoria = 'tramites';
        $etiqueta_link['otros_tramites'] = new \stdClass();
        $etiqueta_link['otros_tramites']->keyword = '(otros.+tr.+mites)|tr.+mites$';
        $etiqueta_link['otros_tramites']->categoria = 'tramites';

        $etiqueta_link['subsidio_programas'] = new \stdClass();
        $etiqueta_link['subsidio_programas']->keyword = '(programas? de subsidios?)|(subsidios?.+y.+beneficios?)';
        $etiqueta_link['subsidio_programas']->categoria = 'subsidios_y_beneficios';
        //$etiqueta_link['subsidio_nominas']->keyword='n.+mina de beneficiados';
        //$etiqueta_link['subsidio_nominas']->categoria='subsidios_y_beneficios';

        $etiqueta_link['ciudadana'] = new \stdClass();
        $etiqueta_link['ciudadana']->keyword = '(mecanismos.+de.+participaci.+n.+ciudadana)|(^participaci.+n.+ciudadana)';
        $etiqueta_link['ciudadana']->categoria = 'participacion_ciudadana';
        $etiqueta_link['norma_ciudadana'] = new \stdClass();
        $etiqueta_link['norma_ciudadana']->keyword = '(norma\s*$)|(norma\s+general)';
        $etiqueta_link['norma_ciudadana']->categoria = 'participacion_ciudadana';
        $etiqueta_link['portal_ciudadana'] = new \stdClass();
        $etiqueta_link['portal_ciudadana']->keyword = 'portal de participaci.+n ciudadana';
        $etiqueta_link['portal_ciudadana']->categoria = 'participacion_ciudadana';

        $etiqueta_link['vinculos'] = new stdClass();
        $etiqueta_link['vinculos']->keyword = '(representaci.+n.+intervenci.+n)|(v.+nculos)|(participaci.+n.+entidades)';
        $etiqueta_link['vinculos']->categoria = 'vinculos_cat';

        $etiqueta_link['gestion_de_solicitudes'] = new stdClass();
        $etiqueta_link['gestion_de_solicitudes']->keyword = '(gesti.+n.+solicitudes)|(solicitudes.+informaci.+n)';
        $etiqueta_link['gestion_de_solicitudes']->categoria = 'gestion_de_solicitudes_cat';

        $etiqueta_link['costos_de_reproduccion'] = new stdClass();
        $etiqueta_link['costos_de_reproduccion']->keyword = '(costo?.+reproducci.+n)|(resoluci.+n.+exenta)|(costos)';
        $etiqueta_link['costos_de_reproduccion']->categoria = 'costos_de_reproduccion_cat';

        $etiqueta_link['ley20416'] = new stdClass();
        $etiqueta_link['ley20416']->keyword = '(empresas.+menor.+tam)|(EMT)';
        $etiqueta_link['ley20416']->categoria = 'ley20416_cat';

        $etiqueta_link['solicitud_informacion'] = new stdClass();
        $etiqueta_link['solicitud_informacion']->keyword = 'solicitud.+(de|a.+la).+Informaci.+n';
        $etiqueta_link['solicitud_informacion']->categoria = 'solicitud_informacion_cat';
        $etiqueta_link['informacion_no_disponible'] = new \stdClass();
        $etiqueta_link['informacion_no_disponible']->keyword = 'informaci.+n.+no.+disponible';
        $etiqueta_link['informacion_no_disponible']->categoria = 'solicitud_informacion_cat';
        $etiqueta_link['registro_respuestas'] = new \stdClass();
        $etiqueta_link['registro_respuestas']->keyword = 'registro.+de.+respuesta.+de.+solicitudes';
        $etiqueta_link['registro_respuestas']->categoria = 'solicitud_informacion_cat';

        //Se pasa a la categoria de solicitud de información
        $etiqueta_link['secretoreserva'] = new stdClass();
        $etiqueta_link['secretoreserva']->keyword = '(secreto|reservados)';
        $etiqueta_link['secretoreserva']->categoria = 'solicitud_informacion_cat';

        $etiqueta_link['normas_acceso_informacion'] = new \stdClass();
        $etiqueta_link['normas_acceso_informacion']->keyword = 'normas.+de.+la.+ley.+sobre.+acceso.+a.+la.+informaci.+n.+p.+blica';
        $etiqueta_link['normas_acceso_informacion']->categoria = 'ley20285_cat';
        $etiqueta_link['tutoriales_derecho_acceso'] = new \stdClass();
        $etiqueta_link['tutoriales_derecho_acceso']->keyword = '(tutoriales.+derecho.+de.+acceso)|(educa.+transparencia)';
        $etiqueta_link['tutoriales_derecho_acceso']->categoria = 'ley20285_cat';
        $etiqueta_link['tutorial_institucional'] = new \stdClass();
        $etiqueta_link['tutorial_institucional']->keyword = 'tutorial.+institucional';
        $etiqueta_link['tutorial_institucional']->categoria = 'ley20285_cat';

        //Se crean las subcategorias para Solicitud de información
        $etiqueta_link_sub = array();
        $etiqueta_link_sub['solicitud_informacion_cat'] = array();
        $etiqueta_link_sub['solicitud_informacion_cat']['solicitud_via_online'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['solicitud_via_online']->keyword = '(v.+a.+electr.+nica)|(enlace.+al.+sistema)|(url?.+enlace.+sistema.+de.+gesti.+n)';
        $etiqueta_link_sub['solicitud_informacion_cat']['solicitud_via_online']->categoria = 'acceso_informacion_publica_cat';
        $etiqueta_link_sub['solicitud_informacion_cat']['solicitud_via_material'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['solicitud_via_material']->keyword = '(v.+a.+material)|(url?.+enlace.+a.+formulario.+descargable)';
        $etiqueta_link_sub['solicitud_informacion_cat']['solicitud_via_material']->categoria = 'acceso_informacion_publica_cat';
        $etiqueta_link_sub['solicitud_informacion_cat']['educa_transparencia'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['educa_transparencia']->keyword = 'educa.+transparencia';
        $etiqueta_link_sub['solicitud_informacion_cat']['educa_transparencia']->categoria = 'derecho_acceso_cat';
        $etiqueta_link_sub['solicitud_informacion_cat']['tutorial_institucional'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['tutorial_institucional']->keyword = 'tutorial.+institucional';
        $etiqueta_link_sub['solicitud_informacion_cat']['tutorial_institucional']->categoria = 'derecho_acceso_cat';

        $etiqueta_link_sub['solicitud_informacion_cat']['canales_ingreso'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['canales_ingreso']->keyword = 'v.+as.+de.+ingreso';
        $etiqueta_link_sub['solicitud_informacion_cat']['canales_ingreso']->categoria = 'lugares_atencion_cat';
        $etiqueta_link_sub['solicitud_informacion_cat']['direcciones_oficinas'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['direcciones_oficinas']->keyword = 'oficinas.+de.+atenci.+n';
        $etiqueta_link_sub['solicitud_informacion_cat']['direcciones_oficinas']->categoria = 'lugares_atencion_cat';

        $etiqueta_link_sub['solicitud_informacion_cat']['formulario_online'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['formulario_online']->keyword = '(con.+el.+formulario.+((online)|(on.+line)))|(plan.+de.+contingencia)';
        $etiqueta_link_sub['solicitud_informacion_cat']['formulario_online']->categoria = 'dificultades_tecnicas_cat';
        $etiqueta_link_sub['solicitud_informacion_cat']['reporte_error'] = new \stdClass();
        $etiqueta_link_sub['solicitud_informacion_cat']['reporte_error']->keyword = 'reporte.+error.+t.+cnico';
        $etiqueta_link_sub['solicitud_informacion_cat']['reporte_error']->categoria = 'dificultades_tecnicas_cat';


        log_message('debug','INDEXADOR - LECTURA DE ETIQUETAS');
        $paginas = array();
        foreach ($etiqueta_link as $key => $val) {
            $directorio = new stdClass();
            $directorio->servicios_id=$servicios_id;
            $directorio->pagina = $key;
            $directorio->categoria = $val->categoria;
            $directorio->url = NULL;

            foreach ($anchors as $anchor) {
                if (preg_match('/' . $val->keyword . '/is', $anchor->innertext)) { //Hay un match
                    $directorio->url = $this->CI->parser_library->convertLinkToAbsolutePath($anchor->href, $url);
                    $this->_findPaginasIntermedias($directorio->servicios_id, $directorio->pagina, $directorio->categoria, $directorio->url, null, null, $etiqueta_link_sub);
                }
            }

            //Si es que no encontramos la URL la almacenamos igual como NULL
            if ($directorio->url == NULL)
                $this->CI->Directorio_model->insert($directorio);
        }

        log_message('debug','INDEXADOR - CREACION DE DOM');

        $html_dom->clear();

        //Almacenamos la info de contacto del sitio
        log_message('debug','INDEXADOR - ALMACENACION DE INFO DE CONTACTO DEL SITIO');
        $info = $this->getInfoContacto($html);
        $servicio->info = $info;

        //Almacenamos la fecha de actualizacion del home del sitio.
        log_message('debug','INDEXADOR - ALMACENACION DE FECHA DE ACTUALIZACIÓN DEL SITIO');
        $modified = $this->getLastModified($html);
        $servicio->modified = $modified;
        $this->CI->Servicios_model->update($servicio->id, $servicio);

        //Retornamos las paginas que indexamos
        $result->paginas = $this->CI->Directorio_model->getByServiciosIdAndDeprecated($servicios_id,FALSE)->result();

        //$result->paginas=$paginas;
        $result->status = 'Ok';
        log_message('debug','INDEXADOR - STATUS OK');
        return $result;
    }

    /*
     * Funcion que indexa las paginas que se encuentran dentro de paginas intermedias (Seleccion de mes y año).
     */

    function _findPaginasIntermedias($servicios_id, $pagina, $categoria, $url, $subseccion1=NULL, $subseccion2=NULL, $etiqueta_link_sub=null) {
        if($url==NULL || in_array($url, $this->revisados)) {
            return;
        //else if(in_array($url, $this->revisados) && !in_array($pagina, $this->permite_duplicados)){
            //return;
        }
        $this->revisados[]=$url;
        log_message('debug','INDEXADOR - PAGINA INTERMEDIA: '.count($this->revisados));
        $directorio = new stdClass();
        $directorio->servicios_id=$servicios_id;
        $directorio->pagina=$pagina;
        $directorio->categoria=$categoria;
        $directorio->url=$url;
        $directorio->subseccion1=$subseccion1;
        $directorio->subseccion2=$subseccion2;

        /* Revisa si existen subcategorias -> Solo aplica para las subsecciones 1 */
        if(isset($etiqueta_link_sub[$categoria]) && $subseccion1 != ''){
        	foreach($etiqueta_link_sub[$categoria] as $subcategoria){
        		if (preg_match('/' . $subcategoria->keyword . '/is', $subseccion1)) {
        			$directorio->subcategoria = $subcategoria->categoria;
        		}
        	}
        }

        if (preg_match('/\.(pdf|jpg|gif|png)$/i', $url) || in_array($url, $this->blacklist)) {
            $directorio->blacklisted=TRUE;
            $this->CI->Directorio_model->insert($directorio);
            return;
        }

        echo 'Reviso url: ' . $directorio->url . ' ' . number_format(memory_get_usage(true), 0) . "\n";

        $intermedia = false;

        $html = $this->CI->parser_library->readHTML($url)->html;

        $html_dom = str_get_html($html);

        //Tomamos cada una de las anchors
        $anchors = $html_dom->find('.subMenu a');

        foreach ($anchors as $anchor) {
            //$fecha = $this->findMesAnoInString($anchor->plaintext);
            //if ($fecha->mes != NULL || $fecha->ano != NULL) {
                //echo 'Encontre match con año: '.$fecha->ano.' y mes '.$fecha->mes.'<br />';
                $intermedia = true;
                $new_url = $this->CI->parser_library->convertLinkToAbsolutePath($anchor->href, $url);
                $cat=preg_replace('/\s+/', ' ', $anchor->innertext);
                if ($directorio->subseccion1==NULL) $subseccion1=$cat;
                else if ($directorio->subseccion2==NULL) $subseccion2=$cat;

                //$html_dom->clear();

                $this->_findPaginasIntermedias($servicios_id, $pagina, $categoria, $new_url, $subseccion1, $subseccion2, $etiqueta_link_sub);

                //$urls[$año]= $this->convertLinkToAbsolutePath($anchor->href,$url);
            //}
        }

        $html_dom->clear();

        if (!$intermedia) {
            $directorio->footnotes=$this->getFootnotes($html);

            $this->CI->Directorio_model->insert($directorio);
        }
        return;
    }

    /*function findMesAnoInString($string) {
        $result->mes = NULL;
        $result->ano = NULL;

        for ($i = 2006; $i <= date('Y'); $i++)
            $años[] = $i;
        $meses = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');

        foreach ($años as $key => $x)
            if (preg_match('/' . $x . '/i', $string)) { //Si lo encuentra
                $result->ano = $x;
                break;
            }

        foreach ($meses as $key => $x)
            if (preg_match('/' . $x . '/i', $string)) { //Si lo encuentra
                $result->mes = $key;
                break;
            }

        return $result;
    }*/

    function getFootnotes($html){
    	$html_dom = str_get_html($html);
    	$footnotes=$html_dom->find('#footnotes',0);
        if($footnotes)
            $info=trim($footnotes->innertext);
        else
            $info=NULL;
    	$html_dom->clear();
    	return $info;
    }

    function getInfoContacto($html){
    	$html_dom = str_get_html($html);
    	
    	$footer=$html_dom->find('div.footer',0);
    	if(!$footer)
    		$footer=$html_dom->find('div#footer',0);

    	$info=trim($footer->innertext);
    	$html_dom->clear();
    	return $info;
    }

    function getLastModified($html){
    	//echo 'caca<br />';
    	$html_dom = str_get_html($html);
    	$h3=$html_dom->find('div h3',0);
    	if (!$h3)
    		return NULL;
    	//$string=$h3->innertext;
    	//$string=preg_replace('/<b>.+<\/b>/i','',$string);
    	$string=$h3->plaintext;
    	//echo $string.'<br />';
    	$string=preg_replace('/.+ltima\sactualizaci.+n\s*:/i','',$string);
    	//echo $string.'<br />';
    	$string=trim($string);
    	$date=$this->CI->parser_library->convertStringToDate($string);
    	$html_dom->clear();
    	return $date;
    }

}

?>