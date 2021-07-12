$(document).ready(function(){
	$('#rut').Rut({
		on_error: function(){ alert('Rut incorrecto'); }
	});
	$('#rut').Rut({
		on_success: function(){
			rut=$('#rut').val();
			console.log (rut);
		$.ajax({
            type: "POST",
            url: base_url+"transportes/trabajador/consulta_trabajador/"+rut,
            data: {rut: rut},
            dataType: "json",                    
            success: function(data) {
                      if (data == true){
                         
                      	alert ('el rut ya esta registrado');
                      	$('#boton').attr("disabled", true);
            }else{
                 $('#boton').attr("disabled", false);

            } }
        });

		 }
	});
});