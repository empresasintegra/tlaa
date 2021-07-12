$(document).ready(function(){
	$('#rut').Rut({
		on_error: function(){ alert('Rut incorrecto'); }
	});
});