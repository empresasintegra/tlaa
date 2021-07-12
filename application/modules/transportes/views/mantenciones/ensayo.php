<body>
  <div class="panel panel-white"><br>
     
              <?php 
            foreach ($datos_mantenciones as $datos){ 
         ?>
             
                  <div class="col-md-12">
                  <h4>
                    <label class="control-label" for="inputTipo"><strong style="color: #000000"> Mantención General:  </strong></label>
                  
                        <input type='text'  disabled name="titulo" id="titulo" style="width: 700px" value="<?php
                         echo strtoupper($datos->titulo)?>"/>
                   </h4>
               </div> 

   
  <div class="container"> <!-- Inicio Container -->
      <div class="row" style="color:#8b91a0" style="margin-top: 1cm;"> <!-- Inicio ROW-->     
            <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>
            <br> <br> 
             <div class="col-md-4">
              <label class="control-label" for="inputTipo"> <strong style="color: #000000">Codigo CCU: </strong></label>
                  <?php
                    foreach ($codigos as $cod) {
                      if($datos->id_cod_ccu == $cod->idcodigos_ccu ) echo $cod->codigos_ccu;
                    }?> 
             </div>

          
             <div class="col-md-4">
              <label class="control-label" for="inputTipo"><strong style="color: #000000">Chofer: </strong></label>           
                  <?php 
                    foreach ($choferes as $ch) {
                    if($datos->id_chofer == $ch->id_persona) echo ucwords(strtolower($ch->apellido_paterno.' '.$ch->apellido_materno.' '.$ch->nombre));
                  } ?>                 
                
            </div>        
          

          <div class="col-md-4">
              <label class="control-label" for="inputTipo"><strong style="color: #000000">Patente: </strong> </label>                
                  <?php 
                    foreach ($camiones as $cam) {
                      if($datos->id_camion == $cam->id) 
                        echo $cam->patente;
                  }?>         
          </div>

          <div class="col-md-4">
              <label class="control-label" for="inputTipo"><strong style="color: #000000">Kilometraje: </strong></label>
                    <input type='text' class="input-mini" name="kilometraje" id="kilometraje" style="width: 150px" disabled value="<?php echo $datos->kilometraje?>"/>         
          </div>
    

            <div class="col-md-4">
                     <label class="control-label" for="inputTipo"><strong style="color: #000000">Fecha: </strong></label>
              
                        <input type='text' disabled class="input-mini" style="width: 150px" name="fecha" id="fecha" value="<?php echo $datos->fecha?>"/>
                
            </div>
            <div  class="col-md-4">
            <label class="control-label" for="inputTipo"><strong style="color: #000000">Costo:</strong></label>
            <label style="width: 150px">
              <?php 
                        $suma = 0;
                        foreach ($costo as $key ) {
                              $suma+= $key->total;   
                        }
                          echo " $ ".number_format($suma);
                    ?>
                    </label>
            </div>
      </div>                                 <!-- Fin row -->
            <?php } ?>
            <div class="col-md-12" align="right" style="border-bottom-color: blue; top: -4px;"> 
                <?php 
                  if ($datos->estado ==1) {
                 ?>
                     <input  type="button" value="Agregar detalles de mantención" name ="+" class="btn btn">
               <?php 
                  }else{ 
                ?>
                     <input  type="button" value="Agregar detalles de mantención" name ="+" class="btn btn-blue"  data-toggle="modal" data-target="#ModalAgregarNombre">
                <?php 
                  }
                ?> 
            </div>

      <div class="col-md-12" style="background: #ddd; height: 3px"></div>
    <!--******************** INICIO DE CADA DATOS DE SUBMANTENCION**************************-->
                  <?php
                    $costo=0;
                    foreach ($listado as $row) {   
                  ?>
                  
                 
      <div class="col-md-12" style="background: #ddd; height: 3px"></div><!--Div con background para separar cada Submantencion-->
      <br>
        <div class="row">
        <div class="col-md-10" style=" box-shadow: inset 0px -16px 42px 0px rgba(0,0,0,0.07);">
          <label class="control-label" for="inputTipo"> <strong style="color: #000000">Detalle: </strong></label>
                 
                        <?php 
                          echo ucwords(strtolower($row->nombre_submantencion));
                          $idsub = $row->id_submantencion; //le asigno la id de la submantencion 
                          $nombreSub = $row->nombre_submantencion;
                           
                          if ($datos->estado==1) {
                        ?>
                              <a  style="margin-left: 20px;" href="" ><i title="editar nombre detalle" style="color: #000000"  class="fa fa-edit"></i></a>  

                              <a  href="" class="btn btn-outline btn-circle dark btn-sm black"><i title="eliminar detalle" style="color: #000000;" class="fa fa-trash-o "></i> </a>
                        <?php 
                          }else{
                        ?>
                            <a  style="margin-left: 20px;" class=" dark btn-sm black  " data-toggle="modal" href="<?php echo base_url()?>transportes/mantenciones/modal_editar_nombre_submantencion/<?php echo $idsub;?>/<?php echo $id_mantencion ?>" data-target="#ModalEditarNombreSubmantencion"><i title="editar nombre detalle"  class="fa fa-edit"></i></a>  

                             <a  href="<?php echo base_url()?>transportes/mantenciones/eliminar_submantencion/<?php echo $id=$idsub;?>/<?php echo $id_mantencion ?>" class=" dark btn-sm black  " onClick="if(confirm('Esta seguro que desea eliminar el detalle que lleva por titulo : <?php echo strtoupper($nombreSub) ?> y todo su contenido?')) return true; else return false;"><i title="eliminar detalle" style="color: red;" class="fa fa-trash-o "></i> </a>
                        <?php 
                          } 
                          echo "<label class='control-label' for='inputTipo'> <strong style='color: #000000''>Total Detalle: </strong></label>"." $ ";
                        // echo "<b>Total detalle:</b> $ ";  
                          $suma=0;
                          foreach ($sumatotal as $key) {           
                            if ($key->id_mantencion_detalles == $row->id_submantencion) {
                               $suma += $key->total;
                            }
                          } 
                          //echo $suma;
                          echo number_format($suma);

                        ?>
                          
                  </div>
                  <div class="col-md-10"  align="left" style="height: 180px; overflow: scroll;" > <!-- Inicio div-->

                <table class="table">
                  <thead>
                    <th ><b>Repuesto</b></th> 
                    <th ><b>Cantidad</b></th> 
                    <th ><b>Precio c/u</b></th>               
                    <th ><b>Total</b></th>            
                    <th ><b>Proveedor</b></th>
                    <th ><b>Editar </b></th>
                  </thead>  
                  <tbody>
                    <?php
                       if ($listado != false) {
                       $i= 1;
                       foreach ($row->respuesto_mantencion as $key) { 
                    ?>
                    <tr>
                        <td><?php echo ucwords(strtolower($key->nombre_respuesto));?></td>
                        <?php $nombreRep = $key->nombre_respuesto?>
                        <td><?php echo $key->cantidad."<br>";?></td>
                        <td> <?php echo "$ ".number_format($key->precio_repuesto); ?></td>
                        <td> <?php echo "$ ".number_format($key->total); ?></td>
                        <td><?php echo ucwords(strtolower($key->proveedor)); ?></td>  
                      <?php 
                        if ($datos->estado == 1) { 
                      ?>
                        <td>
                            <a class="btn btn"  ><i style="color: #000000" class="fa fa-edit"></i></a> 
                            <a  class="btn btn"><i style="color: #000000" class=" fa fa-trash-o "></i> </a>
                        </td>
                      <?php   
                        }else {  
                      ?>        
                        <td>
                            <a data-toggle="modal" href="<?php echo base_url()?>transportes/mantenciones/modal_editar_submantencion/<?php echo $key->id;?>/<?php echo $id_mantencion ?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a> 
                            <a  href="<?php echo base_url()?>transportes/mantenciones/eliminar_repuestos_submantencion/<?php echo $key->id;?>/<?php echo $id_mantencion ?>"  onClick="if(confirm('Esta seguro que desea eliminar el registro  con nombre de repuesto  <?php echo $nombreRep; ?>?')) return true; else return false;"><i style="color: red;"  class="fa fa-trash-o "></i> </a>
                        </td>
                        <?php 
                          }                     
                           $i++;
                          } 
                           }else{
                                    //echo "no se han agregado repuesto a esta submantencion";
                            } 
                        ?>
                    </tr>
                  </tbody>
                </table>
            </div><!-- Fin div-->
                <?php 
                    if ($datos->estado == 1) {
                ?>
                    <div class="col-md-2" align="center" style="margin-top: 80px;">
                      <a class="btn btn"  style=" background-color: #dddddd; color: #000000" >Agregar Repuesto</a>
                    </div>
                <?php   
                   }else{
                ?>
                    <div class="col-md-2" align="center" style="margin-top: 80px;">
                      <a data-toggle="modal" class="btn btn-green" href="<?php echo base_url()?>transportes/mantenciones/modal_agregar_repuestos/<?php echo $idsub?>/<?php echo $id_mantencion ?>" data-target="#ModalAgregar">Agregar Repuesto</a>
                      <input type="hidden" name="id_mantencion" id="id_mantencion" value="<?php echo $id_mantencion ?>">
                    </div>
                <?php 
                  }
                ?>
       </div>                                         <!-- Fin ROW -->
   <?php
        }
    ?>
   <!--FIN DE CADA DATOS DE SUBMANTENCION-->
   </div><!--Fin container-->
  
</div>
</body>

<!-- Modal Agregar Nombre del submantenimiento-->
<div class="modal fade" id="ModalAgregarNombre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Seleccione nombre detalle</h2>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>
          <form action="<?php echo base_url() ?>transportes/mantenciones/guardar_nombre_submantencion" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
            <div class="control-group">
                  <input type="hidden" name="id_mantencion" id="id_mantencion" value="<?php echo $id_mantencion ?>">
                  <div class="col-md-2">
                  <label class="control-label" for="inputTipo">Nombre: </label>
                  </div>
                  <div class="controls">
                  
                      <select required  name="nombre_submantencion" id="nombre_submantencion">
                          <option value="">Seleccione</option>
                          <?php 
                              foreach ($nombre_detalle as $nombre) { 
                          ?>
                       <option  value="<?php echo $nombre->nombre_mantencion?>"><?php echo $nombre->nombre_mantencion; ?></option>
                          <?php
                              } 
                          ?>
                        </select>
                         <a style="margin-left: 10px;" href="<?php echo base_url()?>transportes/nombre_mantencion/index/<?php echo $id_mantencion?>"> <i title="Agregar Detalles"  class="fa fa-plus-square"></i></a> 
                  </div>
               
            </div>
            <div class="modal-footer" style="margin-top: 25px">
                  <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
                  <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
 </div>
</div>
<!--****************************** Inicio Modal Agregar Repuesto   *****************************************-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
       <script type="text/javascript" src="<?php echo base_url() ?>\extras\layout2.0\assets\js\si_get_repuestos.js"></script>
      </div>
  </div>
 </div>
</div> <!-- Fin Modal Agregar Repuestos -->

<!--****************************  ModalEditarSubmantencion************************************-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal --> 

<!--****************************  Modal Editar Nombre de Submantencion************************************-->
<div class="modal fade" id="ModalEditarNombreSubmantencion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>