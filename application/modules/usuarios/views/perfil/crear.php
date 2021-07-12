<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> REGISTRAR</h4>
		<div class="panel-tools">										
			<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu dropdown-light pull-right" role="menu">
				<li>
					<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
				</li>
				<li>
					<a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
	<p>
		Create one account to manage everything you do with Rapido, from your shopping preferences to your Rapido activity.
	</p>
	<hr>
	<form action="" role="form" id="form" method='post'>
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
					<label class="control-label">
						Rut <span class="symbol required"></span>
					</label>
					<input type="text" placeholder="Ingrese el rut" class="form-control" id="rut" name="rut" value="<?php if(!empty($texto_anterior['rut_usuario'])) ?>" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Nombres <span class="symbol required"></span>
					</label>
					<input type="text" placeholder="Ingrese sus nombres" class="form-control" id="firstname" name="nombres" value="<?php if(!empty($texto_anterior['nombres'])) ?>" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Apellido Paterno <span class="symbol required"></span>
					</label>
					<input type="text" placeholder="Ingrese su apellido Paterno" class="form-control" id="lastname" name="paterno" value="<?php if(!empty($texto_anterior['paterno'])) ?>" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Apellido Materno 
					</label>
					<input type="text" placeholder="Ingrese su apellido Materno" class="form-control" id="lastname" name="materno" value="<?php if(!empty($texto_anterior['materno'])) ?>" >
				</div>
				<div class="form-group">
					<label class="control-label">
						Correo Electr&oacute;nico
					</label>
					<input type="email" placeholder="Ingrese el correo" class="form-control" id="email" name="email" value="<?php if(!empty($texto_anterior['email'])) ?>" >
				</div>
				<div class="form-group">
					<label class="control-label">
						Contrase&ntilde;a <span class="symbol required"></span>
					</label>
					<input type="password" class="form-control" name="password" id="password" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Confirmar Contrase&ntilde;a <span class="symbol required"></span>
					</label>
					<input type="password" class="form-control" id="password_again" name="password_again" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group connected-group">
					<label class="control-label">
						Tel&eacute;fono <span class="symbol required"></span>
					</label>
					<div class="row">
						<div class="col-md-2">
							<input type="phone" class="form-control" name="fono1" id="phone" value="<?php if(!empty($texto_anterior['fono1'])) ?>" required>
						</div>
						<div class="col-md-7">
							<input type="phone" class="form-control" name="fono2" id="phone" value="<?php if(!empty($texto_anterior['fono2'])) ?>" required>
						</div>
					</div>
				</div>
				<div class="form-group connected-group">
					<label class="control-label">
						Fecha de Nacimiento 
					</label>
					<div class="row">
						<div class="col-md-3">
							<select name="select_nac_dia" id="dd" class="form-control">
								<option value="">DD</option>
								<option value="01">1</option>
								<option value="02">2</option>
								<option value="03">3</option>
								<option value="04">4</option>
								<option value="05">5</option>
								<option value="06">6</option>
								<option value="07">7</option>
								<option value="08">8</option>
								<option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select>
						</div>
						<div class="col-md-3">
							<select name="select_nac_mes" id="mm" class="form-control">
								<option value="">MM</option>
								<option value="01">1</option>
								<option value="02">2</option>
								<option value="03">3</option>
								<option value="04">4</option>
								<option value="05">5</option>
								<option value="06">6</option>
								<option value="07">7</option>
								<option value="08">8</option>
								<option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" placeholder="YYYY" id="yyyy" name="select_nac_ano" class="form-control">
						</div>
					</div>
				</div>
				<div class="form-group ">
					<label class="control-label">
						Tipo de Usuario <span class="symbol required"></span>
					</label>
					<div class="row">
						<div class="col-md-9">
							<select name="tipo_usuario" id="tipo_usuario" class="form-control" <?php echo ($tipo)?'disabled':''; ?> required>
								<option value="" >Seleccionar</option>
								<?php foreach ($lista_tipo as $l) { ?>
									<option value="<?php echo $l->id ?>" <?php echo ($tipo == $l->id)?'SELECTED':''; ?> ><?php echo $l->nombre ?></option>
								<?php } ?>
							</select>
							<?php if($tipo){ ?>
							<input type="hidden" name="tipo_usuario" value="<?php echo $tipo ?>" />
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="form-group ">
					<label class="control-label">
						Cargo <span class="symbol required"></span>
					</label>
					<div class="row">
						<div class="col-md-9">
							<select name="cargo" id="cargo_usuario" class="form-control" <?php echo ($tipo)?'disabled':''; ?> required>
								<option value="">Seleccionar</option>
								<?php if($tipo){ ?>
									<?php foreach ($cargo as $c) { ?>
										<option value='<?php $c->id ?>'
										<?php if( $tipo == 3 ){ ?>
											<?php echo ($c->id == 2)?'SELECTED':''; ?>
										<?php } ?> 
										 ><?php echo $c->desc_tipo_usuarios; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php if($tipo){ ?>
							<input type="hidden" name="cargo" value="2" />
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label">
						Genero
					</label>
					<div>
						<label class="radio-inline">
							<input type="radio" class="grey" value="1" name="genero" id="gender_female" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
							Femenino
						</label>
						<label class="radio-inline">
							<input type="radio" class="grey" value="0" name="genero" id="gender_male" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
							Masculino
						</label>
					</div>
				</div>
				<div class="form-group">
					<hr>
					<label class="control-label">
						<strong>Chat</strong> <span class="symbol required"></span>
					</label>
					<p>
						Activar el acceso a chat?
					</p>
					<div>
						<label class="radio-inline">
							<input type="radio" class="grey" value="0" name="chat" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);" checked>
							No
						</label>
						<label class="radio-inline">
							<input type="radio" class="grey" value="1" name="chat" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
							Si
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div>
					<span class="symbol required"></span>Campos Obligatorios
					<hr>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
			</div>
			<div class="col-md-4">
				<button class="btn btn-yellow btn-block" type="submit">
					Registrar <i class="fa fa-arrow-circle-right"></i>
				</button>
			</div>
		</div>
	</form>
</div>
</div>