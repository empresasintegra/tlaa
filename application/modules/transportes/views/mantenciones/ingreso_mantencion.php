<body>
  <form action="<?php echo base_url() ?>transportes/rep/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong><i>Ingresar Mantenciones.ddd</i></strong>
          </p>
        </div>
       
      <div class="" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">
        <div class="" align="center"></div>
          <div class="col-md-3" align="center">
               <div class="control-group">
                  <label class="control-label" for="inputTipo">Estado</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
                
                 <div class="control-group">
                  <label class="control-label" for="inputTipo">Camion</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
        </div>
        <div class="col-md-3" align="center">
                <div class="control-group">
                  <label class="control-label" for="inputTipo">Fecha Mantencion</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
                <div class="control-group">
                  <label class="control-label" for="inputTipo">Patente</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
        </div>
        <div class="col-md-3" align="center">
                <div class="control-group">
                  <label class="control-label" for="inputTipo">Chofer</label>
                  <?foreach ($mantenciones as $datos) {
                      
                  } ?>
                  <?php echo $datos->codigos_ccu?>
                        <select>
                            <?php
                            while
                            ?>

                        </select>

                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
                <div class="control-group">
                  <label class="control-label" for="inputTipo">kilometraje</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
        </div>

        <div class="col-md-3" align="center">
                <div class="control-group">
                  <label class="control-label" for="inputTipo">Costo Total</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
                <div class="control-group">
                  <label class="control-label" for="inputTipo">Odometro</label>
                  <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='12' required/>
                  </div>
               </div>
        </div>
        <div class="col-md-12" align="center">
                <div class="control-group">
                  <label class="control-label" for="inputTipo">Titulo</label>
                  <div class="controls">
                      <input type='text' class="input-xxlarge" name="nombre" id="nombre" maxlength='18' required/>
                  </div>
               </div>
        </div>

        <H4>Detalle Mantencion</H4>
        </div>
         <div class="col-md-2">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
          <input  type="button" title="Agregar" value="+" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">
        </div>


      </div>
       <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Descripcion</th>
        <th>Costo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>

      <tr>
        <td>1</td>
        <td>bujia</td>
        <td>30000</td>
        <td><a 
         class="btn btn-outline btn-circle dark btn-sm black" onClick="if(confirm('Esta seguro que desea eliminar el registro?')) return true; else return false;">Eliminar</a></td>
      </tr>
    </tbody>
  </table>
 </div>
   Comentario(opcional): <input class="input-xxlarge" type="text" name="" >

   <input type="button" name="" value="guardar" align="right">

    </div>

  </form> <!--**********************************************FIN FORM***************************************-->
  <div class="leyenda">   
   + Agregar Nueva Mantencion - Eliminar Mantencion.
 </div>



 <div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Detalles De Mantencion</h2>
      </div>
      <div class="modal-body">
        <div align="right">
          <h5>Costo Total:</h5>
         
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>

          <form action="<?php echo base_url() ?>transportes/mantenciones/guardar_mantenciones" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Detalle Mantencion</label>
            <div class="controls">
              <input type='text' class="input-xxlarge" name="nombre" id="nombre" maxlength='12' required/>
            </div>
          </div>
  <!--********************************************************************** -->



         <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Repuesto</th>
        <th>Cantidad</th>
        <th>Precio U</th>
        <th>Total</th>
        <th>Proveedor</th>
      </tr>
    </thead>
    <tbody>

      <tr>
        <td>1</td>
        <td>bujia</td>
        <td>2</td>
        <td>15000</td>
        <td>30000</td>
        <td>Integra</td>
      </tr>
    </tbody>
  </table>
 </div>









  <!--********************************************************************** -->
          <div class="modal-footer" style="margin-top: 25px">
            <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</body>