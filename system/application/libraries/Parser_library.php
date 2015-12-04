<?php
class Parser_library{
		
  function readHTML($url){
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $result = new \stdClass();
		$result->html = curl_exec($curl);

		if(curl_error($curl))
			return false;

		$result->http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		//Removemos caracteres en blanco que harian conflicto con el trim luego de hacer decode.
		$result->html=str_replace('&nbsp;',' ',$result->html);

		// $encoding=mb_detect_encoding($result->html,'UTF-8,ISO-8859-1');
		$encoding=mb_detect_encoding($result->html);

		//echo $encoding.', memory: '.memory_get_usage(true).'<br />';
		if($encoding!='UTF-8'){
			//echo 'convierto '.$url.'<br />';
			$result->html=utf8_encode($result->html);
			//$html=iconv('utf-8','utf-8',$html);
		}
		//$result->html= html_entity_decode($result->html,ENT_COMPAT,'UTF-8');

    $tidy=new tidy();
    $result->html=$tidy->repairString($result->html,array(),'UTF8');
		return $result;
	}



function convertLinkToAbsolutePath($href,$sitio_url){
        if($href=='#')
            return NULL;

    	//Quitamos la ultima parte del sitio_url. Ej: http://www.a.cl/index.html, sacamos index.html
    	$sitio_url=preg_replace('/([^\/])+$/','',$sitio_url);
    	//Quitamos las cosas que se envian con get
    	$sitio_url=preg_replace('/\?.+$/','',$sitio_url);

    	$href=trim($href);
    	$href=str_replace(' ','%20',$href);

    	$base_url_arr=array();
    	preg_match('/https?:\/\/(\w+|\.)+/',$sitio_url,$base_url_arr);
    	$base_url=$base_url_arr[0];

    	$parsed_url='';

    	if($href){
	       	if(substr($href,0,1)=='/'){
	       		$parsed_url=$base_url.$href;
	       	}
	       	//Si es un link absoluto lo dejamos tal cual
			else if (preg_match('/http/i',$href))
	       		$parsed_url=$href;
	       	else {
	       		$parsed_url=$sitio_url.$href;
	       	}
    	}

       	return $parsed_url;
    }

    function convertStringtoNumber($string){
    	//return preg_replace('/\D/','',$string);
			$string=str_replace('$','',$string);
			$string=str_replace('&nbsp;','',$string);
    	$string=str_replace('.','',$string);
    	$string=str_replace(',','.',$string);
    	$number=(int) $string;
    	if ($number==0) $number=NULL;
    	return $number;
    }

    function convertStringToDate($string){
    	if(preg_match('/indefinid(o|a)/i',$string))
    		return '9999-12-31';

    	$string=trim($string);
    	$string=str_replace('.','/',$string);
    	$string=str_replace('-','/',$string);
    	$aux=explode('/',$string);
    	if(count($aux)==3){
    		$usadate=$aux[1].'/'.$aux[0].'/'.$aux[2];
    		$unixdate=strtotime($usadate);
    		if ($unixdate)
    			$mysqldate=date ("Y-m-d", $unixdate);
    		else
    			$mysqldate=NULL;
    	}
    	else
    		$mysqldate=NULL;

    	return $mysqldate;
    }

    function convertStringToString($string){
        return preg_replace('/\s+$/', '', $string);
    }
	
}
?>