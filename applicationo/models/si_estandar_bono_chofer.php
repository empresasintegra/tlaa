<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_estandar_bono_chofer extends CI_Model {

	function estandar_ruta($extraer_cargo, $extraer_tipo_contrato){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_ruta"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_produccion_2($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_produccion_2"');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		//$this->db->where('vuelta', $vuelta);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_2($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_cliente_2"');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		//$this->db->where('vuelta', $vuelta);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_produccion_6($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_produccion_6"');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		//$this->db->where('vuelta', $vuelta);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_6($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_cliente_6"');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		//$this->db->where('vuelta', $vuelta);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_produccion_8($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_produccion_8"');
		$this->db->where('cantidad_pallets', 8);
		//$this->db->where('vuelta', $vuelta);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_8($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_cliente_8"');
		$this->db->where('cantidad_pallets', 8);
		//$this->db->where('vuelta', $vuelta);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_vuelta_adicional_2($extraer_tipo_contrato, $extraer_cargo, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_vuelta_adicional_2"');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_vuelta_adicional_6($extraer_tipo_contrato, $extraer_cargo, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_vuelta_adicional_6"');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_vuelta_adicional_8($extraer_tipo_contrato, $extraer_cargo, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_chofer');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_vuelta_adicional_8"');
		$this->db->where('cantidad_pallets =', 8);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}



}

/* End of file si_estandar_bono_chofer.php */
/* Location: ./application/models/si_estandar_bono_chofer.php */