<?php
class si_colectivo_model extends CI_Model {
	function listar(){
		$this->db->SELECT('*');	
		$this->db->From('instrumento_colectivo');
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
		$this->db->insert('instrumento_colectivo',$data);
		return $this->db->insert_id(); 
	}
	function eliminar($id){			
		$data = array(
			'estado' => 3 );
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('instrumento_colectivo');

		
	}

	function actualizar_colectivo($id,$data){
		$this->db->where('id',$id);
		$this->db->update('instrumento_colectivo',$data); 
		return $this->db->insert_id();
	}

	function get_colectivo($id){
		$this->db->select("*");
		$this->db->from("instrumento_colectivo");
		$this->db->where("instrumento_colectivo.id",$id);
		$query = $this->db->get();
		return $query->result();
	}

	function tipo_cargo_trabajador($id){
		$this->db->select('*');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id);
		$this->db->where('id_estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function tipo_cargo_ayudante($id_ayudante_1){
		$this->db->select('*');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id_ayudante_1);
		$this->db->where('id_estado', 1);
		$query = $this->db->get();
		return $query->row();		
	}

	function tipo_cargo_ayudante_2($id_ayudante_2){
		$this->db->select('*');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id_ayudante_2);
		$this->db->where('id_estado', 1);
		$query = $this->db->get();
		return $query->row();		
	}

	function tipo_cargo_ayudante_3($id_ayudante_3){
		$this->db->select('*');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id_ayudante_3);
		$this->db->where('id_estado', 1);
		$query = $this->db->get();
		return $query->row();		
	}

	function tipo_cargo_ayudante_4($id_ayudante_4){
		$this->db->select('*');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id_ayudante_4);
		$this->db->where('id_estado', 1);
		$query = $this->db->get();
		return $query->row();		
	}

}