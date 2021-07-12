<?php
class si_rutas_model extends CI_Model {
	function listar(){
		$this->db->SELECT('*');	
		$this->db->From('rutas');
		$this->db->where('estado !=', 3);
		$query = $this->db->get();
		return $query->result();
	}

	function listarcargo(){
		$this->db->select('*');
		$this->db->from('nombre_cargos');
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result()as $row)
				$arrDatos[htmlspecialchars($row->id, ENT_QUOTES)]=htmlspecialchars($row->nombre, ENT_QUOTES);
			$query->free_result();
			return $arrDatos;
		}
	}

	function listargrupo(){
		$this->db->select('*');
		$this->db->from('grupo');
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result()as $row)
				$arrDatos[htmlspecialchars($row->id, ENT_QUOTES)]=htmlspecialchars($row->nombre_grupo, ENT_QUOTES);
			$query->free_result();
			return $arrDatos;
		}
	}

	function listarruta(){
		$this->db->select('*');
		$this->db->from('rutas');
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result()as $row)
				$arrDatos[htmlspecialchars($row->id, ENT_QUOTES)]=htmlspecialchars($row->nombre_rutas, ENT_QUOTES);
			$query->free_result();
			return $arrDatos;
		}
	}
	
	function ingresar($data){
		$this->db->insert('rutas',$data);
		return $this->db->insert_id(); 
	}
	
	function eliminar($id){
		$data = array('estado' => 3,
			'id_usuario' => $this->session->userdata('id'));
		$this->db->set($data);
		$this->db->where('id',$id);
		$this->db->update('rutas'); 
	}

	function actualizar_rutas($id,$data){
		$this->db->where('id',$id);
		$this->db->update('rutas',$data); 
		return $this->db->insert_id();
	}

	function get_rutas($id){
		$this->db->select("*");
		$this->db->from("rutas");
		$this->db->where("rutas.id",$id);
		$query = $this->db->get();
		return $query->result();
	}

	function listar_rutas(){
		$this->db->select('id, nombre_rutas');
		$this->db->from('rutas');
		$this->db->where('estado !=', 3);
		$query = $this->db->get();

		return $query->result();
	}

	function consultar_registro($nombre_rutas){
		$this->db->select('*');
		$this->db->from('rutas');
		$this->db->where('nombre_rutas', $nombre_rutas);
		$this->db->where('estado !=', 3);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

}