<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cierres_mensual extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE) {
			echo "<script>alert('No puede acceder al contenido')</script>";
			redirect('/usuarios/login/index', 'refresh');
		} else {
			//cargar modelos
			$this->load->model('tla_cierre_diario');
		}
	}



	public function resumen(){
		

		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Cierres Mensuales",
			'subtitulo' => '',
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			);

		$pagina = "";
		$base['cuerpo'] = $this->load->view('transportes/cierres/cierre_mensual',$pagina,TRUE);
    	$this->load->view('layout2.0/layout',$base);

	}
}