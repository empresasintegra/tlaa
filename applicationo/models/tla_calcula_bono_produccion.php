<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_calcula_bono_produccion extends CI_Model {

	function extraer_info($fecha){
		$this->db->select('*');
		$this->db->from('tabla_resumen_produccion');
		$this->db->where('fecha_registro', $fecha);
		$query = $this->db->get();
		return $query->result();		
	}

	function buscar_ruta_guardada($id_trabajador, $fecha){
		$this->db->select('bono_ruta');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->where('fecha_registro', $fecha);
		$this->db->where('bono_ruta', 1600);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}
}

/* End of file tla_calcula_bono_produccion.php */
/* Location: ./application/models/tla_calcula_bono_produccion.php */