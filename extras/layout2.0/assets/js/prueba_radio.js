$(function(){
	$('input:radio').change(
		function(){
			//alert($("input[name='prueba']:checked").val())
			if($("input[name='prueba']:checked").val() == 1){
            	var resultado = 1;
				$.ajax({
					type: "POST",
					url:base_url+"transportes/datos/cargar_solo_choferes/"+resultado,
					contentType: "application/x-www-form-urlencoded",
					dataType: "json",
					success: function(data){ 
						alert('chofer');
					}
				});
			}
			if($("input[name='prueba']:checked").val() == 2){
				var id_cargo = $("input[name='prueba']:checked").val();
				/*var codigo = $('#codigo').val();
				$.ajax({
					type: "POST",
					url:base_url+"servicios/produccion/buscar_detalles_producto/"+id_planta+"/"+codigo,
					contentType: "application/x-www-form-urlencoded",
					dataType: "json",
					success: function(data){ 
						$("#articulo").val(data['articulo']);
						$("#descripcion").val(data['descripcion']);
						$("#tamano").val(data['tamano']);
						$("#producto_id").val(data['producto_id']);
						$("#tipo_producto").val(data['nombre_tipo_producto']);
					}
				});*/
				alert('id_cargo')
			}
		}
		);          

});