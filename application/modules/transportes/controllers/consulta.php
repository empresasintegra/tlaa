<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Consulta extends CI_Controller {	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model("consulta_model");
		$this->load->model("Si_codigos_model");
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

	function index($fecha = FALSE){
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
		 if ($fecha_trabajar > $fecha_hoy) {
		   echo "<script>alert('La fecha seleccionada no puede ser mayor a la de hoy')</script>";
		   redirect('transportes/consulta/', 'refresh');
		 }
		 $base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Detalles Camion * vuelta",
			 'js' => array('js/confirm_elimina_trabajador.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_datepicker_codigo.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js','tables/js/jquery.dataTables.min.js','tables/js/dataTables.bootstrap.min.js','tables/js/responsive.bootstrap.min.js','tables/js/dataTables.buttons.min.js','tables/js/buttons.bootstrap.min.js','tables/js/jszip.min.js','tables/js/buttons.html5.min.js','tables/export.js','tables/popover-dias.js'),
			   'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/datos/resumen_trabajadores', 'txt' => 'Ingreso Produccion '), array('url' => '', 'txt' => 'Detalles ') ),  
			   'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css','tables/css/bootstrap.css','tables/css/dataTables.bootstrap.min.css','tables/css/responsive.bootstrap.min.css','tables/css/buttons.bootstrap.min.css','tables/css/bootstrap.css','tables/css/dataTables.bootstrap.min.css','extras/layout/tables/css/responsive.bootstrap.min.css','tables/css/buttons.bootstrap.min.css'),
			'subtitulo' => '',
			'side_bar' => false,
			'menu' => $this->menu,
			);
		$pagina['fecha'] = $fecha_trabajar;
		//$pagina['codigosccu'] = $this->consulta_model->consultar_codigosccu();
			$produccion = $this->consulta_model->consultar_produccion($fecha_trabajar);
			$listado = array();
	  		foreach($produccion as $rm){
	  			$auxiliar = new stdClass();
				$todos_los_camiones = $this->Si_codigos_model->obtener_id($rm->id_camion);
				$auxiliar->codigo2 = $todos_los_camiones->codigos_ccu;
				foreach ($produccion as $vuelta) {
					if ($rm->id_camion == $vuelta->id_camion) {
						if ($vuelta->vuelta==1) {
							$auxiliar->vuelta1 = $vuelta->caja_rechazo;
						}
						if ($vuelta->vuelta==2) {
							$auxiliar->vuelta2 = $vuelta->caja_rechazo;
						}
						if ($vuelta->vuelta==3) {
							$auxiliar->vuelta3 = $vuelta->caja_rechazo;
						}
						if ($vuelta->vuelta==4) {
							$auxiliar->vuelta4 = $vuelta->caja_rechazo;
						}
						if ($vuelta->vuelta==5) {
							$auxiliar->vuelta5 = $vuelta->caja_rechazo;
						}	
						$person1  = $this->Si_codigos_model->getNombrePersona($vuelta->id_chofer);
						$person2  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_1);
						$person3  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_2);
						$person4  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_3);
						$person5  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_4);
						$auxiliar->chofer= isset($person1->nombre)?$person1->nombre." ".$person1->apellido_paterno:'N/N';						
						$auxiliar->ayudante1= isset($person2->nombre)?$person2->nombre." ".$person2->apellido_paterno:'';						
						$auxiliar->ayudante2=isset($person3->nombre)?$person3->nombre." ".$person3->apellido_paterno:'';					
						$auxiliar->ayudante3= isset($person4->nombre)?$person4->nombre." ".$person4->apellido_paterno:'';					
						$auxiliar->ayudante4= isset($person5->nombre)?$person5->nombre." ".$person5->apellido_paterno:'';		
					}
				}
			//	$auxiliar->caja_rechazo = $rm->caja_rechazo;
			array_push($listado, $auxiliar);
      	  	unset($auxiliar);
      	  }  	
        //$pagina['lista_aux'] = $lista_aux;
        $pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('transportes/consulta/gestion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function consulta_por_mes($fecha = FALSE){
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
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Detalles Camion * vuelta",
			 'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_datepicker_consulta_mes.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js','tables/js/jquery.dataTables.min.js','tables/js/dataTables.bootstrap.min.js','tables/js/responsive.bootstrap.min.js','tables/js/dataTables.buttons.min.js','tables/js/buttons.bootstrap.min.js','tables/js/jszip.min.js','tables/js/buttons.html5.min.js','tables/export.js','tables/popover-dias.js'),
			   'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Cajas Rechazadas Por Vuelta ')),  
			   'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css','tables/css/bootstrap.css','tables/css/dataTables.bootstrap.min.css','tables/css/responsive.bootstrap.min.css','tables/css/buttons.bootstrap.min.css','tables/css/bootstrap.css','tables/css/dataTables.bootstrap.min.css','extras/layout/tables/css/responsive.bootstrap.min.css','tables/css/buttons.bootstrap.min.css'),
			'subtitulo' => '',
			'side_bar' => false,
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
			foreach ($arr as $a) {
				//print_r($rm);
				$aux = new stdClass();
				$produccion = $this->consulta_model->consultar_produccion($a);
						$aux->adiario = array();
				  		foreach($produccion as $rm){
				  			$auxiliar = new stdClass();
							$todos_los_camiones = $this->Si_codigos_model->obtener_id($rm->id_camion);
							$auxiliar->codigo2 = $todos_los_camiones->codigos_ccu;
							foreach ($produccion as $vuelta) {
								if ($rm->id_camion == $vuelta->id_camion) {
									if ($vuelta->vuelta==1) {
										$auxiliar->vuelta1 = $vuelta->caja_rechazo;
										$auxiliar->caja1= $vuelta->cajas_original;
									}
									if ($vuelta->vuelta==2) {
										$auxiliar->vuelta2 = $vuelta->caja_rechazo;
										$auxiliar->caja2= $vuelta->cajas_original;

									}
									if ($vuelta->vuelta==3) {
										$auxiliar->vuelta3 = $vuelta->caja_rechazo;
										$auxiliar->caja3= $vuelta->cajas_original;

									}
									if ($vuelta->vuelta==4) {
										$auxiliar->vuelta4 = $vuelta->caja_rechazo;
										$auxiliar->caja4= $vuelta->cajas_original;

									}
									if ($vuelta->vuelta==5) {
										$auxiliar->vuelta5 = $vuelta->caja_rechazo;
										$auxiliar->caja5= $vuelta->cajas_original;

									}	
									$person1  = $this->Si_codigos_model->getNombrePersona($vuelta->id_chofer);
									$person2  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_1);
									$person3  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_2);
									$person4  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_3);
									$person5  = $this->Si_codigos_model->getNombrePersona($vuelta->id_ayudante_4);
									$auxiliar->chofer= isset($person1->nombre)?$person1->nombre." ".$person1->apellido_paterno:'N/N';						
									$auxiliar->ayudante1= isset($person2->nombre)?$person2->nombre." ".$person2->apellido_paterno:'';						
									$auxiliar->ayudante2=isset($person3->nombre)?$person3->nombre." ".$person3->apellido_paterno:'';					
									$auxiliar->ayudante3= isset($person4->nombre)?$person4->nombre." ".$person4->apellido_paterno:'';					
									$auxiliar->ayudante4= isset($person5->nombre)?$person5->nombre." ".$person5->apellido_paterno:'';
								}
							}		
						array_push($aux->adiario, $auxiliar);
			      	  	unset($auxiliar);
			      	  }  
			      	  $aux->fechas=$a; //Fecha diaria
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$pagina['fecha'] = $fecha_trabajar;
		$base['cuerpo'] = $this->load->view('transportes/consulta/gestion2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


}
?>