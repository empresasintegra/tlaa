<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Trabajador extends CI_Controller {
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
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 112)
				$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes_rrhh','',TRUE);
			else
				redirect('/usuarios/login/index', 'refresh');
			$this->load->model('personal_model');
			$this->load->model('tla_auditoria_registros');
		}
	}

	function datos_trabajadores($tipo_listado = false){
		$this->load->model("personal_model");
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Listado de Personal",
			'subtitulo' => '',
			'js' => array('js/seleccionar_todos.js','js/si_listado_trabajadores.js','js/validar_rut.js','js/confirm_eliminar.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js','js/lista_usuarios_req.js','js/cargar_choferes.js','plugins/jquery.Rut/jquery.Rut.js','plugins/jquery.Rut/jquery.Rut.min.js','js/validando_rut.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);

		$listado_defecto = 3;
		if (empty($tipo_listado)){
			$listado_seleccion = $listado_defecto;
		}else{ 
			$listado_seleccion = $tipo_listado;
		}
		
		if ($listado_seleccion == 3) {
			$pagina['personal'] = $this->personal_model->listar();
		}elseif($listado_seleccion == 1){
			$pagina['personal'] = $this->personal_model->listar_activos();
		}elseif($listado_seleccion == 2){
			$pagina['personal'] = $this->personal_model->listar_inactivos();
		}
        
       
        $pagina['recorriendo'] = $this->personal_model->buscar_trabajadores();
		$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
		$pagina['listar_faltas'] = $this->personal_model->tipo_inasistencia();
		$pagina['listado_seleccion'] = $listado_seleccion;
		$pagina['cargolista']= $this->personal_model->listarcargo();
		$pagina['contratolista']= $this->personal_model->listarcontrato();
		$pagina['listarempresa'] = $this->personal_model->listarempresa();
		$base['cuerpo'] = $this->load->view('transportes/trabajador/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_persona(){
		$nombre = trim($_POST['nombre']);
		$rut = trim($_POST['rut']);
		$apellido_paterno = trim($_POST['apellido_paterno']);
		$apellido_materno = trim($_POST['apellido_materno']);

		if(empty($nombre)){
			echo "<script>alert('Complete el campo Nombre!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		if(empty($rut)){
			echo "<script>alert('Complete el campo Rut!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		if(empty($apellido_paterno)){
			echo "<script>alert('Complete el campo Apellido Paterno!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		if(empty($apellido_materno)){
			echo "<script>alert('Complete el campo Apellido Materno!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}

		$si_existe_rut = $this->personal_model->consulta_rut_trabajador($rut);

		if ($si_existe_rut == 1) {
			echo "<script>alert('El rut ingresado ya existe!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}else{

			$data = array(
				'nombre' => strtoupper($_POST['nombre']),
				'rut' => $_POST['rut'],
				'apellido_paterno' => strtoupper($_POST['apellido_paterno']),
				'apellido_materno' => strtoupper($_POST['apellido_materno']),

				);
			$this->personal_model->ingresar($data);
			$ultimo_id = $this->db->insert_id();

			date_default_timezone_set('America/Santiago');

			$auditoria_persona = array('tabla_id' => "personal_".$ultimo_id, 
				'usuario_id' => $this->session->userdata('id'),
				'fecha' => date('Y-m-d G:i:s'),
				'accion' => 1
				);

			$this->tla_auditoria_registros->guarda_auditoria_persona($auditoria_persona);

			$data2 = array(
				'id_persona' => $ultimo_id,
				'id_cargo' => $_POST['id_select_cargo'],
				'id_instrumento_colectivo' => $_POST['id_select_contrato'],
				'id_empresa' => $_POST['id_select_empresa'],
				'id_estado' => 1,
				'estado_actual' => 6
				);
			$this->personal_model->ingresar_trabajador($data2);

			date_default_timezone_set('America/Santiago');

			$auditoria_trabajador = array('tabla_id' => "trabajador_".$ultimo_id, 
				'usuario_id' => $this->session->userdata('id'),
				'fecha' => date('Y-m-d G:i:s'),
				'accion' => 1
				);

			$this->tla_auditoria_registros->guarda_auditoria_trabajador($auditoria_trabajador);


			echo "<script>alert('Trabajador Ingresado Exitosamente.')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
	}

	function eliminar_producto($id){
		$this->load->model("personal_model");
		$this->productos_model->eliminar($id);
		redirect('transportes/trabajador/datos_trabajadores', 'refresh');
	}
    //controlador para actualzar informacion
	function actualizar(){
		
		$nombre = trim($_POST['nombre']);
		$rut = trim($_POST['rut']);
		$apellido_paterno = trim($_POST['apellido_paterno']);
		$apellido_materno = trim($_POST['apellido_materno']);

		if(empty($nombre)){
			echo "<script>alert('Complete el campo Nombre!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		if(empty($rut)){
			echo "<script>alert('Complete el campo Rut!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		if(empty($apellido_paterno)){
			echo "<script>alert('Complete el campo Apellido Paterno!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		if(empty($apellido_materno)){
			echo "<script>alert('Complete el campo Apellido Materno!')</script>";
			redirect('transportes/trabajador/datos_trabajadores', 'refresh');
		}
		$id = $_POST['id'];
		$data = array(
			'nombre' => $_POST['nombre'],
			'rut' => $_POST['rut'],
			'apellido_paterno' => $_POST['apellido_paterno'],
			'apellido_materno' => $_POST['apellido_materno']
			);
		$this->personal_model->actualizar($id,$data);

		date_default_timezone_set('America/Santiago');

		$auditoria_persona = array('tabla_id' => "personal_".$id, 
			'usuario_id' => $this->session->userdata('id'),
			'fecha' => date('Y-m-d G:i:s'),
			'accion' => 2
			);

		$this->tla_auditoria_registros->actualizar_auditoria_persona($auditoria_persona);

		$modificacion = array('id_usuario' => $this->session->userdata('id'),
					  'id_trabajador' => $_POST['id'],
					   'cambio_cargo' => $_POST['id_select_contrato']);
		$this->tla_auditoria_registros->responsable_cambio($modificacion);


		$data2 = array(
			'id_cargo' => $_POST['id_select_cargo'],
			'id_instrumento_colectivo' => $_POST['id_select_contrato'],
			'id_empresa' => $_POST['id_select_empresa']
			);
		$this->personal_model->actualizar_trabajador($id,$data2);

		date_default_timezone_set('America/Santiago');

		$auditoria_trabajador = array('tabla_id' => "trabajador_".$id, 
			'usuario_id' => $this->session->userdata('id'),
			'fecha' => date('Y-m-d G:i:s'),
			'accion' => 2
			);

		$this->tla_auditoria_registros->actualizar_auditoria_trabajador($auditoria_trabajador);

		$this->personal_model->actualizar_trabajador_al_dia($id,$data2);

		date_default_timezone_set('America/Santiago');

		$auditoria_trabajador_al_dia = array('tabla_id' => "trabajador_al_dia_".$id, 
			'usuario_id' => $this->session->userdata('id'),
			'fecha' => date('Y-m-d G:i:s'),
			'accion' => 2
			);

		$this->tla_auditoria_registros->actualizar_auditoria_trabajador_al_dia($auditoria_trabajador_al_dia);


		$data3 = array(
			'id_cargo' => $_POST['id_select_cargo'],
			'id_convenio' => $_POST['id_select_contrato']
			);

		$this->personal_model->actualiza_resumen_produccion($id,$data3);
		
		echo "<script>alert('Trabajador Actualizado Exitosamente.')</script>";
		redirect('transportes/trabajador/datos_trabajadores', 'refresh');
	}


	//creacion de modal para opciones de edicion
	function modal_editar($id){
		$this->load->model("personal_model");
		$pagina['cargolista']= $this->personal_model->listarcargo();
		$pagina['contratolista']= $this->personal_model->listarcontrato();
		$pagina['listarempresa'] = $this->personal_model->listarempresa();
		$pagina['datos_trabajador']= $this->personal_model->get_trabajador($id);
		$pagina['id_trabajador'] = $id;
		$this->load->view('transportes/trabajador/modal_editar_trabajador', $pagina);
	}
	//modal agregar incidente	

	function modal_agregar_incidente($id){
		$this->load->model("personal_model");
		$pagina['cargolista']= $this->personal_model->listarcargo();
		$pagina['contratolista']= $this->personal_model->listarcontrato();
		$pagina['datos_trabajador']= $this->personal_model->get_trabajador($id);
		$this->load->view('transportes/trabajador/modal_agregar_incidente', $pagina);
	}
	//modal ver icidente 	

	function modal_informe_incidente($id){
		$this->load->model("personal_model");
		$pagina['cargolista']= $this->personal_model->listarcargo();
		$pagina['contratolista']= $this->personal_model->listarcontrato();
		$pagina['datos_trabajador']= $this->personal_model->get_trabajador($id);
		$this->load->view('transportes/trabajador/modal_informe_incidente', $pagina);
	}
	
	function verificar(){
		$this->load->model("personal_model");		
		if (isset($_POST['enviar'])){		
				foreach($_POST['trabajadores'] as $c => $valores){
					if (!empty($_POST['trabajadores'][$c])) {						
						$datas = array('estado_actual' => $_POST['id_select_inasistencia'][$c]);

						//var_dump($datas);
						$this->personal_model->guarda_estado_trabajadores($datas, $valores);
					}								
				}					
		}

		if (isset($_POST['eliminar'])){
			foreach($_POST['seleccionar_eliminar'] as $id){				
				$datos = $this->personal_model->traer_datos($id);


				foreach ($datos as $datos1){
					$datos2 = array  ('id_trabajador' => $datos1->id ,
									 'id_persona' => $datos1->id_persona,
									 'id_cargo' => $datos1->id_cargo,
									  'id_instrumento_colectivo' => $datos1->id_instrumento_colectivo,
									  'id_estado' => $datos1->id_estado,
									  'estado_actual' => $datos1->estado_actual,
									  'fecha_registro' => $datos1->fecha_registro,
									  'usuario_elimino' => $this->session->userdata('id'),
									  'estado'          => 1,
									  'fecha_elimino' => date('Y-m-d'),
									);


				}
				$this->personal_model->respaldo($datos2);
				$this->personal_model->borrar($id);


				date_default_timezone_set('America/Santiago');
				$auditoria_persona = array('tabla_id' => "personal_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3
					);

				$this->tla_auditoria_registros->eliminar_auditoria_persona($auditoria_persona);
				

				date_default_timezone_set('America/Santiago');

				$auditoria_trabajador = array('tabla_id' => "trabajador_al_dia_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3
					);

				$this->tla_auditoria_registros->eliminar_auditoria_trabajador_al_dia($auditoria_trabajador);
			}
		}
		redirect('transportes/trabajador/datos_trabajadores', 'refresh');
	}

	function guardar_trabajadores_excel(){
		$this->load->library('excel');
		$name   = $_FILES['dato']['name'];
		$tname  = $_FILES['dato']['tmp_name'];        
		$obj_excel = PHPExcel_IOFactory::load($tname);
		$obj_excel ->setActiveSheetIndex(0);            
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();
		$cont = 0;
		for ($i=1; $i <= $numRows; $i++) {
			if ($i != 1) {      


				$rut = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$apellido_paterno = $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
				$apellido_materno = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$nombres = $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$fecha_inicio_c = date("Y-m-d", $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
				$fecha_termino_c = date("Y-m-d", $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
				$cargo = $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				$tipo_contrato = $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();

				
				$si_existe_rut = $this->personal_model->consulta_rut_trabajador($rut);

				if ($si_existe_rut == 1) {
					echo "<script>alert('El rut ingresado ya existe!')</script>";
					redirect('transportes/trabajador/datos_trabajadores', 'refresh');
				}else{				

					$data = array(
						'nombre' => $nombres,
						'rut' => $rut,
						'apellido_paterno' => $apellido_paterno,
						'apellido_materno' => $apellido_materno,
						'fecha_inicio_c' => $fecha_inicio_c,
						'fecha_termino_c' => $fecha_termino_c,
						);
					$this->personal_model->ingresar_excel($data);
					$ultimo_id = $this->db->insert_id();					
					$data2 = array(
						'id_persona' => $ultimo_id,
						'id_cargo' => $cargo,
						'id_instrumento_colectivo' => $tipo_contrato,
						'id_estado' => 1,
						'estado_actual' => 6
						);

					
					$this->personal_model->ingresar_trabajador_excel($data2);	
					redirect('transportes/trabajador/datos_trabajadores', 'refresh');
				}

			}
			
		}


	}


	function reincorporar_trabajador (){
		$this->load->model("personal_model");
		if (isset($_POST['reincorporar'])){
			foreach($_POST['seleccionar_buscar'] as $id){



				$datos = $this->personal_model->traer_datos_respaldo($id);

					foreach ($datos as $datos1){
					$datos2 = array  ('id' => $datos1->id_trabajador ,
									 'id_persona' => $datos1->id_persona,
									 'id_cargo' => $datos1->id_cargo,
									  'id_instrumento_colectivo' => $datos1->id_instrumento_colectivo,
									  'id_estado' => $datos1->id_estado,
									  'estado_actual' => $datos1->estado_actual,
									  'fecha_registro' => $datos1->fecha_registro,
									);


				}

								$this->personal_model->devolver_trabajador($datos2);


					$actualizar_respaldo = array('usuario_reincorporacion' => $this->session->userdata('id') , 
										'fecha_reincorporacion' => date('Y-m-d '),
										'estado' => 2);

					$this->personal_model->actualizar_respaldo($id,$actualizar_respaldo);
					
				





	}

}
redirect('transportes/trabajador/datos_trabajadores', 'refresh');
}

function consulta_trabajador(){
  		$this->load->model("personal_model");
 		$rut = $_POST['rut'];
  		$resultado = $this->personal_model->comprobar_rut($rut);
  		echo json_encode($resultado);

}


}

?>