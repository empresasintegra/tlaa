$(function(){
//	var editor = new wysihtml5.Editor("textarea", {
//	    toolbar:      "toolbar",
//	    stylesheets:  base_url+"extras/js/wysihtml5/stylesheet.css",
//	    parserRules:  wysihtml5ParserRules
//	  });
//	$(".tags a").click(function(event){
//		event.preventDefault();
//		tag = $(this).attr('href');
//		alert(tag);
//		$('body.wysihtml5-editor').html("<b>"+tag+"</b>");
//	});
	$('#editar_contrato').click(function(event){
		event.preventDefault();
		url = $(this).attr('href');
		radio =  $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar un contrato");
		}
		else{
			location.href = url +  radio.val(); 
		}
		
	});
	$('#eliminar_contrato').click(function(event){
		event.preventDefault();
		url = $(this).attr('href');
		radio =  $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar un contrato");
		}
		else{
			
		}
	});
	
	// pagina de listado de contratos.
	$(".listado_contratos").change(function() {
		id = $(this).val();
		id_subreq = $(this).attr('title');
		location.href = base_url + 'administracion/contratos/asignar/'+id_subreq+'/'+id;
	});
	
	$('input[name=all]').click(function(){
		if($(this).is(":checked")){
			$("input[type=checkbox]").attr("checked","checked");
		}
		else{
			$("input[type=checkbox]").removeAttr("checked");
		}
	});
	
	//-------------------- ASIGNACION DE USUARIOS A CONTRATO ------------------
	$("#guardar").click(function(event){
		event.preventDefault();
		check = $('*:checkbox:checked');
		if( check.val() == undefined ){
			$.msgbox("Debe seleccionar al menos un usuario");
		}
		else{
			var datos = $("#form_asignacion_contratos").serialize();
			$.extend($.modal.defaults, {
				closeClass: "closeClass",
				closeHTML: "<a href='#'>x</a>"
			});
			$.ajax({
		         type: "GET",
		         url: base_url+"administracion/contratos/guardar_sueldo",
		         data: datos,
		         success: function(msg){
		            alert(  msg );
		            $("#modal_contratos").modal();
		            $("#modal_content p").html(msg);
		         },
		         error: function(obj,msg){
		        	 //modal_contrato
		        	 alert("Error: " + msg);
		            //$("#modal_contratos").modal();
		         }
		      });
		}
	});
});