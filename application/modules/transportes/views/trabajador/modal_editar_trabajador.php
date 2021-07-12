<form action="<?php echo base_url() ?>transportes/trabajador/actualizar" role="form" id="form2" method='post' name="f2" class="form-horizontal" enctype="multipart/form-data">
  <legend><i>Ingrese Información</i></legend>



  <fieldset>
    <!-- Text input-->

    <input type='hidden' class="input-mini" name="id" id="id" value="<?php echo $id_trabajador;?>"/>

    <?php foreach ($datos_trabajador as $datos) {?>
            <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Rut</label>  
        <div class="col-md-4">
          <input id="rut" name="rut" type="text" class="form-control input-md" value="<?php echo $datos->rut?>"/>
          <span class="help-block" style="color: red;">Ej: 12.345.678-9</span> 

        </div>
      </div>



      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Nombre</label>  
        <div class="col-md-4">
          <input id="nombre" name="nombre" type="text" class="form-control input-md" value="<?php echo $datos->nombre?>"/>

        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Apellido Paterno</label>  
        <div class="col-md-4">
          <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control input-md" value="<?php echo $datos->ap?>"/>

        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="textinput">Apellido Materno</label>  
        <div class="col-md-4">
          <input id="apellido_materno" name="apellido_materno" type="text" class="form-control input-md" value="<?php echo $datos->am?>"/>

        </div>
      </div>
      
      <!-- Select Basic -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="selectbasic">Cargo</label>
        <div class="col-md-4">
         <select name="id_select_cargo" id="id_select_cargo" required>
          <option value="<?php echo $datos->id_cargo?>"><?php echo $datos->n_cargo?></option>
          <?php
          foreach ($cargolista as $id_cargo => $nombre)
            echo '<option value="',$id_cargo,'">',$nombre,'</option>';
          ?>
        </select>
      </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="selectbasic">Tipo Convenio</label>
      <div class="col-md-4">
       <select name="id_select_contrato" id="id_select_contrato" required>
        <option value="<?php echo $datos->id_instrumento_colectivo?>"><?php echo $datos->n_instrumento?></option>
        <?php
        foreach ($contratolista as $id_contrato => $nombre)
          echo '<option value="',$id_contrato,'">',$nombre,'</option>';
        ?>
      </select>
    </div>
  </div>

 <!-- Select Basic -->
  <div class="form-group">
      <label class="col-md-4 control-label" for="selectbasic">Empresa</label>
      <div class="col-md-4">
       <select name="id_select_empresa" id="id_select_empresa" required>
        <option value="<?php echo $datos->id_empresa?>"><?php echo $datos->empresa?></option>
        <?php
        foreach ($listarempresa as $id_empresa => $empresa)
          echo '<option value="',$id_empresa,'">',  $empresa,'</option>';
        ?>
      </select>
    </div>
  </div>
<?php } ?>



</fieldset>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>

</form>
