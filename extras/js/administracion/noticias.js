$(document).ready(function(){
	$(".eliminar-noticia").click(function(event){
		event.preventDefault();
		a = $(this);
		$.msgbox("¿Esta seguro que desea eliminar esta publicación?", {
		  type: "confirm",
		  buttons : [
		    {type: "submit", value: "Si"},
		    {type: "cancel", value: "No"}
		  ]
		}, function(result) {
			if(result)
		  		location.href = a.attr('href');
		});
	});
	
	$('#tipo').change(function(){
		valor = $(this).val();
		href = base_url+"administracion/publicaciones/buscar/"+valor;
		location.href = href;
	});
});
