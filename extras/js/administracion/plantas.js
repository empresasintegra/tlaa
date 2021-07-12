$(document).ready(function(){
	var id_planta;
	var url_del = $("#eliminar_planta").attr('href');
	var url_edit = $("#editar_planta").attr('href');
	var volver = $("#eliminar_planta").attr('rel');
	$("input[type=radio]").click(function(){
		id_planta =  $(this).val();
		url_final_del = url_del + '/' + id_planta + '/' + volver;
		url_final_edit = url_edit + '/' + id_planta;
		$("#eliminar_planta").attr('href',url_final_del);
		$("#editar_planta").attr('href',url_final_edit);
	});
	$("#eliminar_planta").click(function(event){
		event.preventDefault();
		link = $(this);
		$.msgbox("¿Desea realmente eliminar esta planta?", {
		  type: "confirm",
		  buttons : [
		    {type: "submit", value: "Si"},
		    {type: "cancel", value: "No"}
		  ]
		}, function(result) {
			if(result){
				$.getJSON( base_url + 'administracion/plantas/ajax_validar_eliminar/'+id_planta , function(result){
					tiene_usuarios = false;
					tiene_requerimientos = false;
					if( result.usuarios.length > 0)
						tiene_usuarios = true;
					if( result.requerimientos.length > 0)
						tiene_requerimientos = true;
					
					if ( tiene_usuarios || tiene_requerimientos ){
						msg = "Esta planta tiene datos existentes.<br />";
						if(tiene_usuarios) msg += "<b>Posee "+result.usuarios.length+" usuarios asignados a esta planta.</b> <br />";
						if(tiene_requerimientos) msg += "<b>Posee "+result.requerimientos.length+" requerimientos asignados a esta planta.</b> <br />";
						if(tiene_requerimientos) msg += "Lamentablemente usted <b>no puede eliminar</b> esta planta, por poseer requerimientos.<br />";
						else msg += "¿Aun está seguro de eliminar esta planta?<br />Recuerde que se eliminaran sus usuarios existentes";
						if(tiene_requerimientos){
							$.msgbox(msg, {
							  type: "confirm",
							  buttons : [
							    {type: "cancel", value: "No"}
							  ]
							});
						}
						else{
							$.msgbox(msg, {
							  type: "confirm",
							  buttons : [
							    {type: "submit", value: "Si"},
							    {type: "cancel", value: "No"}
							  ]
							}, function(result) {
								if(result)
									location.href = link.attr('href') ;
							});
						}
					}
					else
						location.href = link.attr('href') ;
				});
				//location.href = link.attr('href') ;
			}
		});
	});
});
