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
		$.get(base_url+"administracion/trabajadores/provincia/"+val,function(data){
		   	$("#select_provincia").html(data);
		});
		$.get(base_url+"administracion/trabajadores/ciudad/"+val,function(data){
		   	$("#select_ciudad").html(data);
		});
	});
	$(".eliminar_archivo").click(function(event){
		event.preventDefault();
		url = $(this).attr("href");
		$.msgbox("¿Esta seguro que desea eliminar este archivo adjunto?", {
			type: "confirm"
		}, function(result) {
			if (result){ location.href = url; }
		  	else return false;
		});
	});
	
	
	/******************** TAGS O CURSOS **********************/
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
	
	//experiencia
	
	$("#editar_exp").click(function(event){
		event.preventDefault();
		radio = $("input[name=radio_experiencia]:checked");
		href = $(this).attr('href'); 
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar una experiencia");
		}
		else{
			$.extend($.modal.defaults, {
				closeClass: "closeClass",
				closeHTML: "<a href='#'>x</a>"
			});
			url = href + '/' + radio.val();
			$.get(url, function(data) {
				 $.modal(data);
				 url_form = $("#form_exp").attr("action");
				 url_form = url_form +'/'+ radio.val();
				 $("#form_exp").attr("action", url_form);
			});
		}
	});
	
	$("#eliminar_exp").click(function(event){
		event.preventDefault();
		radio = $("input[name=radio_experiencia]:checked");
		href = $(this).attr('href');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar una experiencia");
		}
		else{
			$.msgbox("¿Esta seguro que desea eliminar esta experiencia para siempre?", {
			  type: "confirm",
			  buttons : [
			    {type: "submit", value: "Yes"},
			    {type: "cancel", value: "No"},
			  ]
			}, function(result) {
				if(result){
					url = href + '/' + radio.val();
					location.href = url;
				}
			});
		}
	});
	
	$('#form_exp').live('keypress',function(e){   
	    if(e.which == 13){ 
	      return false; 
	    } 
	  });
	  
	text_tags_referencias = "";
	text_tags_funciones = "";
	$(".tags_addTag.referencias input").live('click',function(){
		$(this).val("");
	});
	$(".tags_addTag.funciones input").live('click',function(){
		$(this).val("");
	});

	$(".tags_addTag.referencias input").live('keypress',function(event) {
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
	$(".tags_addTag.funciones input").live('keypress',function(event) {
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
	
	$("#help_funciones").live('click', function(e){
		e.preventDefault();
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
	$("#help_referencias").live('click', function(e){
		e.preventDefault();
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