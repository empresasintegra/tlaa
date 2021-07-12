  $(document).on('change', '#repuesto', function(){//js para obtener el precio en el MODAL Agregar repuestos a la SUBMANTENCION
                            var id_repuesto = $(this).val();
                            //alert("hi");
                              $.ajax({
                                type: "POST",
                                url:base_url+"transportes/mantenciones/buscar_repuestos/"+id_repuesto,
                                contentType: "application/x-www-form-urlencoded",
                                dataType: "json",
                                success: function(data){
                                 $("#precio_repuesto").val(data['precio']);
                                 $("#cantidad").val("");
                                 $("#precio_total").val("");
                                }
                                });
                            });

  $(document).on('change', '#repuesto2', function(){ //js para obtener el precio en el MODAL EDITAR SUBMANTENCION
                            var id_repuesto = $(this).val();
                            //alert("hi");
                              $.ajax({
                                type: "POST",
                                url:base_url+"transportes/mantenciones/buscar_repuestos/"+id_repuesto,
                                contentType: "application/x-www-form-urlencoded",
                                dataType: "json",
                                success: function(data){
                                 $("#precio").val(data['precio']);
                                 $("#cantidad2").val("");
                                   $("#total").val(""); 
                                 //$("#precio_repuesto2").val(data['id']);
                                }
                                });
                            });