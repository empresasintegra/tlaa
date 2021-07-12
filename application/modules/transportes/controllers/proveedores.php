<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Proveedores extends CI_Controller {
	//public $requerimiento;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model("proveedores_model");
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
			'titulo' => "Proveedores",
			'js' => array('js/confirm_eliminar.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Proveedores ')), 
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['proveedor'] = $this->proveedores_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/proveedores/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_proveedores(){
		$this->load->model('tla_auditoria_registros');
		$nombre_add_cargo = trim($_POST['rut_proveedor']);
		if (empty($nombre_add_cargo)) {
			echo "<script>alert('Debe completar los campos')</script>";
			redirect('transportes/proveedores', 'refresh');
		}else{
			$si_existe = $this->proveedores_model->consultar_registro($_POST['rut_proveedor']);

			if ($si_existe == 1){
				echo "<script>alert('El Proveedor ingresado ya existe')</script>";
			}elseif($si_existe == 0){
				$data = array(
					'rut' => $_POST['rut_proveedor'],
					'nombre_proveedor'=> $_POST['nombre_proveedor'],
					'direccion'=> $_POST['direccion'],
					);
				$this->proveedores_model->ingresar($data);
				
				

				//auditoria

				$ultimo_id = $this->db->insert_id();
					

				date_default_timezone_set('America/Santiago');

             
				$auditoria_proveedor = array('tabla_id' => "proveedor_".$ultimo_id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 1,
					'nombre'=>"Proveedor ".$_POST['nombre_proveedor']." fue ingresado.",
 					);

				$this->tla_auditoria_registros->guarda_auditoria_proveedor($auditoria_proveedor);


				//termino auditoria








		}
		echo "<script>alert('Se han actualizado los registros')</script>";
		redirect('transportes/proveedores', 'refresh');
	}
}

	function modal_editar($id){
		$pagina['proveedores']= $this->proveedores_model->get_proveedor($id);
		$this->load->view('transportes/proveedores/modal_editar_proveedores', $pagina);
	}
	function actualizar(){			
		$id = $_POST['id'];
		$data = array(
			'nombre_proveedor' => $_POST['nombre'],
			'rut'=>$_POST['rut'],
			'direccion'=>$_POST['direccion'],
			);
		$this->proveedores_model->actualizar_proveedor($id,$data);	
		echo "<script>alert('Se han actualizado los registros')</script>";
		redirect('transportes/proveedores', 'refresh');
	}		

	function eliminar($id){
		$this->proveedores_model->eliminar($id);
        redirect( base_url().'transportes/proveedores', 'refresh');
	}

	function verificar(){
		if (isset($_POST['eliminar'])){
			foreach($_POST['seleccionar_eliminar'] as $id){	  		
				$this->herramientas_model->eliminar($id);
			}
		}
		echo "<script>alert('Registro Eliminado')</script>";
		redirect('transportes/proveedores', 'refresh');
	}
}
?>