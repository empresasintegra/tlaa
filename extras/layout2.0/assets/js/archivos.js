$(document).ready(function(){
	$("#select_tipo").change(function(){
		id = $(this).val();
		$.ajax({
			dataType: "json",
			url: base_url+"administracion/archivos/ajax_categoria_usuario/"+id
		}).done(function(data) {
			$("#select_categoria").find('option').remove();
			$.each( data, function(i, item) {
			    //items.push( "<option value='" + key + "'>" + val + "</option>" );
			    $("#select_categoria").append("<option value='" + data[i].id + "'>" + data[i].desc_tipo_usuarios + "</option>");
			});
		});
	});
});