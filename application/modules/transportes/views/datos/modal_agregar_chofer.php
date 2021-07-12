<div class="modal-body">
       <!--Cargar detalles de Trabajadadores-->
       <div class="table-responsive">
         <table class="table" id="tabla1">
          <thead>
            <tr>
              <th>Rut</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Seleccione</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($solo_choferes as $c) { ?>
            <tr>
              <td><?php echo $c->rut; ?></td>
              <td><?php echo $c->nombre_persona; ?></td>
              <td><?php echo $c->ap."&nbsp;".$c->am; ?></td>
              <td><input type="checkbox" class="chk_peoneta" name="seleccionar_trabajador[]" value="<?php echo $c->id_trabajador; ?>" /></td>
            </tr>
            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <input type="button" class="btn btn-success add_peonetas" data-dismiss="modal" value="Agregar Trabajadores">
    </div>