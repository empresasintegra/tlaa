<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Forzar_descarga extends CI_Controller {
		
		function index($f){
			$f = urldecode($f);
			echo $f;
			$fx = base_url().$f;
			$arh = basename($fx);
			echo $fx;
			$this->output->set_header("HTTP/1.0 200 OK");
			$this->output->set_header("HTTP/1.1 200 OK");
			$this->output->set_header("Content-type: application/octet-stream");
			$this->output->set_header("Content-Disposition: attachment; filename=\"$arh\"\n");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			readfile($fx);
		}
}
?>