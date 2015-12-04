<?php
class Usuarios_model extends Model {

    function Usuarios_model()
    {
        parent::Model();
    }
    
	function getUsuarioByUsuarioAndPassword($usuario,$password){
		$this->db->from('usuarios');
		$this->db->where('usuario', $usuario);
		$this->db->where('password', $password);
		$result=$this->db->get();
		return $result;
	}
	
	function getByUsuario($usuario){
		$this->db->from('usuarios');
		$this->db->where('usuario', $usuario);
		$result=$this->db->get();
		return $result;
	}
	
	function update($usuario,$data){
		$this->db->where('usuario', $usuario);
		$this->db->update('usuarios', $data); 
	}
    
   
}