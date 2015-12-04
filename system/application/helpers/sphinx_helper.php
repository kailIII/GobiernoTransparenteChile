<?php

/*
 * SPHINX HELPER:
 * Wrapper para la api de Sphinx para Redchile
 * 
 */

/*Busca usando sphinx*/
function search_busqueda_ajax($string, $filters = array(), $limit = null, $offset = null) {

    $status = FALSE;
    $message = "Default";
    $result_set = array();
    
    $CI =& get_instance();
    
    /* Para que esto funcione debe estar instalado sphinx y corriendo el demonio searchd en el servidor */
    /* http://www.hackido.com/2009/01/install-sphinx-search-on-ubuntu.html */
    /* O buscar en synaptic en caso de ubuntu por sphinx */
    /* IMPORTANTE: La api debe coincidir con la version de sphinx instalada!*/

    /* Cargo API de sphinx */
    $CI->load->library("sphinxclient");

    /* Config de Sphinx para Redchile de acuerdo a sphinx.conf */
    $CI->config->load('sphinx');

    $port = $CI->config->item('port');
    $server = $CI->config->item('server');
    $index = $CI->config->item('index');

    /*Asigno limites a la consulta*/
    if($limit !== null && $offset !== null){
        $CI->sphinxclient->SetLimits($offset,$limit,10000);
    }
    
    $CI->sphinxclient->SetServer($server, $port);
    $CI->sphinxclient->SetSortMode(SPH_SORT_EXTENDED,"contador DESC, @weight DESC");
    
    $CI->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED2);
    $CI->sphinxclient->setRankingMode(SPH_RANK_PROXIMITY_BM25);
    
    //Se asignan pesos a los campos especificos.
    //Cada match suma 200 o 50 puntos respectivamente.
    //En otro campo un match va a sumar 1 punto.
    //El total aparece en el campo @weight de sphinx.
    $CI->sphinxclient->SetFieldWeights(array('busqueda'=> 400));
    
    /*Reseteo filtros, para poder invocar el objeto y hacer filtros varias veces*/
    $CI->sphinxclient->ResetFilters();
    
    /* Hago la consulta */
    $result = $CI->sphinxclient->Query($string, $index); //String, Index
    
    /* Proceso resultado */
    if ($result === false) {
        //Tipicamente este caso va a ser por que Sphinx no esta corriendo.
        $message = "Query failed: " . $CI->sphinxclient->GetLastError();
    } else {
        if ($CI->sphinxclient->GetLastWarning()) {
            $message = "WARNING: " . $CI->sphinxclient->GetLastWarning() . "";
        }else{
            $status = TRUE;
            if(isset($result['matches'])){
                $result_set = $result['matches'];
            }else{
                $message = "Empty Set";
                $result_set = array();
            }
        }
    }
    
    return array($result_set,$status,$message,$result);
    
}

/*Busca usando sphinx*/
function search($string, $filters = array(), $index = null, $limit = null, $offset = null) {

    $status = FALSE;
    $message = "Default";
    $result_set = array();
    
    $CI =& get_instance();
    
    /* Para que esto funcione debe estar instalado sphinx y corriendo el demonio searchd en el servidor */
    /* http://www.hackido.com/2009/01/install-sphinx-search-on-ubuntu.html */
    /* O buscar en synaptic en caso de ubuntu por sphinx */
    /* IMPORTANTE: La api debe coincidir con la version de sphinx instalada!*/

    /* Cargo API de sphinx */
    $CI->load->library("sphinxclient");

    /* Config de Sphinx para Redchile de acuerdo a sphinx.conf */
    $CI->config->load('sphinx');

    $port = $CI->config->item('port');
    $server = $CI->config->item('server');
    $index = $index.'_index';

    /*Asigno limites a la consulta*/
    if($limit !== null && $offset !== null){
        $CI->sphinxclient->SetLimits($offset,$limit,10000);
    }
    
    $CI->sphinxclient->SetServer($server, $port);
    $CI->sphinxclient->SetSortMode(SPH_SORT_EXTENDED,"@weight DESC");
    
    $CI->sphinxclient->SetMatchMode(SPH_MATCH_EXTENDED2);
    $CI->sphinxclient->setRankingMode(SPH_RANK_PROXIMITY_BM25);
    
    //Se asignan pesos a los campos especificos.
    //Cada match suma 200 o 50 puntos respectivamente.
    //En otro campo un match va a sumar 1 punto.
    //El total aparece en el campo @weight de sphinx.
    //$CI->sphinxclient->SetFieldWeights(array('busqueda'=> 400));
    
    /*Reseteo filtros, para poder invocar el objeto y hacer filtros varias veces*/
    $CI->sphinxclient->ResetFilters();
    
    /* Asigno filtros */
    //Except: Campos que requieren AND logico.
    $excep = array();

    if(is_array($filters) && count($filters)>0){
        foreach($filters as $field=>$values){
          //En este caso, por cada campo se genera un filtro.
          //Sphinx toma como OR los valores posibles para mismo un campo si se definene en el mismo filtro.
          $CI->sphinxclient->SetFilter($field,$values);
        }
    }
    
    /* Hago la consulta */
    $result = $CI->sphinxclient->Query($string, $index); //String, Index
    
    /* Proceso resultado */
    if ($result === false) {
        //Tipicamente este caso va a ser por que Sphinx no esta corriendo.
        $message = "Query failed: " . $CI->sphinxclient->GetLastError();
    } else {
        if ($CI->sphinxclient->GetLastWarning()) {
            $message = "WARNING: " . $CI->sphinxclient->GetLastWarning() . "";
        }else{
            $status = TRUE;
            if(isset($result['matches'])){
                $result_set = $result['matches'];
            }else{
                $message = "Empty Set";
                $result_set = array();
            }
        }
    }
    
    return array($result_set,$status,$message,$result);
    
}

?>
