<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_inasistentes_model extends CI_Model {

	function consultar_trabajadores_inasistentes($fecha_trabajar){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
				p.apellido_paterno as ap, p.apellido_materno as am, 
				t.id_cargo as cargo, t.estado_actual as falta, t.comentario as coment, t.fecha_registro as fecha');
		$this->db->from('trabajador_al_dia t');
		$this->db->join('persona p', 'p.id = t.id_persona', 'inner');
		$this->db->where('t.fecha_registro', $fecha_trabajar);
		$this->db->where('t.estado_actual !=', 6);
		$this->db->where('t.id_estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function guardar_tipo_inasistencia($editar_inasistencia, $id_trabajador, $fecha){
		$this->db->where('fecha_registro', $fecha);
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->update('inasistencias', $editar_inasistencia);
	}

	function guarda_inasistentes($guarda_registro_trabajadores){
		$this->db->insert('inasistencias', $guarda_registro_trabajadores);
	}

	function consultar_inasistente_registrado($id_persona, $fecha_actual){
		$this->db->select('*');
		$this->db->from('inasistencias');
		$this->db->where('id_trabajador', $id_persona);
		$this->db->where('fecha_registro', $fecha_actual);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return "NO";
		}
	}

	function guardar_inasistencias($guarda_inasistentes, $id_trabajador, $fecha_trabajar){		
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->update('inasistencias', $guarda_inasistentes);
	}

	function inasistencias_registradas($fecha_mostrar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('estado_actual = ', 5);
		$query = $this->db->get();
		return $query->result();
	}

}

/* End of file si_inasistentes_model.php */
/* Location: ./application/models/si_inasistentes_model.php */
