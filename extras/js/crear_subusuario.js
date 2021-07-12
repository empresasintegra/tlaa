$(document).ready(function(){
	$("input[name=rut]").Rut({
	  on_error: function(){ $.msgbox('Rut incorrecto'); },
	  format_on: 'keyup'
	});
});