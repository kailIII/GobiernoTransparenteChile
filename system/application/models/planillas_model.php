<?php

class Planillas_model extends Model {


    function Planillas_model() {
        parent::Model();

        $this->nombre_tabla=NULL;
        $this->search_cols=array();
    }

    function insert($data) {

        $this->db->insert($this->nombre_tabla, $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->nombre_tabla);
    }

    function deleteByDirectorioId($directorio_id) {
        $this->db->where('directorio_id', $directorio_id);
        $this->db->delete($this->nombre_tabla);
    }
    
    //Limpia los registros que no tienen correspondencia en la tabla directorio.
    function clean() {
        $this->db->query('DELETE '.$this->nombre_tabla.' FROM '.$this->nombre_tabla.'
        LEFT JOIN directorio on '.$this->nombre_tabla.'.directorio_id=directorio.id
        WHERE directorio.id IS NULL');   
    }

    function getByServiciosIdAndDeprecated($servicios_id, $deprecated) {
        $this->db->select($this->nombre_tabla.'.*');
        $this->db->join('directorio','directorio.id='.$this->nombre_tabla.'.directorio_id');
        $this->db->where('directorio.servicios_id', $servicios_id);
        $this->db->where('directorio.deprecated', $deprecated);
        return $this->db->get($this->nombre_tabla);
    }

    function getByServiciosId($servicios_id, $limit=NULL, $offset=NULL, $sort='id', $direction='asc') {
        $this->db->select($this->nombre_tabla.'.*');
        $this->db->join('directorio','directorio.id='.$this->nombre_tabla.'.directorio_id');
        $this->db->where('directorio.servicios_id', $servicios_id);
        $this->db->order_by($this->nombre_tabla.'.'.$sort, $direction);
        if($limit && $offset)$this->db->limit($limit, $offset);
        return $this->db->get($this->nombre_tabla);
    }

    function countByServiciosIdAndsubseccion1Andsubseccion2($servicios_id, $subseccion1, $subseccion2) {
        $this->db->from($this->nombre_tabla);
        $this->db->join('directorio','directorio.id='.$this->nombre_tabla.'.directorio_id');
        $this->db->where('directorio.servicios_id', $servicios_id);
        $this->db->where('servicios_id', $servicios_id);
        $this->db->where('subseccion1', $subseccion1);
        $this->db->where('subseccion2', $subseccion2);
        return $this->db->count_all_results();
    }

    function getByServiciosIdAndsubseccion1Andsubseccion2($servicios_id, $subseccion1, $subseccion2, $limit=NULL, $offset=NULL, $sort='id', $direction='asc') {
        $this->db->select($this->nombre_tabla.'.*');
        $this->db->join('directorio','directorio.id='.$this->nombre_tabla.'.directorio_id');
        $this->db->where('directorio.servicios_id', $servicios_id);
        $this->db->where('servicios_id', $servicios_id);
        $this->db->where('subseccion1', $subseccion1);
        $this->db->where('subseccion2', $subseccion2);
        $this->db->order_by($this->nombre_tabla.'.'.$sort, $direction);
        if($limit!==NULL && $offset!==NULL)$this->db->limit($limit, $offset);
        return $this->db->get($this->nombre_tabla);
    }



    function query($query, $servicios=NULL,$limit = 10, $offset = 0) {
    	  $idResultados = array(null);
				$this->load->library('sphinxclient');
				$this->load->helper('sphinx');

				$search_result = search($query, null, $this->nombre_tabla, $limit, $offset);
				$total = $search_result[3]['total_found'];

        //Parche para que mysql haga las busquedas como la gente.
        $aux = explode(' ', $query);
        foreach ($aux as &$a)
            if (strlen($a) >= 4)
                $a = '+"' . $a . '"';
        $query = implode(' ', $aux);

        $this->db->select('servicios.servicio as servicio,
            servicios.id as servicios_id,
            servicios.entidades_id as entidades_id,
            directorio.subseccion1 as subseccion1,
            directorio.subseccion2 as subseccion2,'
            .$this->nombre_tabla.'.*');


        $this->db->join('directorio', 'directorio.id='.$this->nombre_tabla.'.directorio_id', 'left');
        $this->db->join('servicios', 'directorio.servicios_id=servicios.id', 'left');
        if ($servicios)
            $this->db->where_in('servicios_id', $servicios);

        if($search_result[0]){
    	  	$idResultados = array();
        	foreach ($search_result[0] as $id => $resultado) {
						$idResultados[] = $id;
					}
				}

       	$this->db->where_in($this->nombre_tabla.'.id', $idResultados);

	      //Busqueda antigua sin sphinx
	      // $this->db->where("MATCH (".implode(',', $this->search_cols).") AGAINST ('" . $query . "' in BOOLEAN MODE)", NULL, FALSE);

        return array('query' => $this->db->get($this->nombre_tabla), 'total' => $total);
    }

}

?>