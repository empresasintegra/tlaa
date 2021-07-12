<li class="nav link"><a href="<?php echo  base_url()?>subusuario" class="item">Inicio</a></li>
<li class="nav link"><a href="#" class="item">Requerimientos</a>
	<div class="menu" style="display: none">
		<h3>Requerimientos</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>subusuario/requerimiento/estado">Estado</a></li>
		</ul>
		<h3>Historiales</h3>
		<ul>
			<li><a href="#">De requerimientos</a></li>
			<li><a href="#">De trabajadores</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link right"><a href="#" class="item">Mensajes</a>
	<div class="menu" style="display: none">
		<h3>Mensajes internos</h3>
		<ul>
			<li><a class="dialog" href="<?php echo base_url() ?>subusuario/mensajes/crear">Crear mensaje</a></li>
			<li><a href="<?php echo base_url() ?>subusuario/mensajes/bandeja">Revisar mensajes</a></li>
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
			<li><a href="<?php echo base_url() ?>subusuario/perfil">Como me ven</a></li>
			<li><a href="<?php echo base_url() ?>subusuario/perfil/editar#datos-personales">Datos Personales</a></li>
			<hr />
			<li><a href="<?php echo base_url() ?>login/salir">Salir</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>