<?php
class Consulta_model extends CI_Model {
	

	function consultar_camiones(){//consulta a la tabla camiones
		$this->db->SELECT('*');
		$this->db->FROM('camiones');
		$this->db->order_by("patente","asc");
		$query = $this->db->get();
		return $query->result();
	}

	function consultar_codigosccu($id_camion){
		$this->db->SELECT('codigos_ccu.codigos_ccu as codigo');
		$this->db->FROM('codigos_ccu');
		$this->db->join('ccu_camion ', 'codigos_ccu.idcodigos_ccu = ccu_camion.codigo_ccu', 'left');
		$this->db->join('camiones ', 'camiones.id = ccu_camion.codigo_camion', 'left');
		$this->db->where('camiones.id', $id_camion);
		$this->db->where('ccu_camion.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}
	
	function consultar_produccion($fecha){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('caja_reales >0');
		$this->db->where('fecha_registro',$fecha);
		$this->db->group_by('id_camion, vuelta');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_camiones_codigo($id){
		$this->db->select('c_ccu.codigos_ccu as codigo, c_ccu.idcodigos_ccu as id_ccu, c_camiones.pallets as pallets');
		$this->db->from('codigos_ccu c_ccu');
		$this->db->join('ccu_camion c_camion', 'c_ccu.idcodigos_ccu = c_camion.codigo_ccu', 'left');
		$this->db->join('camiones c_camiones', 'c_camiones.id = c_camion.codigo_camion', 'left');
		$this->db->where('c_camion.estado', 1);
		$this->db->where('c_camiones.idy', $id);
		$this->db->order_by('pallets','desc');
		$query = $this->db->get();
		return $query->row();
	}


}