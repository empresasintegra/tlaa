$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
	  fecha_seleccionada = $(this).val();
	  vuelta = ($('input:text[name=vuelta_trabajar]').val());
	  location.href=base_url+"transportes/datos/upload/"+fecha_seleccionada+"/"+vuelta;
	});

	$(".vuelta1").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		vuelta = ($('input:hidden[name=vuelta_trabajar]').val());
	    location.href=base_url+"transportes/datos/upload/"+fecha+"/"+vuelta;
 	});
 	$(".vuelta2").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		vuelta = ($('input:hidden[name=vuelta_trabajar]').val());
	    location.href=base_url+"transportes/datos/upload/"+fecha+"/"+vuelta;
 	});
 	$(".vuelta3").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		vuelta = ($('input:hidden[name=vuelta_trabajar]').val());
	    location.href=base_url+"transportes/datos/upload/"+fecha+"/"+vuelta;
	});
	$(".vuelta4").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		vuelta = ($('input:hidden[name=vuelta_trabajar]').val());
	    location.href=base_url+"transportes/datos/upload/"+fecha+"/"+vuelta;
	});
	$(".vuelta5").click( function() {
 		fecha = ($('input:hidden[name=fecha_mostrar]').val());
 		vuelta = ($('input:hidden[name=vuelta_trabajar]').val());
	    location.href=base_url+"transportes/datos/upload/"+fecha+"/"+vuelta;
	});
});