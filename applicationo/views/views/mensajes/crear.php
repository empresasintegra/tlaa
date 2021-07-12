<div>
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Crear nuevo mensaje</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor escriba un nuevo mensaje.
			</p>
			<?php $url_actual = current_url(); ?>
			<?php if($this->session->userdata('tipo') == 1) $accion = base_url()."/mandante/mensajes/guardar/"; ?>
			<?php if($this->session->userdata('tipo') == 2) $accion = base_url()."/trabajador/mensajes/guardar/"; ?>
			<?php if($this->session->userdata('tipo') == 3) $accion = base_url()."/administracion/mensajes/guardar/"; ?>
			<?php if($this->session->userdata('tipo') == 6) $accion = base_url()."/subusuario/mensajes/guardar/"; ?>
			<form autocomplete="off" action="<?php echo $accion ?>" method="post" class="form">
				<?php if(!$disable){ ?>
				<script>
					function lookup(inputString) {
					if(inputString.length == 0) {
							// Hide the suggestion box.
							$('#suggestions').hide();
						} else {
							$.post(base_url+"usuarios/lista_usuarios", {queryString: ""+inputString+""}, function(data){
								if(data.length >0) {
									$('#autoSuggestionsList').show();
									$('#autoSuggestionsList').html(data);
								}
							});
						}
					} // lookup
					function fill(thisValue,thisId) {
						$('#autocompletar').val(thisValue);
						setTimeout("$('#autoSuggestionsList').hide();", 200);
						$(".id_usuario").val(thisId);
					}
				</script>
				<div class="field">
					<label for="email">Para</label>
					<div class="fields">
						<input id="autocompletar" type="text" name="para" size="30" autocomplete='off' onkeyup="lookup(this.value);" onblur="fill();" >
						<input type="hidden" name="id_usuario" class="id_usuario" />
						<div style="display: none" class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
					</div>
				</div>
				<?php } ?>
				<?php if($disable){ ?>
				<div class="field">
					<label for="email">Para</label>
					<div class="fields">
						<input type="text" value="Administrador" name="para_admin" readonly="true" size="30" />
					</div>
				</div>
				<?php } ?>
				<div class="field">
					<label for="email">Asunto</label>
					<div class="fields">
						<input type="text" name="asunto" size="30">
						<input type="hidden" name="url" value="<?php $url_actual; ?>" />
					</div>
				</div>
				<div class="field">
					<label for="email">Mensaje</label>
					<div class="fields">
						<textarea name="mensaje" cols="30" rows="8"></textarea>
					</div>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary" tabindex="1">
						Enviar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>