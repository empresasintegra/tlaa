$(document).ready(function(){
	FormWizard.init();
	$('.date-picker').datepicker();

	function onFinishCallback(){
        $('#wizard').smartWizard('showMessage','Finish Clicked');
    } 

	// LLENAR LAS AREAS Y CARGOS AL CARGAR LA PAGINA
	$.getJSON( base_url+"est/requerimiento/j_areas", function( data ) {
		$('.search-select-areas').select2({
			placeholder: "Seleccione un area",
		 	data: data,
		 	allowClear: true
		});
	});

	$.getJSON( base_url+"est/requerimiento/j_cargos", function( data ) {
		$('.search-select-cargos').select2({
			placeholder: "Seleccione un area",
		 	data: data,
		 	allowClear: true
		});
	});

	$("input[name='todos_areas']").on('click', function(){
		if($(this).is(':checked')) {  
			$("input[name='areas[]']").prop('checked', true);
		}
		else{
			$("input[name='areas[]']").prop('checked', false);
		}
	});

	$("input[name='todos_cargos']").on('click', function(){
		if($(this).is(':checked')) {  
			$("input[name='cargos[]']").prop('checked', true);
		}
		else{
			$("input[name='cargos[]']").prop('checked', false);
		}
	});

	// FIN LLENADO

	$("#agregar").on('click',function(e){
		// LLENAR LAS AREAS Y CARGOS  CUANDO PINCHE EN AGREGAR MAS AREAS Y CARGOS
		e.preventDefault();
		a = "<div class=\"form-group\" id=\"copia\" ><label class=\"col-sm-3 control-label\">Area - Cargo - N <span class=\"symbol required\"></span></label>";
		a += "<div class=\"col-sm-7\"><div class=\"row\"><div class=\"col-sm-5\"><input type=\"hidden\" name=\"select_area[]\" class=\"form-control search-select-areas2\" >";
		a += "</div><div class=\"col-sm-4\"><input type=\"hidden\" name=\"select_cargo[]\" class=\"form-control search-select-cargos2\" ></div>";
		a += "<div class=\"col-sm-2\"><input type=\"number\" min=\"1\" class=\"form-control\" name=\"personas[]\" placeholder=\"personas\"></div>";
		a += "<div class=\"col-sm-1\"></div></div></div></div>";

		$(".btns").before(a);
		$.getJSON( base_url+"est/requerimiento/j_areas", function( data ) {
			$('.search-select-areas2').select2({
				placeholder: "Seleccione un area",
			 	data: data,
			 	allowClear: true
			});
		});

		$.getJSON( base_url+"est/requerimiento/j_cargos", function( data ) {
			$('.search-select-cargos2').select2({
				placeholder: "Seleccione un area",
			 	data: data,
			 	allowClear: true
			});
		});
	});
	$(".finish-step").on('click', function(){
		alert("");
	});
});