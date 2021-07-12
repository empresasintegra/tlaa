<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cierres extends CI_Controller {

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
			'titulo' => "Cierres Diarios",
			'subtitulo' => '',
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			);

		$pagina = "";
		$base['cuerpo'] = $this->load->view('transportes/cierres/gestion',$pagina,TRUE);
    	$this->load->view('layout2.0/layout',$base);

	}

	function continuar($fecha_1 = FALSE, $fecha_2 = FALSE){
		$fecha_inicio = $_POST['datepicker'];
		$fecha_termino = $_POST['datepicker2'];

		redirect('transportes/cierres/abrir_dias/'.$fecha_inicio.'/'.$fecha_termino.'', 'refresh');

	}

	function abrir_dias($fecha_1 = FALSE, $fecha_2 = FALSE){
		$fecha_inicio = $fecha_1;
		$fecha_termino = $fecha_2;
 
		$fechaInicio= strtotime($fecha_inicio);
		$fechaFin= strtotime($fecha_termino);

		$f_inicio = $fecha_inicio;
		$f_termino = $fecha_termino;

		if ($fechaInicio > $fechaFin){
			echo "<script>alert('Debe ingresar una fecha mayor a la fecha de inicio')</script>";
			redirect('transportes/resumen/resumen_produccion','refresh');
		}

		$fechas_resumen = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$fechas_resumen[] = date('Y-m-d', $i);      
		}


		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Cierres Diarios",
			'subtitulo' => '',
			'js' => array('js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			);

	
		$lista_aux = array();
		if (!empty($fechas_resumen)){
			foreach ($fechas_resumen as $rm) {
				$aux = new stdClass();
				$get_fecha_cierre = $this->tla_cierre_diario->consulta_cierre_diario($rm);
				//var_dump($get_fecha_cierre);
				$aux->fechas = $rm;
				switch (isset($get_fecha_cierre->estado_cierre)?$get_fecha_cierre->estado_cierre: 0) {
					case '1':
					  $cierre = "<span class='label label-danger'>Cerrado</span> ";
					  $check_dato = "<input type='checkbox' name='fechas[]'' value='$rm''>";
					break;

					case '2':
					  $cierre = "<span class='label label-success'>Abierto</span> ";
					  $check_dato = "<input type='checkbox' name='fechas[]'' value='$rm''>";
					break;

					case '0':
					  $cierre = "<span class='label label-warning'>Sin Información</span>";
					  $check_dato = "N/A";	
					break;

					default:
						# code...
					break;
				}
			
				$aux->cierres = $cierre;
				$aux->check = $check_dato;
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$pagina['lista_aux'] = $lista_aux;
		$pagina['fecha_1'] = $fecha_inicio;
		$pagina['fecha_2'] = $fecha_termino;
		$base['cuerpo'] = $this->load->view('transportes/cierres/abrir_dias',$pagina,TRUE);
    	$this->load->view('layout2.0/layout',$base);
	}

	function abrir_fecha_seleccionada($fecha_inicio = FALSE, $fecha_termino = FALSE){

		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_termino = $_POST['fecha_fin'];

		if ($_POST['guardar'] == 'abrir') {
			if (!empty($_POST['fechas'])){
				foreach($_POST['fechas'] as $row=>$valores){
					$this->tla_cierre_diario->abrir_dias_seleccionados($valores);
				}
			}
		} else if ($_POST['guardar'] == 'cerrar') {
			if (!empty($_POST['fechas'])){
				foreach($_POST['fechas'] as $row=>$valores){
					$this->tla_cierre_diario->cerrar_dias_seleccionados($valores);
				}
			}
		} 

		
		//$this->tla_cierre_diario->abrir_dias_seleccionados($fecha_inicio, $fecha_termino);

		//redirect('transportes/cierres/resumen/', 'refresh');*/

		

		redirect('transportes/cierres/abrir_dias/'.$fecha_inicio.'/'.$fecha_termino.'', 'refresh');
	}
}

/* End of file cierres.php */
/* Location: ./application/modules/transportes/controllers/cierres.php */