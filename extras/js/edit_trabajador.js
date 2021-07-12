$(document).ready(function(){
	// cambiar cajas con "tags"
	//idiomas
	$(".tags_addTag.idioma input").click(function(){
		$(this).val("");
	});
	$(".tags_addTag.software input").click(function(){
		$(this).val("");
	});
	$(".tags_addTag.equipos input").click(function(){
		$(this).val("");
	});
	$(".tags_addTag.cursos input").click(function(){
		$(this).val("");
	});
	text_tags_idioma = $(".tags_addTag.idioma").parent().children("textarea").text();
	text_tags_software = $(".tags_addTag.software").parent().children("textarea").text();
	text_tags_equipos = $(".tags_addTag.equipos").parent().children("textarea").text();
	text_tags_cursos = $(".tags_addTag.cursos").parent().children("textarea").text();
	//alert(text_tags);
	
	$(".tags_addTag.idioma").parent().click(function(){
		$(".tags_tag",this).focus();
	});
	$(".tags_addTag.software").parent().click(function(){
		$(".tags_tag",this).focus();
	});
	$(".tags_addTag.equipos").parent().click(function(){
		$(".tags_tag",this).focus();
	});
	$(".tags_addTag.cursos").parent().click(function(){
		$(".tags_tag",this).focus();
	});
	$(".tags_addTag.idioma input").keypress(function(event) {
		if ( event.which == 13 || event.which == 59 ) {
			event.preventDefault();
			if($(this).val().length > 1){
				caja = "<span class='tag'><span>"+$(".tags_addTag.idioma input").val()+"&nbsp;&nbsp;</span><a href='#' title='Eliminar tag'>x</a></span>";
				text_tags_idioma += $(".tags_addTag.idioma input").val()+";"
				$(this).parent().parent().children("textarea").text(text_tags_idioma);
				$(".tags_addTag.idioma input").val("");
				$(this).parent().children(".cont-tag").append(caja);
			}
		}
	});
	$(".tags_addTag.software input").keypress(function(event) {
		if ( event.which == 13 || event.which == 59 ) {
			event.preventDefault();
			if($(this).val().length > 1){
				caja = "<span class='tag'><span>"+$(".tags_addTag.software input").val()+"&nbsp;&nbsp;</span><a href='#' title='Eliminar tag'>x</a></span>";
				text_tags_software += $(".tags_addTag.software input").val()+";"
				$(this).parent().parent().children("textarea").text(text_tags_software);
				$(".tags_addTag.software input").val("");
				$(this).parent().children(".cont-tag").append(caja);
			}
		}
	});
	$(".tags_addTag.equipos input").keypress(function(event) {
		if ( event.which == 13 || event.which == 59 ) {
			event.preventDefault();
			if($(this).val().length > 1){
				caja = "<span class='tag'><span>"+$(".tags_addTag.equipos input").val()+"&nbsp;&nbsp;</span><a href='#' title='Eliminar tag'>x</a></span>";
				text_tags_equipos += $(".tags_addTag.equipos input").val()+";"
				$(this).parent().parent().children("textarea").text(text_tags_equipos);
				$(".tags_addTag.equipos input").val("");
				$(this).parent().children(".cont-tag").append(caja);
			}
		}
	});
	$(".tags_addTag.cursos input").keypress(function(event) {
		if ( event.which == 13 || event.which == 59 ) {
			event.preventDefault();
			if($(this).val().length > 1){
				caja = "<span class='tag'><span>"+$(".tags_addTag.cursos input").val()+"&nbsp;&nbsp;</span><a href='#' title='Eliminar tag'>x</a></span>";
				text_tags_cursos += $(".tags_addTag.cursos input").val()+";"
				$(this).parent().parent().children("textarea").text(text_tags_cursos);
				$(".tags_addTag.cursos input").val("");
				$(this).parent().children(".cont-tag").append(caja);
			}
		}
	});
	
	$(".tags_addTag.idioma .tag a").live("click",function(event){
		event.preventDefault();
		texto_interno = $(this).parents('.tagsinput').find("textarea").val();
		texto_interno = $.trim(texto_interno);
		text = texto_interno.split(";");
		cont = $(this).parent().find("span").text();
		cont = $.trim(cont);
		for(i=0;i < text.length; i++){
			if(cont == text[i]){
				text.splice(i,1);
			}
		}
		
		for(a=0;a < (text.length - 1); a++){
			//alert("valor de a = "+ text[a]);
			if (typeof textarea == "undefined")
				textarea = text[a]+";";
			else
				textarea = textarea + text[a] + ";";
		}
		if( (text.length - 1) < 1){
			textarea = "";
		}
		text_tags_idioma = textarea;
		//alert(textarea);
		$(this).parents('.tagsinput').find("textarea").text(textarea);
		$(this).parent().remove();
		delete window.textarea;
	});
	$(".tags_addTag.software .tag a").live("click",function(event){
		event.preventDefault();
		texto_interno = $(this).parents('.tagsinput').find("textarea").val();
		text = texto_interno.split(";");
		cont = $(this).parent().find("span").text();
		cont = $.trim(cont);
		for(i=0;i < text.length; i++){
			if(text[i] == cont){
				text.splice(i,1);
			}
		}
		
		for(a=0;a < (text.length - 1); a++){
			//alert("valor de a = "+ text[a]);
			if (typeof textarea == "undefined")
				textarea = text[a]+";";
			else
				textarea = textarea + text[a] + ";";
		}
		if( (text.length - 1) < 1){
			textarea = "";
		}
		//alert(textarea);
		text_tags_software = textarea;
		$(this).parents('.tagsinput').find("textarea").text(textarea);
		$(this).parent().remove();
		delete window.textarea;
	});
	$(".tags_addTag.equipos .tag a").live("click",function(event){
		event.preventDefault();
		texto_interno = $(this).parents('.tagsinput').find("textarea").val();
		text = texto_interno.split(";");
		cont = $(this).parent().find("span").text();
		cont = $.trim(cont);
		for(i=0;i < text.length; i++){
			if(text[i] == cont){
				text.splice(i,1);
			}
		}
		
		for(a=0;a < (text.length - 1); a++){
			//alert("valor de a = "+ text[a]);
			if (typeof textarea == "undefined")
				textarea = text[a]+";";
			else
				textarea = textarea + text[a] + ";";
		}
		if( (text.length - 1) < 1){
			textarea = "";
		}
		//alert(textarea);
		text_tags_equipos = textarea;
		$(this).parents('.tagsinput').find("textarea").text(textarea);
		$(this).parent().remove();
		delete window.textarea;
	});
	$(".tags_addTag.cursos .tag a").live("click",function(event){
		event.preventDefault();
		texto_interno = $(this).parents('.tagsinput').find("textarea").val();
		text = texto_interno.split(";");
		cont = $(this).parent().find("span").text();
		cont = $.trim(cont);
		for(i=0;i < text.length; i++){
			if(text[i] == cont){
				text.splice(i,1);
			}
		}
		
		for(a=0;a < (text.length - 1); a++){
			//alert("valor de a = "+ text[a]);
			if (typeof textarea == "undefined")
				textarea = text[a]+";";
			else
				textarea = textarea + text[a] + ";";
		}
		if( (text.length - 1) < 1){
			textarea = "";
		}
		//alert(textarea);
		text_tags_cursos = textarea;
		$(this).parents('.tagsinput').find("textarea").text(textarea);
		$(this).parent().remove();
		delete window.textarea;
	});
	
	
	//cambiar afp
	$("#select_afp").change(function(){
		if( $(this).val() == 6 )
			$(".excajas").fadeIn("slow");
		else
			$(".excajas").fadeOut("slow");
	});
});
