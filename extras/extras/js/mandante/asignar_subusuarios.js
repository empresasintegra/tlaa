$(document).ready(function(){
	var $id_usuario;
	$('*:radio').click(function(){
		$id_usuario = $(this).val();
	});
	
	$("#click_filtro").click(function(event){
		event.preventDefault();
		$("#esconder").toggle('slow');
	});
	$('#asignar_req').click(function(event){
		event.preventDefault();
		if( typeof $id_usuario === 'undefined')
			$.msgbox("Debe seleccionar un requerimiento");
		else{
			url = $(this).attr("href");
			url = url+"/"+$id_usuario;
			document.location.href=url;
		}
	});
	
	
	//ASIGNAR
	$('#req_select').change(function(){
		id_req = $(this).val();
		
	});
});
