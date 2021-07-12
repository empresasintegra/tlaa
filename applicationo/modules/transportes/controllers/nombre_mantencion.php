<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Nombre_Mantencion extends CI_Controller {
	//public $requerimiento;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model("nombre_mantencion_model");
		if ($this->session->userdata('logged') == FALSE) {
			echo "<script>alert('No puede acceder al contenido')</script>";
			redirect('/usuarios/login/index', 'refresh');
		} else {
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
			else
				redirect('/usuarios/login/index', 'refresh');
		}
	}

	function index($id_mantencion = FALSE){
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Nombre Mantencion",
			'js' => array('js/confirm_eliminar.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/tabla_detalle.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			//'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Nombe Mantencion ')), 
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['id_mantencion'] = $id_mantencion;
		$pagina['nombre'] = $this->nombre_mantencion_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/mantencion/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_nombre(){
		$id_mantencion= $_POST['id_mantencion'];
		$data = array(
			'nombre_mantencion' => $_POST['nombre_mantencion'],
			);
		$this->nombre_mantencion_model->ingresar($data);
		echo "<script>alert('Se han actualizado los registros')</script>";
		redirect('transportes/nombre_mantencion/index/'.$id_mantencion, 'refresh');
	}

	function modal_editar($id){
		$pagina['nombre']= $this->nombre_mantencion_model->get_nombre($id);
		$this->load->view('transportes/mantencion/modal_editar_mantencion', $pagina);
	}
	function actualizar(){			
		$id = $_POST['id'];
		$data = array(
			'nombre_mantencion' => $_POST['nombre'],
			);
		$this->nombre_mantencion_model->actualizar_nombre($id,$data);	
		echo "<script>alert('Se han actualizado los registros')</script>";
		redirect('transportes/nombre_mantencion', 'refresh');
	}		

	function eliminar($id){
		$this->nombre_mantencion_model->eliminar($id);
        redirect( base_url().'transportes/nombre_mantencion', 'refresh');
	}

	function verificar(){
		if (isset($_POST['eliminar'])){
			foreach($_POST['seleccionar_eliminar'] as $id){	  		
				$this->herramientas_model->eliminar($id);
			}
		}
		echo "<script>alert('Registro Eliminado')</script>";
		redirect('transportes/nombre_mantencion', 'refresh');
	}
}
?>