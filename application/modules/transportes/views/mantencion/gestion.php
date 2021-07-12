<body>
  <?php if ($id_mantencion == NULL) {?>
    <a href="javascript:history.go(-1)">Volver</a>

 <?php }else{ ?>
    <a style="margin-left: 10px;" href="<?php echo base_url()?>transportes/mantenciones/agregar_submantencion/<?php echo $id_mantencion?>"> <i title="volver" >volver</i></a>
    <?php } ?> 
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-8">
            <p align="left">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              En esta secci&oacute;n usted podra:<strong><i>agregar, editar y eliminar detalles  de mantención</i></strong>
            </p>
         

        </div>
        <div class="col-md-4">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
            <input  type="button" title="Agregar" value="Agregar Nombre Detalle" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">
             <a id="myButtonControlID" href=""> <img style="width: 30px;" src="<?php echo base_url() ?>extras/img/excel.png"> </a>
        </div>
        <div class="col-md-1" align="center"></div>
      </div>

      <div class="panel-body">
       <div class="row">
        <div class="col-md-2" align="center"></div>
          <div class="col-md-8" align="center">
            <table id="example1">
              <thead>
              <th style="width: 10%;"><b>#</b></th> 
                <th style="width: 80%;"><b>Nombre</b></th> 
                <th style="width: 10%;"><b>Edicion</b></th>  
               <!-- <th ><b>Direccion</b></th>  
                <th ><b>Modificar</b></th> 
                <th ><b>Eliminar</b></th> -->   
              </thead>  
              <tbody>
              <?php 
                $i=1;
                  foreach ($nombre as $datos){ 
              ?>
                <tr>
                <td><?php echo $i; ?></td>
                  <td><?php echo $datos->nombre_mantencion?></td>
                  <td> <a data-toggle="modal" href="<?php echo base_url()?>transportes/nombre_mantencion/modal_editar/<?php echo $datos->id?>" data-target="#ModalEditar"><i  title="Editar" class="fa fa-edit"></i></a>
                    <a  href="<?php echo base_url()?>transportes/nombre_mantencion/eliminar/<?php echo $datos->id?>" onClick="if(confirm('Esta seguro que desea eliminar el registro?')) return true; else return false;"><i style="color: #FA5858" title="Eliminar Mantencion" class="fa fa-trash-o "></i> </a>
                  </td>
                </tr>
              <?php
              $i++;
                }  
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</body>
<!--Inicio Div para la exportacion a Excel-->
<div id="divTableDataHolder" style="display:none">
     <table id="example1">
              <thead>
                 <th ><b>#</b></th> 
                 <th ><b>Nombre</b></th> 
              </thead>  
              <tbody>
              <?php 
              $i=1;
                  foreach ($nombre as $datos){
              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $datos->nombre_mantencion?></td>
                </tr>
              <?php
              $i++;
                }  
              ?>
              </tbody>
            </table>
</div>
<!--Fin Div para la exportacion a Excel-->

<!-- Modal Editar Trabajador-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->  

<!-- Modal Agregar-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
        <h2 class="modal-title" id="myModalLabel">Ingreso nuevo nombre detalle</h2>
      </div>
      <div class="modal-body">
     
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>
          <form action="<?php echo base_url() ?>transportes/nombre_mantencion/guardar_nombre" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
             <input type="hidden" name="id_mantencion" id="id_mantencion" value="<?php echo $id_mantencion ?>">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Detalle</label>
              <div class="controls">
                  <input style="width: 100%;" maxlength='150' required type='text' class="input-mini" name="nombre_mantencion" id="nombre_mantencion" ></input>
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