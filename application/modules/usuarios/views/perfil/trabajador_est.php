<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> AGREGAR DATOS</h4>
		<div class="panel-tools">										
			<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu dropdown-light pull-right" role="menu">
				<li>
					<a class="panel-collapse collapses" href="table_basic.html#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
				</li>
				<li>
					<a class="panel-refresh" href="table_basic.html#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="table_basic.html#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="table_basic.html#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="table_basic.html#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
		<div class="tabbable tabs-left">
			<ul id="myTab2" class="nav nav-tabs">
				<li class="active">
					<a href="#datos-personales" data-toggle="tab">
						<i class="pink fa fa-user"></i> Datos Personales
					</a>
				</li>
				<li>
					<a href="#datos-imagen" data-toggle="tab">
						<i class='pink fa fa-file-photo-o' ></i> Imagen
					</a>
				</li>
				<li>
					<a href="#datos-tecnicos" data-toggle="tab">
						<i class='pink fa fa-gears' ></i> Datos T&eacute;cnicos
					</a>
				</li>
				<li>
					<a href="#datos-extras" data-toggle="tab">
						<i class='pink fa fa-puzzle-piece' ></i> Datos Extra
					</a>
				</li>
				<li>
					<a href="#datos-pass" data-toggle="tab">
						<i class='pink fa fa-key' ></i> Cambiar Contrase&ntilde;a
					</a>
				</li>
				<li>
					<a href="#datos-archivo" data-toggle="tab">
						<i class='pink fa fa-upload' ></i> Subir Archivos
					</a>
				</li>
				<li>
					<a href="#datos-experiencia" data-toggle="tab">
						<i class='pink fa fa-suitcase' ></i> Experiencia
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="datos-personales">
					<h2>Datos Personales</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>usuarios/perfil/guardar_personales" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								RUT <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="rut" value='<?php echo $datos_usuario->rut_usuario ?>' class="form-control" disabled="disabled">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-2">
								Nombres <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" name="nombres" value="<?php echo $datos_usuario->nombres ?>" id="form-field-2" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-3">
								Apellidos <span class="symbol required"></span>
							</label>
							<div class="col-sm-5">
								<input type="text" name="paterno" value="<?php echo $datos_usuario->paterno ?>" id="form-field-3" class="form-control">
							</div>
							<div class="col-sm-4">
								<input type="text" name="materno" value="<?php echo $datos_usuario->materno ?>" id="form-field-3" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-4">
								Fecha de nacimiento 
							</label>
							<div class="col-sm-3">
								<?php 
								if ($datos_usuario->fecha_nac)
									$f_nac = explode('-',$datos_usuario->fecha_nac); 
								else $f_nac = false;
								?>
								<select name="nac_dia" id="nac_dia" class="form-control">
									<option value="">DD</option>
									<?php for( $i=1;$i<32;$i++ ){ ?>
									<option <?php echo (@$f_nac[2] == $i)?'SELECTED':'' ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<select name="nac_mes" id="nac_mes" class="form-control">
									<option value="">MM</option>
									<?php for( $i=1;$i<13;$i++ ){ ?>
									<option <?php echo (@$f_nac[1] == $i)?'SELECTED':'' ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<input type="text" name="nac_ano" placeholder="YYYY" id="nac_ano" value="<?php echo @$f_nac[0] ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Regi&oacute;n <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_region" id="select_region" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_region as $lr) { ?>
										<option value="<?php echo $lr->id ?>" <?php echo ($datos_usuario->id_regiones == $lr->id)?'SELECTED':'' ?> ><?php echo $lr->desc_regiones ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Provincia <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_provincia" id="select_provincia" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_provincia as $lp) { ?>
										<option value="<?php echo $lp->id ?>" <?php echo ($datos_usuario->id_provincias == $lp->id)?'SELECTED':'' ?> ><?php echo $lp->desc_provincias ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Ciudad <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_ciudad" id="select_ciudad" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_ciudad as $lc) { ?>
										<option value="<?php echo $lc->id ?>" <?php echo ($datos_usuario->id_ciudades == $lc->id)?'SELECTED':'' ?> ><?php echo $lc->desc_ciudades ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Direcci&oacute;n 
							</label>
							<div class="col-sm-9">
								<input type="text" name="direccion" id="form-field-5" value="<?php echo $datos_usuario->direccion ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Sexo <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_sexo" id="select_sexo" class="form-control">
									<option value="">Seleccione...</option>
									<option value="0" <?php echo ($datos_usuario->sexo == 0)?'SELECTED':'' ?> >Masculino</option>
									<option value="1" <?php echo ($datos_usuario->sexo == 1)?'SELECTED':'' ?> >Femenino</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Telefono <span class="symbol required"></span>
							</label>
							<?php $fono1 = explode('-', $datos_usuario->fono ); ?>
							<div class="col-sm-2">
								<input type="text" id="form-field-5" name='fono1' value="<?php echo $fono1[0] ?>" class="form-control">
							</div>
							<div class="col-sm-7">
								<input type="text" id="form-field-5" name='fono2' value="<?php echo $fono1[1] ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Telefono
							</label>
							<?php $fono2 = explode('-', $datos_usuario->telefono2 ); ?>
							<div class="col-sm-2">
								<input type="text" id="form-field-5" name='fono3' value="<?php echo @$fono2[0] ?>" class="form-control">
							</div>
							<div class="col-sm-7">
								<input type="text" id="form-field-5" name='fono4' value="<?php echo @$fono2[1] ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Email
							</label>
							<div class="col-sm-9">
								<input type="email" name="email" id="form-field-5" value="<?php echo $datos_usuario->email ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Estado Civil <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_civil" id="select_civil" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_civil as $lc) { ?>
										<option value="<?php echo $lc->id ?>" <?php echo ($datos_usuario->id_estadocivil == $lc->id)?'SELECTED':'' ?> ><?php echo $lc->desc_estadocivil ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Nacionalidad <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_nacionalidad" id="select_nacionalidad" class="form-control">
									<option value="">Seleccione... </option>
									<option value="chilena" <?php echo ($datos_usuario->nacionalidad == "chilena")?'SELECTED':'' ?> >Chilena </option>
									<option value="extranjera" <?php echo ($datos_usuario->nacionalidad == "extranjera")?'SELECTED':'' ?> >Extranjera </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-imagen">
					<h2>Modificar imagen</h2>
					<p>
						Favor seleccione que tipo de imagen desea subir. La extencion de los archivos soportados son .png y .jpg, el tamaño maximo del archivo es de 2MB.
					</p>
					<form enctype="multipart/form-data" role="form" class="form-horizontal" action="<?php echo  base_url() ?>usuarios/perfil/guardar_imagen/<?php echo $id_usuario ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Imagen
							</label>
							<div class="col-sm-9">
								<input type="file" name="imagen" id="file">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar imagen
								</button>
							</div>
						</div>
					</form>
					<br><br><br><br><br>
				</div>
				<div class="tab-pane fade" id="datos-tecnicos">
					<h2>Datos T&eacute;cnicos</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>usuarios/perfil/guardar_tecnicos" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Nivel de estudios
							</label>
							<div class="col-sm-9">
								<select name="select_estudios" id="select_estudios" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_estudios as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_estudios == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_nivelestudios ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-2">
								Nombre Instituci&oacute;n
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-2" name="institucion" value="<?php echo $datos_usuario->institucion ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-3">
								A&ntilde;o egreso
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-3" name="ano_egreso" value="<?php echo $datos_usuario->ano_egreso ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-4">
								Titulo/ Profesi&oacute;n
							</label>
							<div class="col-sm-9">
								<select name="select_profesiones" id="select_profesiones" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_profesiones as $lp) { ?>
										<option value="<?php echo $lp->id ?>" <?php echo ($datos_usuario->id_profesiones == $lp->id)?'SELECTED':'' ?> ><?php echo $lp->desc_profesiones ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Especialidad
							</label>
							<div class="col-sm-9">
								<select name="select_especialidad1" id="select_especialidad1" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_especialidades as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_especialidad_trabajador == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_especialidad ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Especialidad
							</label>
							<div class="col-sm-9">
								<select name="select_especialidad2" id="select_especialidad2" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_especialidades as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_especialidad_trabajador_2 == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_especialidad ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								A&ntilde;os de experiencia
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-5" name="anos_experiencia" value="<?php echo $datos_usuario->ano_experiencia ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Cursos relevantes
							</label>
							<div class="col-sm-9">
								<textarea id="form-field-22" name="cursos" class="form-control"><?php echo $datos_usuario->cursos ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Equipos que maneja
							</label>
							<div class="col-sm-9">
								<textarea id="form-field-22" name="equipos" class="form-control"><?php echo $datos_usuario->equipos ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Software que maneja
							</label>
							<div class="col-sm-9">
								<textarea id="form-field-22" name="software" class="form-control"><?php echo $datos_usuario->software ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Idiomas
							</label>
							<div class="col-sm-9">
								<textarea id="form-field-22" name="idiomas" class="form-control"><?php echo $datos_usuario->idiomas ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-extras">
					<h2>Datos Extra</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>usuarios/perfil/guardar_extra" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Banco
							</label>
							<div class="col-sm-9">
								<select name="select_bancos" id="select_bancos" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_bancos as $lb) { ?>
										<option value="<?php echo $lb->id ?>" <?php echo ($datos_usuario->id_bancos == $lb->id)?'SELECTED':'' ?> ><?php echo $lb->desc_bancos ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-2">
								Tipo de cuenta
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-2" name="tipo_cuenta" value="<?php echo $datos_usuario->tipo_cuenta ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-3">
								N° de cuenta
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-3" name="n_cuenta" value="<?php echo $datos_usuario->cuenta_banco ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-4">
								AFP
							</label>
							<div class="col-sm-9">
								<select name="select_afp" id="select_afp" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_afp as $la) { ?>
										<option value="<?php echo $la->id ?>" <?php echo ($datos_usuario->id_afp == $la->id)?'SELECTED':'' ?> ><?php echo $la->desc_afp ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Sistema de Salud
							</label>
							<div class="col-sm-9">
								<select name="select_salud" id="select_salud" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_salud as $ls) { ?>
										<option value="<?php echo $ls->id ?>" <?php echo ($datos_usuario->id_salud == $ls->id)?'SELECTED':'' ?> ><?php echo $ls->desc_salud ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Licencia de conducir
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-5" name="licencia" value="<?php echo $datos_usuario->licencia ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								N° de Zapato
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-5" name="n_zapato" value="<?php echo $datos_usuario->num_zapato ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Talla de buzo
							</label>
							<div class="col-sm-9">
								<input type="text" id="form-field-5" name="talla_buzo" value="<?php echo $datos_usuario->talla_buzo ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
					
				</div>
				<div class="tab-pane fade" id="datos-pass">
					<form action="#" method="post" class="form-horizontal" >
						<h2>Modificar contraseña</h2>
									<!-- .field -->
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Nueva contraseña
							</label>
							<div class="col-sm-9">
								<input type="password" name="pass_nueva1" id="pass_nueva1" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Nueva contraseña
							</label>
							<div class="col-sm-9">
								<input type="password" name="pass_nueva2" id="pass_nueva2" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar contraseña
								</button>
							</div>
						</div>
					</form>
					
				</div>
				<div class="tab-pane fade" id="datos-archivo">
					<h2>Subir un archivo al sistema</h2>
					<p>
						Favor seleccione que <b>tipo de archivo</b> desea subir. La extencion de los archivos soportados son <b>Word (.doc) y Pdf (.pdf)</b>, el <b>tamaño maximo</b> de cada 
						archivo es de <b>5MB</b>. Usted puede ingresar un <strong>maximo</strong> de 7 archivos.
					</p>

					<form enctype="multipart/form-data" action="<?php echo  base_url() ?>usuarios/perfil/guardar_archivo/<?php echo $id_usuario ?>" method="post" class="form-horizontal" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Tipo de archivo
							</label>
							<div class="col-sm-9">
								<select name="select_archivo" id="select_archivo">
									<option value="">Seleccione el tipo de archivo...</option>
									<?php foreach ($lista_archivos as $la) { ?>
										<option value="<?php echo $la->id ?>"><?php echo $la->desc_tipoarchivo ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Documento
							</label>
							<div class="col-sm-9">
								<input type="file" name="documento" id="documento" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Subir Archivo
								</button>
							</div>
						</div>
					</form>
					<div>
						<h4>Documentos Subidos</h4>
						<?php if($lista_archivos_subidos){ ?>
						<table class="table">
						<?php foreach ($lista_archivos_subidos as $a) { ?>
							<tr>
								<td><?php echo $a->fecha ?></td>
								<td><?php echo $a->nombre ?></td>
								<td><?php echo $a->desc_tipoarchivo ?></td>
								<td><a href='<?php echo base_url().$a->url ?>' target='_blank'>Descargar</a> </td>
							</tr>
						<?php } ?>
						</table>
						<?php } else {?>
						No existen archivos para este usuario
						<?php } ?>
					</div>
				</div>
				<div class="tab-pane fade" id="datos-experiencia">
					<h2>Listado de experiencias</h2>
					<?php if(!empty($lista_experiencia)){ ?>
					Aun no existen experiencias agregadas <br>
					<?php } else { ?>
					<table class="table">
						<thead>
							<th>Desde</th>
							<th>Hasta</th>
							<th>Cargo</th>
							<th>Area</th>
							<th>Empresa Contratista</th>
							<th>Empresa Mandante/Planta</th>
							<th>Principales Funciones</th>
							<th>Referencias</th>
						</thead>
						<tbody>
							<?php foreach ($lista_experiencia as $l) { ?>
								<tr>
									<td><?php echo $l->desde ?></td>
									<td><?php echo $l->hasta ?></td>
									<td><?php echo $l->cargo ?></td>
									<td><?php echo $l->area ?></td>
									<td><?php echo $l->empresa_c ?></td>
									<td><?php echo $l->empresa_m ?></td>
									<td><?php echo $l->funciones ?></td>
									<td><?php echo $l->referencias ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php } ?>
					<a class="btn btn-primary dialog" href="#">Agregar</a>
				</div>
			</div>
		</div>
	</div>
</div>