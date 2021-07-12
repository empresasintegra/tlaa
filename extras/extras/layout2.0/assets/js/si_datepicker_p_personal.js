$(document).ready(function () {
  var empresa = ($('input:hidden[name=empresa]').val());
  $('#datepicker').datepicker({
 	format: 'yyyy-mm-dd',
}).on('changeDate', function(ev) {
  fecha_seleccionada = $(this).val();
  location.href=base_url+"servicios/produccion/index/"+empresa+"/"+fecha_seleccionada;
  });
});