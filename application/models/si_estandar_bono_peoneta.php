<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_estandar_bono_peoneta extends CI_Model {

	function estandar_ruta($extraer_cargo, $extraer_tipo_contrato){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('nombre_bono = "bono_ruta"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 1);
		//$this->db->where('nombre_bono = "bono_produccion_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_produccion_tripulantes_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', 8);
		$this->db->where('cantidad_peonetas', 1);
		//$this->db->where('nombre_bono = "bono_produccion_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 2);
		//$this->db->where('nombre_bono = "bono_produccion_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_produccion_tripulantes_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', 8);
		$this->db->where('cantidad_peonetas', 2);
		//$this->db->where('nombre_bono = "bono_produccion_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 3);
		//$this->db->where('nombre_bono = "bono_produccion_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_produccion_tripulantes_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', 8);
		$this->db->where('cantidad_peonetas', 3);
		//$this->db->where('nombre_bono = "bono_produccion_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}
	//camion de 2 pallets
	function estandar_bono_cliente_ayudante_1_2_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 1);
		$this->db->where('nombre_bono = "bono_cliente_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_ayudante_2_2_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 2);
		$this->db->where('nombre_bono = "bono_cliente_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_ayudante_3_2_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 3);
		$this->db->where('nombre_bono = "bono_cliente_2"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	//camion de 6 pallets
	function estandar_bono_cliente_ayudante_1_6_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 1);
		$this->db->where('nombre_bono = "bono_cliente_6"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_ayudante_2_6_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 2);
		$this->db->where('nombre_bono = "bono_cliente_6"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_ayudante_3_6_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('cantidad_peonetas', 3);
		$this->db->where('nombre_bono = "bono_cliente_6"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	//camion de 8 pallets
	function estandar_bono_cliente_ayudante_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', 8);
		$this->db->where('cantidad_peonetas', 1);
		$this->db->where('nombre_bono = "bono_cliente_8"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_ayudante_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', 8);
		$this->db->where('cantidad_peonetas', 2);
		$this->db->where('nombre_bono = "bono_cliente_8"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function estandar_bono_cliente_ayudante_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_cargo', $extraer_cargo);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('cantidad_pallets', 8);
		$this->db->where('cantidad_peonetas', 3);
		$this->db->where('nombre_bono = "bono_cliente_8"');
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}
	//dos palltes
	function bono_vuelta_adicional_ayudante($pallets_camion_data, $extraer_tipo_contrato){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('cantidad_pallets', $pallets_camion_data);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('vuelta', 2);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}

	function bono_vuelta_adicional_ayudante_8_pallets($pallets_camion_data, $extraer_tipo_contrato){
		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('cantidad_pallets =', 8);
		$this->db->where('id_instrumento_colectivo', $extraer_tipo_contrato);
		$this->db->where('vuelta', 2);
		$query = $this->db->get();
		return $query->row()->bono_en_pesos;
	}
	
	function listar1(){

		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_instrumento_colectivo',21);
		$query = $this->db->get();
		return $query->result();
	}

	function listar2(){

		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_instrumento_colectivo',22);
		$query = $this->db->get();
		return $query->result();
	}

	function listar3(){

		$this->db->select('*');
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('id_instrumento_colectivo',23);
		$query = $this->db->get();
		return $query->result();
	}

	function get_cajas2($id){
		$this->db->select("*");
		$this->db->from('estandar_bono_peoneta');
		$this->db->where('estandar_bono_peoneta.id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function actualizar_caja2($id,$data){
		$this->db->where('id',$id);
		$this->db->update('estandar_bono_peoneta',$data); 
	}



}

/* End of file si_estandar_bono_peoneta.php */
/* Location: ./application/models/si_estandar_bono_peoneta.php */