<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Cron extends CI_Controller {
		function index(){}
	
		function cierre_diario(){
			/*$this->load->model('Si_produccion_model');	
			$fecha = date('Y-m-j');
			$nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

			$todos_los_registros_dia = $this->Si_produccion_model->listar_registros_dia($nuevafecha);

			if ($todos_los_registros_dia == 1) {
				$this->Si_produccion_model->actualiza_cierre($nuevafecha);
			}elseif ($todos_los_registros_dia == 0) {
				echo "no existen registros";
			}*/
		}
}
?>