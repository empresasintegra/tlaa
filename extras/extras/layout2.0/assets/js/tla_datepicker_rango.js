$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
	  fecha_seleccionada = $(this).val();
	  fecha_termino = ($('input:text[name=datepicker2]').val());
	  location.href=base_url+"transportes/bonos_trabajador/calcular/"+fecha_seleccionada+"/"+fecha_termino;
	});
});