<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class rutas extends CI_Controller {
	//public $requerimiento;
	
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
			$this->load->model('si_rutas_model');
			$this->load->model('tla_auditoria_registros');
		}
	}

	function index(){
		$this->load->model("si_rutas_model");


		$base = array(
			'head_titulo' => "Sistema Transporte - Rutas",
			'titulo' => "Transporte Rutas",
			'subtitulo' => '',
			'js' => array('js/sweetalert-dev.js','js/confirm_eliminar.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
		$pagina['ruta'] = $this->si_rutas_model->listar();
		$pagina['rutalista']= $this->si_rutas_model->listarruta();
		$base['cuerpo'] = $this->load->view('transportes/rutas/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_ruta(){

		$nombre_add_ruta = trim($_POST['nombre_rutas']);
		if (empty($nombre_add_ruta)) {
			echo "<script>alert('Debe completar los campos!!')</script>";
			redirect('transportes/rutas', 'refresh');
		}else{

			$si_existe_ruta = $this->si_rutas_model->consultar_registro($_POST['nombre_rutas']);

			if ($si_existe_ruta == 1){
				echo "<script>alert('El registro ingresado ya existe')</script>";
			}elseif ($si_existe_ruta == 0) {
				$data = array(
					'id' => $_POST['id'],
					'nombre_rutas' => $_POST['nombre_rutas'],
					'id_usuario' => $this->session->userdata('id'),
					'estado' => 1,
					
					);
				$this->si_rutas_model->ingresar($data);
				$ultimo_id = $this->db->insert_id();

				date_default_timezone_set('America/Santiago');

				$auditoria_ruta = array('tabla_id' => "ruta_".$ultimo_id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 1,
					'nombre'=>"Ruta ".$_POST['nombre_rutas']." fue ingresada.",
 					);

				$this->tla_auditoria_registros->guarda_auditoria_ruta($auditoria_ruta);
			}
	
			redirect('transportes/rutas', 'refresh');
			
		}
		
	}
	
	function actualizar(){
		
		$nombre_rutas = trim($_POST['nombre_rutas']);
		if (empty($nombre_rutas)) {
			echo "<script>alert('Debe completar los campos!!')</script>";
			redirect('transportes/rutas', 'refresh');
		}else{
			$id = $_POST['id'];
			$data = array(
				'nombre_rutas' => $_POST['nombre_rutas'],
				'id_usuario' => $this->session->userdata('id'),
				'estado' => 2
				);
			

			$nombre=$this->si_rutas_model->id($id);


			date_default_timezone_set('America/Santiago');

			$auditoria_ruta = array('tabla_id' => "ruta_".$id, 
				'usuario_id' => $this->session->userdata('id'),
				'fecha' => date('Y-m-d G:i:s'),
				'accion' => 2,
				'nombre'=>"Ruta ".$nombre." fue actualizada a ".$_POST['nombre_rutas'].".",
				);

			$this->tla_auditoria_registros->actualizar_auditoria_ruta($auditoria_ruta);
            $this->si_rutas_model->actualizar_rutas($id,$data);

			redirect('transportes/rutas', 'refresh');
		}

					
	}

	function modal_editar($id){
		$this->load->model("si_rutas_model");
		$pagina['datos_ruta']= $this->si_rutas_model->get_rutas($id);
		$this->load->view('transportes/rutas/modal_editar_rutas', $pagina);
	}
	
	
function verificar(){
		$this->load->model("si_rutas_model");
		if (isset($_POST['eliminar'])){
			foreach($_POST['seleccionar_eliminar'] as $id){
				$this->si_rutas_model->eliminar($id);
                
				$nombre=$this->si_rutas_model->id($id);
				date_default_timezone_set('America/Santiago');

				$auditoria_ruta = array('tabla_id' => "ruta_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3,
					'nombre'=>"Ruta ".$nombre." fue eliminada.",
					);

				$this->tla_auditoria_registros->eliminar_auditoria_ruta($auditoria_ruta);
			}
		}
		echo "<script>alert('Registro Eliminado')</script>";
		redirect('transportes/rutas', 'refresh');
	}
	
	
}
?>