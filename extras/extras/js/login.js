$(document).ready(function(){
	$('input[placeholder], textarea[placeholder]').placeholder();
	$("#perdio_pass").click(function(event){
		event.preventDefault();
		$("form").addClass("ant");
		$(".login_fields.ingresar").animate({
		    opacity: 0,
		    height: '0'
		  }, 900, function() {
		  	$(".login_fields.ingresar").hide();
		   	$(".login_fields.recuperar").animate({
				opacity: "show",
				height: '100px'
			}, 1000, function() {
				$(".ant").live("submit",function(event){
					$(this).addClass("prox");
					$(this).removeClass("ant");
					event.preventDefault();
					rut = $("#rut_r").val();
					if(rut.length > 0){
						$(".login_fields.recuperar").animate({
						    opacity: 0,
						    height: '0'
						  }, 900, function() {
					  		$.get(base_url+"login/validar_correo/"+rut,function(data){
								if(data == "si"){
										$(".login_fields.final1").animate({
											opacity: "show",
											height: '70px'
										}, 1000);
								}
								else if(data == "no"){
									$(".login_fields.final2").animate({
										opacity: "show",
										height: '70px'
									}, 1000);
								}
								else{
									$(".login_fields.error").animate({
										opacity: "show",
										height: '70px'
									}, 1000);
								}
								$(".prox").live("submit",function(event){
									event.preventDefault();
//									$(".login_fields.final1,.login_fields.final2,.login_fields.error").animate({
//									    opacity: 0,
//									    height: '0'
//									  }, 900, function() {
//									  	$(".login_fields.final1,.login_fields.final2,.login_fields.error").hide();
//										$(".login_fields.ingresar").animate({
//											opacity: "show",
//											height: '100px'
//										}, 1000,function(){
//											$("form").removeClass("prox");
//											$(".login_fields.ingresar").css({ opacity: 1 });
//											$("form").submit(function(){
//												return true;
//											});
//										});
//									});
									location.reload();
								});
							});
					  });
					}
				});
			});
		});
	});
	
	// CAMBIAR CONTRASEÑA
	
	//VALIDAR QUE LAS CONTRASEÑAS SEAN IGUALES ANTES DE HACER SUBMIT
	$("cambiar_pass").click(function(event){
		event.preventDefault();
		if( $("#pass1").val() != $("#pass2").val() ){
			alert("Las contraseñas no coinciden");
		}
		else{
			return true;
		}
	})	
});
