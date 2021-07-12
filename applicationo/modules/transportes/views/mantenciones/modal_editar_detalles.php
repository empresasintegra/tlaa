<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="select2.js"></script>
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
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos</h4>
  </div>

    <form action="<?php echo base_url()?>transportes/mantenciones/actualizar" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div id="modal_content">
        <div class="modal-header">
             <p><i>Detalle de Mantencion</i></p>
        </div>
          <?php foreach ($detalles as $datos){ ?>
            <input type='hidden' name="id" id="id"  value="<?php echo $datos->id ?>"/>

          <div class="col-md-6">
            <label class="control-label" for="inputTipo">Detalle mantencion:</label>
                <div class="controls">
                    <select id="codigosccu" name="codigosccu">
                       <option name="basic" id="basic" value="<?php echo $datos->descripcion ?>"><?php echo $detalles->descripcion?></option>
                    </select>
                </div>          
          </div>

          <div class="col-md-6">
              <label class="control-label" for="inputTipo">Fechaxxxxxx</label>
                <div class="controls">
                  <input type='text' class="input-mini" name="fecha" id="fecha" value="<?php echo $datos->fecha?>"/>
                </div>     
          </div>

          <div class="col-md-6">
            <label class="control-label" for="inputTipo">Patente </label>
                <div class="controls">
                      <select id="camion" name="camion">
                        <?php foreach ($camiones as $cam) { ?>
                          <option value="<?php echo $cam->id ?>" <?php if($datos->id_camion == $cam->id) echo "selected" ?> ><?php echo $cam->patente?></option>
                        <?php } ?>
                    </select>
                </div>          
          </div>

          <div class="col-md-6">
            <label class="control-label" for="inputTipo">chofer</label>
                <div class="controls">
                      <select id="chofer" name="chofer">
                        <?php foreach ($choferes as $ch) { ?>
                          <option value="<?php echo $ch->id_persona ?>" <?php if($datos->id_chofer == $ch->id_persona) echo "selected" ?> ><?php echo $ch->apellido_paterno.' '.$ch->apellido_materno.' '.$ch->nombre; ?></option>
                        <?php } ?>
                    </select>
                </div>          
          </div>

          <div class="col-md-6">
            <label class="control-label" for="inputTipo">kilometraje</label>
                <div class="controls">
                      <input type='text' class="input-mini" name="kilometraje" id="kilometraje" value="<?php echo $datos->id_cod_ccu?>"/>
                </div>          
          </div>

          <div class="col-md-6">
            <label class="control-label" for="inputTipo">titulo</label>
                <div class="controls">
                      <input type='text' class="input-mini" name="titulo" id="titulo" value="<?php echo $datos->titulo?>"/>
                </div>          
          </div>
      </div>
   <?php } ?><!-- Fin foreach [$detalles]-->
    <div class="modal-footer" style="margin-top:62px;">
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
    </form>
  </div>
