<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_model extends CI_Model {

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
	  function agrupar_cajas_rechazo($fecha_trabajar){ //borrar
        $this->db->select('camion , sum(suma_de_cajas) as cajas, fecha_factura as fecha, 
                count( distinct cod_cliente) as clientes, carga as vuelta');
        $this->db->from('rechazos');
        $this->db->where('fecha_factura', $fecha_trabajar);
        $this->db->group_by('camion, carga');
        $query = $this->db->get();
        return $query->result();
    }

	function consulta_rechazos($fecha_trabajar){
		$this->db->select('id');
		$this->db->from('rechazos');
		$this->db->where('fecha_subida', $fecha_trabajar);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		}
	}

	function consulta_preventa($fecha_trabajar){
		$this->db->select('id');
		$this->db->from('preventas');
		$this->db->where('fecha_preventa', $fecha_trabajar);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		}

	}

	function consultar_trabajadores_inasistentes($fecha_trabajar, $vuelta_trabajar){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am, t.id_cargo as cargo, c.codigos_ccu as ccu, c.idcodigos_ccu as id_ccu, i.tipo_falta as falta, i.comentarios as coment, i.vuelta as vuelta, i.fecha_registro as fecha');
		$this->db->from('inasistencias i');
		$this->db->join('persona p', 'p.id = i.id_trabajador', 'inner');
		$this->db->join('trabajador t', 't.id_persona = i.id_trabajador', 'inner');
		$this->db->join('codigos_ccu c', 'c.idcodigos_ccu = i.codigo_camion', 'inner');
		$this->db->where('i.fecha_registro', $fecha_trabajar);
		$this->db->where('i.vuelta', $vuelta_trabajar);
		$this->db->where('i.estado', 2);
		$query = $this->db->get();
		return $query->result();
	}

}

/* End of file datos_model.php */
/* Location: ./application/models/datos_model.php */