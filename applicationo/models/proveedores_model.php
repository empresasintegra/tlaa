<?php
class Proveedores_model extends CI_Model {
	function listar(){
		 $this->db->SELECT('*');
		$this->db->From('mantenciones_proveedores');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('mantenciones_proveedores',$data);
		return $this->db->insert_id();		
	}

	function eliminar($id){
        $this->db->delete('mantenciones_proveedores', array('id' => $id)); 
    }

	function actualizar_proveedor($id,$data){
		$this->db->where('id',$id);
		$this->db->update('mantenciones_proveedores',$data); 
		return $this->db->insert_id();
	}

	function get_proveedor($id){
		$this->db->select("*");
		$this->db->from("mantenciones_proveedores");
		$this->db->where("mantenciones_proveedores.id",$id);
		$query = $this->db->get();
		return $query->result();
	}

	function consultar_registro($rut){
		$this->db->select('*');
		$this->db->from('mantenciones_proveedores');
		$this->db->where('rut', $rut);
		/*$this->db->where('estado !=', 3);*/
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}
}