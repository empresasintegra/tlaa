<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tla_auditoria_registros extends CI_Model {

	/*///////////////////////////////////////////*
	/*	Controlador de Cargos - Auditoria de    /*
	/*	Registros    							/*
	/*///////////////////////////////////////////*

	function guarda_auditoria_cargo($auditoria_cargo){
		$this->db->insert('tla_auditoria_registro', $auditoria_cargo);
	}

	function actualizar_auditoria_cargo($auditoria_cargo){
		$this->db->insert('tla_auditoria_registro', $auditoria_cargo);
	}

	function eliminar_auditoria_cargo($auditoria_cargo){
		$this->db->insert('tla_auditoria_registro', $auditoria_cargo);
	}

	/*///////////////////////////////////////////*
	/*	Controlador de Rutas - Auditoria de     /*
	/*	Registros    							/*
	/*///////////////////////////////////////////*

	function guarda_auditoria_ruta($auditoria_ruta){
		$this->db->insert('tla_auditoria_registro', $auditoria_ruta);
	}

	function actualizar_auditoria_ruta($auditoria_ruta){
		$this->db->insert('tla_auditoria_registro', $auditoria_ruta);
	}

	function eliminar_auditoria_ruta($auditoria_ruta){
		$this->db->insert('tla_auditoria_registro', $auditoria_ruta);
	}	

	/*///////////////////////////////////////////*
	/*	Controlador de Camiones - Auditoria de  /*
	/*	Registros    							/*
	/*///////////////////////////////////////////*

	function guarda_auditoria_camion($auditoria_camion){
		$this->db->insert('tla_auditoria_registro', $auditoria_camion);
	}

	function guarda_auditoria_camion_ccu($auditoria_camion){
		$this->db->insert('tla_auditoria_registro', $auditoria_camion);
	}

	function actualizar_auditoria_camion($auditoria_camion){
		$this->db->insert('tla_auditoria_registro', $auditoria_camion);
	}

	function eliminar_auditoria_camion($auditoria_camion){
		$this->db->insert('tla_auditoria_registro', $auditoria_camion);
	}	

	function eliminar_auditoria_camion_ccu($auditoria_camion){
		$this->db->insert('tla_auditoria_registro', $auditoria_camion);
	}

	/*///////////////////////////////////////////*
	/*	Controlador de Codigos - Auditoria de   /*
	/*	Registros    							/*
	/*///////////////////////////////////////////*

	function guarda_auditoria_codigo_ccu($auditoria_codigo_ccu){
		$this->db->insert('tla_auditoria_registro', $auditoria_codigo_ccu);
	}

	
	function eliminar_auditoria_codigo_ccu($auditoria_codigo_ccu){
		$this->db->insert('tla_auditoria_registro', $auditoria_codigo_ccu);
	}	

	/*///////////////////////////////////////////*
	/*	Controlador de Convenios - Colectivo    /*
	/*	- Auditoria de  Registros               /*
	/*	 										/*
	/*///////////////////////////////////////////*

	function guarda_auditoria_convenio($auditoria_convenio){
		$this->db->insert('tla_auditoria_registro', $auditoria_convenio);
	}

	function actualizar_auditoria_convenio($auditoria_convenio){
		$this->db->insert('tla_auditoria_registro', $auditoria_convenio);
	}
	
	function eliminar_auditoria_convenio($auditoria_convenio){
		$this->db->insert('tla_auditoria_registro', $auditoria_convenio);
	}

	/*///////////////////////////////////////////////*
	/*	Controlador de Trabajadores - Auditoria de  /*
	/*	Registros    							    /*
	/*///////////////////////////////////////////////*

	function guarda_auditoria_persona($auditoria_persona){
		$this->db->insert('tla_auditoria_registro', $auditoria_persona);
	}

	function guarda_auditoria_trabajador($auditoria_trabajador){
		$this->db->insert('tla_auditoria_registro', $auditoria_trabajador);
	}

	function actualizar_auditoria_persona($auditoria_persona){
		$this->db->insert('tla_auditoria_registro', $auditoria_persona);
	}

	function actualizar_auditoria_trabajador($auditoria_trabajador){
		$this->db->insert('tla_auditoria_registro', $auditoria_trabajador);
	}

	function actualizar_auditoria_trabajador_al_dia($auditoria_trabajador_al_dia){
		$this->db->insert('tla_auditoria_registro', $auditoria_trabajador_al_dia);
	}

	function eliminar_auditoria_persona($auditoria_persona){
		$this->db->insert('tla_auditoria_registro', $auditoria_persona);
	}	

	function eliminar_auditoria_trabajador_al_dia($auditoria_trabajador){
		$this->db->insert('tla_auditoria_registro', $auditoria_trabajador);
	}

	/*///////////////////////////////////////////////*
	/*	Controlador de Mantenciones - Auditoria de  /*
	/*	Registros    							    /*
	/*///////////////////////////////////////////////*

	function eliminar_auditoria_mantencion($auditoria_mantencion){
		$this->db->insert('tla_auditoria_registro', $auditoria_mantencion);
	}

	function responsable_cambio($modificacion){
		$this->db->insert('modificacion_trabajador', $modificacion);


	}
	

}

/* End of file tla_auditoria_registros.php */
/* Location: ./application/models/tla_auditoria_registros.php */