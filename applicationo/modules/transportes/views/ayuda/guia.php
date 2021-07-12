<body>
    <head>
        

<script LANGUAGE="JavaScript">
<!--
var cuenta=0;

function enviado() {
if (cuenta == 0)
{
cuenta++;
return true;
}
else
{
alert("El siguiente formulario ya ha sido enviado, muchas gracias.");
return "<?php echo base_url()?>transportes/cierres_mensual/resumen";
}
}
// -->
</script>

<?php $fecha_inicio1 = new DateTime('first day of previous month'); 
      $fecha_inicio = $fecha_inicio1->format('Y-m') ;?>

    </head>
    <form action="<?php echo base_url()?>transportes/liquidacion/liquidaciones" role="form" id="form1" method="post" autocomplete="off" onSubmit="return enviado()" >   
        <div class="panel panel-white">
            <div class="row">
                
            </div><br>
            <div class="row">
                <div class="col-md-1">  
                </div>
                <div class="col-md-10">
                    <h3>
                    <p style="color: red;">Seleccione la ayuda que necesite </p></h3>
                </div>
            </div></br>
            <div class="row">
                <div class="col-md-1">  
                </div>
                <div class="col-md-10">

                    <a href="https://www.tla.integraltda.cl/gif/actualizacion2.html">*Cierre mensual </a> <br>
                     <a href="https://www.tla.integraltda.cl/gif/actualizacion.html">*Informe de liquidaciones y consolidado</a>
                  
                                   
                </div>
                <div class="col-md-1">  
                </div>

            </div><br>
            
            <div class="panel-body">    
               
            </div>
        </div>
    </form>



</body>