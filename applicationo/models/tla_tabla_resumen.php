<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_tabla_resumen extends CI_Model {

	function borra_datos($fecha_inicio, $fecha_termino){
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');
		$this->db->delete('tabla_resumen_produccion');
	}

	function consultar_produccion($f){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $f);
		$query = $this->db->get();
		return $query->result();
	}

	function guarda_tabla_resumen_1($guardar_produccion_forma_2){
		$this->db->insert('tabla_resumen_produccion', $guardar_produccion_forma_2);
		return $this->db->insert_id();
	}

	function estado_cierre($actualiza_data, $f){
		$this->db->where('fecha_registro', $f);
		$this->db->update('ingreso_produccion', $actualiza_data);
	}


	function traer_dias_habiles($fecha_inicio,$fecha_termino){

		$this->db->select('count(*)');
		$this->db->from('preventas');
		$this->db->where('fecha_preventa BETWEEN "'. date('Y-m-d', strtotime($fecha_inicio)). '" and "'. date('Y-m-d', strtotime($fecha_termino)).'"');
		$query = $this->db->get();
        return $query->row();




	}


}

/* End of file tla_tabla_resumen.php */
/* Location: ./application/models/tla_tabla_resumen.php */