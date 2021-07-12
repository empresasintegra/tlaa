<div id="modal">
 <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos</h4>
  </div>
    <form action="<?php echo base_url()?>transportes/nombre_mantencion/actualizar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">
        <div class="modal-header">
     
        </div>
          <?php 
             foreach ($nombre as $datos){
          ?>
              <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>
              <label class="control-label" for="inputTipo">Nombre</label>
              <div class="controls">
                 <input style="width: 100%; line-height: 20px; " maxlength='150' required type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_mantencion?>"></input>
              </div>                                
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
