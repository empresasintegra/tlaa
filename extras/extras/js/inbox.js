$(function(){
	dir = document.URL;
	dir = dir.split('/');
	var dir = dir[3];
	if(window.location.hash) {

  		pagina = window.location.hash;
  		pag =  pagina.split("#");
  		var pagina = pag[1];
  	}
  	else {
  		var pagina = "ajax-all";
  	}

	$(".inbox").removeClass('active');
	$("a[data-pagina='" + pagina + "']").parent().addClass("active");
	$("#loading").show();
	$.ajax({
		url: base_url + dir +"/publicaciones/inbox_ajax",
		async:false,
		data: "pagina="+pagina,
		type: "post",
		beforeSend: function(objeto){
        	$("#loading").show();
   		},
        success: function(datos){
            $( ".emailContent" ).html(datos);
            $("#loading").hide();
        }
	});
	

	$(".inbox-click").click(function(){
		event.preventDefault();
		$(".inbox").removeClass('active');
		$(this).parent().addClass("active");

		pagina = $(this).data("pagina");
		window.location = '#'+pagina;
		$.ajax({
			url: base_url +  dir +"/publicaciones/inbox_ajax",
			async:false,
			data: "pagina="+pagina,
			type: "post",
			beforeSend: function(objeto){
            	$("#loading").show();
       		},
	        success: function(datos){
	            $( ".emailContent" ).html(datos);
	            $("#loading").hide();
	        }
		});
	});

	$(".replyBtn").live('click',function(){
		event.preventDefault();
		pagina = $(this).data("pagina");
		window.location = '#'+pagina;
		$.ajax({
			url: base_url +  dir +"/publicaciones/inbox_ajax",
			async:false,
			data: "pagina="+pagina,
			type: "post",
			beforeSend: function(objeto){
            	$("#loading").show();
       		},
	        success: function(datos){
	            $( ".emailContent" ).html(datos);
	            $("#loading").hide();
	        }
		});
	});

	$(".viewEmail").live("click", function(){
		event.preventDefault();
		id = $(this).data("id");
		pagina = $(this).data("tipo");
		$.ajax({
			url: base_url + dir + "/publicaciones/contenido_ajax",
			async:false,
			data: "id="+id+"&pagina="+pagina,
			type: "post",
			beforeSend: function(objeto){
            	$("#loading").show();
       		},
	        success: function(datos){
	            $( ".emailContent" ).html(datos);
	            $("#loading").hide();
	        }
		});
	});

	$("#refresh").live('click',function(){
		event.preventDefault();
		if(window.location.hash){
			pagina = window.location.hash;
  			pag =  pagina.split("#");
  			pagina = pag[1];
		}
  		else pagina = "ajax-all";

  		$.ajax({
			url: base_url +  dir +"/publicaciones/inbox_ajax",
			async:false,
			data: "pagina="+pagina,
			type: "post",
			beforeSend: function(objeto){
            	$("#loading").show();
       		},
	        success: function(datos){
	            $( ".emailContent" ).html(datos);
	            $("#loading").hide();
	        }
		});
	});

	$("#leido").live("click", function(){
		event.preventDefault();
		$(".checker input:checkbox:checked").each(function(){
			pagina = $(this).data("tipo");
			id = $(this).data("id");
			if ( pagina == "ajax-all" )
				pagina = $(this).data('especif');
			$.ajax({
				url: base_url +  dir +"/publicaciones/leido",
				async:false,
				data: "pagina="+pagina+"&id="+id,
				type: "post",
				beforeSend: function(objeto){
	            	$("#loading").show();
	       		},
		        success: function(datos){
		            $.ajax({
						url: base_url +  dir +"/publicaciones/inbox_ajax",
						async:false,
						data: "pagina="+pagina,
						type: "post",
						beforeSend: function(objeto){
			            	$("#loading").show();
			       		},
				        success: function(datos){
				            $( ".emailContent" ).html(datos);
				            $("#loading").hide();
				        }
					});
		        }
			});
		});
	});

	$("#eliminar").live("click", function(){
		event.preventDefault();
		$(".checker input:checkbox:checked").each(function(){
			pagina = $(this).data("tipo");
			id = $(this).data("id");
			if ( pagina == "ajax-all" )
				pagina = $(this).data('especif');
			$.ajax({
				url: base_url +  dir +"/publicaciones/borrar",
				async:false,
				data: "pagina="+pagina+"&id="+id,
				type: "post",
				beforeSend: function(objeto){
	            	$("#loading").show();
	       		},
		        success: function(datos){
		            $.ajax({
						url: base_url +  dir +"/publicaciones/inbox_ajax",
						async:false,
						data: "pagina="+pagina,
						type: "post",
						beforeSend: function(objeto){
			            	$("#loading").show();
			       		},
				        success: function(datos){
				            $( ".emailContent" ).html(datos);
				            $("#loading").hide();
				        }
					});
		        }
			});
		});
	});
	$("#btn_prev").live("click", function(){
		event.preventDefault();
		pagina = $(this).data("tipo");
		npagina = $(this).data("npagina");

  		$.ajax({
			url: base_url +  dir +"/publicaciones/inbox_ajax",
			async:false,
			data: "pagina="+pagina+"&n_pagina="+npagina,
			type: "post",
			beforeSend: function(objeto){
            	$("#loading").show();
       		},
	        success: function(datos){
	            $( ".emailContent" ).html(datos);
	            $("#loading").hide();
	        }
		});
	});
	$("#btn_next").live("click", function(){
		event.preventDefault();
		pagina = $(this).data("tipo");
		npagina = $(this).data("npagina");

  		$.ajax({
			url: base_url +  dir +"/publicaciones/inbox_ajax",
			async:false,
			data: "pagina="+pagina+"&n_pagina="+npagina,
			type: "post",
			beforeSend: function(objeto){
            	$("#loading").show();
       		},
	        success: function(datos){
	            $( ".emailContent" ).html(datos);
	            $("#loading").hide();
	        }
		});
	});
});