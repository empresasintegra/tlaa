<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resumen extends CI_Controller {

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
			$this->load->model('personal_model');
			$this->load->model('t_genera_liquidaciones');
			
		}
	}

function pruebaqla(){
	
$fecha1 = "2018-08-01";
$fecha2 = "2018-08-33";

for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
   // echo $i . "<br />";
    $fechas_produccion[]= $i;
 //aca puedes comparar $i a una fecha en la bd y guardar el resultado en un arreglo

}
var_dump($fechas_produccion);

}


/*function liquidacion(){

	$this->load->model('tla_tabla_resumen');

 $fecha_inicio1 = new DateTime('first day of previous month');
 $fecha_inicio = $fecha_inicio1->format('Y-m-d') ;
 var_dump($fecha_inicio);

 $fecha_termino1 = new DateTime('last day of previous month');
 $fecha_termino = $fecha_termino1->format('Y-m-d');
 var_dump($fecha_termino);

$d_habiles = $this->tla_tabla_resumen->traer_dias_habiles($fecha_inicio,$fecha_termino);
 foreach ($d_habiles as $dias_h){
            	$dias_habiles = $dias_h;
            }
var_dump($dias_habiles);






}*/

	public function resumen_produccion(){
		$base = array(
			'head_titulo' => "Sistema Transporte - Producción",
			'titulo' => "Informe de Producción",
			'subtitulo' => '',
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this->menu,
			);

		$pagina['listado_seleccion'] = $this->personal_model->listar();
		$base['cuerpo'] = $this->load->view('transportes/resumen/resumen_produccion', $pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	public function genera_informe_produccion(){
		$this->load->library('PHPExcel');
		$this->load->library('zip');
		$this->load->helper('download');

		$espacio = " ";
		$trab = 0;
		$fecha_inicio = $_POST['datepicker'];
		$fecha_termino = $_POST['datepicker2'];
		$dias_habiles = $_POST['dias_laborales'];

		$fechaInicio=strtotime($fecha_inicio);
		$fechaFin=strtotime($fecha_termino);

		if ($fechaInicio > $fechaFin){
			echo "<script>alert('Debe ingresar una fecha mayor a la fecha de inicio')</script>";
			redirect('transportes/resumen/resumen_produccion','refresh');
		}

		if($dias_habiles != 0 and $dias_habiles != NULL){
			$dinero_bono_ruta = round(40000 / $dias_habiles);
		}else{
			$dinero_bono_ruta = 0;
		}

		/*$f2 = explode("-", $fecha_termino);
		$ano2 = $f2[0];
		$mes2 = $f2[1];

		/*if($ano2 == '2016' and $mes2 == '10'){
			$nuevafecha = strtotime ('+1 day', strtotime($fecha_termino));
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		}elseif($ano2 == '2017' and $mes2 == '03'){
			$nuevafecha = strtotime ('+1 day', strtotime($fecha_termino));
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	    }elseif($ano2 == '2018' and $mes2 == '08'){
			$nuevafecha = strtotime ('+1 day', strtotime($fecha_termino));
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		}else{
			$nuevafecha = $fecha_termino;
		}

		//$fecha_inicio2 = strtotime($fecha_inicio);
		//$fecha_termino2 = strtotime($nuevafecha);

		$fechas_produccion = array();
		/*$dia_once = 0;
		for($i=$fecha_inicio2; $i<=$fecha_termino2; $i+=86400){
			if(date('Y-m-d', $i) == '2018-05-12'){
				if($dia_once == 0){
					$fechas_produccion[] = date('Y-m-d', $i);
				}
				$dia_once += 1;
			}else{
				$fechas_produccion[] = date('Y-m-d', $i);
			}    
		}*/



		for($i=$fecha_inicio;$i<=$fecha_termino;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
		   // echo $i . "<br />";
		    $fechas_produccion[]= $i;
		}
		//var_dump($fechas_produccion);

		if (!empty($_POST['usuarios'])){ //O
			foreach($_POST['usuarios'] as $row=>$valores){ //O
				//faltas peoneta 
				$contador_faltas = 0;
				$contador_faltas_2 = 0;
				$contador_faltas_peoneta_sin_nada = 0;
				//faltas chofer	
				$contador_faltas_chofer = 0;
				$contador_faltas_chofer_2 = 0;
				$contador_faltas_chofer_sin_nada = 0;
				//vueltas adicionales chofer
				$contador_vueltas_adicionales = 0;
				$contador_vueltas_adicionales_2 = 0;
				$contador_vueltas_adicionales_sin_nada = 0;
				//vueltas adicionales peoneta
				$contador_vueltas_adicionales_peoneta = 0;
				$contador_vueltas_adicionales_peoneta_2 = 0;
				$contador_vueltas_adicionales_peoneta_sin_nada = 0;

				$trab += 1;

				$data = $this->t_genera_liquidaciones->generar_liquidaciones($valores);
				$cargo = isset($data->cargo)?$data->cargo:'';
				$convenio = isset($data->convenio)?$data->convenio:'';

				//var_dump($data);
				//var_dump($cargo);
				//var_dump($convenio);
                       
                      

				//chofer_sindicato_antiguo
				if ($cargo == 72 and $convenio == 21) { //0

					$objPHPExcel = new PHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$archivo = "extras/tla_excel/liquidacion_chofer_sindicato_conv_antiguo.xlsm";
					$objPHPExcel = $objReader->load(BASE_URL2.$archivo);

					//datos_chofer
					$nombre_completo = $data->nombre.$espacio.$data->ap.$espacio.$data->am;
					$rut = $data->rut;
					$cargo = isset($data->n_cargo)?$data->n_cargo:'';
					$fecha_actual = date('d-m-Y');

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(0);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(1);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$a = 16;

					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);
					$contador_faltas_chofer = $get_faltas_trabajador->faltas;
				
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, $f);
						}
					}


					//$vueltas_adicionales_registradas = $this->t_genera_liquidaciones->get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino);
					//$contador_vueltas_adicionales = $vueltas_adicionales_registradas->vueltas;
					
					$objPHPExcel->getActiveSheet()->SetCellValue('T8', $contador_faltas_chofer);

					/*if ($contador_faltas_chofer >= $contador_vueltas_adicionales) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}elseif ($contador_faltas_chofer < $contador_vueltas_adicionales) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}*/

					if (!empty($fechas_produccion)){ 
						foreach ($fechas_produccion as $f) { 
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, $f);
							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							$chofer_produccion_pallets_2 = 0;
							$chofer_vuelta_adicional_pallets_2 = 0;
							$chofer_produccion_pallets_6 = 0;
							$chofer_vuelta_adicional_pallets_6 = 0;
							$chofer_produccion_pallets_8 = 0;
							$chofer_vuelta_adicional_pallets_8 = 0;
							$suma_cajas_2_pallets = 0;
							$suma_cajas_6_pallets = 0;
							$suma_cajas_8_pallets = 0;

							if($datos_produccion != NULL){ //0
								foreach ($datos_produccion as $chofer) { //0
									if ($chofer->vuelta == 1) { 
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											//$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											//$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											//$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;							
										}	
									}//vuelta_2
									if ($chofer->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;


											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_3
									if ($chofer->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_4
									if ($chofer->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;									
											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_5
									if ($chofer->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;							
										}	
									}
								}
							}


							if ($chofer_produccion_pallets_2 != 0) {
								$suma_2_pallets = $chofer_produccion_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$a, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_produccion_pallets_6 != 0) {
								$suma_6_pallets = $chofer_produccion_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$a, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_produccion_pallets_8 != 0) {
								$suma_8_pallets = $chofer_produccion_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$a, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//vuelta_adicional
							if ($chofer_vuelta_adicional_pallets_2 != 0) {
								$suma_2_pallets = $chofer_vuelta_adicional_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$a, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_vuelta_adicional_pallets_6 != 0) {
								$suma_6_pallets = $chofer_vuelta_adicional_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$a, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_vuelta_adicional_pallets_8 != 0) {
								$suma_8_pallets = $chofer_vuelta_adicional_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$a, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}

							if ($suma_cajas_2_pallets != 0) {
								$suma_cajas = $suma_cajas_2_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$a, $suma_cajas);
							}
							if ($suma_cajas_6_pallets != 0) {
								$suma_cajas = $suma_cajas_6_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$a, $suma_cajas);
							}
							if ($suma_cajas_8_pallets != 0) {
								$suma_cajas = $suma_cajas_8_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$a, $suma_cajas);
							}

							$a++;
						}
					}

					//HOJA 2
					$objPHPExcel->setActiveSheetIndex(2);
					//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$s = 15;

					if (!empty($fechas_produccion)){ 
						foreach ($fechas_produccion as $f) {

							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$s ,$f);
							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);

							$chofer_b_cliente_pallets_2 = 0;
							$chofer_b_cliente_pallets_6 = 0;
							$chofer_b_cliente_pallets_8 = 0;
							$chofer_b_ruta_calculada = 0;
							$suma_cliente_2_pallets = 0;
							$suma_cliente_6_pallets = 0;
							$suma_cliente_8_pallets = 0;
							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $chofer) { 
									if ($chofer->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada; 

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;


										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets; 									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 							
										}		
									}//vuelta_2
									if ($chofer->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;  

										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada; 

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets; 									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 							
										}		
									}//vuelta_3
									if ($chofer->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;  



										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets;  									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 

										}		
									}//vuelta_4
									if ($chofer->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada; 

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets; 


										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets;  									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 							
										}		
									}//vuelta_5
									if ($chofer->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;
										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets; 									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets;							
										}		
									}								
								}
							} # cierro if ***********

							//b_clientes
							if ($chofer_b_cliente_pallets_2 != 0) {
								$suma_2_pallets = $chofer_b_cliente_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$s, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_b_cliente_pallets_6 != 0) {
								$suma_6_pallets = $chofer_b_cliente_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$s, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_b_cliente_pallets_8 != 0) {
								$suma_8_pallets = $chofer_b_cliente_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$s, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//suma_rutas
							if ($chofer_b_ruta_calculada != 0) {
								//$suma_total_ruta = $chofer_b_ruta_calculada;
								$suma_total_ruta = $dinero_bono_ruta;

								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$s, $suma_total_ruta);
							}
							if ($suma_cliente_2_pallets != 0) {
								$suma_cliente = $suma_cliente_2_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$s, $suma_cliente);
							}
							if ($suma_cliente_6_pallets != 0) {
								$suma_cliente = $suma_cliente_6_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$s, $suma_cliente);
							}
							if ($suma_cliente_8_pallets != 0) {
								$suma_cliente = $suma_cliente_8_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$s, $suma_cliente);
							}


							$s++;
						}

					}

					//HOJA 4
					$objPHPExcel->setActiveSheetIndex(3);

					//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);
					$contador_asistencias_b_servicio_4 = 0;
					$contador_faltas_b_servicio = 0;

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_porcentaje_ranking_trabajador = $this->t_genera_liquidaciones->get_porcentaje_ranking_trabajador($valores, $f);

							if (!empty($get_porcentaje_ranking_trabajador)) {
								$porcentaje_rank = $get_porcentaje_ranking_trabajador->total_rank; 
								if ($porcentaje_rank >= 75 and $porcentaje_rank <= 50) {
									$bono_a_pagar = 13000;
								}

								if ($porcentaje_rank >= 76 and $porcentaje_rank <= 85) {
									$bono_a_pagar = 21000;
								}	

								if ($porcentaje_rank >= 86 and $porcentaje_rank <= 90) {
									$bono_a_pagar = 27000;
								}	

								if ($porcentaje_rank >= 91 and $porcentaje_rank <= 100) {
									$bono_a_pagar = 31200;
								}

								$objPHPExcel->getActiveSheet()->SetCellValue('E9', $bono_a_pagar);
							}
						}
					}

					//HOJA 5
					$objPHPExcel->setActiveSheetIndex(4);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

					$get_con_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 1);
					$get_sin_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 2);
					$get_vacaciones = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 3);
					$get_licencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 4);
					$get_ausencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 5);
					$get_presente = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 6);
							$con_goce = isset($get_con_goce->id)?'1':'0';
							$sin_goce = isset($get_sin_goce->id)?'1':'0';
							$vacaciones = isset($get_vacaciones->id)?'1':'0';
							$licencia = isset($get_licencia->id)?'1':'0';
							$ausencia = isset($get_ausencia->id)?'1':'0';
							$presente = isset($get_presente->id)?'1':'0';

							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
							
							if ($diasemana=='Domingo') {
								$presente=0;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $presente);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $con_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $sin_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $vacaciones);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $licencia);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, $ausencia);
							$num++;
						}
					}

					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save(BASE_URL2."extras/tla_excel/liquidaciones_tla/".$rut.".xlsm");
				}

//chofer convenio nuevo*******************************************************************************

				if ($cargo == 72 and $convenio == 22) {

					$objPHPExcel = new PHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$archivo = "extras/tla_excel/liquidacion_chofer_sindicato_conv_nuevo.xlsm";
					$objPHPExcel = $objReader->load(BASE_URL2.$archivo);

					//datos_chofer
					$nombre_completo = $data->nombre.$espacio.$data->ap.$espacio.$data->am;
					$rut = $data->rut;
					$cargo = isset($data->n_cargo)?$data->n_cargo:'';
					$fecha_actual = date('d-m-Y');

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(0);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(1);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$a = 16;									
					//$objPHPExcel->getActiveSheet()->SetCellValue('T8', $contador_faltas_chofer_2);
					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);

					$contador_faltas_chofer_2 = $contador_faltas_chofer_2 + $get_faltas_trabajador->faltas;		

					//$vueltas_adicionales_registradas = $this->t_genera_liquidaciones->get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino);
					//$contador_vueltas_adicionales_2 = $contador_vueltas_adicionales_2 + $vueltas_adicionales_registradas->vueltas;
					
					$objPHPExcel->getActiveSheet()->SetCellValue('T8', $contador_faltas_chofer_2);

					/*if ($contador_faltas_chofer_2 >= $contador_vueltas_adicionales_2) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer_2);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}elseif ($contador_faltas_chofer_2 < $contador_vueltas_adicionales_2) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer_2);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}*/

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, $f);

							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							
							$chofer_produccion_pallets_2 = 0;
							$chofer_vuelta_adicional_pallets_2 = 0;
							$chofer_produccion_pallets_6 = 0;
							$chofer_vuelta_adicional_pallets_6 = 0;
							$chofer_produccion_pallets_8 = 0;
							$chofer_vuelta_adicional_pallets_8 = 0;
							$suma_cajas_2_pallets = 0;
							$suma_cajas_6_pallets = 0;
							$suma_cajas_8_pallets = 0;
							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $chofer) {
									if ($chofer->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											//$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;							
										}	
									}//vuelta_2
									if ($chofer->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_3
									if ($chofer->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_4
									if ($chofer->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;									
											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_5
									if ($chofer->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;			
										}	
									}
								}
							}# end if

							if ($chofer_produccion_pallets_2 != 0) {
								$suma_2_pallets = $chofer_produccion_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$a, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_produccion_pallets_6 != 0) {
								$suma_6_pallets = $chofer_produccion_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$a, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_produccion_pallets_8 != 0) {
								$suma_8_pallets = $chofer_produccion_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$a, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//vuelta_adicional
							if ($chofer_vuelta_adicional_pallets_2 != 0) {
								$suma_2_pallets = $chofer_vuelta_adicional_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$a, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_vuelta_adicional_pallets_6 != 0) {
								$suma_6_pallets = $chofer_vuelta_adicional_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$a, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_vuelta_adicional_pallets_8 != 0) {
								$suma_8_pallets = $chofer_vuelta_adicional_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$a, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}

							if ($suma_cajas_2_pallets != 0) {
								$suma_cajas = $suma_cajas_2_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$a, $suma_cajas);
							}
							if ($suma_cajas_6_pallets != 0) {
								$suma_cajas = $suma_cajas_6_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$a, $suma_cajas);
							}
							if ($suma_cajas_8_pallets != 0) {
								$suma_cajas = $suma_cajas_8_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$a, $suma_cajas);
							}

							$a++;
						}
					}

					//HOJA 2
					$objPHPExcel->setActiveSheetIndex(2);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$s = 15;

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$s ,$f);
							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);

							$chofer_b_cliente_pallets_2 = 0;
							$chofer_b_cliente_pallets_6 = 0;
							$chofer_b_cliente_pallets_8 = 0;
							$chofer_b_ruta_calculada = 0;
							$suma_cliente_2_pallets = 0;
							$suma_cliente_6_pallets = 0;
							$suma_cliente_8_pallets = 0;
							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $chofer) {
									if ($chofer->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada; 

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;


										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets; 									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 							
										}		
									}//vuelta_2
									if ($chofer->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;  



										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada; 

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets; 									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 							
										}		
									}//vuelta_3
									if ($chofer->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;  



										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets;  									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 

										}		
									}//vuelta_4
									if ($chofer->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada; 

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets; 


										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets;  									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets; 							
										}		
									}//vuelta_5
									if ($chofer->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$s, $get_clientes);										

											$chofer_b_cliente_pallets_2 = $get_bono_cliente + $chofer_b_cliente_pallets_2;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_2_pallets = $get_clientes + $suma_cliente_2_pallets;


										}elseif ($chofer->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;	

											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$s, $get_clientes);


											$chofer_b_cliente_pallets_6 = $get_bono_cliente + $chofer_b_cliente_pallets_6;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_6_pallets = $get_clientes + $suma_cliente_6_pallets; 									

										}elseif ($chofer->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$s, $get_clientes);
											
											$chofer_b_cliente_pallets_8 = $get_bono_cliente + $chofer_b_cliente_pallets_8;

											$chofer_b_ruta_calculada = $get_bono_ruta + $chofer_b_ruta_calculada;

											$suma_cliente_8_pallets = $get_clientes + $suma_cliente_8_pallets;							
										}		
									}								
								}
							} # end  if($datos_produccion != NULL){ 

							//b_clientes
							if ($chofer_b_cliente_pallets_2 != 0) {
								$suma_2_pallets = $chofer_b_cliente_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$s, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_b_cliente_pallets_6 != 0) {
								$suma_6_pallets = $chofer_b_cliente_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$s, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_b_cliente_pallets_8 != 0) {
								$suma_8_pallets = $chofer_b_cliente_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$s, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//suma_rutas
							if ($chofer_b_ruta_calculada != 0) {
								$suma_total_ruta = $chofer_b_ruta_calculada;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$s, $suma_total_ruta);
							}
							if ($suma_cliente_2_pallets != 0) {
								$suma_cliente = $suma_cliente_2_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$s, $suma_cliente);
							}
							if ($suma_cliente_6_pallets != 0) {
								$suma_cliente = $suma_cliente_6_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$s, $suma_cliente);
							}
							if ($suma_cliente_8_pallets != 0) {
								$suma_cliente = $suma_cliente_8_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$s, $suma_cliente);
							}


							$s++;
						}

					}

					//HOJA 4
					$objPHPExcel->setActiveSheetIndex(3);

					//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);
					$contador_asistencias_b_servicio_3 = 0;
					$contador_faltas_b_servicio_2 = 0;

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_porcentaje_ranking_trabajador = $this->t_genera_liquidaciones->get_porcentaje_ranking_trabajador($valores, $f);

							if (!empty($get_porcentaje_ranking_trabajador)) {
								$porcentaje_rank = $get_porcentaje_ranking_trabajador->total_rank; 
								if ($porcentaje_rank >= 75 and $porcentaje_rank <= 50) {
									$bono_a_pagar = 13000;
								}

								if ($porcentaje_rank >= 76 and $porcentaje_rank <= 85) {
									$bono_a_pagar = 21000;
								}	

								if ($porcentaje_rank >= 86 and $porcentaje_rank <= 90) {
									$bono_a_pagar = 27000;
								}	

								if ($porcentaje_rank >= 91 and $porcentaje_rank <= 100) {
									$bono_a_pagar = 31200;
								}

								$objPHPExcel->getActiveSheet()->SetCellValue('E9', $bono_a_pagar);
							}					

						}
					}
						//HOJA 5
					$objPHPExcel->setActiveSheetIndex(4);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_con_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 1);
							$get_sin_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 2);
							$get_vacaciones = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 3);
							$get_licencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 4);
							$get_ausencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 5);
							$get_presente = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 6);
							$con_goce = isset($get_con_goce->id)?'1':'0';
							$sin_goce = isset($get_sin_goce->id)?'1':'0';
							$vacaciones = isset($get_vacaciones->id)?'1':'0';
							$licencia = isset($get_licencia->id)?'1':'0';
							$ausencia = isset($get_ausencia->id)?'1':'0';
							$presente = isset($get_presente->id)?'1':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
							
							if ($diasemana=='Domingo') {
								$presente=0;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $presente);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $con_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $sin_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $vacaciones);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $licencia);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, $ausencia);
							$num++;
						}
					}
					#	HOJA 6  Bono Rechazo
					$objPHPExcel->setActiveSheetIndex(5);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
							$getBonoRechazo = $this->t_genera_liquidaciones->get_bono_rechazo($valores,$f);
							$bonoRechazo = isset($getBonoRechazo->id_BonoRechazos)?'350':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
									if ($diasemana == 'Domingo') {
										$presente=0;
									}else{
										$presente=1;
									}
									$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
									$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $f);
									$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $bonoRechazo);
									$num++;
						}
					}

					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save(BASE_URL2."extras/tla_excel/liquidaciones_tla/".$rut.".xlsm");
				}

//*******************************************************************************************chofer_sin_nada....
				if ($cargo == 72 and $convenio == 23) {
	
					$objPHPExcel = new PHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$archivo = "extras/tla_excel/liquidacion_chofer_solo.xlsm";
					$objPHPExcel = $objReader->load(BASE_URL2.$archivo);

					//datos_chofer
					$nombre_completo = $data->nombre.$espacio.$data->ap.$espacio.$data->am;
					$rut = $data->rut;
					$cargo = isset($data->n_cargo)?$data->n_cargo:'';
					$fecha_actual = date('d-m-Y');

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(0);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(1);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$a = 16;

					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);

					$contador_faltas_chofer_sin_nada = $contador_faltas_chofer_sin_nada + $get_faltas_trabajador->faltas;		

					//$vueltas_adicionales_registradas = $this->t_genera_liquidaciones->get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino);

					//$contador_vueltas_adicionales_sin_nada = $contador_vueltas_adicionales_sin_nada + $vueltas_adicionales_registradas->vueltas;
					
					$objPHPExcel->getActiveSheet()->SetCellValue('T8', $contador_faltas_chofer_sin_nada);

					/*if ($contador_faltas_chofer_sin_nada >= $contador_vueltas_adicionales_sin_nada) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer_sin_nada);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}elseif ($contador_faltas_chofer_sin_nada < $contador_vueltas_adicionales_sin_nada) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer_sin_nada);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}*/

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, $f);

							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							
							$chofer_produccion_pallets_2 = 0;
							$chofer_vuelta_adicional_pallets_2 = 0;
							$chofer_produccion_pallets_6 = 0;
							$chofer_vuelta_adicional_pallets_6 = 0;
							$chofer_produccion_pallets_8 = 0;
							$chofer_vuelta_adicional_pallets_8 = 0;
							$suma_cajas_2_pallets = 0;
							$suma_cajas_6_pallets = 0;
							$suma_cajas_8_pallets = 0;
							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $chofer) {
									if ($chofer->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;							
										}	
									}//vuelta_2
									if ($chofer->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_3
									if ($chofer->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_4
									if ($chofer->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;									
											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;

										}	
									}//vuelta_5
									if ($chofer->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $chofer->vuelta);
										if ($chofer->tam_camion == 2) {
											//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											//vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);

											$chofer_produccion_pallets_2 = $get_bono_produccion + $chofer_produccion_pallets_2;

											$chofer_vuelta_adicional_pallets_2 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_2;

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;

										}elseif ($chofer->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);
											
											$chofer_produccion_pallets_6 = $get_bono_produccion + $chofer_produccion_pallets_6;

											$chofer_vuelta_adicional_pallets_6 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_6;

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;									

										}elseif ($chofer->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $get_cajas);

											$chofer_produccion_pallets_8 = $get_bono_produccion + $chofer_produccion_pallets_8;

											$chofer_vuelta_adicional_pallets_8 = $get_bono_v_adicional + $chofer_vuelta_adicional_pallets_8;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;							
										}	
									}
								}
							}# end 	if($datos_produccion != NULL){ 	

							if ($chofer_produccion_pallets_2 != 0) {
								$suma_2_pallets = $chofer_produccion_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$a, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_produccion_pallets_6 != 0) {
								$suma_6_pallets = $chofer_produccion_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$a, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_produccion_pallets_8 != 0) {
								$suma_8_pallets = $chofer_produccion_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$a, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//vuelta_adicional
							if ($chofer_vuelta_adicional_pallets_2 != 0) {
								$suma_2_pallets = $chofer_vuelta_adicional_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$a, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($chofer_vuelta_adicional_pallets_6 != 0) {
								$suma_6_pallets = $chofer_vuelta_adicional_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$a, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($chofer_vuelta_adicional_pallets_8 != 0) {
								$suma_8_pallets = $chofer_vuelta_adicional_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$a, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}

							if ($suma_cajas_2_pallets != 0) {
								$suma_cajas = $suma_cajas_2_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$a, $suma_cajas);
							}
							if ($suma_cajas_6_pallets != 0) {
								$suma_cajas = $suma_cajas_6_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$a, $suma_cajas);
							}
							if ($suma_cajas_8_pallets != 0) {
								$suma_cajas = $suma_cajas_8_pallets;
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$a, $suma_cajas);
							}

							$a++;
						}
					}
						//HOJA 5
					$objPHPExcel->setActiveSheetIndex(2);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_con_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 1);
							$get_sin_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 2);
							$get_vacaciones = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 3);
							$get_licencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 4);
							$get_ausencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 5);
							$get_presente = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 6);
							$con_goce = isset($get_con_goce->id)?'1':'0';
							$sin_goce = isset($get_sin_goce->id)?'1':'0';
							$vacaciones = isset($get_vacaciones->id)?'1':'0';
							$licencia = isset($get_licencia->id)?'1':'0';
							$ausencia = isset($get_ausencia->id)?'1':'0';
							$presente = isset($get_presente->id)?'1':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
							
							if ($diasemana=='Domingo') {
								$presente=0;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $presente);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $con_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $sin_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $vacaciones);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $licencia);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, $ausencia);
							$num++;
						}
					}
				#	HOJA 6  Bono Rechazo
				/*	$objPHPExcel->setActiveSheetIndex(5);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
							$getBonoRechazo = $this->t_genera_liquidaciones->get_bono_rechazo($valores,$f);
							$bonoRechazo = isset($getBonoRechazo->id_BonoRechazos)?'350':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
									if ($diasemana == 'Domingo') {
										$presente=0;
									}else{
										$presente=1;
									}
									$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
									$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $f);
									$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $bonoRechazo);
									$num++;
						}
					}*/

					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save(BASE_URL2."extras/tla_excel/liquidaciones_tla/".$rut.".xlsm");
				}


//*******************************************************************************************peoneta sindicato_antiguo
				if ($cargo == 73 and $convenio == 21) {
					$objPHPExcel = new PHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$_archivo = "extras/tla_excel/liquidacion_peoneta_sindicato_conv_antiguo.xlsm";
					$objPHPExcel = $objReader->load(BASE_URL2.$_archivo);

					$nombre_completo = $data->nombre.$espacio.$data->ap.$espacio.$data->am;
					$rut = $data->rut;
					$cargo = isset($data->n_cargo)?$data->n_cargo:'';
					$fecha_actual = date('d-m-Y');

				//HOJA 1
					$objPHPExcel->setActiveSheetIndex(0);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);			

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(1);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$z = 24;
				//$fechas_produccion = array('2016-09-21','2016-09-22','2016-09-23','2016-09-24');

					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);

					$contador_faltas = $contador_faltas + $get_faltas_trabajador->faltas;													
					$objPHPExcel->getActiveSheet()->SetCellValue('T19', $contador_faltas);

					//$vueltas_adicionales_registradas = $this->t_genera_liquidaciones->get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino);

					//$contador_vueltas_adicionales_peoneta = $contador_vueltas_adicionales_peoneta + $vueltas_adicionales_registradas->vueltas;
					

					/*if ($contador_faltas >= $contador_vueltas_adicionales_peoneta) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}elseif ($contador_faltas < $contador_vueltas_adicionales_peoneta) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}*/


					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$z, $f);
							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							$produccion_pallets_2 = 0;
							$vuelta_adicional_pallets_2 = 0;
							$produccion_pallets_6 = 0;
							$vuelta_adicional_pallets_6 = 0;
							$produccion_pallets_8 = 0;
							$vuelta_adicional_pallets_8 = 0;

							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $row => $values) {
								//vuelta 1
									if ($values->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											//$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);
											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											//$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											//$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}	
								//vuelta 2
									elseif ($values->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 3
									elseif ($values->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 4
									elseif ($values->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 5
									elseif ($values->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
								}
							}# end	if($datos_produccion != NULL){ 					

						//produccion
							if ($produccion_pallets_2 != 0) {
								$suma_2_pallets = $produccion_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$z, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($produccion_pallets_6 != 0) {
								$suma_6_pallets = $produccion_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$z, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($produccion_pallets_8 != 0) {
								$suma_8_pallets = $produccion_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$z, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//vuelta_adicional
							if ($vuelta_adicional_pallets_2 != 0) {
								$suma_2_pallets = $vuelta_adicional_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$z, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($vuelta_adicional_pallets_6 != 0) {
								$suma_6_pallets = $vuelta_adicional_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$z, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($vuelta_adicional_pallets_8 != 0) {
								$suma_8_pallets = $vuelta_adicional_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$z, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}

							$z++;
						}
					}

					//HOJA 3
					$objPHPExcel->setActiveSheetIndex(2);

					//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$x = 24;

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
						//fechas
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$x, $f);
							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							$b_cliente_pallets_2 = 0;
							$b_cliente_pallets_6 = 0;
							$b_cliente_pallets_8 = 0;
							$b_ruta_calculada = 0;

							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $row => $values) {
									
									if ($values->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;

										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 2	
									if ($values->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 

											


										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 3
									if ($values->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 

											


										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 4
									if ($values->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;										

										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 5
									if ($values->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 

											


										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}
								}
							}# end 	if($datos_produccion != NULL){ 

						//b_clientes
							if ($b_cliente_pallets_2 != 0) {
								$suma_2_pallets = $b_cliente_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$x, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($b_cliente_pallets_6 != 0) {
								$suma_6_pallets = $b_cliente_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$x, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($b_cliente_pallets_8 != 0) {
								$suma_8_pallets = $b_cliente_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$x, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//suma_rutas
							if ($b_ruta_calculada != 0) {
								$suma_total_ruta = $b_ruta_calculada;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$x, $suma_total_ruta);
							}
							$x++;
						}


					//HOJA 4
						$objPHPExcel->setActiveSheetIndex(3);
					//CREAR VALORES
						$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
						$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
						$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
						$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);

						$contador_asistencias_b_servicio_1 = 0;
						$contador_faltas_b_servicio = 0;

						if (!empty($fechas_produccion)){
							foreach ($fechas_produccion as $f) {

								$get_porcentaje_ranking_trabajador = $this->t_genera_liquidaciones->get_porcentaje_ranking_trabajador($valores, $f);

								if (!empty($get_porcentaje_ranking_trabajador)) {
									$porcentaje_rank = $get_porcentaje_ranking_trabajador->total_rank;
									//echo $porcentaje_rank; 
									if ($porcentaje_rank >= 75 and $porcentaje_rank <= 50) {
										$bono_a_pagar = 5000;
									}

									if ($porcentaje_rank >= 76 and $porcentaje_rank <= 85) {
										$bono_a_pagar = 10000;
									}	

									if ($porcentaje_rank >= 86 and $porcentaje_rank <= 90) {
										$bono_a_pagar = 16000;
									}	

									if ($porcentaje_rank >= 91 and $porcentaje_rank <= 100) {
										$bono_a_pagar = 20000;
									}

									$objPHPExcel->getActiveSheet()->SetCellValue('E9', $bono_a_pagar);								
								}
							}
						}
							//HOJA 5
					$objPHPExcel->setActiveSheetIndex(4);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_con_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 1);
							$get_sin_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 2);
							$get_vacaciones = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 3);
							$get_licencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 4);
							$get_ausencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 5);
							$get_presente = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 6);
							$con_goce = isset($get_con_goce->id)?'1':'0';
							$sin_goce = isset($get_sin_goce->id)?'1':'0';
							$vacaciones = isset($get_vacaciones->id)?'1':'0';
							$licencia = isset($get_licencia->id)?'1':'0';
							$ausencia = isset($get_ausencia->id)?'1':'0';
							$presente = isset($get_presente->id)?'1':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
							
							if ($diasemana=='Domingo') {
								$presente=0;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $presente);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $con_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $sin_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $vacaciones);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $licencia);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, $ausencia);
							$num++;
						}
					}
					#	HOJA 6  Bono Rechazo
					$objPHPExcel->setActiveSheetIndex(5);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
					$getBonoRechazo = $this->t_genera_liquidaciones->get_bono_rechazo($valores,$f);
					$bonoRechazo = isset($getBonoRechazo->id_BonoRechazos)?'350':'0';
					$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
					$diasemana = $dias[date('N', strtotime($f))];
							if ($diasemana == 'Domingo') {
								$presente=0;
							}else{
								$presente=1;
							}
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $bonoRechazo);
							$num++;
						}
					}
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
						$objWriter->save(BASE_URL2."extras/tla_excel/liquidaciones_tla/".$rut.".xlsm");
					}				
				}
//************************************************************************************************************************peoneta sindicato_nuevo
				if ($cargo == 73 and $convenio == 22) {

					$objPHPExcel = new PHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$_archivo = "extras/tla_excel/liquidacion_peoneta_sindicato_conv_nuevo.xlsm";
					$objPHPExcel = $objReader->load(BASE_URL2.$_archivo);
					$nombre_completo = $data->nombre.$espacio.$data->ap.$espacio.$data->am;
					$rut = $data->rut;
					$cargo = isset($data->n_cargo)?$data->n_cargo:'';
					$fecha_actual = date('d-m-Y');

				//HOJA 1
					$objPHPExcel->setActiveSheetIndex(0);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);			

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(1);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$z = 24;
				//$fechas_produccion = array('2016-09-21','2016-09-22','2016-09-23','2016-09-24');

					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);

					$contador_faltas_2 = $contador_faltas_2 + $get_faltas_trabajador->faltas;													
					$objPHPExcel->getActiveSheet()->SetCellValue('T19', $contador_faltas_2);

					//$vueltas_adicionales_registradas = $this->t_genera_liquidaciones->get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino);

					//$contador_vueltas_adicionales_peoneta_2 = $contador_vueltas_adicionales_peoneta_2 + $vueltas_adicionales_registradas->vueltas;

					/*if ($contador_faltas_2 >= $contador_vueltas_adicionales_peoneta_2) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_chofer);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}elseif ($contador_faltas_2 < $contador_vueltas_adicionales_peoneta_2) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_2);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}*/

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$z, $f);
							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							$produccion_pallets_2 = 0;
							$vuelta_adicional_pallets_2 = 0;
							$produccion_pallets_6 = 0;
							$vuelta_adicional_pallets_6 = 0;
							$produccion_pallets_8 = 0;
							$vuelta_adicional_pallets_8 = 0;

							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $row => $values) {
								//vuelta 1
									if ($values->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											//$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);
											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											//$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											//$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}	
								//vuelta 2
									elseif ($values->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 3
									elseif ($values->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 4
									elseif ($values->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 5
									elseif ($values->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
								}	
							}# end 	if($datos_produccion != NULL){ 				

						//produccion
							if ($produccion_pallets_2 != 0) {
								$suma_2_pallets = $produccion_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$z, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($produccion_pallets_6 != 0) {
								$suma_6_pallets = $produccion_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$z, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($produccion_pallets_8 != 0) {
								$suma_8_pallets = $produccion_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$z, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//vuelta_adicional
							if ($vuelta_adicional_pallets_2 != 0) {
								$suma_2_pallets = $vuelta_adicional_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$z, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($vuelta_adicional_pallets_6 != 0) {
								$suma_6_pallets = $vuelta_adicional_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$z, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($vuelta_adicional_pallets_8 != 0) {
								$suma_8_pallets = $vuelta_adicional_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$z, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}

							$z++;
						}
					}

					//HOJA 3
					$objPHPExcel->setActiveSheetIndex(2);

					//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$x = 24;
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
						//fechas
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$x, $f);

							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);

							$b_cliente_pallets_2 = 0;
							$b_cliente_pallets_6 = 0;
							$b_cliente_pallets_8 = 0;
							$b_ruta_calculada = 0;

							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $row => $values) {
									
									if ($values->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;
											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 
										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 2	
									if ($values->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 

										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 3
									if ($values->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 

											


										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 4
									if ($values->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;										

										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}//vuelta 5
									if ($values->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$x, $get_ayudantes);

											$b_cliente_pallets_2 = $get_bono_cliente + $b_cliente_pallets_2;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 

											


										}elseif ($values->tam_camion == 6) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$x, $get_ayudantes);

											$b_cliente_pallets_6 = $get_bono_cliente + $b_cliente_pallets_6;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada; 									

										}elseif ($values->tam_camion >= 8) {
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;

											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $get_clientes);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$x, $get_ayudantes);

											$b_cliente_pallets_8 = $get_bono_cliente + $b_cliente_pallets_8;

											$b_ruta_calculada = $get_bono_ruta + $b_ruta_calculada;							
										}				
									}
								}
							}# end 	if($datos_produccion != NULL){ 

						//b_clientes
							if ($b_cliente_pallets_2 != 0) {
								$suma_2_pallets = $b_cliente_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$x, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($b_cliente_pallets_6 != 0) {
								$suma_6_pallets = $b_cliente_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$x, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($b_cliente_pallets_8 != 0) {
								$suma_8_pallets = $b_cliente_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$x, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
						//suma_rutas
							if ($b_ruta_calculada != 0) {
								$suma_total_ruta = $dinero_bono_ruta;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$x, $suma_total_ruta);
							}

							$x++;
						}


					//HOJA 4
						$objPHPExcel->setActiveSheetIndex(3);

					//CREAR VALORES
						$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
						$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
						$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
						$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);
						$contador_asistencias_b_servicio_2 = 0;
						$contador_faltas_b_servicio = 0;

						if (!empty($fechas_produccion)){
							foreach ($fechas_produccion as $f) {
								$get_porcentaje_ranking_trabajador = $this->t_genera_liquidaciones->get_porcentaje_ranking_trabajador($valores, $f);

								if (!empty($get_porcentaje_ranking_trabajador)) {
									$porcentaje_rank = $get_porcentaje_ranking_trabajador->total_rank; 
									if ($porcentaje_rank >= 75 and $porcentaje_rank <= 50) {
										$bono_a_pagar = 5000;
									}

									if ($porcentaje_rank >= 76 and $porcentaje_rank <= 85) {
										$bono_a_pagar = 10000;
									}	

									if ($porcentaje_rank >= 86 and $porcentaje_rank <= 90) {
										$bono_a_pagar = 16000;
									}	

									if ($porcentaje_rank >= 91 and $porcentaje_rank <= 100) {
										$bono_a_pagar = 20000;
									}

									$objPHPExcel->getActiveSheet()->SetCellValue('E9', $bono_a_pagar);								
								}								
							}
						}
									//HOJA 5
					$objPHPExcel->setActiveSheetIndex(4);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_con_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 1);
							$get_sin_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 2);
							$get_vacaciones = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 3);
							$get_licencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 4);
							$get_ausencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 5);
							$get_presente = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 6);
							$con_goce = isset($get_con_goce->id)?'1':'0';
							$sin_goce = isset($get_sin_goce->id)?'1':'0';
							$vacaciones = isset($get_vacaciones->id)?'1':'0';
							$licencia = isset($get_licencia->id)?'1':'0';
							$ausencia = isset($get_ausencia->id)?'1':'0';
							$presente = isset($get_presente->id)?'1':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
							
							if ($diasemana=='Domingo') {
								$presente=0;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $presente);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $con_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $sin_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $vacaciones);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $licencia);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, $ausencia);
							$num++;
						}
					}
					#	HOJA 6  Bono Rechazo
					$objPHPExcel->setActiveSheetIndex(5);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {
					$getBonoRechazo = $this->t_genera_liquidaciones->get_bono_rechazo($valores,$f);
					$bonoRechazo = isset($getBonoRechazo->id_BonoRechazos)?'350':'0';
					$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
					$diasemana = $dias[date('N', strtotime($f))];
							if ($diasemana == 'Domingo') {
								$presente=0;
							}else{
								$presente=1;
							}
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $bonoRechazo);
							$num++;
						}
					}
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
						$objWriter->save(BASE_URL2."extras/tla_excel/liquidaciones_tla/".$rut.".xlsm");
					}				
				}
//*******************************************************************************************peoneta solo...
				if ($cargo == 73 and $convenio == 23) {

					$objPHPExcel = new PHPExcel();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$_archivo = "extras/tla_excel/liquidacion_peoneta_solo.xlsm";
					$objPHPExcel = $objReader->load(BASE_URL2.$_archivo);

					$nombre_completo = $data->nombre.$espacio.$data->ap.$espacio.$data->am;
					$rut = $data->rut;
					$cargo = isset($data->n_cargo)?$data->n_cargo:'';
					$fecha_actual = date('d-m-Y');

				//HOJA 1
					$objPHPExcel->setActiveSheetIndex(0);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('D2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('D4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('D5', $fecha_actual);			

				//HOJA 2
					$objPHPExcel->setActiveSheetIndex(1);
				//CREAR VALORES
					$objPHPExcel->getActiveSheet()->SetCellValue('C2', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C3', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('C4', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('C5', $fecha_actual);

					$z = 24;
				//$fechas_produccion = array('2016-09-21','2016-09-22','2016-09-23','2016-09-24');

					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);

					$contador_faltas_peoneta_sin_nada = $contador_faltas_peoneta_sin_nada + $get_faltas_trabajador->faltas;													
					$objPHPExcel->getActiveSheet()->SetCellValue('T19', $contador_faltas_peoneta_sin_nada);

					//$vueltas_adicionales_registradas = $this->t_genera_liquidaciones->get_vueltas_adicionales_registradas($valores, $fecha_inicio, $fecha_termino);

					//$contador_vueltas_adicionales_peoneta_sin_nada = $contador_vueltas_adicionales_peoneta_sin_nada + $vueltas_adicionales_registradas->vueltas;
					

					/*if ($contador_faltas_peoneta_sin_nada >= $contador_vueltas_adicionales_peoneta_sin_nada) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_peoneta_sin_nada);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}elseif ($contador_faltas_peoneta_sin_nada < $contador_vueltas_adicionales_peoneta_sin_nada) {
						$buscar_vueltas_adicionales = $this->t_genera_liquidaciones->get_vueltas_adicionales_trabajador($valores, $fecha_inicio, $fecha_termino, $contador_faltas_peoneta_sin_nada);
						if (!empty($buscar_vueltas_adicionales)) {
							foreach ($buscar_vueltas_adicionales as $key => $value) {
								$vuelta_adicional = array('bono_vuelta_adicional' => 0);
								$this->t_genera_liquidaciones->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
							}
						}
					}*/

					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$z, $f);

							$datos_produccion = $this->t_genera_liquidaciones->generar_liquidacion_trabajador($valores, $f);
							$produccion_pallets_2 = 0;
							$vuelta_adicional_pallets_2 = 0;
							$produccion_pallets_6 = 0;
							$vuelta_adicional_pallets_6 = 0;
							$produccion_pallets_8 = 0;
							$vuelta_adicional_pallets_8 = 0;

							if($datos_produccion != NULL){ #inicio if 
								foreach ($datos_produccion as $row => $values) {

								//vuelta 1
									if ($values->vuelta == 1) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);
											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}	
								//vuelta 2
									elseif ($values->vuelta == 2) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('H'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 3
									elseif ($values->vuelta == 3) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('I'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 4
									elseif ($values->vuelta == 4) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('J'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
									//vuelta 5
									elseif ($values->vuelta == 5) {
										$datos_produccion_vuelta = $this->t_genera_liquidaciones->generar_liquidacion_trabajador_vuelta($valores, $f , $values->vuelta);
										if ($values->tam_camion == 2) {		
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_2 = $get_bono_produccion + $produccion_pallets_2;

											$vuelta_adicional_pallets_2 = $get_bono_v_adicional + $vuelta_adicional_pallets_2;


										}elseif ($values->tam_camion == 6) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_6 = $get_bono_produccion + $produccion_pallets_6;

											$vuelta_adicional_pallets_6 = $get_bono_v_adicional + $vuelta_adicional_pallets_6;									

										}elseif ($values->tam_camion >= 8) {
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
											$get_ayudantes = isset($datos_produccion_vuelta->tripulacion)?$datos_produccion_vuelta->tripulacion:0;
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
											$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $get_cajas);
											$objPHPExcel->getActiveSheet()->SetCellValue('K'.$z, $get_ayudantes);

											$produccion_pallets_8 = $get_bono_produccion + $produccion_pallets_8;

											$vuelta_adicional_pallets_8 = $get_bono_v_adicional + $vuelta_adicional_pallets_8;							
										}				
									}
								}	
							}#end 	if($datos_produccion != NULL){ 				

						//produccion
							if ($produccion_pallets_2 != 0) {
								$suma_2_pallets = $produccion_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$z, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($produccion_pallets_6 != 0) {
								$suma_6_pallets = $produccion_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$z, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($produccion_pallets_8 != 0) {
								$suma_8_pallets = $produccion_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$z, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}
		//vuelta_adicional /*Edit 28-07-2017****************************************/
							if ($vuelta_adicional_pallets_2 != 0 and $vuelta_adicional_pallets_2 != 1) {
								$suma_2_pallets = $vuelta_adicional_pallets_2;
								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$z, $suma_2_pallets);
							}else{
								$suma_2_pallets = 0;
							}
							if ($vuelta_adicional_pallets_6 != 0) {
								$suma_6_pallets = $vuelta_adicional_pallets_6;
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$z, $suma_6_pallets);
							}else{
								$suma_6_pallets = 0;
							}
							if ($vuelta_adicional_pallets_8 != 0) {
								$suma_8_pallets = $vuelta_adicional_pallets_8;
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$z, $suma_8_pallets);
							}else{
								$suma_8_pallets = 0;
							}

							$z++;
						}
					}
								//HOJA 3
					$objPHPExcel->setActiveSheetIndex(2);
					//CREAR VALORES
					$num=17;
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', $nombre_completo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E7', $rut);
					$objPHPExcel->getActiveSheet()->SetCellValue('E8', $cargo);
					$objPHPExcel->getActiveSheet()->SetCellValue('E9', $fecha_actual);
					if (!empty($fechas_produccion)){
						foreach ($fechas_produccion as $f) {

							$get_con_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 1);
							$get_sin_goce = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 2);
							$get_vacaciones = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 3);
							$get_licencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 4);
							$get_ausencia = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 5);
							$get_presente = $this->t_genera_liquidaciones->get_tipo_asistencia_resumen($valores, $f, 6);
							$con_goce = isset($get_con_goce->id)?'1':'0';
							$sin_goce = isset($get_sin_goce->id)?'1':'0';
							$vacaciones = isset($get_vacaciones->id)?'1':'0';
							$licencia = isset($get_licencia->id)?'1':'0';
							$ausencia = isset($get_ausencia->id)?'1':'0';
							$presente = isset($get_presente->id)?'1':'0';
							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
							$diasemana = $dias[date('N', strtotime($f))];
							
							if ($diasemana=='Domingo') {
								$presente=0;
							}

							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $diasemana);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $f);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $presente);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $con_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $sin_goce);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $vacaciones);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $licencia);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, $ausencia);
							$num++;
						}
					}

					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save(BASE_URL2."extras/tla_excel/liquidaciones_tla/".$rut.".xlsm");
				}
			}
			//fin foreach
			
			$path = BASE_URL2.'/extras/tla_excel/liquidaciones_tla/';
			$this->zip->read_dir($path, FALSE);
			$carpeta = BASE_URL2.'/extras/tla_excel/liquidaciones_tla/';
		    	//Elimino la gestion documental de ese cliente  
			if (file_exists($carpeta)) {
				foreach(glob($carpeta . "/*") as $archivos_carpeta){
					if (is_dir($archivos_carpeta)){
					}else{
						unlink($archivos_carpeta);
					}
				}
			
			$this->zip->download("tla_liquidaciones_1_Los_Angeles_desde".$fecha_inicio."_hasta".$fecha_termino.".zip");
		}else{
			echo "<script>alert('Debe selecccionar un trabajador.')</script>";
			redirect('transportes/resumen/resumen_produccion','refresh');
		}
	}

}


}
/* End of file resumen.php */
/* Location: ./application/modules/transportes/controllers/resumen.php */