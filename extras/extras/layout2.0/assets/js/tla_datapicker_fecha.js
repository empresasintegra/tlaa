$(document).ready(function() {
	$("#calcula_boton").click(function() { 
		fecha_desde = $('input[name=fecha_desde]').val();		
		location.href=base_url+"transportes/reportes/reporte_cliente/"+fecha_desde;
	});
});

$(document).ready(function() {
	$("#calcula_boton_cajas").click(function() { 
		fecha_desde = $('input[name=fecha_desde]').val();		
		location.href=base_url+"transportes/reportes/reporte_cajas/"+fecha_desde;
	});
});