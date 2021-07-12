<div id="modal" >
   <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar repuesto de detalles</h4>
   </div>
    <form action="<?php echo base_url()?>transportes/mantenciones/actualizar_repuestos_submantencion" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">
            <script type="text/javascript" src="<?php echo base_url() ?>\extras\layout2.0\assets\js\si_get_repuestos.js"></script>
          <?php 
              foreach ($repuestos_subdetalles as $datos){ 
          ?>
              <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>
              <input type='hidden' name="id_mantencion" id="id_mantencion" value="<?php echo $id_mantencion ?>"/>
          <br>
            <div class="control-group row">
              <div class="col-md-2">
                  <label class="control-label" for="inputTipo">Repuesto</label>
              </div>
                  <div class="controls col-md-9">
                      <select required name="repuesto2" id="repuesto2">
                         <option value="">Seleccione</option>
                         <?php foreach ($repuestos as $repuesto) { 
                         ?>
                          <option value="<?php echo $repuesto->id ?>" <?php if($datos->id_repuesto == $repuesto->id ) echo "selected" ?> ><?php echo $repuesto->nombre_repuesto?></option>
                         <?php 
                            } 
                         ?>
                      </select>
                  </div>  
            </div>
            <br>
                        <div class="control-group row">
                <div class="col-md-2">
                   <label class="control-label" for="inputTipo">Proveedor</label>
                </div>
                <div class="controls col-md-9">
                   <select required name="proveedor" id="proveedor">
                       <option value="">Seleccione</option>
                       <?php 
                          foreach ($proveedores as $proveedor) { 
                       ?>
                        <option value="<?php echo $proveedor->id ?>" <?php if($datos->id_proveedor == $proveedor->id ) echo "selected" ?> ><?php echo $proveedor->nombre_proveedor?></option>
                       <?php
                         } 
                       ?>
                  </select>
                </div>  
            </div> 
            <br>
          
            <div class="control-group row">
                <div class="col-md-2">
                  <label class="control-label" for="inputTipo">Cantidad</label>
                </div>

                <div class="controls col-md-9">
                  <input type='text' onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="input-mini" name="cantidad2" id="cantidad2" value="<?php echo $datos->cantidad?>" onkeyup="javascript:multiplica_dos_valores('precio', 'cantidad2', 'total')" required/>
                </div>     
            </div>
            <br>
            <div class="control-group row">
                <div class="col-md-2">
                     <label class="control-label" for="inputTipo">Precio </label>
                </div>
                <div class="controls col-md-9">
                     <input type='text' onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="input-mini" name="precio" id="precio" value="<?php echo $datos->precio_repuesto?>"
                     onkeyup="javascript:multiplica_dos_valores('precio', 'cantidad2', 'total')" required/>
                </div>  
            </div>        
            <br>
            <div class="control-group row">
                <div class="col-md-2">
                     <label class="control-label" for="inputTipo">Total</label>
                </div>
                <div class="controls col-md-9">
                     <input type='text' onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="input-mini" readonly="readonly" name="total" id="total" value="<?php echo $datos->total?>"/>
                </div>
            </div>
          
            
          <?php  
            }  
          ?>        
      </div>
      <div class="modal-footer" >
        <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </form>
</div>
