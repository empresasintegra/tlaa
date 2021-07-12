$(document).ready(function(){
  var max_chofer = 3;
  var div = $(".listado");
  var i = 0;
  $(".add_field_button").click(function(e){
    e.preventDefault();
    if (i < max_chofer) {      
      var resultado = false;      
      $(".chk").each(function(i){
        i+=1;
        if($(this).is(':checked')){
         resultado = $(this).val();
         $.ajax({
          type: "POST",
          url:base_url+"transportes/datos/buscar_chofer/"+resultado,
          contentType: "application/x-www-form-urlencoded",
          dataType: "json",
          success: function(data){
            $(div).append('<div><label>'+ data['nombre_persona'].toUpperCase() + '&nbsp;'+ data['ap'].toUpperCase() + '&nbsp;'+ data['am'].toUpperCase() +
              '</label><input type="hidden" size="20" name="chofer['+ i +']"  id="chofer[]" value="'+ data['id_trabajador'] +'" /><input type="hidden" name="id_cargo_c['+ i +']" value="1" id="id_cargo_c[]">&nbsp;<a href="#" class="remove_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>');
          }
        });

       }
     });
    }

  });

    $(div).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('div').remove(); i--;
    });
  });
$(document).ready(function(){
  var max_peonetas = 3;
  var div = $(".listado_peoneta");
  var x = 0;
  $(".add_peonetas").click(function(e){
    e.preventDefault();
    if (x < max_peonetas) {  
      var resultado_p = false;
      $(".chk_peoneta").each(function(){
        x+=1;
        if($(this).is(':checked')){
         resultado_p = $(this).val();
         $.ajax({
          type: "POST",
          url:base_url+"transportes/datos/buscar_peoneta/"+resultado_p,
          contentType: "application/x-www-form-urlencoded",
          dataType: "json",
          success: function(data){
            $(div).append('<div><label>'+ data['nombre_persona'].toUpperCase() + '&nbsp;'+ data['ap'].toUpperCase() + '&nbsp;'+ data['am'].toUpperCase() +
              '</label><input type="hidden" size="20" name="id_peoneta['+ x +']" id="id_peoneta[]" value="'+ data['id_trabajador'] +'" /><input type="hidden" size="20" name="id_cargo_p['+ x +']" value="2" id="id_cargo_p[]">&nbsp;<a href="#" class="remove_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>');
              
          }
        });

       }
     });
    }

  });

    $(div).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('div').remove(); x--;
    });
  });

function borrar() {
  $("#chofer").remove();
}

function borrar_p() {
  $("#peonetas").remove();
}

