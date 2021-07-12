<div id="modal">
 <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Repuestos</h4>
  </div>
    <form action="<?php echo base_url()?>transportes/repuestos/actualizar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">

          <?php foreach ($datos_repuestos as $datos){
            ?>
            <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>
<br>
             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Repuestos</label>
                    </div>
                    <div class="controls">
                      <input type='text' class="input-mini" maxlength="50" name="nombre" id="nombre" value="<?php echo $datos->nombre_repuesto?>" required/>
                    </div>
                    </div>
                    <br>

             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Precio</label>
                    </div>
                    <div class="controls">
                      <input type='text' class="input-mini" name="precio" placeholder="$" id="precio" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $datos->precio?>" required />
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
