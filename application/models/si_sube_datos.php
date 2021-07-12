<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_sube_datos extends CI_Model {

	function inserta_datos($datos){ 
            //cambiar el nombre del campo que esta luego del insert por el campo de tu tabla
		$this->db->insert('mantenciones_proveedores', $datos);
	}

}

/* End of file si_sube_datos.php */
/* Location: ./application/models/si_sube_datos.php */
?>