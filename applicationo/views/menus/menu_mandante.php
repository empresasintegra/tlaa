<li class="nav link"><a href="<?php echo  base_url()?>mandante" class="item">Inicio</a></li>
<li class="nav link"><a href="#" class="item">Usuarios</a>
	<div class="menu" style="display: none">
		<h3>SubUsuarios</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>mandante/subusuarios/crear">Crear</a></li>
			<li><a href="<?php echo base_url() ?>mandante/subusuarios/listado">Buscar</a></li>
		</ul>
		<h3>proceso</h3>
		<ul>
			<li><a href="#">Asignar</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Requerimientos</a>
	<div class="menu" style="display: none">
		<h3>Requerimientos</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>mandante/requerimiento/publicar">Publicar</a></li>
			<li><a href="<?php echo base_url() ?>mandante/requerimiento/estado">Estado</a></li>
			<li><a href="<?php echo base_url() ?>mandante/requerimiento/historial_requerimiento">Historial</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Configuraciones</a>
	<div class="menu" style="display: none">
		<h3>Publicaciones integra</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>mandante/areas">Mis areas</a></li>
			<li><a href="<?php echo base_url() ?>mandante/cargos">Mis cargos</a></li>
			<li><a href="<?php echo base_url() ?>mandante/centros_de_costo">Mis centros de costo</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Anuncios</a>
	<?php if($noticias_noleidas > 0){ ?>
	<div class="notify"><?php echo $noticias_noleidas ?></div>
	<?php } ?>
	<div class="menu" style="display: none">
		<h3>Publicaciones integra</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>mandante/noticias">Noticias publicadas</a>
				<?php if($noticias_noleidas > 0){ ?>
				<div class="notify lista"><?php echo $noticias_noleidas ?></div>
				<?php } ?>
			</li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>

<li class="nav link right"><a href="#" class="item">Mensajes</a>
	<?php if($mensajes_noleidos > 0){ ?>
	<div class="notify"><?php echo $mensajes_noleidos ?></div>
	<?php } ?>
	<div class="menu" style="display: none">
		<h3>Mensajes internos</h3>
		<ul>
			<li><a class="dialog" href="<?php echo base_url() ?>mandante/mensajes/crear">Crear mensaje</a></li>
			<li><a href="<?php echo base_url() ?>mandante/mensajes/bandeja">Revisar mensajes</a>
				<?php if($mensajes_noleidos > 0){ ?>
				<div class="notify lista"><?php echo $mensajes_noleidos ?></div>
				<?php } ?>
			</li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link right"><a href="#" class="item">Perfil</a>
	<div class="menu" style="display: none">
		<div class="img_aux"></div>
		<div class="img_perfil"><img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="imagen de perfil" /></div>
		<hr class="hr" />
		<h3>Preferencias</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>mandante/perfil">Como me ven</a></li>
			<li><a href="<?php echo base_url() ?>mandante/perfil/editar">Datos Personales</a></li>
			<hr />
			<li><a href="<?php echo base_url() ?>login/salir">Salir</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link right" style='color:white;'>Bienvenido Usuario Apellido</li>