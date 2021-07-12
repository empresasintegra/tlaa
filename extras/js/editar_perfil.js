$(document).ready(function(){
	var jash = window.location.hash;
	$(".tab-nav a").click(function(event){
		event.preventDefault();
		jash = $(this).attr("href");
		$(".tab-nav li").removeClass("current");
		$(this).parent().addClass("current");
		$(".contenido-tab").hide();
		$(".contenido-tab[title="+jash+"]").show();
		location.hash=jash;
	});
	if( jash.length > 0){
		$(".contenido-tab").hide();
		$(".tab-nav li").removeClass("current");
		$(".tab-nav a[href='"+jash+"']").parent().addClass("current");
		$(".contenido-tab[title="+jash+"]").show();
	}
	else{
		$(".contenido-tab").hide();
		$(".contenido-tab[title=#datos-representante]").show();
	}
	
	$("#select_region").change(function(){
		val = $(this).val();
		$.get(base_url+"trabajador/perfil/provincia/"+val,function(data){
		   	$("#select_provincia").html(data);
		});
		$.get(base_url+"trabajador/perfil/ciudad/"+val,function(data){
		   	$("#select_ciudad").html(data);
		});
	});
	$("input[name=rut_usuario]").Rut({
	  on_error: function(){ $.msgbox('Rut incorrecto'); },
	  format_on: 'keyup'
	});
});
