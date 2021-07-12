<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

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
			$this->load->model('t_reporte_trabajador');
			$this->load->model('tla_informe_produccion');
			$this->load->model('tla_calcula_bono_produccion');
			$this->load->model('si_estandar_bono_chofer');
			$this->load->model('si_estandar_bono_peoneta');
			$this->load->model('Si_produccion_model');
			$this->load->model('tla_tabla_resumen');
			$this->load->model('tla_descuento_vuelta');

		}
	}

	public function cajas() {
		$base = array( 
			'head_titulo' => "Sistema Transporte - Cajas Movidas",
			'titulo' => "Reporte Cajas Movidas",
			'subtitulo' => '',
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js','js/seleccionar_todos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => TRUE,
			'menu' => $this->menu,
			);

		$pagina['listado_seleccion'] = $this->personal_model->listar();		
		$base['cuerpo'] = $this->load->view('transportes/reportes/cajas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function reporte_por_trabajador(){
		$base = array( 
			'head_titulo' => "Sistema Transporte - Cajas Movidas",
			'titulo' => "Reporte Cajas Movidas",
			'subtitulo' => 'Resumen por Trabajador',
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => TRUE,
			'menu' => $this->menu,
		);

		$fecha_inicio = $_POST['datepicker'];
		$fecha_termino = $_POST['datepicker2'];

		$fechaInicio= strtotime($fecha_inicio);
		$fechaFin= strtotime($fecha_termino);

		$f_inicio = $fecha_inicio;
		$f_termino = $fecha_termino;

		if ($fechaInicio > $fechaFin){
			echo "<script>alert('Debe ingresar una fecha mayor a la fecha de inicio')</script>";
			redirect('transportes/resumen/resumen_produccion','refresh');
		}

		//1.- borrar todos los registros de la tablar resumen produccion desde fecha inicio hasta fecha termino
		//2.- consultar todos los registros en la tabla registro produccion desde fecha inicio hasta fecha termino
		//3.- foreach consulta anterior
		//4.- por cada registro preguntar por cada trabajador y registrar datos en la tabla resumen produccion

		//paso 1
		$this->tla_tabla_resumen->borra_datos($fecha_inicio, $fecha_termino);


		$fechas_resumen = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$fechas_resumen[] = date('Y-m-d', $i);      
		}

		if (!empty($fechas_resumen)) {
			foreach ($fechas_resumen as $f) {
				$consular_produccion = $this->tla_tabla_resumen->consultar_produccion($f);

				//$actualiza_data = array('estado_cierre' => 1);
				//$this->tla_tabla_resumen->estado_cierre($actualiza_data, $f);
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


		/*$fechas_resumen = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$fechas_resumen[] = date('Y-m-d', $i);      
		}

		if (!empty($fechas_resumen)) {
			foreach ($fechas_resumen as $f) {
				
			}
		}*/



		$fechas_produccion = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$fechas_produccion[] = date('Y-m-d', $i);      
		}

		if (!empty($fechas_produccion)){
			foreach ($fechas_produccion as $fecha) {

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

						/*if ($consulta_bono_ruta_almacenada == 1) {
							$estandar_ruta_trabajador = 0;
						}else{							
							if ($listar->ruta == 10) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
							}							
						}*/

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
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

						/*if ($consulta_bono_ruta_almacenada == 1) {
							$estandar_ruta_trabajador = 0;
						}else{							
							if ($listar->ruta == 10) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
							}							
						}*/

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
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
							/*CAMION DE 2 PALLETS*/

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

						/*if ($consulta_bono_ruta_almacenada == 1) {
							$estandar_ruta_trabajador = 0;
						}else{							
							if ($listar->ruta == 10) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
							}							
						}*/

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
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
							/*CAMION DE 2 PALLETS*/

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

						/*if ($consulta_bono_ruta_almacenada == 1) {
							$estandar_ruta_trabajador = 0;
						}else{							
							if ($listar->ruta == 10) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
							}							
						}*/

						if ($listar->ruta == 10) {
							$estandar_ruta_trabajador = 0;
						}else{
							if ($consulta_bono_ruta_almacenada == 1) {
								$estandar_ruta_trabajador = 0;
							}else{
								$estandar_ruta_trabajador = 1600;
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
							/*CAMION DE 2 PALLETS*/

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



		$lista_aux = array();
		if (!empty($_POST['usuarios'])){
			foreach($_POST['usuarios'] as $row => $valores){
				$aux = new stdClass();
				$data = $this->t_reporte_trabajador->generar_reporte($fecha_inicio, $fecha_termino, $valores);
				$consulta_falla = $this->tla_informe_produccion->get_faltas_trabajador_ilegales($valores, $fecha_inicio, $fecha_termino);

				foreach ($data as $datos) {
					$aux->rut = (isset($datos->rut)?$datos->rut: "0");
					$aux->nombre = (isset($datos->nombre)?$datos->nombre: "0");
					$aux->ap = (isset($datos->ap)?$datos->ap: "0");
					$aux->am = (isset($datos->am)?$datos->am: "0");
					$aux->colectivo = (isset($datos->colectivo)?$datos->colectivo: "0");
					$aux->cargo = (isset($datos->cargo)?$datos->cargo: "0");
					$aux->caja = (isset($datos->cajas)?$datos->cajas: 0);
					$aux->vueltas = (isset($datos->vuelta)?$datos->vuelta: 0);
					$aux->clientes = (isset($datos->clientes)?$datos->clientes: 0);
					$aux->falla = (isset($consulta_falla->faltas_i)?$consulta_falla->faltas_i: 0);	
					array_push($lista_aux, $aux);
					unset($aux);
				}
			}
		}

		//print_r($lista_aux);
		$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
		$pagina['listar_reporte'] = $lista_aux;
		$base['cuerpo'] = $this->load->view('transportes/reportes/cajas_resumen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);

	}

	function reporte_cliente($fecha = FALSE){

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

		$base = array(
			'head_titulo' => "Sistema de Transportes Integra",
			'titulo' => "Empresa: Transportes Integra",
				'subtitulo' => "Transportes L.A",
			'side_bar' => true,
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js', 'js/tla_datapicker_fecha.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Total Clientes por Camión') ), 
			'menu' => $this->menu
		);



		$month = $mes;
		$year = $ano;
		$ultimo = date("d",(mktime(0,0,0,$month+1,1,$year)-1));

		

		$fechaInicio=strtotime($ano."-".$mes."-01");
		$fechaFin=strtotime($ano."-".$mes."-".$ultimo);

		
		$arr = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$arr[] = date('Y-m-d', $i);      
		}
		$todos_los_camiones = $this->Si_produccion_model->listar_camiones_codigo();
		$lista_aux = array();
		if (!empty($todos_los_camiones)){
			foreach ($todos_los_camiones as $cm) {
				$aux = new stdClass();
  				$aux->codigo_camion = $cm->codigo;
  				$pallets_camion_data = $this->Si_produccion_model->obtener_pallets_camion($cm->id_ccu);
  				$aux->pallets = $pallets_camion_data."- Pallets";
  				$aux->fechas = array();
  				if (!empty($arr)){
					foreach ($arr as $f){

						$aux2 = new stdClass();
						$get_clientes_camion = $this->tla_informe_produccion->clientes_camiones($f, $cm->id_ccu);
						$aux2->fecha_camion = $get_clientes_camion->suma_cliente;

						array_push($aux->fechas, $aux2);
						unset($aux2);
					}
				}

				array_push($lista_aux, $aux);
				unset($aux);
			}

		}


		$pagina['lista_aux'] = $lista_aux; 
		$pagina['fechas'] = $arr; 
		$pagina['fecha'] = $fecha_trabajar;
		$base['cuerpo'] = $this->load->view('reportes/reporte_cliente',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function reporte_cajas($fecha = FALSE){

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

		$base = array(
			'head_titulo' => "Sistema de Transportes Integra",
			'titulo' => "Empresa: Transportes Integra",
				'subtitulo' => "Transportes L.A",
			'side_bar' => true,
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js', 'js/tla_datapicker_fecha.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Total Cajas por Camión') ), 
			'menu' => $this->menu
		);



		$month = $mes;
		$year = $ano;
		$ultimo = date("d",(mktime(0,0,0,$month+1,1,$year)-1));

		

		$fechaInicio=strtotime($ano."-".$mes."-01");
		$fechaFin=strtotime($ano."-".$mes."-".$ultimo);

		
		$arr = array();
		for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){                 	
			$arr[] = date('Y-m-d', $i);      
		}
		$todos_los_camiones = $this->Si_produccion_model->listar_camiones_codigo();
		$lista_aux = array();
		if (!empty($todos_los_camiones)){
			foreach ($todos_los_camiones as $cm) {
				$aux = new stdClass();
  				$aux->codigo_camion = $cm->codigo;
  				$pallets_camion_data = $this->Si_produccion_model->obtener_pallets_camion($cm->id_ccu);
  				$aux->pallets = $pallets_camion_data." - Pallets";
  				$aux->fechas = array();
  				if (!empty($arr)){
					foreach ($arr as $f){

						$aux2 = new stdClass();
						$get_clientes_camion = $this->tla_informe_produccion->cajas_camiones($f, $cm->id_ccu);
						$aux2->fecha_camion = $get_clientes_camion->suma_cajas;


						array_push($aux->fechas, $aux2);
						unset($aux2);
					}
				}

				array_push($lista_aux, $aux);
				unset($aux);
			}

		}


		$pagina['lista_aux'] = $lista_aux; 
		$pagina['fechas'] = $arr; 
		$pagina['fecha'] = $fecha_trabajar;
		$base['cuerpo'] = $this->load->view('reportes/reporte_cajas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

}

/* End of file reportes.php */
/* Location: ./application/modules/transportes/controllers/reportes.php */