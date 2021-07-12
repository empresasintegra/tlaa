$(document).ready(function(){
	$(".eliminar").on('click',function(event){
		event.preventDefault();
		link = $(this).attr('href');;
		bootbox.confirm("Esta seguro que desea eliminar este elemento??", function(result) {
			if(result){
				window.location=link;
			}
		}); 
	});
});
