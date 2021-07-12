<form action="<?php echo base_url() ?>transportes/camion/actualiza_camion" role="form" id="form2" method='post' name="f2" class="form-horizontal" enctype="multipart/form-data">
  <legend><i>Ingrese Información</i></legend>

  <!-- Text input-->
  <?php foreach ($data_camion as $data) { ?>
  
  <div class="form-group">
    <label class="col-md-4 control-label" for="patente">Patente</label>  
    <div class="col-md-4">
      <input id="patente_data" name="patente_data" type="text" value="<?php echo $data->patente;?>" 
      class="form-control input-md">
      
      <input id="id_camion" name="id_camion" type="hidden" value="<?php echo $data->id;?>" 
      class="form-control input-md">

    </div>
  </div>

  <!-- Select Basic -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="id_select_marca">Marca</label>
    <div class="col-md-4">
      <select id="id_select_marca" name="id_select_marca" class="form-control">
        <option>Seleccione Marca</option>                           
        <option value="Chevrolet">Chevrolet</option>          
        <option value="Ford">Ford</option>
        <option value="Isuzu">Isuzu</option>              
        <option value="Kia">Kia</option>             
        <option value="Mercedes Benz">Mercedes Benz</option> 
        <option value="Mitsubishi">Mitsubishi</option>         
      </select>
    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="ano">Año</label>  
    <div class="col-md-4">
      <input id="ano" name="ano" type="text" value="<?php echo $data->ano; ?>" class="form-control input-md">

    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="capacidad">Capacidad</label>  
    <div class="col-md-4">
      <input id="capacidad" name="capacidad" type="text" value="<?php echo $data->capacidad; ?>" class="form-control input-md">

    </div>
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="pallets">Pallets</label>  
    <div class="col-md-4">
      <input id="pallets" name="pallets" type="text" value="<?php echo $data->pallets; ?>" class="form-control input-md">

    </div>
  </div>






</div>
<?php } ?>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  <button type="submit" class="btn btn-primary">Guardar</button>
</div>

</form>