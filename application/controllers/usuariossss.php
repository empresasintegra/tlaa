<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Usuarios extends CI_Controller {
	function index() {
		//$base['cuerpo'] = '';
		//$this -> load -> view('layout',$base);
	}
	/*function lista_usuarios() {
		$this->load->model("Usuarios_model");
		foreach ($this->Usuarios_model->listar_msj($_POST['queryString']) as $l){
			echo '<li onClick="fill(\''.ucfirst( mb_strtolower( $l->nombres.' '.$l->paterno.' '.$l->materno, 'UTF-8')).'\',\''.$l->id.'\');">'.ucfirst( mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno, 'UTF-8')).'</li>';
		}
	}*/
	
	// function actualizar_clave(){
		// $this->load->model("Usuarios_model");
		// foreach ($this->Usuarios_model->listar_cantidad(5063,5070) as $lista){
			// //echo $lista->clave."<br/>";
			// $data = array(
				// 'clave' => hash("sha512", $lista->clave)
			// );
			// $this->Usuarios_model->editar($lista->id,$data);
		// }
	// }
		
}
?>