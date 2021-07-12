<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class colectivo extends CI_Controller {
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
			$this->load->model('si_colectivo_model');
			$this->load->model('tla_auditoria_registros');

		}
	}

	function index(){
		$this->load->model("si_colectivo_model");


		$base = array(
			'head_titulo' => "Sistema Transporte - Instrumento colectivo",
			'titulo' => "Transporte Colectivo",
			'subtitulo' => '',
			'js' => array('js/confirm_eliminar.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);

		$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
		$pagina['usuario_id'] = $this->session->userdata('id');
		$pagina['colectivo'] = $this->si_colectivo_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/colectivo/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_colectivo(){

		$nombre_convenio = trim($_POST['nombre']);
		if (empty($nombre_convenio)) {
			echo "<script>alert('Debe completar los campos!')</script>";
			redirect('transportes/colectivo', 'refresh');
		}
		$data = array(
			'id' => $_POST['id'],
			'id_usuario' => $_POST['usuario_id'],
			'nombre' => $_POST['nombre'],
			'estado' => 1
			);
		$this->si_colectivo_model->ingresar($data);
		$ultimo_id = $this->db->insert_id(); 

		date_default_timezone_set('America/Santiago');

		$auditoria_convenio = array('tabla_id' => "convenio_".$ultimo_id, 
			'usuario_id' => $this->session->userdata('id'),
			'fecha' => date('Y-m-d G:i:s'),
			'accion' => 1,
			'nombre' => "Instrumento Colectivo ".$_POST['nombre']." fue ingresado.",
			);

		$this->tla_auditoria_registros->guarda_auditoria_convenio($auditoria_convenio);
				
		redirect('transportes/colectivo', 'refresh');
	}
	
	function actualizar(){

		$nombre_convenio = trim($_POST['nombre']);
		if (empty($nombre_convenio)) {
			echo "<script>alert('Debe completar los campos!')</script>";
			redirect('transportes/colectivo', 'refresh');
		}
		
		$id = $_POST['id'];
		$data = array(
			'id_usuario' => $_POST['usser_id'],
			'nombre' => $_POST['nombre'],
			'estado' => 2
			);
		$this->si_colectivo_model->actualizar_colectivo($id,$data);

		date_default_timezone_set('America/Santiago');

        $nombre=$this->si_colectivo_model->id($id);
		$auditoria_convenio = array('tabla_id' => "convenio_".$id, 
			'usuario_id' => $this->session->userdata('id'),
			'fecha' => date('Y-m-d G:i:s'),
			'accion' => 2,
			'nombre' => "I.Colectivo ".$nombre." fue actualizado a ".$_POST['nombre'].".",
			);

		$this->tla_auditoria_registros->actualizar_auditoria_convenio($auditoria_convenio);
		redirect('transportes/colectivo', 'refresh');		
	}

	function modal_editar($id= false, $usuario_id = false){
		$this->load->model("si_colectivo_model");
		$pagina['usser_id'] = $usuario_id;
		$pagina['datos_colectivo']= $this->si_colectivo_model->get_colectivo($id);
		$this->load->view('transportes/colectivo/modal_editar_colectivo', $pagina);
	}
	
	function verificar(){		

		//$this->load->model("si_colectivo_model");
		if (isset($_POST['eliminar'])){


			foreach($_POST['seleccionar_eliminar'] as $id){
				
				$this->si_colectivo_model->eliminar($id);

				date_default_timezone_set('America/Santiago');

				$nombre=$this->si_colectivo_model->id($id);
				$auditoria_convenio = array('tabla_id' => "convenio_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3,
					'nombre'=> "Instrumento Colectivo ".$nombre." fue eliminado.",
					);

				$this->tla_auditoria_registros->eliminar_auditoria_convenio($auditoria_convenio);
			}
		}
		echo "<script>alert('Registro Eliminado')</script>";
		redirect('transportes/colectivo', 'refresh');
	}
	
}
?>