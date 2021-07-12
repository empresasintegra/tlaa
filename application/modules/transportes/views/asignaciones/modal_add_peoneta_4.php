<form action="<?php echo base_url() ?>transportes/asignacion/add_peoneta_4" role="form" id="form2" method='post' name="f2" autocomplete="off">

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<input type="hidden" name="id_camion" id="id_camion" value="<?php echo $codigo;?>" />

			<?php
			$x= 0;
			if ($peoneta != FALSE){
				foreach ($peoneta as $row){
					$x +=1;
					?>

					<div class="control-group">

						<div class="controls">
							<input type="radio"  
							value="<?php echo $row->id; ?>"; name="peoneta[]" id="id_peoneta[]"/> 
							<label><?php echo strtoupper($row->nombre)?> <?php echo strtoupper($row->ap)?> <?php echo strtoupper($row->am)?></label>

						</div>
					</div>   			

					<?php
				}
			}else{
				?>
				<p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
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