$(document).ready(function(){
	text_tags_referencias = "";
	text_tags_funciones = "";
	$(".tags_addTag.referencias input").click(function(){
		$(this).val("");
	});
	$(".tags_addTag.funciones input").click(function(){
		$(this).val("");
	});
	$(".tags_addTag.referencias").parent().click(function(){
		$(".tags_tag",this).focus();
	});
	$(".tags_addTag.funciones").parent().click(function(){
		$(".tags_tag",this).focus();
	});
	$(".tags_addTag.referencias input").keypress(function(event) {
		if ( event.which == 13 ) {
			event.preventDefault();
			if($(this).val().length > 1){
				caja = "<span class='tag'><span>"+$(".tags_addTag.referencias input").val()+"&nbsp;&nbsp;</span><a href='#' title='Eliminar tag'>x</a></span>";
				text_tags_referencias += $(".tags_addTag.referencias input").val()+";"
				$(this).parent().parent().children("textarea").text(text_tags_referencias);
				$(".tags_addTag.referencias input").val("");
				$(this).parent().children(".cont-tag").append(caja);
			}
		}
	});
	$(".tags_addTag.funciones input").keypress(function(event) {
		if ( event.which == 13 ) {
			event.preventDefault();
			if($(this).val().length > 1){
				caja = "<span class='tag'><span>"+$(".tags_addTag.funciones input").val()+"&nbsp;&nbsp;</span><a href='#' title='Eliminar tag'>x</a></span>";
				text_tags_funciones += $(".tags_addTag.funciones input").val()+";"
				$(this).parent().parent().children("textarea").text(text_tags_funciones);
				$(".tags_addTag.funciones input").val("");
				$(this).parent().children(".cont-tag").append(caja);
			}
		}
	});
	$(".tags_addTag.referencias .tag a").live("click",function(event){
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
		text_tags_referencias = textarea;
		//alert(textarea);
		$(this).parents('.tagsinput').find("textarea").text(textarea);
		$(this).parent().remove();
		delete window.textarea;
	});
	$(".tags_addTag.funciones .tag a").live("click",function(event){
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
		text_tags_funciones = textarea;
		//alert(textarea);
		$(this).parents('.tagsinput').find("textarea").text(textarea);
		$(this).parent().remove();
		delete window.textarea;
	});
	$("#help_funciones").live('mouseover', function(event) {
		$(this).qtip({
		   content: {
				text: "<img class='throbber' src='"+ base_url +"/extras/img/throbber.gif' alt='Cargando...' />",
				ajax: {
		               url: base_url+'trabajador/experiencia/tooltip/1' // Use the rel attribute of each element for the url to load
		            },
				title: {
		               text: 'Ayuda Principales Funciones', // Give the tooltip a title using each elements text
		               button: true
		            }
				},
				style: {
		            classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
		         },
		      show: {
					event: event.type, // Use the same show event as the one that triggered the event handler
					ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
				}
		}, event);
	});
	$("#help_referencias").live('mouseover', function(event) {
		$(this).qtip({
		   content: {
				text: "<img class='throbber' src='"+ base_url +"/extras/img/throbber.gif' alt='Cargando...' />",
				ajax: {
		               url: base_url+'trabajador/experiencia/tooltip/2' // Use the rel attribute of each element for the url to load
		            },
				title: {
		               text: 'Ayuda Referencias', // Give the tooltip a title using each elements text
		               button: true
		            }
				},
				style: {
		            classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
		      },
		      show: {
					event: event.type, // Use the same show event as the one that triggered the event handler
					ready: true // Show the tooltip as soon as it's bound, vital so it shows up the first time you hover!
				}
		}, event);
	});
});
