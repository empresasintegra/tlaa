<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_genera_liquidaciones extends CI_Model {

	function generar_liquidaciones($data){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			t_r_p.fecha_registro as fecha, t_r_p.clientes_reales as clientes, 
			t_r_p.vuelta as vuelta,
			t_r_p.tripulacion as tripulacion, t_r_p.T_camion as tam_camion,
			t_r_p.id_cargo as cargo,
			c.nombre as n_cargo,
			t_r_p.id_convenio as convenio, ');
		$this->db->from('persona p');
		$this->db->join('tabla_resumen_produccion t_r_p', 't_r_p.id_trabajador = p.id', 'left');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_tabla_resumen = t_r_p.id', 'left');
		$this->db->join('cargos c', 'c.id = t_r_p.id_cargo', 'left');
		$this->db->where('p.id', $data);
		$query = $this->db->get();
		return $query->row();
	}

	function generar_liquidacion_trabajador($valores, $f){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			t_b_c.fecha_registro as fecha, 
			t_r_p.vuelta as vuelta,
			t_r_p.tripulacion as tripulacion, t_r_p.T_camion as tam_camion,
			t_b_c.cargo as cargo,
			t_r_p.id_convenio as convenio, 
			t_b_c.cajas_reales as cajas,
			t_b_c.bono_produccion as b_produccion,
			t_b_c.bono_vuelta_adicional as b_v_adicional,
			t_b_c.clientes_reales as clientes');
		$this->db->from('persona p');
		$this->db->join('tabla_resumen_produccion t_r_p', 't_r_p.id_trabajador = p.id', 'inner');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_tabla_resumen = t_r_p.id', 'inner');
		$this->db->where('t_b_c.fecha_registro', $f);
		$this->db->where('p.id', $valores);
		$query = $this->db->get();
		return $query->result();
	}

	function generar_liquidacion_trabajador_vuelta($valores, $f , $vuelta){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, 
			p.apellido_paterno as ap, p.apellido_materno as am,
			t_b_c.fecha_registro as fecha,  
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
		$this->db->where('p.id', $valores);
		$query = $this->db->get();
		return $query->row();
	}

	function get_faltas_trabajador($valores,  $fecha_inicio, $fecha_termino){
		$this->db->select('count(id_persona) as faltas');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $valores);
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');		
		$this->db->where('estado_actual =', 5);
		$query = $this->db->get();
		return $query->row();
	}
	function get_asistencia_resumen($valores,  $fecha_inicio){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona',$valores);
		$this->db->where('fecha_registro', $fecha_inicio);
		$query = $this->db->get();
		return $query->row();
	}

	function get_tipo_asistencia_resumen($valores, $fecha_inicio, $tipo_asist){
		$this->db->select('id');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona',$valores);
		$this->db->where('fecha_registro', $fecha_inicio);
		$this->db->where('estado_actual', $tipo_asist);
		$query = $this->db->get();
		return $query->row();
	}

	function get_asistencia_trabajador($valores, $f){
		$this->db->select('count(id_persona) as asistencia');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $valores);
		$this->db->where('fecha_registro', $f);
		$this->db->where('estado_actual =', 6);
		$query = $this->db->get();
		return $query->row();
	}

	function get_porcentaje_ranking_trabajador($valores, $f){
		$this->db->select('*');
		$this->db->from('ranking_trabajador');
		$this->db->where('id_trabajador', $valores);
		$this->db->where('fecha_registro', $f);
		$query = $this->db->get();
		return $query->row();
	}

	function get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino){
		$this->db->select('count(id_trabajador) as vueltas');
		$this->db->from('tabla_resumen_bonos_vuelta_adicional');
		$this->db->where('id_trabajador', $valores);
		$this->db->where('fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');
		$query = $this->db->get();
		return $query->row();

	}

	function get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer){
		$this->db->select('*');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador', $valores);
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
	#hoja 6 para obtener el bono rechazo
	function get_bono_rechazo($valores, $fecha){
		$this->db->select('id_BonoRechazos');
		$this->db->from('bono_rechazos');
		$this->db->where('id_trabajador', $valores);
		$this->db->where('fecha_bono', $fecha);
		//$this->db->limit($contador_faltas_chofer);
		//$this->db->order_by('fecha_registro', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

}

/* End of file t_genera_liquidaciones.php */
/* Location: ./application/models/t_genera_liquidaciones.php */