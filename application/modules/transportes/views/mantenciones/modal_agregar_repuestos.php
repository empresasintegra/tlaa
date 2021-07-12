  <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Agregar Repuesto</h4>
  </div>
    <div id="modal_content">
        <div class="modal-header">
             <p> Ingrese repuesto al detalle de mantención: <?php foreach ($nombre_sub as $nombre ) {?>
              <b> <?php echo ucwords(strtolower($nombre->nombre_submantencion)); }?></b></p>
        </div>
        <div class="modal-body">
          <script type="text/javascript" src="<?php echo base_url() ?>\extras\layout2.0\assets\js\si_get_repuestos.js"></script>
          <script type="text/javascript" src="<?php echo base_url() ?>\extras\layout2.0\assets\js\si_validaciones.js"></script>
          <div>
          
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"></label>
            <form action="<?php echo base_url() ?>transportes/mantenciones/guardar_submantenciones/<?php echo $idsub?>/<?php echo $id_mantencion ?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">

          <div class="row">
                  <input type="hidden" name="id_mantencion" id="id_mantencion" value="<?php echo $id_mantencion ?>">
                  <div class="control-group row">
                      <div class="col-md-2">
                      <label class="control-label" for="inputTipo">Repuesto</label>
                    </div>
                    <div class="controls col-md-9">
                      <select required  name="repuesto" id="repuesto" class="repuesto">
                          <option value="">Seleccione</option>
                          <?php 
                              foreach ($repuestos as $repuesto) { 
                          ?>
                             <option  value="<?php echo $repuesto->id ?>"><?php echo $repuesto->nombre_repuesto; ?></option>
                          <?php
                              } 
                          ?>
                        </select>
                    </div>
                  </div>
                  <br>

                    <div class="control-group row">
                        <div class="col-md-2">
                            <label class="control-label" for="inputTipo">Proveedores</label>
                        </div>
                        <div class="controls col-md-9">
                          <select required name="proveedores" id="proveedores">
                                <option value="">Seleccione</option>
                                <?php 
                                    foreach ($proveedores as $proveedor) { 
                                ?>
                                    <option  value="<?php echo $proveedor->id ?>"><?php echo $proveedor->nombre_proveedor; ?></option>
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
                      <input  type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="cantidad" id="cantidad" value="" onkeyup="javascript:multiplica_dos_valores('precio_repuesto', 'cantidad', 'precio_total')" required>
                    </div>
                    </div>
                    <br>

                    <div class="control-group row">
                      <div class="col-md-2">
                    <label class="control-label" for="inputTipo">Precio c/u</label>
                    </div>
                    <div class="controls col-md-9">
                       <input  type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="precio_repuesto" id="precio_repuesto" value="0" onkeyup="javascript:multiplica_dos_valores('precio_repuesto', 'cantidad', 'precio_total') " required>
                    </div>
                    </div>
                 <br>

                  <div class="control-group  row">
                      <div class="col-md-2">
                    <label class="control-label" for="inputTipo">Precio total</label>
                    </div>
                    <div class="controls col-md-9">
                      <input  type='text' class="input-mini" name="precio_total" readonly="readonly" id="precio_total" required/>
                    </div>
                    </div>
                   

                  

              <div class="col-md-12" align="right" style="margin-top: 10px;">
                  <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
                  <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
          </div>          <!-- Fin Row-->
      </form>   <!-- Fin Form -->
    </div>
  </div>
</div>
