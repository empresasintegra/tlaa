<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_informe_produccion extends CI_Model {

	function cantidad_dias_rutero($id_trabajador, $fecha_inicio, $fecha_termino){
		$this->db->select('*');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador =', $id_trabajador);
		$this->db->where('bono_ruta !=', 0);
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');
		$this->db->group_by('fecha_registro');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function todos_los_trabajadores($valores, $f_inicio, $f_termino){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			c.nombre as n_cargo,
			cl.nombre as n_convenio');
		$this->db->from('persona p');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_trabajador = p.id', 'left');
		$this->db->join('cargos c', 'c.id = t_b_c.cargo', 'left');
		$this->db->join('instrumento_colectivo cl', 'cl.id = t_b_c.contrato', 'left');
		$this->db->where('t_b_c.fecha_registro between "'.$f_inicio.'" and "'.$f_termino.'"');	
		$this->db->where('p.id', $valores);
		$this->db->group_by('p.id');
		$this->db->order_by('p.apellido_paterno', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_bono_rechazo($valores, $f_inicio, $f_termino){
		$this->db->select('count(id_trabajador) as diasTotalBono');
		$this->db->from('bono_rechazos');
		$this->db->where('id_trabajador', $valores);
		$this->db->where('fecha_bono between "'.$f_inicio.'" and "'.$f_termino.'"');	
		$query = $this->db->get();
		return $query->row();
	}
	function extraer_informacion_trabajador($id, $f){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			t_r_p.fecha_registro as fecha,  
			t_r_p.vuelta as vuelta,
			t_r_p.tripulacion as tripulacion, 
			t_r_p.T_camion as tam_camion,
			t_b_c.cargo as cargo,
			t_r_p.id_convenio as convenio, 
			t_b_c.cajas_reales as cajas,
			t_b_c.bono_produccion as b_produccion,
			t_b_c.bono_cliente as b_cliente,
			t_b_c.bono_ruta as b_ruta,
			t_b_c.bono_vuelta_adicional as b_v_adicional,
			t_b_c.clientes_reales as clientes');
		$this->db->from('persona p');
		$this->db->join('tabla_resumen_produccion t_r_p', 't_r_p.id_trabajador = p.id', 'left');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_tabla_resumen = t_r_p.id', 'left');
		$this->db->where('t_b_c.fecha_registro', $f);
		$this->db->where('t_b_c.id_trabajador', $id);
		$this->db->where('t_b_c.estado', 0);
		$query = $this->db->get();
		return $query->result();
	}

	function info_vuelta_trabajador($id, $f , $vuelta){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			t_r_p.fecha_registro as fecha,  
			t_r_p.vuelta as vuelta,
			t_r_p.tripulacion as tripulacion, 
			t_r_p.T_camion as tam_camion,
			t_b_c.cargo as cargo,
			t_r_p.id_convenio as convenio, 
			t_b_c.cajas_reales as cajas,
			t_b_c.bono_produccion as b_produccion,
			t_b_c.bono_cliente as b_cliente,
			t_b_c.bono_ruta as b_ruta,
			t_b_c.bono_vuelta_adicional as b_v_adicional,
			t_b_c.clientes_reales as clientes');
		$this->db->from('persona p');
		$this->db->join('tabla_resumen_produccion t_r_p', 't_r_p.id_trabajador = p.id', 'left');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_tabla_resumen = t_r_p.id', 'left');
		$this->db->where('t_b_c.vuelta', $vuelta);
		$this->db->where('t_b_c.fecha_registro', $f);
		$this->db->where('t_b_c.id_trabajador', $id);
		$this->db->where('t_b_c.estado', 0);
		$query = $this->db->get();
		return $query->row();
	}

	function get_faltas_trabajador($id, $f_inicio, $f_termino){
		$this->db->select('count(id_persona) as faltas');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id);
		$this->db->where('fecha_registro between "'.$f_inicio.'" and "'.$f_termino.'"');		
		$this->db->where('estado_actual !=', 6);
		$this->db->where('estado_actual !=', 5);
		$query = $this->db->get();
		return $query->row();
	}

	function get_faltas_trabajador_ilegales($id, $f_inicio, $f_termino){
		$this->db->select('count(id_persona) as faltas_i');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id);
		$this->db->where('fecha_registro between "'.$f_inicio.'" and "'.$f_termino.'"');	
		$this->db->where('estado_actual =', 5);
		$query = $this->db->get();
		return $query->row();
	}

	function get_ranking_trabajador($id, $f_inicio, $f_termino){

		$this->db->select('*');
		$this->db->from('ranking_trabajador');
		$this->db->where('id_trabajador', $id);
		$this->db->where('fecha_registro between "'.$f_inicio.'" and "'.$f_termino.'"');
		$query = $this->db->get();
		return $query->row();
	
	}

	function clientes_camiones($f, $id_ccu){
		$this->db->select('sum(cliente_reales) as suma_cliente');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('fecha_registro', $f);
		$query = $this->db->get();
		return $query->row();
	}

	function cajas_camiones($f, $id_ccu){
		$this->db->select('sum(caja_reales) as suma_cajas');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('fecha_registro', $f);
		$query = $this->db->get();
		return $query->row();
	}
}

/* End of file tla_informe_produccion.php */
/* Location: ./application/models/tla_informe_produccion.php */