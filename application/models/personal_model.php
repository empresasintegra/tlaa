<?php
class personal_model extends CI_Model {                
	function listar(){
		$this->db->SELECT('*, persona.id as id_trabajador');	
		$this->db->select('tipo_inasistencias.nombre_falta as nombre_falta');
		$this->db->SELECT('cargos.nombre as cargos');
		$this->db->SELECT('instrumento_colectivo.nombre as nombre_instrumento_colectivo');
		$this->db->From('trabajador');
		$this->db->join('cargos','trabajador.id_cargo = cargos.id','inner');
		$this->db->join('instrumento_colectivo', 'trabajador.id_instrumento_colectivo = instrumento_colectivo.id','inner');
		$this->db->join('persona', 'trabajador.id_persona = persona.id', 'inner');
		$this->db->join('tipo_inasistencias', 'tipo_inasistencias.id = trabajador.estado_actual', 'left');
		$this->db->join('empresa', 'empresa.id = trabajador.id_empresa', 'inner');
		$this->db->order_by('persona.apellido_paterno', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_activos($fecha_1,$fecha_2){
		$this->db->SELECT('*, persona.id as id_trabajador');	
		$this->db->select('tipo_inasistencias.nombre_falta as nombre_falta');
		$this->db->SELECT('cargos.nombre as cargos');
		$this->db->SELECT('instrumento_colectivo.nombre as nombre_instrumento_colectivo');
		$this->db->select('tabla_bonos_calculados.id_trabajador as id_t' );
		$this->db->From('trabajador');
		$this->db->join('cargos','trabajador.id_cargo = cargos.id','inner');
		$this->db->join('instrumento_colectivo', 'trabajador.id_instrumento_colectivo = instrumento_colectivo.id','inner');
		$this->db->join('persona', 'trabajador.id_persona = persona.id', 'inner');
		$this->db->join('tipo_inasistencias', 'tipo_inasistencias.id = trabajador.estado_actual', 'inner');
		$this->db->join('tabla_bonos_calculados', 'tabla_bonos_calculados.id_trabajador = trabajador.id_persona', 'inner');
		$this->db->join('empresa', 'empresa.id = trabajador.id_empresa', 'left');
		$this->db->where('empresa.id', 2);
		$this->db->where('trabajador.id_estado', 1);
		$this->db->where('tabla_bonos_calculados.fecha_registro BETWEEN "'. date('Y-m-d', strtotime($fecha_1)). '" and "'. date('Y-m-d', strtotime($fecha_2)).'"');
		$this->db->group_by('trabajador.id_persona');

		$query = $this->db->get();
		return $query->result();
	}


	function listar_activos2($fecha_1,$fecha_2){
		$this->db->SELECT('*, persona.id as id_trabajador');	
		$this->db->select('tipo_inasistencias.nombre_falta as nombre_falta');
		$this->db->SELECT('cargos.nombre as cargos');
		$this->db->SELECT('instrumento_colectivo.nombre as nombre_instrumento_colectivo');
		$this->db->select('tabla_bonos_calculados.id_trabajador as id_t' );
		$this->db->From('trabajador');
		$this->db->join('cargos','trabajador.id_cargo = cargos.id','inner');
		$this->db->join('instrumento_colectivo', 'trabajador.id_instrumento_colectivo = instrumento_colectivo.id','inner');
		$this->db->join('persona', 'trabajador.id_persona = persona.id', 'inner');
		$this->db->join('tipo_inasistencias', 'tipo_inasistencias.id = trabajador.estado_actual', 'inner');
		$this->db->join('tabla_bonos_calculados', 'tabla_bonos_calculados.id_trabajador = trabajador.id_persona', 'inner');
		$this->db->join('empresa', 'empresa.id =  trabajador.id_empresa', 'inner');
		
		//$this->db->where('empresa.id', 2);
		$this->db->where('trabajador.id_estado', 1);
		$this->db->where('tabla_bonos_calculados.fecha_registro BETWEEN "'. date('Y-m-d', strtotime($fecha_1)). '" and "'. date('Y-m-d', strtotime($fecha_2)).'"');
		$this->db->group_by('trabajador.id_persona');

		$query = $this->db->get();
		return $query->result();
	}

	function listar_inactivos(){
		$this->db->SELECT('*, persona.id as id_trabajador');	
		$this->db->select('tipo_inasistencias.nombre_falta as nombre_falta');
		$this->db->SELECT('cargos.nombre as cargos');
		$this->db->SELECT('instrumento_colectivo.nombre as nombre_instrumento_colectivo');
		$this->db->From('trabajador');
		$this->db->join('cargos','trabajador.id_cargo = cargos.id','inner');
		$this->db->join('instrumento_colectivo', 'trabajador.id_instrumento_colectivo = instrumento_colectivo.id','inner');
		$this->db->join('persona', 'trabajador.id_persona = persona.id', 'inner');
		$this->db->join('tipo_inasistencias', 'tipo_inasistencias.id = trabajador.estado_actual', 'inner');
		$this->db->where('trabajador.id_estado', 2);
		$query = $this->db->get();
		return $query->result();
	}


	function listarcargo(){
		$this->db->select('*');
		$this->db->from('cargos');
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result()as $row)
				$arrDatos[htmlspecialchars($row->id, ENT_QUOTES)]=htmlspecialchars($row->nombre, ENT_QUOTES);
			$query->free_result();
			return $arrDatos;
		}
	}	

	function listarcontrato(){
		$this->db->select('*');
		$this->db->from('instrumento_colectivo');
		$this->db->where('estado', 1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result()as $row)
				$arrDatos[htmlspecialchars($row->id, ENT_QUOTES)]=htmlspecialchars($row->nombre, ENT_QUOTES);
			$query->free_result();
			return $arrDatos;
		}
	}

	function listarempresa(){
		$this->db->select('*');
		$this->db->from('empresa');
		$this->db->where('estado_e', 1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach($query->result()as $row)
				$arrDatos[htmlspecialchars($row->id, ENT_QUOTES)]=htmlspecialchars($row->empresa, ENT_QUOTES);
			$query->free_result();
			return $arrDatos;
		}
	}

	function ingresar($data){
		$this->db->insert('persona',$data);
		return $this->db->insert_id(); 
	}

	function ingresar_trabajador($data2){
		$this->db->insert('trabajador',$data2); 
	}
	function get_trabajador($id){
		$this->db->select('p.id as id, p.rut as rut, p.nombre as nombre, p.apellido_paterno as ap, 
					apellido_materno as am, c.id as id_cargo, c.nombre as n_cargo, i.id as id_instrumento_colectivo, i.nombre as n_instrumento, e.empresa as empresa, e.id as id_empresa');
		$this->db->from('trabajador t');
		$this->db->join('persona p','p.id = t.id_persona','inner');
		$this->db->join('cargos c','c.id = t.id_cargo','inner');
		$this->db->join('instrumento_colectivo i', 'i.id = t.id_instrumento_colectivo','inner');
		$this->db->join('empresa e', 'e.id = t.id_empresa','inner');
		$this->db->where('t.id_persona',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_contrato($id){
		$this->db->join("forma_pago",'trabajador.id_forma_pago = forma_pago.id');
		$this->db->where("forma_pago.id",$id);
		$query = $this->db->get('trabajador');
		return $query->result();
	}

	function editar($data){
		$this->db->update('persona', $data); 
	}

	function actualizar($id,$data){
		$this->db->where('id',$id);
		$this->db->update('persona',$data); 
		return $this->db->insert_id();
	}

	function actualizar_trabajador($id,$data2){
		$this->db->where('id_persona',$id);
		$this->db->update('trabajador',$data2); 
		return $this->db->insert_id();
	}

	function actualizar_trabajador_al_dia($id,$data2){
		$this->db->where('id_persona',$id);
		$this->db->update('trabajador_al_dia',$data2); 
	}
	function traer_datos($id){
		$this->db->select('*');
		$this->db->where('id_persona',$id);
		$this->db->from('trabajador');
		$query = $this->db->get();
		return $query->result();


		//$this->db->where('id_persona',$id);
		//$this->db->delete('trabajador');
		
	}

		

	function actualizar_estado_activo_trabajador($data, $id_trabajador){
		$this->db->where('id_persona', $id_trabajador);
		$this->db->update('trabajador', $data);
	}

	function actualizar_estado_inactivo_trabajador($estadoarray, $c){
		$this->db->where('id_persona', $c);	
		$this->db->update('trabajador', $estadoarray);
	}

	function consulta_rut_trabajador($rut){
		$this->db->select('*');
		$this->db->from('persona');
		$this->db->where('rut', $rut);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function ingresar_excel($data){
		$this->db->insert('persona',$data);
		return $this->db->insert_id(); 
	}

	function ingresar_trabajador_excel($data2){
		$this->db->insert('trabajador',$data2); 
	}

	function tipo_inasistencia(){
		$this->db->select('*');
		$this->db->from('tipo_inasistencias');
		$query = $this->db->get();
		return $query->result();
	}

	function guarda_estado_trabajadores($datas, $c){
		$this->db->where('id_persona', $c);
		$this->db->update('trabajador', $datas);
	}

	function actualiza_estado_trabajadores($datas, $c, $fecha_actual){
		$this->db->where('fecha_registro', $fecha_actual);
		$this->db->where('id_persona', $c);
		$this->db->update('trabajador_al_dia', $datas);
	}

	function guarda_personal_dia($trabajadores_activos){
		$this->db->insert('trabajador_al_dia', $trabajadores_activos);
	}
	
	function consulta_fecha_seleccionada2($fecha_trabajar, $id_persona){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$this->db->where('id_persona', $id_persona);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return "SI";
		}else{
			return "NO";
		}
	}

	function consulta_fecha_seleccionada($fecha_trabajar){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia');
		$this->db->where('fecha_registro', $fecha_trabajar);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return "NO";
		}
	}
	
	function trabajadores_al_dia($ultima_fecha_registrada){
		$this->db->select('*');
		$this->db->from('trabajador_al_dia t_dia');
		$this->db->where('t_dia.fecha_registro', $ultima_fecha_registrada);
		$this->db->where('t_dia.id_estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function crea_nuevo_registro($crea_nuevos_datos){
		$this->db->insert('trabajador_al_dia', $crea_nuevos_datos);
	}

	function listar_trabajadores_dia($fecha_trabajar){
		$this->db->select('p.id as id_trabajador, p.rut as rut, p.nombre as nombre, p.apellido_paterno as ap, 
			p.apellido_materno as am, t_dia.fecha_registro, c.nombre as cargo,
			t_dia.estado_actual as estado, t_dia.comentario, nombre_falta');
		$this->db->from('trabajador_al_dia t_dia');
		$this->db->join('persona p', 't_dia.id_persona = p.id', 'inner');
		$this->db->join('cargos c', 't_dia.id_cargo = c.id', 'inner');
		$this->db->join('tipo_inasistencias tipo', 'tipo.id = t_dia.estado_actual', 'inner');
		$this->db->where('t_dia.fecha_registro', $fecha_trabajar);
		$this->db->where('t_dia.id_estado', 1);
		$this->db->order_by('p.apellido_paterno', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_nuevos_trabajadores_choferes($fecha_trabajar){
		$query = $this->db->query("select t.id_empresa as empresa, p.id as id, p.nombre as nombre, p.apellido_paterno as ap, apellido_materno as am, t.id_cargo as cargo, t.id_instrumento_colectivo as colectivo	
			FROM trabajador t
			inner join persona p on p.id = t.id_persona
			WHERE t.id_persona NOT IN (SELECT id_persona FROM trabajador_al_dia where fecha_registro = '".$fecha_trabajar."')
			and t.id_cargo ='72'");
		return $query->result();
	}

	function listar_nuevos_trabajadores_ayudante($fecha_trabajar){
		$query = $this->db->query("select t.id_empresa as empresa, p.id as id, p.nombre as nombre, p.apellido_paterno as ap, apellido_materno as am, t.id_cargo as cargo, t.id_instrumento_colectivo as colectivo	
			FROM trabajador t
			inner join persona p on p.id = t.id_persona
			WHERE t.id_persona NOT IN (SELECT id_persona FROM trabajador_al_dia where fecha_registro = '".$fecha_trabajar."')
			and t.id_cargo ='73'");
		return $query->result();
	}

	function guarda_nuevos_trabajadores($datas){
		$this->db->insert('trabajador_al_dia', $datas);
	}

/*	function ultima_fecha_registrada($fecha_trabajar){
		$this->db->select('fecha_registro as fecha');
		$this->db->from('trabajador_al_dia');
		$this->db->where('fecha_registro <=', $fecha_trabajar);
		$this->db->order_by('fecha_registro', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row()->fecha;
	}*/

	function actualiza_resumen_produccion($id,$data2){
		$this->db->where('id_trabajador',$id);
		$this->db->update('tabla_resumen_produccion',$data2); 
		return $this->db->insert_id();
	}

	function respaldo($datos2){
		$this->db->insert('respaldo_trabajador',$datos2);
		
	}

	function borrar($id){
		$this->db->where('id_persona',$id);
		$this->db->delete('trabajador');


	}

	function buscar_trabajadores(){
		$this->db->select('*');
		$this->db->select('p.nombre as nombrep');
		$this->db->select('c.nombre as nombreca');
		$this->db->select('i.nombre as nombrei');
		$this->db->select('respaldo_trabajador.id as id_respaldo');
		$this->db->from('respaldo_trabajador');
		$this->db->join('persona p ', 'p.id = respaldo_trabajador.id_persona','left');
		$this->db->join('instrumento_colectivo i','i.id = respaldo_trabajador.id_instrumento_colectivo','left');
		$this->db->join('cargos c','c.id = respaldo_trabajador.id_cargo','left');
		$this->db->where('respaldo_trabajador.estado',1);

		$query = $this->db->get();
		return $query->result();


	}

    function traer_datos_respaldo ($id){
    	$this->db->select('*');
		$this->db->where('id_persona',$id);
		$this->db->where('estado',1);
		$this->db->from('respaldo_trabajador');
		$query = $this->db->get();
		return $query->result();


    }

    function actualizar_respaldo($id,$actualizar_respaldo){
    	$this->db->where('id_persona',$id);
    	$this->db->update('respaldo_trabajador',$actualizar_respaldo);
       


    }

    function devolver_trabajador($datos2){
    $this->db->insert('trabajador',$datos2);
}

	function comprobar_rut($rut){

		$this->db->select('*');
		$this->db->where('rut',$rut);
		$this->db->from('persona');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}


function listar_activos3($fecha_inicio,$fecha_termino){
		$this->db->SELECT('*, persona.id as id_trabajador');	
		$this->db->select('tipo_inasistencias.nombre_falta as nombre_falta');
		$this->db->SELECT('cargos.nombre as cargos');
		$this->db->SELECT('instrumento_colectivo.nombre as nombre_instrumento_colectivo');
		$this->db->select('tabla_bonos_calculados.id_trabajador as id_t' );
		$this->db->From('trabajador');
		$this->db->join('cargos','trabajador.id_cargo = cargos.id','inner');
		$this->db->join('instrumento_colectivo', 'trabajador.id_instrumento_colectivo = instrumento_colectivo.id','inner');
		$this->db->join('persona', 'trabajador.id_persona = persona.id', 'inner');
		$this->db->join('tipo_inasistencias', 'tipo_inasistencias.id = trabajador.estado_actual', 'inner');
		$this->db->join('tabla_bonos_calculados', 'tabla_bonos_calculados.id_trabajador = trabajador.id_persona', 'inner');
		$this->db->join('empresa', 'empresa.id = trabajador.id_empresa', 'left');
		$this->db->where('empresa.id', 1);
		$this->db->where('trabajador.id_estado', 1);
		$this->db->where('tabla_bonos_calculados.fecha_registro BETWEEN "'. date('Y-m-d', strtotime($fecha_inicio)). '" and "'. date('Y-m-d', strtotime($fecha_termino)).'"');
		$this->db->group_by('trabajador.id_persona');

		$query = $this->db->get();
		return $query->result();
	}


	function listar1($id){

		$this->db->select('nombre');
		$this->db->where('persona.id',$id);
		$query=$this->db->get('persona',1)->row();
		return $query->nombre;

		var_dump('query');exit;
	}


	function listar2($id){

		$this->db->select('rut');
		$this->db->where('persona.id',$id);
		$query=$this->db->get('persona',1)->row();
		return $query->rut;
	}

	function listar3($id){

		$this->db->select('apellido_paterno');
		$this->db->where('persona.id',$id);
		$query=$this->db->get('persona',1)->row();
		return $query->apellido_paterno;
	}

	
	function listar4($id){

		$this->db->select('apellido_materno');
		$this->db->where('persona.id',$id);
		$query=$this->db->get('persona',1)->row();
		return $query->apellido_materno;
	}

	function listar5($id){

		$this->db->select('id_cargo');
	
        $this->db->where('trabajador.id_persona',$id);
		$query=$this->db->get('trabajador',1)->row();
		return $query->id_cargo;
	}
	

	function listar6($id_cargo_traer){

		$this->db->select('id');
	
        $this->db->where('persona.id',$id_cargo_traer);
		$query=$this->db->get('persona',1)->row();
		return $query->id;
	}

	
	function listar7($id_cargo_traer){

		$this->db->select('nombre');
	
        $this->db->where('cargos.id',$id_cargo_traer);
		$query=$this->db->get('cargos',1)->row();
		return $query->nombre;
	}

	function listar8($id_cargo){


		$this->db->select('nombre');
	
        $this->db->where('cargos.id',$id_cargo);
		$query=$this->db->get('cargos',1)->row();
		return $query->nombre;
	}

	//seleccionar id_instrumento_colectivo para buscar nombre en
	function listar9($id){

	$this->db->select('id_instrumento_colectivo');
	$this->db->where('trabajador.id_persona',$id);
	$query=$this->db->get('trabajador',1)->row();
	return $query->id_instrumento_colectivo;
    }

		
	function listar10($i_colectivo_nuevo){

		$this->db->select('nombre');
	    $this->db->where('instrumento_colectivo.id',$i_colectivo_nuevo);
		$query=$this->db->get('instrumento_colectivo',1)->row();
		return $query->nombre;
	}

	// instrumento colectivo
	function listar11( $id_instrumento_colectivo){


		$this->db->select('nombre');
	
        $this->db->where('instrumento_colectivo.id', $id_instrumento_colectivo);
		$query=$this->db->get('instrumento_colectivo',1)->row();
		return $query->nombre;
	}


	function listar13($id){

		$this->db->select('id_empresa');
		$this->db->where('trabajador.id_persona',$id);
		$query=$this->db->get('trabajador',1)->row();
		return $query->id_empresa;
		}
	
			
		function listar14($id_empresa_traer){
	
			$this->db->select('empresa');
			$this->db->where('empresa.id',$id_empresa_traer);
			$query=$this->db->get('empresa',1)->row();
			return $query->empresa;
		}

		function listar15( $id_empresa){


			$this->db->select('empresa');
			$this->db->where('empresa.id', $id_empresa);
			$query=$this->db->get('empresa',1)->row();
			return $query->empresa;
		}



		function traer_nombre($buscar_persona){

			$this->db->select('nombre');
			$this->db->where('persona.id', $buscar_persona);
			$query=$this->db->get('persona',1)->row();
			return $query->nombre;
 
		}

		function traer_apellido($buscar_persona){

			$this->db->select('apellido_paterno');
			$this->db->where('persona.id', $buscar_persona);
			$query=$this->db->get('persona',1)->row();
			return $query->apellido_paterno;
 
		}

		function buscar_id_persona($id){

			$this->db->select('id_persona');
			$this->db->where('trabajador.id', $id);
			$query=$this->db->get('trabajador',1)->row();
			return $query->id_persona;


		}
	

}
