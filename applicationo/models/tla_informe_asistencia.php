<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_informe_asistencia extends CI_Model {

	function todos_los_trabajadores($f_inicio, $f_termino){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			c.nombre as n_cargo,
			cl.nombre as n_convenio');
		$this->db->from('persona p');
		$this->db->join('trabajador_al_dia t', 't.id_persona = p.id', 'left');
		$this->db->join('cargos c', 'c.id = t.id_cargo', 'left');
		$this->db->join('instrumento_colectivo cl', 'cl.id = t.id_instrumento_colectivo', 'left');
		$this->db->where('t.fecha_registro between "'.$f_inicio.'" and "'.$f_termino.'"');
		$this->db->group_by('p.id');
		$query = $this->db->get();
		return $query->result();
	}

	function obtener_asistencia($f, $id){
		$this->db->select('estado_actual as estado');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id);
		$this->db->where('fecha_registro', $f);
		$query = $this->db->get();
		return $query->row();

	}

}

/* End of file tla_informe_asistencia.php */
/* Location: ./application/models/tla_informe_asistencia.php */