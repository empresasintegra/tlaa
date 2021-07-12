<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<META name="robots" content="NOINDEX,NOFOLLOW,NOARCHIVE,NOODP,NOSNIPPET">
		<title><?php echo $titulo; ?></title>
		<link href="<?php echo base_url() ?>extras/css/reseter_v2.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/base.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.maskedinput.min.js" type="text/javascript"></script>
		<link href="<?php echo base_url() ?>extras/js/lightbox/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/lightbox/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
		<link href="<?php echo base_url() ?>extras/js/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/msgbox/jquery.msgbox.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/DD_roundies_0.0.2a-min.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		DD_roundies.addRule('.btn', '4px');
		DD_roundies.addRule('.notify' , '100px');
		</script>
		<script src="<?php echo base_url() ?>extras/js/base.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="contenido">
			<div class="contenido">
				<div class="grid grid_16">
				<br /><br />
				<div style="font-size: 50px;">404!</div>
				<br />
				<p>La pagina que buscas no existe. Algunas de las razones pueden ser:</p>
				<ul>
					<li>- Pudiste haber escrito mal la dirección de la página que querías ver.</li>
					<li>- El link que pinchaste apuntaba a una página que no existe o estaba mal ingresado.</li>
					<li>- Algun gracioso se robo nuestra pagina web.</li>
				</ul>
				<br />
				<div><a href="javascript:history.back(1);">Volver a la pagina anterior</a></div>
			</div>
			<div class="grid grid_8">
			<!-- 	<img src="<?php echo base_url() ?>extras/img/el_chapulin_colorado_copia.jpg" /> -->
			</div>
			<div class="grid grid_7">
			<p><b>ERROR 404 - PAGE NOT FOUND</b></p>
			</div>
			</div>
		</div>
	</body>
</html>