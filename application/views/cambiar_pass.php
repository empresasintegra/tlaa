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
	</head>
	<body>
		<div id="login">
			<h1>Ingreso a sistema</h1>
			<div id="login_panel">
				<form action="<?php echo base_url() ?>login/renovar_pass" method="post">		
					<div class="login_fields">
						<div class="field">
							<label for="email">Nueva contraseña</label>
							<input type="password" name="pass1" value="" id="pass1" tabindex="1" />		
						</div>
						
						<div class="field">
							<label for="password">Repetir Contraseña</label>
							<input type="password" name="pass2" value="" id="pass2" tabindex="2" />			
						</div>
						<input type="hidden" name="rut" value="<?php echo $rut ?>" />
						<input type="hidden" name="id" value="<?php echo $id ?>" />
					</div> <!-- .login_fields -->	
					<div class="login_actions">
						<button type="submit" class="btn primary cambiar_pass" tabindex="3">Cambiar</button>
					</div>
				</form>
			</div> <!-- #login_panel -->	
		</div>
	</body>
</html>