<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_reporte_trabajador extends CI_Model {

	function generar_reporte($fecha_inicio, $fecha_termino, $valores){
		/*$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am,sum(t_b_c.cajas_reales) as cajas, count(t_b_c.vuelta) as vuelta, sum(t_b_c.clientes_reales) as clientes,
			t.id_cargo as cargo, t.id_instrumento_colectivo as colectivo');
		$this->db->from('persona p');
		$this->db->join('trabajador t', 't.id_persona = p.id', 'left');
		$this->db->join('tabla_bonos_calculados t_b_c', 't_b_c.id_trabajador=p.id', 'left');
		$this->db->where('t_b_c.fecha_registro between "'.$fecha_inicio.'" and "'.$fecha_termino.'"');
		$this->db->where('p.id', $valores);
		$this->db->order_by('p.apellido_paterno', 'desc');
		$query = $this->db->get();
		return $query->result();*/

		$query = $this->db->query("SELECT p.id as id, p.rut as rut, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am,sum(t_r_p.cajas_reales) as cajas, count(IF(t_r_p.vuelta != 1,1,NULL)) as vuelta, sum(t_r_p.clientes_reales) as clientes, t.id_cargo as cargo, t.id_instrumento_colectivo as colectivo
			from persona p 
			left join trabajador t on t.id_persona = p.id 
			left join tabla_resumen_produccion t_r_p on t_r_p.id_trabajador=p.id
			where t_r_p.fecha_registro between '$fecha_inicio' and '$fecha_termino'
			and p.id = '$valores'
			order by p.apellido_paterno desc");
		return $query->result();	
	}

}

/* End of file t_reporte_trabajador.php */
/* Location: ./application/models/t_reporte_trabajador.php */