<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<META name="robots" content="NOINDEX,NOFOLLOW,NOARCHIVE,NOODP,NOSNIPPET">
		<title><?php echo $titulo; ?></title>

		<link href="<?php echo base_url() ?>extras/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/base.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/js/msgbox/Styles/msgBoxLight.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/js/lightbox/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" />
		<!--<link rel="stylesheet" href="<?php echo base_url() ?>extras/css/fallr.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/js/jqwidgets/styles/jqx.base.css" type="text/css" />-->
		<!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" /> -->

<!-- 	<link href="<?php echo base_url() ?>extras/css/reseter_v2.css" rel="stylesheet" type="text/css" /> -->

<!--	<script src="<?php echo base_url() ?>extras/js/jquery-1.9.1.min.js" type="text/javascript"></script> -->
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		</script>
		<script src="http://code.jquery.com/jquery-2.0.3.js"></script> 
		<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>-->
		<script src="<?php echo base_url() ?>extras/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/msgbox/jquery.msgBox.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/lightbox/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.maskedinput.min.js" type="text/javascript"></script>
<!--		<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script> 
		<script src="<?php echo base_url() ?>extras/js/jquery-migrate-1.1.1.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script> 
		<script src="<?php echo base_url() ?>extras/js/DD_roundies_0.0.2a-min.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		DD_roundies.addRule('.btn', '4px');
		DD_roundies.addRule('.notify' , '100px');
		</script> -->
		<script src="<?php echo base_url() ?>extras/js/base.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="header" class="container-fluid">
			<div class="contenido row-fluid">
				<div class="span12">
					<ul>
						<?php echo $menu; ?>
					</ul>
				</div>
			</div>
		</div>
		<div id="sub-header" class="<?php echo @$class_subheader ?> container-fluid">
			<div class="contenido row-fluid">
				<div class="span12">
					<h2><?php echo $lugar; ?></h2>
					<?php echo @$lugar_aux; ?>
				</div>
			</div>
		</div>
		<div id="contenido container-fluid">
			<div class="contenido row-fluid">
				<?php echo $cuerpo; ?>
			</div>
		</div>
	</body>
</html>