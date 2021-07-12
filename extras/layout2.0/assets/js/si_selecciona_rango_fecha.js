$(document).ready(function() {
	$("#calcula_boton").click(function() { 
		fecha_desde = $('input[name=fecha_desde]').val();		
		location.href=base_url+"transportes/informes/generar_informe_asistencia/"+fecha_desde;
	});
});