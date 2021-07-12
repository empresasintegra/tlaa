<script type="text/javascript" src="<?php echo base_url() ?>extras/js/mensajes.js"></script>
<?php $i=0; ?>
<div id="inbox-tabs" class="grid grid_5">
	<ul>
		<li class="current">
			<a href="../">Bandeja</a>
			<div class="count">
				<?php echo $noleidas ?>
			</div>
		</li>
		<!-- <li>
			<a href="#">Contacts</a>
		</li> -->
	</ul>
</div>
<div class="grid grid_18 prepend_1">
	<h1>Re: <?php echo $mensaje->asunto ?></h1>
	<div class="btn-toolbar">
		<a href="#reply_form" class="btn small secondary">Responder el mensaje</a>
		<a href="<?php 
		if($this->session->userdata('tipo') == 1) echo base_url().'mandante/mensajes/eliminar_msj/'.urlencode(base64_encode($mensaje->id));
		if($this->session->userdata('tipo') == 2) echo base_url().'trabajador/mensajes/eliminar_msj/'.urlencode(base64_encode($mensaje->id)); 
		if($this->session->userdata('tipo') == 3) echo base_url().'administracion/mensajes/eliminar_msj/'.urlencode(base64_encode($mensaje->id));
		?>" class="btn small secondary eliminar_msj">Eliminar la conversacion</a>
	</div>
	<div class="clear"></div>
	<ul class="message_threads">
		<li class="message">
			<a href="j#"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" alt="Avatar" class="avatar"></a>
			<div class="message_body">
				<div class="message_text">
					<p class="message_author">
						<a href='javascript:;'><?php echo $de ?></a> comentó:
					</p>
					<p>
						<?php echo nl2br($mensaje->texto) ?>
					</p>
					<p class="message_date">
					<?php $fecha = new DateTime($mensaje->fecha); ?>
					<?php echo $fecha->format('d-m-Y').'@'. $fecha->format("h:m") ?>
					</p>
				</div>
				<div class="message_arrow"></div>
			</div>
		</li>
		<?php foreach($respuestas as $r){ ?>
		<li class="message <?php ($i%2)?"alt":"";$i++;?>">
			<a href="javascript:;"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" alt="Avatar" class="avatar"></a>
			<div class="message_body">
				<div class="message_text">
					<p class="message_author">
						<?php $usr = $this->Usuarios_model->get($r->id_usuarios); ?>
						<?php if($usr->id_tipo_usuarios != 3){ ?>
						<a href='javascript:;'><?php echo $usr->nombres." ".$usr->paterno." ".$usr->materno ?></a> comenta:
						<?php }else{ ?>
							<a href='javascript:;'>Administrador</a> comenta:
						<?php } ?>
					</p>
					<p>
						<?php echo nl2br($r->texto); ?>
					</p>
					<p class="message_date">
					<?php $fecha2 = new DateTime($r->fecha); ?>
					<?php echo $fecha2->format('d-m-Y').'@'. $fecha2->format("h:m")   ?>
					</p>
				</div>
				<div class="message_arrow"></div>
			</div>
		</li>
		<?php } ?>
		<?php if(isset($no_mostrar)){ ?>
		<li class="message aviso">
			<a href="javascript:;"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" alt="Avatar" class="avatar"></a>
			<div class="message_body">
				<div class="message_text">
					<p class="message_author">
							Mensaje administracion:
					</p>
					<p>
						Este mensaje ya obtuvo respuesta del administrador <b><?php echo $admin_resp ?></b>.<br />
						Si desea ver los mensajes o agregar alguna respuesta favor dar <a href="<?php echo base_url() ?>administracion/mensajes/desbloquear/<?php echo $mensaje->id ?>">click aqui</a>
					</p>
				</div>
				<div class="message_arrow"></div>
			</div>
		</li>
		<?php } ?>
	</ul>
	<br>
	<?php if($this->session->userdata('tipo') == 1) $accion = base_url()."/mandante/mensajes/responder/"; ?>
	<?php if($this->session->userdata('tipo') == 2) $accion = base_url()."/trabajador/mensajes/responder/"; ?>
	<?php if($this->session->userdata('tipo') == 3) $accion = base_url()."/administracion/mensajes/responder/"; ?>
	<?php if(!isset($no_mostrar)){ ?>
	<form id="reply_form" action="<?php echo $accion; ?>" method="post" class="form">
		<h3>Responder...</h3>
		<input type="hidden" name="id" value="<?php echo $mensaje->id ?>" />
		<textarea name="note" id="note" placeholder="Ingrese su texto a enviar, aquí..."></textarea>
		<button type="submit" class="btn primary">
			Enviar
		</button>
	</form>
	<?php  } ?>
</div>