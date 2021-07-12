$(document).ready(function(){
	$("select[name=empresa]").change(function(){
		id_emp = $(this).val();
		if(id_emp != ""){
			$.ajax({
				type: 'GET',
			  	url: base_url + "administracion/grupos/plantas_ajax/"+id_emp,
			  	cache: false,
			  	dataType: "json",
			  	success: function(data){
			  		$("#select_planta").html("<option value=''>Seleccione...</option>");
			  		$.each(data,function(i,item){
			  			$("#select_planta").append("<option value="+data[i].id+">"+data[i].nombre+"</option>");
			  		});
			    	
				}
			});
		}
	});
	
	
});
