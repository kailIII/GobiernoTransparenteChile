<?php

class Parser_planilla {

    protected $reglas;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('Planillas_model');
        $this->CI->load->model('Directorio_model');
        $this->model = NULL;
        $this->nombre_pagina = NULL;
        $this->nombre = NULL;
    }

    function start($servicio_id) {
        $result = new \stdClass();
        $result->nombre = $this->nombre;

        $antiguas = $this->CI->Directorio_model->getByServiciosIdAndDeprecated($servicio_id, TRUE)->result();
        foreach ($antiguas as $a) {
            $this->CI->Directorio_model->delete($a->id);
        }
        $this->model->clean();

        /* $antiguas=$this->model->getByServiciosIdAndDeprecated($servicio_id,TRUE)->result();
          foreach($antiguas as $a){
          $this->model->delete($a->id);
          $this->CI->Directorio_model->delete($a->directorio_id);

          } */

        $directorio = $this->CI->Directorio_model->getByServiciosIdAndPagina($servicio_id, $this->nombre_pagina)->result();

        $results = array();
        foreach ($directorio as $dir)
            if ($dir->url && !$dir->blacklisted)
                $results[] = $this->process($dir->id);

        $result->results = $results;

        return $result;
    }

    private function process($directorio_id) {
        $result = new \stdClass();
        $directorio = $this->CI->Directorio_model->getById($directorio_id)->row();
        $url = $directorio->url;
        $result->url = $url;

        $servicios_id = $directorio->servicios_id;



        $parser = $this->parser($url);

        if ($parser->status != 'Ok') {
            $result->status = $parser->status;
        } else {
            $results = $parser->records;


            foreach ($results as $valor) {
                $valor['directorio_id'] = $directorio_id;
                $this->model->insert($valor);
            }
            $result->status = 'Ok';
        }

        $directorio->parsed = $result->status;
        $this->CI->Directorio_model->update($directorio->id, $directorio);

        return $result;
    }

    function parser($url) {
        $paginas = array($url);

        //Vemos si tiene filtro de categorias (Combobox)
        $read = $this->CI->parser_library->readHTML($url);
        if($read === false){
        	$result = new stdClass;
        	$result->status = 'Fail - Timeout';
        	$result->records = array();
        	return $result;
        }

        $html = $read->html;
        $html_dom = str_get_html($html);
        $categorias = $html_dom->find(".filtroCategorias option");
        foreach ($categorias as $c)
            $paginas[] = $this->CI->parser_library->convertLinkToAbsolutePath($c->value . '.html', $url);
        $paginas = array_unique($paginas);
        $html_dom->clear();
        //

        $urls_a_procesar = array();
        foreach ($paginas as $p) {
            $url = $p;
            echo 'Parseo url: ' . $url . ' ' . number_format(memory_get_usage(true), 0) . "\n";
            $urls_a_procesar[] = $url;


            $html = $this->CI->parser_library->readHTML($url)->html;

            $html_dom = str_get_html($html);

            //Chequeamos si tiene multiples paginas
            $center = $html_dom->find('center',0);
            if ($center) {
                $anchors = $center->find('a');
                if ($anchors && $anchors[0]->plaintext == '2') {
                    foreach ($anchors as $a)
                        $urls_a_procesar[] = $this->CI->parser_library->convertLinkToAbsolutePath($a->href, $url);
                }
            }


            $html_dom->clear();
            $result->records = array();
            $result->status = 'Ok';

            foreach ($urls_a_procesar as $u) {
                $aux = $this->processPage($u);
                if ($aux->status == 'Ok') {
                    $result->records = array_merge($result->records, $aux->records);
                    //print_r($aux->records);
                }
                else
                    $result->status = $aux->status;
            }
        }
        return $result;
    }

    function processPage($url) {
        $result = new \stdClass();
        $records = array();

        $html = $this->CI->parser_library->readHTML($url)->html;

        //echo $html;

        $html_dom = str_get_html($html);

        //Verificamos que es una pagina que sigue el estandar
        $div_detalle = $html_dom->find('.detalle');
        if (!empty($div_detalle)) {
            //Verificamos que tiene una tabla
            $table = $html_dom->find('.detalle table');
            if (!empty($table)) {
                //Buscamos en que columna esta cada campo
                $header_cols = $html_dom->find('.detalle table th');
                $rows = $html_dom->find('.detalle table tr');
                if (empty($header_cols)) {
                    $header_cols = $html_dom->find('.detalle table thead tr');
                    $rows = $html_dom->find('.detalle table tbody tr');
                }
                if (!empty($header_cols) && !empty($rows)) {
                    foreach ($this->reglas as $key => $val)
                        $campos_id[$key] = -1;

                    foreach ($header_cols as $col_id => $hr) {
                        foreach ($this->reglas as $key => $val)
                            if (preg_match('/' . $val->keyword . '/is', $hr->innertext))
                                $campos_id[$key] = $col_id;
                    }

                    foreach ($rows as $row) {
                        //$fila=$element->innertext;
                        //$dom=str_get_html($fila);
                        $cells = $row->find('td');

                        if (!empty($cells)) {
                            foreach ($campos_id as $campo => $campo_id) {
                                if ($campo_id != -1 && isset($cells[$campo_id]) && !$this->_isBlank($cells[$campo_id]->innertext))
                                    if ($this->reglas[$campo]->type == 'numeric')
                                        $valor[$campo] = $this->CI->parser_library->convertStringtoNumber($cells[$campo_id]->plaintext);
                                    else if ($this->reglas[$campo]->type == 'url') {
                                        $anchor = $cells[$campo_id]->find('a', 0);
                                        if ($anchor)
                                            $valor[$campo] = '<a target="_blank" href="' . $this->CI->parser_library->convertLinkToAbsolutePath($anchor->href, $url) . '">' . $anchor->innertext . '</a>';
                                        else
                                            $valor[$campo] = $cells[$campo_id]->innertext;
                                    }
                                    else if ($this->reglas[$campo]->type == 'date')
                                        $valor[$campo] = $this->CI->parser_library->convertStringToDate($cells[$campo_id]->plaintext);
                                    else
                                        $valor[$campo] = trim(preg_replace('/\s\s+/', ' ', $cells[$campo_id]->plaintext));
                                else
                                    $valor[$campo] = NULL;
                            }

                            //Lo agregamos si no estan todos los datos en blanco
                            if ($this->_isValidRecord($valor))
                                $records[] = $valor;
                        }
                        //$dom->clear();
                    }


                    $result->records = $records;


                    $result->status = 'Ok';
                }
                else {
                    $result->status = 'Fail: Estructura de html no estandar: No hay filas o cabeceras en tabla';
                }
            } else {
                $message = preg_replace('/Última actualización:\d+\/\d+\/\d+/i', '', $div_detalle[0]->plaintext);
                $message = trim($message);
                $result->status = 'Message: ' . $message;
            }
        } else {
            $result->status = 'Fail: Pagina no sigue estandar, no tiene div de detalle.';
        }





        $html_dom->clear();
        return $result;
    }

    private function _isValidRecord($record) {
        foreach ($record as $value)
            if (trim($value) != '')
                return true;
        return false;
    }

    private function _isBlank($value) {
        if (preg_match('/^(-|\s)*$/', $value))
            return true;
        else
            return false;
    }

}

?>