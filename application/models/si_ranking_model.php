<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_ranking_model extends CI_Model {

	function consulta_trabajador($id, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('ranking_trabajador');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_trabajador', $id);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function todos_los_trabajadores_activos(){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am, t.id_cargo as cargo');
		$this->db->from('persona p, trabajador t');
		$this->db->where('t.id_persona = p.id');
		$this->db->where('t.id_instrumento_colectivo !=', 23);
		//$this->db->where('t.fecha_registro', $f);
		//$this->db->where('t.estado_actual =', 6);
		$query = $this->db->get();
		return $query->result();

	}

	function insertar_datos($datas_trabajador){
		$this->db->insert('ranking_trabajador', $datas_trabajador);
	}

	function obtener_datos_ranking($fecha_trabajar){
		$this->db->select('p.id as id, p.rut,p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am,t.id_cargo as cargo, r.amonestaciones as amonesta, r.inasistencias as inasis, r.falta_dinero as falta_dinero, r.rechazos_cajas as r_caja, r.rechazos_clientes as r_cliente, r.aseo_mantencion as aseo, r.queja_reclamo as quejas, r.total_rank as t_rank, ic.nombre as nombre_convenio');
		$this->db->from('ranking_trabajador r');
		$this->db->join('trabajador t', 't.id_persona = r.id_trabajador', 'inner');
		$this->db->join('cargos c', 'c.id = t.id_cargo', 'inner');
		$this->db->join('persona p', 'p.id = r.id_trabajador', 'inner');
		$this->db->join('instrumento_colectivo ic', 'ic.id = t.id_instrumento_colectivo', 'inner');
		$this->db->where('r.fecha_registro', $fecha_trabajar);   	
		$this->db->where('t.id_estado', 1);		
		$this->db->order_by('p.apellido_paterno', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function guardar_ranking_trabajador($datos_ranking, $id_trabajador, $fecha_trabajar){
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->where('fecha_registro', $fecha_trabajar);	
		$this->db->update('ranking_trabajador', $datos_ranking);
	}

}

/* End of file si_ranking_model.php */
/* Location: ./application/models/si_ranking_model.php */