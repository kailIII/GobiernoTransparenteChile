<?php

class Usuarios extends Controller {

	function Usuarios()
	{
		parent::Controller();
		$this->load->model('Usuarios_model');
		$this->load->library('form_validation');
	}
	
	function login()
	{
		$this->form_validation->set_rules('usuario', 'usuario', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

        $data['referer'] = $this->session->userdata('referer')?$this->session->userdata('referer'):'';
		
		if ($this->form_validation->run() == TRUE){
			$usuario=$this->Usuarios_model->getUsuarioByUsuarioAndPassword($_POST['usuario'],sha1($_POST['password']))->row();
			if(empty($usuario)){
				$data['message']='Usuario y password no coinciden';
			}
			else{
				$this->session->set_userdata(array('logged_in'=>TRUE,'usuario'=> $usuario->usuario));
				redirect($data['referer']);
			}
			
		}
		$this->load->view('usuarios_login',$data);
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */