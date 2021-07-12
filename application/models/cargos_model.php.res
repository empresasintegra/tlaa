<?php
class Cargos_model extends CI_Model {
	function listar(){
		$this->db->SELECT('*');	
		$this->db->SELECT('cargos.id as id_cargo');	
		$this->db->From('cargos');
		$this->db->where('estado !=', 3);		
		//$this->db->join('rutas','cargos.id_rutas = rutas.id','left');
		//$this->db->join('grupo', 'cargos.id_grupo = grupo.id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('cargos',$data);
		return $this->db->insert_id();		
	}

	function consultar_registro($nombre){
		$this->db->select('*');
		$this->db->from('cargos');
		$this->db->where('nombre', $nombre);
		$this->db->where('estado !=', 3);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}


	}
	function eliminar($id){
		$data = array('estado' => 3,
			'id_usuario' => $this->session->userdata('id'));
		$this->db->set($data);
		$this->db->where('id',$id);
		$this->db->update('cargos'); 
	}

	function actualizar_cargos($id,$data){
		$this->db->where('id',$id);
		$this->db->update('cargos',$data); 
		return $this->db->insert_id();
	}

	function get_cargo($id){
		$this->db->select("*");
		$this->db->select('cargos.id as id_cargo');
		$this->db->from("cargos");
		$this->db->where("cargos.id",$id);
		$query = $this->db->get();
		return $query->result();
	}

}