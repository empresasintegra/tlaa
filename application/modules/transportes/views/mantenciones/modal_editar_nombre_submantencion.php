
 <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Editar nombre detalle</h4>
  </div>
<div class="modal-body">
  <div class="control-group">
    <form action="<?php echo base_url() ?>transportes/mantenciones/actualizar_nombre_submantencion" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
     <div class="container">
         <div class="row">
                    <input type='hidden' name="id" id="id"  value="<?php echo $idsub?>"/>
                    <input type='hidden' name="id_mantencion" id="id_mantencion" value="<?php echo $id_mantencion ?>"/>      

          <div class="col-md-6">
            <label class="control-label" for="inputTipo">Nombre:  </label>
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
          </div>
                       <br>
         </div>
     </div>
                <div class="modal-footer" style="margin-top: 20px;"  align="right">
                  <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
                  <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
    </form> 
 </div> 
</div>




