$(document).ready(function () {
	
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
	}).on('changeDate', function(ev) {
		fecha_seleccionada = $(this).val();
		location.href=base_url+"transportes/consulta/consulta_por_mes/"+fecha_seleccionada;
	});
});

