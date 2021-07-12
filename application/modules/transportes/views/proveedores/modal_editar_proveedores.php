<div id="modal">
 <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Proveedores</h4>
  </div>
    <form action="<?php echo base_url()?>transportes/proveedores/actualizar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">

          <?php 
             foreach ($proveedores as $datos){
          ?>
              <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>
<br>
             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Rut</label>
                    </div>
                    <div class="controls">
                  <input required type='text' class="input-mini" name="rut"  id="rut" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $datos->rut?>"/>
                    </div>
                    </div>
                    <br>


             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Proveedor</label>
                    </div>
                    <div class="controls">
                  <input required type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_proveedor?>"/>
                    </div>
                    </div>
                    <br>

             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Direccion</label>
                    </div>
                    <div class="controls">
                  <input required type='text' class="input-mini" name="direccion"  id="direccion"  value="<?php echo $datos->direccion?>"/>
                    </div>
                    </div>
                    <br>                              
   
          <?php 
              }
          ?>
      </div>
            
       <div class="modal-footer" style="margin-top:62px;">
            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
       </div>
    </form>
</div>
