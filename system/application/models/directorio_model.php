<?php

class Directorio_model extends Model {

    function Directorio_model() {
        parent::Model();
    }

    function get($where=NULL) {
        $this->db->select('directorio.*, servicios.servicio as servicio, servicios.entidades_id as entidades_id, servicios.url as servicios_url');


        $this->db->from('directorio');



        $this->db->join('servicios', 'servicios.id=directorio.servicios_id', 'left');

        foreach ($where as $key => $val)
            $this->db->where('directorio.' . $key, $val);

        $this->db->order_by('servicios_id asc');

        return $this->db->get();
    }

    function getByServiciosIdAndPagina($servicios_id, $pagina, $subseccion1=NULL, $subseccion2=NULL, $group_by = null) {
        $this->db->select('servicios.entidades_id as entidades_id,directorio.*');
        $this->db->join('servicios', 'servicios.id=directorio.servicios_id');
        $this->db->where('servicios_id', $servicios_id);
        $this->db->where('pagina', $pagina);
        
        if ($subseccion1 != NULL)
            $this->db->where('(trim(subseccion1) = '.$this->db->escape($subseccion1).' OR alias_subseccion1 = '.$this->db->escape($subseccion1).')');
        if ($subseccion2 != NULL)
            $this->db->where('(trim(subseccion2) = '.$this->db->escape($subseccion2).' OR alias_subseccion2 = '.$this->db->escape($subseccion2).')');

        if($group_by){
        	$this->db->group_by($group_by);
        }
        
        return $this->db->get('directorio');
    }

    function getByServiciosId($servicios_id, $order_by='id asc', $group_by = null) {
        $this->db->from('directorio');
        $this->db->where('servicios_id', $servicios_id);
        $this->db->order_by($order_by);
        if($group_by){
        	$this->db->group_by($group_by);
        }
        return $this->db->get();
    }

    function getByServiciosIdAndDeprecated($servicios_id, $deprecated) {
        $this->db->from('directorio');
        $this->db->where('servicios_id', $servicios_id);
        $this->db->where('deprecated', $deprecated);
        return $this->db->get();
    }

    function getById($id) {
        $this->db->from('directorio');
        $this->db->where('id', $id);
        return $this->db->get();
    }

    function insert($directorio) {
    	if(isset($directorio->subseccion1)){
    		$directorio->alias_subseccion1 = url_title($directorio->subseccion1);
    	}
    	if(isset($directorio->subseccion2)){
    		$directorio->alias_subseccion2 = url_title($directorio->subseccion2);
    	}
      $this->db->insert('directorio', $directorio);
    }

    function clear() {
        $this->db->truncate('directorio');
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('directorio');
    }

    function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('directorio', $data);
    }

    function updateByServiciosId($servicios_id, $data) {
        $this->db->where('servicios_id', $servicios_id);
        $this->db->update('directorio', $data);
    }

}

?>