<?php

class Pagina extends Controller {

	function Pagina()
	{
		parent::Controller();	
	}
	
	function privacidad()
	{
		$data['title']='Pol&iacute;tica de Privacidad';
		$data['content']='pagina_privacidad';
		
		$this->load->view('template',$data);
	}
	
	function ayuda()
	{
		$data['title']='Ayuda';
		$data['content']='pagina_ayuda';
		
		$this->load->view('template',$data);
	}
	function faq()
	{
		$data['title']='Preguntas Frecuentes';
		$data['content']='pagina_faq';
		
		$this->load->view('template',$data);
	}
	function acercade()
	{
		$this->load->model('Servicios_model');

		$data['title']='Acerca De';
		$data['content']='pagina_acercade';
		$data['count_servicios'] = $this->Servicios_model->get_count();

		$this->load->view('template',$data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */