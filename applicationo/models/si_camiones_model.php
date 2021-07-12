<?php
class si_camiones_model extends CI_Model {
	function listar(){
		$this->db->select('ccu_c.idccu_camion as codigo_ccuc, c.id as id_camion,c_ccu.codigos_ccu as codigo, c.patente as patente, c.marca as marca, c.ano as ano, c.capacidad as capacidad, c.pallets as pallets');
		$this->db->from('ccu_camion ccu_c, camiones c, codigos_ccu c_ccu');
		$this->db->where('c.id = ccu_c.codigo_camion');
		$this->db->where('ccu_c.codigo_ccu = c_ccu.idcodigos_ccu');
		$this->db->where('ccu_c.estado =', 1);
		$this->db->group_by('codigo_camion');
		$this->db->order_by('codigo', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('camiones',$data); 
		return $this->db->insert_id();
	}

	function guarda_datos($data1){
		$this->db->insert('ccu_camion', $data1);
		return $this->db->insert_id();
	}

	/*function guarda_datos_camion_trabajador($data2){
		$this->db->insert('camion_trabajador', $data2);
	}*/

	function eliminar($codigo_ccuc){
		$data = array('estado' => 0, );
		$this->db->where('idccu_camion',$codigo_ccuc);
		$this->db->update('ccu_camion', $data);
		
	}

	function actualizar_cargos($id,$data2){
		$this->db->where('id',$id);
		$this->db->update('cargos',$data2); 
		return $this->db->insert_id();
	}

	function get_camion($id_camion){
		$this->db->select('id,patente,marca,ano,capacidad,pallets');		
		$this->db->from('camiones');
		$this->db->where('id',$id_camion);
		$query = $this->db->get();
		return $query->result();
	}

	function actualizar_camiones($id,$data){
		$this->db->where('id',$id);
		$this->db->update('camiones',$data); 
	}

	function consulta_registro($id_select_codigo){
		$this->db->select('*');
		$this->db->from('ccu_camion');
		$this->db->where('codigo_ccu', $id_select_codigo);
		$this->db->where('estado =', 1);
		$query = $this->db->get();
		
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function consulta_registro_patente($patente_data){
		$this->db->select('*');
		$this->db->from('camiones');
		$this->db->where('patente', $patente_data);
		$this->db->where('estado =', 1);
		$query = $this->db->get();
		
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function actualiza_dato($id_select_codigo){
		$data = array('estado' => 0);
		$this->db->where('codigo_ccu', $id_select_codigo);
		$this->db->update('ccu_camion', $data);
	}

	function actualizar_camiones_estado($id_camion){
		$data = array('estado' => 0, );
		$this->db->where('id',$id_camion);
		$this->db->update('camiones', $data);
	}

}