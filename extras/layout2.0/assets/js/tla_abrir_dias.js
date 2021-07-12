$(document).ready(function() {
	$("#abrir_dias").click(function() { 
		fecha_seleccionada = $('input[name=fecha_seleccionada]').val();
		fecha_inicio = $('input[name=fecha_inicio]').val();
		fecha_termino = $('input[name=fecha_termino]').val();		
		location.href=base_url+"transportes/cierres/abrir_dias_cerrados/"+fecha_seleccionada+"/"+fecha_inicio+"/"+fecha_termino;
	});
});