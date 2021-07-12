
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Cambio Contraseña - Transportes Integra</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/animate.css/animate.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/skins/all.css">
		<link rel="shortcut icon" href="<?php echo base_url() ?>extras/images/favicon.ico" />
	</head>
	<body class="login">
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo">
					<font color="#FFFFFF" size="4">Integra - Transportes</font>
				</div>
				<!-- start: LOGIN BOX -->
				<div class="box-login">
					<h3>Cambio De Contraseña</h3>
					<p>
						Ingrese su rut y contraseña en el formulario.
					</p>
					<form class="form-login" action="<?php echo base_url() ?>usuarios/login/actualizar_contrasena" method='POST'>
						<div class="errorHandler alert alert-danger no-display">
							<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
						</div>
						<fieldset>
							<div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="rut" placeholder="RUT">
									<i class="fa fa-user"></i> </span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="Contraseña Antigua">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password2" placeholder="Contraseña Nueva">
									<i class="fa fa-lock"></i>
								</span>
							</div>
						
							<div class="form-actions">
								<button type="submit" class="btn btn-green pull-right">
									Cambiar <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
						</fieldset>
						<a href="javascript:history.go(-1)">Volver</a>
					</form>
					<!-- start: COPYRIGHT -->
					<div class="copyright">
						<?php echo date('Y') ?> &copy; Transportes Integra Ltda.
					</div>
					<!-- end: COPYRIGHT -->
				</div>
				<!-- end: LOGIN BOX -->
			</div>
		</div>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery.transit/jquery.transit.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/main.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/login.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	</body>
	<!-- end: BODY -->
</html>