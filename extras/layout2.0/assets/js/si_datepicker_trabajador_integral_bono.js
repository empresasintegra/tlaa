$(document).ready(function () {
  var empresa = ($('input:hidden[name=empresa_planta]').val());
  var convenio = ($('input:hidden[name=id_convenio]').val());
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
}).on('changeDate', function(ev) {
  fecha_seleccionada = $(this).val();
  location.href=base_url+"servicios/trabajador_integral/bonos_ti/"+empresa+"/"+convenio+"/"+fecha_seleccionada;
  });
	$("#select_convenio").change( function() {
	fecha = ($('input:text[name=datepicker]').val());
	empresa = ($('input:hidden[name=empresa_planta]').val());
	convenio = ($('input:hidden[name=id_convenio]').val());
  	location.href=base_url+"servicios/trabajador_integral/bonos_ti/"+empresa+"/"+convenio+"/"+fecha;
 	});
});