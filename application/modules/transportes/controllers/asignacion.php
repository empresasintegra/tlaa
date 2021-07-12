<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacion extends CI_Controller {

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
			else
				redirect('/usuarios/login/index', 'refresh');
			$this->load->model('si_asignaciones_model');
			$this->load->model('personal_model');
		}
	}

	public function asignacion_trabajadores(){
		
		$base = array(
			'head_titulo' => "Sistema Transporte - Instrumento colectivo",
			'titulo' => "Asignacion Camion - Trabajador",
			'subtitulo' => '',
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js','js/lista_usuarios_req.js','js/cargar_choferes.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => false,
			'menu' => $this->menu
			);
		$pagina['usuario_id'] = $this->session->userdata('id');


		$pagina = "";
		$todos_los_camiones = $this->si_asignaciones_model->listar_camiones_codigo();
		$lista_aux = array();
		if (!empty($todos_los_camiones)) {
			foreach ($todos_los_camiones as $listar) {
				$aux = new stdClass();
				$aux->codigo2 = $listar->codigo;
				$aux->codigo = $listar->id_ccu;
				//chofer
				$get_chofer_asignado = $this->si_asignaciones_model->listar_choferes_asignados($listar->id_ccu);
				if($get_chofer_asignado == "N/D"){
					$chofer_asignado = $this->si_asignaciones_model->listar_choferes_asignados("N/D");
				}else{
					$chofer_asignado = $this->si_asignaciones_model->listar_choferes_asignados($listar->id_ccu);

				}
				//ayudante1
				$get_peoneta_1_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				if($get_peoneta_1_asignado == "N/D"){
					$peoneta_1_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado("N/D");
				}else{
					$peoneta_1_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				}

				//ayudante2
				$get_peoneta_2_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				if($get_peoneta_2_asignado == "N/D"){
					$peoneta_2_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado("N/D");
				}else{
					$peoneta_2_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				}
				//ayudante3
				$get_peoneta_3_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				if($get_peoneta_3_asignado == "N/D"){
					$peoneta_3_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado("N/D");
				}else{
					$peoneta_3_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				}
				//ayudante4
				$get_peoneta_4_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				if($get_peoneta_4_asignado == "N/D"){
					$peoneta_4_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado("N/D");
				}else{
					$peoneta_4_asignado = $this->si_asignaciones_model->listar_peoneta_1_asignado($listar->id_ccu);
				}


				$chofer_1 = $this->si_asignaciones_model->mostrar_nombre_chofer($chofer_asignado->id_chofer);
				$peoneta_1 = $this->si_asignaciones_model->mostrar_nombre_peoneta_1($peoneta_1_asignado->id_ayudante_1);
				$peoneta_2 = $this->si_asignaciones_model->mostrar_nombre_peoneta_1($peoneta_2_asignado->id_ayudante_2);
				$peoneta_3 = $this->si_asignaciones_model->mostrar_nombre_peoneta_1($peoneta_3_asignado->id_ayudante_3);
				$peoneta_4 = $this->si_asignaciones_model->mostrar_nombre_peoneta_1($peoneta_4_asignado->id_ayudante_4);
				//datos_chofer
				$aux->chofer1_nombre = (isset($chofer_1->nombre)?$chofer_1->nombre:"N/D");
				$aux->chofer1_ap = (isset($chofer_1->apellido_paterno)?$chofer_1->apellido_paterno:"");	
				$aux->chofer1_am = (isset($chofer_1->apellido_materno)?$chofer_1->apellido_materno:"");		
				//datos_peoneta_1
				$aux->peoneta1_nombre = (isset($peoneta_1->nombre)?$peoneta_1->nombre:"N/D");
				$aux->peoneta1_ap = (isset($peoneta_1->apellido_paterno)?$peoneta_1->apellido_paterno:"");	
				$aux->peoneta1_am = (isset($peoneta_1->apellido_materno)?$peoneta_1->apellido_materno:"");
				//datos_peoneta_2
				$aux->peoneta2_nombre = (isset($peoneta_2->nombre)?$peoneta_2->nombre:"N/D");
				$aux->peoneta2_ap = (isset($peoneta_2->apellido_paterno)?$peoneta_2->apellido_paterno:"");	
				$aux->peoneta2_am = (isset($peoneta_2->apellido_materno)?$peoneta_2->apellido_materno:"");
				//datos_peoneta_3
				$aux->peoneta3_nombre = (isset($peoneta_3->nombre)?$peoneta_3->nombre:"N/D");
				$aux->peoneta3_ap = (isset($peoneta_3->apellido_paterno)?$peoneta_3->apellido_paterno:"");	
				$aux->peoneta3_am = (isset($peoneta_3->apellido_materno)?$peoneta_3->apellido_materno:"");
				//datos_peoneta_4
				$aux->peoneta4_nombre = (isset($peoneta_4->nombre)?$peoneta_4->nombre:"N/D");
				$aux->peoneta4_ap = (isset($peoneta_4->apellido_paterno)?$peoneta_4->apellido_paterno:"");	
				$aux->peoneta4_am = (isset($peoneta_4->apellido_materno)?$peoneta_4->apellido_materno:"");

				
				array_push($lista_aux, $aux);
				unset($aux);

			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$base['cuerpo'] = $this->load->view('transportes/asignaciones/camion_trabajadores',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
		


	}

	function modal_agregar_trabajador($codigo = FALSE){
		$pagina['choferes'] = $this->si_asignaciones_model->get_choferes();
		$pagina['codigo'] = $codigo;
		$this->load->view('transportes/asignaciones/modal_add_chofer', $pagina);
	}

	function add_chofer(){
		
		$id_camion = $_POST['id_camion'];

		$si_existe_registro_camion_t = $this->si_asignaciones_model->consulta_si_existe_camion($id_camion);

		if ($si_existe_registro_camion_t == 1) {
			//echo "existe, debes actuyalziar";
			
			if (isset($_POST['chofer'])) {

				//$id_chofer = $_POST['chofer'];
				$x = 0;
				foreach ($_POST['chofer'] as $key1){
					$x += 1;
					$chofer[$x] = $key1;
				}
				if ($chofer[$x]){
					$id_chofer = $chofer[$x];						
				}else {
					$arreglo_chofer_1 = ('0');
				}
				$si_existe_chofer_asignado = $this->si_asignaciones_model->consultar_camion_chofer($id_chofer);

				if($si_existe_chofer_asignado == 1){
					echo "<script>alert('Este chofer ya esta asignado a otro Camión')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}elseif ($si_existe_chofer_asignado == 0) {
					$id_camion =$_POST['id_camion'];			
					$x = 0;
					foreach ($_POST['chofer'] as $key1){
						$x += 1;
						$chofer[$x] = $key1;
					}
					if ($chofer[$x]){
						$arreglo_chofer_1 = $chofer[$x];						
					}else {
						$arreglo_chofer_1 = ('0');
					}				

					$guarda_registro = array(
						'id_chofer' => $arreglo_chofer_1,
						'estado' => 1);
					$this->si_asignaciones_model->actualizar_registro_trabajadores_chofer($guarda_registro, $id_camion);
					echo "<script>alert('Se han Guardado los registros!!')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}			

			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}		

		}elseif ($si_existe_registro_camion_t == 0) {
			//echo "No existe, debes insertar";
			$id_camion =$_POST['id_camion'];
			$x = 0;
			
			if (isset($_POST['chofer'])){
				foreach ($_POST['chofer'] as $key1){
					$x += 1;
					$chofer[$x] = $key1;
				}
				if ($chofer[$x]){
					$arreglo_chofer_1 = $chofer[$x];						
				}else {
					$arreglo_chofer_1 = ('0');
				}
			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}

			$guarda_registro = array('id_camion' => $id_camion, 
				'id_chofer' => $arreglo_chofer_1,
				'estado' => 1);
			$this->si_asignaciones_model->guarda_registro_trabajadores($guarda_registro);
			echo "<script>alert('Se han Guardado los registros!!')</script>";
			redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
		}



		
	}

	function modal_agregar_trabajador_peoneta_1($codigo = FALSE){
		$pagina['peoneta'] = $this->si_asignaciones_model->get_peonetas();
		$pagina['codigo'] = $codigo;
		$this->load->view('transportes/asignaciones/modal_add_peoneta_1', $pagina);
	}

	function add_peoneta_1(){
		$id_camion = $_POST['id_camion'];

		$si_existe_registro_camion_t = $this->si_asignaciones_model->consulta_si_existe_camion($id_camion);

		if ($si_existe_registro_camion_t == 1) {
			if (isset($_POST['peoneta'])) {

				//$id_chofer = $_POST['chofer'];
				$x = 0;
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$id_peoneta = $peoneta[$x];						
				}else {
					$id_peoneta = ('0');
				}
				$si_existe_peoneta_asignado = $this->si_asignaciones_model->consultar_peoneta_camion_1($id_peoneta);

				if($si_existe_peoneta_asignado == 1){
					echo "<script>alert('Este Peoneta ya esta asignado a otro Camión')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}elseif ($si_existe_peoneta_asignado == 0) {
					$id_camion =$_POST['id_camion'];			
					$x = 0;
					foreach ($_POST['peoneta'] as $key1){
						$x += 1;
						$peoneta[$x] = $key1;
					}
					if ($peoneta[$x]){
						$arreglo_peoneta_1 = $peoneta[$x];						
					}else {
						$arreglo_peoneta_1 = ('0');
					}				

					$guarda_registro = array(
						'id_ayudante_1' => $arreglo_peoneta_1,
						'estado' => 1);
					$this->si_asignaciones_model->actualizar_registro_trabajadores_peoneta_1($guarda_registro, $id_camion);
					echo "<script>alert('Se han Guardado los registros!!')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}			

			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}
			
		}elseif ($si_existe_registro_camion_t == 0) {
			//echo "No existe, debes insertar";
			$id_camion =$_POST['id_camion'];
			$x = 0;
			
			if (isset($_POST['peoneta'])){
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$arreglo_peoneta_1 = $peoneta[$x];						
				}else {
					$arreglo_peoneta_1 = ('0');
				}
			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}

			$guarda_registro = array('id_camion' => $id_camion, 
				'id_ayudante_1' => $arreglo_peoneta_1,
				'estado' => 1);
			$this->si_asignaciones_model->guarda_registro_trabajadores_ayudante_1($guarda_registro);
			echo "<script>alert('Se han Guardado los registros!!')</script>";
			redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
		}
	}
	function modal_agregar_trabajador_peoneta_2($codigo = FALSE){
		$pagina['peoneta'] = $this->si_asignaciones_model->get_peonetas();
		$pagina['codigo'] = $codigo;
		$this->load->view('transportes/asignaciones/modal_add_peoneta_2', $pagina);
	}
	function add_peoneta_2(){
		$id_camion = $_POST['id_camion'];

		$si_existe_registro_camion_t = $this->si_asignaciones_model->consulta_si_existe_camion($id_camion);

		if ($si_existe_registro_camion_t == 1) {
			if (isset($_POST['peoneta'])) {

				//$id_chofer = $_POST['chofer'];
				$x = 0;
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$id_peoneta = $peoneta[$x];						
				}else {
					$id_peoneta = ('0');
				}
				$si_existe_peoneta_asignado_2 = $this->si_asignaciones_model->consultar_peoneta_camion_1($id_peoneta);

				if($si_existe_peoneta_asignado_2 == 1){
					echo "<script>alert('Este Peoneta ya esta asignado a otro Camión')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}elseif ($si_existe_peoneta_asignado_2 == 0) {
					$id_camion =$_POST['id_camion'];			
					$x = 0;
					foreach ($_POST['peoneta'] as $key1){
						$x += 1;
						$peoneta[$x] = $key1;
					}
					if ($peoneta[$x]){
						$arreglo_peoneta_2 = $peoneta[$x];						
					}else {
						$arreglo_peoneta_2 = ('0');
					}				

					$guarda_registro = array(
						'id_ayudante_2' => $arreglo_peoneta_2,
						'estado' => 1);
					$this->si_asignaciones_model->actualizar_registro_trabajadores_peoneta_2($guarda_registro, $id_camion);
					echo "<script>alert('Se han Guardado los registros!!')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}			

			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}
			
		}elseif ($si_existe_registro_camion_t == 0) {
			//echo "No existe, debes insertar";
			$id_camion =$_POST['id_camion'];
			$x = 0;
			
			if (isset($_POST['peoneta'])){
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$arreglo_peoneta_2 = $peoneta[$x];						
				}else {
					$arreglo_peoneta_2 = ('0');
				}
			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}

			$guarda_registro = array('id_camion' => $id_camion, 
				'id_ayudante_2' => $arreglo_peoneta_2,
				'estado' => 1);
			$this->si_asignaciones_model->guarda_registro_trabajadores_ayudante_2($guarda_registro);
			echo "<script>alert('Se han Guardado los registros!!')</script>";
			redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
		}
	}
	function modal_agregar_trabajador_peoneta_3($codigo = FALSE){
		$pagina['peoneta'] = $this->si_asignaciones_model->get_peonetas();
		$pagina['codigo'] = $codigo;
		$this->load->view('transportes/asignaciones/modal_add_peoneta_3', $pagina);
	}
	function add_peoneta_3(){
		$id_camion = $_POST['id_camion'];

		$si_existe_registro_camion_t = $this->si_asignaciones_model->consulta_si_existe_camion($id_camion);

		if ($si_existe_registro_camion_t == 1) {
			if (isset($_POST['peoneta'])) {

				//$id_chofer = $_POST['chofer'];
				$x = 0;
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$id_peoneta_2 = $peoneta[$x];						
				}else {
					$id_peoneta_2 = ('0');
				}
				$si_existe_peoneta_asignado_2 = $this->si_asignaciones_model->consultar_peoneta_camion_1($id_peoneta_2);

				if($si_existe_peoneta_asignado_2 == 1){
					echo "<script>alert('Este Peoneta ya esta asignado a otro Camión')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}elseif ($si_existe_peoneta_asignado_2 == 0) {
					$id_camion =$_POST['id_camion'];			
					$x = 0;
					foreach ($_POST['peoneta'] as $key1){
						$x += 1;
						$peoneta[$x] = $key1;
					}
					if ($peoneta[$x]){
						$arreglo_peoneta_2 = $peoneta[$x];						
					}else {
						$arreglo_peoneta_2 = ('0');
					}				

					$guarda_registro = array(
						'id_ayudante_3' => $arreglo_peoneta_2,
						'estado' => 1);
					$this->si_asignaciones_model->actualizar_registro_trabajadores_peoneta_3($guarda_registro, $id_camion);
					echo "<script>alert('Se han Guardado los registros!!')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}			

			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}
			
		}elseif ($si_existe_registro_camion_t == 0) {
			//echo "No existe, debes insertar";
			$id_camion =$_POST['id_camion'];
			$x = 0;
			
			if (isset($_POST['peoneta'])){
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$arreglo_peoneta_2 = $peoneta[$x];						
				}else {
					$arreglo_peoneta_2 = ('0');
				}
			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}

			$guarda_registro = array('id_camion' => $id_camion, 
				'id_ayudante_3' => $arreglo_peoneta_2,
				'estado' => 1);
			$this->si_asignaciones_model->guarda_registro_trabajadores_ayudante_3($guarda_registro);
			echo "<script>alert('Se han Guardado los registros!!')</script>";
			redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
		}
	}

	function modal_agregar_trabajador_peoneta_4($codigo = FALSE){
		$pagina['peoneta'] = $this->si_asignaciones_model->get_peonetas();
		$pagina['codigo'] = $codigo;
		$this->load->view('transportes/asignaciones/modal_add_peoneta_4', $pagina);
	}

	function add_peoneta_4(){
		$id_camion = $_POST['id_camion'];

		$si_existe_registro_camion_t = $this->si_asignaciones_model->consulta_si_existe_camion($id_camion);

		if ($si_existe_registro_camion_t == 1) {
			if (isset($_POST['peoneta'])) {

				//$id_chofer = $_POST['chofer'];
				$x = 0;
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$id_peoneta_2 = $peoneta[$x];						
				}else {
					$id_peoneta_2 = ('0');
				}
				$si_existe_peoneta_asignado_2 = $this->si_asignaciones_model->consultar_peoneta_camion_1($id_peoneta_2);

				if($si_existe_peoneta_asignado_2 == 1){
					echo "<script>alert('Este Peoneta ya esta asignado a otro Camión')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}elseif ($si_existe_peoneta_asignado_2 == 0) {
					$id_camion =$_POST['id_camion'];			
					$x = 0;
					foreach ($_POST['peoneta'] as $key1){
						$x += 1;
						$peoneta[$x] = $key1;
					}
					if ($peoneta[$x]){
						$arreglo_peoneta_2 = $peoneta[$x];						
					}else {
						$arreglo_peoneta_2 = ('0');
					}				

					$guarda_registro = array(
						'id_ayudante_4' => $arreglo_peoneta_2,
						'estado' => 1);
					$this->si_asignaciones_model->actualizar_registro_trabajadores_peoneta_4($guarda_registro, $id_camion);
					echo "<script>alert('Se han Guardado los registros!!')</script>";
					redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
				}			

			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}
			
		}elseif ($si_existe_registro_camion_t == 0) {
			//echo "No existe, debes insertar";
			$id_camion =$_POST['id_camion'];
			$x = 0;
			
			if (isset($_POST['peoneta'])){
				foreach ($_POST['peoneta'] as $key1){
					$x += 1;
					$peoneta[$x] = $key1;
				}
				if ($peoneta[$x]){
					$arreglo_peoneta_2 = $peoneta[$x];						
				}else {
					$arreglo_peoneta_2 = ('0');
				}
			}else{
				echo "<script>alert('Debe Seleccionar un Registro')</script>";
				redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
			}

			$guarda_registro = array('id_camion' => $id_camion, 
				'id_ayudante_4' => $arreglo_peoneta_2,
				'estado' => 1);
			$this->si_asignaciones_model->guarda_registro_trabajadores_ayudante_4($guarda_registro);
			echo "<script>alert('Se han Guardado los registros!!')</script>";
			redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
		}
	}




	function listar_choferes(){		
		$consulta = $this->si_asignaciones_model->get_choferes();
		echo json_encode($consulta);
	}

	function modal_agregar_trabajadores($codigo = FALSE){

		$choferes = $this->si_asignaciones_model->listar_chofer();
		$peonetas = $this->si_asignaciones_model->listar_peonetas();
		$lista_aux = array();
		if (!empty($choferes)) {
			foreach ($choferes as $rm) {
				$aux = new stdClass();
				$aux->c_chofer = $rm->id;
				$aux->c_nombre = $rm->nombre_persona;
				$aux->c_ap = $rm->ap;
				$aux->c_am = $rm->am;
				$aux->c_cargo = $rm->id_cargo;
				//$get_consulta = $this->si_asignaciones_model->si_existe_chofer($rm->id);
				//$aux->estado = (isset($get_consulta->id_trabajador))?$get_consulta->id_trabajador:"";
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$lista_aux2 = array();
		if (!empty($peonetas)) {
			foreach ($peonetas as $rm) {
				$aux = new stdClass();
				$aux->c_peoneta = $rm->id;
				$aux->p_nombre = $rm->nombre_persona;
				$aux->p_ap = $rm->ap;
				$aux->p_am = $rm->am;
				$aux->p_cargo = $rm->id_cargo;
				//$get_consulta = $this->si_asignaciones_model->si_existe_peoneta($rm->id);
				//$aux->estado = (isset($get_consulta->id_trabajador))?$get_consulta->id_trabajador:"";
				array_push($lista_aux2, $aux);
				unset($aux);
			}
		}
		$pagina['choferes'] = $lista_aux;
		$pagina['peonetas'] = $lista_aux2;
		$pagina['codigo'] = $codigo;		
		$this->load->view('transportes/asignaciones/modal_agregar_trabajadores', $pagina, FALSE);

	}

	function agregar_trabajadores(){

		$id_c = $_POST['id_camion'];

		

		$i = 0;
		foreach ($_POST['peonetas'] as $key){
			$i += 1;
			$peoneta[$i] = $key;
		}

		$x = 0;
		foreach ($_POST['chofer'] as $key1){
			$x += 1;
			$chofer[$x] = $key1;
		}


		$datos_generales = array('id_camion' => $id_c);

		
		if ($chofer[1]){
			$arreglo_chofer_1 = array(
				'id_chofer' => $chofer[1],
				);
		}else{
			$arreglo_chofer_1 = ('');
		}

		if ($peoneta[1]){
			$arreglo_peoneta_1 = array(
				'id_ayudante_1' => $peoneta[1],
				);
		}else{
			$arreglo_peoneta_1 = ('');
		}

		if ($peoneta[2]){
			$arreglo_peoneta_2 = array(
				'id_ayudante_2' => $peoneta[2],
				);
		}else{
			$arreglo_peoneta_2 = ('');
		}

		if ($peoneta[3]){
			$arreglo_peoneta_3 = array(
				'id_ayudante_3' => $peoneta[3],
				);
		}else{
			$arreglo_peoneta_3 = ('');
		}

		if ($peoneta[4]){
			$arreglo_peoneta_4 = array(
				'id_ayudante_4' => $peoneta[4],
				);
		}else{
			$arreglo_peoneta_4 = ('');
		}



		$arreglo_total = array_merge($datos_generales, $arreglo_peoneta_1, $arreglo_peoneta_2, $arreglo_peoneta_3, $arreglo_peoneta_4, $arreglo_chofer_1);

		


		$this->si_asignaciones_model->guarda_asignaciones($arreglo_total);
		echo "<script>alert('Se han Guardado los registros')</script>";
		redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
		
		

	}

	function eliminar_asignacion($codigo){
		$this->si_asignaciones_model->a_eliminar($codigo);
		redirect('transportes/asignacion/asignacion_trabajadores', 'refresh');
	}

	
}

/* End of file asignacion.php */
/* Location: ./application/modules/transportes/controllers/asignacion.php */