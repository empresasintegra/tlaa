<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Decidir extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE) {
			echo "<script>alert('No puede acceder al contenido')</script>";
			redirect('/usuarios/login/index', 'refresh');
		} else {
			$this->load->library('session');
			if ($this->session->userdata('logged') == FALSE)
				redirect('/usuarios/login/index', 'refresh');
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 108)
				$this->menu = $this->load->view('layout2.0/menus/menu_asistente_contable_transporte','',TRUE);
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 109)
				$this->menu = $this->load->view('layout2.0/menus/menu_supervisor_transporte','',TRUE);
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 110)
				$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes','',TRUE);
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 111)
				$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes_administracion','',TRUE);
			else
				redirect('/usuarios/login/index', 'refresh');
			$this->load->model('tla_calcula_bono_produccion');
			$this->load->model('si_estandar_bono_chofer');
			$this->load->model('si_estandar_bono_peoneta');
			$this->load->model('Si_produccion_model');
			$this->load->model('tla_tabla_resumen');
			$this->load->model('personal_model');		
		}
	}

	public function generar_informe($fecha_1 = FALSE, $fecha_2 = FALSE, $dias_laborales = FALSE){
		$base = array(
			'head_titulo' => "Sistema Transporte - Producción",
			'titulo' => "Informe de Producción",
			'subtitulo' => '',
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/bonos_trabajador/calcular', 'txt' => 'Calculo de Bonos Trabajadores '), array('url' => '', 'txt' => 'Informe De Produccion ') ), 
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);

		$pagina = "";
		$pagina['fecha_1'] = $fecha_1;
		$pagina['fecha_2'] = $fecha_2;
		$pagina['dias_laborales'] = $dias_laborales;
		$pagina['listado_seleccion'] = $this->personal_model->listar_activos($fecha_1, $fecha_2);
		$pagina['listado_seleccion_2'] = $this->personal_model->listar_activos($fecha_1, $fecha_2);
		$base['cuerpo'] = $this->load->view('transportes/decidir/generar_informe', $pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	public function generar_informe2($fecha_1 = FALSE, $fecha_2 = FALSE, $dias_laborales = FALSE){
		$base = array(
			'head_titulo' => "Sistema Transporte - Producción",
			'titulo' => "Informe de Producción",
			'subtitulo' => '',
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/bonos_trabajador/calcular', 'txt' => 'Calculo de Bonos Trabajadores '), array('url' => '', 'txt' => 'Informe De Produccion ') ), 
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);

		$pagina = "";
		$pagina['fecha_1'] = $fecha_1;
		$pagina['fecha_2'] = $fecha_2;
		$pagina['dias_laborales'] = $dias_laborales;
		$pagina['listado_seleccion'] = $this->personal_model->listar_activos2($fecha_1, $fecha_2);
		$pagina['listado_seleccion_2'] = $this->personal_model->listar_activos($fecha_1, $fecha_2);
		$base['cuerpo'] = $this->load->view('transportes/decidir/generar_informe', $pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

}

/* End of file decidir.php */
/* Location: ./application/modules/transportes/controllers/decidir.php */