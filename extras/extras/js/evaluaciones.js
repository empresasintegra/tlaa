$(document).ready(function(){
	$("#editar").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		url = $(this).attr("href");
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar una evaluación");
		else{
			id = radio.val();
			url = url+"/"+id;
			//location.href=url;
			$.extend($.modal.defaults, {
				closeClass: "closeClass",
				closeHTML: "<a href='#'>x</a>"
			});
			$.get(url, function(data) {
				 $.modal(data);
			});
		}
	});
	$("#eliminar").click(function(event){
		event.preventDefault();
		radio =  $('*:radio:checked');
		if( radio.val() == undefined )
			$.msgbox("Debe seleccionar una evaluación");
		else{
			$.msgbox("¿Esta seguro que desea eliminar esta evaluación?<br />",{
				type: "confirm",
				}, function(result){
					if(result){
						$.get(base_url+'administracion/evaluaciones/eliminar_evaluacion/'+radio.val(),function(){
							location.reload();
						});
					}
			});
		}
	});
});
