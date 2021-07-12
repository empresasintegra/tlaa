<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produccion_nuevo extends CI_Controller {

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
			$this->load->model('tla_informe_produccion');
			
		}
	}

	public function genera_informe_general(){
		$this->load->library('PHPExcel');
		$this->load->library('zip');
		$this->load->helper('download');

		$fecha_inicio = $_POST['datepicker'];
		$fecha_termino = $_POST['datepicker2'];
		$dias_habiles = $_POST['dias_laborales'];

		$fechaInicio= strtotime($fecha_inicio);
		$fechaFin= strtotime($fecha_termino);

		$f_inicio = $fecha_inicio;
		$f_termino = $fecha_termino;

		if ($fechaInicio > $fechaFin){
			echo "<script>alert('Debe ingresar una fecha mayor a la fecha de inicio')</script>";
			redirect('transportes/resumen/resumen_produccion','refresh');
		}

		if($dias_habiles != 0 and $dias_habiles != NULL){
			$dinero_bono_ruta = round(40000 / $dias_habiles);
		}else{
			$dinero_bono_ruta = 0;
		}

		$trab = 0;
		$a = 2;

		$f2 = explode("-", $fecha_termino);
		$ano2 = $f2[0];
		$mes2 = $f2[1];

		if($ano2 == '2016' and $mes2 == '10'){
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

		$fecha_inicio2 = strtotime($fecha_inicio);
		$fecha_termino2 = strtotime($nuevafecha);

		$fechas_produccion = array();
		$dia_once = 0;
		for($i=$fecha_inicio2; $i<=$fecha_termino2; $i+=86400){
			if(date('Y-m-d', $i) == '2017-03-11'){
				if($dia_once == 0){
					$fechas_produccion[] = date('Y-m-d', $i);
				}
				$dia_once += 1;
			}else{
				$fechas_produccion[] = date('Y-m-d', $i);
			}    
		}

		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$archivo = "extras/tla_excel/informe_general_produccion.xlsx";
		$objPHPExcel = $objReader->load(BASE_URL2.$archivo);

		if (!empty($_POST['usuarios_2'])){
			foreach($_POST['usuarios_2'] as $row=>$valores){
				$todos_los_trabajadores = $this->tla_informe_produccion->todos_los_trabajadores($valores, $f_inicio, $f_termino);
				//var_dump($todos_los_trabajadores);
				if (!empty($todos_los_trabajadores)){
					foreach ($todos_los_trabajadores as $trabajadores) {
						
						$trab += 1;
						/*$fechas_produccion = array();
						for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
							$fechas_produccion[] = date('Y-m-d', $i);      
						}*/

						$objPHPExcel->setActiveSheetIndex(0);

						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a, $trabajadores->id);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a, $trabajadores->rut);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a, $trabajadores->ap." ".$trabajadores->am." ".$trabajadores->nombre);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$a, $trabajadores->n_cargo);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$a, $trabajadores->n_convenio);

				//cajas
						$suma_cajas_2_pallets = 0;
						$suma_cajas_6_pallets = 0;
						$suma_cajas_8_pallets = 0;
				//bono_produccion
						$suma_bono_produccion = 0;
				//bono rutero
						$bono_rutero = 0;
				//bono vuelta adicional
						$suma_b_vuelta_adicional = 0;
				//clientes efectivos
						$clientes_efectivos = 0;
				//bono cliente
						$bono_cliente = 0;
				//bono buen serivicio
						$suma_bono_buen_servicio = 0;
				//faltas
						$contador_faltas_legales = 0;
						$contador_faltas_ilegales = 0;

				//faltas_legales 
						$get_faltas_trabajador = $this->tla_informe_produccion->get_faltas_trabajador($trabajadores->id, $f_inicio, $f_termino);
						$contador_faltas_legales = $contador_faltas_legales + $get_faltas_trabajador->faltas;
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$a, $contador_faltas_legales);

				//faltas ilegales
						$get_faltas_trabajador_ilegales = $this->tla_informe_produccion->get_faltas_trabajador_ilegales($trabajadores->id, $f_inicio, $f_termino);
						$contador_faltas_ilegales = $contador_faltas_ilegales + $get_faltas_trabajador_ilegales->faltas_i;
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$a, $contador_faltas_ilegales);


						$vuelta = 0;
						$vuelta_ad = 0;	

						if (!empty($fechas_produccion)){
							foreach ($fechas_produccion as $f) {
								$datos_produccion = $this->tla_informe_produccion->extraer_informacion_trabajador($trabajadores->id, $f);									
								foreach ($datos_produccion as $data) {
									if ($data->vuelta == 1) {
										$datos_produccion_vuelta = $this->tla_informe_produccion->info_vuelta_trabajador($trabajadores->id, $f , $data->vuelta);
										$vuelta = $vuelta + 1;
										if ($data->tam_camion == 2) {
										//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										//$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;

											$clientes_efectivos = $get_clientes + $clientes_efectivos;

											$bono_cliente = $get_bono_cliente + $bono_cliente;

											$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

											$bono_rutero = $get_bono_ruta + $bono_rutero;						

											$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;	
										}
										if ($data->tam_camion == 6) {
										//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										//$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;

											$clientes_efectivos = $get_clientes + $clientes_efectivos;

											$bono_cliente = $get_bono_cliente + $bono_cliente;

											$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;					
											$bono_rutero = $get_bono_ruta + $bono_rutero;				

											$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;	
										}
										if ($data->tam_camion >= 8) {
										//cajas
											$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
											$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
											$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
											$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
											$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
											$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										//$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;

											$clientes_efectivos = $get_clientes + $clientes_efectivos;

											$bono_cliente = $get_bono_cliente + $bono_cliente;

											$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

											$bono_rutero = $get_bono_ruta + $bono_rutero;

											$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;	
										}
								}//vuelta 2
								if ($data->vuelta == 2) {
									$datos_produccion_vuelta = $this->tla_informe_produccion->info_vuelta_trabajador($trabajadores->id, $f , $data->vuelta);
									$vuelta = $vuelta + 1;
									$vuelta_ad = $vuelta_ad + 1;
									if ($data->tam_camion == 2) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;						

										$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;	
									}
									if ($data->tam_camion == 6) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;					
										$bono_rutero = $get_bono_ruta + $bono_rutero;				

										$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;	
									}
									if ($data->tam_camion >= 8) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;

										$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;	
									}
								}//vuelta3
								if ($data->vuelta == 3) {
									$datos_produccion_vuelta = $this->tla_informe_produccion->info_vuelta_trabajador($trabajadores->id, $f , $data->vuelta);
									$vuelta = $vuelta + 1;
									$vuelta_ad = $vuelta_ad + 1;
									if ($data->tam_camion == 2) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;						

										$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;	
									}
									if ($data->tam_camion == 6) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;					
										$bono_rutero = $get_bono_ruta + $bono_rutero;				

										$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;	
									}
									if ($data->tam_camion >= 8) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;

										$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;	
									}
								}//vuelta 4
								if ($data->vuelta == 4) {
									$datos_produccion_vuelta = $this->tla_informe_produccion->info_vuelta_trabajador($trabajadores->id, $f , $data->vuelta);
									$vuelta = $vuelta + 1;
									$vuelta_ad = $vuelta_ad + 1;
									if ($data->tam_camion == 2) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;						

										$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;	
									}
									if ($data->tam_camion == 6) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;					
										$bono_rutero = $get_bono_ruta + $bono_rutero;				

										$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;	
									}
									if ($data->tam_camion >= 8) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;

										$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;	
									}
								}//vuelta 5
								if ($data->vuelta == 5) {
									$datos_produccion_vuelta = $this->tla_informe_produccion->info_vuelta_trabajador($trabajadores->id, $f , $data->vuelta);
									$vuelta = $vuelta + 1;
									$vuelta_ad = $vuelta_ad + 1;
									if ($data->tam_camion == 2) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;						

										$suma_cajas_2_pallets = $get_cajas + $suma_cajas_2_pallets;	
									}
									if ($data->tam_camion == 6) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;					
										$bono_rutero = $get_bono_ruta + $bono_rutero;				

										$suma_cajas_6_pallets = $get_cajas + $suma_cajas_6_pallets;	
									}
									if ($data->tam_camion >= 8) {
										//cajas
										$get_cajas = isset($datos_produccion_vuelta->cajas)?$datos_produccion_vuelta->cajas:0;
										//bono_produccion						
										$get_bono_produccion = isset($datos_produccion_vuelta->b_produccion)?$datos_produccion_vuelta->b_produccion:0;
										//bono_ruta
										$get_bono_ruta = isset($datos_produccion_vuelta->b_ruta)?$datos_produccion_vuelta->b_ruta:0;
										//bono vuelta adicional
										$get_bono_v_adicional = isset($datos_produccion_vuelta->b_v_adicional)?$datos_produccion_vuelta->b_v_adicional:0;
										//clientes_efectivos
										$get_clientes = isset($datos_produccion_vuelta->clientes)?$datos_produccion_vuelta->clientes:0;
										//bono_cliente	
										$get_bono_cliente = isset($datos_produccion_vuelta->b_cliente)?$datos_produccion_vuelta->b_cliente:0;

										$suma_b_vuelta_adicional = $get_bono_v_adicional + $suma_b_vuelta_adicional;
										
										$clientes_efectivos = $get_clientes + $clientes_efectivos;

										$bono_cliente = $get_bono_cliente + $bono_cliente;

										$suma_bono_produccion = $get_bono_produccion + $suma_bono_produccion;

										$bono_rutero = $get_bono_ruta + $bono_rutero;

										$suma_cajas_8_pallets = $get_cajas + $suma_cajas_8_pallets;	
									}
									}
								}										
							}
						}
						//cajas


				$cantidad_dias_rutas = $this->tla_informe_produccion->cantidad_dias_rutero($trabajadores->id, $fecha_inicio, $fecha_termino);
				$bono_rutero = $cantidad_dias_rutas * $dinero_bono_ruta;


				//if ($suma_cajas_2_pallets != 0) {
						$suma_cajas = $suma_cajas_2_pallets;
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$a, $suma_cajas);
				//}
				//if ($suma_cajas_6_pallets != 0) {
						$suma_cajas = $suma_cajas_6_pallets;
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$a, $suma_cajas);
				//}
				//if ($suma_cajas_8_pallets != 0) {
						$suma_cajas = $suma_cajas_8_pallets;
						$objPHPExcel->getActiveSheet()->SetCellValue('J'.$a, $suma_cajas);
				//}
				//vueltas
				//if ($vuelta != 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('L'.$a, $vuelta);
				//}
				//vueltas_extras
				//if ($vuelta_ad != 0) {
						$objPHPExcel->getActiveSheet()->SetCellValue('M'.$a, $vuelta_ad);
				//}
				//bono_produccion
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$a, $suma_bono_produccion);
				//bono_rutero
						$objPHPExcel->getActiveSheet()->SetCellValue('P'.$a, $bono_rutero);
				//bono_vuelta_adicional
						$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$a, $suma_b_vuelta_adicional);
				//clientes efectivos
						$objPHPExcel->getActiveSheet()->SetCellValue('R'.$a, $clientes_efectivos);
				//bono cliente
						$objPHPExcel->getActiveSheet()->SetCellValue('S'.$a, $bono_cliente);
						
				//ranking_trabajadores
				//faltas_legales 
						$get_ranking_trabajador = $this->tla_informe_produccion->get_ranking_trabajador($trabajadores->id, $f_inicio, $f_termino);

						if ($trabajadores->n_convenio == "NO TIENE") {
					//bono_buen_Servicio
							if ($trabajadores->n_cargo == "CHOFER") {
								$bono_a_pagar = 0;
								$objPHPExcel->getActiveSheet()->SetCellValue('T'.$a, $bono_a_pagar);
							}
							if ($trabajadores->n_cargo == "AYUDANTE") {
								$bono_a_pagar = 0;
								$objPHPExcel->getActiveSheet()->SetCellValue('T'.$a, $bono_a_pagar);								
							}
					//amonestaciones 
							$objPHPExcel->getActiveSheet()->SetCellValue('U'.$a, 0);
				//inasistentes
							$objPHPExcel->getActiveSheet()->SetCellValue('V'.$a, 0);
				//falta_dinero
							$objPHPExcel->getActiveSheet()->SetCellValue('W'.$a, 0);
				//rechazo_caja
							$objPHPExcel->getActiveSheet()->SetCellValue('X'.$a, 0);
				//rechazo_clientes
							$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$a, 0);
				//aseo
							$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$a, 0);
				//quejas
							$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$a, 0);	
				//B rechazo
				/*			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$a, 0); #edit 04-12-2017*/

						}else{
					//bono_buen_Servicio
							if ($trabajadores->n_cargo == "CHOFER") {
								if (!empty($get_ranking_trabajador)) {
									$porcentaje_rank = (isset($get_ranking_trabajador->total_rank)?
										$get_ranking_trabajador->total_rank: 0);
									if ($porcentaje_rank == 0) {
										$bono_a_pagar = 0;
									} 
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

									$objPHPExcel->getActiveSheet()->SetCellValue('T'.$a, $bono_a_pagar);
								}		
							}
							#Ayudante
							if ($trabajadores->n_cargo == "AYUDANTE") {
								if (!empty($get_ranking_trabajador)) {
									$porcentaje_rank = (isset($get_ranking_trabajador->total_rank)?
										$get_ranking_trabajador->total_rank: 0);
									if ($porcentaje_rank == 0) {
										$bono_a_pagar = 0;
									}
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

									$objPHPExcel->getActiveSheet()->SetCellValue('T'.$a, $bono_a_pagar);								
								}
							}
				//amonestaciones 
							$objPHPExcel->getActiveSheet()->SetCellValue('U'.$a, (isset($get_ranking_trabajador->amonestaciones)?$get_ranking_trabajador->amonestaciones: 0));
				//inasistentes
							$objPHPExcel->getActiveSheet()->SetCellValue('V'.$a, (isset($get_ranking_trabajador->inasistencias)?$get_ranking_trabajador->inasistencias: 0));
				//falta_dinero
							$objPHPExcel->getActiveSheet()->SetCellValue('W'.$a, (isset($get_ranking_trabajador->falta_dinero)?$get_ranking_trabajador->falta_dinero: 0));
				//rechazo_caja
							$objPHPExcel->getActiveSheet()->SetCellValue('X'.$a, (isset($get_ranking_trabajador->rechazos_cajas)?$get_ranking_trabajador->rechazos_cajas :0));
				//rechazo_clientes
							$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$a, (isset($get_ranking_trabajador->rechazos_clientes)?$get_ranking_trabajador->rechazos_clientes :0));	
				//aseo
							$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$a, 
								(isset($get_ranking_trabajador->aseo_mantencion)?$get_ranking_trabajador->aseo_mantencion:0));			
				//quejas
							$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$a, 
								(isset($get_ranking_trabajador->queja_reclamo)?$get_ranking_trabajador->queja_reclamo :0));	
						}
###						
						$bonoRechazo = $this->tla_informe_produccion->get_bono_rechazo($valores, $f_inicio, $f_termino);#edit 01-12-2017
							$obtieneBono = isset($bonoRechazo->diasTotalBono)?$bonoRechazo->diasTotalBono :0;
							if ($obtieneBono > 0) {
								$total = $obtieneBono*350;
							}else{
								$total = 0;
							}
							$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$a, $total);	
						$a++;
					}
				}
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save(BASE_URL2."extras/tla_excel/informes/informe_general".$fecha_inicio."_al_".$fecha_termino."_.xlsx");
		}

		$path = BASE_URL2.'/extras/tla_excel/informes/';
		$this->zip->read_dir($path, FALSE);
		$carpeta = BASE_URL2.'/extras/tla_excel/informes/';

		if (file_exists($carpeta)) {
			foreach(glob($carpeta . "/*") as $archivos_carpeta){
				if (is_dir($archivos_carpeta)){
				}else{
					unlink($archivos_carpeta);
				}
			}
		}
		$this->zip->download("informe_produccion_".$fecha_inicio."_al_".$fecha_termino."_Los_Angeles.zip");
	}

}

/* End of file produccion_nuevo.php */
/* Location: ./application/modules/transportes/controllers/produccion_nuevo.php */