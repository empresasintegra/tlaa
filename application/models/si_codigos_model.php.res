<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_codigos_model extends CI_Model {

	function listar(){
		$this->db->select('*');
		$this->db->from('codigos_ccu');
		$this->db->where('eliminado', 1);
		$query = $this->db->get();

		return $query->result();
	}

	function consultar_registro($codigo){
		$this->db->select('*');
		$this->db->from('codigos_ccu');
		$this->db->where('codigos_ccu', $codigo);
		$this->db->where('eliminado !=', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function guarda_registro($data){
		$this->db->insert('codigos_ccu', $data);
		return $this->db->insert_id();
	}

	function eliminar($id){
		$data = array('eliminado' => 2, );
		$this->db->where('idcodigos_ccu', $id);
		$this->db->update('codigos_ccu', $data);
	}

	function listar_camion(){
		$this->db->select('idcodigos_ccu as id, codigos_ccu as code');
		$this->db->from('codigos_ccu');
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 1);
		$query = $this->db->get();

		return $query->result();
	}
	function obtener_id_codigo($codigoccu){
		$this->db->select('*');
		$this->db->from('codigos_ccu');
		$this->db->where('codigos_ccu',$codigoccu);
		$query = $this->db->get();
		return $query->row();
	}

	function obtener_id($idcodigos_ccu){
		$this->db->select('');
		$this->db->from('codigos_ccu');
		$this->db->where('idcodigos_ccu',$idcodigos_ccu);
		$query = $this->db->get();
		return $query->row();
	}

	function getNombrePersona($id){
		$this->db->select('*');
		$this->db->from('persona');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

}

/* End of file Si_codigos_model.php */
/* Location: ./application/models/Si_codigos_model.php */