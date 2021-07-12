$(document).ready(function () {
  $(".todos").click( function() { 		
 		tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
 		//estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"transportes/trabajador/datos_trabajadores/"+tipo_listado;
	    
 	});
  $(".activos").click( function() { 		
 		tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
 		//estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"transportes/trabajador/datos_trabajadores/"+tipo_listado;
	     
 	});
  $(".inactivos").click( function() { 		
 		tipo_listado = ($('input:hidden[name=listado_seleccion]').val());
 		//estado = ($('input:hidden[name=estado]').val());
	    location.href=base_url+"transportes/trabajador/datos_trabajadores/"+tipo_listado;
	     
 	});
});