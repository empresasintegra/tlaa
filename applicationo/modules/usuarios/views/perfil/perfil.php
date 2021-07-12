<div class="tabbable">
	<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
		<li class="active">
			<a data-toggle="tab" href="#panel_overview">
				Overview
			</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#panel_edit_account">
				Editar Cuenta
			</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#panel_projects">
				Proyectos
			</a>
		</li>
	</ul>
	<div class="tab-content">
		<div id="panel_overview" class="tab-pane fade active in">
			<div class="row">
				<div class="col-sm-5 col-md-4">
					<div class="user-left">
						<div class="center">
							<h4><?php echo $nombre ?></h4>
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="user-image">
									<div class="fileupload-new thumbnail"><img src="<?php echo base_url().$imagen ?>" alt="">
									</div>
									<div class="fileupload-preview fileupload-exists thumbnail"></div>
									<div class="user-image-buttons">
										<span class="btn btn-azure btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-pencil"></i></span><span class="fileupload-exists"><i class="fa fa-pencil"></i></span>
											<input type="file">
										</span>
										<a href="#" class="btn fileupload-exists btn-red btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>
							</div>
							<hr>
							<div class="social-icons block">
								<ul>
									<li data-placement="top" data-original-title="Twitter" class="social-twitter tooltips">
										<a href="http://www.twitter.com" target="_blank">
											Twitter
										</a>
									</li>
									<li data-placement="top" data-original-title="Facebook" class="social-facebook tooltips">
										<a href="http://facebook.com" target="_blank">
											Facebook
										</a>
									</li>
									<li data-placement="top" data-original-title="Google" class="social-google tooltips">
										<a href="http://google.com" target="_blank">
											Google+
										</a>
									</li>
									<li data-placement="top" data-original-title="LinkedIn" class="social-linkedin tooltips">
										<a href="http://linkedin.com" target="_blank">
											LinkedIn
										</a>
									</li>
									<li data-placement="top" data-original-title="Github" class="social-github tooltips">
										<a href="pages_user_profile.html#" target="_blank">
											Github
										</a>
									</li>
								</ul>
							</div>
							<hr>
						</div>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th colspan="3">Informaci&oacute;n de Contacto</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>RUT</td>
									<td><?php echo $datos->rut_usuario; ?></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>Genero</td>
									<td><?php echo ($datos->sexo)?'Femenino':'Masculino'; ?></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>email:</td>
									<td>
									<a href="#">
										<?php echo $datos->email; ?>
									</a></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>Telefono:</td>
									<td><?php echo $datos->fono; ?></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th colspan="3">Informaci&oacute;n General</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Estado Civil</td>
									<td>Administrator</td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>Regi&oacute;n</td>
									<td></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>Provincia</td>
									<td>56 min</td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>Ciudad</td>
									<td>Senior Marketing Manager</td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
								<tr>
									<td>Direcci&oacute;n</td>
									<td><?php echo $datos->direccion; ?></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th colspan="3">Informaci&oacute;n Adicional</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Nacimiento</td>
									<td><?php echo $datos->fecha_nac; ?></td>
									<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-sm-7 col-md-8">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula, dictum varius turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus.
					</p>
					<div class="row space20">
						<div class="col-sm-3">
							<button class="btn btn-icon btn-block">
								<i class="clip-clip"></i>
								Projects <span class="badge badge-info"> 4 </span>
							</button>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-icon btn-block pulsate" style="outline: 0px; outline-offset: 10px;">
								<i class="clip-bubble-2"></i>
								Messages <span class="badge badge-info"> 23 </span>
							</button>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-icon btn-block">
								<i class="clip-calendar"></i>
								Calendar <span class="badge badge-info"> 5 </span>
							</button>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-icon btn-block">
								<i class="clip-list-3"></i>
								Notifications <span class="badge badge-info"> 9 </span>
							</button>
						</div>
					</div>
					<div class="panel panel-white space20">
						<div class="panel-heading">
							<i class="clip-menu"></i>
							Recent Activities
							<div class="panel-tools">
								<a class="btn btn-xs btn-link panel-close" href="#">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="panel-body panel-scroll height-300 ps-container">
							<ul class="activities">
								<li>
									<a class="activity" href="javascript:void(0)">
										<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-blue"></i> <i class="fa fa-code fa-stack-1x fa-inverse"></i> </span> <span class="desc">You uploaded a new release.</span>
										<div class="time">
											<i class="fa fa-clock-o"></i>
											2 hours ago
										</div>
									</a>
								</li>
								<li>
									<a class="activity" href="javascript:void(0)">
										<img alt="image" src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-2.jpg"> <span class="desc">Nicole Bell sent you a message.</span>
										<div class="time">
											<i class="fa fa-clock-o"></i>
											3 hours ago
										</div>
									</a>
								</li>
								<li>
									<a class="activity" href="javascript:void(0)">
										<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-orange"></i> <i class="fa fa-database fa-stack-1x fa-inverse"></i> </span> <span class="desc">DataBase Migration.</span>
										<div class="time">
											<i class="fa fa-clock-o"></i>
											5 hours ago
										</div>
									</a>
								</li>
								<li>
									<a class="activity" href="javascript:void(0)">
										<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-yellow"></i> <i class="fa fa-calendar-o fa-stack-1x fa-inverse"></i> </span> <span class="desc">You added a new event to the calendar.</span>
										<div class="time">
											<i class="fa fa-clock-o"></i>
											8 hours ago
										</div>
									</a>
								</li>
								<li>
									<a class="activity" href="javascript:void(0)">
										<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-green"></i> <i class="fa fa-file-image-o fa-stack-1x fa-inverse"></i> </span> <span class="desc">Kenneth Ross uploaded new images.</span>
										<div class="time">
											<i class="fa fa-clock-o"></i>
											9 hours ago
										</div>
									</a>
								</li>
								<li>
									<a class="activity" href="javascript:void(0)">
										<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-green"></i> <i class="fa fa-file-image-o fa-stack-1x fa-inverse"></i> </span> <span class="desc">Peter Clark uploaded a new image.</span>
										<div class="time">
											<i class="fa fa-clock-o"></i>
											12 hours ago
										</div>
									</a>
								</li>
							</ul>
						<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 638px; display: none;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 270px; display: inherit;"><div class="ps-scrollbar-y" style="top: 0px; height: 163px;"></div></div></div>
					</div>
					<div class="panel panel-white space20">
						<div class="panel-heading">
							<i class="clip-checkmark-2"></i>
							To Do
							<div class="panel-tools">
								<a class="btn btn-xs btn-link panel-close" href="#">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="panel-body panel-scroll height-300 ps-container">
							<ul class="todo">
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc">Staff Meeting</span> <span class="label label-danger"> today</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> New frontend layout</span> <span class="label label-danger"> today</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> Hire developers</span> <span class="label label-warning"> tommorow</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc">Staff Meeting</span> <span class="label label-warning"> tommorow</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> New frontend layout</span> <span class="label label-success"> this week</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> Hire developers</span> <span class="label label-success"> this week</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> New frontend layout</span> <span class="label label-info"> this month</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> Hire developers</span> <span class="label label-info"> this month</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc">Staff Meeting</span> <span class="label label-danger"> today</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> New frontend layout</span> <span class="label label-danger"> today</span>
									</a>
								</li>
								<li>
									<a class="todo-actions" href="javascript:void(0)">
										<i class="fa fa-square-o"></i> <span class="desc"> Hire developers</span> <span class="label label-warning"> tommorow</span>
									</a>
								</li>
							</ul>
						<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: -156px; width: 638px; display: none;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 159px; right: 3px; height: 270px; display: inherit;"><div class="ps-scrollbar-y" style="top: 94px; height: 158px;"></div></div></div>
					</div>
				</div>
			</div>
		</div>
		<div id="panel_edit_account" class="tab-pane fade">
			<form action="<?php echo base_url() ?>usuarios/perfil/guardar_personales" role="form" id="form" method='post' enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $datos->id ?>">
				<div class="row">
					<div class="col-md-12">
						<h3>Informaci&oacute;n</h3>
						<hr>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">
								RUT
							</label>
							<input type="text" class="form-control" id="firstname" name="rut" value="<?php echo $datos->rut_usuario ?>" disabled="disabled">
						</div>
						<div class="form-group">
							<label class="control-label">
								Nombres <span class="symbol required"></span>
							</label>
							<input type="text" class="form-control" id="firstname" name="nombres" value="<?php echo $datos->nombres ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Apellido Paterno <span class="symbol required"></span>
							</label>
							<input type="text" class="form-control" id="lastname" name="paterno" value="<?php echo $datos->paterno ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Apellido Materno
							</label>
							<input type="text" class="form-control" id="lastname" name="materno" value="<?php echo $datos->materno ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Email
							</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo $datos->email ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Telefono
							</label>
							<div class="row">
								<?php $fono = ($datos->fono)?explode($datos->fono, "-"):false; ?>
								<div class="col-md-2">
									<input type="text" class="form-control" id="phone" name="email" value="<?php echo $fono[0] ?>">
								</div>
								<div class="col-md-10">
									<input type="text" class="form-control" id="phone" name="email" value="<?php echo $fono[1] ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">
								Contrase&ntilde;a
							</label>
							<input type="password" class="form-control" name="password" id="password">
						</div>
						<div class="form-group">
							<label class="control-label">
								Confirmar Contrase&ntilde;a
							</label>
							<input type="password" class="form-control" id="password_again" name="password_again">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group connected-group">
							<label class="control-label">
								Fecha de Nacimiento
							</label>
							<div class="row">
								<?php $nacimiento = ($datos->fecha_nac)?explode($datos->fecha_nac, "-"):false; ?>
								<div class="col-md-3">
									<select name="nac_dia" id="nac_dia" class="form-control">
										<option value="">DD</option>
										<?php for( $i=1;$i<32;$i++ ){ ?>
										<option value="<?php echo $i ?>" <?php echo ($i==$nacimiento[2])?'SELECTED':''; ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="nac_mes" id="nac_mes" class="form-control">
										<option value="">MM</option>
										<option value="">DD</option>
										<?php for( $i=1;$i<13;$i++ ){ ?>
										<option value="<?php echo $i ?>" <?php echo ($i==$nacimiento[1])?'SELECTED':''; ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3">
									<input type="text" id="nac_ano" name="nac_ano" placeholder="YYYY" value="<?php echo $nacimiento[0] ?>" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">
								Genero
							</label>
							<div>
								<label class="radio-inline">
									<input type="radio" class="grey" value="1" name="select_sexo" id="gender_female" <?php echo ($datos->sexo==1)?"checked='checked'":''; ?>>
									Femenino
								</label>
								<label class="radio-inline">
									<input type="radio" class="grey" value="0" name="select_sexo" id="gender_male" <?php echo ($datos->sexo==0)?"checked='checked'":''; ?>>
									Masculino
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">
								Estado Civil <span class="symbol required"></span>
							</label>
							<select name="select_civil" id="select_civil" class="form-control">
								<option value="">Seleccione...</option>
								<?php foreach ($estadocivil as $e) { ?>
									<option value="<?php echo $e->id ?>" <?php echo ($datos->id_estadocivil==$e->id)?'SELECTED':''; ?>><?php echo $e->desc_estadocivil ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">
								Nacionalidad <span class="symbol required"></span>
							</label>
							<select name="select_nacionalidad" id="select_nacionalidad" class="form-control">
								<option value="">Seleccione...</option>
								<option value="chilena" <?php echo ($datos->nacionalidad=='chilena')?'SELECTED':''; ?>>Chilena</option>
								<option value="extranjera" <?php echo ($datos->nacionalidad=='extranjera')?'SELECTED':''; ?>>Extranjera</option>
							</select>
						</div>
						<div class="form-group">
							<label>
								Imagen Subida
							</label>
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail"><img src="<?php echo base_url().$imagen ?>" alt="">
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail"></div>
								<div class="user-edit-image-buttons">
									<span class="btn btn-azure btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Selecionar imagen</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
										<input type="file" name="imagen">
									</span>
									<a href="#" class="btn fileupload-exists btn-red" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Eliminar
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3>Informaci&oacute;n Adicional</h3>
						<hr>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">
								Direcci&oacute;n
							</label>
							<input class="form-control" type="text" name="direccion" value="<?php echo $datos->direccion ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Regi&oacute;n <span class="symbol required"></span>
							</label>
							<select name="select_region" id="select_region" class="form-control">
								<option value="">Seleccione...</option>
								<?php foreach ($regiones as $r) { ?>
									<option value="<?php echo $r->id ?>" <?php echo ($datos->id_regiones==$r->id)?'SELECTED':''; ?>><?php echo $r->desc_regiones ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">
								Provincia <span class="symbol required"></span>
							</label>
							<select name="select_provincia" id="select_provincia" class="form-control">
								<option value="">Seleccione...</option>
								<?php foreach ($provincias as $p) { ?>
									<option value="<?php echo $p->id ?>" <?php echo ($datos->id_provincias==$p->id)?'SELECTED':''; ?>><?php echo $p->desc_provincias ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">
								Ciudad <span class="symbol required"></span>
							</label>
							<select name="select_ciudad" id="select_ciudad" class="form-control">
								<option value="">Seleccione...</option>
								<?php foreach ($ciudades as $c) { ?>
									<option value="<?php echo $c->id ?>" <?php echo ($datos->id_ciudades==$c->id)?'SELECTED':''; ?>><?php echo $c->desc_ciudades ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div>
							<span class="symbol required"></span> Obligatorios
							<hr>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<p>
							By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
						</p>
					</div>
					<div class="col-md-4">
						<button class="btn btn-green btn-block" type="submit">
							Actualizar <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
		<div id="panel_projects" class="tab-pane fade">
			<table class="table table-striped table-bordered table-hover" id="projects">
				<thead>
					<tr>
						<th class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey selectall" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></th>
						<th>Project Name</th>
						<th class="hidden-xs">Client</th>
						<th>Proj Comp</th>
						<th class="hidden-xs">%Comp</th>
						<th class="hidden-xs center">Priority</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey foocheck" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></td>
						<td>IT Help Desk</td>
						<td class="hidden-xs">Master Company</td>
						<td>11 november 2014</td>
						<td class="hidden-xs">
						<div class="progress active progress-xs">
							<div style="width: 70%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar" class="progress-bar progress-bar-warning">
								<span class="sr-only"> 70% Complete (danger)</span>
							</div>
						</div></td>
						<td class="center hidden-xs"><span class="label label-danger">Critical</span></td>
						<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-light-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
							<a href="#" class="btn btn-red tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
						</div>
						<div class="visible-xs visible-sm hidden-md hidden-lg">
							<div class="btn-group">
								<a class="btn btn-green dropdown-toggle btn-sm" data-toggle="dropdown" href="pages_user_profile.html#">
									<i class="fa fa-cog"></i> <span class="caret"></span>
								</a>
								<ul role="menu" class="dropdown-menu dropdown-dark pull-right">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-edit"></i> Editar
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-share"></i> Compartir
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-times"></i> Eliminar
										</a>
									</li>
								</ul>
							</div>
						</div></td>
					</tr>
					<tr>
						<td class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey foocheck" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></td>
						<td>PM New Product Dev</td>
						<td class="hidden-xs">Brand Company</td>
						<td>12 june 2014</td>
						<td class="hidden-xs">
						<div class="progress active progress-xs">
							<div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-info">
								<span class="sr-only"> 40% Complete</span>
							</div>
						</div></td>
						<td class="center hidden-xs"><span class="label label-warning">High</span></td>
						<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-light-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
							<a href="#" class="btn btn-red tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
						</div>
						<div class="visible-xs visible-sm hidden-md hidden-lg">
							<div class="btn-group">
								<a class="btn btn-green dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
									<i class="fa fa-cog"></i> <span class="caret"></span>
								</a>
								<ul role="menu" class="dropdown-menu dropdown-dark pull-right">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-edit"></i> Editar
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-share"></i> Compartir
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-times"></i> Eliminar
										</a>
									</li>
								</ul>
							</div>
						</div></td>
					</tr>
					<tr>
						<td class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey foocheck" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></td>
						<td>ClipTheme Web Site</td>
						<td class="hidden-xs">Internal</td>
						<td>11 november 2014</td>
						<td class="hidden-xs">
						<div class="progress active progress-xs">
							<div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar progress-bar-success">
								<span class="sr-only"> 90% Complete</span>
							</div>
						</div></td>
						<td class="center hidden-xs"><span class="label label-success">Normal</span></td>
						<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-light-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
							<a href="#" class="btn btn-red tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
						</div>
						<div class="visible-xs visible-sm hidden-md hidden-lg">
							<div class="btn-group">
								<a class="btn btn-green dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
									<i class="fa fa-cog"></i> <span class="caret"></span>
								</a>
								<ul role="menu" class="dropdown-menu dropdown-dark pull-right">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-edit"></i> Edit
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-share"></i> Share
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-times"></i> Remove
										</a>
									</li>
								</ul>
							</div>
						</div></td>
					</tr>
					<tr>
						<td class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey foocheck" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></td>
						<td>Local Ad</td>
						<td class="hidden-xs">UI Fab</td>
						<td>15 april 2014</td>
						<td class="hidden-xs">
						<div class="progress active progress-xs">
							<div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-warning">
								<span class="sr-only"> 50% Complete</span>
							</div>
						</div></td>
						<td class="center hidden-xs"><span class="label label-success">Normal</span></td>
						<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-light-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
							<a href="#" class="btn btn-red tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
						</div>
						<div class="visible-xs visible-sm hidden-md hidden-lg">
							<div class="btn-group">
								<a class="btn btn-green dropdown-toggle btn-sm" data-toggle="dropdown" href="pages_user_profile.html#">
									<i class="fa fa-cog"></i> <span class="caret"></span>
								</a>
								<ul role="menu" class="dropdown-menu dropdown-dark pull-right">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="pages_user_profile.html#">
											<i class="fa fa-edit"></i> Edit
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="pages_user_profile.html#">
											<i class="fa fa-share"></i> Share
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="pages_user_profile.html#">
											<i class="fa fa-times"></i> Remove
										</a>
									</li>
								</ul>
							</div>
						</div></td>
					</tr>
					<tr>
						<td class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey foocheck" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></td>
						<td>Design new theme</td>
						<td class="hidden-xs">Internal</td>
						<td>2 october 2014</td>
						<td class="hidden-xs">
						<div class="progress active progress-xs">
							<div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-success">
								<span class="sr-only"> 20% Complete (warning)</span>
							</div>
						</div></td>
						<td class="center hidden-xs"><span class="label label-danger">Critical</span></td>
						<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-light-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
							<a href="#" class="btn btn-red tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
						</div>
						<div class="visible-xs visible-sm hidden-md hidden-lg">
							<div class="btn-group">
								<a class="btn btn-green dropdown-toggle btn-sm" data-toggle="dropdown" href="pages_user_profile.html#">
									<i class="fa fa-cog"></i> <span class="caret"></span>
								</a>
								<ul role="menu" class="dropdown-menu dropdown-dark pull-right">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-edit"></i> Edit
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-share"></i> Share
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-times"></i> Remove
										</a>
									</li>
								</ul>
							</div>
						</div></td>
					</tr>
					<tr>
						<td class="center">
						<div class="checkbox-table">
							<label>
								<div class="icheckbox_flat-grey" style="position: relative;"><input type="checkbox" class="flat-grey foocheck" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							</label>
						</div></td>
						<td>IT Help Desk</td>
						<td class="hidden-xs">Designer TM</td>
						<td>6 december 2014</td>
						<td class="hidden-xs">
						<div class="progress active progress-xs">
							<div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
								<span class="sr-only"> 40% Complete (warning)</span>
							</div>
						</div></td>
						<td class="center hidden-xs"><span class="label label-warning">High</span></td>
						<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-light-blue tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-green tooltips" data-placement="top" data-original-title="Share"><i class="fa fa-share"></i></a>
							<a href="#" class="btn btn-red tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
						</div>
						<div class="visible-xs visible-sm hidden-md hidden-lg">
							<div class="btn-group">
								<a class="btn btn-green dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
									<i class="fa fa-cog"></i> <span class="caret"></span>
								</a>
								<ul role="menu" class="dropdown-menu dropdown-dark pull-right">
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-edit"></i> Edit
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-share"></i> Share
										</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#">
											<i class="fa fa-times"></i> Remove
										</a>
									</li>
								</ul>
							</div>
						</div></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>