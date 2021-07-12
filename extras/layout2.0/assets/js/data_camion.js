	$(document).ready(function(){		

		var msg = $('#id_camion').val();

		$.post("transportes/datos/ingreso_vueltas_modal", { "item": id_c },
			function(data){ alert(data.result); }, "json"); 


	});