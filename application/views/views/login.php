<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Empresas integra - Acceso a sistema</title>
		<link href="<?php echo base_url() ?>extras/css/reseter_v2.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/login.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/jquery-1.7.1.min.js" type="text/javascript"></script>
		<link href="<?php echo base_url() ?>extras/js/lightbox/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/lightbox/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
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
		<div id="login">
			<h1>Ingreso a sistema</h1>
			<div id="login_panel">
				<form action="<?php echo base_url() ?>login/validar" method="post">		
					<div class="login_fields ingresar">
						<div class="field">
							<label for="email">Rut</label>
							<input type="text" name="rut" value="" id="rut" tabindex="1">		
						</div>
						
						<div class="field">
							<label for="password">Contraseña <small><a id="perdio_pass" href="#">Perdio su contraseña?</a></small></label>
							<input type="password" name="password" value="" id="password" tabindex="2">			
						</div>
					</div> <!-- .login_fields -->	
					<div class="login_fields recuperar" style="display: none; height: 0;">
						<p>Favor ingrese su RUT. Se le generará una nueva contraseña</p><br/>
						<div class="field">
							<label for="email">Rut</label>
							<input type="text" name="rut_r" value="" id="rut_r" tabindex="1" >		
						</div>
						
					</div>
					<div class="login_fields final1" style="display: none; height: 0;">
						<p>Se ha enviado un correo electrónico con las indicaciones para la recuperación de la contraseña a su correo.</p><br/>
					</div>
					<div class="login_fields final2" style="display: none; height: 0;">
						<p>Usted no posee un correo electrónico, se ha enviado una solicitud de recuperación de contraseña a la administracion, favor espere nuestro llamado, pronto nos comunicaremos con usted.</p><br/>
					</div>
					<div class="login_fields error" style="display: none; height: 0;">
						<p>El rut ingresado no existe o tenemos un problema con el envío de correos, favor intente mas tarde.</p><br/>
					</div>
					<div class="login_actions">
						<button type="submit" class="btn primary" tabindex="3">Ingresar</button>
					</div>
				</form>
			</div> <!-- #login_panel -->	
		</div>
	</body>
</html>