$(document).ready(function(){
	$("#input_rut").Rut({
	  on_error: function(){ $.msgbox('Rut incorrecto'); },
	  on_success: function(){ 
	  	rut = $("#input_rut").val();
	  	$.ajax({
			async: false,
			type: "GET",
			url: base_url + "/administracion/trabajadores/rut_existe",
			data: 'rut='+rut,
			success: function(dato){
	            if(dato==true){
	            	$.msgbox('El usuario existe en el sistema');
	            }
	        }
		});
	  } ,
	  format_on: 'keyup'
	});
});
