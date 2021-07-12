<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class camion extends CI_Controller {

  public function __construct(){
      parent::__construct();
      $this->load->library('session');
      if ($this->session->userdata('logged') == FALSE) {
        echo "<script>alert('No puede acceder al contenido')</script>";
        redirect('/usuarios/login/index', 'refresh');
      } else{
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
        $this->load->model('si_camiones_model');
        $this->load->model('Si_codigos_model');
        $this->load->model('tla_auditoria_registros');
      }
  }

  function index(){
    $this->load->model("si_camiones_model");


    $base = array(
      'head_titulo' => "Sistema Transporte - Camiones",
      'titulo' => "Listado de Camiones",
      'subtitulo' => '',
      'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
      'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
      'side_bar' => true,
      'menu' => $this->menu,
      );

    $pagina['usuario_subtipo'] = $this->session->userdata('subtipo');
    $pagina['camion'] = $this->si_camiones_model->listar();    
    $pagina['codigos'] = $this->Si_codigos_model->listar_camion();

    $base['cuerpo'] = $this->load->view('transportes/camiones/gestion',$pagina,TRUE);
    $this->load->view('layout2.0/layout',$base);
  }

  function guardar_camion(){

    $patente = trim($_POST['patente_data']);
    $marca = trim($_POST['id_select_marca']);
    $ano = trim($_POST['ano']);
    $capacidad = trim($_POST['capacidad']);
    $pallets = trim($_POST['pallets']);

    if(empty($patente)){
      echo "<script>alert('Complete el campo Patente!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($marca)){
      echo "<script>alert('Complete el campo Marca!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($ano)){
      echo "<script>alert('Complete el campo Año!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($capacidad)){
      echo "<script>alert('Complete el campo Capacidad!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($pallets)){
      echo "<script>alert('Complete el campo Pallets!')</script>";
      redirect('transportes/camion', 'refresh');
    }


    $si_existe_patente = $this->si_camiones_model->consulta_registro_patente($_POST['patente_data']);

    if ($si_existe_patente == 1) {
      echo "<script>alert('La patente que trata de ingresar ya esta registrada!')</script>";
      redirect('transportes/camion', 'refresh');
    }elseif($si_existe_patente == 0){
      $data = array(
        'patente' => strtoupper($_POST['patente_data']),
        'marca' => $_POST['id_select_marca'],
        'ano' => $_POST['ano'],
        'capacidad' => $_POST['capacidad'],
        'pallets' => $_POST['pallets'],
      );
      $this->si_camiones_model->ingresar($data);
      $ultimo_id_camion = $this->db->insert_id();
      
      

      date_default_timezone_set('America/Santiago');
      $auditoria_camion = array('tabla_id' => "camion_".$ultimo_id_camion, 
          'usuario_id' => $this->session->userdata('id'),
          'fecha' => date('Y-m-d G:i:s'),
          'accion' => 1,
          'nombre'=>"Camión ".$_POST['patente_data']." fue ingresado.",
          );

      $this->tla_auditoria_registros->guarda_auditoria_camion($auditoria_camion);

      $si_existe_codigo_camion = $this->si_camiones_model->consulta_registro($_POST['id_select_codigo']);

      if($si_existe_codigo_camion == 1){
        $this->si_camiones_model->actualiza_dato($_POST['id_select_codigo']);
        $data1 = array('codigo_ccu' => $_POST['id_select_codigo'],
          'codigo_camion' => $ultimo_id_camion,
          'estado' => 1,
          

          
        );

        $this->si_camiones_model->guarda_datos($data1);
        $ultimo_id_ccu = $this->db->insert_id();

 

        date_default_timezone_set('America/Santiago');
        $auditoria_camion = array('tabla_id' => "ccu_camion_".$ultimo_id_ccu, 
          'usuario_id' => $this->session->userdata('id'),
          'fecha' => date('Y-m-d G:i:s'),
          'accion' => 1,
          'nombre'=> NULL,
      
          );

        $this->tla_auditoria_registros->guarda_auditoria_camion_ccu($auditoria_camion);

      }elseif($si_existe_codigo_camion == 0) {

        $data1 = array('codigo_ccu' => $_POST['id_select_codigo'],
          'codigo_camion' => $ultimo_id_camion,
          'estado' => 1,
        );
        $this->si_camiones_model->guarda_datos($data1);
        $ultimo_id_ccu = $this->db->insert_id();

      
        date_default_timezone_set('America/Santiago');

        $auditoria_camion = array('tabla_id' => "ccu_camion_".$ultimo_id_ccu, 
          'usuario_id' => $this->session->userdata('id'),
          'fecha' => date('Y-m-d G:i:s'),
          'accion' => 1,
          'nombre'=> NULL,
           
          );

        $this->tla_auditoria_registros->guarda_auditoria_camion_ccu($auditoria_camion);
      }   
      redirect('transportes/camion', 'refresh');
    }
  } 


  function actualiza_camion(){

    $patente = trim($_POST['patente_data']);
    $marca = trim($_POST['id_select_marca']);
    $ano = trim($_POST['ano']);
    $capacidad = trim($_POST['capacidad']);
    $pallets = trim($_POST['pallets']);

    if(empty($patente)){
      echo "<script>alert('Complete el campo Patente!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($marca)){
      echo "<script>alert('Complete el campo Marca!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($ano)){
      echo "<script>alert('Complete el campo Año!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($capacidad)){
      echo "<script>alert('Complete el campo Capacidad!')</script>";
      redirect('transportes/camion', 'refresh');
    }
    if(empty($pallets)){
      echo "<script>alert('Complete el campo Pallets!')</script>";
      redirect('transportes/camion', 'refresh');
    }

    $id = $_POST['id_camion'];
   
    

    $data = array(
      'patente' => strtoupper($_POST['patente_data']),
      'marca' => $_POST['id_select_marca'],
      'ano' => $_POST['ano'],
      'capacidad' => $_POST['capacidad'],
      'pallets' => $_POST['pallets']
    );

    $patente2=$this->si_camiones_model->listar1($id);
    $pallets2=$this->si_camiones_model->listar2($id);
    $marca2=$this->si_camiones_model->listar3($id);
    $ano2=$this->si_camiones_model->listar4($id);
    $capacidad2=$this->si_camiones_model->listar5($id);
    
    
     //este no se muestra bien
   //inicio
    if($marca!=$marca2){
    
         $this->si_camiones_model->actualizar_camiones($id,$data);
                
         date_default_timezone_set('America/Santiago');
         $auditoria_camion = array('tabla_id' => "camion_".$id, 
            'usuario_id' => $this->session->userdata('id'),
            'fecha' => date('Y-m-d G:i:s'),
            'accion' => 2,
            'nombre'=>"Camión ".$patente = trim($_POST['patente_data'])." fue actualizado de marca ".$marca2." a ".$_POST['id_select_marca'].".",
          );
            
          $this->tla_auditoria_registros->actualizar_auditoria_camion($auditoria_camion);    
     }
   //fin
   

    if($patente != $patente2 ){

        $this->si_camiones_model->actualizar_camiones($id,$data); 
    
        date_default_timezone_set('America/Santiago');
        $auditoria_camion = array('tabla_id' => "camion_".$id, 
           'usuario_id' => $this->session->userdata('id'),
           'fecha' => date('Y-m-d G:i:s'),
           'accion' => 2,
           'nombre'=>"Camión ".$patente2." fue actualizado de ".$patente2." a ".$_POST['patente_data'].".",
        );
   
        $this->tla_auditoria_registros->actualizar_auditoria_camion($auditoria_camion);  
  
    } 
  
           //hasta aquí   
  
    if($pallets!=$pallets2){
    
        $this->si_camiones_model->actualizar_camiones($id,$data);
          
        date_default_timezone_set('America/Santiago');
        $auditoria_camion = array('tabla_id' => "camion_".$id, 
           'usuario_id' => $this->session->userdata('id'),
           'fecha' => date('Y-m-d G:i:s'),
           'accion' => 2,
           'nombre'=>"Camión ".$patente2." fue actualizado de ".$pallets2." a ".$_POST['pallets']." pallets.",
        );
      
        $this->tla_auditoria_registros->actualizar_auditoria_camion($auditoria_camion);    
    
   } 
      
  

    if($ano!=$ano2){
    
          $this->si_camiones_model->actualizar_camiones($id,$data);
                      
          date_default_timezone_set('America/Santiago');
          $auditoria_camion = array('tabla_id' => "camion_".$id, 
             'usuario_id' => $this->session->userdata('id'),
             'fecha' => date('Y-m-d G:i:s'),
             'accion' => 2,
             'nombre'=>"Camión ".$patente = trim($_POST['patente_data'])." fue actualizado de año ".$ano2." a ".$_POST['ano'].".",
          );
                  
           $this->tla_auditoria_registros->actualizar_auditoria_camion($auditoria_camion);    
      
    } 

  
     if($capacidad!=$capacidad2){
    
           $this->si_camiones_model->actualizar_camiones($id,$data);
                                      
           date_default_timezone_set('America/Santiago');
           $auditoria_camion = array('tabla_id' => "camion_".$id, 
           'usuario_id' => $this->session->userdata('id'),
           'fecha' => date('Y-m-d G:i:s'),
           'accion' => 2,
           'nombre'=>"Camión ".$patente = trim($_POST['patente_data'])." fue actualizado de capacidad ".$capacidad2." a ".$_POST['capacidad'].".",
          );
                                           
          $this->tla_auditoria_registros->actualizar_auditoria_camion($auditoria_camion);    
    
    } 
 
          redirect('transportes/camion', 'refresh'); 

  }
 


  function modal_editar($id_camion){
    $pagina['data_camion'] = $this->si_camiones_model->get_camion($id_camion);
    $id1= $this->si_camiones_model->get_camion($id_camion);
    $this->load->view('transportes/camiones/modal_editar_camion', $pagina);
  }

  function eliminar($codigo_ccuc = false, $id_camion = false){
      if (empty($codigo_ccuc) && empty($id_camion)) {
        echo "<script>alert('Vacio')</script>";
        redirect('transportes/camion', 'refresh');
      }  
      $this->si_camiones_model->eliminar($codigo_ccuc);
      $this->si_camiones_model->actualizar_camiones_estado($id_camion);

      date_default_timezone_set('America/Santiago');
        $auditoria_camion = array('tabla_id' => "codigo_ccu".$codigo_ccuc, 
          'usuario_id' => $this->session->userdata('id'),
          'fecha' => date('Y-m-d G:i:s'),
          'accion' => 3,
          );

      $this->tla_auditoria_registros->eliminar_auditoria_camion_ccu($auditoria_camion);

      date_default_timezone_set('America/Santiago');
        $auditoria_camion = array('tabla_id' => "camion_".$id_camion, 
          'usuario_id' => $this->session->userdata('id'),
          'fecha' => date('Y-m-d G:i:s'),
          'accion' => 3,
          );

      $this->tla_auditoria_registros->eliminar_auditoria_camion($auditoria_camion);

      echo "<script>alert('Registro Eliminado')</script>";
      redirect('transportes/camion', 'refresh');
    }
}
