$(document).ready(function () {
  var empresa = ($('input:hidden[name=empresa_planta]').val());
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
}).on('changeDate', function(ev) {
  fecha_seleccionada = $(this).val();
  location.href=base_url+"servicios/produccion/merma/"+empresa+"/"+fecha_seleccionada;
  });
});