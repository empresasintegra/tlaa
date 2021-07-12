<?php
class Mantenciones_model extends CI_Model {
	function listar(){  //funcion para listar todo el contenido de la tabla mantenciones en la vista principal "gestion.php"
		 $this->db->SELECT('*');
		$this->db->SELECT('mantenciones.id_cod_ccu as id_cod_ccu_mantenciones');
		$this->db->From('mantenciones');
		$query = $this->db->get();
		return $query->result();
	}

	function ingresar($data){//funcion para ingresar nuevos datos a la tabla mantenciones
		$this->db->insert('mantenciones',$data);
		return $this->db->insert_id();		
	}

	function ingresar_costo($id_mantencion, $data){
		$this->db->where('mantenciones.id',$id_mantencion);
		$this->db->update('mantenciones', $data);
	
	}

	function ingresar_subdetalles($data){ // funcion para ingresar nuevos detalles a la tabla mantenciones_subdetalles
		$this->db->insert('mantenciones_subdetalles',$data);
		return $this->db->insert_id();
	}
	function ingresar_nombre_submantencion($data){
		$this->db->insert('mantenciones_detalles',$data);
		return $this->db->insert_id();
	}

	function consultar_registro($nombre){
		$this->db->select('*');
		$this->db->from('mantenciones');
		$this->db->where('id_cod_ccu', $nombre);
		/*$this->db->where('estado !=', 3);*/
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	function consultar_proveedores(){  // consultar por los proveedores
		$this->db->SELECT('*');
		$this->db->FROM('mantenciones_proveedores');
		$this->db->order_by("id","desc");
		$query = $this->db->get();
		return $query->result();
	}

	function consultar_detalles(){   
		$this->db->SELECT('*');
		$this->db->FROM('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones.id = mantenciones_detalles.id_mantenciones','inner');
		$query = $this->db->get();
		return $query->result();
	}

	function consultar_nombre_submantencion($idsub){
		$this->db->SELECT('*');
		$this->db->FROM('mantenciones_detalles');
		$this->db->where('id_detalle',$idsub);
		$query = $this->db->get();
		return $query->result();
	}

	function listar_todos_repuestos(){// consultar por los repuestos
		 $this->db->SELECT('*');
		$this->db->From('repuestos');
		$this->db->order_by("id","desc");
		$query = $this->db->get();
		return $query->result();
	}
	function listar_nombre_submantencion(){
		$this->db->select('*');
		$this->db->from('mantenciones_detalles');
		$query = $this->db->get();
		return $query->result();
	}
	
	function consultar_repuesto($id_repuesto){// consultar por los repuestos
		$this->db->select('*');
		$this->db->From('repuestos');
		$this->db->where('id',$id_repuesto);
		$query = $this->db->get();
		return $query->row();
	}
	

	function get_proveedor($id_proveedor){
		$this->db->SELECT('*');
		$this->db->FROM('mantenciones_proveedores');
		$this->db->where('id',$id_proveedor);
		$query = $this->db->get();
		return $query->row();
	}

	function get_repuestos($id_submantencion){// consultar por los repuestos
		$this->db->select('*');
		$this->db->From('mantenciones_subdetalles');
		 $this->db->where('id_mantencion_detalles',$id_submantencion);
		$query = $this->db->get();
		return $query->result();
	}

	function consultar_chofer(){//Para asi obtener de la base de datos los choferes  puesto que el id de chofer es 72***
		$this->db->SELECT('*');
		$this->db->FROM('trabajador');
		$this->db->join('persona','trabajador.id_persona = persona.id','inner');
		$this->db->where('trabajador.id_cargo', 72);
		$this->db->order_by("apellido_paterno","asc");
		$query = $this->db->get();
		return $query->result();
	}

		function consultar_camiones(){//consulta a la tabla camiones
		$this->db->SELECT('*');
		$this->db->FROM('camiones');
		$this->db->order_by("patente","asc");
		$query = $this->db->get();
		return $query->result();
	}
		function consultar_codigosccu(){
		$this->db->SELECT('*');
		$this->db->FROM('codigos_ccu');
		$this->db->order_by("codigos_ccu","asc");
		$query = $this->db->get();
		return $query->result();
	}

	function actualizar_mantenciones($id,$data){
		$this->db->where('id',$id);
		$this->db->update('mantenciones',$data); 
		return $this->db->insert_id();
	}

	function actualizar_repuestos_submantencion($id,$data){ // funcion para actualizar los datos dentro del submantenimiento
		$this->db->where('mantenciones_subdetalles.id',$id);
		$this->db->update('mantenciones_subdetalles',$data);
		return $this->db->insert_id();
	}

	function actualizar_nombre_submantencion($id,$data){
		$this->db->where('id_detalle',$id);
		$this->db->update('mantenciones_detalles',$data);
	}

	function get_mantencion($id){
		$this->db->select("*");
		$this->db->from("mantenciones");
		$this->db->where("id",$id);
		$query = $this->db->get();
		return $query->result();
	}

	function obtenernombre(){
		$this->db->SELECT('nombre');
		$this->db->FROM('trabajador');
		$this->db->join('persona','trabajador.id_persona = persona.id','inner');
		$this->db->where('trabajador.id_cargo', 72);
		$query = $this->db->get();
		return $query->result();
	}

	function datos_tablas(){ //esta funcion me dara los nombres  para mostrar en la vista gestion* en base a los id
		$this->db->SELECT('*');
		$this->db->SELECT('persona.id as id_persona');
		$this->db->SELECT('mantenciones.estado as estado_mantencion');
		$this->db->SELECT('mantenciones.id as id_mantencion');
		$this->db->FROM('mantenciones');
		$this->db->join('codigos_ccu','mantenciones.id_cod_ccu = codigos_ccu.idcodigos_ccu','inner');
		$this->db->join('persona','mantenciones.id_chofer = persona.id','inner');
		$this->db->join('camiones','mantenciones.id_camion = camiones.id','inner');
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->order_by('mantenciones.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	function eliminar_repuestos_submantencion($id){
				$this->db->delete('mantenciones_subdetalles', array('id'=> $id));
	}

	function obtener_mantenciones_subdetalles($id_mantencion){
		$this->db->SELECT('*');
		$this->db->FROM('mantenciones_detalles');
		$this->db->where('id_mantenciones', $id_mantencion);
		$this->db->where('eliminado', 0);
		$this->db->order_by('id_detalle','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function nombre_submantencion($idsub){ 
		$this->db->select('*');
		$this->db->from('mantenciones_detalles');
		$this->db->where('id_detalle',$idsub);
		$query = $this->db->get();
		return $query->result();
	}

	function mantenciones_subdetalles($id){
		$this->db->SELECT('*');
		$this->db->FROM('mantenciones_subdetalles');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function suma_total(){
		$this->db->select('*');
		$this->db->FROM('mantenciones_detalles');
		$this->db->join('mantenciones_subdetalles','mantenciones_detalles.id_detalle = mantenciones_subdetalles.id_mantencion_detalles','inner');
		//$this->db->where('mantenciones_detalles.id_mantenciones',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function costo_mantencion(){
		$this->db->select('*');
		$this->db->FROM('mantenciones_detalles');
		$this->db->join('mantenciones_subdetalles','mantenciones_detalles.id_detalle = mantenciones_subdetalles.id_mantencion_detalles','inner');
		$this->db->where('eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$query = $this->db->get();
		return $query->result();
	}

	function costo_mantencion_detalle($id){
		$this->db->select('*');
		$this->db->FROM('mantenciones_detalles');
		$this->db->join('mantenciones_subdetalles','mantenciones_detalles.id_detalle = mantenciones_subdetalles.id_mantencion_detalles','inner');
		$this->db->where('mantenciones_detalles.id_mantenciones',$id);
		$this->db->where('eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$query = $this->db->get();
		return $query->result();
	}

	function exportacion(){
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#informe diario
	function filtro_mantencion($fecha_hoy){		
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha',$fecha_hoy);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 1
	function filtro_por_repuesto($repuesto){ #case 1
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 2
	function filtro_por_camion($camion){	
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 3
	function filtro_por_proveedor($proveedores){  
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones_proveedores.id',$proveedores);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 4
		function filtro_por_fecha($fecha_inicio, $fecha_termino){ 
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 5
	function filtro_por_camion_repuesto($camion, $repuesto){ 
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 6
	function filtro_por_fecha_repuesto($fecha_inicio, $fecha_termino, $repuesto){ 
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
#case 7
	function filtro_por_fecha_camion($fecha_inicio, $fecha_termino, $camion){ 
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
#case 8
	function filtro_por_camion_proveedor($camion, $proveedor){   
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
	
#case 9
	function filtro_por_fecha_camion_proveedor($camion, $proveedor,$fecha_inicio,$fecha_termino){   
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
#case 10	
	function filtro_por_fecha_proveedor($fecha_inicio,$fecha_termino, $proveedor){   
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
#case 11
	function filtro_por_fecha_camion_repuesto($fecha_inicio, $fecha_termino, $camion, $repuesto){   
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
#case 12
	function filtro_por_fecha_repuesto_proveedor($fecha_inicio, $fecha_termino, $repuesto, $proveedor){
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
	
#case 13
	function filtro_por_fecha_camion_repuesto_proveedor($fecha_inicio, $fecha_termino, $camion, $repuesto, $proveedor){
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}
	
#case 14
	function filtro_por_camion_repuesto_proveedor($camion, $repuesto, $proveedor){
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}

#case 15
	function filtro_por_repuesto_proveedor($repuesto, $proveedor){
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');

		$this->db->where('repuestos.id',$repuesto);
		$this->db->where('mantenciones_proveedores.id',$proveedor);
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}



/*
	function filtro_all($camion = FALSE, $proveedor = FALSE,$repuesto = FALSE, $fecha_inicio = FALSE, $fecha_termino = FALSE){
		$this->db->select('*');
		$this->db->From('mantenciones');
		$this->db->join('mantenciones_detalles','mantenciones_detalles.id_mantenciones = mantenciones.id','inner');
		$this->db->join('mantenciones_subdetalles','mantenciones_subdetalles.id_mantencion_detalles = mantenciones_detalles.id_detalle','inner');
		$this->db->join('codigos_ccu','codigos_ccu.idcodigos_ccu = mantenciones.id_cod_ccu','inner');
		$this->db->join('repuestos','repuestos.id = mantenciones_subdetalles.id_repuesto');
		$this->db->join('camiones','camiones.id = mantenciones.id_camion');
		$this->db->join('persona', 'persona.id = mantenciones.id_chofer');
		$this->db->join('mantenciones_proveedores','mantenciones_subdetalles.id_proveedor = mantenciones_proveedores.id');
		if (strlen($fecha_inicio)!=0 ) {
			$this->db->where('mantenciones.fecha between "'.$fecha_inicio.'"and"'.$fecha_termino.'"');	
			}
		if (strlen($camion)!=0 ) {	
			$this->db->where('codigos_ccu.idcodigos_ccu',$camion);
		}
		if (strlen($proveedor)!=0 ) {	
			$this->db->where('mantenciones_proveedores.id',$proveedor);
		}
		if (strlen($repuesto)!=0 ) {
			$this->db->where('repuestos.id',$repuesto);
		}
		$this->db->where('mantenciones.eliminado', 0);
		$this->db->where('mantenciones_detalles.eliminado', 0); // 0.-no eliminado / 1.-eliminado
		$this->db->order_by("mantenciones.id","asc");
		$this->db->order_by("nombre_submantencion","asc");
		$query = $this->db->get();
		return $query->result();
	}*/

}