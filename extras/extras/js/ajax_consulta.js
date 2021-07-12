$(document).ready(function(){

	var id_planta;
	var id_grupo;
	var id_area;

	$("#planta").change(function(){
		id_planta = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + "/consulta/requerimiento/ajax_grupo/"+id_planta,
			dataType: "json",
			success: function(datos){
	            $("#grupo").html("<option value='0'>Todos</option>");
	            $.each(datos,function(i,item){
	            	$("#grupo").append("<option value='"+datos[i].id+"'>"+datos[i].nombre+"</option>");
	            });
	        }
		});
	});
	$("#grupo").change(function(){
		id_grupo = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + "/consulta/requerimiento/ajax_areas/"+id_grupo,
			dataType: "json",
			success: function(datos){
	            $("#area").html("<option value='0'>Todos</option>");
	            $.each(datos,function(i,item){
	            	$("#area").append("<option value='"+datos[i].id+"'>"+datos[i].nombre+"</option>");
	            });
	        }
		});
	});
	$("#area").change(function(){
		id_area = $(this).val();
		$.ajax({
			type: "POST",
			url: base_url + "/consulta/requerimiento/ajax_cargos/"+id_grupo+"/"+id_area,
			dataType: "json",
			success: function(datos){
	            $("#cargo").html("<option value='0'>Todos</option>");
	            $.each(datos,function(i,item){
	            	$("#cargo").append("<option value='"+datos[i].id+"'>"+datos[i].nombre+"</option>");
	            });
	        }
		});
	});
});