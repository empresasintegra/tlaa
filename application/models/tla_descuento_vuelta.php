<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_descuento_vuelta extends CI_Model {

	function todos_los_trabajadores($fecha_inicio, $fecha_termino){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			c.nombre as n_cargo,
			cl.nombre as n_convenio');
		$this->db->from('persona p');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_trabajador = p.id', 'left');
		$this->db->join('cargos c', 'c.id = t_b_c.cargo', 'left');
		$this->db->join('instrumento_colectivo cl', 'cl.id = t_b_c.contrato', 'left');
		$this->db->where('t_b_c.fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');	
		$this->db->group_by('p.id');
		$query = $this->db->get();
		return $query->result();
	}

	function get_faltas_trabajador($id, $fecha_inicio, $fecha_termino){
		$this->db->select('count(id_persona) as faltas');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id);
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');		
		$this->db->where('estado_actual =', 5);
		$query = $this->db->get();
		return $query->row();
	}

	function get_vueltas_adicionales_registradas($id, $fecha_inicio, $fecha_termino){
		$this->db->select('count(id_trabajador) as vueltas');
		$this->db->from('tabla_resumen_bonos_vuelta_adicional');
		$this->db->where('id_trabajador', $id);
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');
		$query = $this->db->get();
		return $query->row();

	}

	function get_vueltas_adicionales_trabajador($id, $fecha_inicio, $fecha_termino, $contador_faltas_chofer){
		$this->db->select('*');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador', $id);
		$this->db->where('vuelta !=', 1);
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');
		$this->db->limit($contador_faltas_chofer);
		$this->db->order_by('fecha_registro', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function actualiza_vuelta_adicional($id_trabajador, $fecha_registro, $vuelta, $vuelta_adicional){
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_registro);
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->update('tabla_bonos_calculados', $vuelta_adicional);
	}

}

/* End of file tla_descuento_vuelta.php */
/* Location: ./application/models/tla_descuento_vuelta.php */