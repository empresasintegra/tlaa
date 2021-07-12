<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_produccion_model extends CI_Model {

	function guarda_produccion($data){
		$this->db->insert('ingreso_produccion', $data);
	}

	function ultima_produccion_registrada_fecha($fecha_trabajar){
		$this->db->select('fecha_registro as fecha');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro <=', $fecha_trabajar);
		$this->db->order_by('fecha_registro', 'desc');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row()->fecha;
	}

	function ultima_produccion_registrada_vuelta($ultima_fecha){
		$this->db->select('vuelta as vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $ultima_fecha);
		$this->db->order_by('vuelta', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row()->vuelta;
	}

	function extraer_datos($ultima_fecha, $ultima_vuelta){
		$this->db->select('id_camion, id_chofer, id_ayudante_1, id_ayudante_2, id_ayudante_3, id_ayudante_4');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $ultima_fecha);
		$this->db->where('vuelta', $ultima_vuelta);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function guarda_datos($guarda){
		if (isset($guarda)) {
			$this->db->insert('ingreso_produccion', $guarda);
		}
		
	}

	function obtener_vueltas($fecha_trabajar, $codigo){
		$this->db->select('count(distinct vuelta) as cuenta');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion', $codigo);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		}		
	}

	function consultar_registro($fecha_trabajar, $vuelta_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $vuelta_trabajar);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function listar_camiones_codigo(){
		$this->db->select('c_ccu.codigos_ccu as codigo, c_ccu.idcodigos_ccu as id_ccu, c_camiones.pallets as pallets');
		$this->db->from('codigos_ccu c_ccu');
		$this->db->join('ccu_camion c_camion', 'c_ccu.idcodigos_ccu = c_camion.codigo_ccu', 'left');
		$this->db->join('camiones c_camiones', 'c_camiones.id = c_camion.codigo_camion', 'left');
		$this->db->where('c_camion.estado', 1);
		$this->db->order_by('pallets','desc');
		$query = $this->db->get();
		return $query->result();
	}


	function listar_choferes_asignados($id_ccu, $vuelta_trabajar, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 0);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}
	}

	function listar_peoneta_1_asignado($id_ccu, $vuelta_trabajar, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('fecha_registro', $fecha_trabajar);
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

	function get_choferes($fecha_mostrar){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am ');
		$this->db->from('persona p, trabajador_al_dia t');
		$this->db->where('t.id_persona = p.id');
		$this->db->where('t.id_cargo', 72);
		$this->db->where('t.fecha_registro', $fecha_mostrar);
		$this->db->where('t.estado_actual =', 6);
		$this->db->order_by('apellido_paterno', 'asc');
		$query = $this->db->get();
		return $query->result();

	}

	function consulta_si_existe_camion($id_camion, $vuelta, $fecha_mostrar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
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
		$this->db->from('ingreso_produccion');
		$this->db->where('id_chofer', $id_chofer);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function consultar_peoneta_camion_1($id_peoneta, $vuelta, $fecha_mostrar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_1', $id_peoneta.' or id_ayudante_2', $id_peoneta.' or id_ayudante_3', $id_peoneta.' or id_ayudante_4', $id_peoneta);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function get_peonetas($fecha_mostrar){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am ');
		$this->db->from('persona p, trabajador_al_dia t');
		$this->db->where('t.id_persona = p.id');
		$this->db->where('t.id_cargo', 73);
		$this->db->where('t.fecha_registro', $fecha_mostrar);
		$this->db->where('t.estado_actual =', 6);
		$this->db->order_by('apellido_paterno', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function guarda_registro_trabajadores($guarda_registro){
		$this->db->insert('ingreso_produccion', $guarda_registro);
	}

	function guarda_registro_trabajadores_ayudante_1(){
		$this->db->insert('ingreso_produccion', $guarda_registro);
	}
	function guarda_registro_trabajadores_ayudante_2(){
		$this->db->insert('ingreso_produccion', $guarda_registro);
	}
	function guarda_registro_trabajadores_ayudante_3(){
		$this->db->insert('ingreso_produccion', $guarda_registro);
	}
	function guarda_registro_trabajadores_ayudante_4(){
		$this->db->insert('ingreso_produccion', $guarda_registro);
	}

	function actualizar_registro_trabajadores_chofer($guarda_registro, $id_camion, $vuelta,
		$fecha_mostrar){
		$this->db->where('fecha_registro', $fecha_mostrar);		
		$this->db->where('vuelta', $vuelta);
		$this->db->where('id_camion', $id_camion);
		$this->db->update('ingreso_produccion', $guarda_registro);
	}

	function actualizar_registro_trabajadores_peoneta_1($guarda_registro, $id_camion, $vuelta, $fecha_mostrar){
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('id_camion', $id_camion);		
		$this->db->update('ingreso_produccion', $guarda_registro);
	} 
	function actualizar_registro_trabajadores_peoneta_2($guarda_registro, $id_camion, $vuelta, $fecha_mostrar){
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('id_camion', $id_camion);
		$this->db->update('ingreso_produccion', $guarda_registro);
	}
	function actualizar_registro_trabajadores_peoneta_3($guarda_registro, $id_camion, $vuelta, $fecha_mostrar){
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('id_camion', $id_camion);
		$this->db->update('ingreso_produccion', $guarda_registro);
	}
	function actualizar_registro_trabajadores_peoneta_4($guarda_registro, $id_camion, $vuelta, $fecha_mostrar){
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('id_camion', $id_camion);
		$this->db->update('ingreso_produccion', $guarda_registro);
	}

	function eliminar_trabajador_camion_ch($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar){
		$datos = array('id_chofer' => 0, );
		$this->db->where('id_chofer', $id_trabajador);
		$this->db->where('vuelta', $vuelta_trabajar_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->update('ingreso_produccion', $datos);
	}

	function eliminar_trabajador_camion_p1($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar){
		$datos = array('id_ayudante_1' => 0, );
		$this->db->where('id_ayudante_1', $id_trabajador);
		$this->db->where('vuelta', $vuelta_trabajar_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->update('ingreso_produccion', $datos);
	}

	function eliminar_trabajador_camion_p2($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar){
		$datos = array('id_ayudante_2' => 0, );
		$this->db->where('id_ayudante_2', $id_trabajador);
		$this->db->where('vuelta', $vuelta_trabajar_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->update('ingreso_produccion', $datos);
	}

	function eliminar_trabajador_camion_p3($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar){
		$datos = array('id_ayudante_3' => 0, );
		$this->db->where('id_ayudante_3', $id_trabajador);
		$this->db->where('vuelta', $vuelta_trabajar_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->update('ingreso_produccion', $datos);
	}

	function eliminar_trabajador_camion_p4($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar){
		$datos = array('id_ayudante_4' => 0, );
		$this->db->where('id_ayudante_4', $id_trabajador);
		$this->db->where('vuelta', $vuelta_trabajar_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->update('ingreso_produccion', $datos);
	}

	function guardar_produccion_camion($datos, $codigo_camion, $vueltas, $fecha_mostrar){
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->update('ingreso_produccion', $datos);
	}

	function mostrar_nombre_ruta($id_ruta){
		$this->db->select('*');
		$this->db->from('rutas');
		$this->db->where('id', $id_ruta);
		$this->db->where('estado !=', 3);
		$query = $this->db->get();
		return $query->row();

	}

	function listar_ruta_camion($id_ccu, $vuelta_trabajar, $fecha_trabajar){
		$this->db->select('id_ruta');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 0);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}

	}


	function cajas_entrega($id_ccu, $vuelta_trabajar, $fecha_trabajar){
		$this->db->select('cajas_entrega');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('estado', 1);
		$this->db->where('eliminado', 0);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}
	}

	function consulta_camion_produccion($fecha_trabajar, $vuelta_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function listar_produccion_camion($id_camion, $vuelta_trabajar, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $vuelta_trabajar);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "N/D";
		}
	}

	function ver_tripulacion_camion($codigo_camion, $vueltas, $fecha_mostrar){
		$query = $this->db->query("SELECT  SUM( IF(id_ayudante_1 = 0, 1, 0)) +
			SUM( IF(id_ayudante_2 = 0, 1, 0)) +
			SUM( IF(id_ayudante_3 = 0, 1, 0)) +
			SUM( IF(id_ayudante_4 = 0, 1, 0)) total
			FROM ingreso_produccion where vuelta = '$vueltas' and 
			fecha_registro = '$fecha_mostrar' and id_camion = '$codigo_camion';");
		return $row = $query->row_array();		
	}

	function guarda_tripulacion_actual($data, $codigo_camion, $vueltas, $fecha_mostrar){
		$this->db->where('id_camion', $id_camion);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->insert('ingreso_produccion', $data);
	}

	

	function comprara_trabajadores($codigo_camion, $ultima_vuelta, $ultima_fecha){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $ultima_vuelta);
		$this->db->where('fecha_registro', $ultima_fecha);
		$query = $this->db->get();
		return $query->result();
		//return $query->row();
	}

	function trabajador_defecto($codigo_camion, $ultima_vuelta){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $ultima_vuelta);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function listar_todos_trabajadores($id_chofer, $codigo_camion, $vueltas){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_chofer', $id_chofer);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows > 0)
			return $query->row();
		else
			return "NE";
	}

	function listar_todos_ayudante_1($id_ayudante_1, $codigo_camion, $vueltas){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_1', $id_ayudante_1);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows > 0)
			return $query->row();
		else
			return "NE";		
	}

	function listar_todos_ayudante_2($id_ayudante_2, $codigo_camion, $vueltas){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_2', $id_ayudante_2);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows > 0)
			return $query->row();
		else
			return "NE";		
	}

	function listar_todos_ayudante_3($id_ayudante_3, $codigo_camion, $vueltas){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_3', $id_ayudante_3);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows > 0)
			return $query->row();
		else
			return "NE";		
	}

	function listar_todos_ayudante_4($id_ayudante_4, $codigo_camion, $vueltas){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_ayudante_4', $id_ayudante_4);
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows > 0)
			return $query->row();
		else
			return "NE";		
	}


	function datos_trabajadores($id_chofer){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am');
		$this->db->from('persona p, trabajador t');
		$this->db->where('t.id_persona = p.id');
		$this->db->where('p.id', $id_chofer);
		$this->db->where('t.id_cargo', 72);
		$query = $this->db->get();
		return $query->result();	
	}

	function datos_peoneta($id_ayudante_1){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am');
		$this->db->from('persona p, trabajador t');
		$this->db->where('t.id_persona = p.id');
		$this->db->where('p.id', $id_ayudante_1);
		$this->db->where('t.id_cargo', 73);
		$query = $this->db->get();
		return $query->result();	

	}

	function consulta_si_existe_trabajador_inasistente($id, $vueltas, $fecha_mostrar){
		$this->db->select('*');
		$this->db->from('inasistencias');
		$this->db->where('id_trabajador', $id);
		$this->db->where('vuelta', $vueltas);
		//$this->db->where('codigo_camion', $codigo_camion);
		$this->db->where('fecha_registro', $fecha_mostrar);
		//$this->db->where('estado', 2);
		$query = $this->db->get();
		if($query->num_rows > 0)
			return $query->row();
		else
			return "NO";		
	}

	function guarda_inasistentes($guarda_info_inasistentes){
		$this->db->insert('inasistencias', $guarda_info_inasistentes);
	}

	function mostrar_inasistentes($fecha_trabajar, $vuelta_trabajar){
		$this->db->select('p.id as id, p.nombre as nombre, p.apellido_paterno as ap, p.apellido_materno as am, t.id_cargo as cargo, c.codigos_ccu as ccu, c.idcodigos_ccu as id_ccu');
		$this->db->from('inasistencias i');
		$this->db->join('persona p', 'p.id = i.id_trabajador', 'inner');
		$this->db->join('trabajador t', 't.id_persona = i.id_trabajador', 'inner');
		$this->db->join('codigos_ccu c', 'c.idcodigos_ccu = i.codigo_camion', 'inner');
		$this->db->where('i.fecha_registro', $fecha_trabajar);
		$this->db->where('i.vuelta', $vuelta_trabajar);
		$this->db->where('i.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function guardar_tipo_inasistencia($guarda_inasistentes, $id_trabajador, $fecha_trabajar, $vuelta, $id_ccu){
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('codigo_camion', $id_ccu);
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->update('inasistencias', $guarda_inasistentes);
	}

	function consultar_inasistentes_vuelta_camion($vueltas, $fecha_mostrar){
		$this->db->select('*');
		$this->db->from('inasistencias');	
		$this->db->where('vuelta', $vueltas);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return $query->row();
		}else{
			return "NO";
		}
	}

	function arreglo_trabajadores_camion($codigo_camion, $vueltas, $fecha_mostrar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $codigo_camion);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('fecha_registro', $fecha_mostrar);
		//$this->db->where('estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function guarda_tabla_resumen_1($guardar_produccion_forma_2){
		$this->db->insert('tabla_resumen_produccion', $guardar_produccion_forma_2);
		return $this->db->insert_id();
	}

	function obtener_pallets_camion($codigo_camion){
		$this->db->select('pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'inner');
		$this->db->where('ccu.codigo_ccu', $codigo_camion);
		$this->db->where('c.estado', 1);
		$query = $this->db->get();
		return $query->row()->pallets;
	}

	function obtener_pallets_camion_2($codigo){
		$this->db->select('pallets as pallets');
		$this->db->from('camiones c');
		$this->db->join('ccu_camion ccu', 'ccu.codigo_camion = c.id', 'inner');
		$this->db->where('ccu.codigo_ccu', $codigo);
		$this->db->where('c.estado', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function si_existe_en_tabla_resumen($id_trabajador, $fecha_mostrar, $vueltas, $codigo_camion){
		$this->db->select('*');
		$this->db->from('tabla_resumen_produccion');
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('id_camion', $codigo_camion);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return $query->row();
		}else{
			return "NO";
		}
	}

	function actualiza_tabla_resumen_1($fecha_mostrar, $vueltas, $id_trabajador, $actualiza_produccion_forma_2){
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->update('tabla_resumen_produccion', $actualiza_produccion_forma_2);
		return $this->db->insert_id(); 
	}

	function extraer_cargo($id_trabajador){
		$this->db->select('id_cargo as cargo');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id_trabajador);
		$query = $this->db->get();
		if ($query->num_rows != 0) {
			return $query->row()->cargo;
		}else{
			return "NO";
		}

	}

	function extraer_tipo_contrato($id_trabajador){
		$this->db->select('id_instrumento_colectivo as colectivo');
		$this->db->from('trabajador');
		$this->db->where('id_persona', $id_trabajador);
		$query = $this->db->get();
		if ($query->num_rows != 0) {
			return $query->row()->colectivo;
		}else{
			return "NO";
		}
		
	}



	function consulta_bono_calculado($id_trabajador, $fecha_mostrar, $vueltas, $pallets_camion_data){
		$this->db->select('*');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vueltas);
		$this->db->where('tamano_camion', $pallets_camion_data);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return $query->row();
		}else{
			return "NO";
		}
	}

	function guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores){
		$this->db->insert('tabla_bonos_calculados', $bonos_calculados_trabajadores);
	}

	function guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores){
		$this->db->insert('tabla_resumen_bonos_vuelta_adicional', $bonos_calculados_trabajadores);
	}

	function actualiza_bonos_calculados_trabajadores($vueltas, $fecha_mostrar, $id_trabajador, $pallets_camion_data, $bonos_calculados_trabajadores){
		$this->db->where('vuelta', $vueltas);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->where('tamano_camion', $pallets_camion_data);
		$this->db->update('tabla_bonos_calculados', $bonos_calculados_trabajadores);
	}

	function consulta_vuelta_almacenada($vuelta_trabajar, $fecha_trabajar){
		$this->db->select('SUM(estado_vuelta) AS estado_vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('id_camion !="N/D"');
		$query = $this->db->get();
		return $query->row()->estado_vuelta;
	}

	function rescatar_chofer($id_camion, $vuelta, $fecha_mostrar){
		$this->db->select('id_chofer as chofer');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$query = $this->db->get();
		return $query->row()->chofer;
	}

	function rescatar_id_peoneta_1($id_camion, $vuelta, $fecha_mostrar){
		$this->db->select('id_ayudante_1 as peoneta_1');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$query = $this->db->get();
		return $query->row()->peoneta_1;
	}

	function rescatar_id_peoneta_2($id_camion, $vuelta, $fecha_mostrar){
		$this->db->select('id_ayudante_2 as peoneta_2');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$query = $this->db->get();
		return $query->row()->peoneta_2;
	}

	function rescatar_id_peoneta_3($id_camion, $vuelta, $fecha_mostrar){
		$this->db->select('id_ayudante_3 as peoneta_3');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$query = $this->db->get();
		return $query->row()->peoneta_3;
	}

	function rescatar_id_peoneta_4($id_camion, $vuelta, $fecha_mostrar){
		$this->db->select('id_ayudante_4 as peoneta_4');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$query = $this->db->get();
		return $query->row()->peoneta_4;
	}

	function consultar_ultimo_camion(){
		$this->db->select('c_ccu.codigos_ccu as codigo, c_ccu.idcodigos_ccu as id_ccu');
		$this->db->from('codigos_ccu c_ccu ');
		$this->db->join('ccu_camion c_camion', 'c_ccu.idcodigos_ccu = c_camion.codigo_ccu', 'inner');
		$this->db->where('c_camion.estado', 1);
		$this->db->order_by('c_camion.idccu_camion', 'desc');
		//$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	function guarda_ultimo_camion($data_almacenada){
		$this->db->insert('ingreso_produccion', $data_almacenada);
	}

	function consulta_existe_camion_vuelta_nuevo($id_ccu, $ultima_vuelta , $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_ccu);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('vuelta', $ultima_vuelta);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function consultar_por_trabajador($id_chofer, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id_chofer);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado_actual', 6);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function consultar_por_trabajador_ayudante_1($id_ayudante_1, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id_ayudante_1);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado_actual', 6);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function consultar_por_trabajador_ayudante_2($id_ayudante_2, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id_ayudante_2);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado_actual', 6);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function consultar_por_trabajador_ayudante_3($id_ayudante_3, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id_ayudante_3);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado_actual', 6);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function consultar_por_trabajador_ayudante_4($id_ayudante_4, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('id_persona', $id_ayudante_4);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('estado_actual', 6);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}

	function si_existe_vuelta($vuelta_trabajar, $fecha_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('vuelta', $vuelta_trabajar);
		$this->db->where('fecha_registro', $fecha_trabajar);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function consulta_vuelta_almacenada_fecha($fecha_trabajar){
		$this->db->select('SUM(estado_vuelta) AS estado_vuelta');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_camion !="N/D"');
		$query = $this->db->get();
		return $query->row()->estado_vuelta;
	}

	function borra_datos_de_resumen_dia_vuelta($fecha_mostrar, $vueltas){
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('vuelta', $vueltas);
		$this->db->delete('tabla_resumen_produccion');
	}

	function borra_datos_de_calculo_dia_vuelta($fecha){
		$this->db->where('fecha_registro', $fecha);
		//$this->db->where('vuelta', $vueltas);
		$this->db->delete('tabla_bonos_calculados');
	}

	function borra_datos_vuelta_adicional_almacenada($fecha){
		$this->db->where('fecha_registro', $fecha);
		//$this->db->where('vuelta', $vueltas);
		$this->db->delete('tabla_resumen_bonos_vuelta_adicional');
	}

	function datos_ultima_vuelta($id_persona){
		$this->db->select('*');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador', $id_persona);
		$this->db->where('vuelta >', 1);
		$this->db->order_by('fecha_registro', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();

	}

	function si_existe_vuelta_descontada($id_trabajador, $fecha_mostrar){
		$this->db->select('*');
		$this->db->from('tabla_bonos_calculados');
		$this->db->where('id_trabajador', $id_trabajador);
		$this->db->where('fecha_registro', $fecha_mostrar);
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function listar_registros_dia($nuevafecha){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('fecha_registro', $nuevafecha);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function actualiza_cierre($fecha_registro){
		$actualiza_data = array('estado_cierre' => 1, );
		$this->db->where('fecha_registro', $fecha_registro);
		$this->db->update('ingreso_produccion', $actualiza_data);
	}




	/*function si_existe_vuelta_uno($id_camion, $vuelta_trabajar){
		$this->db->select('*');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $id_camion);
		$this->db->where('vuelta', $vuelta_trabajar);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}*/

	/*function camion_existe_en_produccuin($ultimo_id_camion, $ultima_vuelta, $ultima_fecha){
		$this->db->select('id_camion');
		$this->db->from('ingreso_produccion');
		$this->db->where('id_camion', $ultimo_id_camion);		
		$this->db->where('fecha_registro', $ultima_fecha);
		$this->db->where('vuelta', $ultima_vuelta);
		$this->db->where('estado', 1);		
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}

	}*/
}

/* End of file S_produccion_model.php */
/* Location: ./application/models/S_produccion_model.php */