<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Empresas integra - Acceso a sistema</title>
		<link href="<?php echo base_url() ?>extras/css/reseter_v2.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/login2.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/jquery-1.7.1.min.js" type="text/javascript"></script>
		<link href="<?php echo base_url() ?>extras/js/lightbox/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/lightbox/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.placeholder.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/login.js" type="text/javascript"></script>
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		</script>
		<!--<script src="<?php echo base_url() ?>extras/js/DD_roundies_0.0.2a-min.js"></script>
		<script type="text/javascript">
		DD_roundies.addRule('.btn', '4px');
		DD_roundies.addRule('#login_panel', '8px');
		DD_roundies.addRule('#login_panel2', '8px');
		DD_roundies.addRule('#login .login_actions', '0 0 8px 8px');
		</script> -->
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div id="login_splash">
					<div id="img_logo">
						<!--<img src="<?php echo base_url() ?>extras/img/casco_logo.png" />-->
						<br><br><br><br>
						<img src="<?php echo base_url() ?>extras/img/logo-footer.jpg" />
						<h2 class="titulo">SGO</h2>
					</div>
				</div>
		    	<div id="content">
		    		<div id="auth_dialog_container" class="login_form">
		    			<div id="auth_dialog">
		    				<h3><span>Ingrese con sus datos</span></h3>
		    				<form action="<?php echo base_url() ?>login/validar" method="post" novalidate="" style="display: block; ">
		    					<div class="big_input control_holder">
		    						<label style="display: none" class="main_label" for="login_form_email">Rut </label>
		    						<input name="rut" id="login_form_rut" tabindex="1" class="text_field" type="email" placeholder="Rut o Codigo">
		    					</div>
		    					<div class="big_input control_holder">
		    						<label style="display: none" class="main_label" for="login_form_password">Contraseña</label>
		    						<input name="password" id="login_form_password" tabindex="2" type="password" class="password_field" placeholder="Contraseña">
		    					</div>
		    					<div class="login_action">
		    						<div class="control_holder login_form_remember_holder">
		    							<!--
		    							<a href="<?php echo base_url() ?>extras/Recorrido_Bus_EST_-_Minibuses_de_Acercamiento.pdf" target="_blank" id="manual">Recorrido Buses Planta Nueva Aldea PGP 2013</a><br/>
		    							<a href="<?php echo base_url() ?>extras/Manual_de_Usuario_SGO_Integra_EST_rev2.pdf" target="_blank" id="manual">Descargar Manual de Usuario</a>
		    							<a href="<?php echo base_url() ?>login/recordar">¿Perdió su contraseña?</a>
		    							|-->
		    						</div>
		    						<div class="button_holder">
		    							<button tabindex="5" class="default" type="submit" accesskey="s">Ingresar</button>
		    						</div>
		    					</div>
		    					<input type="hidden" name="submitted" value="submitted" style="display: none">
		    				</form>
		    				
					</div>
				</div>
			</div>
			</div>
			</div>
	</body>
</html>