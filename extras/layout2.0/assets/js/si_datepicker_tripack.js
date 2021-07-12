$(document).ready(function () {
  $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
}).on('changeDate', function(ev) {
  fecha_seleccionada = $(this).val();
  location.href=base_url+"servicios/tripack/index/"+fecha_seleccionada;
  });
});