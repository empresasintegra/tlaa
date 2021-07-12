<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_cierre_diario extends CI_Model {

	function consulta_cierre_diario($rm){
		$this->db->select('fecha_registro, estado_cierre');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $rm);
		//$this->db->where('estado_cierre', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function abrir_dias_seleccionados($valores){
		$estado_cierre = array('estado_cierre' => 2);
		$this->db->where('fecha_registro', $valores);
		$this->db->update('ingreso_produccion', $estado_cierre);
	}

	function cerrar_dias_seleccionados($valores){
		$estado_cierre = array('estado_cierre' => 1);
		$this->db->where('fecha_registro', $valores);
		$this->db->update('ingreso_produccion', $estado_cierre);
	}	

}

/* End of file tla_cierre_diario.php */
/* Location: ./application/models/tla_cierre_diario.php */