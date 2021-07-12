<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class liquidacion extends CI_Controller {

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
			$this->load->model('tla_calcula_bono_produccion');
			$this->load->model('si_estandar_bono_chofer');
			$this->load->model('si_estandar_bono_peoneta');
			$this->load->model('Si_produccion_model');
			$this->load->model('tla_tabla_resumen');
			$this->load->model('tla_descuento_vuelta');
			$this->load->model('personal_model');
			$this->load->model('tla_informe_produccion');
			$this->load->model('tla_informe_asistencia');
			
		}

	}

public	function liquidaciones(){


 $this->load->model('tla_tabla_resumen');

$fecha_inicio1 = new DateTime('first day of previous month');
 $fecha_inicio = $fecha_inicio1->format('Y-m-d') ;
 


 $fecha_termino1 = new DateTime('last day of previous month');
 $fecha_termino = $fecha_termino1->format('Y-m-d');



$d_habiles = $this->tla_tabla_resumen->traer_dias_habiles($fecha_inicio,$fecha_termino);
 foreach ($d_habiles as $dias_h){
            	$dias_habiles = $dias_h;
            }


$fechaInicio= strtotime($fecha_inicio);
		$fechaFin= strtotime($fecha_termino);

		if ($fechaInicio > $fechaFin){
			echo "<script>alert('Debe ingresar una fecha mayor a la fecha de inicio')</script>";
			redirect('transportes/resumen/resumen_produccion','refresh');
		}

		//1.- borrar todos los registros de la tablar resumen produccion desde fecha inicio hasta fecha termino
		//2.- consultar todos los registros en la tabla registro produccion desde fecha inicio hasta fecha termino
		//3.- foreach consulta anterior
		//4.- por cada registro preguntar por cada trabajador y registrar datos en la tabla resumen produccion
		$dinero_bono_ruta = round(40000 / $dias_habiles);
		//paso 1
		$this->tla_tabla_resumen->borra_datos($fecha_inicio, $fecha_termino);

		

		
		for($i=$fecha_inicio;$i<=$fecha_termino;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
		    $fechas_resumen[]= $i;

		}
		

		if (!empty($fechas_resumen)) {
			foreach ($fechas_resumen as $f) {
				
				$consular_produccion = $this->tla_tabla_resumen->consultar_produccion($f);
				
				//cerrar mes campo bloqueado
				//cerrar dia produccion calculada
				$actualiza_data = array('estado_cierre' => 1);
				$this->tla_tabla_resumen->estado_cierre($actualiza_data, $f);
				

				foreach ($consular_produccion as $listar) {
					 if ($listar->caja_reales != 0 || $listar->cliente_reales != 0){

					 	if($listar->id_chofer != 0){
					 		$chofer = array($listar->id_chofer);
					 	}else{
					 		$chofer = array();
					 	}

					 	if($listar->id_ayudante_1 != 0){
					 		$id_ayudante_1 = array($listar->id_ayudante_1);
					 	}else{
					 		$id_ayudante_1 = array();
					 	}

					 	if($listar->id_ayudante_2 != 0){
					 		$id_ayudante_2 = array($listar->id_ayudante_2);
					 	}else{
					 		$id_ayudante_2 = array();
					 	}

					 	if($listar->id_ayudante_3 != 0){
					 		$id_ayudante_3 = array($listar->id_ayudante_3);
					 	}else{
					 		$id_ayudante_3 = array();
					 	}

					 	if($listar->id_ayudante_4 != 0){
					 		$id_ayudante_4 = array($listar->id_ayudante_4);
					 	}else{
					 		$id_ayudante_4 = array();
					 	}

					 	$pallets_camion_data = $this->Si_produccion_model->obtener_pallets_camion($listar->id_camion);
					 	$todos_los_trabajadores_con_produccion = array_merge($chofer, $id_ayudante_1, $id_ayudante_2, $id_ayudante_3, $id_ayudante_4);
					 	foreach ($todos_los_trabajadores_con_produccion as $key => $value) {         
					 		$id_trabajador = $todos_los_trabajadores_con_produccion[$key];
					 		$extraer_cargo = $this->Si_produccion_model->extraer_cargo($id_trabajador);
					 		$extraer_tipo_contrato = $this->Si_produccion_model->extraer_tipo_contrato($id_trabajador);
					 		$guardar_produccion_forma_2 = array(
					 			'id_camion' =>  $listar->id_camion,
					 			'id_cargo' =>  $extraer_cargo,
					 			'id_convenio' =>  $extraer_tipo_contrato,            
					 			'id_trabajador' => $id_trabajador,
					 			'fecha_registro' => $listar->fecha_registro,
					 			't_camion' => $pallets_camion_data,
					 			'vuelta' => $listar->vuelta,
					 			'ruta' => $listar->id_ruta,
					 			'cajas_reales' => $listar->caja_reales,
					 			'clientes_reales' => $listar->cliente_reales,
					 			'tripulacion' => $listar->tripulacion_actual
					 			);
					 		//var_dump($guardar_produccion_forma_2);
					 		$this->tla_tabla_resumen->guarda_tabla_resumen_1($guardar_produccion_forma_2);

					 	}
					 }
				}
			}
		}


		

		if (!empty($fechas_resumen)){
			foreach ($fechas_resumen as $fecha) {

				$this->Si_produccion_model->borra_datos_de_calculo_dia_vuelta($fecha); 
  				$this->Si_produccion_model->borra_datos_vuelta_adicional_almacenada($fecha);  

				$extraer_info_resumen_prod = $this->tla_calcula_bono_produccion->extraer_info($fecha);

				foreach ($extraer_info_resumen_prod as $listar) {
					$extraer_cargo = $listar->id_cargo;
					$extraer_tipo_contrato = $listar->id_convenio;

				 	//chofer contrato
					if ($extraer_cargo == 72 and $extraer_tipo_contrato == 21) {
          				//estandar_ruta         

            				//pallets_camion
						if ($listar->t_camion == 2) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);//bono en pesos
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_2($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}elseif ($listar->t_camion == 6) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_6($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_6($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_6($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}elseif ($listar->t_camion >= 8) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_8($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_8($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_8($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}

						$consulta_bono_ruta_almacenada = $this->tla_calcula_bono_produccion->buscar_ruta_guardada($listar->id_trabajador, $fecha);

						

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = $dinero_bono_ruta;
							}							
						}


						$bonos_calculados_trabajadores = array('id_trabajador' => $listar->id_trabajador,
							'cargo' => $extraer_cargo,
							'contrato' => $extraer_tipo_contrato,
							'id_tabla_resumen' => $listar->id,
							'fecha_registro' => $fecha,  
							'bono_ruta' => $estandar_ruta_trabajador,
							'tamano_camion' => $listar->t_camion,
							'vuelta' => $listar->vuelta,
							'cajas_reales' => $listar->cajas_reales,
							'clientes_reales' => $listar->clientes_reales,
							'bono_produccion' => $total_bono_produccion,
							'bono_cliente' => $total_bono_cliente,
							'bono_vuelta_adicional' => $vuelta_adicional,
							'total_bono_calculado' => $total_bono_produccion + $total_bono_cliente + $vuelta_adicional + $estandar_ruta_trabajador,
							);


						//var_dump($bonos_calculados_trabajadores);
						  	$this->Si_produccion_model->guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores);

						  	if ($listar->vuelta != 1) {
						  		$this->Si_produccion_model->guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores);
						  	}

					//chofer convenio
					}elseif ($extraer_cargo == 72 and $extraer_tipo_contrato == 22) {
          				//estandar_ruta              

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							$estandar_ruta_trabajador = $this->si_estandar_bono_chofer->estandar_ruta($extraer_cargo, $extraer_tipo_contrato);

						}

            				//pallets_camion
						if ($listar->t_camion == 2) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_2($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}elseif ($listar->t_camion == 6) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_6($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_6($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_6($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}elseif ($listar->t_camion >= 8) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_8($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_8($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_8($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}

						$consulta_bono_ruta_almacenada = $this->tla_calcula_bono_produccion->buscar_ruta_guardada($listar->id_trabajador, $fecha);

						

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = $dinero_bono_ruta;
							}							
						}



						$bonos_calculados_trabajadores = array('id_trabajador' => $listar->id_trabajador,
							'cargo' => $extraer_cargo,
							'contrato' => $extraer_tipo_contrato,
							'id_tabla_resumen' => $listar->id,
							'fecha_registro' => $fecha,  
							'bono_ruta' => $estandar_ruta_trabajador,
							'tamano_camion' => $listar->t_camion,
							'vuelta' => $listar->vuelta,
							'cajas_reales' => $listar->cajas_reales,
							'clientes_reales' => $listar->clientes_reales,
							'bono_produccion' => $total_bono_produccion,
							'bono_cliente' => $total_bono_cliente,
							'bono_vuelta_adicional' => $vuelta_adicional,
							'total_bono_calculado' => $total_bono_produccion + $total_bono_cliente + $vuelta_adicional + $estandar_ruta_trabajador,
							);
						//var_dump($bonos_calculados_trabajadores);
						$this->Si_produccion_model->guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores);

						if ($listar->vuelta != 1) {
							$this->Si_produccion_model->guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores);
						}
					//chofer sin nada
					}elseif ($extraer_cargo == 72 and $extraer_tipo_contrato == 23) {
          				//estandar_ruta              

						
						$estandar_ruta_trabajador = 0;
					

            				//pallets_camion
						if ($listar->t_camion == 2) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_2($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}elseif ($listar->t_camion == 6) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_6($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_6($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_6($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}elseif ($listar->t_camion >= 8) {
              				//bono_produccion
							$bono_produccion = $this->si_estandar_bono_chofer->estandar_bono_produccion_8($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
              				//calculo_bono_produccion
							$total_bono_produccion = $listar->cajas_reales * $bono_produccion;
              				//bono_cliente
							$bono_cliente = $this->si_estandar_bono_chofer->estandar_bono_cliente_8($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
							$total_bono_cliente = $listar->clientes_reales * $bono_cliente;
							if ($listar->vuelta > 1) {
								$vuelta_adicional = $this->si_estandar_bono_chofer->estandar_vuelta_adicional_8($extraer_tipo_contrato, $extraer_cargo, $listar->t_camion);
							}else{
								$vuelta_adicional = 0;
							}
						}

						$bonos_calculados_trabajadores = array('id_trabajador' => $listar->id_trabajador,
							'cargo' => $extraer_cargo,
							'contrato' => $extraer_tipo_contrato,
							'id_tabla_resumen' => $listar->id,
							'fecha_registro' => $fecha,  
							'bono_ruta' => $estandar_ruta_trabajador,
							'tamano_camion' => $listar->t_camion,
							'vuelta' => $listar->vuelta,
							'cajas_reales' => $listar->cajas_reales,
							'clientes_reales' => $listar->clientes_reales,
							'bono_produccion' => $total_bono_produccion,
							'bono_cliente' => $total_bono_cliente,
							'bono_vuelta_adicional' => $vuelta_adicional,
							'total_bono_calculado' => $total_bono_produccion + $total_bono_cliente + $vuelta_adicional + $estandar_ruta_trabajador,
							);
						//var_dump($bonos_calculados_trabajadores);
						$this->Si_produccion_model->guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores);

						if ($listar->vuelta != 1) {
							$this->Si_produccion_model->guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores);
						}
					//AYUDANTE CONTRATO
					}elseif ($extraer_cargo == 73 and $extraer_tipo_contrato == 21) {
          				
            			//pallets_camion
						if ($listar->t_camion == 2 ) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 1;
							}
							

							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						//CAMION DE 6 PALLETS
						}elseif ($listar->t_camion == 6) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 0;
							}
							
							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						//CAMION DE 8 PALLETS
						}elseif ($listar->t_camion >= 8) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante_8_pallets($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 0;
							}
							
							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						}

						$consulta_bono_ruta_almacenada = $this->tla_calcula_bono_produccion->buscar_ruta_guardada($listar->id_trabajador, $fecha);

						

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = $dinero_bono_ruta;
							}							
						}


						$bonos_calculados_trabajadores = array('id_trabajador' => $listar->id_trabajador,
							'cargo' => $extraer_cargo,
							'contrato' => $extraer_tipo_contrato,
							'id_tabla_resumen' => $listar->id,
							'fecha_registro' => $fecha, 
							'bono_ruta' => $estandar_ruta_trabajador,
							'tamano_camion' => $listar->t_camion,
							'vuelta' => $listar->vuelta,
							'cajas_reales' => $listar->cajas_reales,
							'clientes_reales' => $listar->clientes_reales,
							'bono_produccion' => $total_bono_produccion_ayudante,
							'bono_cliente' => $total_bono_clientes_ayudante,
							'bono_vuelta_adicional' => $vuelta_adicional_ayudante,
							'total_bono_calculado' => $estandar_ruta_trabajador + $total_bono_produccion_ayudante + $total_bono_clientes_ayudante + $vuelta_adicional_ayudante
							);
						//var_dump($bonos_calculados_trabajadores);
						$this->Si_produccion_model->guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores);

						if ($listar->vuelta != 1) {
							$this->Si_produccion_model->guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores);
						}
					//ayudante convenio                     
					}elseif ($extraer_cargo == 73 and $extraer_tipo_contrato == 22) {
          				
            			//pallets_camion
						if ($listar->t_camion == 2 ) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 1;
							}
						

							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						//CAMION DE 6 PALLETS
						}elseif ($listar->t_camion == 6) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 0;
							}
							
							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						//CAMION DE 8 PALLETS
						}elseif ($listar->t_camion >= 8) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante_8_pallets($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 0;
							}
							
							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						}

						$consulta_bono_ruta_almacenada = $this->tla_calcula_bono_produccion->buscar_ruta_guardada($listar->id_trabajador, $fecha);

						

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = $dinero_bono_ruta;
							}							
						}


						$bonos_calculados_trabajadores = array('id_trabajador' => $listar->id_trabajador,
							'cargo' => $extraer_cargo,
							'contrato' => $extraer_tipo_contrato,
							'id_tabla_resumen' => $listar->id,
							'fecha_registro' => $fecha, 
							'bono_ruta' => $estandar_ruta_trabajador,
							'tamano_camion' => $listar->t_camion,
							'vuelta' => $listar->vuelta,
							'cajas_reales' => $listar->cajas_reales,
							'clientes_reales' => $listar->clientes_reales,
							'bono_produccion' => $total_bono_produccion_ayudante,
							'bono_cliente' => $total_bono_clientes_ayudante,
							'bono_vuelta_adicional' => $vuelta_adicional_ayudante,
							'total_bono_calculado' => $estandar_ruta_trabajador + $total_bono_produccion_ayudante + $total_bono_clientes_ayudante + $vuelta_adicional_ayudante
							);
						//var_dump($bonos_calculados_trabajadores);
						$this->Si_produccion_model->guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores);

						if ($listar->vuelta != 1) {
							$this->Si_produccion_model->guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores);
						}
					//ayudante sin nada gil ql
					}elseif ($extraer_cargo == 73 and $extraer_tipo_contrato == 23) {
          				//estandar_ruta              
						
						$estandar_ruta_trabajador = 0;
						
            			//pallets_camion
						if ($listar->t_camion == 2 ) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 1;
							}
							

							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_2_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						//CAMION DE 6 PALLETS
						}elseif ($listar->t_camion == 6) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 0;
							}
							
							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_6_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						//CAMION DE 8 PALLETS
						}elseif ($listar->t_camion >= 8) {
              				//VUELTA ADICIONAL
							if ($listar->vuelta > 1) {
								$vuelta_adicional_ayudante = $this->si_estandar_bono_peoneta->bono_vuelta_adicional_ayudante_8_pallets($listar->t_camion, $extraer_tipo_contrato);
							}else{
								$vuelta_adicional_ayudante = 0;
							}
							
							if ($listar->tripulacion  == 1) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_1_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion == 2) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_2_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;

							}elseif ($listar->tripulacion >= 3) {
                				//BONO_PRODUCCION
								$bono_produccion_ayudante = $this->si_estandar_bono_peoneta->bono_produccion_tripulantes_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_produccion_ayudante = $listar->cajas_reales * $bono_produccion_ayudante;
                				//BONO_CLIENTE
								$bono_cliente_ayudante = $this->si_estandar_bono_peoneta->estandar_bono_cliente_ayudante_3_8_pallets($extraer_cargo, $extraer_tipo_contrato, $listar->t_camion);
								$total_bono_clientes_ayudante = $listar->clientes_reales * $bono_cliente_ayudante;


							}
						}


						$bonos_calculados_trabajadores = array('id_trabajador' => $listar->id_trabajador,
							'cargo' => $extraer_cargo,
							'contrato' => $extraer_tipo_contrato,
							'id_tabla_resumen' => $listar->id,
							'fecha_registro' => $fecha, 
							'bono_ruta' => $estandar_ruta_trabajador,
							'tamano_camion' => $listar->t_camion,
							'vuelta' => $listar->vuelta,
							'cajas_reales' => $listar->cajas_reales,
							'clientes_reales' => $listar->clientes_reales,
							'bono_produccion' => $total_bono_produccion_ayudante,
							'bono_cliente' => $total_bono_clientes_ayudante,
							'bono_vuelta_adicional' => $vuelta_adicional_ayudante,
							'total_bono_calculado' => $estandar_ruta_trabajador + $total_bono_produccion_ayudante + $total_bono_clientes_ayudante + $vuelta_adicional_ayudante
							);
						//var_dump($bonos_calculados_trabajadores);
						$this->Si_produccion_model->guarda_bonos_calculados_trabajadores($bonos_calculados_trabajadores);

						if ($listar->vuelta != 1) {
							$this->Si_produccion_model->guarda_resumen_vuelta_adicional($bonos_calculados_trabajadores);
						}
					}
				}
			}
		}

		//DESCUENTO VUELTAS ADICIONALES
		$todos_los_trabajadores = $this->tla_descuento_vuelta->todos_los_trabajadores($fecha_inicio, $fecha_termino);

		if (!empty($todos_los_trabajadores)){
			foreach ($todos_los_trabajadores as $trabajadores) {
				$get_faltas_trabajador = $this->tla_descuento_vuelta->get_faltas_trabajador($trabajadores->id, $fecha_inicio, $fecha_termino);

				$contador_faltas_chofer = $get_faltas_trabajador->faltas;

				$vueltas_adicionales_registradas = $this->tla_descuento_vuelta->get_vueltas_adicionales_registradas($trabajadores->id, $fecha_inicio, $fecha_termino);

				$contador_vueltas_adicionales = $vueltas_adicionales_registradas->vueltas;

				if ($contador_faltas_chofer >= $contador_vueltas_adicionales) {
					$buscar_vueltas_adicionales = $this->tla_descuento_vuelta->get_vueltas_adicionales_trabajador($trabajadores->id, $fecha_inicio, $fecha_termino, $contador_faltas_chofer);
					if (!empty($buscar_vueltas_adicionales)) {
						foreach ($buscar_vueltas_adicionales as $key => $value) {
							$vuelta_adicional = array('bono_vuelta_adicional' => 0);
							$this->tla_descuento_vuelta->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
						}
					}
				}elseif ($contador_faltas_chofer < $contador_vueltas_adicionales) {
					$buscar_vueltas_adicionales = $this->tla_descuento_vuelta->get_vueltas_adicionales_trabajador($trabajadores->id, $fecha_inicio, $fecha_termino, $contador_faltas_chofer);
					if (!empty($buscar_vueltas_adicionales)) {
						foreach ($buscar_vueltas_adicionales as $key => $value) {
							$vuelta_adicional = array('bono_vuelta_adicional' => 0);
							$this->tla_descuento_vuelta->actualiza_vuelta_adicional($value->id_trabajador, $value->fecha_registro, $value->vuelta, $vuelta_adicional);
						}
					}
				}
			}
		}

		
			//redirect('transportes/decidir/generar_informe/'.$fecha_inicio.'/'.$fecha_termino.'/'.$dias_habiles, 'refresh');


        
	     $this->load->model('t_genera_liquidaciones');


	     $this->load->library('PHPExcel');
		 $this->load->library('zip');
		 $this->load->helper('download');

		 $espacio = " ";
		 $trab = 0;


		$fechaInicio=strtotime($fecha_inicio);
		$fechaFin=strtotime($fecha_termino);


       if($dias_habiles != 0 and $dias_habiles != NULL){
			$dinero_bono_ruta = round(40000 / $dias_habiles);
		}else{
			$dinero_bono_ruta = 0;
		}

for($i=$fecha_inicio;$i<=$fecha_termino;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
		   // echo $i . "<br />";
		    $fechas_produccion[]= $i;
		}

$listados = $this->personal_model->listar_activos3($fecha_inicio, $fecha_termino);



			if (!empty($listados)){ //O
			foreach($listados as $row){ //O
				//faltas peoneta 

				
				$valores= $row->id_persona;
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

					
					
					$objPHPExcel->getActiveSheet()->SetCellValue('T8', $contador_faltas_chofer_2);

					

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

					
					$objPHPExcel->getActiveSheet()->SetCellValue('T8', $contador_faltas_chofer_sin_nada);

				

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
				
					$get_faltas_trabajador = $this->t_genera_liquidaciones->get_faltas_trabajador($valores, $fecha_inicio, $fecha_termino);

					$contador_faltas_peoneta_sin_nada = $contador_faltas_peoneta_sin_nada + $get_faltas_trabajador->faltas;													
					$objPHPExcel->getActiveSheet()->SetCellValue('T19', $contador_faltas_peoneta_sin_nada);

					

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
		//vuelta_adicional 
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
			
			$this->zip->archive(BASE_URL2."extras/tla_excel/liquidaciones_tla/tla_liquidaciones_1_Los_Angeles_desde".$fecha_inicio."_hasta".$fecha_termino.".zip");
		}
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
		}elseif($ano2 == '2019' and $mes2 == '09'){
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

		$listados = $this->personal_model->listar_activos3($fecha_inicio, $fecha_termino);

           $f_inicio = $fecha_inicio;
           $f_termino = $fecha_termino;

			if (!empty($listados)){ //O
			foreach($listados as $row){ //O
             $valores = $row->id_persona;

				$todos_los_trabajadores = $this->tla_informe_produccion->todos_los_trabajadores($valores, $f_inicio, $f_termino);
				//var_dump($todos_los_trabajadores);
				if (!empty($todos_los_trabajadores)){
					foreach ($todos_los_trabajadores as $trabajadores) {
						
						$trab += 1;

						

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


		$this->zip->archive(BASE_URL2."extras/tla_excel/liquidaciones_tla/informe_produccion_".$fecha_inicio."_al_".$fecha_termino."_Los_Angeles.zip");
		



		$f_inicio= $fecha_inicio;
		$f_termino= $fecha_termino;
		$fechaInicio=$fecha_inicio;
		$fechaFin=$fecha_termino;

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

		$fechas_produccion = array();
		$dia_once = 0;
		$fechaI = new DateTime($fecha_inicio);
			$fechaI->modify('first day of this month');
			$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
		$fechaT = new DateTime($fecha_termino);
			$fechaT->modify('last day of this month');
			$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31

		for($i=$fechaInicio;$i<=$fechaTermino;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
		    $fechas_produccion[]= $i;
		}

	//$dia_31 = array($i = '2017-08-31');
	//$fechas_produccion = array_merge($fechas_produccion, $dia_31);

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
			$objWriter->save(BASE_URL2."extras/tla_excel/informes/asistencia".$fecha_inicio.".xlsx");
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
		

		$this->zip->archive(BASE_URL2."extras/tla_excel/liquidaciones_tla/informe_mensual_descarga.zip");





$this->load->library('email');
$config['smtp_host'] = 'mail.empresasintegra.cl';
$config['smtp_user'] = 'informaciones@empresasintegra.cl';
$config['smtp_pass'] = '%SYkNLH1';
$config['mailtype'] = 'html';
$config['smtp_port']    = '2552';    
$this->email->initialize($config);
$this->email->from('informaciones@empresasintegra.cl', 'Liquidaciones TLA');
$this->email->to('remuneraciones@empresasintegra.cl, soporte@empresasintegra.cl');
$this->email->subject('Liquidaciones TLA');
//$this->email->attach(BASE_URL2."extras/tla_excel/liquidaciones_tla/tla_liquidaciones_1_Los_Angeles_desde".$fecha_inicio."_hasta".$fecha_termino.".zip",' Archivo Zip ');
//$this->email->attach(BASE_URL2."extras/tla_excel/liquidaciones_tla/informe_produccion_".$fecha_inicio."_al_".$fecha_termino."_Los_Angeles.zip",' Archivo Zip ');
$this->email->attach(BASE_URL2."extras/tla_excel/liquidaciones_tla/informe_mensual_descarga.zip",' Archivo Zip ');
$this->email->message('Generacion de liquidaciones con fecha'.date('d-m-Y'));
$this->email->send();

}

}
