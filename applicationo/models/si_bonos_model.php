<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_bonos_model extends CI_Model {

	function muestra_trabajadores_activos(){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am, t.id_cargo as cargo');
		$this->db->from('persona p');
		$this->db->join('trabajador t', 't.id_persona = p.id', 'inner');
		$this->db->join('cargos c', 'c.id = t.id_cargo', 'inner');
		$this->db->where('t.id_estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function buscar_produccion_persona($id, $rm){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		//$this->db->where('id_chofer', $id);
		$this->db->where('id_chofer', $id, 'id_ayudante_1', $id.' or id_ayudante_2', $id.' or id_ayudante_3', $id.' or id_ayudante_4', $id);
		$this->db->where('fecha_registro', $rm);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		return $query->result();

	}

	function extraer_cargo_trabajadores($vuelta, $i){
		$this->db->select('t.id_cargo as cargo');
		$this->db->from('ingreso_produccion i');
		$this->db->join('trabajador t', 't.id_persona = i.id_chofer or i.id_ayudante_1 
			or i.id_ayudante_2 or i.id_ayudante_3 or i.id_ayudante_4', 'join');
		$this->db->where('i.fecha_registro', $i);		
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('t.id_estado', 1);
		$query = $this->db->get();
		return $query->result();
	}


	function buscar_ayudantes_turno($id, $i){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_1', $id.' or id_ayudante_2', $id.' or id_ayudante_3', $id.' or id_ayudante_4', $id);
		$this->db->where('fecha_registro', $i);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		return $query->result();

	}

	function cuenta_vueltas($id, $rm){		
		$this->db->select('vuelta as vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_chofer', $id);
		$this->db->where('fecha_registro', $rm);
		$this->db->order_by('vuelta', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function buscar_ruta_vuelta_chofer($vuelta, $id, $i){
		$this->db->select('r.id as id_ruta');
		$this->db->from('ingreso_produccion i');
		$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_chofer', $id);
		$this->db->where('i.fecha_registro', $i);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function buscar_cajas_reales($vuelta, $id, $rm){
		$this->db->select('i.caja_reales as c_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_chofer', $id);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function buscar_cliente_reales($vuelta, $id, $rm){
		$this->db->select('i.cliente_reales as cliente_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_chofer', $id);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function buscar_tamano_camion_chofer($id_camion, $vuelta, $id, $rm){
		$this->db->select('c.pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'join');
		$this->db->join('ingreso_produccion i', 'i.id_camion = ccu.codigo_ccu', 'join');
		$this->db->where('i.id_chofer', $id);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.id_camion', $id_camion);
		$this->db->where('ccu.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}
	///////////////////////////////
	//----!!! AYUDANTE 1 !!!----//
	/////////////////////////////
	function cuenta_vueltas_peonetas_ayudante_1($id_ayudante_1, $rm){		
		$this->db->select('vuelta as vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_1', $id_ayudante_1);
		$this->db->where('fecha_registro', $rm);
		$this->db->order_by('vuelta', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function produccion_ayudante_1($vuelta, $id_ayudante_1, $rm){
		$this->db->select('i.caja_reales as c_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_1', $id_ayudante_1);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function clientes_ayudante_1($vuelta, $id_ayudante_1, $rm){
		$this->db->select('i.cliente_reales as cliente_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_1', $id_ayudante_1);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function ruta_vuelta_1_ayudante_1($vuelta, $id_ayudante_1, $rm){
		$this->db->select('r.id as id_ruta');
		$this->db->from('ingreso_produccion i');
		$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_1', $id_ayudante_1);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function tamano_camion_ayudante_1($id_camion, $vuelta, $id_ayudante_1, $rm){
		$this->db->select('c.pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'join');
		$this->db->join('ingreso_produccion i', 'i.id_camion = ccu.codigo_ccu', 'join');
		$this->db->where('i.id_ayudante_1', $id_ayudante_1);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.id_camion', $id_camion);
		$this->db->where('ccu.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function tripulacion_actual_ayudante_1($vuelta, $id_ayudante_1, $i){
		$this->db->select('tripulacion_actual as tripulantes');
		$this->db->from('ingreso_produccion i');
		//$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_1', $id_ayudante_1);
		$this->db->where('i.fecha_registro', $i);
		$this->db->where('i.vuelta', $vuelta);
		//$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}
	//Fin ayudante 1



	///////////////////////////////
	//----!!! AYUDANTE 2 !!!----//
	/////////////////////////////
	function cuenta_vueltas_peonetas_ayudante_2_1($id_ayudante_2, $rm){		
		$this->db->select('vuelta as vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_2', $id_ayudante_2);
		$this->db->where('fecha_registro', $rm);
		$this->db->order_by('vuelta', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function produccion_ayudante_2($vuelta, $id_ayudante_2, $rm){
		$this->db->select('i.caja_reales as c_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_2', $id_ayudante_2);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function clientes_ayudante_2($vuelta, $id_ayudante_2, $rm){
		$this->db->select('i.cliente_reales as cliente_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_2', $id_ayudante_2);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function ruta_vuelta_1_ayudante_2($vuelta, $id_ayudante_2, $rm){
		$this->db->select('r.id as id_ruta');
		$this->db->from('ingreso_produccion i');
		$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_2', $id_ayudante_2);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function tamano_camion_ayudante_2($id_camion, $vuelta, $id_ayudante_2, $rm){
		$this->db->select('c.pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'join');
		$this->db->join('ingreso_produccion i', 'i.id_camion = ccu.codigo_ccu', 'join');
		$this->db->where('i.id_ayudante_2', $id_ayudante_2);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.id_camion', $id_camion);
		$this->db->where('ccu.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function tripulacion_actual_ayudante_2($vuelta, $id_ayudante_2, $i){
		$this->db->select('tripulacion_actual as tripulantes');
		$this->db->from('ingreso_produccion i');
		//$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_2', $id_ayudante_2);
		$this->db->where('i.fecha_registro', $i);
		$this->db->where('i.vuelta', $vuelta);
		//$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}
	//fin ayudante 2.



	///////////////////////////////
	//----!!! AYUDANTE 3 !!!----//
	/////////////////////////////
	function cuenta_vueltas_peonetas_ayudante_3_1($id_ayudante_3, $rm){		
		$this->db->select('vuelta as vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_3', $id_ayudante_3);
		$this->db->where('fecha_registro', $rm);
		$this->db->order_by('vuelta', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function produccion_ayudante_3($vuelta, $id_ayudante_3, $rm){
		$this->db->select('i.caja_reales as c_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_3', $id_ayudante_3);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function clientes_ayudante_3($vuelta, $id_ayudante_3, $rm){
		$this->db->select('i.cliente_reales as cliente_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_3', $id_ayudante_3);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function ruta_vuelta_1_ayudante_3($vuelta, $id_ayudante_3, $rm){
		$this->db->select('r.id as id_ruta');
		$this->db->from('ingreso_produccion i');
		$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_3', $id_ayudante_3);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function tamano_camion_ayudante_3($id_camion, $vuelta, $id_ayudante_3, $rm){
		$this->db->select('c.pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'join');
		$this->db->join('ingreso_produccion i', 'i.id_camion = ccu.codigo_ccu', 'join');
		$this->db->where('i.id_ayudante_3', $id_ayudante_3);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.id_camion', $id_camion);
		$this->db->where('ccu.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function tripulacion_actual_ayudante_3($vuelta, $id_ayudante_3, $i){
		$this->db->select('tripulacion_actual as tripulantes');
		$this->db->from('ingreso_produccion i');
		//$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_3', $id_ayudante_3);
		$this->db->where('i.fecha_registro', $i);
		$this->db->where('i.vuelta', $vuelta);
		//$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}
	//fin ayudante 3



	///////////////////////////////
	//----!!! AYUDANTE 4 !!!----//
	/////////////////////////////
	function cuenta_vueltas_peonetas_ayudante_4_1($id_ayudante_4, $rm){		
		$this->db->select('vuelta as vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_4', $id_ayudante_4);
		$this->db->where('fecha_registro', $rm);
		$this->db->order_by('vuelta', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function produccion_ayudante_4($vuelta, $id_ayudante_4, $rm){
		$this->db->select('i.caja_reales as c_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_4', $id_ayudante_4);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function clientes_ayudante_4($vuelta, $id_ayudante_4, $rm){
		$this->db->select('i.cliente_reales as cliente_real');
		$this->db->from('ingreso_produccion i');		
		$this->db->where('i.id_ayudante_4', $id_ayudante_4);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function ruta_vuelta_1_ayudante_4($vuelta, $id_ayudante_4, $rm){
		$this->db->select('r.id as id_ruta');
		$this->db->from('ingreso_produccion i');
		$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_4', $id_ayudante_4);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function tamano_camion_ayudante_4($id_camion, $vuelta, $id_ayudante_4, $rm){
		$this->db->select('c.pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'join');
		$this->db->join('ingreso_produccion i', 'i.id_camion = ccu.codigo_ccu', 'join');
		$this->db->where('i.id_ayudante_4', $id_ayudante_4);
		$this->db->where('i.fecha_registro', $rm);
		$this->db->where('i.vuelta', $vuelta);
		$this->db->where('i.id_camion', $id_camion);
		$this->db->where('ccu.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function tripulacion_actual_ayudante_4($vuelta, $id_ayudante_4, $i){
		$this->db->select('tripulacion_actual as tripulantes');
		$this->db->from('ingreso_produccion i');
		//$this->db->join('rutas r', 'r.id = i.id_ruta', 'inner');
		$this->db->where('i.id_ayudante_4', $id_ayudante_4);
		$this->db->where('i.fecha_registro', $i);
		$this->db->where('i.vuelta', $vuelta);
		//$this->db->where('r.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}	

	/*

	function consulta_si_existen_bonos_choferes($id_camion, $fecha, $id_chofer){
		$this->db->select('*');
		$this->db->from('calculo_bonos_chofer');
		$this->db->where('id_trabajador', $id_chofer);
		$this->db->where('id_camion', $id_camion);
		$this->db->where('fecha_registro', $fecha);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}
	}

	function guarda_calculos_bono_choferes($data_bono_chofer){
		$this->db->insert('calculo_bonos_chofer', $data_bono_chofer);
	}

	function guarda_calculos_bono_choferes_actualizado($id_chofer, $fecha, $data_bono_chofer_actualizado){
		$this->db->where('id_trabajador', $id_chofer);
		$this->db->where('fecha_registro', $fecha);
		$this->db->update('calculo_bonos_chofer', $data_bono_chofer_actualizado);
	}

	function consultar_si_existe_calculo($fecha, $id_camion){
		$this->db->select('*');
		$this->db->from('calculo_bono_ayudante');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('fecha_vuelta', $fecha);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}
	}

	function guarda_calculos_bono_ayudantes($data_bono_ayudante){
		$this->db->insert('calculo_bono_ayudante', $data_bono_ayudante);
	}

	function guarda_calculos_bono_ayudantes_actualizado($data_bono_ayudante_actualizado, $fecha_vuelta, $id_camion){
		$this->db->where('fecha_vuelta', $fecha_vuelta);
		$this->db->where('id_camion', $id_camion);
		$this->db->update('calculo_bono_ayudante', $data_bono_ayudante_actualizado);
	}*/

}

/* End of file si_bonos_model.php */
/* Location: ./application/models/si_bonos_model.php */