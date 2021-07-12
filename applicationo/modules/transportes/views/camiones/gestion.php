<body>
  <form action="<?php echo base_url() ?>transportes/camion/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podra:<strong><i>agregar, editar y eliminar Camiones.</i></strong>
          </p>
        </div>
        <div class="col-md-2">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" title="Agregar" value="+" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">
              
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">

          <div class="col-md-1" align="center"></div>
          <div class="col-md-10" align="center">


            <table id="example1">
              <thead>           

                <th ><b>Codigo CCU</b><br></th>
                <th ><b>Patente</b><br></th>
                <th ><b>Marca</b></th>
                <th ><b>Año</b></th>
                <th ><b>Capacidad de Carga (KG)</b></th>                
                <th ><b>Pallets</b></th>
                <th ><b>Modificar</b></th>
                <?php if ($usuario_subtipo == 110) { ?>
                  <th ><b>Eliminar</b><br></th>
                <?php } ?>
                

              </thead>
              <tbody>

                <?php 
                foreach ($camion as $datos){
                  ?>
                  <tr>

                    <td ><?php echo $datos->codigo?></td>
                    <td ><?php echo $datos->patente?></td>
                    <td ><?php echo $datos->marca?></td>
                    <td ><?php echo $datos->ano?></td>                    
                    <td ><?php echo $datos->capacidad?></td>                    
                    <td ><?php echo $datos->pallets?></td>
                    <td ><a data-toggle="modal" href="<?php echo base_url()?>transportes/camion/modal_editar/<?php echo $datos->id_camion?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a></td>
                    <?php if ($usuario_subtipo == 110) { ?>
                    <td  align="center">
                      <a href="<?php echo base_url() ?>transportes/camion/eliminar/<?php echo $datos->id_camion?>/<?php echo $datos->codigo_ccuc?>" title="Eliminar Camión" class="btn btn-xs btn-danger eliminar"><span class="glyphicon glyphicon-trash"></span></a></td>
                    <?php } ?>  
                  </tr>
                  <?php
                }  
                ?>

              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </form>
  <div class="leyenda">
    + Agregar Nuevo Registro - Eliminar Registro.
  </div>
</body>
<!-- Modal Editar Trabajador-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Nuevo Registro</h4> <h5><i>Todos los campos son obligatorios**</i></h5>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->	
<!-- Modal -->
<div id="ModalAgregar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Nuevo Registro</h4> <h5><i>Todos los campos son obligatorios**</i></h5>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>transportes/camion/guardar_camion" role="form" id="form2" method='post' name="f2" class="form-horizontal" enctype="multipart/form-data">
          <legend><i>Ingrese Información</i></legend>
          <div class="form-group">
            <label class="col-md-4 control-label" for="id_select_ruta">Código</label>
            <div class="col-md-4">
             <select id="id_select_codigo" name="id_select_codigo" class="form-control" required>
              <option value="">Seleccione Código</option>
              <?php foreach ($codigos as $c) { 
                echo '<option value="',$c->id,'">',$c->code,'</option>';
              } ?>
            </select>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="patente">Patente</label>  
          <div class="col-md-4">
            <input id="patente_data" name="patente_data" type="text" placeholder="Ingrese Patente" class="form-control input-md">

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
            <input id="ano" name="ano" type="text" placeholder="Ingrese Año" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="capacidad">Capacidad</label>  
          <div class="col-md-4">
            <input id="capacidad" name="capacidad" type="text" placeholder="Ingrese Capacidad" class="form-control input-md">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="pallets">Pallets</label>  
          <div class="col-md-4">
            <input id="pallets" name="pallets" type="text" placeholder="Ingrese Pallets" class="form-control input-md">

          </div>
        </div>

        




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>

</div>
</div>
