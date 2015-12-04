<?php
class Busquedas_model extends Model {

    function Busquedas_model()
    {
        parent::Model();
    }
    
    function get($order_by='contador desc', $limit=NULL){
    	$this->db->from('busquedas');
    	
    	if($limit)
    		$this->db->limit($limit);
    	
    	if ($order_by)
    		$this->db->order_by($order_by);
    		
    	return $this->db->get();
    }

    function getByBusqueda($busqueda){
    	$this->db->from('busquedas');
    	$this->db->where('busqueda',$busqueda);
    	return $this->db->get();
    }
    
	function insert($busqueda,$contador,$nresultados){ 	
    	$data=array('busqueda'=>$busqueda,
    				'contador'=>$contador,
    				'nresultados'=>$nresultados
    		);
    	
    	$this->db->insert('busquedas',$data);
    }
    
    function delete($busqueda){
    	$this->db->where('busqueda',$busqueda);
    	$this->db->delete('busquedas');
    }
    
    function update($busqueda, $data){
    	$this->db->where('busqueda', $busqueda);
		$this->db->update('busquedas', $data); 
    }
    
	function getLikeInBusqueda($query, $order_by='contador desc', $limit=NULL){    	
			$idResultados = array();
			$this->load->library('sphinxclient');
			$this->load->helper('sphinx');

			$search_result = search_busqueda_ajax($query, null, $limit, 0);

			if($search_result[0]){
				foreach ($search_result[0] as $id => $resultado) {
					$idResultados[] = $id;
				}

	    	$this->db->from('busquedas');
	    	$this->db->where_in('id', $idResultados);
	    	
	    	if ($order_by)
	    		$this->db->order_by($order_by);
	    	
	    	return $this->db->get();
			}else{
				return null;
			}
    }
}
?>