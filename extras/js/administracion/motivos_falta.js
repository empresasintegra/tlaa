$(document).ready(function(){
	$('#eliminar').click(function(event){
		event.preventDefault();
		url = $(this).attr('href');
		$.msgbox("¿En realidad desea eliminar este motivo?", {
			  type: "confirm",
			  buttons : [
			    {type: "submit", value: "Eliminar"},
			    {type: "cancel", value: "Cancelar"}
			  ]
			}, function(result) {
				if(result == "Eliminar")
					location.href= url;
			});
	});
});