<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Mantenciones extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model("mantenciones_model");
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
			$this->load->model('tla_auditoria_registros');
		}
	}

	function index(){
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Mantenciones",
			'js' => array('js/confirm_eliminar.js','js/si_validaciones.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Mantenciones ')), 
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['choferes'] = $this->mantenciones_model->consultar_chofer();
		$pagina['mantenciones'] = $this->mantenciones_model->datos_tablas();
		$pagina['camiones'] = $this->mantenciones_model->consultar_camiones();
		$pagina['codigosccu'] = $this->mantenciones_model->consultar_codigosccu();//
		$pagina['detalles'] = $this->mantenciones_model->consultar_detalles();
		$pagina['proveedores'] = $this->mantenciones_model->consultar_proveedores();
		$pagina['repuestos'] = $this->mantenciones_model->listar_todos_repuestos();
		$pagina['costo'] = $this->mantenciones_model->costo_mantencion();
		$base['cuerpo'] = $this->load->view('transportes/mantenciones/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function agregar_mantencion(){
		$pagina['choferes'] = $this->mantenciones_model->consultar_chofer();
		$pagina['camiones'] = $this->mantenciones_model->consultar_camiones();
		$pagina['codigosccu'] = $this->mantenciones_model->consultar_codigosccu();
		$this->load->view('transportes/mantenciones/modal_agregar_mantenciones', $pagina);
	}

	function agregar_submantencion($id){
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Detalles De Mantención",
			'js' => array('js/confirm_eliminar.js','js/si_validaciones.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/mantenciones/index', 'txt' => 'Mantenciones '), array('url' => '', 'txt' => 'Detalles ') ), 
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			);
		$pagina['choferes'] = $this->mantenciones_model->consultar_chofer();
		$pagina['camiones'] = $this->mantenciones_model->consultar_camiones();
		$pagina['codigos'] = $this->mantenciones_model->consultar_codigosccu();
		$pagina['datos_mantenciones']= $this->mantenciones_model->get_mantencion($id);
		$pagina['detalles'] = $this->mantenciones_model->consultar_detalles();
		$pagina['repuestos'] = $this->mantenciones_model->listar_todos_repuestos();
		$pagina['proveedores'] = $this->mantenciones_model->consultar_proveedores();
		$pagina['subdetalles'] = $this->mantenciones_model->mantenciones_subdetalles($id);
		$pagina['id_mantencion'] = $id;	
		$pagina['costo'] = $this->mantenciones_model->costo_mantencion_detalle($id);
		$pagina['nombre_detalle'] = $this->nombre_mantencion_model->listar();
		$pagina['sumatotal'] = $this->mantenciones_model->suma_total($id);
		$submantenciones = $this->mantenciones_model->obtener_mantenciones_subdetalles($id);
     	  $listado = array();
	  	foreach($submantenciones as $rm){
         $aux = new stdClass();
         $aux->id_submantencion = $rm->id_detalle;
         $aux->nombre_submantencion = $rm->nombre_submantencion;                       
         $get_respuestos_submantencion = $this->mantenciones_model->get_repuestos($rm->id_detalle);
         $aux->respuesto_mantencion = array();
    	if (!empty($get_respuestos_submantencion)){
          foreach ($get_respuestos_submantencion as $d) {
              $archivo = new StdClass();
              $get_repuesto = $this->mantenciones_model->consultar_repuesto($d->id_repuesto);
              $get_proveedor = $this->mantenciones_model->get_proveedor($d->id_proveedor);
	          $archivo->nombre_respuesto = isset($get_repuesto->nombre_repuesto)?$get_repuesto->nombre_repuesto:"";
	          $archivo->proveedor  = isset($get_proveedor->nombre_proveedor)?$get_proveedor->nombre_proveedor:"";
	          //isset(consulta)?"si existe":"no existe";
	          $archivo->id= $d->id;
	          $archivo->cantidad = $d->cantidad;
	          $archivo->precio_repuesto = $d->precio_repuesto;
	          $archivo->total = $d->total;
	          array_push($aux->respuesto_mantencion, $archivo);
	       }
	          unset($archivo);
	     }
         array_push($listado, $aux);
         unset($aux);
        }
        $pagina['listado'] = $listado;
        $base['cuerpo'] = $this->load->view('transportes/mantenciones/ensayo',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);                      
	}

	function filtros_mantenciones($fecha = FALSE, $fecha_2 = FALSE){
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

			$base = array(
			'head_titulo' => "Sistema Transporte - Mantenciones",
			'titulo' => "Filtro de Mantenciones",
			'subtitulo' => '',
			'js' => array('js/seleccionar_todos.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js', 'js/si_rango_informe_produccion.js','js/si_validaciones.js', 'js/tla_datepicker_rango_mantencion.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/mantenciones/index', 'txt' => 'Mantenciones '), array('url' => '', 'txt' => 'Filtro Mantenciones ') ),
			'side_bar' => true,
			'menu' => $this->menu,
			);
			$pagina = "";
			$pagina['fecha_inicio'] = $fecha_trabajar;
			$pagina['codigosccu'] = $this->mantenciones_model->consultar_codigosccu();
		    $pagina['repuestos'] = $this->mantenciones_model->listar_todos_repuestos();
			$pagina['proveedores'] = $this->mantenciones_model->consultar_proveedores();
			$base['cuerpo'] =$this->load->view('transportes/mantenciones/filtros',$pagina,TRUE);
			$this->load->view('layout2.0/layout',$base); 
	}


	function filtro_mantencion(){
		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Detalles De Mantención",
			'js' => array('js/confirm_eliminar.js','js/si_validaciones.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/mantenciones/index', 'txt' => 'Mantenciones '), array('url' => 'transportes/mantenciones/filtros_mantenciones', 'txt' => 'Filtro mantenciones '),array('url' => '', 'txt' => 'detalles') ), 
	

			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'subtitulo' => '',
			'side_bar' => false,
			'menu' => $this->menu,
			);
	
				  #Filtrando por fecha hoy...
		 $f = $_POST['hoy'] ;

		 if ($f ==1) {
		 	$caso_switch = 16;

		}else

			#Filtrando por repuesto...
		if (strlen($_POST['repuesto']) !=0 and strlen($_POST['codigosccu']) == 0 and strlen($_POST['proveedores']) == 0 and strlen($_POST['datepicker']) == 0   ) {
		 		$caso_switch =1;
		 }else

		 	#Filtrando por camion...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) == 0 and strlen($_POST['proveedores']) == 0 and strlen($_POST['datepicker']) == 0) {
		 		$caso_switch =2;
		 }else

		 #Filtrando por proveedor...
		 if (strlen($_POST['proveedores']) !=0 and strlen($_POST['repuesto']) == 0 and strlen($_POST['codigosccu']) == 0 and strlen($_POST['datepicker']) == 0 ) {
		 		$caso_switch =3;
		 }else

		 #Filtrando por fecha...
		 if (strlen($_POST['datepicker']) and strlen($_POST['datepicker2']) != 0 and strlen($_POST['repuesto']) ==0 and strlen($_POST['codigosccu']) == 0 and strlen($_POST['proveedores']) == 0) {
		 	$caso_switch  = 4;
		 }else

		 #Filtrando por camion y repuesto...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) == 0 and strlen($_POST['datepicker']) == 0) {
		 		$caso_switch = 5;
		 }else

		 #Filtrando por fecha y repuesto...
		 if (strlen($_POST['codigosccu']) ==0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) == 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 6;
		 }else
		 #Filtrando por fecha y camion...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) == 0 and strlen($_POST['proveedores']) == 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 7;
		 }else

		 #Filtrando por  camion y proveedores...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) == 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) == 0) {
		 		$caso_switch = 8;
		 }else

		 #Filtrando por fecha, camion y proveedores...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) == 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 9;
		 }else

		 #Filtrando por fecha, proveedores...
		 if (strlen($_POST['codigosccu']) ==0 and strlen($_POST['repuesto']) == 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 10;
		 }else

		 #Filtrando por fecha, camion y repuestos...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) == 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 11;
		 }else

		 #Filtrando por fecha, repuesto y proveedores...
		 if (strlen($_POST['codigosccu']) ==0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 12;
		 }else
 
		 #Filtrando por fecha, camion , repuestos y proveedores...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) != 0) {
		 		$caso_switch = 13;
		 }else

		 #Filtrando por camion, repuesto y proveedores...
		 if (strlen($_POST['codigosccu']) !=0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) == 0) {
		 		$caso_switch = 14;
		 }else

		 #Filtrando por repuesto y proveedores...
		 if (strlen($_POST['codigosccu']) ==0 and strlen($_POST['repuesto']) != 0 and strlen($_POST['proveedores']) != 0 and strlen($_POST['datepicker']) == 0) {
		 		$caso_switch = 15;
		 }else

		if ($f==2) {
			$caso_switch = 17;
		}



		switch ($caso_switch) {
			case '1': # Filtrando solo por repuestos...
				$repuesto = $_POST['repuesto'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_repuesto($repuesto);
			break;

			case '2': # Filtrando solo por codigo camnion...
				$camion = $_POST['codigosccu'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_camion($camion);
				break;
			case '3':# Filtrando solo por proveedores...
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_proveedor($proveedor);
				break;
			case '4':# Filtrando solo por fecha...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha($fecha_inicio, $fecha_termino);
				break;

			case '5':# Filtrando por camion y repuestos...
				$camion = $_POST['codigosccu'];
				$repuesto = $_POST['repuesto'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_camion_repuesto($camion,$repuesto);
				break;

			case '6':# Filtrando por fecha y repuestos...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$repuesto = $_POST['repuesto'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_repuesto($fecha_inicio, $fecha_termino, $repuesto);
				break;

			case '7':# Filtrando por fecha y repuestos...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$camion = $_POST['codigosccu'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_camion($fecha_inicio, $fecha_termino, $camion);
				break;

			case '8':# Filtrando por camion y proveedores...
				$camion = $_POST['codigosccu'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_camion_proveedor($camion, $proveedor);
				break;
					 
			case '9':#Filtrando por fecha, camion y proveedores...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$camion = $_POST['codigosccu'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_camion_proveedor($camion, $proveedor, $fecha_inicio, $fecha_termino);
				break;

			case '10':#Filtrando por fecha, camion y proveedores...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_proveedor($fecha_inicio, $fecha_termino, $proveedor);
				break;

			case '11':#Filtrando por fecha, camion y repuestos...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$camion = $_POST['codigosccu'];
				$repuesto = $_POST['repuesto'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_camion_repuesto($fecha_inicio, $fecha_termino, $camion, $repuesto);
				break;


			case '12': #Filtrando por fecha, repuesto y proveedores...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$repuesto = $_POST['repuesto'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_repuesto_proveedor($fecha_inicio, $fecha_termino,$repuesto, $proveedor);
				break;

			case '13': #Filtrando por fecha, camion , repuestos y proveedores...
				$fecha_inicio = $_POST['datepicker'];
				$fecha_termino = $_POST['datepicker2'];
				$camion = $_POST['codigosccu'];
				$repuesto = $_POST['repuesto'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_fecha_camion_repuesto_proveedor($fecha_inicio, $fecha_termino, $camion, $repuesto, $proveedor);
				break;

			case '14':  #Filtrando por camion, repuesto y proveedores...
				$camion = $_POST['codigosccu'];
				$repuesto = $_POST['repuesto'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_camion_repuesto_proveedor($camion, $repuesto, $proveedor);
				break;
				
			case '15':  #Filtrando por repuesto y proveedores...
				$repuesto = $_POST['repuesto'];
				$proveedor = $_POST['proveedores'];
				$pagina['exportando']=$this->mantenciones_model->filtro_por_repuesto_proveedor($repuesto, $proveedor);
				break;

			case '16':  #Filtrando por fecha hoy...
				$fecha_hoy = date("Y")."-".date("m")."-".date("d");
				$pagina['exportando']=$this->mantenciones_model->filtro_mantencion($fecha_hoy);
				break;
			default:
				$fecha_hoy = date("Y")."-".date("m")."-".date("d");
				$pagina['exportando']=$this->mantenciones_model->filtro_mantencion($fecha_hoy);
				break;
		}
		$pagina['mantenciones'] = $this->mantenciones_model->datos_tablas();
		$pagina['sumatotal'] = $this->mantenciones_model->suma_total();
		$pagina['costo'] = $this->mantenciones_model->costo_mantencion();
		$base['cuerpo'] =$this->load->view('transportes/mantenciones/detalles', $pagina,TRUE);
		$this->load->view('layout2.0/layout',$base); 
	}

	function exportacion_excel(){
		$this->load->view('transportes/mantenciones/ficheroExcel');
	}

	function exportacion(){
		$pagina['mantenciones'] = $this->mantenciones_model->datos_tablas();
		$pagina['sumatotal'] = $this->mantenciones_model->suma_total();
		$pagina['costo'] = $this->mantenciones_model->costo_mantencion();
		$pagina['exportando'] = $this->mantenciones_model->exportacion();
		$this->load->view('transportes/mantenciones/exportacion',$pagina);
	}

	function buscar_repuestos($id_repuesto){ //una ves seleccione un repuesto me muestre el precio  en el modal
		$this->load->model("mantenciones_model");
		$consulta = $this->mantenciones_model->consultar_repuesto($id_repuesto);
		echo json_encode($consulta);
	}

	function guardar_mantencionesss(){
		if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])) {
						$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];
            }else{
            $fecha_v = '0000-00-00';
			}
		if(isset($_POST['ano_f']) && isset($_POST['mes_f']) && isset($_POST['dia_f'])) {
						$fecha_f = $_POST['ano_f'].'-'.$_POST['mes_f'].'-'.$_POST['dia_f'];
            }else{
            $fecha_f = '0000-00-00';
			}
		$data = array(
			'id_cod_ccu'=> $_POST['codigosccu'],
			'id_chofer'=> $_POST['chofer'],
			'id_camion'=> $_POST['camion'],
			'titulo'=> $_POST['titulo'],
			'kilometraje'=> $_POST['kilometraje'],
			'fecha'=> $fecha_v, 
			'fecha_final'=>$fecha_f,					
			'estado'=> 0,
			'eliminado'=>0,
			);
		$this->mantenciones_model->ingresar($data);
		echo "<script>alert('Se han agregado nuevos registros')</script>";
		redirect('transportes/mantenciones', 'refresh');
	}

	function guardar_costo($id_mantencion){
		$costo = $_POST['costo'];
		$data = array(
			'costo'=> $costo,
			);
		$this->mantenciones_model->ingresar_costo($id_mantencion, $data);
		echo "<script>alert('Se ha guardado')</script>";
		redirect('transportes/mantenciones', 'refresh');
	}

	function guardar_submantenciones($idsub){
		$id_mantencion = $_POST['id_mantencion'];
		$data = array(
			'id_mantencion_detalles'=>$idsub,
			'id_repuesto'=>$_POST['repuesto'],
			'id_proveedor'=>$_POST['proveedores'],
			'cantidad'=>$_POST['cantidad'],
			'precio_repuesto'=>$_POST['precio_repuesto'],
			'total'=>$_POST['precio_total'],
			);
		$this->mantenciones_model->ingresar_subdetalles($data);
		echo "<script>alert('Se han agregado nuevos registros')</script>";
		redirect('transportes/mantenciones/agregar_submantencion/'.$id_mantencion.'', 'refresh');
	}

	function guardar_nombre_submantencion(){
		$id_mantencion = $_POST['id_mantencion'];
		$data = array(
			'id_mantenciones'=>$id_mantencion,
			'nombre_submantencion'=>$_POST['nombre_submantencion'],
			'eliminado'=>0,
			);
		$this->mantenciones_model->ingresar_nombre_submantencion($data);
		echo "<script>alert('Se han agregado nuevos registros')</script>";
		redirect('transportes/mantenciones/agregar_submantencion/'.$id_mantencion.'', 'refresh');
	}

	function modal_editar($id){
		$pagina['choferes'] = $this->mantenciones_model->consultar_chofer();
		$pagina['camiones'] = $this->mantenciones_model->consultar_camiones();
		$pagina['codigos'] = $this->mantenciones_model->consultar_codigosccu();
		$pagina['datos_mantenciones']= $this->mantenciones_model->get_mantencion($id);
		$pagina['detalles'] = $this->mantenciones_model->consultar_detalles();
		$this->load->view('transportes/mantenciones/modal_editar_mantenciones', $pagina);
	}

	function modal_editar_detalles($id){
		$pagina['nombre_detalle'] = $this->nombre_mantencion_model->listar();		
		$pagina['proveedores'] = $this->mantenciones_model->consultar_proveedores();
		$this->load->view('transportes/mantenciones/modal_editar_detalles', $pagina);
	}

	function modal_editar_submantencion($id, $id_mantencion){
		$pagina['id_mantencion'] =$id_mantencion;
		$pagina['detalles'] = $this->mantenciones_model->consultar_detalles();
		$pagina['repuestos'] = $this->mantenciones_model->listar_todos_repuestos();
		$pagina['proveedores'] = $this->mantenciones_model->consultar_proveedores();
		$pagina['repuestos_subdetalles'] = $this->mantenciones_model->mantenciones_subdetalles($id);
		$this->load->view('transportes/mantenciones/modal_editar_submantencion',$pagina);
	}

	function modal_editar_nombre_submantencion($idsub, $id_mantencion){
		$pagina['id_mantencion'] =$id_mantencion;
		$pagina['idsub'] = $idsub;
		$pagina['nombre_detalle'] = $this->nombre_mantencion_model->listar();
		$pagina['mantencion_detalle'] = $this->mantenciones_model->listar_nombre_submantencion();
		$pagina['nombre_submantencion'] = $this->mantenciones_model->consultar_nombre_submantencion($idsub);
		$this->load->view('transportes/mantenciones/modal_editar_nombre_submantencion',$pagina);
	}

	function modal_agregar_repuestos($idsub, $id_mantencion){
		$pagina['id_mantencion'] =$id_mantencion;
		$pagina['repuestos'] = $this->mantenciones_model->listar_todos_repuestos();
		$pagina['proveedores'] = $this->mantenciones_model->consultar_proveedores();
		$pagina['idsub'] = $idsub;
		$pagina['nombre_sub'] = $this->mantenciones_model->nombre_submantencion($idsub);
		$this->load->view('transportes/mantenciones/modal_agregar_repuestos',$pagina);
	}

	function actualizar(){	//funcion para actualizar la tabla mantenimientos de la vista gestion que carga el model modal_editar_mantenciones
		 if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])) {
						$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];
	            }else{
	            $fecha_v = '0000-00-00';
				}

		$id = $_POST['id'];
		$data = array(
			'id_cod_ccu'=> $_POST['codigosccu'],
			'id_chofer'=> $_POST['chofer'],
			'id_camion'=> $_POST['camion'],
			'titulo'=> $_POST['titulo'],
			'kilometraje'=> $_POST['kilometraje'],
			'fecha'=> $fecha_v, 					
			'estado'=> 0,
			 );
		$this->mantenciones_model->actualizar_mantenciones($id,$data);	
		echo "<script>alert('Se han actualizado los registros')</script>";
		redirect('transportes/mantenciones', 'refresh');
	}	

	function actualizar_repuestos_submantencion(){
		$id_mantencion = $_POST['id_mantencion']; // recibo la id_mantencion desde un input hidden
		$id=$_POST['id'];
		$data = array(
			'id_repuesto'=>$_POST['repuesto2'],
			'id_proveedor'=>$_POST['proveedor'],
			'cantidad'=>$_POST['cantidad2'],
			'precio_repuesto'=>$_POST['precio'],
			'total'=>$_POST['total'],
			);
		$this->mantenciones_model->actualizar_repuestos_submantencion($id,$data);
		echo "<script>alert('se han actualizado los registros con exito!')</script>";
		redirect('transportes/mantenciones/agregar_submantencion/'.$id_mantencion.'', 'refresh');
	}

	function actualizar_nombre_submantencion(){
		$id_mantencion = $_POST['id_mantencion'];
		$id=$_POST['id'];
		$data = array( 
			'nombre_submantencion'=>$_POST['nombre_submantencion'],
			);
		$this->mantenciones_model->actualizar_nombre_submantencion($id,$data);
		echo "<script>alert('se a modificado el nombre  con exito!')</script>";
		redirect('transportes/mantenciones/agregar_submantencion/'.$id_mantencion.'', 'refresh');
	}

	function eliminar($id){
		$data = array( 
			'eliminado'=>1,
			);
		$this->mantenciones_model->actualizar_mantenciones($id, $data);

		date_default_timezone_set('America/Santiago');
				$auditoria_mantencion = array(
					'tabla_id' => "Mantencion General_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3
					);
				$this->tla_auditoria_registros->eliminar_auditoria_mantencion($auditoria_mantencion);



        redirect( base_url().'transportes/mantenciones', 'refresh');
	}
	function eliminar_repuestos_submantencion($id, $id_mantencion){
		$this->mantenciones_model->eliminar_repuestos_submantencion($id);
		echo "<script>alert('Registro eliminado con exito')</script>";
		redirect('transportes/mantenciones/agregar_submantencion/'.$id_mantencion.'', 'refresh');
	}

	function eliminar_submantencion($id, $id_mantencion){
		$data = array(
			 'eliminado'=>1,
			 );
		$this->mantenciones_model->actualizar_nombre_submantencion($id, $data);
		date_default_timezone_set('America/Santiago');
				$auditoria_mantencion = array(
					'tabla_id' => "Detalles_mantencion_".$id, 
					'usuario_id' => $this->session->userdata('id'),
					'fecha' => date('Y-m-d G:i:s'),
					'accion' => 3
					);
				$this->tla_auditoria_registros->eliminar_auditoria_mantencion($auditoria_mantencion);
		echo "<script>alert('Registro eliminado con exito')</script>";
		redirect('transportes/mantenciones/agregar_submantencion/'.$id_mantencion.'', 'refresh');
	}

	function verificar(){
		if (isset($_POST['eliminar'])){
			foreach($_POST['seleccionar_eliminar'] as $id){	  		
				$this->mantenciones_model->eliminar($id);
			}
		}
		echo "<script>alert('Registro Eliminado')</script>";
		redirect('transportes/mantenciones', 'refresh');
	}
}
?>