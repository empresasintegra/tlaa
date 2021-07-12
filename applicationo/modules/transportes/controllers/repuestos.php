<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Repuestos extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model("repuestos_model");

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

	function index(){
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Repuestos",
			'js' => array('js/confirm_eliminar.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Repuestos ')), 
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['repuestos'] = $this->repuestos_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/repuestos/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
		

	}
	
	function guardar_repuestos(){
		$nombre_add_cargo = trim($_POST['nombre']);
		if (empty($nombre_add_cargo)) {
			echo "<script>alert('Debe completar los campos')</script>";
			redirect('transportes/cargos', 'refresh');
		}else{
			$si_existe = $this->repuestos_model->consultar_registro($_POST['nombre']);

			if ($si_existe == 1){
				echo "<script>alert('El repuesto ingresado ya existe')</script>";
			}elseif($si_existe == 0){
				$data = array(
					/*'id' => $_POST[4],*/
					'nombre_repuesto' => $_POST['nombre'],
					'precio'=> $_POST['precio_repuesto'],
					);
				$this->repuestos_model->ingresar($data);
				echo "<script>alert('Se han actualizado los registros')</script>";
			}
			
			redirect('transportes/repuestos', 'refresh');
		}
	}

	function modal_editar($id){
		$pagina['datos_repuestos']= $this->repuestos_model->get_cargo($id);
		$this->load->view('transportes/repuestos/modal_editar_repuestos', $pagina);
	}
	function exportar(){
		$pagina['repuestos'] = $this->repuestos_model->listar();
		$this->load->view('transportes/repuestos/exportar',$pagina);
	}

	function actualizar(){			
		$nombre_repuestos = trim($_POST['nombre']);
		if (empty($nombre_repuestos)) {
			echo "<script>alert('Debe completar los campos')</script>";
			redirect('transportes/repuestos', 'refresh');
		}else{
			$id = $_POST['id'];
			$data = array(
				'nombre_repuesto' => $_POST['nombre'],
				'precio'=>$_POST['precio'],
				);
			$this->repuestos_model->actualizar_repuestos($id,$data);
			echo "<script>alert('Se han actualizado los registros')</script>";
			redirect('transportes/repuestos', 'refresh');
		}
	}		

	function eliminar($id){
		$this->repuestos_model->eliminar($id);
        redirect( base_url().'transportes/repuestos', 'refresh');
	}
}
?>