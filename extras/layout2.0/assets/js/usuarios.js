$(document).ready(function(){
	$("#rut").focusout(function(){
		rut = $(this).val();

		var posting = $.post( base_url + "usuarios/perfil/rut_existe",{rut : rut});
 


	 	$("#rut").Rut({
		   format_on: 'keyup',
		   on_error: function(){ 
		   	toastr.error('El rut ingresado es incorrecto');
		   	$("button[type='submit']").attr('disabled', true); 
		   }
		}); 
        // Put the results in a div
        posting.done(function( data ) {

            if(data == 'no'){
            	toastr.success("El rut esta disponible");
            	$("button[type='submit']").attr('disabled', false);
            }
            if(data == 'si'){
            	toastr.error("El rut ya se encuentra en el sistema");
            	$("button[type='submit']").attr('disabled', true);
            }
            if(data == 'vacio'){
            	toastr.error("El campo esta vacio!!");
            	$("button[type='submit']").attr('disabled', true);
            }
        });
	});

	

	$("#tipo_usuario").change(function(){
		id_tipo = $(this).val();
		$('#cargo_usuario').find('option').remove();
		$.ajax({
			dataType: "json",
			type: 'post',
			url: base_url + "usuarios/perfil/tipo_usuario",
			data: {id : id_tipo},
			success: function(data){
				$.each(data, function(i, value) {   
				    $('#cargo_usuario')
				        .append($("<option></option>")
				        .attr("value",data[i].id)
				        .text(data[i].desc_tipo_usuarios)); 
				});
			}
		});
	});
});