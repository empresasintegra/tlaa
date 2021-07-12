$(document).ready(function(){
	$("#link-guia").click(function(event){
		event.preventDefault();
		url = $(this).attr("href");
		$.ajax({
			url: url,
			cache: false,
			error: function(objeto, quepaso, otroobj){
	            alert("Estas viendo esto por que fallé");
	            alert("Pasó lo siguiente: "+ quepaso);
	            alert(objeto.responseText);
	            err = eval("(" + objeto.responseText + ")");
  				alert(err.Message);
	        },
		  	beforeSend: function() {
		  		$("#salida-generada").html("<img src='"+base_url+"extras/img/ajax-peq.gif' />Generando...");
		  	},
		  	success: function(){
		   		$("#salida-generada").html("&nbsp;");
		   		//alert(url);
		   		document.location.href=url;
		  	}
		});
	});
});
