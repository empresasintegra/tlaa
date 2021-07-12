<?php
    header('Content-Type: text/html; charset=UTF-8');
?>

<body>
  <form action="<?php echo base_url() ?>transportes/cajas/menu1" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podr&aacute; actualizar valor de cajas: 
          </p>
        </div>
        
        <div class="col-md-1" ></div>
      </div>
      <div class="panel-body">
        <div class="row">

          <div class="col-md-1" ></div>
          <div class="col-md-10" >


            <table id="example1" style="width:auto" class="table table-striped table-bordered">
              <thead>           
                
                <th ><p style="text-align:center">Bono</p></th>
                <th ><p style="text-align:center">Bono en pesos</p></th>
                <th ><p style="text-align:center">Modificar</p></th>
                
              </thead>
              <tbody>

                <?php 
                foreach ($estandar_bono_chofer as $datos){
                  ?>
                <tr>
                    
                 <td ><?php
                 if($datos->nombre_bono == 'bono_ruta') { echo '<span style="color: gray -500;" >' ."Bono Rutero". '</span>';
                 } 


                 elseif($datos->nombre_bono == 'bono_produccion_2')
                 { echo '<span style="color:teal" >' ."Bono Producción 2 pallets". '</span>';
                 }
                 if($datos->nombre_bono == 'bono_produccion_4') 
                 { echo '<span style="color:teal">' ."Bono Producción 4 pallets". '</span>';
                 } 
                 if($datos->nombre_bono == 'bono_produccion_6') 
                 { echo '<span style="color:teal" >' ."Bono Producción 6 pallets". '</span>';}
                 if($datos->nombre_bono == 'bono_produccion_8') 
                 { echo '<span style="color:teal">' ."Bono Producción 8 pallets". '</span>';
                 } 

                 
                 
                 if($datos->nombre_bono == 'bono_cliente_2') 
                 { echo '<span style="color: gray -500;" >' ."Bono Cliente 2 pallets". '</span>';
                 } 
                                  if($datos->nombre_bono == 'bono_cliente_6') 
                 { echo '<span style="color: gray -500;" >' ."Bono Cliente 6 pallets". '</span>';
                 } 
                 if($datos->nombre_bono == 'bono_cliente_8') 
                 { echo '<span style="color: gray -500;"  >' ."Bono Cliente 8 pallets". '</span>';
                }

                if($datos->nombre_bono == 'bono_vuelta_adicional_2') 
                { echo '<span style="color:teal">' ."Bono Vuelta Adicional 2 pallets". '</span>';
                } 
                if($datos->nombre_bono == 'bono_vuelta_adicional_6') 
                { echo '<span style="color:teal">' ."Bono Vuelta Adicional 6 pallets". '</span>';
                } 
                if($datos->nombre_bono == 'bono_vuelta_adicional_8') 
                { echo '<span style="color:teal" >' ."Bono Vuelta Adicional 8 pallets". '</span>';}

              ?></td>


              <td ><?php echo $datos->bono_en_pesos?></td>
              <td ><a data-toggle="modal" href="<?php echo base_url()?>transportes/cajas/modal_editar/<?php echo $datos->id?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a></td>
                
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
  <div class="modal-dialog  modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->  


  
        




    
     
  

