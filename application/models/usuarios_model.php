<?php
class Usuarios_model extends CI_Model {
	function listar(){
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_cantidad($mayor,$menor){
		$this->db->where("id >",$mayor);
		$this->db->where("id <",$menor);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_msj($nombre){
		$this->db->like("nombres",$nombre);
		$this->db->or_like("paterno",$nombre);
		$this->db->or_like("materno",$nombre);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_especialidad($id,$limite=false,$pagina=false){
		$this->db->where("id_especialidad_trabajador",$id);
		if( isset($pagina) && isset($limite) ){
			$query = $this->db->get('usuarios',$limite,$pagina);
		}
		else
			$query = $this->db->get('usuarios');
		return $query->result();
	}
	function listar_id(){
		$this->db->select('id');
		$this->db->where("id_tipo_usuarios",2);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	function listar_filtro($nombre=false,$rut=false,$id_profesion=false,$id_especialidad=false,$id_ciudad=false,$clave=false,$activo=false,$limite=false,$pagina=false){
		//$this->db->cache_on();
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');	
		if($nombre){
			$this->db->or_like("nombres",$nombre);
			$this->db->or_like("paterno",$nombre);
			$this->db->or_like("materno",$nombre);
		}
		if($rut)
			$this->db->or_like("rut_usuario",$rut);
		if($id_profesion)
			$this->db->where("id_profesiones",$id_profesion);
		if($id_especialidad)
			$this->db->where("id_especialidad_trabajador",$id_especialidad);
		if($id_ciudad)
			$this->db->or_like("id_ciudades",$id_ciudad);
		if($clave){
			$this->db->or_like("idiomas",$clave);
			$this->db->or_like("software",$clave);
			$this->db->or_like("equipos",$clave);
			$this->db->or_like("cursos",$clave);
			$this->db->or_like("institucion",$clave);
		}
		$this->db->from('usuarios');
		if($clave){
			$this->db->join('experiencia', 'usuarios.id = experiencia.id_usuarios','left');
			$this->db->or_like("experiencia.funciones",$clave);
			$this->db->or_like("experiencia.referencias",$clave);
		}
		if($activo){
			if($activo == 1){
				$this->db->where("id not in (SELECT id_usuarios FROM asigna_requerimiento)",NULL);
			}
			if($activo == 2)
				$this->db->join('asigna_requerimiento', 'usuarios.id = asigna_requerimiento.id_usuarios');
		}
		$this->db->where("id_tipo_usuarios" ,2);
		if( isset($pagina) && isset($limite) )
			$this->db->limit($limite, $pagina);

		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		//$this->db->join('evaluaciones', 'usuarios.id = evaluaciones.id_usuarios', 'left');
		//$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion', 'left');
		//$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo', 'left');
		//$this->db->where("evaluaciones_tipo.id" ,3); //examen preocupacional
		//$this->db->where("evaluaciones_tipo.id" ,4); //masso
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function total_filtro($nombre=false,$rut=false,$id_profesion=false,$id_especialidad=false,$id_ciudad=false,$clave=false,$activo=false){
		$this->db->select('*');	
		if($nombre){
			$this->db->or_like("nombres",$nombre);
			$this->db->or_like("paterno",$nombre);
			$this->db->or_like("materno",$nombre);
		}
		if($rut)
			$this->db->or_like("rut_usuario",$rut);
		if($id_profesion)
			$this->db->or_like("id_profesiones",$id_profesion);
		if($id_especialidad)
			$this->db->or_like("id_especialidad_trabajador",$id_especialidad);
		if($id_ciudad)
			$this->db->or_like("id_ciudades",$id_ciudad);
		if($clave){
			$this->db->or_like("idiomas",$clave);
			$this->db->or_like("software",$clave);
			$this->db->or_like("equipos",$clave);
			$this->db->or_like("cursos",$clave);
			$this->db->or_like("institucion",$clave);
		}
		$this->db->from('usuarios');
		if($clave){
			$this->db->join('experiencia', 'usuarios.id = experiencia.id_usuarios','left');
			$this->db->or_like("experiencia.funciones",$clave);
			$this->db->or_like("experiencia.referencias",$clave);
		}
		if($activo){
			if($activo == 1){
				$this->db->where("id not in (SELECT id_usuarios FROM asigna_requerimiento)",NULL);
			}
			if($activo == 2)
				$this->db->join('asigna_requerimiento', 'usuarios.id = asigna_requerimiento.id_usuarios');
		}
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->where("id_tipo_usuarios" ,2);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function listar_internos(){
		$this->db->where("id_tipo_usuarios !=",2);
		$this->db->where("id_tipo_usuarios !=",1);
		$this->db->where("id_tipo_usuarios !=",6);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_mandantes(){
		$this->db->where("id_tipo_usuarios",1);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	function listar_trabajadores(){
		$this->db->where("id_tipo_usuarios",2);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_trabajadores_paginado($l1=0,$l2=false){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->where("id_tipo_usuarios",2);
		if( !empty($l2) ) $this->db->limit($l2, $l1);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_trabajadores_paginado_filtrado($filtro,$l1=0,$l2=false){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->join('experiencia ex','ex.id_usuarios = usuarios.id','left');
		$this->db->where("id_tipo_usuarios",2);
		if($filtro){
			$this->db->or_like("nombres",$filtro);
			$this->db->or_like("paterno",$filtro);
			$this->db->or_like("materno",$filtro);
			$this->db->or_like("rut_usuario",$filtro);
			$this->db->or_like("idiomas",$filtro);
			$this->db->or_like("software",$filtro);
			$this->db->or_like("equipos",$filtro);
			$this->db->or_like("cursos",$filtro);
			$this->db->or_like("institucion",$filtro);
			$this->db->or_like("ciudades.desc_ciudades",$filtro);
			$this->db->or_like("et.desc_especialidad",$filtro);
			$this->db->or_like("ex.cargo",$filtro);
			$this->db->or_like("ex.area",$filtro);
			$this->db->or_like("ex.funciones",$filtro);
		}
		if( !empty($l2) ) $this->db->limit($l2, $l1);
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_trabajadores_totales(){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->where("id_tipo_usuarios",2);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	function listar_trabajadores_paginado_filtrado_totales($filtro){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->join('experiencia ex','ex.id_usuarios = usuarios.id','left');
		$this->db->where("id_tipo_usuarios",2);
		if($filtro){
			$this->db->or_like("nombres",$filtro);
			$this->db->or_like("paterno",$filtro);
			$this->db->or_like("materno",$filtro);
			$this->db->or_like("rut_usuario",$filtro);
			$this->db->or_like("idiomas",$filtro);
			$this->db->or_like("software",$filtro);
			$this->db->or_like("equipos",$filtro);
			$this->db->or_like("cursos",$filtro);
			$this->db->or_like("institucion",$filtro);
			$this->db->or_like("ciudades.desc_ciudades",$filtro);
			$this->db->or_like("et.desc_especialidad",$filtro);
			$this->db->or_like("ex.cargo",$filtro);
			$this->db->or_like("ex.area",$filtro);
			$this->db->or_like("ex.funciones",$filtro);
		}
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	function listar_no($id){
		$this->db->where('id_tipo_usuarios !=', $id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_tipo($id){
		$this->db->where('id_tipo_usuarios', $id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('usuarios');
		return $query->row();
	}
	
	function get_planta($id){
		$this->db->where('id_planta',$id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function get_planta_subusr($id){
		$this->db->where('id_planta',$id);
		$this->db->where('id_tipo_usuarios',6); //6 id sub usuarios del un usuario mandante
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function get_rut($rut){
		$this->db->where('rut_usuario',$rut);
		$query = $this->db->get('usuarios');
		return $query->row();
	}
	function validar($rut,$pass){
		//$this->db->select('usuarios_categoria.id AS tipo,tipo_usuarios.id AS subtipo,usuarios.rut_usuario AS rut,usuarios.id');
		$this->db->select('usuarios_categoria.id AS tipo,tipo_usuarios.id AS subtipo,usuarios.rut_usuario AS rut,usuarios.id AS id, usuarios.chat, usuarios.nombres');
		$this->db->from('usuarios');
		$this->db->join('usuarios_categoria', 'usuarios_categoria.id = usuarios.usuarios_categoria_id');
		$this->db->join('tipo_usuarios', 'tipo_usuarios.id = usuarios.id_tipo_usuarios', 'left');
		$this->db->where("rut_usuario",$rut);
		$this->db->where("clave",$pass);
		//$this->db->where("activo",0);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row();
	}
	
	function validar2($codigo,$pass){
		$this->db->select('usuarios_categoria.id AS tipo,tipo_usuarios.id AS subtipo,usuarios.rut_usuario AS rut,usuarios.id AS id, usuarios.chat, usuarios.nombres');
		$this->db->from('usuarios');
		$this->db->join('usuarios_categoria', 'usuarios_categoria.id = usuarios.usuarios_categoria_id');
		$this->db->join('tipo_usuarios', 'tipo_usuarios.id = usuarios.id_tipo_usuarios');
		$this->db->where("codigo_ingreso",$codigo);
		$this->db->where("clave",hash("sha512", $pass));
		$query = $this->db->get();
		return $query->row();
	}
	
	function editar($id,$data){
		//$this->db->cache_delete_all();
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data); 
	}

	function ingresar($data){
		//$this->db->cache_delete_all();
		$this->db->insert('usuarios',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		//$this->db->cache_delete_all();
		$this->db->delete('usuarios', array('id' => $id)); 
	}
	function manual($str){
		$query = $this->db->query($str);
		$data['id'] = $this->db->insert_id();
		if($data['error'] = $this->db->_error_message());
		return $data;
	}
	
	function total_planta($id_planta){
		$this->db->where('id_planta',$id_planta);
		$this->db->where('id_tipo_usuarios', 1);
		$query = $this->db->get('usuarios');
		return $query->num_rows();
	}
	function total_planta_sub($id_planta){
		$this->db->where('id_planta',$id_planta);
		$this->db->where('id_tipo_usuarios', 6);
		$query = $this->db->get('usuarios');
		return $query->num_rows();
	}

	function listar_chat(){
		$this->db->where('chat',1);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	/*****************************Actualizar contraseña******************************************/
	function actualizar_contrasena($rut, $clave, $data){
		$this->db->where('rut_usuario',$rut);
		$this->db->where('clave',$clave);
		$this->db->update('usuarios', $data);
	}
	/*****************************Enviar Contraseña a Correo******************************************/	
	function comprobar_correo($correo){
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('codigo_ingreso',$correo);
		$query = $this->db->get();
		return $query->result();
	}

	function encriptar($cadena){
	    $key='12345';  // esta es la clave de codificacion, debe usarse la misma para encriptar y desencriptar
	    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
	    return $encrypted; //Devuelve el string encriptado
 
	}
	function desencriptar($cadena){
	     $key='12345';  // esta es la clave de codificacion, debe usarse la misma para encriptar y desencriptar
	     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	    return $decrypted;  //Devuelve el string desencriptado
	} 


	function verificar_registro($iniciomes,$findemes){
		$this->db->select('count(*)');
		$this->db->from('cierre_mensual');
		$this->db->where('fecha_cierre BETWEEN "'. date('Y-m-d', strtotime($fecha_inicio)). '" and "'. date('Y-m-d', strtotime($fecha_termino)).'"');
		$query = $this->db->get();
        return $query->row_array();
	}


	function insertar_fecha($datos){
		$this->db->insert('cierre_mensual',$datos);


	}

}