<?php

class Aux extends Controller {

	function Aux()
	{
		parent::Controller();		
		$this->load->library('form_validation');
		$this->load->model('Servicios_model');

	}
	
	

	
	function servicios(){		
		$servicios=$this->Servicios_model->get('servicio asc')->result();
		$data['servicios']=$servicios;
		$data['show_search']=false;
		$data['show_tabs']=false;
		$data['show_bar']=false;
		$data['title']='Servicios';
		$data['content']='aux_servicios';
		$this->load->view('template',$data);
	}
	
	function check_css(){
		$this->load->library('parser_library');
		$this->load->library('simple_html_dom');
		$servicios=$this->Servicios_model->get('id asc')->result();
		
		header('Content-Type: text/html; charset=UTF-8');
		
		foreach($servicios as $s){
			echo '<h3>'.$s->servicio.'</h3>';
			$read=$this->parser_library->readHTML($s->url);
			if($read === false){
				echo '<p>Timeout</p>';
			}elseif ($read->http_code==200){
				$html_dom = str_get_html($read->html);
				$link=$html_dom->find('link');
				echo '<p>Archivos CSS:</p>';
				echo '<ul>';
				foreach($link as $l)
					echo '<li>'.$l->href.'</li>';
				echo '</ul>';
			}
			else
				echo '<p>Pagina no encontrada</p>';
		}
		
		
	}
	

}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */