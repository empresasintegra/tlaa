<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todos_los_trabajadores_model extends CI_Model {

	function listar_choferes($codigo){
		$this->db->select('ct.id_cargo, ct.id_camion, pers.id as id_trabajador, pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_trabajador', 'left');
		$this->db->where('ct.id_cargo', 72);
		$this->db->where('ct.id_camion', $codigo);
		$query = $this->db->get();

		return $query->result();
	}	

	function listar_peonetas($codigo){
		$this->db->select('ct.id_cargo, ct.id_camion, pers.id as id_trabajador, pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_trabajador', 'left');
		$this->db->where('ct.id_cargo', 73);
		$this->db->where('ct.id_camion', $codigo);
		$query = $this->db->get();

		return $query->result();
	}

	function todos_choferes(){
		$this->db->select('ct.id_cargo, ct.id_camion, pers.id as id_trabajador, pers.rut as rut,
			pers.nombre as nombre_persona, pers.apellido_paterno as ap, 
			pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_trabajador', 'left');
		$this->db->where('trab.id_cargo', 1);
		$query = $this->db->get();

		return $query->result();
	}

	function todos_peonetas(){
		$this->db->select('ct.id_cargo, ct.id_camion, pers.id as id_trabajador, pers.rut as rut ,pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_trabajador', 'left');
		$this->db->where('trab.id_cargo', 2);
		$query = $this->db->get();

		return $query->result();
	}

	function get_choferes($resultado){
		$this->db->select('ct.id_cargo as cargo, ct.id_camion, pers.id as id_trabajador, pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_trabajador', 'left');
		$this->db->where('pers.id', $resultado);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}
	}

	function get_peonetas($resultado_p){
		$this->db->select('ct.id_cargo as cargo, ct.id_camion, pers.id as id_trabajador, pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_trabajador', 'left');
		$this->db->where('pers.id', $resultado_p);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}
	}

	

	/*function buscar_choferes($codigo){
		$this->db->select('trab.id_cargo, pers.id as id_trabajador, pers.rut as rut,
			pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->where('trab.id_cargo', 1);
		$this->db->like('pers.nombre', $codigo);
		$query = $this->db->get('');

		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return 0;
		}

	}*/

	function listar_trabajadores_activos(){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am');
		$this->db->from('persona p');
		$query = $this->db->get();
		return $query->result();
	}
}





/* End of file todos_los_trabajadores.php */
/* Location: ./application/models/todos_los_trabajadores.php */