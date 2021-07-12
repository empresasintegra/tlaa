<form class="form-horizontal" action="<?php echo base_url()?>transportes/informes/guardar_inasistencias" role="form" id="form1" method="post" autocomplete="off">
  <fieldset>

    <!-- Form Name -->
    <legend>Ingresar Tipo Inasistencia</legend>

    <!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="selectbasic">Tipo Asistencia</label>
      <div class="col-md-4">
        <select id="id_select_inasistencia" name="id_select_inasistencia" required>
          <option>[Seleccionar..]</option>
          <option value="1">Con Goce de Sueldo</option>
          <option value="2">Sin Goce de Sueldo</option>
          <option value="3">Vacaciones</option>
          <option value="4">Licencias</option>
          <option value="5">Aunsencia Injustificada</option>
        </select>
      </div>
    </div>


    <!-- Textarea -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="comentario">Comentario</label>
      <div class="col-md-4">                     
        <textarea class="form-control" id="comentario" name="comentario"></textarea>
      </div>
    </div>
    <input type="hidden" id="fecha_trabajar" name="fecha" value="<?php echo $fecha; ?>" />
    <input type="hidden" name="id_trabajador" id="id_trabajador" value="<?php echo $id_trabajador;?>" />
    <!-- Button (Double) -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="button1id"></label>
      <div class="col-md-8">
        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </fieldset>
</form>
