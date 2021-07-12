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
		<?php 
		if (isset($css)){
			foreach( $css as $file ){ ?>
				<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/<?php echo $file; ?>">
		<?php }
		} ?>
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE CSS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/plugins.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/themes/theme-default.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/print.css" type="text/css" media="print"/>
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<!-- end: CORE CSS -->
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="<?php if (!$side_bar) echo 'sidebar-close'; ?>">
		<!-- start: SLIDING BAR (SB) -->
		<div id="slidingbar-area">
			<div id="slidingbar">
				<div class="row">
					<!-- start: SLIDING BAR FIRST COLUMN -->
					<div class="col-md-4 col-sm-4">
						<h2>My Options</h2>
						<div class="row">
							<div class="col-xs-6 col-lg-3">
								<button class="btn btn-icon btn-block space10">
									<i class="fa fa-folder-open-o"></i>
									Projects <span class="badge badge-info partition-red"> 4 </span>
								</button>
							</div>
							<div class="col-xs-6 col-lg-3">
								<button class="btn btn-icon btn-block space10">
									<i class="fa fa-envelope-o"></i>
									Messages <span class="badge badge-info partition-red"> 23 </span>
								</button>
							</div>
							<div class="col-xs-6 col-lg-3">
								<button class="btn btn-icon btn-block space10">
									<i class="fa fa-calendar-o"></i>
									Calendar <span class="badge badge-info partition-blue"> 5 </span>
								</button>
							</div>
							<div class="col-xs-6 col-lg-3">
								<button class="btn btn-icon btn-block space10">
									<i class="fa fa-bell-o"></i>
									Notifications <span class="badge badge-info partition-red"> 9 </span>
								</button>
							</div>
						</div>
					</div>
					<!-- end: SLIDING BAR FIRST COLUMN -->
					<!-- start: SLIDING BAR SECOND COLUMN -->
					<div class="col-md-4 col-sm-4">
						<h2>My Recent Works</h2>
						<div class="blog-photo-stream margin-bottom-30">
							<ul class="list-unstyled">
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image01_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image02_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image03_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image04_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image05_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image06_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image07_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image08_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image09_th.jpg"></a>
								</li>
								<li>
									<a href="pages_blank_page.html#"><img alt="" src="<?php echo base_url() ?>extras/layout2.0/assets/images/image10_th.jpg"></a>
								</li>
							</ul>
						</div>
					</div>
					<!-- end: SLIDING BAR SECOND COLUMN -->
					<!-- start: SLIDING BAR THIRD COLUMN -->
					
					<!-- end: SLIDING BAR THIRD COLUMN -->
				</div>
				<div class="row">
					<!-- start: SLIDING BAR TOGGLE BUTTON -->
					<div class="col-md-12 text-center">
						<a href="pages_blank_page.html#" class="sb_toggle"><i class="fa fa-chevron-up"></i></a>
					</div>
					<!-- end: SLIDING BAR TOGGLE BUTTON -->
				</div>
			</div>
		</div>
		<!-- end: SLIDING BAR -->
		<div class="main-wrapper">
			<!-- start: TOPBAR -->
			<header class="topbar navbar navbar-inverse navbar-fixed-top inner">
				<!-- start: TOPBAR CONTAINER -->
				<div class="container">
					<div class="navbar-header">
						<a class="sb-toggle-left hidden-md hidden-lg" href="pages_blank_page.html#main-navbar">
							<i class="fa fa-bars"></i>
						</a>
						<!-- start: LOGO -->
						<a class="navbar-brand" href="#">
							TRANSPORTES INTEGRA
						</a>
						<!-- end: LOGO -->
					</div>
					<div class="topbar-tools">
						<!-- start: TOP NAVIGATION MENU -->
						<ul class="nav navbar-right">
							<!-- start: USER DROPDOWN -->
							<li class="dropdown current-user">
								<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="pages_blank_page.html#">
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
							<!-- end: USER DROPDOWN -->
							<?php if( $this->session->userdata('chat') ){ ?>
							<li class="right-menu-toggle">
								<a href="pages_blank_page.html#" class="sb-toggle-right">
									<i class="fa fa-globe toggle-icon"></i> <i class="fa fa-caret-right"></i> <span class="notifications-count badge badge-default hide"> 3</span>
								</a>
							</li>
							<?php } ?>
						</ul>
						<!-- end: TOP NAVIGATION MENU -->
					</div>
				</div>
				<!-- end: TOPBAR CONTAINER -->
			</header>
			<!-- end: TOPBAR -->
			<!-- start: PAGESLIDE LEFT -->
			<a class="closedbar inner hidden-sm hidden-xs <?php if (!$side_bar) echo 'open'; ?>" href="pages_blank_page.html#">
			</a>
			<nav id="pageslide-left" class="pageslide inner">
				<div class="navbar-content">
					<!-- start: SIDEBAR -->
					<div class="main-navigation left-wrapper transition-left">
						<div class="navigation-toggler hidden-sm hidden-xs">
							<a href="pages_blank_page.html#main-navbar" class="sb-toggle-left">
							</a>
						</div>
						<div class="user-profile border-top padding-horizontal-10 block">
							<div class="inline-block">
								<!--<img src="<?php //echo base_url().$this->session->userdata('imagen'); ?>" alt="">-->
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
					<div class="col-xs-6 text-left no-padding">
						<a class="btn btn-sm status" href="#">
							Estado <i class="fa fa-dot-circle-o text-green"></i> <span>Online</span>
						</a>
					</div>
					<div class="col-xs-6 text-right no-padding">
						<a class="btn btn-sm log-out text-right" href="<?php echo base_url() ?>usuarios/login/salir">
							<i class="fa fa-power-off"></i> Salir
						</a>
					</div>
				</div>
			</nav>
			<!-- end: PAGESLIDE LEFT -->
			<!-- start: PAGESLIDE RIGHT -->
		
			<!-- end: PAGESLIDE RIGHT -->
			<!-- start: MAIN CONTAINER -->
			<div class="main-container inner">
				<!-- start: PAGE -->
				<div class="main-content">
					<!-- start: PANEL CONFIGURATION MODAL FORM -->
					<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									<h4 class="modal-title">Panel Configuration</h4>
								</div>
								<div class="modal-body">
									Here will be a configuration form
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">
										Close
									</button>
									<button type="button" class="btn btn-primary">
										Save changes
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
					<!-- end: SPANEL CONFIGURATION MODAL FORM -->
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
						2015 &copy; Empresas Integra LTDA.
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="fa fa-chevron-up"></i></span>
					</div>
				</div>
			</footer>
			<!-- end: FOOTER -->
			<!-- start: SUBVIEW SAMPLE CONTENTS -->
			<!-- *** NEW NOTE *** -->
			<div id="newNote">
				<div class="noteWrap col-md-8 col-md-offset-2">
					<h3>Add new note</h3>
					<form class="form-note">
						<div class="form-group">
							<input class="note-title form-control" name="noteTitle" type="text" placeholder="Note Title...">
						</div>
						<div class="form-group">
							<textarea id="noteEditor" name="noteEditor" class="hide"></textarea>
							<textarea class="summernote" placeholder="Write note here..."></textarea>
						</div>
						<div class="pull-right">
							<div class="btn-group">
								<a href="pages_blank_page.html#" class="btn btn-info close-subview-button">
									Close
								</a>
							</div>
							<div class="btn-group">
								<button class="btn btn-info save-note" type="submit">
									Save
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- *** READ NOTE *** -->
			<div id="readNote">
				<div class="barTopSubview">
					<a href="pages_blank_page.html#newNote" class="new-note button-sv"><i class="fa fa-plus"></i> Add new note</a>
				</div>
				<div class="noteWrap col-md-8 col-md-offset-2">
					<div class="panel panel-note">
						<div class="e-slider owl-carousel owl-theme">
							<div class="item">
								<div class="panel-heading">
									<h3>This is a Note</h3>
								</div>
								<div class="panel-body">
									<div class="note-short-content">
										Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...
									</div>
									<div class="note-content">
										Lorem ipsum dolor sit amet, consectetur adipisici elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
										Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat.
										Quis aute iure reprehenderit in <strong>voluptate velit</strong> esse cillum dolore eu fugiat nulla pariatur.
										<br>
										Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
										<br>
										Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci v'elit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem.
										<br>
										Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut <strong>aliquid ex ea commodi consequatur?</strong>
										<br>
										Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?
										<br>
										At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.
										<br>
										Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae.
										<br>
										Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
									</div>
									<div class="note-options pull-right">
										<a href="pages_blank_page.html#readNote" class="read-note"><i class="fa fa-chevron-circle-right"></i> Read</a><a href="pages_blank_page.html#" class="delete-note"><i class="fa fa-times"></i> Delete</a>
									</div>
								</div>
								<div class="panel-footer">
									<div class="avatar-note"><img src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-2-small.jpg" alt="">
									</div>
									<span class="author-note">Nicole Bell</span>
									<time class="timestamp" title="2014-02-18T00:00:00-05:00">
										2014-02-18T00:00:00-05:00
									</time>
								</div>
							</div>
							<div class="item">
								<div class="panel-heading">
									<h3>This is the second Note</h3>
								</div>
								<div class="panel-body">
									<div class="note-short-content">
										Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Nemo enim ipsam voluptatem, quia voluptas sit...
									</div>
									<div class="note-content">
										Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
										<br>
										Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci v'elit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem.
										<br>
										Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut <strong>aliquid ex ea commodi consequatur?</strong>
										<br>
										Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?
										<br>
										Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae.
										<br>
										Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
									</div>
									<div class="note-options pull-right">
										<a href="pages_blank_page.html#" class="read-note"><i class="fa fa-chevron-circle-right"></i> Read</a><a href="pages_blank_page.html#" class="delete-note"><i class="fa fa-times"></i> Delete</a>
									</div>
								</div>
								<div class="panel-footer">
									<div class="avatar-note"><img src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-3-small.jpg" alt="">
									</div>
									<span class="author-note">Steven Thompson</span>
									<time class="timestamp" title="2014-02-18T00:00:00-05:00">
										2014-02-18T00:00:00-05:00
									</time>
								</div>
							</div>
							<div class="item">
								<div class="panel-heading">
									<h3>This is yet another Note</h3>
								</div>
								<div class="panel-body">
									<div class="note-short-content">
										At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores...
									</div>
									<div class="note-content">
										At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.
										<br>
										Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
										<br>
										Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci v'elit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem.
										<br>
										Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut <strong>aliquid ex ea commodi consequatur?</strong>
									</div>
									<div class="note-options pull-right">
										<a href="pages_blank_page.html#" class="read-note"><i class="fa fa-chevron-circle-right"></i> Read</a><a href="pages_blank_page.html#" class="delete-note"><i class="fa fa-times"></i> Delete</a>
									</div>
								</div>
								<div class="panel-footer">
									<div class="avatar-note"><img src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-4-small.jpg" alt="">
									</div>
									<span class="author-note">Ella Patterson</span>
									<time class="timestamp" title="2014-02-18T00:00:00-05:00">
										2014-02-18T00:00:00-05:00
									</time>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- *** SHOW CALENDAR *** -->
			<div id="showCalendar" class="col-md-10 col-md-offset-1">
				<div class="barTopSubview">
					<a href="pages_blank_page.html#newEvent" class="new-event button-sv" data-subviews-options='{"onShow": "editEvent()"}'><i class="fa fa-plus"></i> Add new event</a>
				</div>
				<div id="calendar"></div>
			</div>
			<!-- *** NEW EVENT *** -->
			<div id="newEvent">
				<div class="noteWrap col-md-8 col-md-offset-2">
					<h3>Add new event</h3>
					<form class="form-event">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input class="event-id hide" type="text">
									<input class="event-name form-control" name="eventName" type="text" placeholder="Event Name...">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="checkbox" class="all-day" data-label-text="All-Day" data-on-text="True" data-off-text="False">
								</div>
							</div>
							<div class="no-all-day-range">
								<div class="col-md-8">
									<div class="form-group">
										<div class="form-group">
											<span class="input-icon">
												<input type="text" class="event-range-date form-control" name="eventRangeDate" placeholder="Range date"/>
												<i class="fa fa-clock-o"></i> </span>
										</div>
									</div>
								</div>
							</div>
							<div class="all-day-range">
								<div class="col-md-8">
									<div class="form-group">
										<div class="form-group">
											<span class="input-icon">
												<input type="text" class="event-range-date form-control" name="ad_eventRangeDate" placeholder="Range date"/>
												<i class="fa fa-calendar"></i> </span>
										</div>
									</div>
								</div>
							</div>
							<div class="hide">
								<input type="text" class="event-start-date" name="eventStartDate"/>
								<input type="text" class="event-end-date" name="eventEndDate"/>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<select class="form-control selectpicker event-categories">
										<option data-content="<span class='event-category event-cancelled'>Cancelled</span>" value="event-cancelled">Cancelled</option>
										<option data-content="<span class='event-category event-home'>Home</span>" value="event-home">Home</option>
										<option data-content="<span class='event-category event-overtime'>Overtime</span>" value="event-overtime">Overtime</option>
										<option data-content="<span class='event-category event-generic'>Generic</span>" value="event-generic" selected="selected">Generic</option>
										<option data-content="<span class='event-category event-job'>Job</span>" value="event-job">Job</option>
										<option data-content="<span class='event-category event-offsite'>Off-site work</span>" value="event-offsite">Off-site work</option>
										<option data-content="<span class='event-category event-todo'>To Do</span>" value="event-todo">To Do</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="summernote" placeholder="Write note here..."></textarea>
								</div>
							</div>
						</div>
						<div class="pull-right">
							<div class="btn-group">
								<a href="pages_blank_page.html#" class="btn btn-info close-subview-button">
									Close
								</a>
							</div>
							<div class="btn-group">
								<button class="btn btn-info save-new-event" type="submit">
									Save
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- *** READ EVENT *** -->
			<div id="readEvent">
				<div class="noteWrap col-md-8 col-md-offset-2">
					<div class="row">
						<div class="col-md-12">
							<h2 class="event-title">Event Title</h2>
							<div class="btn-group options-toggle pull-right">
								<button class="btn dropdown-toggle btn-transparent-grey" data-toggle="dropdown">
									<i class="fa fa-cog"></i>
									<span class="caret"></span>
								</button>
								<ul role="menu" class="dropdown-menu dropdown-light pull-right">
									<li>
										<a href="pages_blank_page.html#newEvent" class="edit-event">
											<i class="fa fa-pencil"></i> Edit
										</a>
									</li>
									<li>
										<a href="pages_blank_page.html#" class="delete-event">
											<i class="fa fa-times"></i> Delete
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-6">
							<span class="event-category event-cancelled">Cancelled</span>
							<span class="event-allday"><i class='fa fa-check'></i> All-Day</span>
						</div>
						<div class="col-md-12">
							<div class="event-start">
								<div class="event-day"></div>
								<div class="event-date"></div>
								<div class="event-time"></div>
							</div>
							<div class="event-end"></div>
						</div>
						<div class="col-md-12">
							<div class="event-content"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- *** NEW CONTRIBUTOR *** -->
			<div id="newContributor">
				<div class="noteWrap col-md-8 col-md-offset-2">
					<h3>Add new contributor</h3>
					<form class="form-contributor">
						<div class="row">
							<div class="col-md-12">
								<div class="errorHandler alert alert-danger no-display">
									<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
								</div>
								<div class="successHandler alert alert-success no-display">
									<i class="fa fa-ok"></i> Your form validation is successful!
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="contributor-id hide" type="text">
									<label class="control-label">
										First Name <span class="symbol required"></span>
									</label>
									<input type="text" placeholder="Insert your First Name" class="form-control contributor-firstname" name="firstname">
								</div>
								<div class="form-group">
									<label class="control-label">
										Last Name <span class="symbol required"></span>
									</label>
									<input type="text" placeholder="Insert your Last Name" class="form-control contributor-lastname" name="lastname">
								</div>
								<div class="form-group">
									<label class="control-label">
										Email Address <span class="symbol required"></span>
									</label>
									<input type="email" placeholder="Text Field" class="form-control contributor-email" name="email">
								</div>
								<div class="form-group">
									<label class="control-label">
										Password <span class="symbol required"></span>
									</label>
									<input type="password" class="form-control contributor-password" name="password">
								</div>
								<div class="form-group">
									<label class="control-label">
										Confirm Password <span class="symbol required"></span>
									</label>
									<input type="password" class="form-control contributor-password-again" name="password_again">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">
										Gender <span class="symbol required"></span>
									</label>
									<div>
										<label class="radio-inline">
											<input type="radio" class="grey contributor-gender" value="F" name="gender">
											Female
										</label>
										<label class="radio-inline">
											<input type="radio" class="grey contributor-gender" value="M" name="gender">
											Male
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">
										Permits <span class="symbol required"></span>
									</label>
									<select name="permits" class="form-control contributor-permits" >
										<option value="View and Edit">View and Edit</option>
										<option value="View Only">View Only</option>
									</select>
								</div>
								<div class="form-group">
									<div class="fileupload fileupload-new contributor-avatar" data-provides="fileupload">
										<div class="fileupload-new thumbnail"><img src="<?php echo base_url() ?>extras/layout2.0/assets/images/anonymous.jpg" alt="" width="50" height="50"/>
										</div>
										<div class="fileupload-preview fileupload-exists thumbnail"></div>
										<div class="contributor-avatar-options">
											<span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
												<input type="file">
											</span>
											<a href="pages_blank_page.html#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
												<i class="fa fa-times"></i> Remove
											</a>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">
										SEND MESSAGE (Optional)
									</label>
									<textarea class="form-control contributor-message"></textarea>
								</div>
							</div>
						</div>
						<div class="pull-right">
							<div class="btn-group">
								<a href="pages_blank_page.html#" class="btn btn-info close-subview-button">
									Close
								</a>
							</div>
							<div class="btn-group">
								<button class="btn btn-info save-contributor" type="submit">
									Save
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- *** SHOW CONTRIBUTORS *** -->
			<div id="showContributors">
				<div class="barTopSubview">
					<a href="pages_blank_page.html#newContributor" class="new-contributor button-sv"><i class="fa fa-plus"></i> Add new contributor</a>
				</div>
				<div class="noteWrap col-md-10 col-md-offset-1">
					<div class="panel panel-default">
						<div class="panel-body">
							<div id="contributors">
								<div class="options-contributors hide">
									<div class="btn-group">
										<button class="btn dropdown-toggle btn-transparent-grey" data-toggle="dropdown">
											<i class="fa fa-cog"></i>
											<span class="caret"></span>
										</button>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">
											<li>
												<a href="pages_blank_page.html#newContributor" class="show-subviews edit-contributor">
													<i class="fa fa-pencil"></i> Edit
												</a>
											</li>
											<li>
												<a href="pages_blank_page.html#" class="delete-contributor">
													<i class="fa fa-times"></i> Delete
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end: SUBVIEW SAMPLE CONTENTS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/respond.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jQuery/jquery-1.11.1.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
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
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
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