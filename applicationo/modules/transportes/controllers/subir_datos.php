<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subir_datos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE) {
			echo "<script>alert('No puede acceder al contenido')</script>";
			redirect('/usuarios/login/index', 'refresh');
		} else {
			$this->load->library('session');
			if ($this->session->userdata('logged') == FALSE)
				redirect('/usuarios/login/index', 'refresh');
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 110)
				$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes','',TRUE);
			else
				redirect('/usuarios/login/index', 'refresh');
			$this->load->model('si_camiones_model');
			$this->load->library('calendar');
			$this->load->model('Si_informes_model');
			$this->load->model('todos_los_trabajadores_model');
			$this->load->model('Si_sube_excel');
			$this->load->model('si_inasistentes_model');
			$this->load->model('tla_informe_asistencia');
		}
	}

	function index(){
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Subir Datos a traves de Excel",
			'js' => array('js/confirm_eliminar.js','js/si_validaciones.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio')),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina = '';
		$base['cuerpo'] = $this->load->view('transportes/subir_datos/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

function inserta_datos($fecha2 = FALSE){
		$this->load->model('si_sube_datos');
			$this->load->library('excel');
			$name   = $_FILES['dato']['name'];
			$tname  = $_FILES['dato']['tmp_name'];        
			$obj_excel = PHPExcel_IOFactory::load($tname);
			$obj_excel ->setActiveSheetIndex(1); // cargara la segunda hoja del excel           
			$numRows = $obj_excel->setActiveSheetIndex(1)->getHighestRow();
			$errores_rechazo_cuenta = 0;
			$errores_rechazo = array();
			for ($i=1; $i <= $numRows; $i++) {
				if ($i != 1) {                         
					$nombre =  $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(); //cambiar  
					$precio =  $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();//cambiar
				}
			}
			if ($errores_rechazo_cuenta == 0) {
				for ($i=1; $i <= $numRows; $i++) {
					if ($i != 1) {                         
					 $nombre =  $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();//cambiar 
				     $precio =  $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();//cambiar
						if($nombre != null ) {
								$datos = array (
		                        'rut' => $nombre,       			 //Cambiar Aqui******* 
		                        'nombre_proveedor' => $precio,    //Cambiar Aqui******* 
							);
								$this->si_sube_datos->inserta_datos($datos);
							}
						}
					}
				}			
			redirect('/transportes/subir_datos/index','refresh');
		
			echo "<script>alert('Se han ingresado los datos Exitosamente!!')</script>";
			redirect('/transportes/subir_datos/index','refresh');
		}
	}
?>