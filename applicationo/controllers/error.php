<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Error extends CI_Controller {
	/*public $noticias;
	public $requerimiento;
	public function __construct()
   	{
    	parent::__construct();
    	$this->load->library('session');
		if($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		$this->load ->model("Requerimiento_model");
		$this->load->model("Noticias_model");
		$this->noticias['noticias_noleidas'] = $this -> Noticias_model -> cont_noticias_noleidas($this -> session -> userdata('id'));
		$this->requerimiento['requerimiento_noleidos'] = $this -> Requerimiento_model -> noleidas();
   	}
	function index() {
	}*/
	
	function error_404(){
		$base['titulo'] = "Pagina no encontrada";
		$base['lugar'] = "¡Houston, tenemos un problema!";
		
		$this -> load -> view('error/404',$base);
	}
}
?>