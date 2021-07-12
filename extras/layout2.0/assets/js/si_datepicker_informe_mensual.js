$(document).ready(function () {
  var empresa = ($('input:hidden[name=empresa_planta]').val());
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
}).on('changeDate', function(ev) {
  fecha_seleccionada = $(this).val();
  estado = ($('input:hidden[name=estado]').val());
  location.href=base_url+"servicios/informes/mensual/"+empresa+"/"+estado+"/"+fecha_seleccionada;
  });
	$(".estado_activo").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
  		location.href=base_url+"servicios/informes/mensual/"+empresa+"/"+estado+"/"+fecha;
	});
	$(".estado_inactivo").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
 		empresa = ($('input:hidden[name=empresa_planta]').val());
 		estado = ($('input:hidden[name=estado]').val());
  		location.href=base_url+"servicios/informes/mensual/"+empresa+"/"+estado+"/"+fecha;
	});
});