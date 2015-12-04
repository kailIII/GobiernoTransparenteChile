<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Usuarios_library {

	function login_check(){
		$CI =& get_instance();
		$CI->load->model('Usuarios_model');
		
		//if ($CI->uri->segment(1)=='usuarios' && $CI->uri->segment(2)=='login')
		//	return;
		
		$logged_in=$CI->session->userdata('logged_in');
		if (!$logged_in){
			//$CI->session->set_flashdata('redirect',uri_string());
			//$redirect=uri_string();
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
				//redirect('usuarios/login');
				header('WWW-Authenticate: Basic realm="Area restringida"');
	   	 		header('HTTP/1.0 401 Unauthorized');
	   	 		echo 'No autorizado';
	   	 		exit;
			}
			else{
				//echo $_SERVER['PHP_AUTH_USER'];
				$usuario=$CI->Usuarios_model->getUsuarioByUsuarioAndPassword($_SERVER['PHP_AUTH_USER'],sha1($_SERVER['PHP_AUTH_PW']))->row();
				if(empty($usuario)){
					echo 'Usuario y password no coinciden';
					exit;
				}
				else{
					$CI->session->set_userdata(array('logged_in'=>TRUE,'usuario'=> $usuario->usuario));
					//$redirect=$CI->session->flashdata('redirect');
					//if ($redirect)
					//	redirect($redirect);
					//else
					//	redirect('');
				}
			}
		}
		
	}
}

?>