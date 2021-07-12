// document.oncontextmenu = function(){return false}
$(document).ready(function(){
	
	$("html").click(function(){
		$(".menu").hide();
		$(".sub-menu").hide();
	});

	$(".nav.link").mouseover(function(){  
		$(".menu").hide();
        $(this).find(".menu").show(); 
    });  
    /*$(".nav.link").mouseout(function(){  
    	$(".menu").hide();
       $(this).find(".menu").hide();
    });*/

   	$(".sub-item").mouseover(function(){  
   		$(".sub-menu").hide();
        $(this).next(".sub-menu").show();
    });  
    /*$(".sub-item").mouseout(function(){  
       $(this).next(".sub-menu").hide();
    });*/

/*
	//menu top - navegacion
	$(".nav.link").on('click',function(event){
		//event.stopPropagation();
		//$(this).unbind("click");
		$(".menu").hide();
		$(this).find(".menu").show();
	});
	$(".sub-item").on('click',function(event){
		//event.stopPropagation();
		$(this).next(".sub-menu").show();
	});
	/***************************************/
	
	//cerrar aviso
	$(".blank_start .cerrar a").click(function(event){
		event.preventDefault();
		$(this).parent().parent().fadeOut("slow");
	});
	/***************************************/
	
	$(".nav .menu").click(function(){
		$(this).bind('click');
	});
	
	$("a.lightbox").lightBox();
	
	//abrir modal overlay
	/*$("a.dialog").live('click',function(event){
		idOverlay = $(this).attr("href");
		event.preventDefault();
		$.extend($.modal.defaults, {
			closeClass: "closeClass",
			closeHTML: "<a href='#'>x</a>"
		});
		if(idOverlay.indexOf("http")!=-1){
			$.get(idOverlay, function(data) {
				 $.modal(data);
			});
		}
		else{
			$(idOverlay).modal();
		}
	});
	
	/********************************/
	//eliminar cualquier cosa, por parametro url de un link (a href)
	
	$("a.eliminar.ajax").click(function(event){
		event.preventDefault();
		url = $(this).attr("href");
		if( confirm("Realmente desea eliminar este item?") ){
			location.href = url;
		}
	});
	
	
	//$("#input_fecha").mask("99/99/9999");
	//$("#input_rut").mask("?9.999.999-9",{placeholder:" "});
	
	
});
