$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
	  fecha_seleccionada = $(this).val();
	  tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
	  location.href=base_url+"transportes/resumen/resumen_produccion/"+fecha_seleccionada+"/"+tipo_listado;
	});

	$(".todos").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
	    location.href=base_url+"transportes/resumen/resumen_produccion/"+fecha+"/"+tipo_listado;
 	});
 	$(".sindicato").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
	    location.href=base_url+"transportes/resumen/resumen_produccion/"+fecha+"/"+tipo_listado;
 	});
 	$(".convenio").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
	    location.href=base_url+"transportes/resumen/resumen_produccion/"+fecha+"/"+tipo_listado;
	});
});