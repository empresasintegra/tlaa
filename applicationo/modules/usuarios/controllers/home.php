<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Home extends CI_Controller {
	public $requerimiento;
	public function __construct()
   	{
    	parent::__construct();
    	$this->load->library('session');
    	if ($this->session->userdata('logged') == FALSE)
    		redirect('/usuarios/login/index', 'refresh');
    	elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 107)
    		$this->menu = $this->load->view('layout2.0/menus/menu_mecanico','',TRUE);
    	elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 108)
    		$this->menu = $this->load->view('layout2.0/menus/menu_asistente_contable_transporte','',TRUE);
    	elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 109)
    		$this->menu = $this->load->view('layout2.0/menus/menu_supervisor_transporte','',TRUE);
    	elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 110)
    		$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes','',TRUE);
    	elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 111)
    		$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes_administracion','',TRUE);
    	elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 112)
    		$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes_rrhh','',TRUE);
    	else
    		redirect('/usuarios/login/index', 'refresh');
    	$this->load->model('Si_produccion_model');
    	$this->load->model('tla_informe_produccion');
    	$this->load->model("tla_registro_sesion");
   	}


   	
	function index(){
		$this->load->model("Usuarios_model");
		//$this->load->library("session");
		$base = array(
			'head_titulo' => "Sistema de Transportes Integra",
			'titulo' => "Empresa: Transportes Integra",
				'subtitulo' => "Transportes L.A",
			'side_bar' => true,
			'js' => array('plugins/bootstrap-progressbar/bootstrap-progressbar.min.js','plugins/nvd3/lib/d3.v3.js','plugins/nvd3/nv.d3.min.js','plugins/nvd3/src/models/historicalBar.js','plugins/nvd3/src/models/historicalBarChart.js','plugins/nvd3/src/models/stackedArea.js','plugins/nvd3/src/models/stackedAreaChart.js','plugins/jquery.sparkline/jquery.sparkline.js','plugins/easy-pie-chart/dist/jquery.easypiechart.min.js', 'js/index.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);
		$pagina = "";

		$base['cuerpo'] = $this->load->view('home/home',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	function cambiar_contrasena($id){
		$pagina['contrasena']= $this->tla_registro_sesion->contrasena_usuario($id);
		$this->load->view('usuarios/home/cambiar_contrasena',$pagina);
	}

	function actualizar_contrasena(){
		$id=$_POST['id'];
		$clave = $_POST['contrasena_antigua'];
		$data = array(	
				'clave'=>$_POST['contrasena_nueva'],
				);
		$this->tla_registro_sesion->actualizar_contrasena($id, $clave, $data);
		echo "<script>alert('Contraseña Modificada Exitosamente')</script>";
		redirect('usuarios/home', 'refresh');
	}

	/*function rechazos_mayo_2017(){
		$this->load->model('Tla_registro_sesion');
		$fecha_inicio = "2017-05-01";
		$fecha_termino = "2017-05-31";

		$rechazos_mayo = $this->Tla_registro_sesion->consultar_rechazos_mayo();
		foreach ($rechazos_mayo as $key){
			$consulta1 = $this->Tla_registro_sesion->consultar_id_sccu($key->camion);

			$id_camion_en_reg_produccion = isset($consulta1->idcodigos_ccu)?$consulta1->idcodigos_ccu:'0';
			$consulta_registro_ccu = $this->Tla_registro_sesion->consultar_registro_produccion($id_camion_en_reg_produccion, $key->fecha_registro);
			$id_registro_produccion = isset($consulta_registro_ccu->id)?$consulta_registro_ccu->id:"0";

			$get_registro_produccion = $this->Tla_registro_sesion->get_registro_produccion($id_registro_produccion);

			$cajas_reales = isset($get_registro_produccion->caja_reales)?$get_registro_produccion->caja_reales:"ND";
			$clientes_reales = isset($get_registro_produccion->cliente_reales)?$get_registro_produccion->cliente_reales:"ND";

			$cajas_a_actualizar = $cajas_reales - $key->cajas;
			$clientes_a_actualizar = $clientes_reales - $key->clientes;

			$key->id_registro_produccion = isset($consulta_registro_ccu->id)?$consulta_registro_ccu->id:"NE";
			$key->id = $key->id;
			$key->s_camion = $key->camion;
			$key->id_camion = $id_camion_en_reg_produccion;
			$key->cajas = $key->cajas;
			$key->clientes = $key->clientes;
			$key->fecha_registro = $key->fecha_registro;
			$key->cajas_reales = $cajas_reales;
			$key->clientes_reales = $clientes_reales;
			$key->cajas_a_actualizar = $cajas_a_actualizar;
			$key->clientes_a_actualizar = $clientes_a_actualizar;

			$datos_ingreso_rechazos = array(
				'caja_preventa' => $key->cajas,
				'cliente_preventa' => $key->clientes,
				'caja_reales' => $cajas_a_actualizar,
				'cliente_reales' => $clientes_a_actualizar,
			);

			$this->Tla_registro_sesion->ingresar_rechazos($id_registro_produccion, $datos_ingreso_rechazos);

		}

		var_dump($rechazos_mayo);

	}
*/
	

}
?>