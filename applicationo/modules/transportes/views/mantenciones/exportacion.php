<?php 
header("Content-type: application/vnd.ms-excel; name='excel'"); 
header("Content-Disposition: filename=Mantenciones.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?> 
<style type="text/css">
  #linea{
    border-top: 1px solid #A4A4A4 }
  #linea2{
    background-color: #E0ECFF;
   border-left: 1px solid #A4A4A4;
  }
</style>
<table id="example1">
              <thead >
                <th id="linea2"><b>Camion</b></th>
                <th id="linea2"><b>Patente</b></th>
                <th id="linea2"><b>Chofer</b></th>
                <th id="linea2"><b>kilometraje</b></th>
                <th id="linea2"><b>Mantencion General</b></th>  
                <th id="linea2"><b>Fecha Mantencion</b></th>   
                <th id="linea2"><b>Costo Mantencion</b></th>   
                <th id="linea2"><b>Nombre Detalle</b></th> 
                <th id="linea2"><b>Costo Detalle</b></th>                
                <th id="linea2"><b>Repuesto</b></th> 
                <th id="linea2"><b>Cantidad </b></th>
                <th id="linea2"><b>Precio </b></th>
                <th id="linea2"><b>Total</b></th>  
              </thead>  
              <tbody>
              <?php 
              $comparar="si";
              $comparacion_nombre="si";
              $comparar_chofer="si";
              $comparar_fecha="si";
              $comparar_titulo = "si";
              $comparacion_costo_mantencion="si";
        
                  foreach ($exportando as $datos){
              ?>
                <tr>
                   <?php
                  if ($datos->codigos_ccu == $comparar and //comparo el codigo ccu
                    $datos->apellido_paterno." ".$datos->apellido_materno." ".$datos->nombre == $comparar_chofer and // comparo el chofer
                    $datos->fecha == $comparar_fecha and //comparo la fecha
                    $datos->titulo == $comparar_titulo//comparo el nombre Mantencion General
                    ) {?>
                        <td><?php echo "";?></td>
                        <td><?php echo "";?></td>
                        <td ><?php echo "";?></td>
                        <td><?php echo "";?></td>
                        <td ><?php echo "";?></td>
                        <td ><?php echo "";?></td>
                        <td ><?php echo "";?></td>
                 <?php }else{                          
                             ;?>
                            <td id="linea"><?php echo $datos->codigos_ccu ?></td>
                            <td id="linea"><?php echo $datos->patente ?></td>
                            <td id="linea"><?php echo $datos->apellido_paterno." ".$datos->apellido_materno." ".$datos->nombre; ?></td>
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
                                                echo "<b>".$suma."</b>";
                                          ?>
                  </td>
                  <?php  }// cierro else if
                   if ($datos->nombre_submantencion == $comparacion_nombre and $datos->titulo == $comparar_titulo) {?>
                           <td style="border-left: 1px solid #A4A4A4"><?php echo "";?></td>
                           <td ><?php echo "";?></td> 
                         
                  <?php
                         }else{
                
                  ?>
                            <td id="linea" style=" border-left: 1px solid #A4A4A4"><?php echo $datos->nombre_submantencion?></td>
                            <td id="linea" ><?php
                                              $suma=0;
                                              foreach ($sumatotal as $key) {           
                                                if ($key->id_mantencion_detalles == $datos->id_detalle) {
                                                   $suma += $key->total;
                                                }
                                              } 
                                              echo "<b>".$suma."</b>";
                                            ?>
                            </td>   <?php }?>           
                  <td id="linea" style=" border-left: 1px solid #A4A4A4" "><?php echo $datos->nombre_repuesto; ?></td>
                  <?php  ?>
                  <td id="linea" ><?php echo $datos->cantidad ?></td>
                  <td id="linea"><?php echo $datos->precio_repuesto ?></td>
                  <td id="linea" style="border-right: 1px solid #A4A4A4"><?php echo $datos->total?></td>
                </tr>
              <?php
                   $comparar = $datos->codigos_ccu ;
                   $comparar_chofer = $datos->apellido_paterno." ".$datos->apellido_materno." ".$datos->nombre;
                   $comparar_fecha =  $datos->fecha ;
                   $comparar_titulo = $datos->titulo;
                   $comparacion_nombre = $datos->nombre_submantencion;
                 
                 } 
              ?>
              </tbody>
            </table>