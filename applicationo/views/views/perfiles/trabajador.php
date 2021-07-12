<link href="<?php echo base_url() ?>extras/css/imprimir_perfil.css" rel="stylesheet" type="text/css" media="print" />
<div id="contact_profile" class="grid grid_17 append_1">
	<table>
		<tbody>
			<tr>
				<td class="td_avatar">
					<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
						<img src="<?php echo base_url().$imagen_grande->thumb ?>" class="avatar" alt="Imagen Perfil">
					</a> 
				</td>
				<td class="td_info"><h1 class="contact_name"><?php echo ucwords(mb_strtolower($usuario -> nombres . ' ' . $usuario -> paterno . ' ' . $usuario -> materno,"UTF-8"));?></h1>
				<p class="contact_company">
					<?php if($this -> session -> userdata('tipo') == 3) $url = base_url().'administracion/trabajadores/buscar'; else $url = 'javascript:;'; ?>
					<a href="<?php echo $url ?>"><?php echo ucwords(mb_strtolower($tipo_usuario->desc_tipo_usuarios,"UTF-8")); ?></a>
				</p>
				<p class="contact_tags">
					<?php if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No se ha actualizado el perfil";
						else{
							 $act = explode("-",$usuario->fecha_actualizacion);
							$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
						} ?>
					<span>Ultima actualizacion: <?php echo $actualizacion ?></span>
				</p></td>
			</tr>
		</tbody>
	</table>
	<hr>
	<h2>Datos Personales</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Rut</td>
				<td><?php echo $usuario->rut_usuario; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Sexo</td>
				<td><?php echo ($usuario->sexo == 0) ? 'Masculino' : 'Femenino'; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Fecha de Nacimiento</td>
				<?php if($usuario->fecha_nac){ ?>
				<?php $fecha_nacimiento = explode("-", $usuario->fecha_nac) ?>
				<td><?php echo $fecha_nacimiento[2].'-'.$fecha_nacimiento[1].'-'.$fecha_nacimiento[0]; ?></td>
				<?php }else{ ?>
				<td>&nbsp;</td>
				<?php } ?>
			</tr>
			<tr class="odd gradeX">
				<td>Estado Civil</td>
				<td><?php echo @ucwords(mb_strtolower($estado_civil->desc_estadocivil,"UTF-8")); ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Nacionalidad</td>
				<td><?php echo @ucwords($usuario->nacionalidad); ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>AFP</td>
				<td><?php echo @ucwords(mb_strtolower($afp->desc_afp,"UTF-8")); ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Sistema de Salud</td>
				<td><?php echo @ucwords(mb_strtolower($salud->desc_salud,"UTF-8")); ?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<h2>Datos Tecnicos</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Nivel Máximo de Estudios</td>
				<td><?php echo (!empty($nivel_estudios->desc_nivelestudios)) ? ucwords(mb_strtolower($nivel_estudios->desc_nivelestudios,"UTF-8")):"&nbsp;"; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Nombre de la Institución</td>
				<td><?php echo (!empty($usuario->institucion)) ? $usuario->institucion:"&nbsp;"; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Año de Egreso</td>
				<td><?php echo (!empty($usuario->ano_egreso)) ? $usuario->ano_egreso:"&nbsp;"; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Profesión</td>
				<td><?php echo (!empty($profesion->desc_profesiones)) ? ucwords(mb_strtolower($profesion->desc_profesiones,"UTF-8")):"&nbsp;"; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Especialidad</td>
				<td><?php echo (!empty($especialidad1->desc_especialidad)) ? ucwords(mb_strtolower($especialidad1->desc_especialidad,"UTF-8")):"&nbsp;"; ?></td>
			</tr>
			<?php if(isset($especialidad2)){ ?> <!-- no obligatoria -->
			<tr class="odd gradeX">
				<td>Segunda Especialidad</td>
				<td><?php echo ucwords(mb_strtolower($especialidad2->desc_especialidad,"UTF-8")); ?></td>
			</tr>
			<?php } ?>
			<tr class="odd gradeX">
				<td>Años de Experiencia</td>
				<td><?php echo (!empty($usuario->ano_experiencia)) ? $usuario->ano_experiencia:"&nbsp;"; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Cursos relevantes</td>
				<?php if(isset($cursos)){ ?>
				<td><?php echo $cursos; ?></td>
				<?php }else{?>
				<td>&nbsp;</td>
				<?php } ?>
			</tr>
			<tr class="odd gradeX">
				<td>Equipos que maneja</td>
				<?php if(isset($equipos)){ ?>
				<td><?php echo $equipos; ?></td>
				<?php }else{?>
				<td>&nbsp;</td>
				<?php } ?>
			</tr>
			<tr class="odd gradeX">
				<td>Software que maneja</td>
				<?php if(isset($software)){ ?>
				<td><?php echo $software; ?></td>
				<?php }else{?>
				<td>&nbsp;</td>
				<?php } ?>
			</tr>
			<tr class="odd gradeX">
				<td>Idiomas</td>
				<?php if(isset($idioma)){ ?>
				<td><?php echo $idioma; ?></td>
				<?php }else{?>
				<td>&nbsp;</td>
				<?php } ?>
			</tr>
		</tbody>
	</table>
	<br />
</div>
<div class="grid grid_6">
	<a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn primary xlarge block">Imprimir</a>
	<div class="box">
		<h3>Contacto</h3>
		<ul class="contact_details">
			<?php if(!empty($usuario->direccion)){
			?>
			<li>
				<strong>Dirección: </strong>&nbsp;<?php echo ucwords(mb_strtolower($usuario -> direccion,"UTF-8"));?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->id_provincias)){
			?>
			<li>
				<strong>Provincia: </strong>&nbsp;<?php echo ucwords(mb_strtolower($this->Provincia_model->get($usuario->id_provincias)->desc_provincias,"UTF-8"));?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->id_ciudades)){
			?>
			<li>
				<strong>Ciudad: </strong>&nbsp;<?php echo ucwords(mb_strtolower($this->Ciudad_model->get($usuario->id_ciudades)->desc_ciudades,"UTF-8"));?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->email)){
			?>
			<li>
				<strong>Email: </strong>&nbsp;<?php echo ucwords(mb_strtolower($usuario -> email,"UTF-8"));?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->fono)){
			?>
			<li>
				<strong>Fono: </strong>&nbsp;<?php echo $usuario -> fono;?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->telefono2)){
			?>
			<li>
				<strong>Fono: </strong>&nbsp;<?php echo $usuario -> telefono2;?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->fax)){
			?>
			<li>
				<strong>Fax: </strong>&nbsp;<?php echo $usuario -> fax;?>
			</li>
			<?php }?>
		</ul>
		<br>
		<!-- <h3>Background</h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
		</p> -->
	</div>
	<!-- .box -->
</div>
<div id="contact_profile" class="grid grid_24 append_1">
	<h2>Experiencia</h2>
	<?php if(count($experiencia) > 0){ ?>
	<table class="data display">
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
		<?php foreach ($experiencia as $ex) { ?>
		<tr class="odd gradeX">
			<?php $f_desde = explode("-", $ex->desde) ?>
			<td><?php echo $f_desde[2].'-'.$f_desde[1].'-'.$f_desde[0] ?></td>
			<?php $f_hasta = explode("-", $ex->hasta) ?>
			<td><?php echo $f_hasta[2].'-'.$f_hasta[1].'-'.$f_hasta[0] ?></td>
			<td><?php echo $ex->cargo ?></td>
			<td><?php echo $ex->area ?></td>
			<td><?php echo $ex->empresa_c ?></td>
			<td><?php echo $ex->empresa_m ?></td>
			<td>
			<?php $funciones = explode(";", $ex->funciones); ?>
			<?php for($i=0;$i<(count($funciones)-1);$i++){
				echo ucwords(mb_strtolower($funciones[$i],"UTF-8"));
				if($i < (count($funciones)-2)) echo ", ";
			} ?>
			</td>
			<td>
			<?php $referencia = explode(";", $ex->referencias); ?>
			<?php for($i=0;$i<(count($referencia)-1);$i++){
				echo ucwords(mb_strtolower($referencia[$i],"UTF-8"));
				if($i < (count($referencia)-2)) echo ", ";
			} ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	</table>
	<?php } else{ ?>
	<p>No se han agregado experiencias</p>
	<?php } ?>
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Archivos subidos</h2>
	<?php if(count($archivos) > 0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Tipo</th>
				<th>Descarga</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($archivos as $ar) { ?>
		<tr class="odd gradeX">
			<td><?php echo $ar->nombre ?></td>
			<td><?php echo ucwords(mb_strtolower($ar->desc_tipoarchivo,"UTF-8")) ?></td>
			<td><a href="<?php echo base_url().$ar->url ?>">Descargar</a> </td>
		</tr>
		<?php } ?>
	</tbody>
	</table>
	<?php } else{ ?>
	<p>No se han agregado archivos</p>
	<?php } ?>
</div>