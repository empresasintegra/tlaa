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
				<td class="td_info"><h1 class="contact_name"><?php echo ucwords(mb_strtolower($empresa -> razon_social,"UTF-8")); ?></h1>
				<p class="contact_company">
					<?php if($this -> session -> userdata('tipo') == 3) $url = base_url().'administracion/empresas/buscar'; else $url = 'javascript:;'; ?>
					<a href="<?php echo $url ?>">Empresa</a>
				</p>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
	<h2>Datos Empresa</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Rut</td>
				<td><?php echo $empresa->rut; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Giro</td>
				<td><?php echo $empresa->giro; ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	<h2>Datos Planta y Usuarios</h2>
	<?php foreach($planta as $p){ ?>
	<h3>Datos Planta/Sucursal</h3>
	<table class="data display">
		<thead>
			<tr>
				<th>Planta/Sucursal</th>
				<th>Fono</th>
				<th>Email</th>
				<th>Fax</th>
			</tr>
		</thead>
		<tbody>
			<tr class="odd gradeX">
				<td><?php echo ucwords(mb_strtolower($p->nombre,"UTF-8")); ?></td>
				<td><?php echo $p->fono ?></td>
				<td><?php echo $p->email ?></td>
				<td><?php echo $p->fax ?></td>
			</tr>
			
		</tbody>
	</table>
	<br />
	<h3>Usuarios</h3>
	<?php if(isset($p->usuarios)){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Rut</th>
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($p->usuarios as $u){ ?>
			<tr class="odd gradeX">
				<td><?php echo $u->rut ?></td>
				<td><?php echo ucwords(mb_strtolower($u->nombres." ".$u->paterno." ".$u->materno,"UTF-8")); ?></td>
				<td><?php echo $u->fono ?></td>
				<td><?php echo $u->email ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }else{ ?>
	<p>Aun no existen usuarios</p>
	<?php } ?>
	<br />
	<h3>Sub Usuarios</h3>
	<p>Aun no existen sub usuarios</p>
	<?php } ?>
	<br />
</div>
<div class="grid grid_6">
	<a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn primary xlarge block">Imprimir</a>
	<div class="box">
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
			<?php if(!empty($empresa->web)){
			?>
			<li>
				<strong>Sitio web: </strong> <a target="_blank" href="http://<?php echo $empresa -> web ?>"><?php echo $empresa -> web;?></a>
			</li>
			<?php }?>
		</ul>
		<br />
	</div>
	<!-- .box -->
</div>
<div id="contact_profile" class="grid grid_24 append_1">
	<h2>Requerimientos</h2>
	<?php if(count(@$requerimiento) > 0){ ?>
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
		<?php foreach ($requerimiento as $re) { ?>
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