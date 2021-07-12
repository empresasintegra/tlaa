
<body>
  <form action="<?php echo base_url()?>transportes/produccion/guardar_produccion" role="form" id="form" method="post" autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-6">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong><i>Ingrese la Produccion del Camión </i>&nbsp;<?php echo $c_camion; ?></strong>
          </p>
        </div>
        <div class="col-md-6">
          <div class="col-md-3">
           <p align="left"><b><font color="#006B12">Fecha Actual</font></b></p>
         </div>
         <div class="col-md-3">
          <input style="border-top-width: 1px;margin-top: 0px;padding-top: 2px;border: 1px solid #BFBFBF;padding-bottom: 2px;" name="datepicker" type="text" id="datepicker" class="datepicker" value="<?php echo $fecha_mostrar; ?>" size="10" readonly="true" title="Fecha"/>
        </div>
      </div>
      <div class="panel-body">         

      </div>
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="col-md-2">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Rutas</label>
            <div class="controls">

            </div>
          </div><br>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Cajas Entrega</label>
            <div class="controls">

            </div>
          </div>


        </div>

        <div class="col-md-2">
          <div class="control-group">

            <div class="controls">
              <select name="id_select_ruta" id="id_select_ruta" required>
                <option value="id_select_ruta">Seleccione Ruta</option>
                <?php foreach ($listarutas as $r) { 
                  echo '<option value="',$r->id,'">',$r->nombre_rutas,'</option>';
                } ?>
              </select>
            </div>
          </div><br>          
          <div class="control-group">

            <div class="controls">
              <input type='number' class="input-mini" name="cantidad_cajas" id="cantidad_cajas" value="" required/>
              <input type="hidden" size="20" name="codigo_camion" id="codigo_camion" value="<?php echo $c_camion; ?>"/>
            </div>
          </div>

        </div>       

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Conductor  <a data-toggle="modal" class="btn btn-warning btn-xs" href="<?php echo base_url()?>transportes/datos/modal_agregar_chofer" data-target="#modal_chofer"> Agregar Chofer </a>
                </th>
                <th>Peonetas</th>

              </tr>
            </thead>
            <tbody>
              <tr>
                <?php $x= 0;
                if ($todos_choferes > 0) { ?>
                <?php foreach ($todos_choferes as $row) { 
                  $x +=1;?>

                  <td>
                    <p id="chofer"><label><?php echo strtoupper($row->nombre_persona); ?>&nbsp;<?php echo strtoupper($row->ap); ?>&nbsp;<?php echo strtoupper($row->am); ?></label><input type="hidden" size="20" id="chofer[]" name="chofer[<?php echo $x?>]" value="<?php echo $row->id_trabajador; ?>"/>
                      <input type="hidden" name="c_camion[<?php echo $x ?>]" id="c_camion[]" value="<?php echo $row->id_camion; ?>"/>
                      <input type="hidden" name="id_cargo_c[<?php echo $x?>]" value="<?php echo $row->id_cargo ?>" id="id_cargo_c[]"/> 
                      <span><a href="#" onclick="borrar();"><i class="fa fa-times" aria-hidden="true"></i></a></span></p>
                      <div class="listado">

                      </div>
                    </td>

                    <?php  } ?>
                    <?php } else{ ?>
                    <td>No tiene Chofer Asignado</td>
                    <?php } ?>


                    <td>

                      <?php $i= 0;
                      foreach ($todos_peonetas as $l) { 
                        $i +=1;?>                                     
                        <p id="peonetas"><label><?php echo strtoupper($l->nombre_persona); ?>&nbsp;<?php echo strtoupper($l->ap); ?>&nbsp;<?php echo strtoupper($l->am); ?></label><input type="hidden" size="20" id="id_peoneta[]" name="id_peoneta[<?php echo $i?>]" value="<?php echo $l->id_trabajador; ?>"/>
                          <input type="hidden" name="c_camion[<?php echo $i ?>]" id="c_camion[]" value="<?php echo $l->id_camion; ?>"/>
                          <input type="hidden" name="id_cargo_p[<?php echo $i?>]" value="<?php echo $l->id_cargo ?>" id="id_cargo_p[]"/>
                          <span><a href="#" onclick="borrar_p();"><i class="fa fa-times" aria-hidden="true"></i></a></span></p> 

                          <?php  } ?>

                          <div class="listado_peoneta">

                          </div>


                        </td>
                      </tr>
                    </tbody>              
                  </table>
                </div>
                <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-md-4">
                    <button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo del Trabajador">
                      Guardar Vuelta
                    </button>
                  </div>
                  <br>
                </div><br>
              </div>

            </div>
          </div>




        </form>
      </body>

<!-- Modal Agregar chofer-->
<div class="modal fade" id="modal_chofer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Nuevo Chofer</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
      
<div class="modal fade" id="modal_peoneta" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content Peoneta-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>          
        <h4 class="modal-title">Agregar Peoneta</h4>
        <!--<input type='text' class="buscar_peoneta" name="buscar_peoneta" id="buscar_peoneta" placeholder="Ingrese Busqueda" value="" required/>
        <input type="button" class="btn" style="width:70px; height:30px;" value="Buscar" onclick="buscar_merma()">-->
      </div>
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
            <?php foreach ($solo_peonetas as $p) { ?>
            <tr>
              <td><?php echo $p->rut; ?></td>
              <td><?php echo $p->nombre_persona; ?></td>
              <td><?php echo $p->ap."&nbsp;".$p->am; ?></td>
              <td><input type="checkbox" class="chk_peoneta" name="seleccionar_trabajador[]" value="<?php echo $p->id_trabajador; ?>" /></td>
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
  </div>

</div>
</div>
