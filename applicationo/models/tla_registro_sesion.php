<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_registro_sesion extends CI_Model {

	function guardar_sesion($datos_sesion){
		$this->db->insert('tla_registro_sesion', $datos_sesion);
		return $this->db->insert_id();
	}

	function actualizar_cierre_sesion($datos_sesion_salir, $id_registro_login){
		$this->db->where('id', $id_registro_login);
		$this->db->update('tla_registro_sesion', $datos_sesion_salir);
	}

	function consultar_rechazos_mayo(){
		$this->db->select('*');
		$this->db->from('resumen_rechazo');
		$this->db->where('fecha_registro between "2017-05-02" and "2017-05-31"');
		$query = $this->db->get();
		return $query->result();
	}

	function consultar_id_sccu($s_ccu){
		$this->db->select('*');
		$this->db->from('codigos_ccu');
		$this->db->where('codigos_ccu', $s_ccu);
		$query = $this->db->get();
		return $query->row();
	}


	function consultar_registro_produccion($id_camion, $fecha){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('fecha_registro', $fecha);
		$this->db->where('vuelta', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_registro_produccion($id){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function ingresar_rechazos($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('ingreso_produccion', $datos);
	}



}

/* End of file tla_registro_sesion.php */
/* Location: ./application/models/tla_registro_sesion.php */