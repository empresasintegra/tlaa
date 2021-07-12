<div id="modal">
  <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Trabajadores</h4>
  </div>
  <div id="modal_content">
    <div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>transportes/trabajador/actualizar_editar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        foreach ($datos_trabajador as $datos){
      ?>
        <div class="col-md-6"><!--no tocar-->
          <div class="control-group">
            <label class="control-label" for="inputTipo">Rut</label>
            <div class="controls">
              <input type='hidden' class="input-mini" name="id" id="id" value="<?php echo $datos->id_persona?>"/>
              <input type='text' class="input-mini" name="rut" id="rut" value="<?php echo $datos->rut?>" required/>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="inputTipo">Nombre</label>
            <div class="controls">
              <input  readonly type='text' class="input-mini" name="nombre" id="nombre" value="<?php echo $datos->nombre_persona?>" required/>
            </div>
          </div>

            <div class="control-group">
            <label class="control-label" for="inputTipo">Apellido Paterno</label>
            <div class="controls">
              <input type='text' class="input-mini" name="apellido_paterno" id="apellido_paterno" value="<?php echo $datos->apellido_paterno?>" required/>
            </div>
          </div>
      
          <div class="control-group">
            <label class="control-label" for="inputTipo">Apellido Materno</label>
            <div class="controls">
              <input type='text' class="input-mini" name="apellido_materno" id="apellido_materno" value="<?php echo $datos->apellido_materno?>" required/>
            </div>
          </div>      
         
          </div><!--no tocar-->
          <div class="col-md-6"><!--no tocar-->
            <div class="control-group">
            <label class="control-label" for="inputTipo">Cargo</label>
              <div class="controls">
                <select name="id_select_cargo" id="id_select_cargo" required>
                  <option value="<?php echo $datos->id_cargo?>"><?php echo $datos->nombre_cargos?></option>
                    <?php
                    foreach ($cargolista as $id_cargo => $nombre)
                      echo '<option value="',$id_cargo,'">',$nombre,'</option>';
                   ?>
                </select>
              </div>
          </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Forma Pago</label>
              <div class="controls">
                <td><select name="id_select_contrato" id="id_select_contrato" required>
                  <option value="<?php echo $datos->id_instrumento_colectivo?>"><?php echo $datos->nombre_instrumento_colectivo?></option>
                    <?php
                      foreach ($contratolista as $id_contrato => $nombre)
                            echo '<option value="',$id_contrato,'">',$nombre,'</option>';
                   ?>
                </select>
              </div>
          </div>
           
        <?php
          }
        ?></div><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</div>