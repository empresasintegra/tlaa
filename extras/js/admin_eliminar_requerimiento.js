$(document).ready(function(){
	$("#eliminar").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar un requerimiento");
		}
		else{
			$.msgbox("Recuerde que este requerimiento tiene trabajadores ya asociados.<br>¿Que opcion de eliminar desea?", {
			  type: "confirm",
			  buttons : [
			    {type: "submit", value: "Quitar trabajadores"},
			    {type: "submit", value: "Finalizar trabajadores"},
			    {type: "cancel", value: "Cancelar"}
			  ]
			}, function(result) {
			  if (result) {
			  	if(result == "Quitar trabajadores"){
			  		$.get(base_url+"administracion/requerimiento/eliminar/"+radio.val());
			  	}
			  	if(result == "Finalizar trabajadores"){
			  		$.get(base_url+"administracion/requerimiento/eliminar_req_fin_trab/"+radio.val());
			  	}
			  	location.reload();
			  }
			});
		}
	});
});
