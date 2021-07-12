<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cajas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE) {
			echo "<script>alert('No puede acceder al contenido')</script>";
			redirect('/usuarios/login/index', 'refresh');
		} else {
			//cargar modelos
			$this->load->model('tla_cierre_diario');
			$this->load->model('si_estandar_bono_chofer');
			$this->load->model('si_estandar_bono_peoneta');
		}
	}



	public function menu1(){

 

		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Caja Choferes",
			'subtitulo' => "<br><p><p><strong><p class='text-danger'> <br>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			 &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			 &nbsp;Instrumento Colectivo Sindicato</p>   </strong>.</p></p>",
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			 );

		
		
         $pagina['estandar_bono_chofer'] = $this->si_estandar_bono_chofer->listar1();  
		 $base['cuerpo'] = $this->load->view('transportes/cajas/guia',$pagina,TRUE);
		 $this->load->view('layout2.0/layout',$base);


	}

	public function menu2(){

 

		$base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;Valor Caja Choferes",
			'subtitulo' => "<br><p><p><strong><p class='text-danger'> <br>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			 &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			 &nbsp;Instrumento Colectivo Convenio</p>   </strong>.</p></p>",
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			 );

		    $pagina['estandar_bono_chofer'] = $this->si_estandar_bono_chofer->listar2();  
		    $base['cuerpo'] = $this->load->view('transportes/cajas/guia',$pagina,TRUE);
		    $this->load->view('layout2.0/layout',$base);


	}

	public function menu3(){

 

		     $base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Caja Choferes",
			'subtitulo' => "<br><p><p><strong><p class='text-danger'> <br>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			 &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			 &nbsp;Sin Instrumento Colectivo </p>   </strong>.</p></p>",
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			);
            $pagina['estandar_bono_chofer'] = $this->si_estandar_bono_chofer->listar3();  
		    $base['cuerpo'] = $this->load->view('transportes/cajas/guia',$pagina,TRUE);
		    $this->load->view('layout2.0/layout',$base);


	}

	public function menu4(){

 

		     $base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Caja Ayudantes",
			'subtitulo' => "<br><p><p><strong><p class='text-danger'> <br> &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			 &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			 &nbsp;Instrumento Colectivo Sindicato</p>   </strong>.</p></p>",
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			 );

		    $pagina['estandar_bono_peoneta'] = $this->si_estandar_bono_peoneta->listar1();  
		    $base['cuerpo'] = $this->load->view('transportes/cajas/guia2',$pagina,TRUE);
		    $this->load->view('layout2.0/layout',$base);


	}

	public function menu5(){

 

		$base = array(
			
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Caja Ayudantes",
			'subtitulo' => "<br><p><p><strong><p class='text-danger'> <br> &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			 &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			 &nbsp;Instrumento Colectivo Convenio</p>   </strong>.</p></p>",
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			 );
            $pagina['estandar_bono_peoneta'] = $this->si_estandar_bono_peoneta->listar2();  
	        $base['cuerpo'] = $this->load->view('transportes/cajas/guia2',$pagina,TRUE);
		    $this->load->view('layout2.0/layout',$base);


	}

	public function menu6(){

 

		     $base = array(
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbspValor Caja Ayudantes",
			'subtitulo' => "<br><p><p><strong><p class='text-danger'> <br> &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
			 &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			 &nbsp;Sin Instrumento Colectivo </p>   </strong>.</p></p>",
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js','js/si_rango_informe_produccion.js', 'js/lista_usuarios_req.js', 'js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			 );
            $pagina['estandar_bono_peoneta'] = $this->si_estandar_bono_peoneta->listar3();  
	        $base['cuerpo'] = $this->load->view('transportes/cajas/guia2',$pagina,TRUE);
		    $this->load->view('layout2.0/layout',$base);


	}


	function actualizar(){

		$id = trim($_POST['id']);
		if (empty($id)) {
			echo "<script>alert('Debe completar los campos!')</script>";
			redirect('transportes/cajas', 'refresh');
		}
		
		
		$data = array(
			'id' => $_POST['id'],
			'bono_en_pesos' => $_POST['bono_en_pesos'],);
			$id_instrumento_colectivo=trim($_POST['id_instrumento_colectivo']);


			if($id_instrumento_colectivo=='21'){
				$this->si_estandar_bono_chofer->actualizar_caja($id,$data);
		

		date_default_timezone_set('America/Santiago');

       
		echo "<script>alert('Registro Actualizado')</script>";
		redirect('transportes/cajas/menu1', 'refresh');	
			}

			
			if($id_instrumento_colectivo=='22'){
				$this->si_estandar_bono_chofer->actualizar_caja($id,$data);
		

		date_default_timezone_set('America/Santiago');

       
		echo "<script>alert('Registro Actualizado')</script>";
		redirect('transportes/cajas/menu2', 'refresh');	
			}

			
			if($id_instrumento_colectivo=='23'){
				$this->si_estandar_bono_chofer->actualizar_caja($id,$data);
		

		date_default_timezone_set('America/Santiago');

       
		echo "<script>alert('Registro Actualizado')</script>";
		redirect('transportes/cajas/menu3', 'refresh');	
			}
	}

	function actualizar2(){


		$id = trim($_POST['id']);
		if (empty($id)) {
			echo "<script>alert('Debe completar los campos!')</script>";
			redirect('transportes/cajas', 'refresh');
		}
		
		
		$data = array(
			'id' => $_POST['id'],
			'bono_en_pesos' => $_POST['bono_en_pesos'],
			
			);
		
			$id_instrumento_colectivo=trim($_POST['id_instrumento_colectivo']);


			if($id_instrumento_colectivo=='21'){
				$this->si_estandar_bono_peoneta->actualizar_caja2($id,$data);
		

		date_default_timezone_set('America/Santiago');

       
		echo "<script>alert('Registro Actualizado')</script>";
		redirect('transportes/cajas/menu4', 'refresh');	
			}

			
			if($id_instrumento_colectivo=='22'){
				$this->si_estandar_bono_peoneta->actualizar_caja2($id,$data);
		

		date_default_timezone_set('America/Santiago');

       
		echo "<script>alert('Registro Actualizado')</script>";
		redirect('transportes/cajas/menu5', 'refresh');	
			}

			
			if($id_instrumento_colectivo=='23'){
				$this->si_estandar_bono_peoneta->actualizar_caja2($id,$data);
		

		date_default_timezone_set('America/Santiago');

       
		echo "<script>alert('Registro Actualizado')</script>";
		redirect('transportes/cajas/menu6', 'refresh');	
			}
	}

	function modal_editar($id){
		$pagina['estandar_bono_chofer']= $this->si_estandar_bono_chofer->get_cajas($id);
		$this->load->view('transportes/cajas/modal_editar_cajas', $pagina);
	}

	function modal_editar2($id){
		$pagina['estandar_bono_peoneta']= $this->si_estandar_bono_peoneta->get_cajas2($id);
		$this->load->view('transportes/cajas/modal_editar_cajas2', $pagina);
	}

	
	
	
}