<li class="nav link"><a href="<?php echo  base_url()?>consulta" class="item">Inicio</a></li>
<li class="nav link"><a href="#" class="item">Consulta</a>
	<div class="menu" style="display: none">
		<ul>
			<li><a href="<?php echo base_url() ?>consulta/trabajador/">Por Trabajador</a></li>
			<li><a href="<?php echo base_url() ?>consulta/requerimiento/">Masiva</a></li>
			<li><a href="<?php echo base_url() ?>consulta/observaciones/">trabajador con Observaciones</a></li>
		</ul>
	</div>
</li>
<li class="nav link"><a href="<?php echo base_url() ?>consulta/publicaciones" class="item">Publicaciones</a>
	<!--<div class="menu" style="display: none">
		<ul>
			<li><a href="<?php echo base_url() ?>consulta/noticias/">Noticias</a></li>
			<li><a href="<?php echo base_url() ?>consulta/ofertas/">Ofertas de Trabajo</a></li>
			<li><a href="<?php echo base_url() ?>consulta/capacitaciones/">Capacitaciones</a></li>
			<li><a href="#">Eventos</a></li>
		</ul>
	</div>-->
</li>
<!--
<li class="nav link"><a href="<?php echo base_url() ?>consulta/trabajador/" class="item">Trabajador</a>
	<div class="menu" style="display: none">
		<ul>
			<li><a href="<?php echo base_url() ?>consulta/trabajador/informe_eval">Informe de Evalua</a></li>
			<li><a href="<?php echo base_url() ?>consulta/trabajador/perfil">Perfil de Trabajador</a></li>
		</ul>
		<h3>Historial</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>consulta/trabajador/trabajos">De Trabajos</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>-->
<!--
<li class="nav link"><a href="<?php echo base_url() ?>consulta/requerimiento/" class="item">Requerimiento</a>
	<div class="menu" style="display: none">
		<h3>Buscar</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>consulta/requerimiento/estado">Faena</a></li>
			<li><a href="<?php echo base_url() ?>consulta/requerimiento/grupo">Grupo</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>-->
<!---
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
-->
<li class="nav link right"><a href="#" class="item">Perfil</a>
	<div class="menu right" style="display: none">
		<div class="img_aux"></div>
		<div class="img_perfil"><img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="imagen de perfil" /></div>
		<hr class="hr" />
		<h3>Preferencias</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>login/salir">Cerrar Sesión</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>