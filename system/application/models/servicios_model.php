<?php
class Servicios_model extends Model {

    function Servicios_model()
    {
        parent::Model();
    }
    
    function get($order_by='id asc'){
    	$this->db->order_by($order_by);
    	return $this->db->get('servicios');
    }

    function get_count(){
    	$this->db->where('activo', 1);
    	return $this->db->count_all_results('servicios');
    }
    
    /*function getServiciosWithDirectorio(){
    	return $this->db->query('select distinct servicios.* from servicios, directorio
								where servicios.id=directorio.servicios_id');
    }*/
    
    function getById($id){
    	$this->db->from('servicios');
    	$this->db->where('id',$id);
    	return $this->db->get();
    }
    
	function getByEntidadesId($entidades_id){
    	$this->db->from('servicios');
    	$this->db->where('entidades_id',$entidades_id);
    	$this->db->order_by('orden','asc');
    	return $this->db->get();
    }
    
    function update($id, $data){
    	$this->db->where('id', $id);
		$this->db->update('servicios', $data); 
    }
    
	function getLike($query, $limit=NULL){
    	$this->db->from('servicios');
    	$this->db->like('servicio',$query);
    	if($limit)$this->db->limit($limit);
    	return $this->db->get();
    }
    
}
?>