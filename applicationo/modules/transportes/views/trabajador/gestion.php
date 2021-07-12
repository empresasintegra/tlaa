<body>
  <form action="<?php echo base_url() ?>transportes/trabajador/verificar" role="form" id="form" method='post' autocomplete="off" >
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-8">
          <p align="left">
            &nbsp;&nbsp;&nbsp;
            <b>En esta secci&oacute;n se pueden agregar, editar, activar o desactivar registros de la tabla Trabajador.</b>
          </p>          
        </div>
        <div class="col-md-4" align="right">          
          &nbsp;&nbsp;&nbsp;
          <?php if ($usuario_subtipo == 110) { ?>
            <input type="button" title="Agregar" value="Importar Archivos" name ="+" class="btn btn-green" data-toggle="modal" data-target="#Modal_sube_archivo">&nbsp;
          <?php } ?>
          <input type="button" title="Agregar" value="Agregar Trabajador" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">&nbsp;
          <input type="button" title="respaldo" value="Trabajadores Eliminados" name ="+" class="btn btn-green" data-toggle="modal" data-target="#respaldo">&nbsp;

          <?php if ($usuario_subtipo == 110) { ?> 
          <input type='submit' value='Eliminar' name='eliminar' class='btn btn-green' onclick='return confirmSubmit();'>&nbsp;&nbsp;
          <?php } ?> 

        </div>

        <div class="col-md-1" align="center"></div>
      </div><br>      
      <div class="row">
        <div class="col-md-1"></div>  
        <div class="col-md-10">
          <div class="form-group">
            <label class="col-md-2 control-label" for="textinput">Listar Trabajadores</label>
            <div class="col-md-2">
              <input type="radio" class="todos" name="estado" id="estado" onclick="javacript: document.getElementById('listado_seleccion').value = '3' " <?php if($listado_seleccion == 3) echo "checked" ?> > Todos
                         
          </div>
        </div>
      </div>
      <div class="panel-body">
        <table id="example1">
          <thead>
            
              <th><b>Rut</b></th>
              <th><b>Nombre</b></th>
              <th><b>A Paterno</b></th>
              <th><b>A Materno</b></th>
              <th><b>Cargo</b></th>
              <th><b>Forma de Pago</b></th>

              <th><b>Empresa</b></th>
              <?php if ($usuario_subtipo == 110) { ?>
                <th><b> Accciones</b></th>
              <?php } ?>
            </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($personal as $datos){
              ?>
              <tr>              
                <td><?php echo $datos->rut?></td>
                <td><?php echo $datos->nombre?></td>
                <td><?php echo $datos->apellido_paterno?></td>
                <td><?php echo $datos->apellido_materno?></td>
                <td><?php echo $datos->cargos?></td>
                <td ><?php echo $datos->nombre_instrumento_colectivo?></td>
                <td > <?php echo $datos->empresa?>
                 
                </td>

                <?php if ($usuario_subtipo == 110) { ?>

                  <td aling="center" >
                   <a data-toggle="modal" title="Modificar"href="<?php echo base_url()?>transportes/trabajador/modal_editar/<?php echo $datos->id_trabajador ?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>


                 <a><input type='checkbox' name='seleccionar_eliminar[]' value='<?php echo $datos->id_trabajador ?>'></a>
                  </td>
                <?php } ?>                
              </tr>  
              <?php
              $i++;
              }  
            ?>
            </tbody>
          </table>

            <div class="row">
              <div class="col-md-8"></div>
              <div class="col-md-4">
                <button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo del Trabajador">
                  Guardar Estado Trabajadores
                </button>
              </div>
            </div>
            <br>
          </div>
        </div>
      </form>
    </body>
    <!-- Modal Editar Trabajador-->
    <div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">

          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->  
    <!-- Modal Agregar-->
    <div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="text-align:center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Trabajador</h2>
          </div>
          <div class="modal-body">
            <div>
              <h5>Instrucciones:</h5>
              <p>* Todos los campos sus obligatorios.</p>
            </div>
            <form class="form-horizontal" action="<?php echo base_url() ?>transportes/trabajador/guardar_persona" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
              <fieldset>
                <!-- Text input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">RUT</label>

                  <div class="col-md-4">
                    <input id="rut" name="rut" type="text" placeholder="Ingrese Rut" class="form-control input-md" maxlength="12" required>
                    <span class="help-block" style="color: red;">Ej: 12.345.678-9</span> 


                  </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Nombre</label>  
                  <div class="col-md-4">
                    <input id="nombre" name="nombre" type="text" placeholder="Ingrese Nombre" class="form-control input-md" maxlength="25" required>

                  </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Apellido Paterno</label>  
                  <div class="col-md-4">
                    <input id="apellido_paterno" name="apellido_paterno" type="text" placeholder="Apellido Paterno" class="form-control input-md" maxlength="25" required>

                  </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Apellido Materno</label>  
                  <div class="col-md-4">
                    <input id="apellido_materno" name="apellido_materno" type="text" placeholder="apellido materno" class="form-control input-md" maxlength="25" required>

                  </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Cargo</label>
                  <div class="col-md-4">
                    <select name="id_select_cargo" id="id_select_cargo" required>
                      <option value="">Seleccione..</option>
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
                     <option value="">Seleccione...</option>
                     <?php
                     foreach ($contratolista as $id_contrato => $nombre)
                      echo '<option value="',$id_contrato,'">',$nombre,'</option>';
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Empresa</label>
                  <div class="col-md-4">
                   <select name="id_select_empresa" id="id_select_empresa" required>
                     <option value="">Seleccione...</option>
                     <?php
                     foreach ($listarempresa as $id_empresa => $empresa)
                      echo '<option value="',$id_empresa,'">',$empresa,'</option>';
                    ?>
                  </select>
                </div>
              </div>



            </fieldset>


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="boton" type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--modal sube bd trabajadores-->
<div class="modal fade" id="Modal_sube_archivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Trabajador</h2>
      </div>
      <div class="modal-body">
        <div>
          <h5>Instrucciones:</h5>
          <p>* Todos los campos sus obligatorios.</p>
        </div>
        <form class="form-horizontal" action="<?php echo base_url() ?>transportes/trabajador/guardar_trabajadores_excel" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <fieldset>
            <!-- File Button --> 
            <div class="form-group">
            <label class="col-md-4 control-label" for="filebutton"></label>
              <div class="col-md-4">
                <input id="filebutton" name="dato" class="input-file" type="file">
              </div>
            </div>

          </fieldset>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="btnrut" type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--modal reincorporar trabajadores-->


<div class="modal fade bd-example-modal-lg" id="respaldo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Trabajadores Eliminados</h2>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="<?php echo base_url() ?>transportes/trabajador/reincorporar_trabajador" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
        
          <table class="table table-bordered table-dark">
  <thead>
    <tr>
      
      <th scope="col">Rut</th>
      <th scope="col">Nombre</th>
      <th scope="col">A Paterno </th>
      <th scope="col">A Materno</th>
      <th scope="col">Cargo</th>
      <th scope="col">Forma de pago </th>
      <th scope="col">Reincorporar </th>

    </tr>
  </thead>
  <tbody>
         <?php foreach ($recorriendo as $recorrer){ ?>
    <tr>
    
      <td><?php echo $recorrer->rut ?></td>
      <td> <?php echo $recorrer->nombrep ?></td>
      <td><?php echo $recorrer->apellido_paterno ?></td>
      <td><?php echo $recorrer->apellido_materno ?></td>
      <td><?php echo $recorrer->nombreca ?></td>
      <td><?php echo $recorrer->nombrei ?></td>
      
      <td aling="center"><input type='checkbox' name='seleccionar_buscar[]' value='<?php echo $recorrer->id_persona ?>'></td>

      
    </tr>
  <?php } ?>
    
  </tbody>
</table>
        

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button value='reincorporar' name='reincorporar' id="btnrut" type="submit" class="btn btn-primary" >Reincorporar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


