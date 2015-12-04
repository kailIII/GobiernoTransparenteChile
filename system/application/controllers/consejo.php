<?php

class Consejo extends Controller {

	function Consejo()
	{
		parent::Controller();		
		$this->load->model('Consejo_decisiones_model');

	}
	
	function decisiones(){
		$decisiones=$this->Consejo_decisiones_model->get()->result();
		
		$data['decisiones']=$decisiones;
		$data['title']='Decisiones';
		$data['content']='consejo_decisiones';
		
		$this->load->view('template',$data);
	}
	

	

}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */