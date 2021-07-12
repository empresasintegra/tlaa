<!DOCTYPE html>
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title><?php echo $head_titulo ?></title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,100,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/animate.css/animate.min.css">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR SUBVIEW CONTENTS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.theme.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.transitions.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/summernote/dist/summernote.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/toastr/toastr.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-select/bootstrap-select.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/css/DT_bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/x-editable/css/bootstrap-editable.css">
		<!-- end: CSS REQUIRED FOR THIS SUBVIEW CONTENTS-->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
				<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE CSS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/plugins.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/themes/theme-default.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/print.css" type="text/css" media="print"/>
		<?php 
		if (isset($css)){
			foreach( $css as $file ){ ?>
				<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/<?php echo $file; ?>">
		<?php }
		} ?>

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<!-- end: CORE CSS -->
		<link rel="shortcut icon" href="<?php echo base_url() ?>extras/images/favicon.ico" />
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="<?php if (!$side_bar) echo 'sidebar-close'; ?>">
		<div class="main-wrapper">
			<!-- start: TOPBAR -->
			<header class="topbar navbar navbar-inverse navbar-fixed-top inner">
				<!-- start: TOPBAR CONTAINER -->
				<div class="container">
					<div class="navbar-header">
						<a   class="sb-toggle-left hidden-md hidden-lg" href="pages_blank_page.html#main-navbar">
							<i class="fa fa-bars"></i>
						</a>
						<!-- start: LOGO -->
						<a class="navbar-brand" href="#">
							<font>Integra - Transportes</font>
						</a>
						<!-- end: LOGO -->
					</div>
					<div class="topbar-tools">
						<!-- start: TOP NAVIGATION MENU -->
						<ul class="nav navbar-right">
							<!-- start: USER DROPDOWN -->
							<li class="dropdown current-user">
								<a  data-toggle="dropdown"   data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="pages_blank_page.html#">
									<!--<img src="<?php //echo base_url().$this->session->userdata('imagen_barra'); ?>" class="img-circle" alt="">--> <span class="username hidden-xs"><?php echo $this->session->userdata('nombres'); ?></span> <i class="fa fa-caret-down "></i>
								</a>
								<ul class="dropdown-menu dropdown-dark">
									<!--
									<li>
										<a href="<?php //echo base_url() ?>usuarios/perfil/index">
											Mi Perfil
										</a>
									</li>
									-->
									<li>
										<a href="<?php echo base_url() ?>usuarios/login/salir">
											Salir
										</a>
									</li>
								</ul>
							</li>
						</ul>
						<!-- end: TOP NAVIGATION MENU -->
					</div>
				</div>
				<!-- end: TOPBAR CONTAINER -->
			</header>
			<!-- end: TOPBAR -->
			<!-- start: PAGESLIDE LEFT -->
			<a title="Maximizar" class="closedbar inner hidden-sm hidden-xs <?php if (!$side_bar) echo 'open'; ?>" href="pages_blank_page.html#" >
			</a>
			<nav id="pageslide-left" class="pageslide inner">
				<div class="navbar-content">
					<!-- start: SIDEBAR -->
					<div class="main-navigation left-wrapper transition-left">
						<div class="navigation-toggler hidden-sm hidden-xs">
							<a title="Minimizar" href="pages_blank_page.html#main-navbar" class="sb-toggle-left">
							</a>
						</div>
						<div class="user-profile border-top padding-horizontal-10 block">
							<div class="inline-block">
								<!--<img src="<?phpecho //base_url().$this->session->userdata('imagen'); ?>" alt="">-->
							</div>
							<div class="inline-block">
								<h5 class="no-margin"> Bienvenido </h5>
								<h4 class="no-margin"> <?php echo $this->session->userdata('nombres'); ?> </h4>
								<!--<a class="btn user-options sb_toggle">
									<i class="fa fa-cog"></i>
								</a>-->
							</div>
						</div>
						<!-- start: MAIN NAVIGATION MENU -->
						<ul class="main-navigation-menu">
							<?php echo $menu ?>
						</ul>
						<!-- end: MAIN NAVIGATION MENU -->
					</div>
					<!-- end: SIDEBAR -->
				</div>
				<div class="slide-tools">
				</div>
			</nav>
			<!-- end: PAGESLIDE LEFT -->
			<!-- start: PAGESLIDE RIGHT -->
		
			<!-- end: PAGESLIDE RIGHT -->
			<!-- start: MAIN CONTAINER -->
			<div class="main-container inner">
				<!-- start: PAGE -->
				<div class="main-content">
					<div class="container">
						<!-- start: PAGE HEADER -->
						<!-- start: TOOLBAR -->
						<div class="toolbar row">
							<div class="col-sm-6 hidden-xs">
								<div class="page-header">
									<h1><?php echo $titulo; ?> <small><?php echo @$subtitulo; ?></small></h1>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<a href="#" class="back-subviews">
									<i class="fa fa-chevron-left"></i> Volver
								</a>
								<a href="#" class="close-subviews">
									<i class="fa fa-times"></i> Cerrar
								</a>
								<div class="toolbar-tools pull-right">
									<!-- start: TOP NAVIGATION MENU -->

									<ul class="nav navbar-right">
										<?php if(isset($head_mensajes)){ ?>
										
										<?php } if(isset($head_buscar)){ ?>
										<li class="menu-search">
											<a href="pages_blank_page.html#">
												<i class="fa fa-search"></i> BUSCAR
											</a>
											<!-- start: SEARCH POPOVER -->
											<div class="popover bottom search-box transition-all">
												<div class="arrow"></div>
												<div class="popover-content">
													<!-- start: SEARCH FORM -->
													<form class="" action="<?php echo $head_buscar['url'] ?>" method="<?php echo $head_buscar['method'] ?>" >
														<div class="input-group">
															<input type="text" class="form-control" placeholder="Buscar" name='head_buscar'> 
															<span class="input-group-btn">
																<button class="btn btn-main-color btn-squared" type="button" >
																	<i class="fa fa-search"></i>
																</button> </span>
														</div>
													</form>
													<!-- end: SEARCH FORM -->
												</div>
											</div>
											<!-- end: SEARCH POPOVER -->
										</li>
										<?php } ?>
									</ul>

									<!-- end: TOP NAVIGATION MENU -->
								</div>
							</div>
						</div>
						<!-- end: TOOLBAR -->
						<!-- end: PAGE HEADER -->
						<!-- start: BREADCRUMB -->
						<div class="row">
							<div class="col-md-12">
								<ol class="breadcrumb">
									<?php if(!empty($lugar)){ ?>
										<?php foreach ($lugar as $l) { ?>
											<?php if(!empty($l['url'])){ ?>
											<li>
												<a href="<?php echo base_url().$l['url'] ?>">
													<?php echo $l['txt'] ?>
												</a>
											</li>
											<?php } else{ ?>
											<li class='active'>
											<?php echo $l['txt'] ?>
											</li>
											<?php } ?>
										<?php } 
									} ?>
								</ol>
							</div>
						</div>
						<!-- end: BREADCRUMB -->
						<!-- start: PAGE CONTENT -->
						<div class="row">
							<div class="col-md-12">
								<?php if ( isset($alert_tipo) ){ ?>
								<div class="alert <?php echo $alert_tipo ?>">
									<?php echo $alert_contenido; ?>
								</div>
								<?php } ?>
								<?php echo $cuerpo; ?>
							</div>
						</div>
						<!-- end: PAGE CONTENT-->
					</div>
					<div class="subviews">
						<div class="subviews-container"></div>
					</div>
					<div id="subview-eval-list" class="no-display"></div>
					<div id="subview-eval-add" class="no-display"></div>
				</div>
				<!-- end: PAGE -->
			</div>
			<!-- end: MAIN CONTAINER -->
			<!-- start: FOOTER -->
			<footer class="inner">
				<div class="footer-inner">
					<div class="pull-left">
						<?php echo date('Y') ?> &copy; Transportes Integra Ltda.
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="fa fa-chevron-up"></i></span>
					</div>
				</div>
			</footer>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
		<!--<![endif]-->
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		</script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/chat.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/moment/min/moment.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootbox/bootbox.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery.scrollTo/jquery.scrollTo.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/ScrollToFixed/jquery-scrolltofixed-min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery.appear/jquery.appear.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/velocity/jquery.velocity.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/toastr/toastr.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/truncate/jquery.truncate.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/summernote/dist/summernote.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/x-editable/js/bootstrap-editable.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/subview.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/subview-examples.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<?php 
		if (isset($js)){
			foreach( $js as $file ){ ?>
				<script src="<?php echo base_url() ?>extras/layout2.0/assets/<?php echo $file; ?>"></script>
		<?php }
		} ?>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE JAVASCRIPTS  -->
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/main.js"></script>
		<!-- end: CORE JAVASCRIPTS  -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				SVExamples.init();
				FormElements.init();
				UIModals.init();
				TableData.init();
			});
		</script>
	</body>
	<!-- end: BODY -->
</html>