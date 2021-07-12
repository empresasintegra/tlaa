<?php
    header('Content-Type: text/html; charset=UTF-8');
?>
<body>
  <form action="<?php echo base_url() ?>transportes/cajas/menu4" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
      <div class="col-md-10">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podr&aacute; actualizar valor de cajas:<strong><i></i></strong>
          
        </div>
        
        <div class="col-md-1" ></div>
      </div>
      <div class="panel-body">
        <div class="row">

          <div class="col-md-1" ></div>

      <div class="col-md-10" >


      <table  id="example1" style="width:auto" class="table table-striped table-bordered">
              <thead>  
                        
                
                <th ><p style="text-align:center">Bono</p></th>
                <th ><p style="text-align:center">Bono en pesos</p></th>
                <th ><p style="text-align:center">Modificar</p></th>
                
              
               </thead>
              <tbody>

                <?php 
                foreach ($estandar_bono_peoneta as $datos){
                ?>
                <tr>
                    
                 
                <td ><?php
                  if($datos->nombre_bono == 'bono_ruta') { echo '<span style="color:teal">' ."Bono Rutero". '</span>';
                  } 




                  if($datos->nombre_bono == 'bono_produccion_2' && $datos->cantidad_peonetas=='1') 
                  {
                      
                      echo '<span style="color: gray -500;" >' ."Bono Producción 2 pallets / 1 ayudante". '</span>';
                  }
                  if($datos->nombre_bono == 'bono_produccion_2' && $datos->cantidad_peonetas=='2') 
                  {echo '<span style="color: gray -500px;" >' ."Bono Producción 2 pallets / 2 ayudantes". '</span>';
                  }
                  if($datos->nombre_bono == 'bono_produccion_2' && $datos->cantidad_peonetas=='3') 
                  {echo '<span style="color: gray -500px;" >' ."Bono Producción 2 pallets / 3 ayudantes". '</span>';
                  }

                  
                  if($datos->nombre_bono == 'bono_produccion_4' && $datos->cantidad_peonetas=='1')
                   { echo '<span style="color: gray -500px;">' ."Bono Producción 4 pallets / 1 ayudante". '</span>';
                  } 
                  if($datos->nombre_bono == 'bono_produccion_4' && $datos->cantidad_peonetas=='2')
                   { echo '<span style="color: gray -500px;">' ."Bono Producción 4 pallets / 2 ayudantes". '</span>';
                  }
                  if($datos->nombre_bono == 'bono_produccion_4' && $datos->cantidad_peonetas=='3')
                   { echo '<span style="color: gray -500px;">' ."Bono Producción 4 pallets / 3 ayudantes". '</span>';
                  }


                  if($datos->nombre_bono == 'bono_produccion_6' && $datos->cantidad_peonetas=='1') 
                  { 
                    echo '<span style="color: gray -500px;">' ."Bono Producción 6 pallets / 1 ayudante". '</span>';}
                  if($datos->nombre_bono == 'bono_produccion_6' && $datos->cantidad_peonetas=='2') 
                  { 
                    echo '<span style="color: gray -500px;">' ."Bono Producción 6 pallets / 2 ayudantes". '</span>';} 
                  if($datos->nombre_bono == 'bono_produccion_6' && $datos->cantidad_peonetas=='3') 
                  { 
                  echo '<span style="color: gray -500px;">' ."Bono Producción 6 pallets / 3 ayudantes". '</span>';}   


                  
                  if($datos->nombre_bono == 'bono_produccion_8' && $datos->cantidad_peonetas=='1') 
                  { 
                    echo '<span style="color: gray -500px;" >' ."Bono Producción 8 pallets / 1 ayudante". '</span>';}
                  if($datos->nombre_bono == 'bono_produccion_8' && $datos->cantidad_peonetas=='2') 
                  { 
                    echo '<span style="color: gray -500px;">' ."Bono Producción 8 pallets / 2 ayudantes". '</span>';} 
                  if($datos->nombre_bono == 'bono_produccion_8' && $datos->cantidad_peonetas=='3') 
                  { 
                  echo '<span style="color: gray -500px;">' ."Bono Producción 8 pallets / 3 ayudantes". '</span>';}   






                  if($datos->nombre_bono == 'bono_cliente_2' && $datos->cantidad_peonetas=='1')
                  {
                     echo '<span style="color:teal">' ."Bono Cliente 2 pallets / 1 ayudante". '</span>';}
                  if($datos->nombre_bono == 'bono_cliente_2' && $datos->cantidad_peonetas=='2')
                  {
                     echo '<span style="color:teal">' ."Bono Cliente 2 pallets / 2 ayudantes". '</span>';} 
                  if($datos->nombre_bono == 'bono_cliente_2' && $datos->cantidad_peonetas=='3')
                  { 
                     echo '<span style="color:teal">' ."Bono Cliente 2 pallets / 3 ayudantes". '</span>';
                  }  




                  if($datos->nombre_bono == 'bono_cliente_6' && $datos->cantidad_peonetas=='1' )
                  { 
                    echo '<span style="color:teal" >' ."Bono Cliente 6 pallets / 1 ayudante". '</span>';}
                  if($datos->nombre_bono == 'bono_cliente_6' && $datos->cantidad_peonetas=='2')
                  { 
                    echo '<span style="color:teal" >' ."Bono Cliente 6 pallets / 2 ayudantes". '</span>';}  
                  if($datos->nombre_bono == 'bono_cliente_6' && $datos->cantidad_peonetas=='3')
                  { 
                    echo '<span style="color:teal" >' ."Bono Cliente 6 pallets / 3 ayudantes". '</span>';}  




                  if($datos->nombre_bono == 'bono_cliente_8' && $datos->cantidad_peonetas=='1')
                  {
                    echo '<span style="color: teal">' ."Bono Cliente 8 pallets / 1 ayudante". '</span>';} 
                  if($datos->nombre_bono == 'bono_cliente_8' && $datos->cantidad_peonetas=='2')
                  { 
                    echo '<span style="color:teal" >' ."Bono Cliente 8 pallets / 2 ayudantes". '</span>';}
                  if($datos->nombre_bono == 'bono_cliente_8' && $datos->cantidad_peonetas=='3')
                  { 
                  echo '<span style="color:teal" >' ."Bono Cliente 8 pallets / 3 ayudantes". '</span>';}  









                  if($datos->nombre_bono == 'bono_vuelta_adicional_2')
                  { 
                    echo '<span style="color:gray -500px;">' ."Bono Vuelta Adicional 2 pallets ". '</span>';} 
                  if($datos->nombre_bono == 'bono_vuelta_adicional_6')
                  { 
                    echo '<span style="color:gray -500px;">' ."Bono Vuelta Adicional 6 pallets". '</span>';} 
                  if($datos->nombre_bono == 'bono_vuelta_adicional_8')
                  { 
                    echo '<span style="color:gray -500px;">' ."Bono Vuelta Adicional 8 pallets". '</span>';} 
                 
                  
                ?></td>

                               
                <td ><?php echo $datos->bono_en_pesos?></td>
                <td ><a data-toggle="modal" href="<?php echo base_url()?>transportes/cajas/modal_editar2/<?php echo $datos->id?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a></td>
                
                            
              </tr> <?php  } ?>
                
              </tbody>




            </table>
          </div>
        </div>
        
      </div>
    </div>
  </form>

  <!-- Modal Editar Caja-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->  
  
        




    
     
  

