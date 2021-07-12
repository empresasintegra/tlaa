<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Home extends CI_Controller {
	function index() {
		$this->load->helper('browsers');
		if(getBrowser()){
			redirect('/home/cambiar_browser', 'refresh');
		}
		//$base['cuerpo'] = '';
		//$this -> load -> view('layout',$base);
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('usuarios/login/index', 'refresh');
		
		
	}
	function salir() {
		
	}
	
	function cambiar_browser(){
		$this->load->library('user_agent');
		if($this->agent->platform() == "Windows XP")
			$pag['url_ie'] = "http://www.microsoft.com/downloads/es-es/details.aspx?familyid=341c2ad5-8c3d-4347-8c03-08cdecd8852b";
		else
			$pag['url_ie'] = "http://windows.microsoft.com/es-ES/internet-explorer/products/ie/home";
		$this -> load -> view('cambiar_navegador',$pag);
	}

}
?>