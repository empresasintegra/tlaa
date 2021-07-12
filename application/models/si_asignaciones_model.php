<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_asignaciones_model extends CI_Model {

	function listar_camiones_codigo(){
		$this->db->select('c_ccu.codigos_ccu as codigo, c_ccu.idcodigos_ccu as id_ccu');
		$this->db->from('codigos_ccu c_ccu');
		$this->db->join('ccu_camion c_camion', 'c_ccu.idcodigos_ccu = c_camion.codigo_ccu', 'inner');
		$this->db->where('c_camion.estado', 1);
		$query = $this->db->get();

		return $query->result();
	}

	function listar_chofer(){
		$this->db->select('pers.id, pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am, pers.rut, id_cargo as id_cargo');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->where('trab.id_cargo', 1);
		$query = $this->db->get();

		return $query->result();

	}

	function listar_peonetas(){
		$this->db->select('pers.id, pers.nombre as nombre_persona, pers.apellido_paterno as ap, pers.apellido_materno as am, pers.rut, id_cargo as id_cargo');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->where('trab.id_cargo', 2);
		$query = $this->db->get();

		return $query->result();

	}

	function guarda_asignaciones($arreglo_total){
		$data = array('estado' => 1);
		$this->db->insert('camion_trabajador', $arreglo_total);
	}

	function listar_peonetas_asignados($codigo){
		$this->db->select('id_chofer as chofer, id_ayudante_1 as uno,
			id_ayudante_2 as dos,
			id_ayudante_3 as tres');
		$this->db->from('camion_trabajador');
		$this->db->where('id_camion', $codigo);
		$query = $this->db->get();
		return $query->result();	
		
	}

	function listar_choferes_asignados($id_ccu){
		$this->db->select('*');
		$this->db->from('camion_trabajador');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 0);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}
	}

	function listar_peoneta_1_asignado($id_ccu){
		$this->db->select('*');
		$this->db->from('camion_trabajador');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 0);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}
	}

	function listar_peoneta_2_asignado($codigo){
		$this->db->select('*');
		$this->db->from('camion_trabajador');
		$this->db->where('id_camion', $codigo);
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 0);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}
	}

	function mostrar_nombre_chofer($id){
		$this->db->select('*');
		$this->db->from('persona');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();	
	}

	function mostrar_nombre_peoneta_1($id){
		$this->db->select('*');
		$this->db->from('persona');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();	
	}



	function si_existe_chofer($id){
		$this->db->select('pers.id as id_trabajador');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct', 'trab.id_persona = ct.id_chofer', 'left');
		$this->db->where('trab.id_persona', $id);
		$this->db->where('ct.estado', 1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}
	}

	function si_existe_peoneta($id){
		$this->db->select('pers.id as id_trabajador');
		$this->db->from('trabajador trab');
		$this->db->join('persona pers', 'trab.id_persona = pers.id', 'left');
		$this->db->join('camion_trabajador ct1', 'trab.id_persona = ct1.id_ayudante_1', 'left');
		$this->db->join('camion_trabajador ct2', 'trab.id_persona = ct2.id_ayudante_2', 'left');
		$this->db->join('camion_trabajador ct3', 'trab.id_persona = ct3.id_ayudante_3', 'left');
		$this->db->join('camion_trabajador ct4', 'trab.id_persona = ct4.id_ayudante_4', 'left');
		$this->db->where('trab.id_persona', $id);
		$this->db->where('ct1.estado', 1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}
	}

	function get_choferes(){

		$query = $this->db->query("select distinct p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am
			from persona p, trabajador t
			where t.id_persona = p.id and not exists(select * from camion_trabajador c where
			p.id = c.id_chofer )
			and t.id_cargo= '72'");
		return $query->result();
	}


	function consulta_si_existe_camion($id_camion){
		$this->db->select('*');
		$this->db->from('camion_trabajador');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function consultar_camion_chofer($id_chofer){
		$this->db->select('*');
		$this->db->from('camion_trabajador');
		$this->db->where('id_chofer', $id_chofer);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function consultar_peoneta_camion_1($id_peoneta){
		$this->db->select('*');
		$this->db->from('camion_trabajador');
		$this->db->where('id_ayudante_1', $id_peoneta.' or id_ayudante_2', $id_peoneta.' or id_ayudante_3', $id_peoneta.' or id_ayudante_4', $id_peoneta);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}
	

	function get_peonetas(){
		$query = $this->db->query("select distinct p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am
			from persona p, trabajador t
			where t.id_persona = p.id and not exists(select * from camion_trabajador c where
			p.id = c.id_ayudante_1 or p.id = c.id_ayudante_2 or p.id = c.id_ayudante_3 
			or p.id = c.id_ayudante_4 )
			and t.id_cargo= '73'");
		return $query->result();
	}

	function guarda_registro_trabajadores($guarda_registro){
		$this->db->insert('camion_trabajador', $guarda_registro);
	}

	function guarda_registro_trabajadores_ayudante_1(){
		$this->db->insert('camion_trabajador', $guarda_registro);
	}
	function guarda_registro_trabajadores_ayudante_2(){
		$this->db->insert('camion_trabajador', $guarda_registro);
	}
	function guarda_registro_trabajadores_ayudante_3(){
		$this->db->insert('camion_trabajador', $guarda_registro);
	}
	function guarda_registro_trabajadores_ayudante_4(){
		$this->db->insert('camion_trabajador', $guarda_registro);
	}

	function actualizar_registro_trabajadores_chofer($guarda_registro, $id_camion){
		$this->db->where('id_camion', $id_camion);
		$this->db->update('camion_trabajador', $guarda_registro);
	}

	function actualizar_registro_trabajadores_peoneta_1($guarda_registro, $id_camion){
		$this->db->where('id_camion', $id_camion);
		$this->db->update('camion_trabajador', $guarda_registro);
	} 
	function actualizar_registro_trabajadores_peoneta_2($guarda_registro, $id_camion){
		$this->db->where('id_camion', $id_camion);
		$this->db->update('camion_trabajador', $guarda_registro);
	}
	function actualizar_registro_trabajadores_peoneta_3($guarda_registro, $id_camion){
		$this->db->where('id_camion', $id_camion);
		$this->db->update('camion_trabajador', $guarda_registro);
	}
	function actualizar_registro_trabajadores_peoneta_4($guarda_registro, $id_camion){
		$this->db->where('id_camion', $id_camion);
		$this->db->update('camion_trabajador', $guarda_registro);
	} 






	function a_eliminar($codigo){
		$data = array('estado' => 0,
			'eliminado' => 1);
		$this->db->where('id_camion', $codigo);
		$this->db->update('camion_trabajador',$data); 
	}

	
}

/* End of file si_asignaciones_model.php */
/* Location: ./application/models/si_asignaciones_model.php */