<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		$this->load->library('session');
		$this->load->helper('browsers');
		if(getBrowser()){
			redirect('/home/cambiar_browser', 'refresh');
		}
		$this->load->model("tla_registro_sesion");
		$this->load->model('Usuarios_model');
	}

	function index(){
		$this->session->unset_userdata('reemplazo_final');
		$this->session->unset_userdata('usr_reemplazo');
		$this->session->unset_userdata('reemplazo');
		$this->load->view('login/login');
	}

	function cambiar_contrasena(){
	//	$pagina['contrasena']= $this->tla_registro_sesion->contrasena_usuario();
		$this->load->view('usuarios/login/cambiar_contrasena');
	}

	function actualizar_contrasena(){
		$rut = $_POST['rut'];
		$contrasena1 = $_POST['password']; // contraseña antigua
			$encriptando = new Usuarios_model();
			$clave = $encriptando->encriptar($contrasena1);
		$contrasena2 = $_POST['password2']; // contraseña nueva
			$encriptando2 = new Usuarios_model();
			$clave_codificada = $encriptando2->encriptar($contrasena2);
		$data = array(	
				'clave'=>$clave_codificada,
				);
		$this->Usuarios_model->actualizar_contrasena($rut, $clave, $data);
		//echo "<script>alert('Clave Modificada Exitosamente')</script>";
		redirect('usuarios/login', 'refresh');
	}

////////////////////Recuperar Contraseña//////////////////////////////////////////////////////////
	function recuperar_contrasena(){
	//	$pagina['contrasena']= $this->tla_registro_sesion->contrasena_usuario();
		$this->load->view('usuarios/login/recuperar_contrasena');
	}	

	function comprobar_correo(){

		$correo = $_POST['recuperar_contrasena'];
		$enviar_correo = $this->Usuarios_model->comprobar_correo($correo);
		//var_dump($enviar_correo);
		foreach ($enviar_correo as $key) {
			//$clave_usuario = $key->clave;

		    $encriptando = new Usuarios_model();
			$clave_usuario= $encriptando-> desencriptar($key->clave);
			$correo_usuario= $key->codigo_ingreso;
			$nombre_usuario = $key->nombres." ".$key->paterno;
			}
			// El mensaje
			$mensaje = "Hola ".$nombre_usuario."\n Recientemente as solicitado tu clave de acceso al portal http://tla.integraltda.cl.\n Su clave de acceso es: ".$clave_usuario."\n Recuerda que puedes modificar tu clave en el siguiente link : \r\n http://tla.integraltda.cl/usuarios/login/cambiar_contrasena";
			// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
			//$mensaje = wordwrap($mensaje, 70, "\r\n");
			// Enviarlo
			mail($correo_usuario, 'Recuperar clave', $mensaje);
		
		echo "<script>alert('Se a enviado clave a su correo')</script>";
		redirect('usuarios/login', 'refresh');
	}

/////////////////////////////////////////////////////////////////////////////////////////
	function validar(){
		$this->load->model('Usuarios_model');
		$this->load->model('tla_registro_sesion');
		$rut = strtoupper($_POST['rut']);
		$clave1 = $_POST['password'];
		$encriptando = new Usuarios_model();
		$clave = $encriptando->encriptar($clave1);
		//$passd = new Usuarios_model();
	//	$pass= $passd->desencriptar($clave);
	//	var_dump($pass);
		if(empty($rut) || empty($clave)){
			redirect('/usuarios/login/index', 'refresh');
		}
		
		$validar = $this->Usuarios_model->validar($rut,$clave);
		
		if(count($validar) > 0 ){ //el usario esta validado, existe y la contraseña es correcta
			$this->load->helper('ip');
			if( is_numeric($validar->tipo)){

				date_default_timezone_set('America/Santiago');
				$datos_sesion = array('usuario_id' => $validar->id,
					'fecha_ingreso' => date('Y-m-d G:i:s') 
					);
				$this->tla_registro_sesion->guardar_sesion($datos_sesion);
				$ultimo_id = $this->db->insert_id();

				
				$session = array(
					'rut' => $validar->rut,
					'nombres' => ucwords(mb_strtolower($validar->nombres,'UTF-8')),
					'id' => $validar->id,
					'tipo' => $validar->tipo,
					'subtipo' => $validar->subtipo,
					//'imagen' => $foto,
					//'imagen_barra' => $foto_barra,
					'navegador' => $_SERVER['HTTP_USER_AGENT'],
					'ip' => getRealIP(),
					'logged' => FALSE,
					'chat' => $validar->chat,
					'estado' => '1',
					'id_registro_login' => $ultimo_id,
					);
				$this->session->set_userdata($session);
			}

			if($validar->tipo == 1){
			//tipo 1 super usuario
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 1){
			//tipo 1 mandante
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 2){
			//tipo 2 trabajador
				$this->session->set_userdata('logged', TRUE);
				redirect('trabajador/', 'refresh');
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 3 ){
			//tipo 3 administrador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 5){
			//tipo 5 encargado herramientas
				$this->session->set_userdata('logged', TRUE);
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 6){
			//tipo 6 sub usuarios
				$this->session->set_userdata('logged', TRUE);
				redirect('subusuario/', 'refresh');
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 7){
			//tipo 7 solo consultar sobre usuarios
				$this->session->set_userdata('logged', TRUE);
				redirect('consulta/', 'refresh');
			}
			elseif($validar->tipo == 3 && $validar->subtipo == 99){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 105){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 106){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 107){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 108){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 109){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 110){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 111){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			elseif($validar->tipo == 6 && $validar->subtipo == 112){
			//tipo 99 moderador
				$this->session->set_userdata('logged', TRUE);
				redirect('usuarios/home/', 'refresh');
			}
			else
				redirect('/usuarios/login/index', 'refresh');
			
		}else{
			$validar = $this->Usuarios_model->validar2($rut,$clave);
			if(count($validar) > 0 ){ //el usario esta validado, existe y la contraseña es correcta
				$this->load->helper('ip');
				if( is_numeric($validar->tipo)){
					//$foto_existe = $this->Fotostrab_model->get_usuario($validar->id);
					//$foto = ( count($foto_existe) > 0 ) ? $foto_existe->thumb : 'extras/img/perfil/avatar.jpg' ;
					$session = array(
						'codigo_ingreso' => $validar->codigo_ingreso,
						'id' => $validar->id,
						'tipo' => $validar->tipo,
						'subtipo' => $validar->subtipo,
						//'imagen' => $foto,
						'navegador' => $_SERVER['HTTP_USER_AGENT'],
						'ip' => getRealIP(),
						'logged' => FALSE,
						'chat' => $validar->chat,
						'estado' => '1'
						);
					$this->session->set_userdata($session);
				}
				
				if($validar->tipo == 1){
				//tipo 1 super usuario
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 1){
				//tipo 1 mandante
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 2){
				//tipo 2 trabajador
					$this->session->set_userdata('logged', TRUE);
					redirect('trabajador/', 'refresh');
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 3 ){
				//tipo 3 administrador
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 5){
				//tipo 5 encargado herramientas
					$this->session->set_userdata('logged', TRUE);
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 6){
				//tipo 6 sub usuarios
					$this->session->set_userdata('logged', TRUE);
					redirect('subusuario/', 'refresh');
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 7){
				//tipo 7 solo consultar sobre usuarios
					$this->session->set_userdata('logged', TRUE);
					redirect('consulta/', 'refresh');
				}
				elseif($validar->tipo == 3 && $validar->subtipo == 99){
				//tipo 99 moderador
					$this->session->set_userdata('logged', TRUE);
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 105){
					//tipo 105 admin de contrato tccu talcahuano
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 106){
					//tipo 106 admin de contrato tccu temuco
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 107){
					//tipo 107 admin de contrato tccu chillan
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 108){
					//tipo 108 jefe servicios tccu
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 109){
			//tipo 99 moderador
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 110){
					//tipo 110 administrativo
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 111){
			//tipo 99 moderador
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				elseif($validar->tipo == 6 && $validar->subtipo == 112){
			//tipo 99 moderador
					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				else
					redirect('/usuarios/login/index', 'refresh');

			}
			else {
				redirect('/usuarios/login/index', 'refresh');
			}
		}
			
	}

	function salir(){
		$this->load->model('tla_registro_sesion');
		date_default_timezone_set('America/Santiago');
		$datos_sesion_salir = array('fecha_egreso' =>  date('Y-m-d G:i:s'), );
		$id_registro_login = $this->session->userdata('id_registro_login');
		$this->tla_registro_sesion->actualizar_cierre_sesion($datos_sesion_salir, $id_registro_login);
		$this->session->destroy();
		redirect('/usuarios/login', 'refresh');
	}

	
}

/* End of file login.php */
/* Location: ./application/modules/usuarios/controller/login.php */