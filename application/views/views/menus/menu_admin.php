<li class="nav link"><a href="<?php echo  base_url()?>administracion" class="item">Inicio</a></li>
<li class="nav link"><a href="#" class="item">Usuarios</a>
	<div class="menu left" style="display: none">
		<h3>Usuarios del sistema</h3>
		<ul>
			<li><a class="sub-item" href="#">Trabajadores</a>
				<div class="sub-menu" style="display: none">
					<ul>
						<li><a href="<?php echo base_url() ?>administracion/trabajadores/agregar">Agregar</a></li>
						<li><a href="<?php echo base_url() ?>administracion/trabajadores/subir_archivo">Subir archivo</a></li>
						<li><a href="<?php echo base_url() ?>administracion/trabajadores/buscar">Buscar</a></li>
<!--						<li><a href="<?php echo base_url() ?>administracion/trabajadores/buscar_nuevo">Buscar</a></li> -->
<!-- 						<li><a href="<?php echo base_url() ?>administracion/trabajadores/evaluar">Evaluar</a></li> -->
						<li><a href="#">Evaluar</a></li>
					</ul>
					<span class="menu-left"></span>
				</div>
			</li>
			<li><a class="sub-item" href="#">Usuario mandante</a>
				<div class="sub-menu" style="display: none">
					<ul>
						<li><a href="<?php echo base_url() ?>administracion/mandantes/agregar">Agregar mandante</a></li>
						<li><a href="#">Agregar subusuario</a></li>
						<li><a href="<?php echo base_url() ?>administracion/mandantes/buscar">Buscar mandante</a></li>
					</ul>
					<span class="menu-left"></span>
				</div>
			</li>
			<li><a class="sub-item" href="#">Internos</a>
				<div class="sub-menu" style="display: none">
					<ul>
						<li><a href="<?php echo base_url() ?>administracion/internos/categorias">Categorias</a></li>
						<li><a href="<?php echo base_url() ?>administracion/internos/agregar">Agregar</a></li>
						<li><a href="<?php echo base_url() ?>administracion/internos/buscar">Buscar</a></li>
					</ul>
					<span class="menu-left"></span>
				</div>
			</li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Administrar Requerimiento</a>
	<div class="menu left" style="display: none">
		<h3>Administraci&oacute;n</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/empresas/buscar">Empresa Mandante</a></li>
			<li><a href="<?php echo base_url() ?>administracion/plantas/buscar">Unidad de Negocio</a></li>
			<li><a href="<?php echo base_url() ?>administracion/areas/buscar">Areas</a></li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/jefe_area">Jefe de Area</a></li>
			<li><a href="<?php echo base_url() ?>administracion/cargos/buscar">Cargos</a></li>
		</ul>
			<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Requerimientos</a>
	<?php if($requerimiento_noleidos > 0){ ?>
	<div class="notify"><?php echo $requerimiento_noleidos+$requerimiento_eliminacion ?></div>
	<?php } ?>
	<div class="menu left" style="display: none">
		<h3>Creaci&oacute;n</h3>
		<ul>
			<li class="sub-item">
				<a href="<?php echo base_url() ?>administracion/trabajadores/listado_grupo">Grupo de Requerimiento</a>
			</li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/agregar">Agregar</a></li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/nuevos">Nuevos</a>
				<?php if($requerimiento_noleidos > 0){ ?>
				<div class="notify lista"><?php echo $requerimiento_noleidos ?></div>
				<?php } ?>
			</li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/busqueda_grupos">Busqueda Grupos</a></li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/representantes_planta">Representantes Plantas</a></li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/activos">Activos</a></li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/historial">Historial</a></li>
			<li><a href="<?php echo base_url() ?>administracion/requerimiento/peticion_eliminacion">Petición de eliminación</a>
				<?php if($requerimiento_eliminacion > 0){ ?>
				<div class="notify lista"><?php echo $requerimiento_eliminacion ?></div>
				<?php } ?>
			</li>
			<li><a href="#">Subir archivo</a></li>
			<li><a href="#">Buscar</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Reportes</a>
	<div class="menu left" style="display: none">
		<h3>Custom Elements</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/reportes/observaciones">Trabajadores con observaciones</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Evaluaciones</a>
	<div class="menu left" style="display: none">
		<h3>evaluaciones</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/evaluaciones/crear">Crear</a></li>
			<li><a href="<?php echo base_url() ?>administracion/evaluaciones/archivo">Subir archivo</a></li>
			<li><a href="<?php echo base_url() ?>administracion/evaluaciones/informe_grupal">Informe Grupal</a></li>
			<li><a class="sub-item" href="#">Listado</a>
				<div class="sub-menu" style="display: none">
					<ul>
						<?php foreach($listado_evaluaciones as $le){ ?>
							<li><a href="<?php echo base_url() ?>administracion/evaluaciones/listado/<?php echo $le->id ?>"><?php echo ucwords(mb_strtolower($le->nombre, 'UTF-8')) ?></a></li>
						<?php } ?>
					</ul>
					<span class="menu-left"></span>
				</div>
			</li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Publicaciones</a>
	<div class="menu left" style="display: none">
		<h3>Publicaciones</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/publicaciones/publicar">Crear publicación</a></li>
		</ul>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/publicaciones/buscar/1">Listado Noticias</a></li>
			<li><a href="<?php echo base_url() ?>administracion/publicaciones/buscar/4">Listado Capacitaciones</a></li>
		</ul>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/ofertas/publicar">Ofertas de Trabajo</a></li>
		</ul>
		<!-- <h3>Avisos</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/avisos/">Publicar</a></li>
		</ul> -->
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Contratos</a>
	<div class="menu left" style="display: none">
		<h3>contrato</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/contratos/agregar_variable">Agregar Variable</a></li>
		</ul>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/contratos/editor_contratos">Texto de Contrato</a></li>
			<li><a href="<?php echo base_url() ?>administracion/contratos/listado">Listado de Contratos</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link"><a href="#" class="item">Configuraciones</a>
	<div class="menu left" style="display: none">
		<h3>Varios</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/profesiones">Profesiones</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/especialidades">Especialidades</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/bancos">Bancos</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/tipos_de_archivos">Tipos de archivos</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/salud">Salud</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/afp">AFP</a></li>
		</ul>
		<h3>Localidades</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/regiones">Regiones</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/provincias">Provincias</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/ciudades">Ciudades</a></li>
		</ul>
		<h3>Trabajador</h3>
		<ul>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/nivel_de_estudios">Nivel de estudios</a></li>
			<li><a href="<?php echo base_url() ?>administracion/configuracion/estados_civiles">Estados civiles</a></li>
			<li><a href="<?php echo base_url() ?>administracion/motivosfalta/listar">Motivos de falta</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>
<li class="nav link right"><a href="#" class="item">Ayuda</a>
	<?php if($mensajes_noleidos > 0){ ?>
	<span class="badge badge-important badge-mensaje"><?php echo $mensajes_noleidos ?></span>
	<?php } ?>
	<div class="menu right" style="display: none">
		<h3>Mensajes internos</h3>
		<ul>
			<li><a class="dialog" href="<?php echo base_url() ?>administracion/mensajes/crear">Crear mensaje</a></li>
			<li><a href="<?php echo base_url() ?>administracion/avisos">Crear aviso</a></li>
			<li><a href="<?php echo base_url() ?>administracion/mensajes/bandeja" style="display: inline;">Revisar mensajes</a>
				<?php if($mensajes_noleidos > 0){ ?>
				<span class="badge badge-important"><?php echo $mensajes_noleidos ?></span>
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
			<li><a href="<?php echo base_url() ?>administracion/perfil">Datos Personales</a></li>
			<hr />
			<li><a href="<?php echo base_url() ?>login/salir">Salir</a></li>
		</ul>
		<span class="menu-top"></span>
	</div>
</li>