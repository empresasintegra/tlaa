<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informes extends CI_Controller {

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
			elseif($this->session->userdata('tipo') == 6 && $this->session->userdata('subtipo') == 112)
				$this->menu = $this->load->view('layout2.0/menus/menu_servicios_transportes_rrhh','',TRUE);
			else
				redirect('/usuarios/login/index', 'refresh');
			$this->load->model('si_camiones_model');
			$this->load->library('calendar');
			$this->load->model('Si_informes_model');
			$this->load->model('todos_los_trabajadores_model');
			$this->load->model('Si_sube_excel');
			$this->load->model('si_inasistentes_model');
			$this->load->model('tla_informe_asistencia');
		}
	}

	public function resumen_preventa_rechazo($fecha = FALSE, $success = FALSE){
		if (!empty($success)){
			$mensaje_exito = "<div class='alert alert-success'> <strong>Se han ingresado los datos Exitosamente.</strong></div>";
		}else{
			$mensaje_exito = "";
		}

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
			'head_titulo' => "Sistema Transporte - Camiones",
			'titulo' => "Informe de Preventa y Rechazo",
			'subtitulo' => '',
			'side_bar' => true,
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 
				'js/si_datepicker_resumen_preventa_rechazo.js','js/confirm.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/lista_usuarios_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'menu' => $this->menu,
			);		
		$month = $mes;
		$year = $ano;

		if($month == '10' and $year == '2016'){
			//$get_ultimo = date("d",(mktime(0,0,0,$month+1,1,$year)-1));
			$ultimo = '31';
			//$nueva_fecha = strtotime('+1 day', strtotime($ultimo));
			//$ultimo = date('d', $nueva_fecha);
		}else{
			$ultimo = date("d",(mktime(0,0,0,$month+1,1,$year)-1));
		}		

		$fechaInicio=strtotime($ano."-".$mes."-01");
		$fechaFin=strtotime($ano."-".$mes."-".$ultimo);

		
		$arr = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$arr[] = date('Y-m-d', $i);      
		}

		$lista_aux = array();
		if (!empty($arr)){
			foreach ($arr as $rm) {
				$aux = new stdClass();
				$get_fecha_preventa = $this->Si_informes_model->consulta_preventa($rm);
				$get_fecha_rechazo = $this->Si_informes_model->consulta_rechazo($rm);
				$aux->fechas = $rm;
				$aux->preventa = (isset($get_fecha_preventa->fecha_preventa))?"1":"0";
				$aux->rechazos = (isset($get_fecha_rechazo->fecha_subida))?"1":"0";
				//$aux->preventa = $get_fecha->fecha_subida;
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$pagina['exito'] = $mensaje_exito;
		$pagina['fecha'] = $fecha_trabajar;
		$base['cuerpo'] = $this->load->view('transportes/informes/preventa_rechazo', $pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function subir_preventa_modal($fechas){
		$pagina['fecha'] = $fechas;
		$this->load->view('transportes/informes/modal_upload_archivo', $pagina);
	}

	function subir_rechazo_modal($fechas){
		$pagina['fecha'] = $fechas;
		$this->load->view('transportes/informes/modal_upload_archivo_rechazo', $pagina);
	}
	//sube preventa 
	function sube_excel($fecha = FALSE){
		/*
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


		$si_existe = $this->Si_sube_excel->consultar_registro($fecha_trabajar);
		//var_dump($si_existe);
		if ($si_existe == 1){
			echo "<script>alert('El registro ingresado ya existe')</script>";
			redirect('transportes/informes/resumen_preventa_rechazo', 'refresh');
		}elseif($si_existe == 0){
			
			$date1 = $fecha_trabajar;*/
			$si_existe = $this->Si_sube_excel->consultar_registro($_POST['fecha']);


		if ($si_existe == 1){
			echo "<script>alert('El registro ingresado ya existe')</script>";
			redirect('transportes/informes/resumen_preventa_rechazo', 'refresh');

		}elseif($si_existe == 0){
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
			$date1 = $_POST['fecha'];

			$this->load->library('PHPExcel');
			$name   = $_FILES['dato']['name'];
			$tname  = $_FILES['dato']['tmp_name']; 
			$obj_excel = new PHPExcel_Reader_Excel5();       
			$obj_excel = PHPExcel_IOFactory::load($tname);
			$obj_excel ->setActiveSheetIndex(1);            
			$numRows = $obj_excel->setActiveSheetIndex(1)->getHighestRow();
			$errores = 0;
			$mensaje_error = array();
			$sw=0;
			for ($i=1; $i <= $numRows; $i++) {
				if ($i != 1) {
					$cd =  $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();   
					$planilla =  $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
					$estado =  $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
					$fecha =  $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
					$transportista =  $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
					$descr_1 =  $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
					$c_camion =  $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue().'G';
					$viaje =  $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
					$zona_entrega =  $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
					$descr_2 =  $obj_excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
					$oficina =  $obj_excel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
					$descr_3 =  $obj_excel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
					$preventista =  $obj_excel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
					$id_cliente =  $obj_excel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
					$rut =  $obj_excel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
					$razon_social =  $obj_excel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
					$calle =  $obj_excel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
					$numero =  $obj_excel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
					$ciudad =  $obj_excel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
					$comuna =  $obj_excel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
					$tipo_factura =  $obj_excel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
					$descr_4 =  $obj_excel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
					$uen =  $obj_excel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
					$rsc =  $obj_excel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
					$categoria =  $obj_excel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
					$marca =  $obj_excel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
					$tamaño =  $obj_excel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
					$producto =  $obj_excel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
					$descr_prod =  $obj_excel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
					$unidad =  $obj_excel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
//cantidad
					$cantidad =  $obj_excel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
					$peso_caja =  $obj_excel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
					$peso_total =  $obj_excel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
					$porc_descuento =  $obj_excel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();
					$valor_linea =  $obj_excel->getActiveSheet()->getCell('AL'.$i)->getCalculatedValue();
					$mensaje_fac =  $obj_excel->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue();
					$mont_anu =  $obj_excel->getActiveSheet()->getCell('AN'.$i)->getCalculatedValue();
					$desc_anulacion =  $obj_excel->getActiveSheet()->getCell('AO'.$i)->getCalculatedValue();
					$fecha_preventa = $date1;

					if($cd != null ) {
						//PREGUNTAR POR DATA CODIGO_ CAMION						
						//pregunto por codigo de camion
						if ($c_camion[0] != "S") {			
							array_push($mensaje_error, "Se ha encontrado el siguiente error: ".$c_camion[0].$c_camion[1].$c_camion[2] ." En la Celda ". $c_camion[3]."-".$i);
							$errores ++;							
						}elseif (!is_numeric($viaje)) {//vuelta camion
							array_push($mensaje_error, "Se ha encontrado el siguiente error: " .$viaje. " En la Celda H- " .$i. " No es Numerico ");
							$errores++;
						}elseif (!is_numeric($cantidad)) {//cantidad cajas
							array_push($mensaje_error, "Se ha encontrado el siguiente error: " .$cantidad. " En la Celda AH- " .$i. " No es Numerico ");								
							$errores ++;	
						}
					}
				}
			}
			
			if ($errores == 0) {
				for ($i=1; $i <= $numRows; $i++) {
					if ($i != 1) {

						$cd =  $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();   
						$planilla =  $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
						$estado =  $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
						$fecha =  $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();

						$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha_php = date('Y-m-d',$timestamp);	
							// agregarle un dia
							$fecha_excel = strtotime('+1 day' , strtotime($fecha_php));
							$get_fecha = date('Y-m-d', $fecha_excel);
						if($sw==0){
							$fecha_resumen_preventa= $fecha_php;
							$sw=1;
						}
						$transportista =  $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
						$descr_1 =  $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
						$c_camion =  $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
						$viaje =  $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
						$zona_entrega =  $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
						$descr_2 =  $obj_excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
						$oficina =  $obj_excel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
						$descr_3 =  $obj_excel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
						$preventista =  $obj_excel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
						$id_cliente =  $obj_excel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
						$rut =  $obj_excel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
						$razon_social =  $obj_excel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
						$calle =  $obj_excel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
						$numero =  $obj_excel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
						$ciudad =  $obj_excel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
						$comuna =  $obj_excel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
						$tipo_factura =  $obj_excel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
						$descr_4 =  $obj_excel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
						$uen =  $obj_excel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
						$rsc =  $obj_excel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
						$categoria =  $obj_excel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
						$marca =  $obj_excel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
						$tamaño =  $obj_excel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
						$producto =  $obj_excel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
						$descr_prod =  $obj_excel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
						$unidad =  $obj_excel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
						//cantidad
						$cantidad =  $obj_excel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
						$peso_caja =  $obj_excel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
						$peso_total =  $obj_excel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
						$porc_descuento =  $obj_excel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();
						$valor_linea =  $obj_excel->getActiveSheet()->getCell('AL'.$i)->getCalculatedValue();
						$mensaje_fac =  $obj_excel->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue();
						$mont_anu =  $obj_excel->getActiveSheet()->getCell('AN'.$i)->getCalculatedValue();
						$desc_anulacion =  $obj_excel->getActiveSheet()->getCell('AO'.$i)->getCalculatedValue();
						$fecha_preventa = $date1;

						if($cd != null ) {
							$datos = array(
								'cd' => $cd,
								'planilla' => $planilla,
								'estado' => $estado,
								'fecha' => $get_fecha,               
				                'transportista' => $transportista,
				                'descr_1' => $descr_1,
				                'c_camion' => $c_camion,
				                'viaje' => $viaje,
				                'zona_entrega' => $zona_entrega,
				                'descr_2' => $descr_2,
				                'oficina' => $oficina,
				                'descr_3' => $descr_3,
				                'preventista' => $preventista,
				                'id_cliente' => $id_cliente,
				                'rut' => $rut,
				                'razon_social' => $razon_social,
				                'calle' => $calle,
				                'numero' => $numero,
				                'ciudad' => $ciudad,
				                'comuna' => $comuna,
				                'tipo_factura' => $tipo_factura,
				                'descr_4' => $descr_4,
				                'uen' => $uen,
				                'rsc' => $rsc,
				                'categoria' => $categoria,
				                'marca' => $marca,
				                'tamaño' => $tamaño,
				                'producto' => $producto,
				                'descr_prod' => $descr_prod,
				                'unidad' => $unidad,
				                'cantidad' => $cantidad,
				                'peso_caja' => $peso_caja,
				                'peso_total' => $peso_total,
				                'porc_descuento' => $porc_descuento,
				                'valor_linea' => $valor_linea,
				                'mensaje_fac' => $mensaje_fac,
				                'mont_anu' => $mont_anu,
				                'desc_anulacion' => $desc_anulacion,
				                'fecha_preventa' =>$fecha_preventa,
								);
							$this->Si_sube_excel->insert($datos);
						}
					}
				}
				echo $fecha_resumen_preventa;
				//agrupar_cajas_por_camion
				$agrupar_camion_preventa = $this->Si_sube_excel->agrupar_cajas_preventa($fecha_resumen_preventa);
				foreach ($agrupar_camion_preventa as $agrupar) {
					$resumen_prenvetas = array('camion' => $agrupar->camion,
						'cajas' => $agrupar->cajas,
						'fecha_registro' => $agrupar->fecha,
						'clientes' => $agrupar->clientes 
						);
					$this->Si_sube_excel->guardar_preventa($resumen_prenvetas);
				} 	
				//$success = "Se han ingresado los datos Exitosamente!!"; 
			 	redirect('/transportes/informes/resumen_preventa_rechazo/'.$fecha_preventa.'/exito','refresh');
			}else{
				foreach ($mensaje_error as $key => $value) {
					unset($mensaje_error[$key + 1]); 
					echo $value . PHP_EOL."<br>";

				}
				echo "<a href='".base_url()."transportes/informes/resumen_preventa_rechazo'>Volver</a>";
			}	
		}
	}

	//sube rechazo excel
	function inserta_rechazo($fecha2 = FALSE){
		$this->load->model('si_sube_excel');
		$this->load->model('si_codigos_model');
		$si_existe1 = $this->si_sube_excel->consultar_registro_rechazo($_POST['fecha2']);
		//var_dump($si_existe1);

		if ($si_existe1 == 1){
			echo "<script>alert('El registro ingresado ya existe')</script>";
			redirect('transportes/informes/resumen_preventa_rechazo', 'refresh');

		}elseif($si_existe1 == 0){
			$fecha_hoy = date('Y-m-d');
			//var_dump($fecha_hoy);
			if (empty($fecha)){
				$fecha_unir = $fecha_hoy;
			}else{
				$fecha_unir = $fecha2;
			}
			//var_dump($fecha_unir);
			$f = explode('-', $fecha_unir);
			$ano = $f[0];
			$mes = $f[1];
			$dia = $f[2];
			$conector = "-";
			$fecha_trabajar = $ano.$conector.$mes.$conector.$dia;
			//var_dump($fecha_trabajar);
			$date1 = $_POST['fecha2'];
            //var_dump($date1);
			$this->load->library('excel');
			$name   = $_FILES['dato']['name'];
			$tname  = $_FILES['dato']['tmp_name'];        
			$obj_excel = PHPExcel_IOFactory::load($tname);
			$obj_excel ->setActiveSheetIndex(1);            
			$numRows = $obj_excel->setActiveSheetIndex(1)->getHighestRow();
			$errores_rechazo_cuenta = 0;
			$sw=0;
			$errores_rechazo = array();
			for ($i=1; $i <= $numRows; $i++) {
				if ($i != 1) {                         
					$uen =  $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();   
					$oficina_comercial =  $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
					$cod_motivo =  $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
					$motivo =  $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
					$vendedor =  $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
					$cod_cliente =  $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
					$cliente =  $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
					$rut =  $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
					$domicilio =  $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
					$camion =  $obj_excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
					$carga =  $obj_excel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
					$sector =  $obj_excel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
					$tf =  $obj_excel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
					$anula_rebaja =  $obj_excel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
					$categoria =  $obj_excel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
					$fecha_factura =  $obj_excel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
					$facturas =  $obj_excel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
					$ncr =  $obj_excel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
					$total =  $obj_excel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
					$producto =  $obj_excel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
					$suma_de_cajas =  $obj_excel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
					$empresario =  $obj_excel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
					$fecha_rechazo =  $date1;

					if($uen != null ) {
						//PREGUNTAR POR DATA CODIGO_ CAMION						
						//pregunto por codigo de camion
						if ($camion[0] != "S") {			
							array_push($errores_rechazo, "Se ha encontrado el siguiente error: ".$camion[0].$camion[1].$camion[2] ." En la Celda ". $camion[3]."-".$i);
							$errores_rechazo_cuenta ++;							
						}elseif (!is_numeric($carga)) {//vuelta camion
							array_push($errores_rechazo, "Se ha encontrado el siguiente error: " .$carga. " En la Celda K- " .$i. " No es Numerico ");
							$errores_rechazo_cuenta++;
						}elseif (!is_numeric($suma_de_cajas)) {//cantidad cajas
							array_push($errores_rechazo, "Se ha encontrado el siguiente error: " .$suma_de_cajas. " En la Celda U- " .$i. " No es Numerico ");								
							$errores_rechazo_cuenta ++;	
						}
					}
				}
			}
			//echo $errores_rechazo_cuenta;
			if ($errores_rechazo_cuenta == 0) {
				for ($i=1; $i <= $numRows; $i++) {
					if ($i != 1) {                         

						$uen =  $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();   
						$oficina_comercial =  $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
						$cod_motivo =  $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
						$motivo =  $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
						$vendedor =  $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
						$cod_cliente =  $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
						$cliente =  $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
						$rut =  $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
						$domicilio =  $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
						$camion =  $obj_excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
						$carga =  $obj_excel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
						$sector =  $obj_excel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
						$tf =  $obj_excel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
						$anula_rebaja =  $obj_excel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
						$categoria =  $obj_excel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
						$fecha_factura =  $obj_excel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
							$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha_factura);
							$fecha_php = date('Y-m-d',$timestamp);	
							/*	$a = explode('-', $fecha_php);
								$ano = $a[0];
								$mes = $a[1];
								$dia = $a[2]+1;
								$conector = "-";
								$fecha_excel = $ano.$conector.$mes.$conector.$dia;*/
								$fecha_excel = strtotime('+1 day' , strtotime($fecha_php));
								$get_fecha = date('Y-m-d', $fecha_excel);
								//var_dump($get_fecha);
								if($sw==0){
									$fecha_resumen_rechazo= $get_fecha;
									$sw=1;
								}
						
						$facturas =  $obj_excel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
						$ncr =  $obj_excel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
						$total =  $obj_excel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
						$producto =  $obj_excel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
						$suma_de_cajas =  $obj_excel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
						$empresario =  $obj_excel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
						$fecha_rechazo =  $date1;

						$f_real=date("d")."-".date("m")."-".date("Y")."".strftime(" a las %H:%M");
						if($uen != null ) {
							//if($cod_motivo == 612 || $cod_motivo == 360 || $cod_motivo == 352 || $cod_motivo == 400 || $cod_motivo == 321){
								$datos = array (
			                        'uen' => $uen, 
			                        'oficina_comercial' => $oficina_comercial,
			                        'cod_motivo' => $cod_motivo,
			                        'motivo' => $motivo, 
			                        'vendedor' => $vendedor, 
			                        'cod_cliente' => $cod_cliente, 
			                        'cliente' => $cliente, 
			                        'rut' => $rut, 
			                        'domicilio' => $domicilio, 
			                        'camion' => $camion, 
			                        'carga' => $carga, 
			                        'sector' => $sector,
			                        'tf' => $tf, 
			                        'anula_rebaja' => $anula_rebaja, 
			                        'categoria' => $categoria, 
			                        'fecha_factura' => $get_fecha, 
			                        'facturas' => $facturas, 
			                        'ncr' => $ncr, 
			                        'total' => $total, 
			                        'producto' => $producto,
			                        'suma_de_cajas' => $suma_de_cajas, 
			                        'empresario' => $empresario,
			                        'fecha_subida' => $fecha_rechazo,
			                        'fecha_real'=> $f_real,
								);
								$this->Si_sube_excel->inserta_rechazo($datos);
							//}
						}
					}
				}

				$agrupar_rechazo = $this->Si_sube_excel->agrupar_cajas_rechazo($fecha_resumen_rechazo);
				foreach ($agrupar_rechazo as $agrupar) {
					$resumen_rechazos = array(
						'camion' => $agrupar->camion,
						'cajas' => $agrupar->cajas,
						'fecha_registro' => $agrupar->fecha,
						'clientes' => $agrupar->clientes,
						'carga' => $agrupar->vuelta,
						);
//EDIT 04-10-2017 se agrego un dia a la fecha para el resumen de rechazos
					$this->Si_sube_excel->guardar_rechazo($resumen_rechazos);

					$get_id_camion = $this->si_codigos_model->obtener_id_codigo($agrupar->camion);
                  	$id_camion = isset($get_id_camion->idcodigos_ccu)?$get_id_camion->idcodigos_ccu:'0';
					$vuelta_fecha = $this->si_sube_excel->consultar_vuelta($agrupar->vuelta, $agrupar->fecha, $id_camion);

					$id_registro_produccion = isset($vuelta_fecha->id)?$vuelta_fecha->id:"0";
					$get_registro_produccion = $this->si_sube_excel->get_registro_produccion($id_registro_produccion);
					if ($get_registro_produccion->id_ruta != 0) { //02-05-2018 si el id_ruta es 0 en ingreso_producciones es porque no tiene produccion
							$cajas_reales = isset($get_registro_produccion->caja_reales)?$get_registro_produccion->caja_reales:"0";
							$clientes_reales = isset($get_registro_produccion->cliente_reales)?$get_registro_produccion->cliente_reales:"0";
							$cajas_anteriores = $cajas_reales; // variable para guardar el numero de cajas reales antes de modificarse
							$clientes_anteriores = $clientes_reales; // variable para guardar el numero de cajas reales antes de modificarse
							$get_cajas_actualizadas = $cajas_reales - $agrupar->cajas;
				
							if ($get_cajas_actualizadas <= 0) { //condicion if en caso de cajas reales ser 0 
								$cajas_actualizadas = 0;
							}else{	
								$cajas_actualizadas = $cajas_reales - $agrupar->cajas;
							 }
							/*##	SE RESTAN CLIENTES SOLO SI LOS RECHAZOS CUMPLEN LOS SIGUIENTES MOTIVOS##*/
						 	if($agrupar->cod_motivo == 612 || $agrupar->cod_motivo == 360 || $agrupar->cod_motivo == 352 || $agrupar->cod_motivo == 400 || $agrupar->cod_motivo == 321){
								$clientes_actualizados = $clientes_reales - $agrupar->clientes;
								if ($clientes_actualizados==0) {
									$clientes_actualizados = 1;
								}
							}else{
								$clientes_actualizados=$clientes_anteriores;
							}
						/*********************BONO $350 **********************************/

							if($agrupar->cajas == 0 or $cajas_anteriores == 0){
								$pagarBono = 0;
							}else{
								$resultadoBono = ($agrupar->cajas / $cajas_anteriores);
								if ($resultadoBono <= 0.01) {
									$pagarBono = 1;
								}else{
									$pagarBono = 0;
								}
							}

								$datass = array(
									'caja_rechazo' =>$agrupar->cajas,
									'cliente_rechazo' =>$agrupar->clientes,
									'cajas_original' =>$cajas_anteriores,
									'caja_reales' =>$cajas_actualizadas,
									'cliente_reales'=>$clientes_actualizados,
									'cliente_original'=>$clientes_anteriores,
									'bono_rechazo'=>$pagarBono,
									);
									$this->si_sube_excel->actualizar_ingreso_produccion($id_registro_produccion, $datass);
					}
					/*una vez cargado los rechazo Tomo  la fecha del excel que afectara a la tabla ingreso produccion y le cambio su estado de cierre de esta manera  no se podra editar las cajas y clientes */
					$estado = array(
						'estado_cierre'=>1,
						);
					$this->Si_sube_excel->cambiar_estado($fecha_resumen_rechazo,$estado);
/*********************BONO RECHAZO*****************************************************/		
				$get_registro_produccion = $this->si_sube_excel->get_registro_produccions($id_registro_produccion);
				//var_dump($get_registro_produccion);
				foreach ($get_registro_produccion as $key) {
					$p1 = $key->id_chofer;
					$p2 = $key->id_ayudante_1;
					$p3 = $key->id_ayudante_2;
					$p4 = $key->id_ayudante_3;
				}
				//echo $p1."-".$p2."-".$p3."-".$p4;
				
					if (!empty($p1) && $pagarBono) {
						$data = ['id_trabajador'=>$p1,'vuelta'=>$agrupar->vuelta, 'fecha_bono'=>$agrupar->fecha];
						$this->si_sube_excel->setBonoRechazo($data);	
					}
					if (!empty($p2) && $pagarBono) {
						$data = ['id_trabajador'=>$p2,'vuelta'=>$agrupar->vuelta, 'fecha_bono'=>$agrupar->fecha];
						$this->si_sube_excel->setBonoRechazo($data);	
					}
					if (!empty($p3) && $pagarBono) {
						$data = ['id_trabajador'=>$p3,'vuelta'=>$agrupar->vuelta, 'fecha_bono'=>$agrupar->fecha];
						$this->si_sube_excel->setBonoRechazo($data);
					}
					if (!empty($p4) && $pagarBono) {
						$data = ['id_trabajador'=>$p4,'vuelta'=>$agrupar->vuelta, 'fecha_bono'=>$agrupar->fecha];
						$this->si_sube_excel->setBonoRechazo($data);		
					}	
/*********************FIN BONO RECHAZO*****************************************************/									
			} 				
				redirect('/transportes/informes/resumen_preventa_rechazo/'.$fecha_rechazo.'/exito','refresh');
			}else{
				foreach ($errores_rechazo as $key => $value) {
					unset($errores_rechazo[$key + 1]); 
					echo $value . PHP_EOL."<br>";
				}
				echo "<a href='".base_url()."transportes/informes/resumen_preventa_rechazo'>Volver</a>";
			}
			echo "<script>alert('Se han ingresado los datos Exitosamente!!')</script>";
			redirect('/transportes/informes/resumen_preventa_rechazo','refresh');
		}
	}

	function hola(){
		$this->load->model('si_sube_excel');
		$fecha = '2017-11-16';
		$id_registro_produccion=42001;
		$get_registro_produccion = $this->si_sube_excel->get_registro_produccions($id_registro_produccion);
		var_dump($get_registro_produccion);
		$p1 =134;
		$p2 = 0;
		$p3 = 2;
		$p4 = 0;
		echo $p1."-".$p2."-".$p3."-".$p4."<br>";
				$p= "N/D";
				$o= 10 / 0;
				echo $o;
		$pagarBono = 0;

			if (!empty($p1) && $o) {
				echo "entre 1";
			}
		$pagpagarBono= 1;
			if (!empty($p2)) {
				echo "entre2";
			}
			if (!empty($p3)) {
				echo "entre3";
				$data = ['name'=>$o];
			$this->si_sube_excel->prueba($data);	


			}
			if (!empty($p4)) {
				echo "entre4";
			}/*
SELECT COUNT(persona.id) as id, rut , nombre, apellido_paterno, apellido_materno FROM `bono_rechazos`
INNER JOIN persona on bono_rechazos.id_trabajador = persona.id  
ORDER BY `persona`.`id` ASC = 40

			SELECT persona.id as id, rut , nombre, apellido_paterno, apellido_materno FROM `bono_rechazos`
INNER JOIN persona on bono_rechazos.id_trabajador = persona.id  
ORDER BY `persona`.`id` ASC


*/
	}

/*	function rechazos_2017(){
		   $this->load->model('si_sube_excel');
	      /* $fecha_inicio = "2017-06-01";
	       $fecha_termino = "2017-06-13";* /
	       $rechazos_junio = $this->si_sube_excel->consultar_rechazos_junio();
	       foreach ($rechazos_junio as $key){
	                       $consulta1 = $this->si_sube_excel->consultar_id_sccu($key->camion);
	                       $id_camion_en_reg_produccion = isset($consulta1->idcodigos_ccu)?$consulta1->idcodigos_ccu:'0';
	                       $consulta_registro_ccu = $this->si_sube_excel->consultar_vuelta($key->carga, $key->fecha,  $id_camion_en_reg_produccion);
	                       $id_registro_produccion = isset($consulta_registro_ccu->id)?$consulta_registro_ccu->id:"0";
	                       //var_dump($id_registro_produccion);
	                       $get_registro_produccion = $this->si_sube_excel->get_registro_produccion($id_registro_produccion);

	                       $cajas_reales = isset($get_registro_produccion->caja_reales)?$get_registro_produccion->caja_reales:"0";
	                       $clientes_reales = isset($get_registro_produccion->cliente_reales)?$get_registro_produccion->cliente_reales:"0";

	                       //$cajas_anteriores = $cajas_reales; // variable para guardar el numero de cajas reales antes de modificarse
						   //$clientes_anteriores = $clientes_reales; // variable para guardar el numero de cajas reales antes de modificarse

						   $get_cajas_actualizadas = $cajas_reales - $key->cajas;
						   $get_clientes_actualizados = $clientes_reales - $key->clientes;
				
							if ($get_cajas_actualizadas <= 0) {
								$cajas_actualizadas = 0;   
							}else{	
								$cajas_actualizadas = $get_cajas_actualizadas;
							 }

							 if ($get_clientes_actualizados <= 0) {
							 	$clientes_actualizados = 0;
							 }
							 else{
								$clientes_actualizados = $get_clientes_actualizados;
								}
	                        $datos_ingreso_rechazos = array(
	                                       'caja_rechazo' => $key->cajas,
	                                       'cliente_rechazo' => $key->clientes,
	                                       'caja_reales' => $cajas_actualizadas,
	                                       'cliente_reales' => $clientes_actualizados,
	                                       'cajas_original' => $cajas_reales,
	                                       'cliente_original' => $clientes_reales,
	                       );
	                       $this->si_sube_excel->actualizar_ingreso_produccion($id_registro_produccion, $datos_ingreso_rechazos);
	                       //var_dump($datos_ingreso_rechazos);
	       }
	       //var_dump($rechazos_junio);
	}*/

	function asistencia($fecha = FALSE){
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
			'head_titulo' => "Sistema Transporte - Camiones",
			'titulo' => "Informe de Asistencia Diaria",
			'subtitulo' => '',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_rango_fechas.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/lista_usuarios_req.js','js/si_selecciona_rango_fecha.js'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Informe De Asistencia Diaria ')),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'menu' => $this->menu,
			);
		$pagina['inasistentes'] = $this->si_inasistentes_model->consultar_trabajadores_inasistentes($fecha_trabajar);
		$pagina['fecha'] = $fecha_trabajar;
		$base['cuerpo'] = $this->load->view('transportes/informes/asistencia', $pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);

	}

	function generar_informe_asistencia($fecha = FALSE){
		$this->load->library('PHPExcel');
		$this->load->library('zip');
		$this->load->helper('download');
		$fecha_hoy = date('Y-m-d');
		if (empty($fecha))	{
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
		$mes_periodo = $f[1];
		$ano_periodo = $f[0];

		if($mes_periodo == 1){
			$nombre_mes = "Enero";
			$nombre_mes_anterior = "Diciembre";
		}elseif ($mes_periodo == 2){
			$nombre_mes = "Febrero";
			$nombre_mes_anterior = "Enero";
		}elseif($mes_periodo == 3){
			$nombre_mes = "Marzo";
			$nombre_mes_anterior = "Febrero";
		}elseif($mes_periodo == 4){
			$nombre_mes = "Abril";
			$nombre_mes_anterior = "Marzo";
		}elseif($mes_periodo == 5){
			$nombre_mes = "Mayo";
			$nombre_mes_anterior = "Abril";
		}elseif($mes_periodo == 6){
			$nombre_mes = "Junio";
			$nombre_mes_anterior = "Mayo";
		}elseif($mes_periodo == 7){
			$nombre_mes = "Julio";
			$nombre_mes_anterior = "Junio";
		}elseif($mes_periodo == 8){
			$nombre_mes = "Agosto";
			$nombre_mes_anterior = "Julio";
		}elseif($mes_periodo == 9){
			$nombre_mes = "Septiembre";
			$nombre_mes_anterior = "Agosto";
		}elseif($mes_periodo == 10){
			$nombre_mes = "Octubre";
			$nombre_mes_anterior = "Septiembre";
		}elseif($mes_periodo == 11){
			$nombre_mes = "Noviembre";
			$nombre_mes_anterior = "Octubre";
		}elseif($mes_periodo == 12){
			$nombre_mes = "Diciembre";
			$nombre_mes_anterior = "Noviembre";
		}else{
			$nombre_mes = " ";
			$nombre_mes_anterior = " ";
		}

		$periodo = $nombre_mes.$conector.$ano_periodo;

		$month = $mes;
		$year = $ano;
		$ultimo = date("d",(mktime(0,0,0,$month+1,1,$year)-1));

		$f_inicio= $ano."-".$mes."-01";
		$f_termino= $ano."-".$mes."-".$ultimo;

		$fechaInicio=strtotime($ano."-".$mes."-01");
		$fechaFin=strtotime($ano."-".$mes."-".$ultimo);

		$trab = 0;
	
		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$archivo = "extras/tla_excel/asistencia.xlsx";
		$objPHPExcel = $objReader->load(BASE_URL2.$archivo);

		$todos_los_trabajadores = $this->tla_informe_asistencia->todos_los_trabajadores($f_inicio, $f_termino);
		//var_dump($todos_los_trabajadores);
		$a = 10;
		$b = 9;
		$z = 10;

		/*
		if($ano == '2016' and $mes == '10'){
			$nuevafecha = strtotime ('+1 day', strtotime($fechaFin));
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		}elseif($ano == '2017' and $mes == '03'){
			$nuevafecha = strtotime ('+1 day', strtotime($fechaFin));
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		}elseif($ano == '2017' and $mes == '08'){
			$nuevafecha = strtotime ('+1 day', strtotime($fechaFin));
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		}else{
			$nuevafecha = $fechaFin;
		}
		*/

		$fecha_inicio2 = strtotime($fechaInicio);
		$fecha_termino2 = strtotime($fechaFin);

		$get_fechas_produccion = array();
		$dia_once = 0;
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
			/*if(date('Y-m-d', $i) == '2018-05-12'){
				if($dia_once == 0){
					$fechas_produccion[] = date('Y-m-d', $i);
				}
				$dia_once += 1;
			}else{
				$fechas_produccion[] = date('Y-m-d', $i);
			}*/
			$get_fechas_produccion[] = date('Y-m-d', $i);
		}

	$dia_31 = array($i = '2018-08-31');
	$fechas_produccion = array_merge($get_fechas_produccion, $dia_31);

		//var_dump($fechas_produccion);

		if (!empty($todos_los_trabajadores)){
			foreach ($todos_los_trabajadores as $trabajadores) {
				$trab += 1;
				$x = 0;			

				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, $trabajadores->rut);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $trabajadores->nombre." ".$trabajadores->ap." ".$trabajadores->am );
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $trabajadores->n_cargo);

				$letras = array('D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL');


				if (!empty($fechas_produccion)){
					foreach ($fechas_produccion as $f) {

						$objPHPExcel->getActiveSheet()->SetCellValue($letras[$x].$b,$f);
						
						$obtener_asistencia_trabajador = $this->tla_informe_asistencia->obtener_asistencia($f, $trabajadores->id);

						$estado_asistencia = isset($obtener_asistencia_trabajador->estado)?$obtener_asistencia_trabajador->estado:'';

						$objPHPExcel->getActiveSheet()->SetCellValue($letras[$x].$z,$estado_asistencia);
								
						$x+=1;
					}
				}
				$z++;
				$a++;	
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save(BASE_URL2."extras/tla_excel/informes/asistencia".$periodo.".xlsx");
		}

		$path = BASE_URL2.'/extras/tla_excel/informes/';
		$this->zip->read_dir($path, FALSE);
		$carpeta = BASE_URL2.'/extras/tla_excel/informes/';

		if (file_exists($carpeta)){
			foreach(glob($carpeta . "/*") as $archivos_carpeta){
				if (is_dir($archivos_carpeta)){
				}else{
					unlink($archivos_carpeta);
				}
			}
		}
		$this->zip->download("informe_asistencia_".$periodo."_descarga.zip");
		redirect('transportes/informes/asistencia','refresh');
	}

	function modal_editar($id, $fecha = false){
		$pagina['id_trabajador'] = $id;
		$pagina['fecha'] = $fecha; 
		$this->load->view('transportes/informes/modal_editar_asistencia', $pagina);
	}

	function guardar_inasistencias(){
		/*foreach($_POST['id_trabajador'] as $c => $valores) {
			if (!empty($_POST['comentario'][$c])) {
				$id_trabajador = $_POST['id_trabajador'][$c];
				$fecha_trabajar = $_POST['fecha_trabajar'][$c];
				$vuelta = $_POST['vuelta'][$c];
				$id_ccu = $_POST['id_ccu_oculto'][$c];
				$guarda_inasistentes = array('tipo_falta' => $_POST['id_select_inasistencia'][$c],
					'comentarios' => $_POST['comentario'][$c],
					'estado' => 2,
					);
			}
		}*/
		$id_trabajador = $_POST['id_trabajador'];
		$fecha = $_POST['fecha'];
		$editar_inasistencia = array('tipo_falta' => $_POST['id_select_inasistencia'],
			'comentarios' => $_POST['comentario']);

		$this->si_inasistentes_model->guardar_tipo_inasistencia($editar_inasistencia, $id_trabajador, $fecha);

		redirect('transportes/informes/asistencia/'.$fecha.'', 'refresh');
	}

}

/* End of file informes.php */
/* Location: ./application/modules/transportes/controllers/informes.php */