$(document).ready(function(){
	var id_empresa = '';
	$("select[name=empresa_select]").change(function(){
		id_emp = $(this).val();
		id_empresa = id_emp;
		if(id_emp != ""){
			$.ajax({
				type: 'GET',
			  	url: base_url + "administracion/mandantes/plantas_ajax/"+id_emp,
			  	cache: false,
			  	dataType: "html",
			  	beforeSend: function(){
			  		$("select[name=planta_select]").html("<option value=''>Espere Cargando...</option>");
			  	},
			  	success: function(data){
			    	$("select[name=planta_select]").html(data);
			    	$('input[name=codigo_ingreso]').val(id_emp);
				}
			});
		}
		else{
			$("ul.contact_details").html("<li>Seleccione una empresa para ver sus plantas/sucursales</li>");
		}
	});
	$("select[name=planta_select]").change(function(){
		id_planta = $(this).val();
		var tot_usr = '';
		$.ajax({
			type: 'GET',
		  	url: base_url + "administracion/mandantes/ajax_revisar_codigo/"+id_planta,
		  	cache: false,
		  	dataType: "html",
		  	async: false,
		  	success: function(data){
		    	tot_usr = data;
			}
		});
		id = id_empresa+'-'+id_planta+'-'+( parseInt(tot_usr) + 1);
		$('input[name=codigo_ingreso]').val(id);
	});
	$(".item-planta").live("click",function(event){
		event.preventDefault();
		$id_planta = $(this).attr("rel");
		
		$.get(base_url + "administracion/mandantes/ajax_datos_planta/"+$id_planta,
		function(data){
			json = $.parseJSON(data);
			$("input[name='nombre_p']").val(json.nombre);
			if(json.fono==null){
				$("input[name='fono_cod']").val("");
				$("input[name='fono_num']").val("");
			}
			else{
				fono = json.fono;
				fono = fono.split("-");
				$("input[name='fono_cod']").val(fono[0]);
				$("input[name='fono_num']").val(fono[1]);
			}
			if(json.fax==null){
				$("input[name='fax_cod']").val("");
				$("input[name='fax_num']").val("");
			}
			else{
				fax = json.fax;
				fax = fono.split("-");
				$("input[name='fax_cod']").val(fax[0]);
				$("input[name='fax_num']").val(fax[1]);
			}
			$("input[name='direccion']").val(json.direccion);
			$("input[name='email_planta']").val(json.email);
			if(json.id_regiones == null){
				$("#select_region option").each(function(index) {
					if($(this).val() == "")
						$(this).attr('selected', 'selected');
				});
				if(json.id_ciudades == null){
					$("#select_ciudad").html("<option value=''>Seleccione una ciudad...</option>");
				}
				if(json.id_provincias == null){
					$("#select_provincia").html("<option value=''>Seleccione una provincia...</option>");
				}
			}
			else{
				$("#select_region option").each(function(index) {
					if($(this).val() == json.id_regiones){
						$(this).attr('selected', 'selected');
						if(json.id_provincias == null){
							$("#select_provincia").html("<option value=''>Seleccione una provincia...</option>");
						}
						else{
							$.get(base_url+"administracion/trabajadores/provincia/"+json.id_regiones,function(data){
							   	$("#select_provincia").html(data);
							   	$("#select_provincia option").each(function(index) {
							   		if($(this).val() == json.id_provincias)
							   			$(this).attr('selected', 'selected');
							   	});
							});
						}
						if(json.id_ciudades == null){
							$("#select_ciudad").html("<option value=''>Seleccione una provincia...</option>");
						}
						else{
							$.get(base_url+"administracion/trabajadores/ciudad/"+json.id_regiones,function(data){
							   	$("#select_ciudad").html(data);
							   	$("#select_ciudad option").each(function(index) {
							   		if($(this).val() == json.id_ciudades)
							   			$(this).attr('selected', 'selected');
							   	});
							});
						}
					}
				});
			}
		});
	});
});
