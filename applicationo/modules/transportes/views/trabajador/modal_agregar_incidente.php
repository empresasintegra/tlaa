<div id="modal">
  <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Ingresar Insidencias</h4>
  </div>
  <div id="modal_content">
    <div class="controls">
    </div>
      <?php 
        foreach ($datos_trabajador as $datos) {
          ?>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">RUT ej: 12.345.678-9</label>              
              <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>         
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Nombre</label>              
              <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>              
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">RUT</label>              
              <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>         
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Nombre</label>              
              <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>              
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">RUT</label>              
              <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>         
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Nombre</label>              
              <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>              
            </div>
          </div>
          
         <?php 
        }
       ?>
     </div>
     <form action="<?php echo base_url() ?>transportes/trabajador/actualizar_editar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
     </div><br><br><br><br><br><br><br><br><br><br><br><br>
     <div class="modal-footer">
      <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
    </div>
    </form>
  </div>
</div>