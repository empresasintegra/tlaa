$(document).ready(function() {
    $('input[type=checkbox]').live('click', function(){
        var parent = $(this).parent().attr('id');
        $('#'+parent+' input[type=checkbox]').removeAttr('checked');
        $(this).attr('checked', 'checked');
    });
});


   $(function () { $('#myModal').modal('hide')})});
   $(function () { $('#myModal').on('hide.bs.modal', function () {
      alert('Hey, I heard you like modals...');})





/*


$(document).on("submit", function(){

alert("probar desde submit envio");
echo $_POST['data'];

});




 $(document).on("ready", function(){                 
      $("#area_tabla table tr td").click(function() {
        var celda = $(this);
        alert(celda.html());
      });
    });


function actualizar_trabajador(i) { 
var c = document.getElementById(i).innerHTML; 
location.href = "recibe.php?rut_usuario="+c; 
} 
*/

function comprueba_extension(formulario, archivo) { 
   extensiones_permitidas = new Array(".docx", ".doc"); 
   mierror = ""; 
   //if (!archivo) { 
      //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario 
        //mierror = "No has seleccionado ningún archivo"; 
   //}else{ 
      //recupero la extensión de este nombre de archivo 
      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
      //alert (extension); 
      //compruebo si la extensión está entre las permitidas 
      permitida = false; 
      for (var i = 0; i < extensiones_permitidas.length; i++) { 
         if (extensiones_permitidas[i] == extension) { 
         permitida = true; 
         break; 
         } 
      } 
      if (!permitida) { 
         mierror = "Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join(); 
        }else{ 
          //submito! 
         //alert ("Todo correcto. Voy a submitir el formulario."); 
         formulario.submit(); 
         return 1; 
        } 
   //} 
   //si estoy aqui es que no se ha podido submitir 
   alert (mierror); 
   return 0; 
}