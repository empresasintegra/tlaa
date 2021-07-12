<body>
    <head>
        

<script LANGUAGE="JavaScript">
function validar(f){

f.enviar.disabled=true;
alert('El formulario se está enviando');


return true}
</script>

<?php $fecha_inicio1 = new DateTime('first day of previous month'); 
      $fecha_inicio = $fecha_inicio1->format('Y-m') ;?>

    </head>
    <form action="<?php echo base_url()?>transportes/liquidacion/liquidaciones" role="form" id="form1" method="post" autocomplete="off" onsubmit="return validar(this)">
        <div class="panel panel-white">
            <div class="row">
                
            </div><br>
            <div class="row">
                <div class="col-md-1">  
                </div>
                <div class="col-md-10">
                    <h3>
                    <p style="color: red;">Cerrar Mes <?php echo $fecha_inicio ?></p></h3>
                </div>
            </div></br>
            <div class="row">
                <div class="col-md-1">  
                </div>
                <div class="col-md-10">
                    
                    <div class="col-md-2"> 
                        <button class="btn btn-success" type="submit" name="enviar" > Cerrar </button>
                    </div>                
                </div>
                <div class="col-md-1">  
                </div>

            </div><br>
            
            <div class="panel-body">    
               
            </div>
        </div>
    </form>



</body>