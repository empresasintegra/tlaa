<link href="<?php echo base_url() ?>extras/css/imprimir_perfil.css" rel="stylesheet" type="text/css" media="print" />
<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"></h4>
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
						<a class="panel-refresh" href="#">
							<i class="fa fa-refresh"></i> <span>Refresh</span>
						</a>
					</li>
					<li>
						<a class="panel-config" href="#panel-config" data-toggle="modal">
							<i class="fa fa-wrench"></i> <span>Configurations</span>
						</a>
					</li>
					<li>
						<a class="panel-expand" href="#">
							<i class="fa fa-expand"></i> <span>Fullscreen</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div id="contact_profile" class="col-xs-12">
			<table class='table col-xs-3'>
				<tbody>
					<tr>
						<td class="td_avatar" style='width:79px;'>
							<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
								<img src="<?php echo base_url() . $this -> session -> userdata('imagen');?>" class="avatar" alt="Imagen Perfil">
							</a>
						</td>
						<td class="td_info"><h1 class="contact_name"><?php echo $usuario->nombre; ?></h1>
						<p class="contact_company">
							<a href="#">Trabajador</a>
						</p>
						<p class="contact_tags">
							<span>Ultima actualizacion: <?php echo $usuario->actualizacion ?></span>
						</p></td>
						<td><a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn btn-primary btn-block">Imprimir</a></td>
					</tr>
				</tbody>
			</table>
			<hr>
			<h2>Datos Personales</h2>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Rut</td>
						<td><?php echo $usuario->rut; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Sexo</td>
						<td><?php echo $usuario->sexo; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Fecha de Nacimiento</td>
						<td><?php echo $usuario->nacimiento; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Regi&oacute;n</td>
						<td><?php echo $usuario->region; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Provincia</td>
						<td><?php echo $usuario->provincia; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Ciudad</td>
						<td><?php echo $usuario->ciudad; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Direcci&oacute;n</td>
						<td><?php echo $usuario->direccion; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Estado Civil</td>
						<td><?php echo $usuario->civil; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>AFP</td>
						<td><?php echo $usuario->afp; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Sistema de Salud</td>
						<td><?php echo $usuario->salud; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Nacionalidad</td>
						<td><?php echo $usuario->nacionalidad; ?></td>
					</tr>
				</tbody>
			</table>
			<br>
			<h2>Contacto de Emergencia</h2>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Nombre</td>
						<td></td>
					</tr>
					<tr class="odd gradeX">
						<td>Direcci&oacute;n</td>
						<td></td>
					</tr>
					<tr class="odd gradeX">
						<td>Comuna</td>
						<td>&nbsp;</td>
					</tr>
					<tr class="odd gradeX">
						<td>Cuidad</td>
						<td></td>
					</tr>
					<tr class="odd gradeX">
						<td>Regi&oacute;n</td>
						<td></td>
					</tr>
					<tr class="odd gradeX">
						<td>Telefono</td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<br>
			<h2>Datos Tecnicos</h2>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Nivel Máximo de Estudios</td>
						<td><?php echo $tecnicos->estudios ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Nombre de la Institución</td>
						<td><?php echo $tecnicos->institucion ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Año de Egreso</td>
						<td><?php echo $tecnicos->egreso ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Profesión</td>
						<td><?php echo $tecnicos->profesion ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Especialidad</td>
						<td><?php echo $tecnicos->especialidad ?></td>
					</tr>
					<?php if(isset($tecnicos->especialidad2)){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Segunda Especialidad</td>
						<td><?php echo $tecnicos->especialidad2 ?></td>
					</tr>
					<?php } ?>
					<?php if(isset($tecnicos->especialidad3)){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Tercera Especialidad</td>
						<td><?php echo ucwords(mb_strtolower($tecnicos->desc_especialidad,"UTF-8")); ?></td>
					</tr>
					<?php } ?>
					<tr class="odd gradeX">
						<td>Años de Experiencia</td>
						<td><?php echo $tecnicos->experiencia; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Cursos relevantes</td>
						<td><?php echo $tecnicos->cursos ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Equipos que maneja</td>
						<td><?php echo $tecnicos->equipos ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Software que maneja</td>
						<td><?php echo $tecnicos->software ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Idiomas</td>
						<td><?php echo $tecnicos->idiomas ?></td>
					</tr>
				</tbody>
			</table>
			<br />
		</div>
		<div id="contact_profile" class="">
			<h2>Datos Familiares</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Parentesco</th>
						<th>Apellido Paterno</th>
						<th>Apellido Materno</th>
						<th>Nombres</th>
						<th>Sexo</th>
						<th>Fecha de Nacimiento</th>
						<th>Rut</th>
						<th>Carga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="contact_profile">
			<h2>Experiencia (XX años)</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Desde</th>
						<th>Hasta</th>
						<th>Cargo</th>
						<th>Area</th>
						<th>Empresa contratista</th>
						<th>Empresa mandante/planta</th>
						<th>Principales funciones</th>
						<th>Referencias</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="archivos" >
			<h2>Informaci&oacute;n General</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Tipo</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="archivos" >
			<h2>Calificaciones y Examenes</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Documentos</th>
						<th>Fecha Contrataci&oacute;n</th>
						<th>Fecha Caducidad</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="archivos" >
			<h2>Contratos y Finiquitos</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Contratos</th>
						<th>Fecha Contrataci&oacute;n</th>
						<th>Fecha Caducidad</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="archivos" >
			<h2>Examenes Preocupacionales</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Examenes</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Fecha Vigencia</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="archivos" >
			<h2>Charlas Masso</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Charla Masso</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Fecha Vigencia</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
		<div id="archivos" >
			<h2>Examen Psicol&oacute;gico</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Examenes</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>