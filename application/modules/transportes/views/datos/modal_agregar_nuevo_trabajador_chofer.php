<form action="<?php echo base_url() ?>transportes/datos/agrega_trabajadores_dia" role="form" id="form2" method='post' name="f2" autocomplete="off">

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<input type="hidden" name="fecha_mostrar" id="fecha_mostrar" value="<?php echo $fecha;?>" />

			<?php
				$i= 0;
				if ($nuevo_trabajador > 0) { ?>			
				<?php foreach ($nuevo_trabajador as $row){
					?>
					<div class="control-group">

						<div class="controls">
							<input type="radio"  
							value="<?php echo $row->id; ?>"; name="trabajador[<?php echo $i; ?>]" id="trabajador[<?php echo $i; ?>]"/>
							<label><?php echo strtoupper($row->ap)?> <?php echo strtoupper($row->am)?> <?php echo strtoupper($row->nombre)?></label>

							<input type="hidden" name="cargo[<?php echo $i; ?>]" id="cargo[<?php echo $i; ?>]" value="<?php echo $row->cargo?>" />
							<input type="hidden" name="colectivo[<?php echo $i; ?>]" id="colectivo[<?php echo $i; ?>]" value="<?php echo $row->colectivo?>" />
                            <input type="hidden" name="empresa[<?php echo $i; ?>]" id="empresa[<?php echo $i; ?>]" value="<?php echo $row->empresa?>" />

						</div>
					</div>


					<?php
					$i++;
					}
				}else{ ?>
					<?php echo "No hay trabajadores para agregar.";?>
				<?php 
					}				
				 ?>					
									
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		<button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
	</div>
</form>