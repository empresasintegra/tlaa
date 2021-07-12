<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE) {
			echo "<script>alert('No puede acceder al contenido')</script>";
			redirect('/usuarios/login/index', 'refresh');
		} else {
			$this->load->model('si_bonos_model');
			$this->load->model('si_colectivo_model');
			$this->load->model('si_estandar_bono_chofer');
			$this->load->model('si_estandar_bono_peoneta');
		}
	}

	public function calculo_bonos($fecha = FALSE) {
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
			'head_titulo' => "Sistema Transporte - Personal",
			'titulo' => "Calculo de Bonos",
			'subtitulo' => '',
			'js' => array('js/confirm.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', 'js/si_rango_fechas.js', 'js/si_dymanic_trabajadores.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/lista_usuarios_req.js','js/si_selecciona_rango_fecha.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css','plugins/bootstrap-btns/css/btn.css'),
			'side_bar' => true,
			'menu' => $this -> load -> view('layout2.0/menus/menu_servicios_transportes','',TRUE)
			);

		/*for($i=$fecha_desde;$i<=$fecha_hasta;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
			echo $i."<br>";
		}*/

		$month = $mes;
		$year = $ano;
		$ultimo = date("d",(mktime(0,0,0,$month+1,1,$year)-1));

		

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
				$aux->fecha_trabajar = $rm;
				
				array_push($lista_aux, $aux);
				unset($aux);		
			}
			var_dump($lista_aux);
		}
		/*$pagina['lista_aux'] = $lista_aux;

		$pagina['usuario_id'] = $this->session->userdata('id');		
		$pagina['fecha'] = $fecha_trabajar;	
		$base['cuerpo'] = $this->load->view('transportes/bono/calculo_bono',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);*/
	}
}

/* End of file bonos.php */
/* Location: ./application/modules/transportes/controllers/bonos.php */