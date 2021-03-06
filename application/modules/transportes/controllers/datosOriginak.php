<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos extends CI_Controller {

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
    $this->load->helper('url');
    $this->load->model('datos_model');
    $this->load->model('si_rutas_model');
    $this->load->model('todos_los_trabajadores_model');
    $this->load->model('si_asignaciones_model');
    $this->load->model('Si_produccion_model');
    $this->load->model('si_estandar_bono_chofer');
    $this->load->model('si_estandar_bono_peoneta');
    $this->load->model('personal_model');
    $this->load->model('si_inasistentes_model');
  }
}

function resumen_trabajadores($fecha = FALSE){
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
   redirect('transportes/datos/resumen_trabajadores', 'refresh');
 }

 $base = array(
   'head_titulo' => "Sistema Transporte - Personal",
   'titulo' => "Ingreso de Producci??n",
   'subtitulo' => '',
  // 'side_bar' => false,
   'js' => array('js/confirm_elimina_trabajador.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_datepicker_trabajadores_diarios.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/evaluar_pgp.js'),
   'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/datos/resumen_trabajadores', 'txt' => 'Ingreso Produccion '), array('url' => '', 'txt' => 'Detalles ') ),  
   'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
   'side_bar' => true,
   'menu' => $this->menu,
   );

 $consulta_fecha_seleccionada = $this->personal_model->consulta_fecha_seleccionada($fecha_trabajar);

 if ($consulta_fecha_seleccionada == "NO") {
  $ultima_fecha_registrada = $this->personal_model->ultima_fecha_registrada($fecha_trabajar);
  $todos_los_trabajadores_al_dia = $this->personal_model->trabajadores_al_dia($ultima_fecha_registrada);

  foreach ($todos_los_trabajadores_al_dia as $key) {
    $crea_nuevos_datos = array(
      'id_persona' => $key->id_persona,
      'id_cargo' => $key->id_cargo,
      'id_instrumento_colectivo' => $key->id_instrumento_colectivo,
      'id_estado' => $key->id_estado,
      'estado_actual' => 6,
      'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar)),
      );

    $this->personal_model->crea_nuevo_registro($crea_nuevos_datos);
  }
}else{

}

$pagina['listar_faltas'] = $this->personal_model->tipo_inasistencia();
$pagina['trabajadores'] = $this->personal_model->listar_trabajadores_dia($fecha_trabajar);
$pagina['fecha'] = $fecha_trabajar;
$base['cuerpo'] = $this->load->view('transportes/datos/resumen_trabajadores', $pagina,TRUE);
$this->load->view('layout2.0/layout',$base);
}

public function continua_ingreso_produccion($fecha = false){
  $fecha_actual = $_POST['fecha_registro'];
  //actualizo estado_trabajadores
  if (isset($_POST['guardar'])){   
    foreach($_POST['trabajadores'] as $c => $valores){
      if (!empty($_POST['trabajadores'][$c])) {           
        $datas = array(
          'estado_actual' => $_POST['id_select_inasistencia'][$c],
          'comentario' => $_POST['comentario'][$c]); 
        //var_dump($datas);
        $this->personal_model->actualiza_estado_trabajadores($datas, $valores, $fecha_actual);
      }               
    }         
  }
  //print_r($fecha_actual);
  redirect('transportes/datos/upload/'.$fecha_actual.'', 'refresh');
}

function agrega_nuevo_registro_chofer($fecha = FALSE){
  $pagina['fecha'] = $fecha;
  $fecha_trabajar = $fecha;
  $pagina['nuevo_trabajador'] = $this->personal_model->listar_nuevos_trabajadores_choferes($fecha_trabajar);
  $this->load->view('transportes/datos/modal_agregar_nuevo_trabajador_chofer', $pagina);
}

function agrega_nuevo_registro_peoneta($fecha = FALSE){
  $pagina['fecha'] = $fecha;
  $fecha_trabajar = $fecha;
  $pagina['nuevo_trabajador'] = $this->personal_model->listar_nuevos_trabajadores_ayudante($fecha_trabajar);
  $this->load->view('transportes/datos/modal_agregar_nuevo_trabajador_peoneta', $pagina);
}

function agrega_trabajadores_dia(){
  $fecha_actual = $_POST['fecha_mostrar'];
  if (isset($_POST['actualizar'])){ 
    foreach($_POST['trabajador'] as $c => $valores){
      if (!empty($_POST['trabajador'][$c])) {           
        $datas = array(
          'id_persona' => $valores,
          'id_cargo' => $_POST['cargo'][$c],
          'id_instrumento_colectivo' => $_POST['colectivo'][$c],
          'estado_actual' => 6,
          'fecha_registro' => date('Y-m-d', strtotime($fecha_actual))
          );
        $this->personal_model->guarda_nuevos_trabajadores($datas);
      }               
    }
  }
  redirect('transportes/datos/resumen_trabajadores/'.$fecha_actual.'', 'refresh');
}

public function upload($fecha = FALSE, $numero_vuelta = FALSE){ ////////////////////////////////////////////////////////////////////////////////////////

  $this->load->model("datos_model");

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

 $vuelta_defecto = "1";
 if (empty($numero_vuelta)){
   redirect('transportes/datos/upload/'.$fecha_trabajar.'/'.$vuelta_defecto.'', 'refresh');
   $vuelta_trabajar = $vuelta_defecto;
 }else{
   $vuelta_trabajar = $numero_vuelta;
 }
 

 //borra datos bd
 //consulta si existe registro en la fecha a trabajar
 //$borro_registro_produccion = $this->Si_produccion_model->borro_registro_produccion($fecha_trabajar, $vuelta_trabajar);
 $base = array(
   'head_titulo' => "Sistema Transporte - Personal",
   'titulo' => "Ingreso de Producci??n",
   'subtitulo' => '',
   'side_bar' => false,
   'js' => array('js/confirm_elimina_trabajador.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/lista_usuarios_req.js','js/si_datepicker_vueltas.js'),
     'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'transportes/datos/resumen_trabajadores', 'txt' => 'Ingreso Produccion '), array('url' => '', 'txt' => 'Detalles ') ), 
   'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
  // 'side_bar' => TRUE,
   'menu' => $this->menu,
   );
 $pagina['usuario_id'] = $this->session->userdata('id');
 $pagina['usuario_subtipo'] = $this->session->userdata('subtipo');

 if($vuelta_trabajar > 1){
  $vuelta_consultar = $vuelta_trabajar - 1;
  $consulta_vuelta_almacenada = $this->Si_produccion_model->consulta_vuelta_almacenada($vuelta_consultar, $fecha_trabajar);
  if ($consulta_vuelta_almacenada == 0) {
   echo "<script>alert('No puede continuar si no ha guardado producci\u00F3n')</script>";
   redirect('transportes/datos/upload/'.$fecha_trabajar.'/'.$vuelta_consultar.'', 'refresh');
 }
} 
   //Extraer ultima fecha y ultima vuelta
$ultima_fecha = $this->Si_produccion_model->ultima_produccion_registrada_fecha($fecha_trabajar);
$ultima_vuelta = $this->Si_produccion_model->ultima_produccion_registrada_vuelta($ultima_fecha);

switch ($vuelta_trabajar) {
  case '1':

  $si_existe_vuelta = $this->Si_produccion_model->si_existe_vuelta($vuelta_trabajar, $fecha_trabajar);

  if ($si_existe_vuelta == 0) { 

    $tabla_produccion_trabajador = $this->Si_produccion_model->extraer_datos($ultima_fecha, $ultima_vuelta);
          //var_dump($tabla_produccion_trabajador);

    foreach ($tabla_produccion_trabajador as $tc) {
      $consultar_por_chofer = $this->Si_produccion_model->consultar_por_trabajador($tc->id_chofer, $fecha_trabajar);

      if ($consultar_por_chofer != 0) {
        $id_chofer = $tc->id_chofer;
      }else{
        $id_chofer = "0"; 
      }
      //revisar ,ma??ana!
      //ayudante 1
      $consultar_por_ayudante_1 = $this->Si_produccion_model->consultar_por_trabajador_ayudante_1($tc->id_ayudante_1, $fecha_trabajar);

      if ($consultar_por_ayudante_1 != 0) {
        $id_ayudante_1 = $tc->id_ayudante_1;
      }else{
        $id_ayudante_1 = "0"; 
      }  

      //ayudante 2
      $consultar_por_ayudante_2 = $this->Si_produccion_model->consultar_por_trabajador_ayudante_2($tc->id_ayudante_2, $fecha_trabajar);

      if ($consultar_por_ayudante_2 != 0) {
        $id_ayudante_2 = $tc->id_ayudante_2;

      }else{
        $id_ayudante_2 = "0"; 
      }

      //ayudante 3
      $consultar_por_ayudante_3 = $this->Si_produccion_model->consultar_por_trabajador_ayudante_3($tc->id_ayudante_3, $fecha_trabajar);

      if ($consultar_por_ayudante_3 != 0) {      
        $id_ayudante_3 = $tc->id_ayudante_3; 
      }else{
        $id_ayudante_3 = "0";
      }

      //ayudante 4
      $consultar_por_ayudante_4 = $this->Si_produccion_model->consultar_por_trabajador_ayudante_4($tc->id_ayudante_4, $fecha_trabajar);

      if ($consultar_por_ayudante_4 != 0) {
        $id_ayudante_4 = $tc->id_ayudante_4;
      }else{      
        $id_ayudante_4 = "0"; 
      }

      $guarda = array(
        'vuelta' => 1,
        'id_camion' =>$tc->id_camion,
        'id_chofer' =>$id_chofer,
        'id_ayudante_1' => $id_ayudante_1,
        'id_ayudante_2' => $id_ayudante_2,
        'id_ayudante_3' => $id_ayudante_3,
        'id_ayudante_4' => $id_ayudante_4,
        'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar)),
        );           

      if($tc->id_camion != "N/D"){
        $this->Si_produccion_model->guarda_datos($guarda); 
      }
    }
  }else{
           // echo "1";
  }
  break;

  case '2':
             //echo "<script>alert('$fecha_trabajar')</script>";
      $si_existe_vuelta = $this->Si_produccion_model->si_existe_vuelta($vuelta_trabajar, $fecha_trabajar);
      if ($si_existe_vuelta == 0) {
        $tabla_produccion_trabajador = $this->Si_produccion_model->extraer_datos($ultima_fecha, $ultima_vuelta);
        foreach ($tabla_produccion_trabajador as $tc) {
          $guarda = array(
            'vuelta' => 2,
            'id_camion' =>$tc->id_camion,
            'id_chofer' =>$tc->id_chofer,
            'id_ayudante_1' => $tc->id_ayudante_1,
            'id_ayudante_2' => $tc->id_ayudante_2,
            'id_ayudante_3' => $tc->id_ayudante_3,
            'id_ayudante_4' => $tc->id_ayudante_4,
            'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar))
            );
          if($tc->id_camion != "N/D")
            $this->Si_produccion_model->guarda_datos($guarda);   

    }
  }else{

  }
  break;

  case '3':
      $si_existe_vuelta = $this->Si_produccion_model->si_existe_vuelta($vuelta_trabajar, $fecha_trabajar);
      if ($si_existe_vuelta == 0) {
        $tabla_produccion_trabajador = $this->Si_produccion_model->extraer_datos($ultima_fecha, $ultima_vuelta);
        foreach ($tabla_produccion_trabajador as $tc) {
          $guarda = array(
            'vuelta' => 3,
            'id_camion' =>$tc->id_camion,
            'id_chofer' =>$tc->id_chofer,
            'id_ayudante_1' => $tc->id_ayudante_1,
            'id_ayudante_2' => $tc->id_ayudante_2,
            'id_ayudante_3' => $tc->id_ayudante_3,
            'id_ayudante_4' => $tc->id_ayudante_4,
            'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar))
            );
          if($tc->id_camion != "N/D")
            $this->Si_produccion_model->guarda_datos($guarda);   
    }
  }else{

  }
  break;

  case '4':
      $si_existe_vuelta = $this->Si_produccion_model->si_existe_vuelta($vuelta_trabajar, $fecha_trabajar);
      if ($si_existe_vuelta == 0) {
        $tabla_produccion_trabajador = $this->Si_produccion_model->extraer_datos($ultima_fecha, $ultima_vuelta);
        foreach ($tabla_produccion_trabajador as $tc) {            
          $guarda = array(
            'vuelta' => 4,
            'id_camion' =>$tc->id_camion,
            'id_chofer' =>$tc->id_chofer,
            'id_ayudante_1' => $tc->id_ayudante_1,
            'id_ayudante_2' => $tc->id_ayudante_2,
            'id_ayudante_3' => $tc->id_ayudante_3,
            'id_ayudante_4' => $tc->id_ayudante_4,
            'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar))
            );
          if($tc->id_camion != "N/D")
           $this->Si_produccion_model->guarda_datos($guarda);   
   }
 }else{

 }
 break;

 case '5':
     $si_existe_vuelta = $this->Si_produccion_model->si_existe_vuelta($vuelta_trabajar, $fecha_trabajar);
     if ($si_existe_vuelta == 0) {
      $tabla_produccion_trabajador = $this->Si_produccion_model->extraer_datos($ultima_fecha, $ultima_vuelta);
      foreach ($tabla_produccion_trabajador as $tc) {


        $guarda = array(
          'vuelta' => 5,
          'id_camion' =>$tc->id_camion,
          'id_chofer' =>$tc->id_chofer,
          'id_ayudante_1' => $tc->id_ayudante_1,
          'id_ayudante_2' => $tc->id_ayudante_2,
          'id_ayudante_3' => $tc->id_ayudante_3,
          'id_ayudante_4' => $tc->id_ayudante_4,
          'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar))
          );
        if($tc->id_camion != "N/D")
         $this->Si_produccion_model->guarda_datos($guarda);   

  }  
}else{

}
break;

default:
      # code...
break;
}

//si hay camion nuevo lo agrega al final de la lista

$consultar_ultimo_camion = $this->Si_produccion_model->consultar_ultimo_camion();
foreach ($consultar_ultimo_camion as $ultimo) {
  $data_almacenada = array(
    'id_camion' => $ultimo->id_ccu,
    'vuelta' => $vuelta_trabajar,
    'fecha_registro' => date('Y-m-d', strtotime($fecha_trabajar))
    );
        //var_dump($data_almacenada);
  $consulta_existe_camion_vuelta_nuevo = $this->Si_produccion_model->consulta_existe_camion_vuelta_nuevo($ultimo->id_ccu, $vuelta_trabajar , $fecha_trabajar);

  //var_dump($consulta_existe_camion_vuelta_nuevo);
  if ($consulta_existe_camion_vuelta_nuevo == 0) {
    $this->Si_produccion_model->guarda_ultimo_camion($data_almacenada);
  }  
}

// extrae datos desde bd camion_trabajador
$todos_los_camiones = $this->Si_produccion_model->listar_camiones_codigo();
$lista_aux = array();
if (!empty($todos_los_camiones)) {
  foreach ($todos_los_camiones as $listar) {
    $aux = new stdClass();
    $aux->codigo2 = $listar->codigo;
    $aux->codigo = $listar->id_ccu;
                //chofer
    $get_chofer_asignado = $this->Si_produccion_model->listar_choferes_asignados($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if($get_chofer_asignado == "N/D"){
      $chofer_asignado = $this->Si_produccion_model->listar_choferes_asignados("N/D");
    }else{
      $chofer_asignado = $this->Si_produccion_model->listar_choferes_asignados($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }
                //ayudante1
    $get_peoneta_1_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if($get_peoneta_1_asignado == "N/D"){
      $peoneta_1_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado("N/D");
    }else{
      $peoneta_1_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }

                //ayudante2
    $get_peoneta_2_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if($get_peoneta_2_asignado == "N/D"){
      $peoneta_2_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado("N/D");
    }else{
      $peoneta_2_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }
                //ayudante3
    $get_peoneta_3_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if($get_peoneta_3_asignado == "N/D"){
      $peoneta_3_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado("N/D");
    }else{
      $peoneta_3_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }
                //ayudante4
    $get_peoneta_4_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if($get_peoneta_4_asignado == "N/D"){
      $peoneta_4_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado("N/D");
    }else{
      $peoneta_4_asignado = $this->Si_produccion_model->listar_peoneta_1_asignado($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }

    $get_ruta_camion = $this->Si_produccion_model->listar_ruta_camion($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if ($get_ruta_camion == "N/D") {
      $id_ruta_seleccionada = $this->Si_produccion_model->listar_ruta_camion("N/D");
    }else{
      $id_ruta_seleccionada = $this->Si_produccion_model->listar_ruta_camion($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }

    $get_produccion_camion = $this->Si_produccion_model->listar_produccion_camion($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    if ($get_produccion_camion == "N/D") {
      $datos_produccion = $this->Si_produccion_model->listar_produccion_camion("N/D");
    }else{
      $datos_produccion = $this->Si_produccion_model->listar_produccion_camion($listar->id_ccu, $vuelta_trabajar, $fecha_trabajar);
    }

    $chofer_1 = $this->Si_produccion_model->mostrar_nombre_chofer($chofer_asignado->id_chofer);
    $peoneta_1 = $this->Si_produccion_model->mostrar_nombre_peoneta_1($peoneta_1_asignado->id_ayudante_1);
    $peoneta_2 = $this->Si_produccion_model->mostrar_nombre_peoneta_1($peoneta_2_asignado->id_ayudante_2);
    $peoneta_3 = $this->Si_produccion_model->mostrar_nombre_peoneta_1($peoneta_3_asignado->id_ayudante_3);
    $peoneta_4 = $this->Si_produccion_model->mostrar_nombre_peoneta_1($peoneta_4_asignado->id_ayudante_4);
    $ruta = $this->Si_produccion_model->mostrar_nombre_ruta($id_ruta_seleccionada->id_ruta);

                //datos_chofer
    $aux->chofer1_id = (isset($chofer_1->id)?$chofer_1->id:"");
    $aux->chofer1_nombre = (isset($chofer_1->nombre)?$chofer_1->nombre:"N/D");
    $aux->chofer1_ap = (isset($chofer_1->apellido_paterno)?$chofer_1->apellido_paterno:""); 
    $aux->chofer1_am = (isset($chofer_1->apellido_materno)?$chofer_1->apellido_materno:"");     
                //datos_peoneta_1
    $aux->peoneta1_id = (isset($peoneta_1->id)?$peoneta_1->id:"");
    $aux->peoneta1_nombre = (isset($peoneta_1->nombre)?$peoneta_1->nombre:"N/D");
    $aux->peoneta1_ap = (isset($peoneta_1->apellido_paterno)?$peoneta_1->apellido_paterno:"");  
    $aux->peoneta1_am = (isset($peoneta_1->apellido_materno)?$peoneta_1->apellido_materno:"");
                //datos_peoneta_2
    $aux->peoneta2_id = (isset($peoneta_2->id)?$peoneta_2->id:"");
    $aux->peoneta2_nombre = (isset($peoneta_2->nombre)?$peoneta_2->nombre:"N/D");
    $aux->peoneta2_ap = (isset($peoneta_2->apellido_paterno)?$peoneta_2->apellido_paterno:"");  
    $aux->peoneta2_am = (isset($peoneta_2->apellido_materno)?$peoneta_2->apellido_materno:"");
                //datos_peoneta_3
    $aux->peoneta3_id = (isset($peoneta_3->id)?$peoneta_3->id:"");
    $aux->peoneta3_nombre = (isset($peoneta_3->nombre)?$peoneta_3->nombre:"N/D");
    $aux->peoneta3_ap = (isset($peoneta_3->apellido_paterno)?$peoneta_3->apellido_paterno:"");  
    $aux->peoneta3_am = (isset($peoneta_3->apellido_materno)?$peoneta_3->apellido_materno:"");
                //datos_peoneta_4
    $aux->peoneta4_id = (isset($peoneta_4->id)?$peoneta_4->id:"");
    $aux->peoneta4_nombre = (isset($peoneta_4->nombre)?$peoneta_4->nombre:"N/D");
    $aux->peoneta4_ap = (isset($peoneta_4->apellido_paterno)?$peoneta_4->apellido_paterno:"");  
    $aux->peoneta4_am = (isset($peoneta_4->apellido_materno)?$peoneta_4->apellido_materno:"");

    $aux->ruta_id = (isset($ruta->id)?$ruta->id:"");
    $aux->nombre_ruta = (isset($ruta->nombre_rutas)?$ruta->nombre_rutas:"N/D");
    $aux->caja_rechazo = (isset($datos_produccion->caja_rechazo)?$datos_produccion->caja_rechazo:"");
    $aux->cliente_rechazo = (isset($datos_produccion->cliente_rechazo)?$datos_produccion->cliente_rechazo:"");
    $aux->caja_reales = (isset($datos_produccion->caja_reales)?$datos_produccion->caja_reales:"0");
    $aux->cliente_reales = (isset($datos_produccion->cliente_reales)?$datos_produccion->cliente_reales:"0");
    $aux->estado_cierre = (isset($datos_produccion->estado_cierre)?$datos_produccion->estado_cierre:"");
    $aux->caja_original = (isset($datos_produccion->cajas_original)?$datos_produccion->cajas_original:"0");
    $aux->cliente_original = (isset($datos_produccion->cliente_original)?$datos_produccion->cliente_original:"0");
    array_push($lista_aux, $aux);
    unset($aux);
  }
}

$pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
$pagina['lista_aux'] = $lista_aux;
$pagina['fecha_mostrar'] = $fecha_trabajar;

$pagina['vuelta_trabajar'] = $vuelta_trabajar;
$pagina['listarutas']= $this->si_rutas_model->listar_rutas();
$pagina['descontando'] = $this->datos_model->agrupar_cajas_rechazo($fecha_trabajar);
$base['cuerpo'] = $this->load->view('transportes/datos/gestion',$pagina,true);
$this->load->view('layout2.0/layout',$base);
}
function exportacion(){
  $this->load->view('transportes/datos/ficheroExcel');
}

function eliminar_trabajador_produccion_ch($fecha_mostrar = false, $vuelta_trabajar = false, $codigo = false,   $id = false){
 $codigo_camion = $codigo;
 $vuelta_trabajar_camion = $vuelta_trabajar;
 $id_trabajador = $id;
 $fecha_trabajar = $fecha_mostrar;
 $this->Si_produccion_model->eliminar_trabajador_camion_ch($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar);
 redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta_trabajar.'',  'refresh');
}

function eliminar_trabajador_produccion_p1($fecha_mostrar = false, $vuelta_trabajar = false, $codigo = false,   $id = false){
 $codigo_camion = $codigo;
 $vuelta_trabajar_camion = $vuelta_trabajar;
 $id_trabajador = $id;
 $fecha_trabajar = $fecha_mostrar;
 
 $this->Si_produccion_model->eliminar_trabajador_camion_p1($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar);
 redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta_trabajar.'', 'refresh');
}

function eliminar_trabajador_produccion_p2($fecha_mostrar = false, $vuelta_trabajar = false, $codigo = false,   $id = false){
 $codigo_camion = $codigo;
 $vuelta_trabajar_camion = $vuelta_trabajar;
 $id_trabajador = $id;
 $fecha_trabajar = $fecha_mostrar;
 
 $this->Si_produccion_model->eliminar_trabajador_camion_p2($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar);
 redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta_trabajar.'',  'refresh');
}

function eliminar_trabajador_produccion_p3($fecha_mostrar = false, $vuelta_trabajar = false, $codigo = false,   $id = false){
 $codigo_camion = $codigo;
 $vuelta_trabajar_camion = $vuelta_trabajar;
 $id_trabajador = $id;
 $fecha_trabajar = $fecha_mostrar;

 $this->Si_produccion_model->eliminar_trabajador_camion_p3($codigo_camion, $vuelta_trabajar_camion, $id_trabajador, $fecha_trabajar);
 redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta_trabajar.'',  'refresh');
}

function eliminar_trabajador_produccion_p4($fecha_mostrar = false, $vuelta_trabajar = false, $codigo = false,   $id = false){
 $codigo_camion = $codigo;
 $vuelta_trabajar_camion = $vuelta_trabajar;
 $id_trabajador = $id;
 $fecha_trabajar = $fecha_mostrar;
 
 $this->Si_produccion_model->eliminar_trabajador_camion_p4($codigo_camion, $vuelta_trabajar_camion, $id_trabajador , $fecha_trabajar);
 redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta_trabajar.'',  'refresh');
}


function modal_agregar_trabajador($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE, $codigo = FALSE ){
  $pagina['choferes'] = $this->Si_produccion_model->get_choferes($fecha_mostrar);
  $pagina['codigo'] = $codigo;
  $pagina['fecha'] = $fecha_mostrar;
  $pagina['vuelta'] = $vuelta_trabajar;
  $this->load->view('transportes/datos/modal_add_chofer', $pagina);
}

function add_chofer($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE){

  $id_camion = $_POST['id_camion'];
  $vuelta = $_POST['vuelta'];
  $fecha_mostrar = $_POST['fecha_mostrar'];

  $si_existe_registro_camion_t = $this->Si_produccion_model->consulta_si_existe_camion($id_camion, $vuelta, $fecha_mostrar);

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
        $arreglo_chofer_1 = $chofer[$x];                       
      }else {
        $arreglo_chofer_1 = ('0');
      }

      $guarda_registro = array(
        'id_chofer' => $arreglo_chofer_1,
        'estado' => 1);
      $this->Si_produccion_model->actualizar_registro_trabajadores_chofer($guarda_registro, $id_camion, $vuelta, $fecha_mostrar);
      echo "<script>alert('Se han Guardado los registros!!')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');


    }else{
      echo "<script>alert('Debe Seleccionar un Registro')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
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
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
    }

    $guarda_registro = array('id_camion' => $id_camion, 
      'id_chofer' => $arreglo_chofer_1,
      'estado' => 1);
    $this->Si_produccion_model->guarda_registro_trabajadores($guarda_registro);
    echo "<script>alert('Se han Guardado los registros!!')</script>";
    redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
  }
}
//peontea 1
function modal_agregar_trabajador_peoneta_1($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE, $codigo = FALSE ){

  //$pagina['peoneta'] = $this->Si_produccion_model->get_peonetas();
  $pagina['codigo'] = $codigo;
  $pagina['fecha'] = $fecha_mostrar;
  $pagina['vuelta'] = $vuelta_trabajar;
  $pagina['peoneta'] = $this->Si_produccion_model->get_peonetas($fecha_mostrar);
  $this->load->view('transportes/datos/modal_add_peoneta_1', $pagina);

}

function add_peoneta_1($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE){
  $id_camion = $_POST['id_camion'];
  $vuelta = $_POST['vuelta'];
  $fecha_mostrar = $_POST['fecha_mostrar'];
  $si_existe_registro_camion_t = $this->Si_produccion_model->consulta_si_existe_camion($id_camion, $vuelta, $fecha_mostrar);

  if ($si_existe_registro_camion_t == 1) {
    if (isset($_POST['peoneta'])) {

                //$id_chofer = $_POST['chofer'];
      $x = 0;
      foreach ($_POST['peoneta'] as $key1){
        $x += 1;
        $peoneta[$x] = $key1;
      }
      if ($peoneta[$x]){
        $id_peoneta_1 = $peoneta[$x];                     
      }else {
        $id_peoneta_1 = ('0');
      }


      $guarda_registro = array(
        'id_ayudante_1' => $id_peoneta_1,
        'estado' => 1);
      $this->Si_produccion_model->actualizar_registro_trabajadores_peoneta_1($guarda_registro, $id_camion, $vuelta, $fecha_mostrar);
      echo "<script>alert('Se han Guardado los registros!!')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');


    }else{
      echo "<script>alert('Debe Seleccionar un Registro')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
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
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
    }

    $guarda_registro = array('id_camion' => $id_camion, 
      'id_ayudante_1' => $arreglo_peoneta_1,
      'estado' => 1);
    $this->Si_produccion_model->guarda_registro_trabajadores_ayudante_1($guarda_registro);
    echo "<script>alert('Se han Guardado los registros!!')</script>";
    redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
  }
}

//peoneta 2
function modal_agregar_trabajador_peoneta_2($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE, $codigo = FALSE ){
  $pagina['peoneta'] = $this->Si_produccion_model->get_peonetas($fecha_mostrar);
  $pagina['codigo'] = $codigo;
  $pagina['fecha'] = $fecha_mostrar;
  $pagina['vuelta'] = $vuelta_trabajar;
  $this->load->view('transportes/datos/modal_add_peoneta_2', $pagina);
}

function add_peoneta_2($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE){
  $id_camion = $_POST['id_camion'];
  $vuelta = $_POST['vuelta'];
  $fecha_mostrar = $_POST['fecha_mostrar'];
  $si_existe_registro_camion_t = $this->Si_produccion_model->consulta_si_existe_camion($id_camion, $vuelta, $fecha_mostrar);

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


      $guarda_registro = array(
        'id_ayudante_2' => $id_peoneta_2,
        'estado' => 1);
      $this->Si_produccion_model->actualizar_registro_trabajadores_peoneta_2($guarda_registro, $id_camion, $vuelta, $fecha_mostrar);
      echo "<script>alert('Se han Guardado los registros!!')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');


    }else{
      echo "<script>alert('Debe Seleccionar un Registro')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
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
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
    }

    $guarda_registro = array('id_camion' => $id_camion, 
      'id_ayudante_2' => $arreglo_peoneta_2,
      'estado' => 1);
    $this->Si_produccion_model->guarda_registro_trabajadores_ayudante_2($guarda_registro);
    echo "<script>alert('Se han Guardado los registros!!')</script>";
    redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
  }
}

//peoneta 3
function modal_agregar_trabajador_peoneta_3($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE, $codigo = FALSE){
  $pagina['peoneta'] = $this->Si_produccion_model->get_peonetas($fecha_mostrar);
  $pagina['codigo'] = $codigo;
  $pagina['fecha'] = $fecha_mostrar;
  $pagina['vuelta'] = $vuelta_trabajar;
  $this->load->view('transportes/datos/modal_add_peoneta_3', $pagina);
}
function add_peoneta_3($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE){
  $id_camion = $_POST['id_camion'];
  $vuelta = $_POST['vuelta'];
  $fecha_mostrar = $_POST['fecha_mostrar'];
  $si_existe_registro_camion_t = $this->Si_produccion_model->consulta_si_existe_camion($id_camion, $vuelta, $fecha_mostrar);

  if ($si_existe_registro_camion_t == 1) {
    if (isset($_POST['peoneta'])) {

                //$id_chofer = $_POST['chofer'];
      $x = 0;
      foreach ($_POST['peoneta'] as $key1){
        $x += 1;
        $peoneta[$x] = $key1;
      }
      if ($peoneta[$x]){
        $id_peoneta_3 = $peoneta[$x];                       
      }else {
        $id_peoneta_3 = ('0');
      }

      $guarda_registro = array(
        'id_ayudante_3' => $id_peoneta_3,
        'estado' => 1);
      $this->Si_produccion_model->actualizar_registro_trabajadores_peoneta_3($guarda_registro, $id_camion, $vuelta, $fecha_mostrar);
      echo "<script>alert('Se han Guardado los registros!!')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');


    }else{
      echo "<script>alert('Debe Seleccionar un Registro')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
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
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
    }

    $guarda_registro = array('id_camion' => $id_camion, 
      'id_ayudante_3' => $arreglo_peoneta_2,
      'estado' => 1);
    $this->Si_produccion_model->guarda_registro_trabajadores_ayudante_3($guarda_registro);
    echo "<script>alert('Se han Guardado los registros!!')</script>";
    redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
  }
}
//peoneta 4
function modal_agregar_trabajador_peoneta_4($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE, $codigo = FALSE ){
  $pagina['peoneta'] = $this->Si_produccion_model->get_peonetas($fecha_mostrar);
  $pagina['codigo'] = $codigo;
  $pagina['fecha'] = $fecha_mostrar;
  $pagina['vuelta'] = $vuelta_trabajar;
  $this->load->view('transportes/datos/modal_add_peoneta_4', $pagina);
}

function add_peoneta_4($fecha_mostrar = FALSE, $vuelta_trabajar = FALSE){
  $id_camion = $_POST['id_camion'];
  $vuelta = $_POST['vuelta'];
  $fecha_mostrar = $_POST['fecha_mostrar'];
  $si_existe_registro_camion_t = $this->Si_produccion_model->consulta_si_existe_camion($id_camion, $vuelta, $fecha_mostrar);

  if ($si_existe_registro_camion_t == 1) {
    if (isset($_POST['peoneta'])) {

                //$id_chofer = $_POST['chofer'];
      $x = 0;
      foreach ($_POST['peoneta'] as $key1){
        $x += 1;
        $peoneta[$x] = $key1;
      }
      if ($peoneta[$x]){
        $id_peoneta_4 = $peoneta[$x];                       
      }else {
        $id_peoneta_4 = ('0');
      }


      $guarda_registro = array(
        'id_ayudante_4' => $id_peoneta_4,
        'estado' => 1);
      $this->Si_produccion_model->actualizar_registro_trabajadores_peoneta_4($guarda_registro, $id_camion, $vuelta, $fecha_mostrar);
      echo "<script>alert('Se han Guardado los registros!!')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');


    }else{
      echo "<script>alert('Debe Seleccionar un Registro')</script>";
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
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
      redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
    }

    $guarda_registro = array('id_camion' => $id_camion, 
      'id_ayudante_4' => $arreglo_peoneta_2,
      'estado' => 1);
    $this->Si_produccion_model->guarda_registro_trabajadores_ayudante_4($guarda_registro);
    echo "<script>alert('Se han Guardado los registros!!')</script>";
    redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vuelta.'', 'refresh');
  }
}

function guardar_produccion($fecha = false,$codigo_camion = false){
  $this->load->model("si_produccion_model");
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

        $id_ruta = $_POST['id_select_ruta'];  
  $vueltas = $_POST['vuelta_trabajar'];
  $fecha_mostrar = $_POST['fecha_mostrar'];   

  //borro registros segun fecha y vuelta trabajada

  $this->Si_produccion_model->borra_datos_de_resumen_dia_vuelta($fecha_mostrar, $vueltas); 
  //$this->Si_produccion_model->borra_datos_de_calculo_dia_vuelta($fecha_mostrar, $vueltas); 
  //$this->Si_produccion_model->borra_datos_vuelta_adicional_almacenada($fecha_mostrar, $vueltas);  

  foreach ($_POST['codigo_camion'] as $c => $valores) {
    if (!empty($_POST['cajas_reales'][$c]) || !empty($_POST['clientes_reales'][$c])) {

      $codigo_camion = $_POST['codigo_camion'][$c];
      $contar_tripulacion = $this->Si_produccion_model->ver_tripulacion_camion($codigo_camion, $vueltas, $fecha_mostrar);
      if (isset($contar_tripulacion)) {
              //tripulacion_defecto = 4
        $t_defecto = 4;
        $t_abordo_actual = $t_defecto - $contar_tripulacion['total'];
      }
      $datos = array(
        'id_ruta' => $_POST['id_select_ruta'][$c],
        //'caja_preventa' => $_POST['cajas_preventa'][$c],
        //'cliente_preventa' => $_POST['clientes_preventa'][$c],
        'caja_reales' => $_POST['cajas_reales'][$c],
        'cliente_reales' => $_POST['clientes_reales'][$c],
        'tripulacion_actual' => $t_abordo_actual,
        'estado_vuelta' => 1
        );
        //var_dump($datos); 
      $this->Si_produccion_model->guardar_produccion_camion($datos, $codigo_camion, $vueltas, $fecha_mostrar);
      //////////////////////////////////////////////////
      //COMIENZA EL CALCULO DE BONOS PARA TRABAJADORES//
      //////////////////////////////////////////////////
      $muestra_trabajadores = $this->Si_produccion_model->arreglo_trabajadores_camion($codigo_camion, $vueltas, $fecha_mostrar);
      $pallets_camion_data = $this->Si_produccion_model->obtener_pallets_camion($codigo_camion);
      
      foreach ($muestra_trabajadores as $datos_choferes_ingresados) {

        $chofer = array($datos_choferes_ingresados->id_chofer);
        $id_ayudante_1 = array($datos_choferes_ingresados->id_ayudante_1);
        $id_ayudante_2 = array($datos_choferes_ingresados->id_ayudante_2);
        $id_ayudante_3 = array($datos_choferes_ingresados->id_ayudante_3);
        $id_ayudante_4 = array($datos_choferes_ingresados->id_ayudante_4);

        $todos_los_trabajadores_con_produccion = array_merge($chofer, $id_ayudante_1, $id_ayudante_2, $id_ayudante_3, $id_ayudante_4);
        foreach ($todos_los_trabajadores_con_produccion as $key => $value) {          
          $id_trabajador = $todos_los_trabajadores_con_produccion[$key];
          $extraer_cargo = $this->si_produccion_model->extraer_cargo($id_trabajador);
          $extraer_tipo_contrato = $this->si_produccion_model->extraer_tipo_contrato($id_trabajador);

          $guardar_produccion_forma_2 = array(
            'id_camion' =>  $codigo_camion,
            'id_cargo' =>  $extraer_cargo,
            'id_convenio' =>  $extraer_tipo_contrato,            
            'id_trabajador' => $id_trabajador,
            'fecha_registro' => $fecha_mostrar,
            't_camion' => $pallets_camion_data,
            'vuelta' => $vueltas,
            'ruta' => $_POST['id_select_ruta'][$c],
            //'cajas_preventa' => $_POST['cajas_preventa'][$c],
            //'clientes_preventa' => $_POST['clientes_preventa'][$c],
            'cajas_reales' => $_POST['cajas_reales'][$c],
            'clientes_reales' => $_POST['clientes_reales'][$c],
            'tripulacion' => $t_abordo_actual
            );

          $actualiza_produccion_forma_2 = array(            
            't_camion' => $pallets_camion_data,
            'ruta' => $_POST['id_select_ruta'][$c],
            //'cajas_preventa' => $_POST['cajas_preventa'][$c],
            //'clientes_preventa' => $_POST['clientes_preventa'][$c],
            'cajas_reales' => $_POST['cajas_reales'][$c],
            'clientes_reales' => $_POST['clientes_reales'][$c],
            'tripulacion' => $t_abordo_actual
            );
          $si_existe_tabla_resumen = $this->Si_produccion_model->si_existe_en_tabla_resumen($id_trabajador, $fecha_mostrar, $vueltas, $codigo_camion);

          if($si_existe_tabla_resumen == "NO"){
            if ($id_trabajador == 0) {

            }else{
              $this->Si_produccion_model->guarda_tabla_resumen_1($guardar_produccion_forma_2);
              $ultimo_id_guardado = $this->db->insert_id();
            }
            
          }else{
            if ($id_trabajador == 0) {

            }else{
              $this->Si_produccion_model->actualiza_tabla_resumen_1($fecha_mostrar, $vueltas, $id_trabajador, $actualiza_produccion_forma_2);
              $ultimo_id_guardado = $si_existe_tabla_resumen->id;              
            }
          }
          //termina de guarda en tabla resumen produccion//
        }
      }

    }
  }

  redirect('transportes/datos/upload/'.$fecha_mostrar.'/'.$vueltas.'', 'refresh');
}



//controller de inasistencias//
/////////////////////////////

function inasistencias($fecha_trabajar = FALSE, $vuelta_trabajar = FALSE){
  //muestro los trabajdores inacistentes

  $base = array(
   'head_titulo' => "Sistema Transporte - Personal",
   'titulo' => "Ingreso de Inasistencias",
   'subtitulo' => '',
   'js' => array('js/confirm.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_datepicker_asistencia.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/lista_usuarios_req.js','js/si_datepicker_vueltas.js'),
   'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
   'side_bar' => true,
   'menu' => $this->menu,
   );
  $pagina['usuario_id'] = $this->session->userdata('id');
  $pagina['fecha_trabajar'] = $fecha_trabajar;
  $pagina['vueltas'] = $vuelta_trabajar;
  $pagina['trabajadores_inasistentes'] = $this->Si_produccion_model->mostrar_inasistentes($fecha_trabajar, $vuelta_trabajar);
  $base['cuerpo'] = $this->load->view('transportes/datos/inasistencias',$pagina,TRUE);
  $this->load->view('layout2.0/layout',$base);

}

/////*function guardar_inasistencias(){

/*  foreach($_POST['id_trabajador'] as $c => $valores) {
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
    $this->Si_produccion_model->guardar_tipo_inasistencia($guarda_inasistentes, $id_trabajador, $fecha_trabajar, $vuelta, $id_ccu);

  }
  redirect('transportes/datos/upload/'.$fecha_trabajar.'/'.$vuelta.'', 'refresh');
}*/

/*function expotar_datos($fecha_trabajar = FALSE, $vuelta_trabajar = FALSE){
  $this->load->library('PHPExcel');
  $this->load->library('zip');
  $this->load->helper('download');
  $objPHPExcel = new PHPExcel();
  $objReader = PHPExcel_IOFactory::createReader('Excel2007');
  $_archivo = "extras/exportar/inasistencias.xlsx";
  $objPHPExcel = $objReader->load(BASE_URL2.$_archivo);
  $objPHPExcel->setActiveSheetIndex(0);

  $trabajadores_inasistentes = $this->datos_model->consultar_trabajadores_inasistentes($fecha_trabajar, $vuelta_trabajar);
  foreach ($trabajadores_inasistentes as $row) {

  }

    //fin hoja bono tripack

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save(BASE_URL2."extras/exportar/inasistencias/".$fecha_trabajar.".xlsx");
      
    $path = BASE_URL2.'extras/exportar/inasistencias/';
    $this->zip->read_dir($path, FALSE);
    $carpeta = BASE_URL2.'extras/exportar/inasistencias/';
      //Elimino la gestion documental de ese cliente  
      if (file_exists($carpeta)) {
        foreach(glob($carpeta . "/*") as $archivos_carpeta){
              if (is_dir($archivos_carpeta)){
              }else{
                  unlink($archivos_carpeta);
              }
          }
        }

        $this->zip->download("si_liquidaciones_Talcahuano.zip");


      }*/

    }
    /* End of file datos.php */
/* Location: ./application/modules/transportes/controllers/datos.php */