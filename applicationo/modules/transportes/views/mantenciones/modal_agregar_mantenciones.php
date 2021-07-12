      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <?php $hoy= date("d")."-".date("m")."-".date("Y"); $hora = strftime("%H:%M");?>
        <h2 class="modal-title" id="myModalLabel">Agregar Mantención</h2>
          <?php echo $hora."<br>".$hoy ?>
      </div>
      <div class="modal-body">
  
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>
           <!--                                       INICIO FORM                       -->
        <form action="<?php echo base_url() ?>transportes/mantenciones/guardar_mantencionesss" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">

          <div class="control-group">
             <div class="col-md-3">
                <label class="control-label" for="inputTipo">Codigo CCU</label>
             </div>
                <div class="controls">
                    <select required name="codigosccu" id="codigosccu">
                      <option value="">Seleccione</option>
                      <?php foreach ($codigosccu as $codigoccu) { ?>
                            <option  value="<?php echo $codigoccu->idcodigos_ccu ?>"><?php echo $codigoccu->codigos_ccu; ?></option>
                      <?php } ?>
                    </select>
                </div>
          </div>
          <br>

          <div class="control-group"> <!-- Div para la fecha -->
            <div class="col-md-3">
             <label class="control-label" for="inputTipo">Fecha Inicio Mantención</label>
             </div>
              <div class="controls">
                <select name="dia_v" style="width: 60px;" required>
                  <option value="" >Dia</option>
                  <?php for($i=1;$i<32;$i++){ ?>
                  <option value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>
                </select>
                <select name="mes_v" style="width: 108px;" required>
                  <option value="">Mes</option>
                  <option value='01'>Enero</option>
                  <option value='02'>Febrero</option>
                  <option value='03'>Marzo</option>
                  <option value='04'>Abril</option>
                  <option value='05'>Mayo</option>
                  <option value='06'>Junio</option>
                  <option value='07'>Julio</option>
                  <option value='08'>Agosto</option>
                  <option value='09'>Septiembre</option>
                  <option value='10'>Octubre</option>
                  <option value='11'>Noviembre</option>
                  <option value='12'>Diciembre</option>
                </select>
                <select name="ano_v" style="width: 70px;" required>
                  <option value="">Año</option>
                  <?php $tope_f = (date('Y')  ); ?>
                  <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                        <option value="<?php echo $i ?>" ><?php echo $i ?></option>
                  <?php } ?>
                </select>
              </div>
          </div>   <!-- Fin  Div para la fecha -->
        <br>
          <div class="control-group"> <!-- Div para la fecha -->
            <div class="col-md-3">
             <label class="control-label" for="inputTipo">Fecha Fin Mantención</label>
             </div>
              <div class="controls">
                <select name="dia_f" style="width: 60px;" required>
                  <option value="" >Dia</option>
                  <?php for($i=1;$i<32;$i++){ ?>
                  <option value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>
                </select>
                <select name="mes_f" style="width: 108px;" required>
                  <option value="">Mes</option>
                  <option value='01'>Enero</option>
                  <option value='02'>Febrero</option>
                  <option value='03'>Marzo</option>
                  <option value='04'>Abril</option>
                  <option value='05'>Mayo</option>
                  <option value='06'>Junio</option>
                  <option value='07'>Julio</option>
                  <option value='08'>Agosto</option>
                  <option value='09'>Septiembre</option>
                  <option value='10'>Octubre</option>
                  <option value='11'>Noviembre</option>
                  <option value='12'>Diciembre</option>
                </select>
                <select name="ano_f" style="width: 70px;" required>
                  <option value="">Año</option>
                  <?php $tope_f = (date('Y') ); $año=(date('Y')); ?>
                  <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                        <option  value="<?php echo $i ?>" ><?php echo $i ?></option>
                  <?php } ?>
                </select>
              </div>
          </div>   <!-- Fin  Div para la fecha -->
          <br>

          <div class="control-group">
              <div class="col-md-3">
              <label class="control-label" for="inputTipo">Patente</label>
              </div>
              <div class="controls">
                <select required name="camion" id="camion">
                <option value="">Seleccione</option>
                <?php foreach ($camiones as $camion) { ?>
                    <option value="<?php echo $camion->id ?>"><?php echo $camion->patente; ?></option>
                <?php } ?>                
                </select>  
              </div>
          </div>      
          <br>

          <div class="control-group">
          <div class="col-md-3">
            <label class="control-label" for="inputTipo">Chofer</label>
            </div>
            <div class="controls">
              <select required id="chofer" name="chofer">
                <option value="">Seleccione</option>
                <?php foreach ($choferes as $ch) { ?>
                      <option value="<?php echo $ch->id_persona ?>"><?php echo $ch->apellido_paterno.' '.$ch->apellido_materno.' '.$ch->nombre; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <br>

                       
          <div class="control-group">
          <div class="col-md-3">
            <label class="control-label" for="inputTipo">Kilometraje</label>
            </div>
            <div class="controls">
                <input type='text' class="input-mini" name="kilometraje" id="kilometraje" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength='12' required/>
            </div>
          </div>     
          <br>

          <div class="control-group">
          <div class="col-md-3">
            <label class="control-label" for="inputTipo">Odometro</label>
          </div>
            <div class="controls">
                <input type='text' class="input-mini" name="odometro" id="odometro" maxlength='12' required/>
            </div>
          </div>
          <br>


          <div class="control-group">
          <div class="col-md-3">
            <label class="control-label" for="inputTipo">Mantención</label>
            </div>
            <div class="controls">
                <input type='text' class="input-xxlarge" name="titulo" id="titulo" maxlength='100' required/>
            </div>
          </div>  
        
   
      
          <div class="control-group" align="right">
              <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
              <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
         </form> <!--                                 FIN FORM                                        -->
        </div>
      </div>
