<body>
  <form action="<?php echo base_url() ?>transportes/rep/verificar" role="form" id="form" method='post' autocomplete="off">
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podra:<strong><i>agregar, editar y eliminar Repuestos.</i></strong>
          </p>
        </div>
        <div class="col-md-2">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
          <input  type="button" title="Agregar" value="+" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">
          <a href="<?php echo base_url()?>transportes/repuestos/exportar?>"> <img style="width: 30px;" src="<?php echo base_url() ?>extras/img/excel.png"> </a>
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-2" align="center"></div>
          <div class="col-md-8" align="center">
            <table id="example1">
              <thead>
                <th ><b>Repuesto</b></th> 
                <th ><b>Precio</b></th>   
                <th ><b>Modificar</b></th> 
              </thead>  
              <tbody>
              <?php 
                  foreach ($repuestos as $datos){
              ?>
              <tr>
                <td><?php echo $datos->nombre_repuesto?></td>
                <td><?php echo $datos->precio?></td>
                <td><a data-toggle="modal" href="<?php echo base_url()?>transportes/repuestos/modal_editar/<?php echo $datos->id?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a></td>
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
</body>
<!-- Modal Editar Trabajador-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
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
        <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Repuesto</h2>
      </div>
      <div class="modal-body">

          <div class="control-group">
              <label class="control-label" for="inputTipo"></label>
              <form action="<?php echo base_url() ?>transportes/repuestos/guardar_repuestos" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
      
<br>
             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Nombre Repuesto</label>
                    </div>
                    <div class="controls">
                      <input type='text' class="input-mini" name="nombre" id="nombre" maxlength='50' required/>
                    </div>
                    </div>
                    <br>

             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Precio Repuesto</label>
                    </div>
                    <div class="controls">
                      <input type='text' class="input-mini" name="precio_repuesto" id="precio_repuesto" maxlength='12' placeholder="$" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required/>
                    </div>
                    </div>
                    <br>
   
    
          
          <div class="modal-footer" style="margin-top: 25px">
            <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>