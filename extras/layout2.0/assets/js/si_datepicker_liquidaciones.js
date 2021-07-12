$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
	  fecha_seleccionada = $(this).val();
	  empresa = ($('input:hidden[name=empresa_planta]').val());
	  estado = ($('input:hidden[name=estado]').val());
	  location.href=base_url+"servicios/liquidaciones/index/"+empresa+"/"+estado+"/"+fecha_seleccionada;
	});

	$(".planta1").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"servicios/liquidaciones/index/"+empresa+"/"+estado+"/"+fecha;
 	});
 	$(".planta2").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"servicios/liquidaciones/index/"+empresa+"/"+estado+"/"+fecha;
 	});
 	$(".planta3").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"servicios/liquidaciones/index/"+empresa+"/"+estado+"/"+fecha;
	});
	$(".estado_activo").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"servicios/liquidaciones/index/"+empresa+"/"+estado+"/"+fecha;
	});
	$(".estado_inactivo").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"servicios/liquidaciones/index/"+empresa+"/"+estado+"/"+fecha;
	});
});