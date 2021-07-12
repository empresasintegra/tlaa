<?php
class Repuestos_model extends CI_Model {
	function listar(){
		$this->db->SELECT('*');
		$this->db->From('repuestos');
		/*$this->db->where('precio !=',2500);*/
		$query = $this->db->get();
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('repuestos',$data);
		return $this->db->insert_id();		
	}

	function consultar_registro($nombre){
		$this->db->select('*');
		$this->db->from('repuestos');
		$this->db->where('nombre_repuesto', $nombre);
		/*$this->db->where('estado !=', 3);*/
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function eliminar($id){
                $this->db->delete('repuestos', array('id' => $id)); 
    }

	function actualizar_repuestos($id,$data){
		$this->db->where('id',$id);
		$this->db->update('repuestos',$data); 
		return $this->db->insert_id();
	}

	function get_cargo($id){
		$this->db->select("*");
		$this->db->select('repuestos.id as id_repuestos');
		$this->db->from("repuestos");
		$this->db->where("repuestos.id",$id);
		$query = $this->db->get();
		return $query->result();
	}

}