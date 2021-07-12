<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codigos_ccu extends CI_Controller {

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
			$this->load->model('Si_codigos_model');
			$this->load->model('tla_auditoria_registros');
		}
	}

	public function index(){
		

		$fecha_hoy = date('Y-m-d');

		$base = array(
			'head_titulo' => "Sistema Transporte - Rutas",
			'titulo' => "Códigos CCU",
			'subtitulo' => '',
			'js' => array('js/confirm_eliminar.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js',
				'js/confirm.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);

		
		$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
		$pagina['fecha'] = $fecha_hoy;	
		$pagina['codigo'] = $this->Si_codigos_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/codigos/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function agregar_codigo(){

		if (!empty($_POST['codigo'])) {

			$permitidos = "sS0123456789";

			for ($i=0; $i<strlen($_POST['codigo']) ; $i++) { 
				if (strpos($permitidos, substr($_POST['codigo'], $i, 1))===false) {
					echo "<script>alert('El codigo ingresado no es valido')</script>";
					redirect('transportes/codigos_ccu', 'refresh');

				}
			}

			$si_existe = $this->Si_codigos_model->consultar_registro($_POST['codigo']);

			if ($si_existe == 1) {
				echo "<script>alert('El registro ingresado ya existe')</script>";
			}elseif($si_existe == 0){
				$data = array('codigos_ccu' => strtoupper($_POST['codigo']),
					'fecha_registro' => $_POST['fecha'],
					'estado' => 1, 
					'eliminado' => 1);
				$this->Si_codigos_model->guarda_registro($data);
				$ultimo_id = $this->db->insert_id();

				date_default_timezone_set('America/Santiago');

				$auditoria_codigo_ccu = array('tabla_id' => "ccu_codigo-".$ultimo_id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 1
					);

				$this->tla_auditoria_registros->guarda_auditoria_codigo_ccu($auditoria_codigo_ccu);


			}

			
			redirect('transportes/codigos_ccu', 'refresh');

		}else{
			echo "<script>alert('Debe completar los campos indicados.')</script>";
			redirect('transportes/codigos_ccu', 'refresh');

		}

	}

	function eliminar_codigo(){
		if (isset($_POST['eliminar'])){			
			foreach($_POST['seleccionar_eliminar'] as $id){	  		
				$this->Si_codigos_model->eliminar($id);

				date_default_timezone_set('America/Santiago');

				$auditoria_codigo_ccu = array('tabla_id' => "ccu_codigo-".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3
					);

				$this->tla_auditoria_registros->eliminar_auditoria_codigo_ccu($auditoria_codigo_ccu);
			}
			echo "<script>alert('Registro Eliminado')</script>";
			redirect('transportes/codigos_ccu', 'refresh');
		}
		
	}

}

/* End of file codigos_ccu.php */
/* Location: ./application/modules/transportes/controllers/codigos_ccu.php */