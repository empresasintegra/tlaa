$(document).ready(function(){
	$("#select_region").change(function(){
		id_region =  $(this).val();
		if(id_region != ""){
			$.get(base_url+"administracion/trabajadores/provincia/"+id_region,function(data){
			   	$("#select_provincia").html(data);
			});
			$.get(base_url+"administracion/trabajadores/ciudad/"+id_region,function(data){
			   	$("#select_ciudad").html(data);
			});
		}
		else{
			$("#select_provincia").html("<option value=''>Seleccione una provincia...</option>");
			$("#select_ciudad").html("<option value=''>Seleccione una provincia...</option>");
		}
	});
	
	$("select[name=empresa]").change(function(){
		id_emp = $(this).val();
		if(id_emp != ""){
			$.ajax({
				type: 'GET',
			  	url: base_url + "administracion/plantas/plantas_ajax/"+id_emp,
			  	cache: false,
			  	dataType: "html",
			  	beforeSend: function(){
			  		$("ul.contact_details").html("<li><img src='"+ base_url +"extras/img/loader.gif' alt='cargando...' /></li>");
			  	},
			  	success: function(data){
			    	$("ul.contact_details").html(data);
				}
			});
		}
		else{
			$("ul.contact_details").html("<li>Seleccione una empresa para ver sus plantas/sucursales</li>");
		}
	});
	
	
});
