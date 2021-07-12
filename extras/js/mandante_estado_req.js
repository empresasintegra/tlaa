$(document).ready(function(){
	//eliminar requerimiento
	$("#eliminar_req").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			$.msgbox("¿Esta seguro que desea eliminar este requerimiento?", {
			  type: "confirm"
			}, function(result) {
			  if (result) {
			  	$.getJSON(base_url+"mandante/requerimiento/ajax_eliminar/"+radio.val(), function(data) {
			  		if(data){ //entra si el requerimiento ya tiene trabajadores asignados
			  			msg = "Este requerimiento ya tiene asignado trabajadores<br/><u>detalle subrequerimiento</u>:<br/>";
			  			$.each(data, function(i,item){
					    	msg += "<b>Especialidad:</b> "+item.especialidad+". <b>Asignados:</b> "+item.cantidad+"<br/>";
					    });
					    msg += "¿De todas maneras desea eliminar?";
					    $.msgbox(msg,{
					    	type: "confirm"
					    },function(result){
					    	if(result){
					    		$.get(base_url+"mandante/requerimiento/ajax_validar_eliminacion/"+radio.val(),function($data){
					    			if(data)
					    				$.msgbox("Ya se ha enviado una petición de eliminación para este requerimiento");
					    			else{
					    				$.get(base_url+"mandante/requerimiento/ajax_peticion_eliminacion/"+radio.val());
					    				$.msgbox("Este requerimiento no se puede eliminar, por contener trabajadores asociados.<br/>Se enviará una notificación a administración para eliminación");
					    			}
					    		});
					    	}
					    });
			  		}
			  		else{//entra si el requerimiento no tiene trabajadores asignados
			  			$.get(base_url+"mandante/requerimiento/ajax_eliminar_sin_trab/"+radio.val(),function(data){
			  				location.href = base_url+"mandante/requerimiento/estado/eliminado";
			  			});
			  		}
				});
			  }
			});
		}
	});
	$("#editar_req").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			$.getJSON(base_url+"mandante/requerimiento/ajax_eliminar/"+radio.val(), function(data) {
				if(data){
					msg = "Este requerimiento ya tiene asignado trabajadores<br/><u>detalle subrequerimiento</u>:<br/>";
		  			$.each(data, function(i,item){
				    	msg += "<b>Especialidad:</b> "+item.especialidad+". <b>Asignados:</b> "+item.cantidad+"<br/>";
				    });
				    msg += "Favor comuniquenos en detalle lo que desee editar:<br />";
				    msg += "<textarea id='txt' cols='40' rows='5'></textarea>";
				    $.msgbox(msg,{
					  type: "info",
					  buttons : [
					    {type: "submit", value: "Enviar"},
					    {type: "cancel", value: "No Enviar"}
					  ]
					}, function(result) {
						if(result){ 
							if( $.trim($('#txt').val()) == '' ){
								$.msgbox('No se ha enviado el mensaje, el texto esta vacío');
							}
							else{
								$.post(base_url+"mandante/requerimiento/ajax_peticion_edicion", { msg: $.trim($('#txt').val()), id: radio.val() },
								function(data){
									if(data == 'si')
										$.msgbox("El mensaje se ha enviado perfectamente.");
									else
										$.msgbox("Ha ocurrido un problema, favor enviar nuevamente en un momento.");
								});
							}
						}
					});
				}
				else{
					location.href= base_url+"mandante/requerimiento/editar/"+radio.val();
				}
			});
		}
	});
});
