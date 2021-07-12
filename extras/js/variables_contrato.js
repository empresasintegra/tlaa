$(document).ready(function(){
	$("#nuevo").click(function(event){
		event.preventDefault();
		$.extend($.modal.defaults, {
			closeClass: "closeClass",
			closeHTML: "<a href='#'>x</a>"
		});
		$.get(base_url+"administracion/contratos/ae_variable", function(data) {
			 $.modal(data);
		});
	});
	$("#editar").click(function(event){
		event.preventDefault();
		radio = $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar al menos una variable");
		}
		else{
			$.extend($.modal.defaults, {
				closeClass: "closeClass",
				closeHTML: "<a href='#'>x</a>"
			});
			$.get(base_url+"administracion/contratos/ae_variable/"+radio.val(), function(data) {
				 $.modal(data);
			});
		}
	});
	$("#eliminar").click(function(event){
		event.preventDefault();
		radio = $('*:radio:checked');
		if( radio.val() == undefined ){
			$.msgbox("Debe seleccionar al menos una variable");
		}
		else{
			$.msgbox("Si esta variable ya fue ingresada a uno o mas contratos, recuerde que esta <b>no se eliminará</b>, debe quitarla manualmente.<br/>¿Esta seguro que desea eliminar la variable seleccionada?", {
				  type: "confirm",
				  buttons : [
				    {type: "submit", value: "Si"},
				    {type: "cancel", value: "Cancel"}
				  ]
				}, function(result) {
					if(result){
						$.ajax({
							url: base_url+"administracion/contratos/eliminar_variable/"+radio.val(),
							async:false,
					        success: function(datos){
					            alert(datos);
					            location.refresh();
					        }
						});
					}
			});
		}
	});
});