<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranking extends CI_Controller {

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
			$this->load->model('si_ranking_model');
			$this->load->model('Si_produccion_model');
		}
	}


	public function ranking_ingreso($fecha = false){
		$fecha_hoy = date('Y-m-d');
		if (empty($fecha)){
			$fecha_unir = $fecha_hoy;
		}else{
			$fecha_unir = $fecha;
		}

		$f = explode('-', $fecha_unir);
		$ano = $f[0];
		$mes = $f[1];
		$dia = $f[2];
		$conector = "-";
		$fecha_trabajar = $ano.$conector.$mes.$conector.'01';

		$fecha_falsa = $ano.$conector.$mes.$conector.'01';

		$base = array(
			'head_titulo' => "Sistema Transporte - Ranking",
			'titulo' => "Ingreso Ranking",
			'subtitulo' => '',
			'js' => array('js/confirm.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_datepicker_datos.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/lista_usuarios_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => TRUE,
			'menu' => $this->menu,
			);



		$todos_los_trabajadores_activos = $this->si_ranking_model->todos_los_trabajadores_activos();
		


		foreach ($todos_los_trabajadores_activos as $trabajador) {
			$consultar_registro_trabajador = $this->si_ranking_model->consulta_trabajador($trabajador->id, $fecha_falsa);
			if ($consultar_registro_trabajador == 0) {
				if ($fecha_falsa == '0000-00-00') {
					//no hace nada
				}else{
					$datas_trabajador = array('id_trabajador' => $trabajador->id,
						'fecha_registro' => $fecha_falsa,
						);
					
					$this->si_ranking_model->insertar_datos($datas_trabajador);
				}
			}else{

			}
		}

		$listar_trabajadores_ranking = $this->si_ranking_model->obtener_datos_ranking($fecha_falsa);
		
		$lista_aux = array();
		if (!empty($listar_trabajadores_ranking)) {
			foreach ($listar_trabajadores_ranking as $listar) { 			 			
				$aux = new stdClass();
				$aux->id = $listar->id;
				$aux->nombre = $listar->nombre;
				$aux->ap = $listar->ap; 
				$aux->am = $listar->am; 
				$aux->rut = $listar->rut; 
				$aux->cargo = $listar->cargo; 
				$aux->nombre_convenio = $listar->nombre_convenio; 
				$aux->amonesta = $listar->amonesta; 
				$aux->inasis = $listar->inasis; 
				$aux->falta_dinero = $listar->falta_dinero;			
				$aux->r_caja = $listar->r_caja; 
				$aux->r_cliente = $listar->r_cliente;
				$aux->aseo = $listar->aseo; 
				$aux->quejas = $listar->quejas;
				$aux->total = $listar->t_rank; 			 		
				array_push($lista_aux, $aux);
				unset($aux);
			}

		}

		$pagina['lista_aux'] = $lista_aux;
		$pagina['usuario_id'] = $this->session->userdata('id');
		$pagina['fecha_mostrar'] = $fecha_falsa;
		$base['cuerpo'] = $this->load->view('transportes/ranking/ingreso_ranking',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_ranking($fecha = false){
		$fecha_hoy = date('Y-m-d');
		if (empty($fecha)){
			$fecha_unir = $fecha_hoy;
		}else{
			$fecha_unir = $fecha;
		}

		$f = explode('-', $fecha_unir);
		$ano = $f[0];
		$mes = $f[1];
		$dia = $f[2];
		$conector = "-";
		$fecha_trabajar = $ano.$conector.$mes.$conector.$dia;

		$fecha_falsa = $ano.$conector.$mes.$conector.'01';
		$fecha_falsa_1 = $_POST['fecha_mostrar'];

		foreach ($_POST['id_trabajador'] as $t => $value) {
			if (!empty($_POST['amonesta'][$t]) || !empty($_POST['inasistencia'][$t]) || !empty($_POST['falta_dinero'][$t])  || !empty($_POST['r_caja'][$t]) 
				|| !empty($_POST['r_cliente'][$t]) || !empty($_POST['aseo'][$t]) 
			 	|| !empty($_POST['aseo'][$t]) || !empty($_POST['quejas'][$t])) {

				$id_trabajador = $_POST['id_trabajador'][$t];
				$datos_ranking = array(
					'amonestaciones' => $_POST['amonesta'][$t],
					'inasistencias' => $_POST['inasistencia'][$t],
					'falta_dinero' => $_POST['falta_dinero'][$t],
					'rechazos_cajas' => $_POST['r_caja'][$t],
					'rechazos_clientes' => $_POST['r_cliente'][$t],
					'aseo_mantencion' => $_POST['aseo'][$t],
					'queja_reclamo' => $_POST['quejas'][$t],
					'total_rank' => $_POST['amonesta'][$t] + $_POST['inasistencia'][$t] +
									$_POST['falta_dinero'][$t] + $_POST['r_caja'][$t] + $_POST['r_cliente'][$t] + $_POST['aseo'][$t] + $_POST['quejas'][$t],
					);

				//echo $fecha_falsa_1;
				//var_dump($datos_ranking);
				$this->si_ranking_model->guardar_ranking_trabajador($datos_ranking, $id_trabajador, $fecha_falsa_1);

			}
		}
		redirect('transportes/ranking/ranking_ingreso/'.$fecha_falsa_1.'', 'refresh');  
	}

}

/* End of file ranking.php */
/* Location: ./application/modules/transportes/controllers/ranking.php */