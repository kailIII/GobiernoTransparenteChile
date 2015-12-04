<?php
class Consejo_decisiones_model extends Model {

    function Consejo_amparos_model()
    {
        parent::Model();
    }
    
    function get(){
    	return $this->db->get('consejo_decisiones');
    }
    
    function insert($record){
    	$this->db->insert('consejo_decisiones',$record);
    }
    
    function clear(){
    	$this->db->truncate('consejo_decisiones');
    }
    

}
?>