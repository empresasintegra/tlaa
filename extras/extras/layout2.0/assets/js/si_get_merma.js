function buscar_merma(){
  var id_planta = $('#id_planta').val();
  var codigo = $('#codigo').val();
  $.ajax({
      type: "POST",
      url:base_url+"servicios/produccion/buscar_detalles_producto/"+id_planta+"/"+codigo,
      contentType: "application/x-www-form-urlencoded",
      dataType: "json",
      success: function(data){ 
        $("#articulo").val(data['articulo']);
        $("#descripcion").val(data['descripcion']);
        $("#tamano").val(data['tamano']);
        $("#producto_id").val(data['producto_id']);
        $("#tipo_producto").val(data['nombre_tipo_producto']);
      }
      });
}