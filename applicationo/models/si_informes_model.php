<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_informes_model extends CI_Model {

	function consulta_preventa($rm){
		$this->db->select('fecha_preventa');
		$this->db->from('preventas');
		$this->db->where('fecha_preventa', $rm);
		$query = $this->db->get();

		

		return $query->row(); 
		

	}

	function consulta_rechazo($rm){
		$this->db->select('fecha_subida');
		$this->db->from('rechazos');
		$this->db->where('fecha_subida', $rm);
		$query = $this->db->get();

		

		return $query->row(); 
		

	}
	


}

/* End of file Si_informes_model.php */
/* Location: ./application/models/Si_informes_model.php */