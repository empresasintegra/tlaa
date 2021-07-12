$(document).ready(function(){
	$("#ver-trabajadores").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			href = $(this).attr("href");
			location.href= href+'/'+radio.val();
		}
	});
	$("#ver-detalles").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			href = $(this).attr("href");
			location.href= href+'/'+radio.val();
		}
	});
});