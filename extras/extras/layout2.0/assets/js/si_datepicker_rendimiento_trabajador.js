$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
	  fecha_seleccionada = $(this).val();
	  rut_usuario = ($('input:text[name=rut_usuario]').val());
	  location.href=base_url+"servicios/informes/rendimiento_trabajadores/"+fecha_seleccionada+"/"+rut_usuario;
	});
	$(".btn_usuario").click( function() {
 		fecha = ($('input:text[name=datepicker]').val());
	  	rut_usuario = ($('input:text[name=rut_usuario]').val());
 		location.href=base_url+"servicios/informes/rendimiento_trabajadores/"+fecha+"/"+rut_usuario;
 	});
});