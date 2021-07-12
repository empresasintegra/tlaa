<body>
  <form action="<?php echo base_url() ?>transportes/cargos/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podra:<strong><i>agregar, editar y eliminar registros de Ruta.</i></strong>
          </p>
        </div>
        <div class="col-md-2">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      

          <input type="button" title="Agregar" value="+" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">
          
          <?php if ($usuario_subtipo == 110) { ?>
            <input type='submit' value='-' name="eliminar" title="Eliminar" class='btn btn-green confirma' onclick='return confirmSubmit();'>       
          <?php } ?> 
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">
        <div class="col-md-2" align="center"></div>
          <div class="col-md-8" align="center">

            <table id="example1">
              <thead>
                <th ><b>Cargo</b></th>                       
                <th ><b>Modificar</b></th> 
                <?php if ($usuario_subtipo == 110) { ?>
                  <th ><b>Eliminar</b></th>    
                <?php } ?>                         
                  
              </thead>  

              <tbody>
                <?php 
                foreach ($cargo as $datos){
                  ?>
                  <tr>

                    <td><?php echo $datos->nombre?></td>
                    <td><a data-toggle="modal" href="<?php echo base_url()?>transportes/cargos/modal_editar/<?php echo $datos->id_cargo?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a></td>
                    <?php if ($usuario_subtipo == 110) { ?>
                        <td aling="center"><input type='checkbox' name='seleccionar_eliminar[]' value='<?php echo $datos->id?>'></td>
                    <?php } ?>   
                    
                  </tr>
                  <?php
                }  
                ?>

              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </form>
  <div class="leyenda">   
   + Agregar Nuevo Registro - Eliminar Registro.
 </div>
</body>
<!-- Modal Editar Trabajador-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->  
<!-- Modal Agregar-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Cargo</h2>
      </div>
      <div class="modal-body">
        <div>
          <h5>Instrucciones:</h5>
          <p>*Todos los campos sus obligatorios.</p>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>
          <form action="<?php echo base_url() ?>transportes/cargos/guardar_cargo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Nombre Cargo</label>
            <div class="controls">
              <input type="hidden" name="usuario_id" value="<?php echo $usuario_id;?>" />
              <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
            </div>
          </div>
          <div class="modal-footer" style="margin-top: 25px">
            <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>