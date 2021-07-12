<li class="nav link"><a href="<?php echo  base_url()?>trabajador" class="item">Inicio</a></li>
<li class="nav link"><a href="<?php echo base_url() ?>trabajador/evaluaciones/informe" class="item">Evaluaciones</a>
	<!--<div class="menu" style="display: none">
		<h3>Publicaciones integra</h3>
		<ul>
			<?php foreach($listado_tipoeval as $l){ ?>
				<li><a href="<?php echo base_url() ?>trabajador/evaluaciones/index/<?php echo urlencode(mb_strtolower($l->nombre,"UTF-8")) ?>"><?php echo ucwords(mb_strtolower($l->nombre,"UTF-8")) ?></a></li>
			<?php } ?>
		</ul>
		<ul>
			<li><a href="<?php echo base_url() ?>trabajador/evaluaciones/informe">Informe de evaluaciones</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>-->
</li>
<li class="nav link"><a href="<?php echo base_url() ?>trabajador/requerimiento/historial" class="item">Trabajos</a>
	<?php if($requerimiento_nuevo > 0){ ?>
	<div class="notify"><?php echo $requerimiento_nuevo ?></div>
	<?php } ?>
	<!--<div class="menu" style="display: none">
		<h3>Asignaciones</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>trabajador/requerimiento/asignado">Asignados</a>
				<?php if($requerimiento_nuevo > 0){ ?>
				<div class="notify lista"><?php echo $requerimiento_nuevo ?></div>
				<?php } ?>
			</li>
			<li><a href="<?php echo base_url() ?>trabajador/requerimiento/anteriores">Historial</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>-->
</li>
<li class="nav link"><a href="<?php echo base_url() ?>trabajador/publicaciones" class="item">Publicaciones</a>
	<?php if($noticias_noleidas > 0 || $capacitaciones_noleidas > 0 || $ofertas_noleidas > 0){ ?>
	<?php 
	if($noticias_noleidas > 0) $n = $noticias_noleidas;
	else $n = 0;
	?>
	<?php
	if($ofertas_noleidas > 0) $o = $ofertas_noleidas;
	else $o = 0;
	?>
	<?php 
	if(@$capacitaciones_noleidas > 0) $c = $capacitaciones_noleidas;
	else $c = 0;
	?>
	<?php $suma_publicaciones = $c + $n + $o; ?>
	<div class="notify"><?php echo $suma_publicaciones ?></div>
	<?php } ?>
	<!--
	<div class="menu" style="display: none">
		<h3>Publicaciones integra</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>trabajador/publicaciones">Publicaciones</a></li>
			<li><a href="<?php echo base_url() ?>trabajador/noticias">Noticias</a>
				<?php if($noticias_noleidas > 0){ ?>
				<div class="notify lista"><?php echo $noticias_noleidas ?></div>
				<?php } ?>
			</li>
			<li><a href="<?php echo base_url() ?>trabajador/capacitaciones">Capacitación</a>
				<?php if(@$capacitaciones_noleidas > 0){ ?>
				<div class="notify lista"><?php echo $capacitaciones_noleidas ?></div>
				<?php } ?>
			</li>
			<li><a href="<?php echo base_url() ?>trabajador/ofertas">Ofertas de Trabajo</a>
				<?php if(@$ofertas_noleidas > 0){ ?>
				<div class="notify lista"><?php echo $ofertas_noleidas ?></div>
				<?php } ?>
			</li>
		</ul>
		<span class="menu-top"></span>
	</div>-->
</li>
<!--
<li class="nav link"><a href="#" class="item">Archivos</a>
	<div class="menu" style="display: none">
		<h3>Mis Archivos</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>trabajador/archivos/subir">Subir</a></li>
			<li><a href="<?php echo base_url() ?>trabajador/archivos/buscar">Buscar</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>-->
<!--
<li class="nav link"><a href="<?php echo base_url() ?>trabajador/experiencia" class="item">Experiencia</a></li>
-->
<li class="nav link right"><a href="#" class="item">Ayuda</a>
	<?php if($mensajes_noleidos > 0){ ?>
	<div class="notify"><?php echo $mensajes_noleidos ?></div>
	<?php } ?>
	<div class="menu right" style="display: none">
		<h3>Mensajes internos</h3>
		<ul>
			<!--<li><a class="dialog" href="<?php echo base_url() ?>trabajador/mensajes/crear">Crear mensaje</a></li>-->
			<li><a class="dialog" href="<?php echo base_url() ?>trabajador/mensajes/bandeja">Crear mensaje</a></li>
			<li><a href="<?php echo base_url() ?>trabajador/mensajes/bandeja">Revisar mensajes</a>
				<?php if($mensajes_noleidos > 0){ ?>
				<div class="notify lista"><?php echo $mensajes_noleidos ?></div>
				<?php } ?>
			</li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link right"><a href="#" class="item">Perfil</a>
	<div class="menu right" style="display: none">
		<div class="img_aux"></div>
		<div class="img_perfil"><img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="imagen de perfil" /></div>
		<hr class="hr" />
		<h3>Preferencias</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>trabajador/perfil">Como me Ven</a></li>
			<li><a href="<?php echo base_url() ?>trabajador/perfil/editar#datos-personales">Actualizar Perfil</a></li>
			<hr />
			<li><a href="<?php echo base_url() ?>login/salir">Cerrar Sesión</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>