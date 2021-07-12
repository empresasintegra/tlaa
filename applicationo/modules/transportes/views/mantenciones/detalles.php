<body>
    <div class="panel panel-white"><br>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12" align="center">
           <style type="text/css">
  #linea{
    border-top: 1px solid #A4A4A4 }
  #linea2{
    background-color: #E0ECFF;
   border-left: 1px solid #A4A4A4;
   border-top: 1px solid #A4A4A4;
  }
</style>
<div align="right">
      <form action="<?php echo base_url() ?>transportes/mantenciones/exportacion_excel/" method="post" target="_blank" id="FormularioExportacion">
        <a href="#"  class="botonExcel">Exportar <img style="width: 30px;" src="<?php echo base_url() ?>extras/img/excel.png"  class="botonExcel" > </a>
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
      </form>
</div>
<table id="example1">
              <thead >
                <th id="linea2"><b>Camion</b></th>
                <th id="linea2"><b>Patente</b></th>
                <th id="linea2"><b>kilometraje</b></th>
                <th id="linea2"><b>Mantencion General</b></th>  
                <th id="linea2"><b>Fecha Mantencion</b></th>   
                <th id="linea2"><b>Costo Mantencion</b></th>   
                <th id="linea2"><b>Nombre Detalle</b></th> 
                <th id="linea2"><b>Costo Detalle</b></th> 
                <th id="linea2"><b>Proveedor</b></th>                                               
                <th id="linea2"><b>Repuesto</b></th> 
                <th id="linea2"><b>Cantidad </b></th>
                <th id="linea2"><b>Precio </b></th>
                <th id="linea2"><b>Total</b></th>  
              </thead>  
              <tbody>
              <?php         
                  foreach ($exportando as $datos){
              ?>
                <tr>
                            <td id="linea"><?php echo $datos->codigos_ccu ?></td>
                            <td id="linea"><?php echo $datos->patente ?></td>
                            <td id="linea"><?php echo  number_format($datos->kilometraje) ?></td>
                            <td id="linea"><?php echo $datos->titulo?></td>
                            <td id="linea"><?php echo $datos->fecha; ?></td>  
                            <td id="linea"><?php 
                                              $suma = 0;
                                              foreach ($costo as $key ) {
                                                  if ($datos->id_mantenciones == $key->id_mantenciones) {
                                                    $suma+= $key->total;
                                                  }
                                              }

                                                echo "$<b> ". number_format($suma)."</b>";
                                          ?>
                            </td>
                            <td id="linea" style=" border-left: 1px solid #A4A4A4"><?php echo $datos->nombre_submantencion?></td>
                            <td id="linea" ><?php
                                              $suma=0;
                                              foreach ($sumatotal as $key) {           
                                                if ($key->id_mantencion_detalles == $datos->id_detalle) {
                                                   $suma += $key->total;
                                                }
                                              } 
                                              echo "$<b> ". number_format($suma)."</b>";
                                            ?>
                            </td>    
                            <td id="linea" ><?php echo $datos->nombre_proveedor;?></td>       
                  <td id="linea" style=" border-left: 1px solid #A4A4A4" "><?php echo $datos->nombre_repuesto; ?></td>
               
                  <td id="linea" ><?php echo $datos->cantidad ?></td>
                  <td id="linea"><?php echo  "$ ".number_format($datos->precio_repuesto) ?></td>
                  <td id="linea" style="border-right: 1px solid #A4A4A4"><?php echo "$".number_format($datos->total)?></td>
                   <?php }?>  
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</body>

     <div class="panel-body" hidden>
     <script language="javascript"> // Script para exportar a excel
            $(document).ready(function() {
              $(".botonExcel").click(function(event) {
                $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
                $("#FormularioExportacion").submit();
            });
            });
      </script>

      <table id="Exportar_a_Excel">
              <thead >
                <th style="border: 1px solid black;"><b>Camion</b></th>
                <th style="border: 1px solid black;"><b>Patente</b></th>
                <th style="border: 1px solid black;"><b>kilometraje</b></th>
                <th style="border: 1px solid black;"><b>Mantencion General</b></th>  
                <th style="border: 1px solid black;"><b>Fecha Mantencion</b></th>   
                <th style="border: 1px solid black;"><b>Costo Mantencion</b></th>   
                <th style="border: 1px solid black;"><b>Nombre Detalle</b></th> 
                <th style="border: 1px solid black;"><b>Costo Detalle</b></th> 
                <th style="border: 1px solid black;"><b>Proveedor</b></th>                                   
                <th style="border: 1px solid black;"><b>Repuesto</b></th> 
                <th style="border: 1px solid black;"><b>Cantidad </b></th>
                <th style="border: 1px solid black;"><b>Precio </b></th>
                <th style="border: 1px solid black;"><b>Total</b></th>  
              </thead>  
              <tbody>
              <?php         
                  foreach ($exportando as $datos){
              ?>
                <tr>
                            <td id="linea"><?php echo $datos->codigos_ccu ?></td>
                            <td id="linea"><?php echo $datos->patente ?></td>
                            <td id="linea"><?php echo $datos->kilometraje ?></td>
                            <td id="linea"><?php echo $datos->titulo?></td>
                            <td id="linea"><?php echo $datos->fecha; ?></td>  
                            <td id="linea"><?php 
                                              $suma = 0;
                                              foreach ($costo as $key ) {
                                                  if ($datos->id_mantenciones == $key->id_mantenciones) {
                                                    $suma+= $key->total;
                                                  }
                                              }

                                                echo "$<b> ".($suma)."</b>";
                                          ?>
                            </td>
                            <td id="linea" style=" border-left: 1px solid #A4A4A4"><?php echo $datos->nombre_submantencion?></td>
                            <td id="linea" ><?php
                                              $suma=0;
                                              foreach ($sumatotal as $key) {           
                                                if ($key->id_mantencion_detalles == $datos->id_detalle) {
                                                   $suma += $key->total;
                                                }
                                              } 
                                              echo "$<b> ".($suma)."</b>";
                                            ?>
                            </td>    
                            <td id="linea" ><?php echo $datos->nombre_proveedor;?></td>       
                  <td id="linea" style=" border-left: 1px solid #A4A4A4" "><?php echo $datos->nombre_repuesto; ?></td>
               
                  <td id="linea" ><?php echo $datos->cantidad ?></td>
                  <td id="linea"><?php echo  "$ ".($datos->precio_repuesto) ?></td>
                  <td id="linea" style="border-right: 1px solid #A4A4A4"><?php echo "$".($datos->total)?></td>
                   <?php }?>  
                </tr>
              </tbody>
            </table>






      </div>
