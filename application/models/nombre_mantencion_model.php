<?php
class Nombre_mantencion_model extends CI_Model {
	function listar(){
		 $this->db->SELECT('*');
		$this->db->From('nombres_mantencion');
		$query = $this->db->get();
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('nombres_mantencion',$data);
		return $this->db->insert_id();		
	}

	function eliminar($id){
                $this->db->delete('nombres_mantencion', array('id' => $id)); 
    }

	function actualizar_nombre($id,$data){
		$this->db->where('id',$id);
		$this->db->update('nombres_mantencion',$data); 
		return $this->db->insert_id();
	}

	function get_nombre($id){
		$this->db->select("*");
		$this->db->from("nombres_mantencion");
		$this->db->where("nombres_mantencion.id",$id);
		$query = $this->db->get();
		return $query->result();
	}

}