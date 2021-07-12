<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/mensajes.js"></script>
<div id="inbox-tabs" class="grid grid_5">
	<ul>
		<li class="current">
			<a href="<?php 
		if($this->session->userdata('tipo') == 1) echo base_url().'mandante/mensajes/bandeja';
		if($this->session->userdata('tipo') == 2) echo base_url().'trabajador/mensajes/bandeja'; 
		if($this->session->userdata('tipo') == 3) echo base_url().'administracion/mensajes/bandeja';
		?>">Bandeja</a>
			<div class="count">
				<?php echo $noleidas ?>
			</div>
		</li>
		<!--<li>
			<a href="#">Contacts</a>
		</li>
		 <li class="divider">
        	<hr>
        </li>

        <li>
            <a href="#">Responder</a>
        </li>	

        <li>
            <a href="#">Eliminar conversación</a>
        </li>	 -->	
	</ul>
</div>
<div class="grid grid_18 prepend_1">
	<h1>Mensajes</h1>
	<table id="inbox-table">
		<tbody>
			<?php if(count($listado_mensajes) > 0){ ?>
			<?php foreach($listado_mensajes as $m ){ ?>
				<?php $visto = "" ?>
				<?php if(( (int)$m->id_usuario_resp == (int)$this->session->userdata("id")) && ((int)$m->visto_resp == 0) ) $visto = "unread"; ?>
				<?php if(( (int)$m->id_usuario_envio == (int)$this->session->userdata("id")) && ((int)$m->visto_envio == 0) ) $visto = "unread"; ?>
				<tr class="<?php echo $visto; ?>">
					<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
					<td class="td_info">
						<?php if($this->Usuarios_model->get($m->id_usuario_envio)->id_tipo_usuarios == 3){ ?>
							<a href="javascript:;">Administrador</a>
							<?php }else{ ?>
							<a target="_blank" href="javascript:;">
							<?php echo $this->Usuarios_model->get($m->id_usuario_envio)->nombres ?>
							</a>
							<?php } ?>
					<br>
					<?php $fecha = new DateTime($m->fecha); ?>
					<?php echo $fecha->format('d-m-Y').'<br/>'. $fecha->format("h:m") ?> </td>
					<td class="td_message" style="width: 502px;">
					<p class="subject">
						<a href="./detalle/<?php echo urlencode(base64_encode($m->id)) ?>"><?php echo $m->asunto ?></a>
					</p>
					<p>
						<?php echo character_limiter(strip_tags($m->texto),100) ?>
					</p></td>
					<td class="td_actions">
					<div class="message_actions">
						<a href="<?php 
						if($this->session->userdata('tipo') == 1) echo base_url().'mandante/mensajes/eliminar_msj/'.urlencode(base64_encode($m->id));
						if($this->session->userdata('tipo') == 2) echo base_url().'trabajador/mensajes/eliminar_msj/'.urlencode(base64_encode($m->id)); 
						if($this->session->userdata('tipo') == 3) echo base_url().'administracion/mensajes/eliminar_msj/'.urlencode(base64_encode($m->id));
						?>" class="delete eliminar_msj">x</a>
					</div></td>
				</tr>
			<?php } ?>
			<?php } ?>
			<!-- <tr class="unread">
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Kiera M.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr class="unread">
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Gabrielle S.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Amy R.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr class="unread">
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Bob J.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Kiera M.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Gabrielle S.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Amy R.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Bob J.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Kiera M.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr>
			<tr>
				<td class="td_avatar"><img src="<?php echo base_url() ?>extras/img/correos/avatar.jpg" class="avatar" alt="Profile Image"></td>
				<td class="td_info"><a href="./contact_profile">Gabrielle S.</a>
				<br>
				2 days ago </td>
				<td class="td_message">
				<p class="subject">
					<a href="./mensaje">Conversation Title</a>
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
				</p></td>
				<td class="td_actions">
				<div class="message_actions">
					<a href="#" class="delete">x</a>
				</div></td>
			</tr> -->
		</tbody>
	</table>
	<?php if( count($listado_mensajes) < 1){ ?>
	<p>No existen mensajes en su bandeja.</p>
	<?php } ?>
	<br>
	<div class="dataTables_paginate paging_full_numbers">
	<!-- 	<span class="previous paginate_button paginate_button_disabled">Anterior</span>
		<span> <span class="paginate_active">1</span> <span class="paginate_button">2</span> <span class="paginate_button">3</span> <span class="paginate_button">4</span> <span class="paginate_button">5</span> </span>
		<span class="next paginate_button">Siguente</span> -->
	</div>
	<!-- .dataTables_paginate -->
</div>