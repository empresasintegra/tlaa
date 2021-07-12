$(document).ready(function(){
	$("#textarea").cleditor(); //activar editor de texto
	
	$("select[name=select_publicaciones]").change(function(){
		valor = $(this).val();
		
		if( valor == 1){
			$("input[type = file]").attr('disabled', false);
			$("#select_cat").fadeIn('slow');
			$("#select_usuarios").fadeIn('slow');
			$("#envio_mail").fadeIn('slow');
			$("input[name=titulo]").attr('disabled', false);
			$("#select_req").fadeOut('slow');
			$("#select_area").fadeOut('slow');
		}
		else if( valor == 2){
			$("input[name=titulo]").attr('disabled', true);
			$("input[type=file]").attr('disabled', true);
			$("#select_cat").fadeOut('slow');
			$("#select_usuarios").fadeOut('slow');
			$("#select_req").fadeOut('slow');
			$("#select_area").fadeOut('slow');
		}
		else if( valor == 3){
			$("input[name=titulo]").attr('disabled', false);
			$("input[type=file]").attr('disabled', false);
			$("#select_cat").fadeOut('slow');
			$("#select_usuarios").fadeOut('slow');
			$("#envio_mail").fadeOut('slow');
			$("#select_req").fadeIn('slow');
			$("#select_area").fadeIn('slow');
		}
		else if( valor == 4){
			$("input[type = file]").attr('disabled', false);
			$("#select_usuarios").fadeIn('slow');
			$("#envio_mail").fadeIn('slow');
			$("input[name=titulo]").attr('disabled', false);
			$("#select_cat").fadeOut('slow');
			$("#select_req").fadeOut('slow');
			$("#select_area").fadeOut('slow');
		}
		
	});
	
	$("select[name=select_req]").change(function(){
		id_req = $(this).val();
		$.ajax({
			type: "POST",
			 url: base_url+"administracion/publicaciones/ajax_area",
			 async:false,
			 data: "area="+id_req,
			 beforeSend: function(objeto){
	            $("select[name=select_area]").html('<option>Cargando datos...</option>');
	        },
	        success: function(datos){
	           $("select[name=select_area]").html(datos);
	        },
        });
	});

	$('.eliminar_categoria').click(function(event){
		event.preventDefault();
		url = $(this).attr('href');
		$.msgbox("¿Esta seguro que desea eliminar esta categoría?", {
		  type: "confirm",
		  buttons : [
		    {type: "submit", value: "Yes"},
		    {type: "cancel", value: "No"}
		  ]
		}, function(result) {
		 	if(result){
		 		location.href = url;
		 	}
		});
	});
	
});
