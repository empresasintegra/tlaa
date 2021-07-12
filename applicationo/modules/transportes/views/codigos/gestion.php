<body>
  <form action="<?php echo base_url() ?>transportes/codigos_ccu/eliminar_codigo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data"> 
    <div class="panel panel-white"><br>
      <div class="row">
        <div class="col-md-10">
          <p align="left">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            En esta secci&oacute;n usted podra:<strong><i>agregar códigos otorgados por CCU</i></strong>
          </p>
        </div>
        <div class="col-md-2">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
          
          <input type="button" title="Agregar" value="+" name ="+" class="btn btn-green" data-toggle="modal" data-target="#modal_add_codigo">
          <?php if ($usuario_subtipo == 110) { ?>
            <input type='submit' value='-' name='eliminar' class='btn btn-green' onclick='return confirmSubmit();'> 
          <?php } ?>         
        </div>
        <div class="col-md-1" align="center"></div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-2" align="center"></div>        
          <div class="col-md-8" align="center">

            <table id="example1">
              <thead>
                <th ><b>Identificador</b></th>                       
                <th ><b>Código CCU</b></th>                        
                <th ><b>Fecha</b></th>
                <?php if ($usuario_subtipo == 110) { ?>
                  <th ><b>Eliminar</b></th>   
                <?php } ?>                    
              </thead>  

              <tbody>
                <?php 
                foreach ($codigo as $c){
                  ?>
                  <tr>

                    <td><?php echo $c->idcodigos_ccu?></td>
                    <td><?php echo $c->codigos_ccu?></td>
                    <td><?php echo $c->fecha_registro?></td>
                    <?php if ($usuario_subtipo == 110) { ?>
                      <td aling="center"><input type='checkbox' name='seleccionar_eliminar[]' value='<?php echo $c->idcodigos_ccu?>'></td>
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
    <div class="leyenda">   
     + Agregar Nuevo Registro - Eliminar Registro.
   </div>
 </form>
</body>
<!-- Modal -->
<div id="modal_add_codigo" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Código</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>transportes/codigos_ccu/agregar_codigo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="control-group">            
            <div class="controls">
              <input type='text' class="input-mini" name="codigo" id="codigo" placeholder="Ingrese Codigo" value=""/>
              <input type="hidden" class="input-mini" name="fecha" id="fecha" value="<?php echo $fecha; ?>"/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-success" >Agregar</button>
        </div>
      </div>
    </form>
  </div>
</div>
