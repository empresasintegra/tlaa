<body>
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-8">
            <p align="left">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              En esta secci&oacute;n usted podra:<strong><i>agregar, editar y eliminar proveedores</i></strong>
            </p>
        </div>
        <div class="col-md-4">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
            <input  type="button" title="Agregar" value="Agregar Proveedor" name ="+" class="btn btn-green" data-toggle="modal" data-target="#ModalAgregar">
             <a id="myButtonControlID" href=""> <img style="width: 30px;" src="<?php echo base_url() ?>extras/img/excel.png"> </a>
        </div>
        <div class="col-md-1" align="center"></div>
      </div>

      <div class="panel-body">
       <div class="row">
        <div class="col-md-2" align="center"></div>
          <div class="col-md-8" align="center">
            <table id="example1">
              <thead>
                <th ><b>Proveedor</b></th> 
                <th ><b>Rut</b></th>  
                <th ><b>Direccion</b></th>  
                <th ><b>Edicion</b></th> 
               
              </thead>  
              <tbody>
              <?php 
                  foreach ($proveedor as $datos){
              ?>
                <tr>
                  <td><?php echo $datos->nombre_proveedor?></td>
                  <td><?php echo $datos->rut?></td>
                  <td><?php echo $datos->direccion?></td>
                  <td>
                     <a data-toggle="modal" href="<?php echo base_url()?>transportes/proveedores/modal_editar/<?php echo $datos->id?>" data-target="#ModalEditar"><i  title="Editar" class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url()?>transportes/proveedores/eliminar/<?php echo $datos->id?>" class="btn btn-outline btn-circle dark btn-sm black" onClick="if(confirm('Esta seguro que desea eliminar el registro?')) return true; else return false;"><i style="color: #FA5858" title="Eliminar Proveedor" class="fa fa-trash-o "></i> </a>




                  </td>
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
</body>
<!--Inicio Div para la exportacion a Excel-->
<div id="divTableDataHolder" style="display:none">
 <table id="example1">
              <thead>
                <th ><b>Proveedor</b></th> 
                <th ><b>Rut</b></th>  
                <th ><b>Direccion</b></th>  
             
              </thead>  
              <tbody>
              <?php 
                  foreach ($proveedor as $datos){
              ?>
                <tr>
                  <td><?php echo $datos->nombre_proveedor?></td>
                  <td><?php echo $datos->rut?></td>
                  <td><?php echo $datos->direccion?></td>
                 
                </tr>
              <?php
                }  
              ?>
              </tbody>
            </table>
</div>
<!--Fin Div para la exportacion a Excel-->

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
        <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Proveedor</h2>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="inputTipo"></label>
          <form action="<?php echo base_url() ?>transportes/proveedores/guardar_proveedores"  id="form2" method='post' name="f2" enctype="multipart/form-data">
<!--          
/*<input type="text" onblur = "this.value = this.value.replace( /^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4')" />-->

  
             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Rut</label>
                    </div>
                    <div class="controls">
                      <input type='text' class="input-mini" name="rut_proveedor" id="rut_proveedor" maxlength='12' placeholder="11.111.111-1" onblur = "this.value = this.value.replace( /^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4')"/>
                    </div>
                    </div>
                    <br>

             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Proveedor</label>
                    </div>
                    <div class="controls">
                       <input type='text' class="input-mini" name="nombre_proveedor" id="nombre_proveedor" maxlength='100' required/>
                    </div>
                    </div>
                    <br>

             <div class="control-group">
                      <div class="col-md-3">
                    <label class="control-label" for="inputTipo">Direccion</label>
                    </div>
                    <div class="controls">
                      <input type='text' class="input-mini" name="direccion" id="direccion" maxlength='12' required/>
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