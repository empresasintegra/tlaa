$(document).ready(function(){
	$(".message_arrow").click(function(){
		 $(this).parents('.message').toggleClass("collapsed");
	});
	
	$(".eliminar_msj").click(function(event){
		event.preventDefault();
		$href = $(this).attr("href");
		$.msgbox("¿Está seguro de que desea eliminar este mensaje?",{
	    	type: "confirm"
	    },function(result){
	    	if(result) location.href = $href;
	    });
	});
	
});
