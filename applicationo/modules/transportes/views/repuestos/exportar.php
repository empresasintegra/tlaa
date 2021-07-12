<?php 
header("Content-type: application/vnd.ms-excel; name='excel'"); 
header("Content-Disposition: filename=Repuestos.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?> 
<table id="example1" >
              <thead >
                <th style="background-color: #E0ECFF;" ><b>Repuesto</b></th> 
                <th style="background-color: #E0ECFF;"><b>Precio</b></th>   
              </thead>  
              <tbody>
              <?php 
                  foreach ($repuestos as $datos){
              ?>
              <tr>
                <td><?php echo $datos->nombre_repuesto?></td>
                <td><?php echo $datos->precio?></td>
              </tr>
              <?php
                }  
              ?>
              </tbody>
            </table>