<?php
class Entidades_model extends Model {

    function Entidades_model()
    {
        parent::Model();
    }
    
    function get(){
    	$this->db->order_by('id','asc');
    	return $this->db->get('entidades');
    }
    

    
    function getById($id){
    	$this->db->from('entidades');
    	$this->db->where('id',$id);
    	return $this->db->get();
    }
    
    function getLike($query,$limit=NULL){
    	$this->db->from('entidades');
    	$this->db->like('entidad',$query);
    	if($limit)$this->db->limit($limit);
    	return $this->db->get();
    }
    
}
?>