$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
	  fecha_seleccionada = $(this).val();
	  empresa = ($('input:hidden[name=empresa_planta]').val());
	  location.href=base_url+"servicios/informes/cierre_mes/"+empresa+"/"+fecha_seleccionada;
	});

	$(".planta1").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		location.href=base_url+"servicios/informes/cierre_mes/"+empresa+"/"+fecha;
 	});
 	$(".planta2").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		location.href=base_url+"servicios/informes/cierre_mes/"+empresa+"/"+fecha;
 	});
 	$(".planta3").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		location.href=base_url+"servicios/informes/cierre_mes/"+empresa+"/"+fecha;
	});
});