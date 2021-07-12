<body>
  <form action="<?php echo base_url() ?>transportes/rep/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>

      <div class="row">
        <div class="col-md-9">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <strong><i>Mantenciones Generales.</i></strong><a  href="<?php echo base_url()?>transportes/mantenciones/filtros_mantenciones"><i title="Filtrar resultados"  class="fa fa-filter "></i></a> <!--ir a filtros-->
          </p>
        </div>
        <div class="col-md-3" align="right">          
          <a data-toggle="modal" class="btn btn-green" href="<?php echo base_url()?>transportes/mantenciones/agregar_mantencion" data-target="#ModalAgregar">Agregar Mantención</a>
          <a href="<?php echo base_url()?>transportes/mantenciones/exportacion?>"> <img style="width: 30px;" src="<?php echo base_url() ?>extras/img/excel.png"> </a>
        </div>
      </div>
  
      
      
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12" align="center">
            <table id="example1">
              <thead>
                <th ><b>CCU</b></th> 
                <th ><b>Chofer</b></th> 
                <th ><b>Camión</b></th>               
                <th ><b>Mantención General</b></th>            
                <th ><b>Costo</b></th>
                <th ><b>kilometraje</b></th> 
                <th ><b>Fecha</b></th>  
                <th ><b>Estado</b></th>
                <th ><b>Editar</b></th>
              </thead>  

              <tbody>
                <?php 
                foreach ($mantenciones as $datos){ 
                  ?>
                  <tr>
                    <td><?php echo $datos->codigos_ccu ?></td>
                    <td><?php echo ucwords(strtolower($datos->apellido_paterno." ".$datos->apellido_materno." ".$datos->nombre)); ?></td>   
                    <td><?php echo $datos->patente?></td>
                    <td><?php echo ucwords(strtolower($datos->titulo))?></td>
                    <td>$ <?php 
                        $suma = 0;
                        foreach ($costo as $key ) {
                            if ($datos->id_mantencion == $key->id_mantenciones) {
                              $suma+= $key->total;
                            }
                        }
                          echo number_format($suma);
                    ?></td>
                    <td><?php echo number_format($datos->kilometraje)?></td>
                    <td><?php echo $datos->fecha?></td>
                   <?php
                      if($datos->estado_mantencion == 1){?>
                    <td> <?php echo "inactivo";?></td>
                    <td>                  <!--Editar Mantencion -->
                      <a  href="#" ><i title="Editar" style=" color: #000000;" class="fa fa-edit"></i></a>
                                          <!--Agregar Submantencion -->
                      <a   href="<?php echo base_url()?>transportes/mantenciones/agregar_submantencion/<?php echo $datos->id_mantencion?>" ><i title="Ver Detalles" style=" color: #000000;"  class="fa fa-wrench"></i></a> <!--Elimnar Mantencion -->
                      <a  href="#" ><i title="Eliminar Mantencion" style=" color: #000000;" class="fa fa-trash-o "></i> </a>
                    </td>
                <?php 
                    }else{ 
                ?> 
                    <td> <?php echo "activo";?></td>
                    <td>        <!--Editar Mantencion -->
                      <a data-toggle="modal" href="<?php echo base_url()?>transportes/mantenciones/modal_editar/<?php echo $datos->id_mantencion?>" data-target="#ModalEditar"><i  title="Editar" class="fa fa-edit"></i></a>
                                <!--Agregar Submantencion -->
                       <a  href="<?php echo base_url()?>transportes/mantenciones/agregar_submantencion/<?php echo $datos->id_mantencion?>"><i title="Agregar Detalles"  class="fa fa-wrench"></i></a>   
                                 <!--Eliminar Mantencion -->
                       <a  href="<?php echo base_url()?>transportes/mantenciones/eliminar/<?php echo $datos->id_mantencion?>" onClick="if(confirm('Esta seguro que desea eliminar el registro?')) return true; else return false;"><i style="color: #FA5858" title="Eliminar Mantencion" class="fa fa-trash-o "></i> </a>
                    </td>
                <?php 
                      }  
                ?>
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
<!-- Modal Editar Mantencion General-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->  
<!--*******************************************Inicio Modal Agregar*************************************************-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div> <!-- Fin Modal Agregar Repuestos -->