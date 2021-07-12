<div id="modal">
 <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos</h4>
  </div>
    <form action="<?php echo base_url()?>transportes/cargos/actualizar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">
        <div class="modal-header">
             <p>Para modificar un registro, <i>complete los campos solicitados.**</i></p>
        </div>
          <?php foreach ($datos_cargo as $datos){
            ?>
          <div class="col-md-6">
            <!--<div class="control-group">-->
              <input type='hidden' class="input-mini" name="id" id="id" value="<?php echo $datos->id_cargo?>"/>
                <label class="control-label" for="inputTipo">Cargo</label>
                  <div class="controls">
                    <input type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre?>"/>
                  </div>
            
        </div>
    </div>
   <?php 
        }
    ?>
     <div class="modal-footer" style="margin-top:62px;">
      <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
