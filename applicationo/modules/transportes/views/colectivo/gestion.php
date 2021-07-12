
<body>
  <form action="<?php echo base_url() ?>transportes/colectivo/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="right">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>En esta secci&oacute;n se pueden agregar, editar y eliminar registros de la tabla Informes Colectivos .</b>
          </p>
        </div>
        <div class="col-md-2">
          &nbsp;&nbsp;&nbsp;
          <input type="button" title="Agregar" value="+" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">&nbsp;

          <?php if ($usuario_subtipo == 110) { ?>
            <input type='submit' value='-' name='eliminar' class='btn btn-green' onclick='return confirmSubmit();'>&nbsp;&nbsp;  
          <?php } ?>  
               
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
       <div class="col-md-1"></div>
       <div class="col-md-10">
         <table id="example1">
          <thead>
            <tr>                        
              <td><b>Codigo</b></td>
              <td><b>Instrumento Colectivo</b></td>
              <td><b>Modificar</b></td>
              <?php if ($usuario_subtipo == 110) { ?>
                <td><b>Eliminar</b></td>
              <?php } ?>                
            </tr>
          </thead>
          <tbody>
            <?php 
            foreach ($colectivo as $datos){
              ?>
              <tr>               
                <td ><?php echo $datos->id?></td>
                <td ><?php echo $datos->nombre?></td>
                <td ><a data-toggle="modal" href="<?php echo base_url()?>transportes/colectivo/modal_editar/<?php echo $datos->id?>/<?php echo $usuario_id;?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a></td>
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
      
      <br>
    </div>
  </div>
</form>
</body>
<!-- Modal Editar ruta-->
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
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo</h2>
      </div>
      <div class="modal-body">
        <div>
          <h5>Instrucciones:</h5>
          <p>*Todos los campos sus obligatorios.</p>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>
          <form action="<?php echo base_url() ?>transportes/colectivo/guardar_colectivo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
            <input name="id" type="hidden" size="25" maxlength="25">
            <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $usuario_id?>" >
            <div class="control-group">
              <label class="control-label" for="inputTipo">Instrumento Colectivo:</label>
              <div class="controls">
                <input name="nombre" type="text" size="25" maxlength="25">
              </div>
            </div>
            <div class="modal-footer" style="margin-top: 30px;">
              <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
              <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>