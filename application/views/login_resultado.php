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
						<img src="<?php echo base_url() ?>extras/img/casco_logo.png" />
						<h2 class="titulo">Integra SGO</h2>
					</div>
				</div>
		    	<div id="content">
		    		<div id="auth_dialog_container" class="login_form">
		    			<div id="auth_dialog">
		    				<h3><span><?php echo $resultado ?></span></h3>
		    				<a href="<?php echo base_url() ?>login">Volver al inicio</a>
					</div>
				</div>
			</div>
			</div>
			</div>
	</body>
</html>