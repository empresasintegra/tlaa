<link href="<?php echo base_url() ?>extras/css/imprimir_perfil.css" rel="stylesheet" type="text/css" media="print" />
<div id="contact_profile" class="grid grid_17 append_1">
	<table>
		<tbody>
			<tr>
				<td class="td_avatar">
					<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
						<img src="<?php echo base_url() . $this -> session -> userdata('imagen');?>" class="avatar" alt="Imagen Perfil">
					</a>
				</td>
				<td class="td_info"><h1 class="contact_name"><?php echo ucwords(mb_strtolower($usuario -> nombres . ' ' . $usuario -> paterno . ' ' . $usuario -> materno, "UTF-8"));?></h1>
				<p class="contact_company">
					<?php if($this -> session -> userdata('tipo') == 3) $url = base_url().'administracion/mandantes/buscar'; else $url = 'javascript:;'; ?>
					<a href="<?php echo $url ?>"><?php echo ucwords(mb_strtolower($tipo_usuario->desc_tipo_usuarios,"UTF-8")); ?></a>
				</p>
				<p class="contact_tags">
					<span><?php echo ucwords(mb_strtolower($empresa->razon_social,"UTF-8")); ?></span>
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
				<td>Planta/Sucursal</td>
				<td><?php echo ucwords(mb_strtolower($planta->nombre,"UTF-8")); ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	<h2>Datos Planta/Sucursal</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Telefono</td>
				<td><?php echo $planta->fono ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>E-mail</td>
				<td><?php echo $planta->email ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Fax</td>
				<td><?php echo $planta->fax ?></td>
			</tr>
		</tbody>
	</table>
	<br>
</div>
<div class="grid grid_6">
	<a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn primary xlarge block">Imprimir</a>
	<div class="box">
		<h3>Contacto</h3>
		<ul class="contact_details">
			<?php if(!empty($usuario->direccion)){
			?>
			<li>
				<strong>Dirección: </strong><?php echo ucwords(mb_strtolower($usuario -> direccion,"UTF-8"));?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->email)){
			?>
			<li>
				<strong>Email: </strong><?php echo ucwords(mb_strtolower($usuario -> email,"UTF-8"));?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->fono)){
			?>
			<li>
				<strong>Fono: </strong><?php echo $usuario -> fono;?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->telefono2)){
			?>
			<li>
				<strong>Fono: </strong><?php echo $usuario -> telefono2;?>
			</li>
			<?php }?>
			<?php if(!empty($usuario->fax)){
			?>
			<li>
				<strong>Fax: </strong><?php echo $usuario -> fax;?>
			</li>
			<?php }?>
		</ul>
		<br/>
	</div>
	<!-- .box -->
</div>
<div id="contact_profile" class="grid grid_24 append_1">
	<h2>Requerimientos</h2>
	<?php if(count(@$requerimientos) > 0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Lugar</th>
				<th>Area</th>
				<th>Cargo</th>
				<th>Centro de Costo</th>
				<th>Especialidad</th>
				<th>Trabajadores</th>
				<th>Fecha Inicio</th>
				<th>Fecha Termino</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($requerimientos as $re) { ?>
		<tr class="odd gradeX">
			<td><?php echo $re->nombre ?></td>
			<td><?php echo $re->lugar ?></td>
			<td>
			<?php foreach($re->req as $r){ ?>
			- <?php echo $r->area ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			- <?php echo $r->cargo ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			- <?php echo $r->cc ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			- <?php echo $r->especialidad ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			- <?php echo $r->cantidad ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			<?php $f_desde = explode("-", $r->f_inicio) ?>
			- <?php echo $f_desde[2].'-'.$f_desde[1].'-'.$f_desde[0] ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			<?php $f_hasta = explode("-", $r->f_termino) ?>
			- <?php echo $f_hasta[2].'-'.$f_hasta[1].'-'.$f_hasta[0] ?><br/>
			<?php } ?>
			</td>
			<td>
			<?php foreach($re->req as $r){ ?>
			- <?php echo $r->estado ?><br/>
			<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	</table>
	<?php } else{ ?>
	<p>No han agregado reqerimientos</p>
	<?php } ?>
</div>