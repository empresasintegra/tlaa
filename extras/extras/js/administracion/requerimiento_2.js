$(document).ready(function(){
	$.tools.dateinput.localize("es",  {
	   months:        'enero,febrero,marzo,abril,mayo,junio,julio,agosto,' +
	                   	'septiembre,octubre,noviembre,diciembre',
	   shortMonths:   'ene,feb,mar,abr,may,jun,jul,ago,sep,oct,nov,dic',
	   days:          'domingo,lunes,martes,miercles,jueves,viernes,sabado',
	   shortDays:     'dom,lun,mar,mie,jue,vie,sab'
	});
	$(".input_fecha").dateinput({
		lang: 'es',
		format: 'dd-mm-yyyy'
	});
	
	$("#select_empresa").change(function(){
		salida = $(this).val();
		if( salida != ""){
			$.ajax({
				type: "POST",
				dataType: "json",
		        url: base_url + "administracion/requerimiento/obtener_planta_ajax",
		        data: "id="+salida,
		        success: function(datos){
		       		//alert( "Se guardaron los datos: " + datos);
		       		$("#select_planta").html('<option value="">Seleccione...</option>');
		       		$("#select_area").html('<option value="">Seleccione...</option>');
		        	$("#select_cargo").html('<option value="">Seleccione...</option>');
		        	$("#select_grupo").html('<option value="">Seleccione...</option>');
		       		$.each(datos.plantas, function(i, item){
		       			$("#select_planta").append('<option value="' + datos.plantas[i].id+ '">' +datos.plantas[i].nombre + '</option>');
		       		});
		       		$.each(datos.areas, function(i, item){ //areas
		       			$("#select_area").append('<option value="' + datos.areas[i].id+ '">' +datos.areas[i].nombre + '</option>');
		       		});
		       		$.each(datos.cargos, function(i, item){ //cargos
		       			$("#select_cargo").append('<option value="' + datos.cargos[i].id+ '">' +datos.cargos[i].nombre + '</option>');
		       		});
		       		$.each(datos.grupos, function(i, item){ //cargos
		       			$("#select_grupo").append('<option value="' + datos.grupos[i].id+ '">' +datos.grupos[i].nombre + '</option>');
		       		});
		      	}
			});
		}
	});
	$("#select_planta").change(function(){
		salida = $(this).val();
		alert(salida);
		if( salida != ""){
			$.ajax({
				type: "POST",
				dataType: "json",
		        url: base_url + "/administracion/requerimiento/resto_planta_ajax",
		        data: "id="+salida,
		        error: function(objeto, quepaso, otroobj){
		            alert("Pasó lo siguiente: "+quepaso+" :"+objeto);
		        },
		        success: function(datos){
		        	$("#select_grupo").html('<option value="">Seleccione...</option>');
		        	$.each(datos.grupo, function(i, item){ //areas
		       			$("#select_grupo").append('<option value="' + datos.grupo[i].id+ '">' +datos.grupo[i].nombre + '</option>');
		       		});
		       		
		       		/*$("#select_planta").html('<option value="">Seleccione...</option>');
		       		$.each(datos, function(i, item){
		       			$("#select_planta").append('<option value="' + datos[i].id+ '">' +datos[i].nombre + '</option>');
		       		});*/
		      	}
			});
		}
	});
});