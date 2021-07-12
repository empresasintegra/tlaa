$(document).ready(function(){
	$(".eliminar").on('click',function(event){
		event.preventDefault();
		link = $(this).attr('href');;
		bootbox.confirm("El trabajador que esta eliminando quedara ausente. Desea continuar?", function(result) {
			if(result){
				window.location=link;
			}
		}); 
	});
});
 