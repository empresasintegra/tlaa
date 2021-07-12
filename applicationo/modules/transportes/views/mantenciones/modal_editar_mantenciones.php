<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src=""></script>
<script>
$(document).ready(function(){
    $("#basic").select2();
    
    $("#multi").select2({
        placeholder: "Select a country"
    });
    
    $("#minimum").select2({
        minimumInputLength: 2
    });
    
});
</script>
<div id="modal" >
    <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar Mantención</h4>
    </div>
    <form action="<?php echo base_url()?>transportes/mantenciones/actualizar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">
      <br>
          <?php 
            foreach ($datos_mantenciones as $datos){ 
          ?>
              <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>
              <div class="control-group"> 
              <div class="col-md-3">
                 <label class="control-label" for="inputTipo">Codigo CCU</label>
              </div>
                  <select required id="codigosccu" name="codigosccu">
                  <option id="basic" value="">Seleccione</option>
                    <?php 
                      foreach ($codigos as $codigo) { 
                    ?>
                        <option value="<?php echo $codigo->idcodigos_ccu ?>" 
                          <?php 
                              if($datos->id_cod_ccu == $codigo->idcodigos_ccu ) echo "selected"?>>
                                <?php echo $codigo->codigos_ccu?>
                        </option>
                    <?php 
                      } 
                    ?>
                  </select>
            </div> 
            <br>  
         <div class="control-group"> 
         <div class="col-md-3">
            <label class="control-label" for="inputTipo">Patente</label>
        </div>
            <div class="controls">
                 <select id="camion" name="camion">
                 <?php 
                    foreach ($camiones as $cam) { 
                 ?>
                    <option value="<?php echo $cam->id ?>" <?php if($datos->id_camion == $cam->id) echo "selected" ?>>
                         <?php echo $cam->patente?>
                    </option>
                 <?php 
                    }
                 ?>
                  </select>
            </div>  
          </div>  
          <br>        
            <?php //  funcion explode para extraer la fecha en variables distintas
                $f = explode("-", $datos->fecha); 
                $ano_v = $f[0];
                $mes_v = $f[1];
                $dia_v = $f[2];
            ?>
            <div class="control-group"> 
            <div class="col-md-3">
             <label class="control-label" for="inputTipo">Fecha Mantención</label>
             </div>
              <div class="controls">
                <select name="dia_v" style="width: 60px;" required>
                  <option value="" >Dia</option>
                  <?php for($i=1;$i<32;$i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($dia_v == $i )? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                  <?php } ?>
                </select>
                <select name="mes_v" style="width: 108px;" required>
                  <option value="">Mes</option>
                  <option value='01' <?php echo ($mes_v == '1')? "selected='selected'" : '' ?> >Enero</option>
                  <option value='02' <?php echo ($mes_v == '2')? "selected='selected'" : '' ?> >Febrero</option>
                  <option value='03' <?php echo ($mes_v == '3')? "selected='selected'" : '' ?> >Marzo</option>
                  <option value='04' <?php echo ($mes_v == '4')? "selected='selected'" : '' ?> >Abril</option>
                  <option value='05' <?php echo ($mes_v == '5')? "selected='selected'" : '' ?> >Mayo</option>
                  <option value='06' <?php echo ($mes_v == '6')? "selected='selected'" : '' ?> >Junio</option>
                  <option value='07' <?php echo ($mes_v == '7')? "selected='selected'" : '' ?> >Julio</option>
                  <option value='08' <?php echo ($mes_v == '8')? "selected='selected'" : '' ?> >Agosto</option>
                  <option value='09' <?php echo ($mes_v == '9')? "selected='selected'" : '' ?> >Septiembre</option>
                  <option value='10' <?php echo ($mes_v == '10')? "selected='selected'" : '' ?> >Octubre</option>
                  <option value='11' <?php echo ($mes_v == '11')? "selected='selected'" : '' ?> >Noviembre</option>
                  <option value='12' <?php echo ($mes_v == '12')? "selected='selected'" : '' ?> >Diciembre</option>
                </select>
                <select name="ano_v" style="width: 70px;" required>
                  <option value="">Año</option>
                     <?php $tope_f = (date('Y') - 5 ); ?>
                     <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                    <option value="<?php echo $i ?>" <?php echo ($ano_v == $i)? "selected='selected'" : '' ?> ><?php echo $i ?>
                    </option>
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
                 <select id="chofer" name="chofer">
                    <?php 
                      foreach ($choferes as $ch) { 
                    ?>
                    <option value="<?php echo $ch->id_persona ?>" <?php if($datos->id_chofer == $ch->id_persona) echo "selected" ?>>
                           <?php echo $ch->apellido_paterno.' '.$ch->apellido_materno.' '.$ch->nombre; ?>
                    </option>
                    <?php 
                      }
                    ?>
                  </select>
            </div>          
        </div>
        <br>  
            <script type="text/javascript">// script para  hacer entrada de datos de solo numeros
              function justNumbers(e)
                    {
                    var keynum = window.event ? window.event.keyCode : e.which;
                    if ((keynum == 8) || (keynum == 46))
                    return true;
                    return /\d/.test(String.fromCharCode(keynum));
                    }
            </script>
            
            <div class="control-group"> 
            <div class="col-md-3">
            <label class="control-label" for="inputTipo">Kilometraje</label>
            </div>
            <div class="controls">
                    <input type='text' style="width: 270px;" onkeypress="return justNumbers(event);" maxlength="7" class="input-mini" name="kilometraje" id="kilometraje" value="<?php echo $datos->kilometraje?>" required/>
            </div>  
            </div> 
            <br>   

          <div class="control-group">
              <div class="col-md-3">
                <label class="control-label" for="inputTipo">Mantención</label>
                </div>
                <div class="controls">
                        <input type='text' class="input-mini" style="width: 270px;" maxlength="100" name="titulo" id="titulo" value="<?php echo $datos->titulo?>" required />
                </div>   
          </div>       
        <?php  
           }  
        ?>
      </div>
      <div class="modal-footer" style="margin-top:72px;">
              <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
              <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
  </form>
</div>
