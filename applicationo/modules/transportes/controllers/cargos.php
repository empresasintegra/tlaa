<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class cargos extends CI_Controller {
	//public $requerimiento;
	
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
			$this->load->model('cargos_model');
			$this->load->model('tla_auditoria_registros');

		}

	}

	function index(){
		
		$this->load->model("cargos_model");
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Transporte Cargo",
			'js' => array('js/confirm_eliminar.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
		$pagina['usuario_id'] = $this->session->userdata('id');
		$pagina['cargo'] = $this->cargos_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/cargo/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
		
	}
	
	function guardar_cargo(){

		$nombre_add_cargo = trim($_POST['nombre']);
		if (empty($nombre_add_cargo)) {
			echo "<script>alert('Debe completar los campos')</script>";
			redirect('transportes/cargos', 'refresh');
		}else{
			$si_existe = $this->cargos_model->consultar_registro($_POST['nombre']);

			if ($si_existe == 1){
				echo "<script>alert('El registro ingresado ya existe')</script>";
			}elseif($si_existe == 0){
				$data = array(
					'id_usuario' => $_POST['usuario_id'],
					'nombre' => $_POST['nombre'],
					'estado' => 1,
					);
				$this->cargos_model->ingresar($data);
				$ultimo_id = $this->db->insert_id();

				date_default_timezone_set('America/Santiago');

				$auditoria_cargo = array('tabla_id' => "cargo_".$ultimo_id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 1,
 					);

				$this->tla_auditoria_registros->guarda_auditoria_cargo($auditoria_cargo);



			}
			echo "<script>alert('Se han actualizado los registros')</script>";
			redirect('transportes/cargos', 'refresh');
		}

	}

	function modal_editar($id){
		$pagina['datos_cargo']= $this->cargos_model->get_cargo($id);
		$this->load->view('transportes/cargo/modal_editar_cargo', $pagina);
	}


	function actualizar(){			
		$nombre_cargo = trim($_POST['nombre']);
		if (empty($nombre_cargo)) {
			echo "<script>alert('Debe completar los campos')</script>";
			redirect('transportes/cargos', 'refresh');
		}else{
			$id = $_POST['id'];
			$data = array(
				'nombre' => $_POST['nombre'],
				'id_usuario' => $this->session->userdata('id'),
				'estado' =>2
				);
			$this->cargos_model->actualizar_cargos($id,$data);

			date_default_timezone_set('America/Santiago');
			$auditoria_cargo = array('tabla_id' => "cargo_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 2,
 			);

			$this->tla_auditoria_registros->actualizar_auditoria_cargo($auditoria_cargo);

			echo "<script>alert('Se han actualizado los registros')</script>";
			redirect('transportes/cargos', 'refresh');
		}
	}		


	function verificar(){

		$this->load->model("cargos_model");
		if (isset($_POST['eliminar'])){
			
			foreach($_POST['seleccionar_eliminar'] as $id){	  		
				$this->cargos_model->eliminar($id);

				date_default_timezone_set('America/Santiago');

				$auditoria_cargo = array('tabla_id' => "cargo_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3,
					);

				$this->tla_auditoria_registros->eliminar_auditoria_cargo($auditoria_cargo);


			}
		}
		echo "<script>alert('Registro Eliminado')</script>";
		redirect('transportes/cargos', 'refresh');
	}
}
?>