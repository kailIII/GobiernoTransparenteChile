<?php
include_once('Parser_library.php');

class Parser_consejo extends Parser_library{
		
	function __construct(){
		parent::__construct();	

		$this->CI->load->model('Consejo_decisiones_model');
	}
	
	function start(){
		$url_inicial='http://www.consejotransparencia.cl/app_casos/frontend/modules/index.html?modulo=caso&accion=ListarUltimasDecisiones';
		
		$read=$this->readHTML($url_inicial);
		if ($read->http_code!=200){
			$result->status='URL no existe';
			return $result;
		}
		
		$html_dom=str_get_html($read->html);
		
		//Vemos cuales son las multiples paginas
		$urls_a_procesar[]=$url_inicial;
		$anchors=$html_dom->find('.box-res-left',0)->find('a');
		foreach ($anchors as $a)
			$urls_a_procesar[]=$this->convertLinkToAbsolutePath($a->href,'http://www.consejotransparencia.cl/app_casos/frontend/modules/');
                $urls_a_procesar=array_unique($urls_a_procesar);


		//Los procesamos
		//$decisiones=array();
		foreach($urls_a_procesar as $u){
                    $decisiones=$this->processPage($u);
                    foreach($decisiones as $a)
                        $this->CI->Consejo_decisiones_model->insert($a);
		}
		
		//Almacenamos en la base de datos
		//$this->CI->Consejo_decisiones_model->clear();
		//foreach($decisiones as $a)
		//	$this->CI->Consejo_decisiones_model->insert($a);
	
		return;
		
	}
	
	function processPage($url){		
		$read=$this->readHTML($url);
				
		$html_dom=str_get_html($read->html);
		
		$filas=$html_dom->find('.tabla-res .tr-estilo-fondoceleste');
		
		foreach($filas as $f){
			$decision->rol=trim($f->find('td',0)->plaintext);
			$decision->tipo_de_caso=trim($f->find('td',1)->plaintext);
                        $decision->fecha_despacho=$this->convertStringToDate($f->find('td',2)->plaintext);
                        $decision->reclamante=trim($f->find('td',3)->plaintext);
                        $decision->reclamado=trim($f->find('td',4)->plaintext);
                        $decision->decision=trim($f->find('td',5)->plaintext);
                        if($f->find('td',5)->find('a'))
                            $decision->url=$this->convertLinkToAbsolutePath($f->find('td',5)->find('a',0)->href,'http://www.consejotransparencia.cl/');
			$decision->descripcion=trim($f->find('td',6)->plaintext);
                        //$url=$this->convertLinkToAbsolutePath($titular->href,'http://www.consejotransparencia.cl/');
			//$bajadas=$f->find('.bajada');
			//$entidad_publica=trim(preg_replace('/\<strong\>.*\<\/strong\>/i','',$bajadas[0]->innertext));
			//$requirente=trim(preg_replace('/\<strong\>.*\<\/strong\>/i','',$bajadas[1]->innertext));
			//$fecha_decision=$this->convertStringToDate(preg_replace('/\<strong\>.*\<\/strong\>/i','',$bajadas[2]->innertext));
			
			//$amparo->nombre=$nombre;
			//$amparo->url=$url;
			//$amparo->entidad_publica=$entidad_publica;
			//$amparo->requirente=$requirente;
			//$amparo->fecha_decision=$fecha_decision;
                        //print_r($decision);
                        //return;
			
			$decisiones[]=clone $decision;
		}

		
		return $decisiones;
	}
	

	

	
}
?>