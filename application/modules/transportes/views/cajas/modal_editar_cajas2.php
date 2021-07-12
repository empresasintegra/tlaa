<div id="modal">
 <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actualizaci&oacute;n Datos</h4>
  </div>
  <div id="modal_content" >
    
    <form action="<?php echo base_url()?>transportes/cajas/actualizar2" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
        <?php foreach ($estandar_bono_peoneta as $datos){
        ?>

         
        <input type='hidden' class="input-mini" name="bono_en_pesos" id="bono_en_pesos" value="<?php echo $datos->id?>"/>
        
        <input type='hidden' class="input-mini" name="id_instrumento_colectivo" id="id_instrumento_colectivo" value="<?php echo $datos->id_instrumento_colectivo?>"/>

        <div class="modal-header" >
            
            <p> Para modificar un valor, complete el campo solicitado.**</p>
            
          </div>

          <br><br>

       <div class="control-group" ><div></div>
       
            <label  style="font-size:15px" class="control-label" for="inputTipo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Caja:</label>
           
            <input size="16" type='text' class="input-mini" name="bono_en_pesos" id="bono_en_pesos" value="<?php echo $datos->bono_en_pesos?>" required/></td>
            
          </div>

          <input type='hidden' class="input-mini" name="id" id="id" value="<?php echo $datos->id?>"/>

      
          <?php 
        }
          ?>
    <div class="modal-footer aling-center " style="margin-top: 32px;">
            <button type="submit" name="actualizar" class="btn btn-primary btn-sm  ">&nbsp;Actualizar&nbsp;&nbsp;</button>
        <button type="button" name="cancelar" class="btn btn-primary btn-sm" data-dismiss="modal">&nbsp;Cancelar&nbsp;&nbsp;</button>
      </div>
    </form>
  </div>