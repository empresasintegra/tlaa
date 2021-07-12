$(document).ready(function(){
	$(".check-reemplazo").click(function() {
		$id_usr = $(this).attr('name');
		$id_subreq = $(this).attr('alt');
		//alert($id_subreq);
		if($(this+":checked").length > 1){
	        alert("Recuerde que solo puede seleccionar un reemplazo");
	        return false;
	    }
		else{
			$.ajax({
				 url: base_url+"administracion/requerimiento/agregar_reemplazo/"+$id_usr+'/'+ $id_subreq,
		        async:false,
		        beforeSend: function(objeto){
		        	//alert("Adiós, me voy a ejecutar");
		        },
		        success: function(datos){
		            //alert(datos);
		        }
	        });
			$.ajax({
				 url: base_url+"administracion/requerimiento/session_obtener_usuario_reemplazar/",
		        async:false,
		        beforeSend: function(objeto){
		        	//alert("Adiós, me voy a ejecutar");
		        },
		        success: function(datos){
		            //alert(datos);
		        }
	        });
		}
	});
	
	$("#boton_reemplazo").click(function(){
		asignados_aux = $("#asignados").text();
		asignados = parseInt(asignados_aux);
		por_asignar_aux = $("#por-asignar").text();
		por_asignar = parseInt(por_asignar_aux);
		id_req =  $("input[name=id]").val();
		// if(asignados < 1)
			// $.msgbox("los trabajadores asignados son insuficientes", {type: "error"});
		// else{
			//$.colorbox.close();
		$.ajax({
	        url: base_url+"administracion/requerimiento/ajax_motivo",
	        async:false,
	        dataType: "html",
	        beforeSend: function(objeto){
	            //alert("Adiós, me voy a ejecutar");
	        },
	        success: function(datos){
	            //alert(datos);
	            $.msgbox("Es necesario agregar el motivo.<br/><b>Motivo</b>:&nbsp;<select name='select_motivo'><option value=''>Seleccione...</option>"+datos+"</select><br/><b>Observación</b>:<br/><textarea cols='40' rows='5' name='obs_reemplazo'></textarea>", {
				  type: "info",
				  buttons : [
				    {type: "submit", value: "Agregar"},
				    {type: "cancel", value: "Cancelar"}
				  ]
				}, function(result) {
					if(result == "Agregar"){
						select_motivo = $("select[name=select_motivo]").val();
						obs_reemplazo = $("textarea[name=obs_reemplazo]").val();
						url_obs = escape(obs_reemplazo);
						if( select_motivo == ""){
							alert("Debe seleccionar un motivo");
						}
						else{
							$.get(base_url+"administracion/requerimiento/session_reemplazo_final/"+select_motivo+"/"+url_obs);
							parent.$.fn.colorbox.close();
						}
					}
					if(result == "Cancelar")
						parent.$.fn.colorbox.close();
				});
	        }
		});
			//location.href = base_url+'administracion/requerimiento/guardar_reemplazo/';
		// }
	});
});